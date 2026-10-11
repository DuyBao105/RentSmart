<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\BaiDang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BaiDangDuyetController extends Controller
{
    /** 📋 Danh sách bài cần duyệt */
    public function pending(Request $request)
    {
        // Support simple filtering and pagination for the admin UI.
        $perPage = (int) $request->get('per_page', 15);

        // Build base query: pending posts only
        $query = BaiDang::with(['anh', 'phong.dayTro', 'chuTro'])
            ->where('trang_thai', 'cho_duyet');

        // Filter by owner (chu_tro) if supplied — match owner name or email
        $owner = trim((string) $request->get('chu_tro', ''));
        if ($owner !== '') {
            $query->whereHas('chuTro', function ($q4) use ($owner) {
                $q4->where('ho_ten', 'like', "%{$owner}%")
                   ->orWhere('email', 'like', "%{$owner}%");
            });
        }

        // If the UI requested a specific district, apply that filter (dia_chi)
        if ($request->filled('dia_chi')) {
            $diaChi = trim((string) $request->get('dia_chi'));
            if ($diaChi !== '') {
                // The district ('dia_chi') is stored on the related day_tro record.
                // Use nested whereHas on phong.dayTro to match the correct column.
                $query->whereHas('phong.dayTro', function ($q2) use ($diaChi) {
                    $q2->where('dia_chi', 'like', "%{$diaChi}%");
                });
            }
        }

        // If the UI requests suspected spam only, try a simple heuristic:
        // - duplicate titles among pending posts
        // - or multiple posts from the same user
        if ((int) $request->get('suspected', 0) === 1) {
            // find duplicate titles and duplicate user ids within pending posts
            $dupTitles = BaiDang::select('tieu_de')
                ->where('trang_thai', 'cho_duyet')
                ->groupBy('tieu_de')
                ->havingRaw('COUNT(*) > 1')
                ->pluck('tieu_de')
                ->filter()
                ->toArray();

            $dupUsers = BaiDang::select('nguoi_dung_id')
                ->where('trang_thai', 'cho_duyet')
                ->groupBy('nguoi_dung_id')
                ->havingRaw('COUNT(*) > 1')
                ->pluck('nguoi_dung_id')
                ->filter()
                ->toArray();

            if (empty($dupTitles) && empty($dupUsers)) {
                // nothing suspected -> return empty paginator
                $posts = (new BaiDang())->newQuery()->whereRaw('0 = 1')->paginate($perPage);
            } else {
                $query->where(function ($q2) use ($dupTitles, $dupUsers) {
                    if (!empty($dupTitles)) {
                        $q2->whereIn('tieu_de', $dupTitles);
                    }
                    if (!empty($dupUsers)) {
                        $q2->orWhereIn('nguoi_dung_id', $dupUsers);
                    }
                });

                $posts = $query->orderByDesc('id')->paginate($perPage);
            }
        } else {
            $posts = $query->orderByDesc('id')->paginate($perPage);
        }

        // Return the paginator as an array so the admin web UI can read `data`, `links`, `total`, etc.
        return response()->json($posts->toArray());
    }

    /** Chi tiết bài (dùng cho admin xem khi duyệt) */
    public function show($id)
    {
        try {
            // Load owner (chuTro) and related dayTro so the admin web UI can render owner, address and related fields.
            $post = BaiDang::with(['anh', 'phong.dayTro', 'chuTro'])->findOrFail($id);

            // Prepare a normalized array to include a couple of display-friendly fields used by the web UI.
            $postArr = $post->toArray();
            $postArr['images'] = $post->anh ?? [];
            // Formatted price and date for convenience in the web UI
            $postArr['gia_hien_thi'] = isset($post->gia_niem_yet) ? number_format($post->gia_niem_yet, 0, ',', '.') . ' đ' : null;
            $postArr['ngay_hien_thi'] = isset($post->ngay_tao) ? $post->ngay_tao->format('d/m/Y') : null;

            return response()->json(['success' => true, 'post' => $postArr, 'images' => $postArr['images']]);
        } catch (\Throwable $e) {
            Log::error('BaiDangDuyetController.show error: ' . $e->getMessage());
            return response()->json(['error' => 'Không thể tải chi tiết bài viết'], 500);
        }
    }

    /** Thống kê cho trang duyệt */
    public function statistics()
    {
        try {
            $totalPending = BaiDang::where('trang_thai', 'cho_duyet')->count();

            // Use ngay_cap_nhat as a proxy for "this month" for approved/rejected actions
            $now = now();
            $approvedThisMonth = BaiDang::where('trang_thai', 'dang')
                ->whereYear('ngay_cap_nhat', $now->year)
                ->whereMonth('ngay_cap_nhat', $now->month)
                ->count();

            $rejectedThisMonth = BaiDang::where('trang_thai', 'tu_choi')
                ->whereYear('ngay_cap_nhat', $now->year)
                ->whereMonth('ngay_cap_nhat', $now->month)
                ->count();

            // Return keys expected by the admin blade (`dang_cho_duyet`, `da_duyet_thang_nay`, `da_tu_choi_thang_nay`)
            return response()->json([
                'dang_cho_duyet' => $totalPending,
                'da_duyet_thang_nay' => $approvedThisMonth,
                'da_tu_choi_thang_nay' => $rejectedThisMonth,
            ]);
        } catch (\Throwable $e) {
            Log::error('BaiDangDuyetController.statistics error: ' . $e->getMessage());
            return response()->json(['error' => 'Không thể lấy thống kê'], 500);
        }
    }

    /** ✅ Duyệt bài */
    public function approve($id)
    {
        try {
            $post = BaiDang::findOrFail($id);

            if ($post->trang_thai !== 'cho_duyet') {
                return response()->json(['error' => 'Bài đăng không ở trạng thái chờ duyệt'], 400);
            }

            $post->update([
                'trang_thai' => 'dang',
                'ngay_duyet' => now(),
            ]);

            return response()->json(['success' => true, 'message' => '✅ Bài đăng đã được duyệt và hiển thị.']);
        } catch (\Throwable $e) {
            Log::error('❌ Lỗi duyệt bài: ' . $e->getMessage());
            return response()->json(['error' => 'Không thể duyệt bài đăng.'], 500);
        }
    }

    /** ❌ Từ chối bài đăng */
    public function reject(Request $request, $id)
    {
        $request->validate([
            'ly_do' => 'nullable|string|max:500',
        ]);

        try {
            $post = BaiDang::findOrFail($id);

            if ($post->trang_thai !== 'cho_duyet') {
                return response()->json(['error' => 'Bài đăng không ở trạng thái chờ duyệt'], 400);
            }

            $post->update([
                'trang_thai' => 'tu_choi',
                'ly_do_tu_choi' => $request->ly_do,
            ]);

            return response()->json(['success' => true, 'message' => '🚫 Đã từ chối bài đăng.']);
        } catch (\Throwable $e) {
            Log::error('❌ Lỗi từ chối bài đăng: ' . $e->getMessage());
            return response()->json(['error' => 'Không thể từ chối bài đăng.'], 500);
        }
    }
}
