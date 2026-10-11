<?php

namespace App\Services;

use App\Models\ChiSo;
use App\Models\DongHo;
use App\Models\HoaDon;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class HoaDonService
{
    /**
     * 🔹 Cập nhật hoặc tạo chi tiết đồng hồ (điện/nước) cho 1 hóa đơn.
     */
    public function capNhatChiTietDongHo(DongHo $dongHo, HoaDon $hoaDon): void
    {
        $thang = Carbon::parse($hoaDon->thang . '-01');
        $thangSau = $thang->copy()->addMonthNoOverflow();

        $chiSoMoi = ChiSo::where('dong_ho_id', $dongHo->id)
            ->whereBetween('thoi_gian', [$thang, $thangSau])
            ->orderByDesc('thoi_gian')
            ->first();

        $chiSoCu = ChiSo::where('dong_ho_id', $dongHo->id)
            ->where('thoi_gian', '<', $thang)
            ->orderByDesc('thoi_gian')
            ->first();

        if ($chiSoMoi && $chiSoCu && $chiSoMoi->gia_tri >= $chiSoCu->gia_tri) {
            $sanLuong = $chiSoMoi->gia_tri - $chiSoCu->gia_tri;
            $donGia = $dongHo->dichVu->don_gia ?? 0;
            $thanhTien = $sanLuong * $donGia;

            DB::table('chi_tiet_dong_ho')->updateOrInsert(
                [
                    'hoa_don_id' => $hoaDon->id,
                    'dong_ho_id' => $dongHo->id,
                ],
                [
                    'dich_vu_id' => $dongHo->dich_vu_id,
                    'chi_so_cu' => $chiSoCu->gia_tri,
                    'chi_so_moi' => $chiSoMoi->gia_tri,
                    'san_luong' => $sanLuong,
                    'don_gia' => $donGia,
                    'thanh_tien' => $thanhTien,
                ]
            );

            $this->capNhatTongTienHoaDon($hoaDon);
        }
    }


    /**
     * 🔹 Tính lại toàn bộ tổng tiền (dịch vụ, điện nước, tổng hóa đơn)
     * đảm bảo đồng bộ tuyệt đối giữa bảng chi tiết và bảng hóa đơn.
     */
    public function capNhatTongTienHoaDon(HoaDon $hoaDon): void
    {
        // Lấy lại tổng tiền dịch vụ từ bảng chi tiết dịch vụ
        $tongTienDichVu = DB::table('chi_tiet_dich_vu')
            ->where('hoa_don_id', $hoaDon->id)
            ->sum('thanh_tien');

        //  Lấy lại tổng tiền điện nước từ bảng chi tiết đồng hồ
        $tongTienDongHo = DB::table('chi_tiet_dong_ho')
            ->where('hoa_don_id', $hoaDon->id)
            ->sum('thanh_tien');

        // Cập nhật lại tổng hóa đơn
        $hoaDon->update([
            'tien_dich_vu' => $tongTienDichVu,
            'tien_dong_ho' => $tongTienDongHo,
            'tong_tien' => $hoaDon->tien_phong + $tongTienDichVu + $tongTienDongHo,
        ]);
    }
}
