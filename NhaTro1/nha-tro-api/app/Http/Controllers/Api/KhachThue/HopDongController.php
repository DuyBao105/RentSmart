<?php

namespace App\Http\Controllers\Api\KhachThue;

use App\Http\Controllers\Controller;
use App\Models\HopDong;
use App\Models\KhachThue;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\PersonalAccessToken;

class HopDongController extends Controller
{
    /**
     * Lấy danh sách hợp đồng của khách thuê đang đăng nhập
     */
    public function index()
    {
        $user = Auth::user();

        $khach = KhachThue::where('nguoi_dung_id', $user->id)->first();

        if (!$khach) {
            return response()->json([
                'message' => 'Không tìm thấy thông tin khách thuê.',
                'data' => []
            ], 200);
        }

        $hopdong = HopDong::where('khach_thue_id', $khach->id)
            ->with(['phong.dayTro'])
            ->orderByDesc('ngay_tao')
            ->get();

        $token = $user->createToken('view_hopdong', ['read'])->plainTextToken;

        foreach ($hopdong as $hd) {
            if (!empty($hd->url_file_hop_dong)) {
                $hd->url_file_hop_dong = url('api/khach-thue/hop-dong/file/' . basename($hd->url_file_hop_dong))
                    . '?token=' . $token;
            }
        }

        return response()->json([
            'message' => 'Danh sách hợp đồng thuê của khách',
            'data' => $hopdong
        ]);
    }


    public function show($id)
    {
        $user = Auth::user();

        $khach = KhachThue::where('nguoi_dung_id', $user->id)->first();

        if (!$khach) {
            return response()->json([
                'message' => 'Không tìm thấy thông tin khách thuê.',
                'data' => null
            ], 404);
        }

        $hopdong = HopDong::where('id', $id)
            ->where('khach_thue_id', $khach->id)
            ->with(['phong.dayTro'])
            ->first();

        if (!$hopdong) {
            return response()->json([
                'message' => 'Không tìm thấy hợp đồng này.',
                'data' => null
            ], 404);
        }

        if (!empty($hopdong->url_file_hop_dong)) {
            $hopdong->url_file_hop_dong = url('api/khach-thue/hop-dong/file/' . basename($hopdong->url_file_hop_dong));
        }

        return response()->json([
            'message' => 'Chi tiết hợp đồng',
            'data' => $hopdong
        ], 200);
    }

}
