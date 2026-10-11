import torch
import torch.nn as nn
import torch.nn.functional as F


class DuelingDQN(nn.Module):
    """
    Dueling Deep Q-Network for Optimal Room Allocation (RL Optimization).
    
    Tách biệt Value stream V(s) (giá trị tổng thể của trạng thái thị trường)
    và Advantage stream A(s, a) (lợi thế cụ thể khi phân bổ từng phòng a).
    
    Công thức Q-value kết hợp:
        Q(s, a) = V(s) + [ A(s, a) - (1 / |A|) * sum_{a'} A(s, a') ]
    """
    def __init__(self, state_size, action_size, feature_dim=8):
        super(DuelingDQN, self).__init__()

        self.action_size = action_size
        self.feature_dim = feature_dim

        # 1. Shared Feature Embedding cho từng phòng (feature_dim -> 64)
        self.room_embed1 = nn.Linear(feature_dim, 64)
        self.ln1 = nn.LayerNorm(64)
        self.room_embed2 = nn.Linear(64, 64)
        self.ln2 = nn.LayerNorm(64)

        # 2. Attention mechanism để học ngữ cảnh tổng thể các phòng
        self.attn = nn.Linear(64, 1)

        # 3. Value stream V(s): Đánh giá giá trị kỳ vọng của trạng thái thị trường
        self.val_fc1 = nn.Linear(64, 64)
        self.val_fc2 = nn.Linear(64, 1)

        # 4. Advantage stream A(s, a): Đánh giá lợi thế khi phân bổ phòng cụ thể
        self.adv_fc1 = nn.Linear(64, 64)
        self.adv_fc2 = nn.Linear(64, 1)

    def forward(self, x):
        """
        x shape: (batch, state_size) hoặc (batch, num_rooms, feature_dim)
        Hỗ trợ số lượng phòng ứng viên K động (Dynamic Candidate Pool).
        """
        batch = x.size(0)

        if x.dim() == 2:
            num_rooms = x.size(1) // self.feature_dim
            x = x.view(batch, num_rooms, self.feature_dim)
        else:
            num_rooms = x.size(1)

        # Feature embedding từng phòng (batch, num_rooms, 64)
        h = F.relu(self.ln1(self.room_embed1(x)))
        h = F.relu(self.ln2(self.room_embed2(h)))

        # Attention weights giữa các phòng hợp lệ
        attn_scores = torch.softmax(self.attn(h), dim=1)  # (batch, num_rooms, 1)
        global_context = torch.sum(h * attn_scores, dim=1)  # (batch, 64)

        # Value stream V(s): Đánh giá giá trị kỳ vọng của tổng thể thị trường ứng viên
        val = F.relu(self.val_fc1(global_context))
        val = self.val_fc2(val)  # (batch, 1)

        # Vectorized Advantage stream A(s, a) tính đồng thời cho toàn bộ phòng
        adv_hidden = F.relu(self.adv_fc1(h))  # (batch, num_rooms, 64)
        adv = self.adv_fc2(adv_hidden).squeeze(-1)  # (batch, num_rooms)

        # Dueling aggregation: Q(s, a) = V(s) + [ A(s, a) - mean(A) ]
        if num_rooms > 1:
            q_values = val + (adv - adv.mean(dim=1, keepdim=True))
        else:
            q_values = val + adv

        return q_values


# Giữ alias DQN để tương thích ngược với code cũ
DQN = DuelingDQN
