<?php

namespace App\Http\Controllers\Api\ChuTro;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use App\Models\ThongBao;

class HopDongController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        if (!$user || $user->vai_tro !== 'chu_tro') {
            return response()->json(['error' => 'Không có quyền truy cập'], 403);
        }

        $dayTroId = $request->query('day_tro_id');

        $hopdongs = DB::table('hop_dong')
            ->join('phong', 'hop_dong.phong_id', '=', 'phong.id')
            ->join('day_tro', 'phong.day_tro_id', '=', 'day_tro.id')
            ->join('khach_thue', 'hop_dong.khach_thue_id', '=', 'khach_thue.id')
            ->join('nguoi_dung', 'khach_thue.nguoi_dung_id', '=', 'nguoi_dung.id')
            ->where('day_tro.chu_tro_id', $user->id)
            ->when($dayTroId, fn($q) => $q->where('day_tro.id', $dayTroId))
            ->select([
                'hop_dong.id',
                'phong.so_phong',
                'day_tro.ten_day_tro',
                'nguoi_dung.ho_ten as khach_thue',
                'hop_dong.ngay_bat_dau',
                'hop_dong.ngay_ket_thuc',
                'hop_dong.tien_coc',
                'hop_dong.trang_thai',
                'hop_dong.url_file_hop_dong',
                'hop_dong.ngay_tao',
                'hop_dong.ngay_cap_nhat'
            ])
            ->orderByDesc('hop_dong.ngay_tao')
            ->get()
            ->map(function ($hd) {
                $daysLeft = Carbon::parse($hd->ngay_ket_thuc)->diffInDays(now(), false);
                $hd->sap_het_han = $daysLeft <= 7 && $daysLeft >= 0;
                $hd->con_lai = $daysLeft;
                return $hd;
            });

        return response()->json($hopdongs);
    }

    public function store(Request $request)
    {
        $user = $request->user();
        if (!$user || $user->vai_tro !== 'chu_tro') {
            return response()->json(['error' => 'Không có quyền truy cập'], 403);
        }

        $v = \Validator::make($request->all(), [
            'phong_id' => ['required', 'exists:phong,id'],
            'khach_thue_id' => ['required', 'exists:khach_thue,id'],
            'ngay_bat_dau' => ['required', 'date'],
            'ngay_ket_thuc' => ['required', 'date', 'after:ngay_bat_dau'],
            'tien_coc' => ['nullable', 'numeric', 'min:0'],
            'file_hop_dong' => ['required', 'file', 'mimes:pdf', 'max:4096'],
            'yeu_cau_thue_id' => ['nullable', 'exists:yeu_cau_thue,id'],
            'nguoi_than' => ['nullable'],
        ], [
            'phong_id.required' => 'Vui lòng chọn phòng.',
            'phong_id.exists' => 'Phòng không hợp lệ.',
            'khach_thue_id.required' => 'Vui lòng chọn khách thuê.',
            'khach_thue_id.exists' => 'Khách thuê không hợp lệ.',
            'ngay_bat_dau.required' => 'Vui lòng chọn ngày bắt đầu.',
            'ngay_ket_thuc.required' => 'Vui lòng chọn ngày kết thúc.',
            'tien_coc.numeric' => 'Tiền cọc phải là số.',
            'file_hop_dong.required' => 'Vui lòng tải lên file hợp đồng (PDF).',
            'file_hop_dong.mimes' => 'Tệp hợp đồng phải là PDF.',
            'file_hop_dong.max' => 'Tệp hợp đồng tối đa 4MB.',
        ]);

        if ($v->fails()) {
            return response()->json([
                'error' => 'Dữ liệu chưa hợp lệ.',
                'fields' => $v->errors(),
            ], 422);
        }

        $validated = $v->validated();

        // ✅ Nếu tạo từ yêu cầu thuê mà không truyền tiền cọc -> lấy từ yeu_cau_thue
        if (!empty($validated['yeu_cau_thue_id']) && empty($validated['tien_coc'])) {
            $yc = DB::table('yeu_cau_thue')->where('id', $validated['yeu_cau_thue_id'])->first();
            if ($yc) {
                $validated['tien_coc'] = $yc->tien_coc ?? 0;
            }
        }

        $phong = DB::table('phong')
            ->join('day_tro', 'phong.day_tro_id', '=', 'day_tro.id')
            ->where('phong.id', $validated['phong_id'])
            ->where('day_tro.chu_tro_id', $user->id)
            ->select('phong.*', 'day_tro.chu_tro_id')
            ->first();

        if (!$phong) {
            return response()->json(['error' => 'Phòng không thuộc quyền quản lý của bạn.'], 403);
        }

        if ($phong->trang_thai === 'bao_tri') {
            return response()->json(['error' => 'Phòng đang bảo trì, không thể tạo hợp đồng'], 400);
        }

        DB::beginTransaction();
        try {
            $file = $request->file('file_hop_dong');
            if (!$file || !$file->isValid()) {
                return response()->json(['error' => 'Tệp hợp đồng không hợp lệ hoặc bị lỗi khi tải lên.'], 422);
            }

            $filePath = $file->store('hop_dong_files', 'public');

            $hopDongId = DB::table('hop_dong')->insertGetId([
                'phong_id' => $validated['phong_id'],
                'khach_thue_id' => $validated['khach_thue_id'],
                'ngay_bat_dau' => $validated['ngay_bat_dau'],
                'ngay_ket_thuc' => $validated['ngay_ket_thuc'],
                'tien_coc' => $validated['tien_coc'] ?? 0,
                'ghi_chu' => $request->input('ghi_chu'),
                'trang_thai' => 'hieu_luc',
                'url_file_hop_dong' => $filePath,
                'ngay_tao' => now(),
            ]);

            // ✅ Lưu người thân (nếu có)
            if ($request->filled('nguoi_than')) {
                $nguoiThanList = is_string($request->input('nguoi_than'))
                    ? json_decode($request->input('nguoi_than'), true)
                    : $request->input('nguoi_than');
                if (is_array($nguoiThanList)) {
                    foreach ($nguoiThanList as $nt) {
                        DB::table('nguoi_than')->insert([
                            'khach_thue_id' => $validated['khach_thue_id'],
                            'ho_ten' => $nt['ho_ten'] ?? null,
                            'so_dien_thoai' => $nt['so_dien_thoai'] ?? null,
                            'moi_quan_he' => $nt['moi_quan_he'] ?? null,
                        ]);
                    }
                }
            }

            // ✅ Cập nhật trạng thái yêu cầu thuê nếu có
            if (!empty($validated['yeu_cau_thue_id'])) {
                DB::table('yeu_cau_thue')
                    ->where('id', $validated['yeu_cau_thue_id'])
                    ->update(['trang_thai' => 'da_tao_hop_dong']);
            }

            DB::table('phong')->where('id', $validated['phong_id'])->update(['trang_thai' => 'da_thue']);

            DB::commit();

            return response()->json([
                'message' => 'Tạo hợp đồng thành công',
                'id' => $hopDongId,
            ], 201);

        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('❌ Lỗi tạo hợp đồng', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return response()->json(['error' => 'Không thể tạo hợp đồng: ' . $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        try {
            $hopdong = DB::table('hop_dong')
                ->join('phong', 'hop_dong.phong_id', '=', 'phong.id')
                ->join('day_tro', 'phong.day_tro_id', '=', 'day_tro.id')
                ->join('khach_thue', 'hop_dong.khach_thue_id', '=', 'khach_thue.id')
                ->join('nguoi_dung', 'khach_thue.nguoi_dung_id', '=', 'nguoi_dung.id')
                ->select([
                    'hop_dong.id',
                    'hop_dong.phong_id',
                    'hop_dong.khach_thue_id',
                    'phong.so_phong',
                    'day_tro.ten_day_tro',
                    'nguoi_dung.ho_ten as khach_thue',
                    'nguoi_dung.so_dien_thoai',
                    'nguoi_dung.email',
                    'hop_dong.ngay_bat_dau',
                    'hop_dong.ngay_ket_thuc',
                    'hop_dong.tien_coc',
                    'hop_dong.ghi_chu',
                    'hop_dong.trang_thai',
                    'hop_dong.url_file_hop_dong',
                    'hop_dong.ngay_tao'
                ])
                ->where('hop_dong.id', $id)
                ->first();

            if (!$hopdong) {
                return response()->json(['error' => 'Không tìm thấy hợp đồng'], 404);
            }

            $hopdong->ngay_bat_dau = Carbon::parse($hopdong->ngay_bat_dau)->format('Y-m-d');
            $hopdong->ngay_ket_thuc = Carbon::parse($hopdong->ngay_ket_thuc)->format('Y-m-d');
            $hopdong->ngay_tao = Carbon::parse($hopdong->ngay_tao)->format('Y-m-d H:i:s');

            // 👨‍👩‍👧 Người thân
            $hopdong->nguoi_than = DB::table('nguoi_than')
                ->where('khach_thue_id', $hopdong->khach_thue_id)
                ->select('ho_ten', 'so_dien_thoai', 'moi_quan_he')
                ->get();

            // 🪪 Lấy CCCD từ yêu cầu thuê gần nhất
            $yc = DB::table('yeu_cau_thue')
                ->where('khach_thue_id', $hopdong->khach_thue_id)
                ->where('phong_id', $hopdong->phong_id)
                ->whereIn('trang_thai', ['chap_nhan', 'da_tao_hop_dong'])
                ->orderByDesc('ngay_tao')
                ->first();

            $hopdong->cccd = $yc->cccd ?? null;

            return response()->json($hopdong, 200);
        } catch (\Throwable $e) {
            Log::error('💥 Lỗi khi lấy hợp đồng: ' . $e->getMessage());
            return response()->json(['error' => 'Lỗi máy chủ: ' . $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'phong_id' => 'required|exists:phong,id',
            'khach_thue_id' => 'required|exists:khach_thue,id',
            'ngay_bat_dau' => 'required|date',
            'ngay_ket_thuc' => 'required|date|after:ngay_bat_dau',
            'tien_coc' => 'required|numeric|min:0',
            'ghi_chu' => 'nullable|string|max:1000',
            'file_hop_dong' => 'nullable|file|mimes:pdf|max:4096',
        ]);

        DB::beginTransaction();
        try {
            $hopdong = DB::table('hop_dong')->find($id);
            if (!$hopdong) {
                return response()->json(['error' => 'Không tìm thấy hợp đồng'], 404);
            }

            $phong = DB::table('phong')->find($validated['phong_id']);
            if ($phong && $phong->trang_thai === 'bao_tri') {
                return response()->json(['error' => 'Phòng đang bảo trì, không thể gán hợp đồng'], 400);
            }

            $filePath = $hopdong->url_file_hop_dong;
            if ($request->hasFile('file_hop_dong')) {
                if ($filePath && Storage::disk('public')->exists($filePath)) {
                    Storage::disk('public')->delete($filePath);
                }
                $filePath = $request->file('file_hop_dong')->store('hop_dong_files', 'public');
            }

            DB::table('hop_dong')->where('id', $id)->update([
                'phong_id' => $validated['phong_id'],
                'khach_thue_id' => $validated['khach_thue_id'],
                'ngay_bat_dau' => $validated['ngay_bat_dau'],
                'ngay_ket_thuc' => $validated['ngay_ket_thuc'],
                'tien_coc' => $validated['tien_coc'],
                'ghi_chu' => $request->input('ghi_chu'),
                'url_file_hop_dong' => $filePath,
                'ngay_cap_nhat' => now(),
            ]);

            DB::table('phong')->where('id', $validated['phong_id'])->update(['trang_thai' => 'da_thue']);

            DB::commit();

            return response()->json(['message' => 'Cập nhật hợp đồng thành công']);
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Lỗi cập nhật hợp đồng: ' . $e->getMessage());
            return response()->json(['error' => 'Không thể cập nhật hợp đồng: ' . $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $hopdong = DB::table('hop_dong')->find($id);
            if (!$hopdong)
                return response()->json(['error' => 'Không tìm thấy hợp đồng'], 404);

            if ($hopdong->url_file_hop_dong && Storage::disk('public')->exists($hopdong->url_file_hop_dong)) {
                Storage::disk('public')->delete($hopdong->url_file_hop_dong);
            }

            DB::table('phong')->where('id', $hopdong->phong_id)->update(['trang_thai' => 'trong']);

            $yeuCau = DB::table('yeu_cau_thue')
                ->where('khach_thue_id', $hopdong->khach_thue_id)
                ->where('phong_id', $hopdong->phong_id)
                ->where('trang_thai', 'da_tao_hop_dong')
                ->orderByDesc('ngay_tao')
                ->first();

            if ($yeuCau) {
                DB::table('yeu_cau_thue')
                    ->where('id', $yeuCau->id)
                    ->update(['trang_thai' => 'chu_tro_huy_hop_dong']);
            }

            $khach = DB::table('khach_thue')
                ->join('nguoi_dung', 'nguoi_dung.id', '=', 'khach_thue.nguoi_dung_id')
                ->where('khach_thue.id', $hopdong->khach_thue_id)
                ->select('nguoi_dung.id as nguoi_dung_id', 'nguoi_dung.ho_ten')
                ->first();

            if ($khach) {
                DB::table('thong_bao')->insert([
                    'nguoi_nhan_id' => $khach->nguoi_dung_id,
                    'noi_dung' => "Chủ trọ đã xóa hợp đồng thuê của bạn cho phòng {$hopdong->phong_id}.",
                    'lien_ket' => '/khach-thue/hop-dong',
                    'da_xem' => 0,
                    'ngay_tao' => now(),
                ]);
            }

            DB::table('hop_dong')->where('id', $id)->delete();

            DB::commit();
            return response()->json(['message' => 'Xóa hợp đồng thành công, khách thuê đã được thông báo.']);
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Lỗi xóa hợp đồng: ' . $e->getMessage());
            return response()->json(['error' => 'Không thể xóa hợp đồng'], 500);
        }
    }
}
