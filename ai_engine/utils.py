import numpy as np
from datetime import datetime


def filter_mandatory_constraints(rooms, user, utilities=None):
    """
    RÀNG BUỘC CỨNG (MANDATORY HARD CONSTRAINTS):
    Áp dụng cổng kiểm tra nghiêm ngặt TRƯỚC KHI xếp hạng.
    Một phòng CHỈ ĐƯỢC COI LÀ HỢP LỆ khi đáp ứng đồng thời:
      1. Phòng thực sự đang trống (trang_thai == 'trong')
      2. Sức chứa phòng đủ cho số lượng người ở (suc_chua >= people)
      3. Nếu strict_budget = True: Giá phòng KHÔNG ĐƯỢC VƯỢT QUÁ ngân sách tối đa
         Nếu strict_budget = False: Cho phép linh hoạt tối đa +15% ngân sách
      4. Nếu strict_location = True: Địa chỉ phòng phải chứa từ khóa khu vực mong muốn
    
    Tuyệt đối không để điểm Q-value cao ghi đè lên các ràng buộc bắt buộc này.
    """
    utilities = utilities or {}
    budget = float(user.get("budget") or user.get("max_price") or 3_500_000)
    people = int(user.get("people") or user.get("so_nguoi") or 1)
    strict_budget = bool(user.get("strict_budget", True))
    strict_location = bool(user.get("strict_location", False))
    user_loc = str(user.get("location") or user.get("dia_chi") or "").lower().strip()

    valid_candidates = []
    rejection_reasons = {
        "not_available": 0,
        "capacity_insufficient": 0,
        "over_budget": 0,
        "location_mismatch": 0
    }

    max_allowed_budget = budget if strict_budget else (budget * 1.15)

    for r in rooms:
        # 1. Ràng buộc phòng trống
        trang_thai = str(r.get("trang_thai") or "").lower().strip()
        if trang_thai != "trong":
            rejection_reasons["not_available"] += 1
            continue

        # 2. Ràng buộc sức chứa
        suc_chua = int(r.get("suc_chua") or 2)
        if suc_chua < people:
            rejection_reasons["capacity_insufficient"] += 1
            continue

        # 3. Ràng buộc ngân sách
        gia = float(r.get("gia") or r.get("gia_thue") or r.get("gia_phong") or 0)
        if gia > max_allowed_budget:
            rejection_reasons["over_budget"] += 1
            continue

        # 4. Ràng buộc vị trí nghiêm ngặt (nếu người dùng bật)
        if strict_location and user_loc:
            dia_chi = str(r.get("dia_chi") or r.get("dia_chi_daytro") or "").lower()
            if user_loc not in dia_chi:
                rejection_reasons["location_mismatch"] += 1
                continue

        valid_candidates.append(r)

    audit_summary = {
        "total_evaluated": len(rooms),
        "eligible_count": len(valid_candidates),
        "rejection_breakdown": rejection_reasons,
        "constraints_applied": {
            "strict_budget_enforced": strict_budget,
            "max_budget_vnd": budget,
            "min_capacity_people": people,
            "strict_location_enforced": strict_location
        }
    }

    return valid_candidates, audit_summary


class RoomEnv:
    """
    Môi trường Reinforcement Learning mô phỏng bài toán phân bổ phòng trọ:
    - State: Ma trận đặc trưng kết hợp giữa các phòng và hồ sơ khách thuê.
    - Action: Lựa chọn phòng tối ưu trong số N phòng hợp lệ.
    - Reward: Hàm phần thưởng đa mục tiêu kết hợp sự hài lòng khách thuê (R_sat)
              và tối ưu hóa tỷ lệ lấp đầy cho chủ trọ (R_rev).
    """
    def __init__(self, rooms, utilities=None, favorites=None):
        self.rooms = rooms
        self.utilities = utilities or {}
        self.favorites = favorites or []
        self.feature_dim = 8  # 8 đặc trưng chuẩn hóa

    def reset(self, user):
        """
        Khởi tạo môi trường với hồ sơ khách thuê mới.
        """
        self.user = {
            "budget": float(user.get("budget") or user.get("max_price") or 3_500_000),
            "strict_budget": bool(user.get("strict_budget", True)),
            "area": float(user.get("area") or 22.0),
            "people": int(user.get("people") or user.get("so_nguoi") or 1),
            "utilities": user.get("utilities") or user.get("dich_vu_id") or [],
            "location": str(user.get("location") or user.get("dia_chi") or "").lower().strip()
        }
        return self.build_state()

    def build_state(self, candidate_rooms=None):
        """
        Xây dựng ma trận đặc trưng 8 chiều cho tập phòng ứng viên (candidate_rooms):
        [0]: Tỷ lệ giá / ngân sách (price_ratio <= 1.0 là trong ngân sách)
        [1]: Độ lệch diện tích tương đối (area_diff)
        [2]: Tỷ lệ tiện ích mong muốn được đáp ứng (util_match: 0..1)
        [3]: Trạng thái yêu thích của người dùng (is_fav: 0 hoặc 1)
        [4]: Thời gian phòng trống chuẩn hóa (days_empty_norm: 0..1)
        [5]: Ràng buộc phòng trống (is_available: 1.0)
        [6]: Độ khớp sức chứa chuẩn hóa (capacity_fit: 0..1)
        [7]: Độ khớp vị trí (location_match: 0..1)
        """
        target_rooms = candidate_rooms if candidate_rooms is not None else self.rooms
        feature_list = []

        user_budget = max(self.user["budget"], 1_000_000)
        user_area = max(self.user["area"], 10.0)
        user_utils = set(self.user["utilities"])
        user_loc = self.user["location"]
        people = max(self.user["people"], 1)

        for room in target_rooms:
            gia = float(room.get("gia") or room.get("gia_thue") or room.get("gia_phong") or 3_000_000)
            dien_tich = float(room.get("dien_tich") or 20.0)
            suc_chua = int(room.get("suc_chua") or 2)
            days_empty = float(room.get("days_empty") or 30.0)
            trang_thai = str(room.get("trang_thai") or "trong")
            dia_chi = str(room.get("dia_chi") or room.get("dia_chi_daytro") or "").lower()

            # 1. Price ratio
            price_ratio = min(gia / user_budget, 2.0)

            # 2. Area relative deviation
            area_diff = min(abs(dien_tich - user_area) / user_area, 1.5)

            # 3. Utility match score
            room_id = room.get("id") or room.get("phong_id")
            room_utils = set(self.utilities.get(room_id, []))
            if user_utils:
                match_count = len(room_utils & user_utils)
                util_match = match_count / max(len(user_utils), 1)
            else:
                util_match = 1.0

            # 4. Favorite status
            is_fav = 1.0 if room_id in self.favorites else 0.0

            # 5. Normalized days empty (tối đa 90 ngày)
            days_empty_norm = min(days_empty / 90.0, 1.0)

            # 6. Availability flag
            is_available = 1.0 if trang_thai == "trong" else 0.0

            # 7. Capacity fit
            capacity_fit = 1.0 if suc_chua >= people else (suc_chua / people)

            # 8. Location match
            if not user_loc:
                location_match = 0.8
            else:
                location_match = 1.0 if user_loc in dia_chi else 0.2

            feature_list.append([
                float(price_ratio),
                float(area_diff),
                float(util_match),
                float(is_fav),
                float(days_empty_norm),
                float(is_available),
                float(capacity_fit),
                float(location_match)
            ])

        return np.array(feature_list, dtype=np.float32)

    def step(self, action, candidate_rooms=None):
        """
        Thực thi hành động chọn phòng ứng viên `action` và trả về phần thưởng đa mục tiêu.
        """
        target_rooms = candidate_rooms if candidate_rooms is not None else self.rooms
        room = target_rooms[action]

        gia = float(room.get("gia") or room.get("gia_thue") or room.get("gia_phong") or 3_000_000)
        dien_tich = float(room.get("dien_tich") or 20.0)
        suc_chua = int(room.get("suc_chua") or 2)
        days_empty = float(room.get("days_empty") or 30.0)
        trang_thai = str(room.get("trang_thai") or "trong")
        dia_chi = str(room.get("dia_chi") or room.get("dia_chi_daytro") or "").lower()

        # R_sat: Sự hài lòng của khách thuê
        r_sat = 0.0
        user_budget = self.user["budget"]
        if gia <= user_budget:
            savings = (user_budget - gia) / user_budget
            r_sat += 4.0 + min(savings * 2.0, 2.0)
        else:
            over = (gia - user_budget) / user_budget
            r_sat -= min(over * 8.0, 6.0)

        area_diff_ratio = abs(dien_tich - self.user["area"]) / max(self.user["area"], 1.0)
        if area_diff_ratio <= 0.15:
            r_sat += 3.0
        elif area_diff_ratio <= 0.30:
            r_sat += 1.5
        else:
            r_sat -= 1.0

        user_utils = set(self.user["utilities"])
        room_id = room.get("id") or room.get("phong_id")
        room_utils = set(self.utilities.get(room_id, []))
        if user_utils:
            util_match = len(room_utils & user_utils) / len(user_utils)
            r_sat += util_match * 4.0
        else:
            r_sat += 2.0

        user_loc = self.user["location"]
        if user_loc and user_loc in dia_chi:
            r_sat += 3.0

        if room_id in self.favorites:
            r_sat += 2.5

        # R_rev: Giảm thời gian trống phòng
        days_empty_norm = min(days_empty / 90.0, 1.0)
        r_rev = (days_empty_norm * 4.0) + min(gia / 4_000_000, 1.5)

        # Phạt vi phạm ràng buộc
        penalty = 0.0
        if trang_thai != "trong":
            penalty += 50.0
        if suc_chua < self.user["people"]:
            penalty += 30.0

        total_reward = (0.60 * r_sat) + (0.30 * r_rev) - penalty
        next_state = self.build_state(target_rooms)
        done = True

        info = {
            "r_sat": r_sat,
            "r_rev": r_rev,
            "penalty": penalty,
            "is_valid": (penalty == 0.0)
        }

        return next_state, float(total_reward), done, info


# =====================================================================
# CÁC HÀM TÍNH ĐIỂM MINH BẠCH & GIẢI THÍCH (EXPLAINABLE AI METRICS)
# =====================================================================
def compute_satisfaction_score(room, user, utilities=None):
    """
    Tính chỉ số mức độ phù hợp (Match Percentage / Satisfaction Score):
    Công thức trọng số minh bạch dựa trên dữ liệu thực:
      - Giá thuê (35%): 100% nếu trong ngân sách, trừ dần theo tỷ lệ vượt
      - Diện tích (25%): 100% trừ theo độ lệch diện tích so với mong muốn
      - Tiện ích (25%): Tỷ lệ tiện ích yêu cầu mà phòng đáp ứng
      - Vị trí (15%): Khớp đúng khu vực mong muốn
    """
    utilities = utilities or {}
    budget = float(user.get("budget") or user.get("max_price") or 3_500_000)
    area = float(user.get("area") or 22.0)
    user_utils = set(user.get("utilities") or user.get("dich_vu_id") or [])
    user_loc = str(user.get("location") or user.get("dia_chi") or "").lower().strip()

    gia = float(room.get("gia") or room.get("gia_thue") or room.get("gia_phong") or 3_000_000)
    dien_tich = float(room.get("dien_tich") or 20.0)
    dia_chi = str(room.get("dia_chi") or room.get("dia_chi_daytro") or "").lower()

    # 1. Điểm giá (35%)
    if gia <= budget:
        savings = (budget - gia) / max(budget, 1.0)
        price_score = min(100.0, 95.0 + savings * 10.0)
    else:
        over = (gia - budget) / max(budget, 1.0)
        price_score = max(0.0, 90.0 - over * 180.0)

    # 2. Điểm diện tích (25%)
    diff_area = abs(dien_tich - area) / max(area, 1.0)
    area_score = max(0.0, 100.0 - (diff_area * 100.0))

    # 3. Điểm tiện ích (25%)
    room_id = room.get("id") or room.get("phong_id")
    room_utils = set(utilities.get(room_id, []))
    if user_utils:
        matched_utils = room_utils & user_utils
        util_score = (len(matched_utils) / len(user_utils)) * 100.0
    else:
        util_score = 92.0

    # 4. Điểm vị trí (15%)
    if user_loc:
        if user_loc in dia_chi:
            loc_score = 100.0
        elif "hồ chí minh" in dia_chi or "tp.hcm" in dia_chi:
            loc_score = 75.0
        else:
            loc_score = 45.0
    else:
        loc_score = 85.0

    total_score = (0.35 * price_score) + (0.25 * area_score) + (0.25 * util_score) + (0.15 * loc_score)
    return round(float(min(max(total_score, 15.0), 99.5)), 1)


def generate_ai_explanations(room, user, utilities=None):
    """
    Sinh cấu trúc giải thích minh bạch dựa trên sự thật (Ground Truth Explanations):
    Phân tách rõ ràng:
      - factual_matches: Các tiêu chí bắt buộc đã thỏa mãn thực tế
      - preference_matches: Các sở thích mềm khớp với nhu cầu
      - trade_offs: Các lưu ý hoặc chênh lệch khách quan
    """
    utilities = utilities or {}
    budget = float(user.get("budget") or user.get("max_price") or 3_500_000)
    gia = float(room.get("gia") or room.get("gia_thue") or room.get("gia_phong") or 3_000_000)
    target_area = float(user.get("area") or 22.0)
    room_area = float(room.get("dien_tich") or 20.0)
    people = int(user.get("people") or user.get("so_nguoi") or 1)
    suc_chua = int(room.get("suc_chua") or 2)
    user_loc = str(user.get("location") or user.get("dia_chi") or "").lower().strip()
    dia_chi = str(room.get("dia_chi") or room.get("dia_chi_daytro") or "")

    factual_matches = []
    preference_matches = []
    trade_offs = []

    # Fact 1: Trạng thái phòng trống
    factual_matches.append("Phòng đang trống, có thể nhận phòng vào ở ngay")

    # Fact 2: Sức chứa
    factual_matches.append(f"Sức chứa {suc_chua} người (đáp ứng đủ nhu cầu {people} người ở)")

    # Fact 3: Ngân sách
    if gia <= budget:
        savings = budget - gia
        if savings > 100_000:
            factual_matches.append(f"Giá thuê {int(gia):,}₫ nằm trong ngân sách (tiết kiệm {int(savings):,}₫/tháng)")
        else:
            factual_matches.append(f"Giá thuê {int(gia):,}₫ hoàn toàn nằm trong ngân sách dự kiến")
    else:
        over = gia - budget
        trade_offs.append(f"Giá thuê vượt nhẹ ngân sách {int(over):,}₫/tháng")

    # Preference 1: Tiện ích
    user_utils = set(user.get("utilities") or user.get("dich_vu_id") or [])
    room_id = room.get("id") or room.get("phong_id")
    room_utils = set(utilities.get(room_id, []))
    if user_utils:
        matched = room_utils & user_utils
        if len(matched) == len(user_utils):
            preference_matches.append(f"Đáp ứng trọn vẹn {len(matched)}/{len(user_utils)} tiện ích bạn yêu cầu")
        elif len(matched) > 0:
            preference_matches.append(f"Đáp ứng {len(matched)}/{len(user_utils)} tiện ích ưu tiên đã chọn")
            missing = len(user_utils) - len(matched)
            trade_offs.append(f"Còn thiếu {missing} tiện ích so với danh sách ưu tiên")
        else:
            trade_offs.append("Chưa có đủ các tiện ích phụ trợ bạn đã chọn")

    # Preference 2: Vị trí
    if user_loc:
        if user_loc in dia_chi.lower():
            preference_matches.append(f"Vị trí chuẩn xác tại khu vực {user.get('location') or user.get('dia_chi')}")
        else:
            preference_matches.append("Vị trí tại TP. Hồ Chí Minh kết nối giao thông thuận tiện")

    # Preference 3: Diện tích
    diff_area = abs(room_area - target_area)
    if diff_area <= 2.0:
        preference_matches.append(f"Diện tích {room_area}m² rất gần với mong muốn ({target_area}m²)")
    elif room_area > target_area:
        preference_matches.append(f"Diện tích rộng rãi {room_area}m² (rộng hơn {diff_area:.1f}m² so với mong muốn)")
    else:
        trade_offs.append(f"Diện tích {room_area}m² (gọn hơn {diff_area:.1f}m² so với tiêu chuẩn {target_area}m²)")

    # Favorite
    if room.get("is_favorite"):
        preference_matches.append("Nằm trong danh sách phòng yêu thích của bạn")

    # Tóm tắt tổng thể
    summary = f"Phòng này phù hợp vì đáp ứng sức chứa {suc_chua} người, giá thuê {int(gia):,}₫/tháng và vị trí thuận tiện."

    return {
        "factual_matches": factual_matches,
        "preference_matches": preference_matches,
        "trade_offs": trade_offs,
        "summary": summary
    }


def generate_ai_reasons(room, user, utilities=None):
    """
    Hàm tương thích ngược trả về danh sách các lý do chính dạng chuỗi.
    """
    exp = generate_ai_explanations(room, user, utilities)
    combined = []
    combined.extend(exp["factual_matches"][:2])
    combined.extend(exp["preference_matches"][:2])
    if exp["trade_offs"]:
        combined.append(exp["trade_offs"][0])
    return combined
