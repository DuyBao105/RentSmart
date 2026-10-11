<?php

namespace App\Http\Controllers\KhachThue;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use App\Mail\ThongBaoChuTroYeuCauMoi;
use App\Mail\ThongBaoKhachThueChapNhan;
use App\Jobs\GuiThongBaoChuTroYeuCauMoi;
class YeuCauThueController extends Controller
{
    public function index()
    {
        $token = session('api_token');
        $apiUrl = rtrim(env('API_BASE_URL', 'http://127.0.0.1:8000'), '/');

        try {
            $response = Http::withToken($token)->timeout(5)->get("$apiUrl/api/khach-thue/yeu-cau-thue");
            $raw = $response->json('data') ?? $response->json();
            $yeuCauThue = is_array($raw) ? $raw : [];
        } catch (\Throwable $e) {
            \Log::warning('Không thể lấy danh sách yêu cầu thuê: ' . $e->getMessage());
            $yeuCauThue = [];
        }

        return view('khachthue.yeucauthue.index', compact('yeuCauThue'));
    }
    public function create($baiDangId = null)
    {
        $token = session('api_token');
        $apiUrl = rtrim(env('API_BASE_URL', 'http://127.0.0.1:8000'), '/');

        $baiDang = null;
        if ($baiDangId) {
            try {
                $res = Http::withToken($token)->get("$apiUrl/api/bai-dang/{$baiDangId}");
                $baiDang = $res->json('data') ?? $res->json();
            } catch (\Throwable $e) {
                \Log::warning("Không thể load bài đăng #{$baiDangId}: " . $e->getMessage());
            }
        }

        $availableRooms = [];
        try {
            $resRooms = Http::get("$apiUrl/api/bai-dang?per_page=50");
            $availableRooms = $resRooms->json('data') ?? [];
        } catch (\Throwable $e) {}

        $user = session('user') ?? auth()->user();

        return view('khachthue.yeucauthue.create', compact('baiDang', 'availableRooms', 'user'));
    }

    public function store(Request $request)
    {
        $token = session('api_token');
        $apiUrl = rtrim(env('API_BASE_URL', 'http://127.0.0.1:8000'), '/');

        try {
            \Log::info('📨 [WEB] Gửi yêu cầu thuê phòng (v2)', [
                'user_id' => auth()->id(),
                'input' => $request->all(),
            ]);

            $validated = $request->validate([
                'bai_dang_id' => 'required|integer',
                'cccd' => 'required|digits_between:9,12',
                'ngay_bat_dau' => 'required|date',
                'ngay_ket_thuc' => 'required|date|after:ngay_bat_dau',
                'tien_coc' => 'required|numeric|min:0',
                'ghi_chu' => 'nullable|string|max:500',
                'nguoi_than' => 'nullable',
                'file_hop_dong' => 'nullable|file|mimes:pdf|max:4096',
            ]);

            $file = $request->file('file_hop_dong');
            $filePath = ($file && $file->isValid()) ? $file->getRealPath() : public_path('files/hopdong_mau.pdf');
            $fileName = ($file && $file->isValid()) ? $file->getClientOriginalName() : 'hopdong_mau.pdf';

            $nguoiThanContent = '';
            if (!empty($validated['nguoi_than'])) {
                $nguoiThanContent = is_array($validated['nguoi_than'])
                    ? json_encode($validated['nguoi_than'], JSON_UNESCAPED_UNICODE)
                    : (string) $validated['nguoi_than'];
            }

            $response = Http::asMultipart()
                ->withToken($token)
                ->attach(
                    'file_hop_dong',
                    fopen($filePath, 'r'),
                    $fileName
                )
                ->post("$apiUrl/api/khach-thue/yeu-cau-thue", [
                    ['name' => 'bai_dang_id', 'contents' => (string) $validated['bai_dang_id']],
                    ['name' => 'cccd', 'contents' => (string) $validated['cccd']],
                    ['name' => 'ngay_bat_dau', 'contents' => (string) $validated['ngay_bat_dau']],
                    ['name' => 'ngay_ket_thuc', 'contents' => (string) $validated['ngay_ket_thuc']],
                    ['name' => 'tien_coc', 'contents' => (string) $validated['tien_coc']],
                    ['name' => 'ghi_chu', 'contents' => (string) ($validated['ghi_chu'] ?? '')],
                    ['name' => 'nguoi_than', 'contents' => $nguoiThanContent],
                ]);

            if ($response->failed()) {
                $msg = $response->json('error') ?? 'Gửi yêu cầu thuê thất bại.';
                \Log::error('❌ [WEB] API phản hồi lỗi', ['body' => $response->body()]);
                if ($request->expectsJson() || $request->ajax()) {
                    return response()->json(['success' => false, 'error' => $msg], 422);
                }
                return back()->with('error', $msg);
            }

            $data = $response->json('data') ?? [];
            $chuTro = (object) ($data['chu_tro'] ?? []);
            $phong = (object) ($data['phong'] ?? []);
            $dayTro = (object) ($data['phong']['day_tro'] ?? []);
            $khach = (object) session('user');

            if (!empty($chuTro->email)) {
                try {
                    GuiThongBaoChuTroYeuCauMoi::dispatch($chuTro, $khach, $phong, $dayTro);
                } catch (\Throwable $mEx) {
                    \Log::warning('Lỗi gửi mail: ' . $mEx->getMessage());
                }
            }

            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => '✅ Đã gửi yêu cầu thuê phòng thành công!',
                    'redirect' => route('khach-thue.yeu-cau-thue.index')
                ]);
            }

            return redirect()
                ->route('khach-thue.yeu-cau-thue.index')
                ->with('success', '✅ Đã gửi yêu cầu thuê phòng thành công!');

        } catch (\Throwable $e) {
            \Log::error('💥 [WEB] Lỗi khi xử lý yêu cầu thuê', [
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json(['success' => false, 'error' => 'Lỗi máy chủ: ' . $e->getMessage()], 500);
            }
            return back()->with('error', 'Lỗi máy chủ: ' . $e->getMessage());
        }
    }

    public function huy($id)
    {
        $token = session('api_token');
        $apiUrl = rtrim(env('API_BASE_URL', 'http://127.0.0.1:8000'), '/');

        $res = Http::withToken($token)->delete("$apiUrl/api/khach-thue/yeu-cau-thue/{$id}/huy");

        if ($res->failed()) {
            return back()->with('error', $res->json('error') ?? 'Không thể hủy yêu cầu thuê.');
        }

        return back()->with('success', 'Đã hủy yêu cầu thuê thành công!');
    }

}
