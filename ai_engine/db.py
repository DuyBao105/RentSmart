import mysql.connector
import pandas as pd
import json

# ======================================
# CONNECT MYSQL
# ======================================
def get_connection():
    return mysql.connector.connect(
        host="127.0.0.1",
        user="root",
        password="",
        database="nha_tro",
        port=3306
    )

# ======================================
# LOAD PHÒNG & BÀI ĐĂNG CHO RL
# ======================================
def load_posts():
    conn = get_connection()

    query = """
        SELECT 
            bd.id AS bai_dang_id,
            bd.tieu_de,
            bd.mo_ta,
            bd.gia_niem_yet AS gia,
            bd.ngay_cap_nhat AS ngay_cap_nhat_baidang,

            -- PHÒNG
            p.id AS phong_id,
            p.so_phong,
            p.gia AS gia_phong,
            p.dien_tich,
            p.suc_chua,
            p.tang,
            p.trang_thai,
            p.ngay_cap_nhat AS ngay_cap_nhat_phong,

            -- DAYS EMPTY (mặc định nếu null là 30 ngày)
            COALESCE(TIMESTAMPDIFF(DAY, p.ngay_cap_nhat, NOW()), 30) AS days_empty,

            -- DÃY TRỌ
            dt.id AS day_tro_id,
            dt.ten_day_tro,
            dt.dia_chi AS dia_chi_daytro,
            dt.tien_ich AS tien_ich_daytro

        FROM bai_dang bd
        JOIN phong p ON p.id = bd.phong_id
        JOIN day_tro dt ON dt.id = p.day_tro_id
        WHERE bd.trang_thai = 'dang'   -- bài đăng đang bật công khai
        ORDER BY bd.id ASC
    """

    df = pd.read_sql(query, conn)
    conn.close()

    return df


# ======================================
# LOAD TIỆN ÍCH PHÒNG (từ phong_tien_ich)
# Trả về dạng: { phong_id: [1,2,3], ... }
# ======================================
def load_all_utilities():
    conn = get_connection()

    query = """
        SELECT phong_id, tien_ich_id 
        FROM phong_tien_ich
    """

    try:
        df = pd.read_sql(query, conn)
        conn.close()

        utilities = {}
        for _, row in df.iterrows():
            pid = int(row["phong_id"])
            tid = int(row["tien_ich_id"])
            if pid not in utilities:
                utilities[pid] = []
            utilities[pid].append(tid)

        return utilities
    except Exception:
        conn.close()
        return {}


# ======================================
# LOAD FAVORITES (yeu_thich)
# ======================================
def load_favorites(user_id):
    if not user_id:
        return []
    try:
        conn = get_connection()
        query = f"SELECT bai_dang_id FROM yeu_thich WHERE nguoi_dung_id = {int(user_id)}"
        df = pd.read_sql(query, conn)
        conn.close()
        return df["bai_dang_id"].tolist()
    except Exception:
        return []
