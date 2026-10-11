<?php

namespace App\Http\Controllers\Api\ChuTro;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HoaDon;
use App\Models\HopDong;
use App\Models\DichVuDinhKy;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Services\HoaDonService;
use Illuminate\Support\Facades\Log;
class HoaDonController extends Controller
{
    protected $hoaDonService;

    public function __construct(HoaDonService $hoaDonService)
    {
        $this->hoaDonService = $hoaDonService;
    }

    private function nextDueDateFromStartDate(string $ngayBatDau): Carbon
    {
        $start = Carbon::parse($ngayBatDau);
        $today = Carbon::today();

        $thisMonthTarget = Carbon::create(
            $today->year,
            $today->month,
            min($start->day, $today->daysInMonth)
        );

        return $today->greaterThanOrEqualTo($thisMonthTarget)
            ? $thisMonthTarget->copy()->addMonthNoOverflow()
            : $thisMonthTarget;
    }

    /*public function index()
    {
        $user = Auth::user();
        if (!$user)
            return response()->json(['error' => 'Chưa đăng nhập'], 401);

        $hoaDons = HoaDon::with(['hopDong.phong.dayTro'])
            ->whereHas('hopDong.phong', function ($q) use ($user) {
                $q->whereHas('dayTro', fn($d) => $d->where('chu_tro_id', $user->id))
                    ->whereIn('trang_thai', ['da_thue', 'dang_thue']);
            })
            ->orderByDesc('thang')
            ->get()
            ->map(function ($hd) {
                $hd->qua_han = (
                    in_array($hd->trang_thai, ['chua_thanh_toan', 'mot_phan'])
                    && Carbon::parse($hd->han_thanh_toan)->lt(now())
                );
                return $hd;
            });

        return response()->json($hoaDons);
    }*/
    public function index(Request $request)
    {
        $user = Auth::user();
        if (!$user)
            return response()->json(['error' => 'Chưa đăng nhập'], 401);

        $query = HoaDon::with(['hopDong.phong.dayTro'])
            ->whereHas('hopDong.phong', function ($q) use ($user) {
                $q->whereHas('dayTro', fn($d) => $d->where('chu_tro_id', $user->id))
                ->whereIn('trang_thai', ['da_thue', 'dang_thue']);
            });

        if ($request->filled('phong')) {
            $phong = $request->input('phong');
            $query->whereHas('hopDong.phong', function ($q) use ($phong) {
                $q->where('so_phong', $phong);
            });
        }

        if ($request->filled('thang')) {
            $query->where('thang', 'LIKE', $request->thang . '%');
        }

        if ($request->filled('trang_thai')) {
            $query->where('trang_thai', $request->input('trang_thai'));
        }

        $hoaDons = $query
            ->orderByDesc('thang')
            ->get()
            ->map(function ($hd) {
                $hd->qua_han = (
                    in_array($hd->trang_thai, ['chua_thanh_toan', 'mot_phan']) &&
                    Carbon::parse($hd->han_thanh_toan)->lt(now())
                );
                return $hd;
            });

        return response()->json($hoaDons);
    }


    public function generate()
    {
        $user = Auth::user();
        if (!$user)
            return response()->json(['error' => 'Chưa đăng nhập'], 401);

        $thangHienTai = Carbon::now()->startOfMonth();
        $thangFormat = $thangHienTai->format('Y-m');

        $hopDongs = HopDong::with(['phong.dayTro', 'phong.dongHo.dichVu'])
            ->whereHas('phong', function ($q) use ($user) {
                $q->whereHas('dayTro', fn($d) => $d->where('chu_tro_id', $user->id))
                    ->whereIn('trang_thai', ['da_thue', 'dang_thue']);
            })
            ->where('trang_thai', 'hieu_luc')
            ->where('ngay_ket_thuc', '>', now())
            ->get();

        if ($hopDongs->isEmpty()) {
            return response()->json(['message' => 'Không có hợp đồng hiệu lực để tạo hóa đơn.']);
        }

        $hoaDonsTaoMoi = [];
        $hoaDonsTaoTiep = [];
        DB::beginTransaction();

        try {
            foreach ($hopDongs as $hopDong) {
                $phong = $hopDong->phong;

                if (!in_array($phong->trang_thai, ['da_thue', 'dang_thue']))
                    continue;

                $daCo = HoaDon::where('hop_dong_id', $hopDong->id)
                    ->where('thang', $thangFormat)
                    ->exists();

                if ($daCo) {
                    \Log::info("⚠️ Đã có hóa đơn tháng {$thangFormat} cho phòng {$phong->so_phong}, bỏ qua.");
                    continue;
                }

                $dsDv = DichVuDinhKy::where('phong_id', $phong->id)->get();
                $tongTienDichVu = $dsDv->sum(fn($dv) => ($dv->don_gia ?? 0) * ($dv->so_luong ?? 1));

                $hoaDon = HoaDon::create([
                    'hop_dong_id' => $hopDong->id,
                    'thang' => $thangFormat,
                    'tien_phong' => $phong->gia ?? 0,
                    'tien_dich_vu' => $tongTienDichVu,
                    'tien_dong_ho' => 0,
                    'tong_tien' => ($phong->gia ?? 0) + $tongTienDichVu,
                    'trang_thai' => 'chua_thanh_toan',
                    'han_thanh_toan' => $this->nextDueDateFromStartDate($hopDong->ngay_bat_dau),
                ]);

                foreach ($dsDv as $dv) {
                    DB::table('chi_tiet_dich_vu')->insert([
                        'hoa_don_id' => $hoaDon->id,
                        'dich_vu_id' => $dv->dich_vu_id,
                        'so_luong' => $dv->so_luong ?? 1,
                        'don_gia' => $dv->don_gia ?? 0,
                        'thanh_tien' => ($dv->so_luong ?? 1) * ($dv->don_gia ?? 0),
                    ]);
                }

                foreach ($phong->dongHo as $dongHo) {
                    $this->hoaDonService->capNhatChiTietDongHo($dongHo, $hoaDon);
                }

                $this->hoaDonService->capNhatTongTienHoaDon($hoaDon);
                $hoaDonsTaoMoi[] = $hoaDon;
                \Log::info("✅ Tạo hóa đơn tháng {$thangFormat} cho phòng {$phong->so_phong}, tổng {$hoaDon->tong_tien}đ");
            }

            $hoaDonsDaThanhToan = HoaDon::whereIn('trang_thai', ['da_thanh_toan', 'da_huy'])
                ->whereHas('hopDong.phong.dayTro', fn($q) => $q->where('chu_tro_id', $user->id))
                ->get();

            foreach ($hoaDonsDaThanhToan as $hd) {
                $result = $this->taoHoaDonKeTiep($hd);
                if ($result)
                    $hoaDonsTaoTiep[] = $result;
            }

            DB::commit();

            $tongTao = count($hoaDonsTaoMoi) + count($hoaDonsTaoTiep);

            return response()->json([
                'message' => $tongTao
                    ? "✅ Đã tạo {$tongTao} hóa đơn mới (tháng {$thangFormat} và/tháng kế tiếp)."
                    : "ℹ️ Không có hóa đơn mới để tạo (mọi phòng đều đã có hoặc chưa đủ điều kiện)."
            ]);

        } catch (\Throwable $e) {
            DB::rollBack();
            \Log::error('❌ Lỗi tạo hóa đơn: ' . $e->getMessage());
            return response()->json(['error' => 'Không thể tạo hóa đơn'], 500);
        }
    }


    // Tạo hóa đơn kế tiếp khi đã thanh toán
    protected function taoHoaDonKeTiep(HoaDon $hoaDon)
    {
        try {
            $thangTiep = Carbon::createFromFormat('Y-m', $hoaDon->thang)
                ->addMonthNoOverflow()
                ->format('Y-m');

            \Log::info("🔁 Tạo hóa đơn kế tiếp từ {$hoaDon->thang} → {$thangTiep}");

            if (
                HoaDon::where('hop_dong_id', $hoaDon->hop_dong_id)
                    ->where('thang', $thangTiep)
                    ->exists()
            ) {
                \Log::info("⚠️ Hóa đơn tháng {$thangTiep} đã tồn tại cho phòng {$hoaDon->hopDong->phong->so_phong}, bỏ qua.");
                return null;
            }

            $hopDong = $hoaDon->hopDong()->with(['phong.dayTro', 'phong.dongHo.dichVu'])->first();
            if (!$hopDong) {
                \Log::warning("⚠️ Không tìm thấy hợp đồng cho hóa đơn ID {$hoaDon->id}");
                return null;
            }

            $phong = $hopDong->phong;
            if (!in_array($phong->trang_thai, ['da_thue', 'dang_thue'])) {
                \Log::info("⚠️ Phòng {$phong->so_phong} không còn đang thuê, bỏ qua tạo hóa đơn kế tiếp.");
                return null;
            }

            $dsDv = DichVuDinhKy::where('phong_id', $phong->id)->get();
            $tongTienDichVu = $dsDv->sum(fn($dv) => ($dv->don_gia ?? 0) * ($dv->so_luong ?? 1));

            $hoaDonMoi = HoaDon::create([
                'hop_dong_id' => $hopDong->id,
                'thang' => $thangTiep,
                'tien_phong' => $phong->gia ?? 0,
                'tien_dich_vu' => $tongTienDichVu,
                'tien_dong_ho' => 0,
                'tong_tien' => ($phong->gia ?? 0) + $tongTienDichVu,
                'trang_thai' => 'chua_thanh_toan',
                'han_thanh_toan' => $this->nextDueDateFromStartDate($hopDong->ngay_bat_dau),
            ]);

            foreach ($dsDv as $dv) {
                DB::table('chi_tiet_dich_vu')->insert([
                    'hoa_don_id' => $hoaDonMoi->id,
                    'dich_vu_id' => $dv->dich_vu_id,
                    'so_luong' => $dv->so_luong ?? 1,
                    'don_gia' => $dv->don_gia ?? 0,
                    'thanh_tien' => ($dv->so_luong ?? 1) * ($dv->don_gia ?? 0),
                ]);
            }

            foreach ($phong->dongHo as $dongHo) {
                $this->hoaDonService->capNhatChiTietDongHo($dongHo, $hoaDonMoi);
            }

            $this->hoaDonService->capNhatTongTienHoaDon($hoaDonMoi);

            \Log::info("✅ ĐÃ TẠO HÓA ĐƠN MỚI THÁNG {$thangTiep} CHO PHÒNG {$phong->so_phong}, tổng {$hoaDonMoi->tong_tien}đ");

            return $hoaDonMoi;

        } catch (\Throwable $e) {
            \Log::error("❌ Lỗi tạo hóa đơn kế tiếp cho hóa đơn {$hoaDon->id}: " . $e->getMessage());
            return null;
        }
    }

    // Xem chi tiết hóa đơn
    public function show($id)
    {
        $user = Auth::user();
        if (!$user)
            return response()->json(['error' => 'Chưa đăng nhập'], 401);

        $hoaDon = HoaDon::with([
            'hopDong.khachThue.nguoiDung',
            'hopDong.phong.dayTro.chuTro'
        ])
            ->whereHas('hopDong.phong.dayTro', fn($q) => $q->where('chu_tro_id', $user->id))
            ->find($id);

        if (!$hoaDon) {
            return response()->json(['error' => 'Không tìm thấy hóa đơn'], 404);
        }

        $phong = optional($hoaDon->hopDong->phong);
        $dayTro = optional($phong->dayTro);
        $chuTro = optional($dayTro->chuTro);
        $khachThue = optional($hoaDon->hopDong->khachThue);
        $nguoiDung = optional($khachThue->nguoiDung);


        $chiTietDichVu = DB::table('chi_tiet_dich_vu')
            ->leftJoin('dich_vu', 'chi_tiet_dich_vu.dich_vu_id', '=', 'dich_vu.id')
            ->where('chi_tiet_dich_vu.hoa_don_id', $hoaDon->id)
            ->select('dich_vu.ten as ten_dich_vu', 'chi_tiet_dich_vu.so_luong', 'chi_tiet_dich_vu.don_gia', 'chi_tiet_dich_vu.thanh_tien')
            ->get();

        $chiTietDongHo = DB::table('chi_tiet_dong_ho')
            ->leftJoin('dong_ho', 'chi_tiet_dong_ho.dong_ho_id', '=', 'dong_ho.id')
            ->leftJoin('dich_vu', 'chi_tiet_dong_ho.dich_vu_id', '=', 'dich_vu.id')
            ->where('chi_tiet_dong_ho.hoa_don_id', $hoaDon->id)
            ->select(
                'dong_ho.ma_dong_ho',
                'dich_vu.ten as ten_dich_vu',
                'chi_tiet_dong_ho.chi_so_cu',
                'chi_tiet_dong_ho.chi_so_moi',
                'chi_tiet_dong_ho.san_luong',
                'chi_tiet_dong_ho.don_gia',
                'chi_tiet_dong_ho.thanh_tien'
            )
            ->get();
        return response()->json([
            'id' => $hoaDon->id,
            'phong' => $phong->so_phong ?? 'N/A',
            'day_tro' => $dayTro->ten_day_tro ?? 'N/A',
            'dia_chi_day_tro' => $dayTro->dia_chi ?? 'Chưa cập nhật',

            'chu_tro' => [
                'ho_ten' => $chuTro->ho_ten ?? 'Chưa cập nhật',
                'so_dien_thoai' => $chuTro->so_dien_thoai ?? 'Chưa cập nhật',
                'bank_code' => $chuTro->bank_code ?? null,
                'account_no' => $chuTro->account_no ?? null,
                'account_name' => $chuTro->account_name ?? null,
            ],

            'khach_thue' => [
                'ho_ten' => $nguoiDung->ho_ten ?? 'Chưa cập nhật',
                'so_dien_thoai' => $nguoiDung->so_dien_thoai ?? 'Chưa cập nhật',
            ],

            'thang' => $hoaDon->thang,
            'tong_tien' => $hoaDon->tong_tien,
            'trang_thai' => $hoaDon->trang_thai,
            'han_thanh_toan' => Carbon::parse($hoaDon->han_thanh_toan)->format('d/m/Y'),

            'chi_tiet_dich_vu' => $chiTietDichVu,
            'chi_tiet_dien_nuoc' => $chiTietDongHo,
            'chi_tiet_dong_ho' => $chiTietDongHo
        ]);

    }


    // Thanh toán hóa đơn
    public function thanhToan($id)
    {
        $hoaDon = HoaDon::findOrFail($id);

        if ($hoaDon->trang_thai === 'chua_thanh_toan') {
            $hoaDon->so_tien_da_tra = $hoaDon->tong_tien / 2;
            $hoaDon->trang_thai = 'mot_phan';
        } elseif ($hoaDon->trang_thai === 'mot_phan') {
            $hoaDon->so_tien_da_tra = $hoaDon->tong_tien;
            $hoaDon->trang_thai = 'da_thanh_toan';
            $this->taoHoaDonKeTiep($hoaDon);
        }

        $hoaDon->save();

        return response()->json(['success' => true, 'trang_thai' => $hoaDon->trang_thai]);
    }

    // Hủy hóa đơn
    public function huy($id)
    {
        $hoaDon = HoaDon::findOrFail($id);
        if ($hoaDon->trang_thai === 'da_thanh_toan') {
            return response()->json(['message' => 'Không thể hủy hóa đơn đã thanh toán!'], 400);
        }

        $hoaDon->trang_thai = 'da_huy';
        $hoaDon->save();

        return response()->json(['success' => true, 'message' => '✅ Hóa đơn đã được hủy!']);
    }


    // 🖨️ Xuất PDF
    public function exportPdf($id)
    {
        try {
            $hoaDonResponse = $this->show($id);
            $hoaDonData = json_decode($hoaDonResponse->getContent(), true);

            if (isset($hoaDonData['error'])) {
                return response()->json(['error' => 'Không tìm thấy hóa đơn.'], 404);
            }

            $pdf = Pdf::loadView('pdf.hoa_don', ['hoaDon' => $hoaDonData])
                ->setPaper('A4', 'portrait')
                ->setOptions(['defaultFont' => 'DejaVu Sans']);

            $fileName = 'hoa_don_' . ($hoaDonData['phong'] ?? 'N') . '_' . ($hoaDonData['thang'] ?? '') . '.pdf';
            return $pdf->download($fileName);

        } catch (\Throwable $e) {
            \Log::error('Xuất PDF lỗi: ' . $e->getMessage());
            return response()->json(['error' => 'Không thể xuất PDF'], 500);
        }
    }
    public function guiYeuCauThanhToan($id)
    {
        $user = Auth::user();

        $hoaDon = HoaDon::with('hopDong.phong.dayTro.chuTro', 'hopDong.khachThue.nguoiDung')
            ->whereHas('hopDong.phong.dayTro', fn($q) => $q->where('chu_tro_id', $user->id))
            ->find($id);

        if (!$hoaDon) {
            return response()->json(['success' => false, 'message' => 'Không tìm thấy hóa đơn hoặc bạn không có quyền.'], 404);
        }

        $khach = $hoaDon->hopDong->khachThue->nguoiDung ?? null;
        if (!$khach) {
            return response()->json(['success' => false, 'message' => 'Không tìm thấy thông tin khách thuê.'], 404);
        }

        DB::table('thong_bao')->insert([
            'nguoi_nhan_id' => $khach->id,
            'noi_dung' => "📩 Chủ trọ yêu cầu thanh toán hóa đơn tháng {$hoaDon->thang} cho phòng {$hoaDon->hopDong->phong->so_phong}.",
            'loai' => 'hoa_don',
            'trang_thai' => 'chua_doc',
            'lien_ket' => "/khach-thue/hoa-don/{$hoaDon->id}",
            'da_xem' => 0,
            'ngay_tao' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => "✅ Đã gửi yêu cầu thanh toán cho khách thuê {$khach->ho_ten}.",
        ]);
    }

    public function xacNhanThanhToan($id)
    {
        try {
            $user = Auth::user();
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'Bạn chưa đăng nhập.'
                ], 401);
            }

            $hoaDon = HoaDon::with(['hopDong.khachThue.nguoiDung', 'hopDong.phong.dayTro'])
                ->whereHas('hopDong.phong.dayTro', fn($q) => $q->where('chu_tro_id', $user->id))
                ->find($id);

            if (!$hoaDon) {
                return response()->json([
                    'success' => false,
                    'message' => 'Không tìm thấy hóa đơn.'
                ], 404);
            }

            if ($hoaDon->trang_thai === 'da_thanh_toan') {
                return response()->json([
                    'success' => true,
                    'message' => 'Hóa đơn này đã được xác nhận trước đó.'
                ], 200);
            }

            DB::beginTransaction();

            $maGD = 'GD' . strtoupper(\Illuminate\Support\Str::random(8));
            $thanhToan = \App\Models\ThanhToan::where('hoa_don_id', $hoaDon->id)->first();
            if (!$thanhToan) {
                \App\Models\ThanhToan::create([
                    'hoa_don_id' => $hoaDon->id,
                    'ngay_thanh_toan' => now(),
                    'so_tien' => $hoaDon->tong_tien,
                    'phuong_thuc' => 'chuyen_khoan',
                    'ma_giao_dich' => $maGD,
                    'ngay_tao' => now(),
                ]);
            }

            $hoaDon->update([
                'trang_thai' => 'da_thanh_toan',
                'so_tien_da_tra' => $hoaDon->tong_tien,
                'ngay_thanh_toan' => now(),
            ]);

            $khach = optional($hoaDon->hopDong->khachThue)->nguoiDung;
            if ($khach && isset($khach->id)) {
                DB::table('thong_bao')->insert([
                    'nguoi_nhan_id' => $khach->id,
                    'noi_dung' => "💰 Chủ trọ đã xác nhận bạn đã thanh toán thành công hóa đơn tháng {$hoaDon->thang} phòng {$hoaDon->hopDong->phong->so_phong}.",
                    'loai' => 'hoa_don',
                    'trang_thai' => 'chua_doc',
                    'da_xem' => 0,
                    'lien_ket' => '/khach-thue/hoa-don/' . $hoaDon->id,
                    'ngay_tao' => now(),
                ]);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => '✅ Đã xác nhận thanh toán thành công và gửi thông báo cho khách thuê.'
            ], 200, ['Content-Type' => 'application/json']);

        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('❌ Lỗi xác nhận thanh toán (Chủ trọ): ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Đã xảy ra lỗi trong quá trình xác nhận thanh toán.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    public function huyXacNhan($id)
    {
        try {
            $user = Auth::user();
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'Bạn chưa đăng nhập.'
                ], 401);
            }

            $hoaDon = HoaDon::with('hopDong.khachThue.nguoiDung', 'hopDong.phong.dayTro')
                ->whereHas('hopDong.phong.dayTro', fn($q) => $q->where('chu_tro_id', $user->id))
                ->find($id);

            if (!$hoaDon) {
                return response()->json([
                    'success' => false,
                    'message' => 'Không tìm thấy hóa đơn.'
                ], 404);
            }

            if ($hoaDon->trang_thai !== 'cho_xac_nhan') {
                return response()->json([
                    'success' => false,
                    'message' => 'Chỉ có thể huỷ khi hóa đơn đang chờ xác nhận.'
                ], 400);
            }

            $hoaDon->update([
                'trang_thai' => 'chua_thanh_toan',
                'ngay_thanh_toan' => null,
                // 'so_tien_da_tra' => null, 
            ]);

            $khach = $hoaDon->hopDong->khachThue->nguoiDung ?? null;
            if ($khach) {
                DB::table('thong_bao')->insert([
                    'nguoi_nhan_id' => $khach->id,
                    'noi_dung' => "❌ Yêu cầu xác nhận thanh toán HĐ tháng {$hoaDon->thang} (phòng {$hoaDon->hopDong->phong->so_phong}) đã bị từ chối. Vui lòng thanh toán lại qua QR và bấm xác nhận.",
                    'loai' => 'hoa_don',
                    'trang_thai' => 'chua_doc',
                    'da_xem' => 0,
                    'lien_ket' => '/khach-thue/hoa-don/' . $hoaDon->id,
                    'ngay_tao' => now(),
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Đã huỷ yêu cầu xác nhận. Hóa đơn trở lại trạng thái CHƯA THANH TOÁN.'
            ]);
        } catch (\Throwable $e) {
            Log::error('❌ Lỗi huỷ xác nhận thanh toán (Chủ trọ): ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Đã xảy ra lỗi khi huỷ xác nhận.',
            ], 500);
        }
    }

}
