<?php

namespace App\Http\Controllers\Api\ChuTro;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use App\Models\ThongBao;

class YeuCauThueController extends Controller
{
    /**
     * 📋 Danh sách yêu cầu thuê của đúng chủ trọ
     */
    public function index(Request $request)
    {
        $user = $request->user();
        if (!$user || $user->vai_tro !== 'chu_tro') {
            return response()->json(['error' => 'Không có quyền truy cập'], 403);
        }

        $rows = DB::table('yeu_cau_thue')
            ->join('bai_dang', 'yeu_cau_thue.bai_dang_id', '=', 'bai_dang.id')
            ->join('phong', 'bai_dang.phong_id', '=', 'phong.id')
            ->join('day_tro', 'phong.day_tro_id', '=', 'day_tro.id')
            ->join('khach_thue', 'yeu_cau_thue.khach_thue_id', '=', 'khach_thue.id')
            ->join('nguoi_dung', 'khach_thue.nguoi_dung_id', '=', 'nguoi_dung.id')
            ->where('day_tro.chu_tro_id', $user->id)
            ->select([
                'yeu_cau_thue.id',
                'phong.id as phong_id',
                'phong.so_phong',
                'day_tro.ten_day_tro',
                'nguoi_dung.ho_ten as khach_thue',
                'yeu_cau_thue.ghi_chu',
                'yeu_cau_thue.nguoi_than',
                'yeu_cau_thue.trang_thai',
                'yeu_cau_thue.ngay_tao',
            ])
            ->orderByDesc('yeu_cau_thue.ngay_tao')
            ->get();

        return response()->json($rows);
    }

    /**
     * ❌ Từ chối yêu cầu thuê
     */
    public function tuChoi(Request $request, $id)
    {
        $user = $request->user();
        if (!$user || $user->vai_tro !== 'chu_tro') {
            return response()->json(['error' => 'Không có quyền truy cập'], 403);
        }

        $row = DB::table('yeu_cau_thue')
            ->join('bai_dang', 'yeu_cau_thue.bai_dang_id', '=', 'bai_dang.id')
            ->join('phong', 'bai_dang.phong_id', '=', 'phong.id')
            ->join('day_tro', 'phong.day_tro_id', '=', 'day_tro.id')
            ->where('day_tro.chu_tro_id', $user->id)
            ->where('yeu_cau_thue.id', $id)
            ->select('yeu_cau_thue.id', 'yeu_cau_thue.khach_thue_id')
            ->first();

        if (!$row) {
            return response()->json(['error' => 'Không tìm thấy yêu cầu'], 404);
        }

        DB::table('yeu_cau_thue')->where('id', $id)->update(['trang_thai' => 'tu_choi']);

        // 🛎️ Gửi thông báo cho khách thuê
        $khach = DB::table('khach_thue')
            ->join('nguoi_dung', 'nguoi_dung.id', '=', 'khach_thue.nguoi_dung_id')
            ->where('khach_thue.id', $row->khach_thue_id)
            ->select('nguoi_dung.id', 'nguoi_dung.ho_ten', 'nguoi_dung.email')
            ->first();

        if ($khach) {
            ThongBao::create([
                'nguoi_nhan_id' => $khach->id,
                'tieu_de' => 'Yêu cầu thuê bị từ chối',
                'noi_dung' => "Chủ trọ {$user->ho_ten} đã từ chối yêu cầu thuê của bạn.",
                'lien_ket' => '/khach-thue/yeu-cau-thue',
                'ngay_tao' => now(),
            ]);
            Log::info('🔔 Đã tạo thông báo từ chối cho khách thuê', ['khach' => $khach->email]);
        }

        return response()->json(['message' => 'Đã từ chối yêu cầu.']);
    }

    /**
     * Chấp nhận yêu cầu thuê (có thể chỉ chấp nhận hoặc tạo hợp đồng luôn)
     */
    public function chapNhan(Request $request, $id)
    {
        $user = $request->user();
        if (!$user || $user->vai_tro !== 'chu_tro') {
            return response()->json(['error' => 'Không có quyền truy cập'], 403);
        }

        // ✅ Lấy yêu cầu thuê thuộc chủ trọ này
        $yc = DB::table('yeu_cau_thue')
            ->join('bai_dang', 'yeu_cau_thue.bai_dang_id', '=', 'bai_dang.id')
            ->join('phong', 'bai_dang.phong_id', '=', 'phong.id')
            ->join('day_tro', 'phong.day_tro_id', '=', 'day_tro.id')
            ->where('day_tro.chu_tro_id', $user->id)
            ->where('yeu_cau_thue.id', $id)
            ->select([
                'yeu_cau_thue.id',
                'yeu_cau_thue.khach_thue_id',
                'yeu_cau_thue.trang_thai',
                'yeu_cau_thue.phong_id',
                'yeu_cau_thue.file_hop_dong',
                'bai_dang.phong_id as bai_dang_phong_id',
                'day_tro.ten_day_tro',
                'phong.so_phong'
            ])
            ->first();

        if (!$yc) {
            return response()->json(['error' => 'Không tìm thấy yêu cầu'], 404);
        }

        if ($yc->trang_thai === 'da_tao_hop_dong') {
            return response()->json(['message' => 'Yêu cầu đã được xử lý trước đó.']);
        }

        DB::beginTransaction();
        try {

            $ycData = DB::table('yeu_cau_thue')->where('id', $yc->id)->first();
            if (!$ycData) {
                throw new \Exception('Không tìm thấy dữ liệu yêu cầu thuê chi tiết.');
            }

            $phongId = $yc->phong_id ?? $yc->bai_dang_phong_id;
            if (!$phongId) {
                throw new \Exception('Không tìm thấy phòng liên kết với yêu cầu.');
            }

            $hdId = DB::table('hop_dong')->insertGetId([
                'khach_thue_id' => $ycData->khach_thue_id,
                'phong_id' => $phongId,
                'ngay_bat_dau' => $ycData->ngay_bat_dau ?? Carbon::today()->format('Y-m-d'),
                'ngay_ket_thuc' => $ycData->ngay_ket_thuc ?? Carbon::today()->addMonths(12)->format('Y-m-d'),
                'tien_coc' => $ycData->tien_coc ?? 0,
                'ghi_chu' => $ycData->ghi_chu ?? null,
                'trang_thai' => 'hieu_luc',
                'url_file_hop_dong' => $ycData->file_hop_dong ?? '',
                'ngay_tao' => now(),
            ]);

            if (!empty($ycData->nguoi_than)) {
                $nguoiThanRaw = $ycData->nguoi_than;
                $nguoiThanList = [];

                if (is_string($nguoiThanRaw)) {
                    $decoded = json_decode($nguoiThanRaw, true);
                    if (is_string($decoded)) {
                        $decoded = json_decode($decoded, true);
                    }

                    if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                        $nguoiThanList = $decoded;
                    }
                } elseif (is_array($nguoiThanRaw)) {
                    $nguoiThanList = $nguoiThanRaw;
                }

                if (!empty($nguoiThanList)) {
                    foreach ($nguoiThanList as $nt) {
                        DB::table('nguoi_than')->insert([
                            'khach_thue_id' => $ycData->khach_thue_id,
                            'ho_ten' => $nt['ho_ten'] ?? $nt['ten'] ?? 'Không rõ tên',
                            'moi_quan_he' => $nt['moi_quan_he'] ?? $nt['quan_he'] ?? 'Không rõ quan hệ',
                            'so_dien_thoai' => $nt['so_dien_thoai'] ?? null,
                        ]);
                    }
                } else {

                    DB::table('nguoi_than')->insert([
                        'khach_thue_id' => $ycData->khach_thue_id,
                        'ho_ten' => is_string($ycData->nguoi_than) ? $ycData->nguoi_than : 'Không rõ',
                        'moi_quan_he' => 'Người sống cùng',
                    ]);
                }
            }

            DB::table('phong')->where('id', $phongId)->update(['trang_thai' => 'da_thue']);
            DB::table('yeu_cau_thue')->where('id', $yc->id)->update(['trang_thai' => 'da_tao_hop_dong']);

            DB::commit();

            // ✅ Gửi thông báo cho khách thuê
            $khach = DB::table('khach_thue')
                ->join('nguoi_dung', 'nguoi_dung.id', '=', 'khach_thue.nguoi_dung_id')
                ->where('khach_thue.id', $yc->khach_thue_id)
                ->select('nguoi_dung.id', 'nguoi_dung.ho_ten', 'nguoi_dung.email')
                ->first();

            if ($khach) {
                if (!empty($khach->email)) {
                    try {
                        \Mail::to($khach->email)->queue(
                            new \App\Mail\ThongBaoKhachThueChapNhan(
                                (object) $khach,
                                (object) $user,
                                (object) [
                                    'so_phong' => $yc->so_phong,
                                    'day_tro' => $yc->ten_day_tro
                                ]
                            )
                        );
                        Log::info('📧 Đã gửi mail chấp nhận cho khách thuê', ['to' => $khach->email]);
                    } catch (\Throwable $mailEx) {
                        Log::error('💥 Gửi mail cho khách thuê thất bại', ['error' => $mailEx->getMessage()]);
                    }
                }

                ThongBao::create([
                    'nguoi_nhan_id' => $khach->id,
                    'tieu_de' => 'Hợp đồng đã được tạo',
                    'noi_dung' => "Chủ trọ {$user->ho_ten} đã chấp nhận yêu cầu thuê và tạo hợp đồng cho phòng {$yc->so_phong} - {$yc->ten_day_tro}.",
                    'lien_ket' => '/khach-thue/hop-dong',
                    'ngay_tao' => now(),
                ]);

                Log::info('🔔 Đã tạo thông báo cho khách thuê');
            }

            return response()->json([
                'message' => 'Đã tạo hợp đồng thành công',
                'hop_dong_id' => $hdId,
            ]);

        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('💥 Lỗi chapNhan YC', [
                'msg' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile(),
            ]);
            return response()->json(['error' => 'Không thể tạo hợp đồng: ' . $e->getMessage()], 500);
        }
    }

    /**
     * 🔍 Xem chi tiết yêu cầu thuê
     */
    public function show(Request $request, $id)
    {
        $user = $request->user();
        if (!$user || $user->vai_tro !== 'chu_tro') {
            return response()->json(['error' => 'Không có quyền truy cập'], 403);
        }

        $yc = DB::table('yeu_cau_thue')
            ->join('bai_dang', 'yeu_cau_thue.bai_dang_id', '=', 'bai_dang.id')
            ->join('phong', 'bai_dang.phong_id', '=', 'phong.id')
            ->join('day_tro', 'phong.day_tro_id', '=', 'day_tro.id')
            ->join('khach_thue', 'yeu_cau_thue.khach_thue_id', '=', 'khach_thue.id')
            ->join('nguoi_dung', 'khach_thue.nguoi_dung_id', '=', 'nguoi_dung.id')
            ->where('day_tro.chu_tro_id', $user->id)
            ->where('yeu_cau_thue.id', $id)
            ->select([
                'yeu_cau_thue.id',
                'yeu_cau_thue.cccd',
                'yeu_cau_thue.ngay_bat_dau',
                'yeu_cau_thue.ngay_ket_thuc',
                'yeu_cau_thue.tien_coc',
                'yeu_cau_thue.ghi_chu',
                'yeu_cau_thue.nguoi_than',
                'yeu_cau_thue.file_hop_dong',
                'yeu_cau_thue.trang_thai',
                'yeu_cau_thue.ngay_tao',
                'phong.so_phong',
                'day_tro.ten_day_tro',
                'nguoi_dung.ho_ten as khach_thue',
                'nguoi_dung.email',
                'nguoi_dung.so_dien_thoai',
            ])
            ->first();

        if (!$yc) {
            return response()->json(['error' => 'Không tìm thấy yêu cầu'], 404);
        }

        return response()->json($yc);
    }
}
