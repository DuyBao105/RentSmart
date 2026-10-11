import os
import torch
import numpy as np
from fastapi import FastAPI, Request
from fastapi.middleware.cors import CORSMiddleware

from db import load_posts, load_all_utilities, load_favorites
from utils import (
    RoomEnv,
    filter_mandatory_constraints,
    compute_satisfaction_score,
    generate_ai_explanations,
    generate_ai_reasons
)
from dqn_model import DuelingDQN

app = FastAPI(title="AI Smart Room Allocation Engine (Dueling DQN Optimization)")

app.add_middleware(
    CORSMiddleware,
    allow_origins=["*"],
    allow_credentials=True,
    allow_methods=["*"],
    allow_headers=["*"],
)

# =====================================================================
# 1. LOAD INVENTORY DATA & DUELING DQN MODEL
# =====================================================================
posts_df = None
posts_raw = []
utilities = {}
rooms = []
env = None
model = None
feature_dim = 8

def refresh_data():
    global posts_df, posts_raw, utilities, rooms, env, model, feature_dim
    posts_df = load_posts()
    posts_raw = posts_df.to_dict(orient="records")
    utilities = load_all_utilities()

    rooms = []
    for p in posts_raw:
        rooms.append({
            "id": p["phong_id"],
            "bai_dang_id": p["bai_dang_id"],
            "gia": float(p.get("gia") or p.get("gia_phong") or 0),
            "dien_tich": float(p.get("dien_tich") or 20.0),
            "suc_chua": int(p.get("suc_chua") or 2),
            "days_empty": int(p.get("days_empty") or 30),
            "trang_thai": str(p.get("trang_thai") or "trong"),
            "dia_chi": str(p.get("dia_chi_daytro") or "")
        })

    env = RoomEnv(rooms, utilities, [])
    feature_dim = env.feature_dim

    # Khởi tạo mô hình Dueling DQN với số chiều đặc trưng chuẩn hóa
    model = DuelingDQN(state_size=len(rooms) * feature_dim, action_size=len(rooms), feature_dim=feature_dim)
    model_path = os.path.join(os.path.dirname(__file__), "dqn_room.pt")
    if os.path.exists(model_path):
        model.load_state_dict(torch.load(model_path, map_location="cpu"))
        print("[AI Engine] Da nap trong so Dueling DQN tu dqn_room.pt")
    model.eval()

refresh_data()


@app.get("/")
@app.get("/health")
def health_check():
    return {
        "status": "healthy",
        "model": "DuelingDQN (Dynamic Candidate Scoring)",
        "rooms_indexed": len(rooms),
        "feature_dim": feature_dim,
        "active_posts": len(posts_raw)
    }


@app.post("/reload")
def reload_data_endpoint():
    refresh_data()
    return {
        "status": "success",
        "message": f"Da lam moi {len(rooms)} phong tro tu co so du lieu."
    }


# =====================================================================
# 2. ENDPOINT RECOMMEND_TOP3 (DÀNH CHO WEB LISTING & PUBLIC DISCOVERY)
# =====================================================================
@app.post("/recommend_top3")
def recommend_top3(data: dict):
    """
    Quy trình đề xuất phòng thông minh bằng Dueling DQN với cổng kiểm tra ràng buộc cứng:
      1. Thu thập và xác thực sở thích khách thuê (ngân sách, số người, diện tích, tiện ích, vị trí).
      2. Áp dụng CỔNG RÀNG BUỘC CỨNG (Hard Constraint Filter):
         - Phòng BẮT BUỘC phải còn trống (trang_thai == 'trong').
         - Sức chứa BẮT BUỘC >= số người thuê.
         - Nếu bật strict_budget: Giá BẮT BUỘC <= ngân sách trần (không ngoại lệ).
         - Nếu bật strict_location: Vị trí BẮT BUỘC khớp khu vực yêu cầu.
      3. Nếu không có phòng nào thỏa mãn -> trả về trạng thái no_match rõ ràng,
         tuyệt đối không cho Q-value ghi đè hoặc bịa đặt dữ liệu phòng.
      4. Với các ứng viên hợp lệ -> Xây dựng ma trận đặc trưng & Đánh giá bằng mạng Dueling DQN.
      5. Sắp xếp và trích xuất Top N cùng hệ thống giải thích đa chiều, minh bạch.
    """
    user_id = data.get("user_id")
    budget = float(data.get("budget") or data.get("max_price") or 3_500_000)
    area = float(data.get("area") or 22.0)
    user_utils = data.get("dich_vu_id") or data.get("utilities") or []
    if isinstance(user_utils, str):
        user_utils = [int(u.strip()) for u in user_utils.split(",") if u.strip().isdigit()]

    location = str(data.get("dia_chi") or data.get("location") or "")
    people = int(data.get("people") or data.get("so_nguoi") or 1)
    strict_budget = bool(data.get("strict_budget", True))
    strict_location = bool(data.get("strict_location", False))
    limit = min(max(int(data.get("limit") or 3), 1), 10)

    # Load favorites nếu có user_id
    try:
        favorites = load_favorites(user_id) if user_id else []
    except Exception:
        favorites = []

    env.favorites = favorites

    user = {
        "budget": budget,
        "strict_budget": strict_budget,
        "area": area,
        "people": people,
        "utilities": user_utils,
        "location": location,
        "strict_location": strict_location
    }

    # BƯỚC 1: LỌC RÀNG BUỘC CỨNG NGHIÊM NGẶT
    valid_candidates, audit = filter_mandatory_constraints(rooms, user, utilities)

    # NẾU KHÔNG CÓ PHÒNG NÀO THỎA MÃN RÀNG BUỘC CỨNG:
    if len(valid_candidates) == 0:
        suggested_adjustments = []
        if audit["rejection_breakdown"]["over_budget"] > 0:
            suggested_adjustments.append(f"Tăng ngân sách tối đa thêm 500.000₫ – 1.000.000₫ (hiện có {audit['rejection_breakdown']['over_budget']} phòng vượt ngân sách)")
        if audit["rejection_breakdown"]["capacity_insufficient"] > 0:
            suggested_adjustments.append(f"Giảm bớt yêu cầu số người ở tối thiểu nếu có thể tách phòng (hiện có {audit['rejection_breakdown']['capacity_insufficient']} phòng không đủ sức chứa)")
        if strict_location and audit["rejection_breakdown"]["location_mismatch"] > 0:
            suggested_adjustments.append("Mở rộng phạm vi tìm kiếm sang các quận/huyện lân cận")
        if not suggested_adjustments:
            suggested_adjustments.append("Nới lỏng bớt các tiêu chí lọc để hệ thống tìm thêm các phương án phù hợp")

        return {
            "status": "no_match",
            "algorithm": "Dueling Deep Q-Network (DQN) with Strict Hard-Constraint Gate",
            "eligible_count": 0,
            "total_evaluated": len(rooms),
            "audit": audit,
            "message": "Không tìm thấy phòng trọ nào đáp ứng đồng thời tất cả các tiêu chí bắt buộc.",
            "suggested_adjustments": suggested_adjustments,
            "recommend": []
        }

    # BƯỚC 2: XÂY DỰNG MA TRẬN ĐẶC TRƯNG CHO CÁC ỨNG VIÊN HỢP LỆ
    env.user = user
    state_matrix = env.build_state(candidate_rooms=valid_candidates)  # (K, 8)
    state_tensor = torch.tensor(state_matrix.reshape(1, len(valid_candidates), feature_dim), dtype=torch.float32)

    # BƯỚC 3: DỰ ĐOÁN GIÁ TRỊ Q-VALUE BẰNG DUELING DQN
    with torch.no_grad():
        q_values = model(state_tensor)[0].numpy()  # (K,)

    # BƯỚC 4: SẮP XẾP VÀ TRÍCH XUẤT TOP ỨNG VIÊN TỐI ƯU
    sorted_indices = np.argsort(q_values)[::-1]
    top_indices = sorted_indices[:limit]

    top_recommendations = []
    for rank_idx, idx in enumerate(top_indices):
        room_info = valid_candidates[idx]
        room_id = room_info["id"]

        # Map về thông tin bài đăng gốc
        p = next((x for x in posts_raw if x["phong_id"] == room_id), None)
        if not p:
            continue

        q_val = float(q_values[idx])
        sat_score = compute_satisfaction_score(room_info, user, utilities)
        explanations = generate_ai_explanations(room_info, user, utilities)
        reasons_list = generate_ai_reasons(room_info, user, utilities)

        top_recommendations.append({
            "ranking_rank": rank_idx + 1,
            "bai_dang_id": p.get("bai_dang_id"),
            "tieu_de": p.get("tieu_de"),
            "gia": float(p.get("gia") or 0),
            "gia_phong": float(p.get("gia_phong") or 0),
            "dien_tich": float(p.get("dien_tich") or 0),
            "suc_chua": int(p.get("suc_chua") or 2),
            "tang": p.get("tang"),
            "ten_day_tro": p.get("ten_day_tro"),
            "phong_id": p.get("phong_id"),
            "dia_chi": p.get("dia_chi_daytro"),
            "tien_ich": utilities.get(p["phong_id"], []),
            "mo_ta": p.get("mo_ta"),
            "days_empty": int(p.get("days_empty") or 30),
            "q_value": round(q_val, 3),
            "satisfaction_score": sat_score,
            "explanations": explanations,
            "ai_reasons": reasons_list,
            "constraint_status": "Đáp ứng 100% tiêu chí bắt buộc (Phòng trống, đủ sức chứa, trong ngân sách)",
            "is_favorite": 1 if p["phong_id"] in favorites else 0
        })

    return {
        "status": "success",
        "algorithm": "Dueling Deep Q-Network (DQN) with Strict Hard-Constraint Gate",
        "eligible_count": len(valid_candidates),
        "total_evaluated": len(rooms),
        "audit": audit,
        "recommend": top_recommendations
    }


# =====================================================================
# 3. ENDPOINT /score (TƯƠNG THÍCH VỚI BACKEND API PORT 8000)
# =====================================================================
@app.post("/score")
def score_candidates(data: dict):
    """
    Endpoint tương thích với RecommendationController@recommend từ API Laravel:
    Nhận tham số: user_id, limit, fetch (boolean)
    Trả về danh sách đối tượng: [{ "id": bai_dang_id, "award": q_val, "base_award": sat, "pref_match": sat }]
    """
    user_id = data.get("user_id")
    limit = min(max(int(data.get("limit") or 50), 1), 100)

    try:
        favorites = load_favorites(user_id) if user_id else []
    except Exception:
        favorites = []

    user = {
        "budget": 4_000_000,
        "strict_budget": False,
        "area": 25.0,
        "people": 1,
        "utilities": [],
        "location": "",
        "strict_location": False
    }

    valid_candidates, _ = filter_mandatory_constraints(rooms, user, utilities)
    if not valid_candidates:
        valid_candidates = rooms[:limit]

    env.user = user
    env.favorites = favorites
    state_matrix = env.build_state(candidate_rooms=valid_candidates)
    state_tensor = torch.tensor(state_matrix.reshape(1, len(valid_candidates), feature_dim), dtype=torch.float32)

    with torch.no_grad():
        q_values = model(state_tensor)[0].numpy()

    sorted_indices = np.argsort(q_values)[::-1]

    results = []
    for idx in sorted_indices[:limit]:
        r = valid_candidates[idx]
        q_val = float(q_values[idx])
        sat = compute_satisfaction_score(r, user, utilities)
        results.append({
            "id": r["bai_dang_id"],
            "phong_id": r["id"],
            "award": round(q_val, 3),
            "base_award": sat,
            "pref_match": sat
        })

    return results
