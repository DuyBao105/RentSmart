import os
import sys
sys.path.insert(0, os.path.dirname(os.path.abspath(__file__)))
import torch
import torch.nn as nn
import torch.optim as optim
import random
import numpy as np
from collections import deque

from db import load_posts, load_all_utilities, load_favorites
from dqn_model import DuelingDQN
from utils import RoomEnv

print("=== BẮT ĐẦU HUẤN LUYỆN DUELING DQN TỐI ƯU PHÂN BỔ PHÒNG TRỌ ===")

# 1. LOAD DỮ LIỆU TỪ DATABASE
df = load_posts()
posts = df.to_dict(orient="records")
utilities = load_all_utilities()
favorites = []

rooms = []
for p in posts:
    room = {
        "id": p["phong_id"],
        "bai_dang_id": p["bai_dang_id"],
        "gia": float(p["gia"]),
        "dien_tich": float(p["dien_tich"]),
        "suc_chua": int(p.get("suc_chua") or 2),
        "days_empty": int(p.get("days_empty") or 30),
        "trang_thai": str(p.get("trang_thai") or "trong"),
        "dia_chi": str(p.get("dia_chi_daytro") or "")
    }
    rooms.append(room)

env = RoomEnv(rooms, utilities, favorites)
num_rooms = len(rooms)
feature_dim = env.feature_dim
state_size = num_rooms * feature_dim
action_size = num_rooms

print(f"Tổng số phòng ứng viên: {num_rooms}")
print(f"Số chiều đặc trưng mỗi phòng: {feature_dim}")
print(f"Kích thước vector trạng thái: {state_size}")

# 2. KHỞI TẠO DUELING DQN
policy_net = DuelingDQN(state_size, action_size, feature_dim=feature_dim)
target_net = DuelingDQN(state_size, action_size, feature_dim=feature_dim)
target_net.load_state_dict(policy_net.state_dict())
target_net.eval()

optimizer = optim.Adam(policy_net.parameters(), lr=0.001)
criterion = nn.SmoothL1Loss()

memory = deque(maxlen=10000)
BATCH_SIZE = 64
GAMMA = 0.95
EPS_START = 1.0
EPS_END = 0.05
EPS_DECAY = 350
TARGET_UPDATE = 20

# BỘ SINH HỒ SƠ KHÁCH THUÊ ĐA DẠNG (DIVERSE TENANT PROFILES)
def sample_random_tenant():
    profile = random.choice(["student_budget", "student_mid", "worker_standard", "roommates"])
    if profile == "student_budget":
        return {
            "budget": random.randint(1800000, 2600000),
            "area": random.randint(15, 22),
            "people": 1,
            "utilities": random.sample([1, 2, 3], k=random.randint(1, 2)),
            "location": random.choice(["thủ đức", "quận 10", "bình thạnh", ""])
        }
    elif profile == "student_mid":
        return {
            "budget": random.randint(2600000, 3600000),
            "area": random.randint(20, 28),
            "people": random.choice([1, 2]),
            "utilities": random.sample([1, 2, 3, 4], k=random.randint(2, 3)),
            "location": random.choice(["bình thạnh", "quận 10", "quận 5", "tân bình", ""])
        }
    elif profile == "worker_standard":
        return {
            "budget": random.randint(3500000, 5000000),
            "area": random.randint(25, 35),
            "people": random.choice([1, 2]),
            "utilities": random.sample([1, 2, 3, 4, 5], k=random.randint(3, 4)),
            "location": random.choice(["quận 1", "quận 3", "phú nhuận", "bình thạnh", ""])
        }
    else:  # roommates
        return {
            "budget": random.randint(3500000, 4800000),
            "area": random.randint(28, 40),
            "people": random.choice([2, 3]),
            "utilities": random.sample([1, 2, 3], k=2),
            "location": random.choice(["thủ đức", "gò vấp", "quận 10", ""])
        }

steps_done = 0

def select_action(state_tensor, epsilon):
    if random.random() < epsilon:
        return random.randint(0, action_size - 1)
    else:
        with torch.no_grad():
            q_values = policy_net(state_tensor)
            return int(torch.argmax(q_values).item())

def train_step():
    if len(memory) < BATCH_SIZE:
        return 0.0

    batch = random.sample(memory, BATCH_SIZE)
    states, actions, rewards, next_states, dones = zip(*batch)

    states_t = torch.tensor(np.array(states), dtype=torch.float32)
    actions_t = torch.tensor(actions, dtype=torch.long).unsqueeze(1)
    rewards_t = torch.tensor(rewards, dtype=torch.float32).unsqueeze(1)
    next_states_t = torch.tensor(np.array(next_states), dtype=torch.float32)
    dones_t = torch.tensor(dones, dtype=torch.float32).unsqueeze(1)

    # Q(s, a) hiện tại
    q_eval = policy_net(states_t).gather(1, actions_t)

    # Double DQN: chọn action tốt nhất bằng policy_net, đánh giá Q bằng target_net
    with torch.no_grad():
        best_actions = policy_net(next_states_t).argmax(dim=1, keepdim=True)
        q_next = target_net(next_states_t).gather(1, best_actions)
        q_target = rewards_t + (1 - dones_t) * GAMMA * q_next

    loss = criterion(q_eval, q_target)
    optimizer.zero_grad()
    loss.backward()
    nn.utils.clip_grad_norm_(policy_net.parameters(), max_norm=1.0)
    optimizer.step()

    return float(loss.item())

# 3. VÒNG LẶP HUẤN LUYỆN
EPISODES = 400
print(f"Bắt đầu huấn luyện {EPISODES} episodes...")

recent_rewards = deque(maxlen=50)

for ep in range(1, EPISODES + 1):
    tenant = sample_random_tenant()
    state_matrix = env.reset(tenant)
    state_input = state_matrix.reshape(1, -1)

    epsilon = EPS_END + (EPS_START - EPS_END) * np.exp(-1.0 * ep / EPS_DECAY)

    action = select_action(torch.tensor(state_input, dtype=torch.float32), epsilon)
    next_state_matrix, reward, done, info = env.step(action)
    next_state_input = next_state_matrix.reshape(1, -1)

    memory.append((state_input[0], action, reward, next_state_input[0], done))
    loss = train_step()

    recent_rewards.append(reward)

    if ep % TARGET_UPDATE == 0:
        target_net.load_state_dict(policy_net.state_dict())

    if ep % 50 == 0 or ep == EPISODES:
        avg_r = np.mean(recent_rewards)
        print(f"Episode {ep:3d}/{EPISODES} | Epsilon: {epsilon:.3f} | Avg Reward (50 ep): {avg_r:.2f} | Loss: {loss:.4f}")

# 4. LƯU MODEL
torch.save(policy_net.state_dict(), "dqn_room.pt")
print("🔥 ĐÃ HUẤN LUYỆN XONG VÀ LƯU MÔ HÌNH: dqn_room.pt")
