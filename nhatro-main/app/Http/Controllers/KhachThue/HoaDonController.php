<?php

namespace App\Http\Controllers\KhachThue;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class HoaDonController extends Controller
{
    protected string $apiUrl;

    public function __construct()
    {
        $this->apiUrl = rtrim(env('API_URL', 'http://127.0.0.1:8000/api'), '/');
    }

    /**
     * 🔹 Danh sách hóa đơn của khách thuê đang đăng nhập
     */
    public function index()
    {
        $token = session('api_token');

        if (!$token) {
            return redirect()->route('login')->with('error', 'Vui lòng đăng nhập lại.');
        }

        try {
            $response = Http::withToken($token)->get("{$this->apiUrl}/khach-thue/hoa-don");

            if ($response->unauthorized()) {
                session()->forget('api_token');
                return redirect()->route('login')->with('error', 'Phiên đăng nhập đã hết hạn.');
            }

            if ($response->failed()) {
                Log::error('❌ Lỗi khi gọi API danh sách hóa đơn khách thuê', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);
                return back()->with('error', 'Không thể tải danh sách hóa đơn.');
            }

            $data = $response->json();
            $hoaDon = $data['data'] ?? [];

            // Đảm bảo luôn là mảng
            if (!is_array($hoaDon)) {
                $hoaDon = json_decode(json_encode($hoaDon), true) ?? [];
            }

            return view('khachthue.hoadon.index', compact('hoaDon'));
        } catch (\Throwable $e) {
            Log::error('❌ Lỗi kết nối API hóa đơn khách thuê', [
                'error' => $e->getMessage()
            ]);
            return back()->with('error', 'Không thể kết nối đến máy chủ.');
        }
    }
    public function show($id)
    {
        $token = session('api_token');

        if (!$token) {
            return redirect()->route('login')->with('error', 'Vui lòng đăng nhập lại.');
        }

        try {
            $response = Http::withToken($token)->get("{$this->apiUrl}/khach-thue/hoa-don/{$id}");

            if ($response->unauthorized()) {
                session()->forget('api_token');
                return redirect()->route('login')->with('error', 'Phiên đăng nhập đã hết hạn.');
            }

            if ($response->failed()) {
                Log::error("❌ Lỗi tải chi tiết hóa đơn #{$id}", [
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);
                return back()->with('error', 'Không thể tải thông tin hóa đơn.');
            }

            $chiTiet = $response->json();

            // ✅ Đảm bảo dữ liệu chu_tro luôn có đầy đủ thông tin ngân hàng
            if (isset($chiTiet['chu_tro'])) {
                $chuTro = $chiTiet['chu_tro'];
                $chiTiet['chu_tro'] = [
                    'ho_ten' => $chuTro['ho_ten'] ?? 'Chưa cập nhật',
                    'so_dien_thoai' => $chuTro['so_dien_thoai'] ?? 'Chưa cập nhật',
                    'bank_code' => $chuTro['bank_code'] ?? 'MB',
                    'account_no' => $chuTro['account_no'] ?? '0000000000',
                    'account_name' => strtoupper($chuTro['account_name'] ?? $chuTro['ho_ten'] ?? 'TEN CHU TRO'),
                ];
            }

            return view('khachthue.hoadon.show', compact('chiTiet'));

        } catch (\Throwable $e) {
            Log::error("❌ Lỗi khi kết nối đến API hóa đơn #{$id}", [
                'error' => $e->getMessage()
            ]);
            return back()->with('error', 'Không thể kết nối đến máy chủ.');
        }
    }

}
