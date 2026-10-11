<?php

namespace App\Http\Controllers\Api\ChuTro;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Phong;
use Illuminate\Support\Facades\Auth;
class PhongController extends Controller
{
    /**
     * GET /api/chu-tro/phong
     * → Trả về danh sách phòng của các dãy thuộc chủ trọ hiện tại
     */
    public function index(Request $request)
    {
        $user = $request->user();

        if ($user->vai_tro !== 'chu_tro') {
            return response()->json(['message' => 'Chỉ chủ trọ mới có quyền truy cập.'], 403);
        }

        $phongs = Phong::with('dayTro:id,ten_day_tro')
            ->whereHas('dayTro', fn($q) => $q->where('chu_tro_id', $user->id))
            ->select('id', 'so_phong', 'gia', 'trang_thai', 'day_tro_id', 'dien_tich', 'suc_chua', 'tang')
            ->orderBy('day_tro_id')
            ->orderBy('so_phong')
            ->get()
            ->map(function ($p) {
                return [
                    'id' => $p->id,
                    'so_phong' => $p->so_phong,
                    'gia' => (float) $p->gia,
                    'dien_tich' => (float) $p->dien_tich,
                    'suc_chua' => $p->suc_chua,
                    'tang' => $p->tang,
                    'trang_thai' => $p->trang_thai,
                    'ten_day_tro' => $p->dayTro->ten_day_tro ?? null,
                    'display' => "{$p->dayTro->ten_day_tro} - Phòng {$p->so_phong} (" . number_format($p->gia, 0, ',', '.') . " đ)"
                ];
            });

        return response()->json($phongs);
    }

    /**
     * POST /api/chu-tro/phong
     * → Thêm mới phòng thuộc dãy trọ của chủ trọ hiện tại
     */
    public function store(Request $request)
    {
        $user = $request->user();

        if ($user->vai_tro !== 'chu_tro') {
            return response()->json(['message' => 'Chỉ chủ trọ mới có quyền thêm phòng.'], 403);
        }

        $data = $request->validate([
            'day_tro_id' => 'required|integer|exists:day_tro,id',
            'so_phong' => 'required|string|max:50',
            'gia' => 'required|numeric|min:0',
            'suc_chua' => 'required|integer|min:1',
            'dien_tich' => 'required|numeric|min:1',
            'tang' => 'required|integer|min:0',
        ]);

        // Kiểm tra dãy có thuộc chủ trọ này không
        $isOwn = DB::table('day_tro')
            ->where('id', $data['day_tro_id'])
            ->where('chu_tro_id', $user->id)
            ->exists();

        if (!$isOwn) {
            return response()->json(['message' => 'Bạn không sở hữu dãy trọ này.'], 403);
        }

        $id = DB::table('phong')->insertGetId([
            ...$data,
            'trang_thai' => 'trong',
            'ngay_tao' => now(),
            'ngay_cap_nhat' => now(),
        ]);

        return response()->json([
            'message' => 'Thêm phòng thành công!',
            'data' => DB::table('phong')->find($id)
        ], 201);
    }

    /**
     * GET /api/chu-tro/phong/{id}
     * → Xem chi tiết một phòng thuộc chủ trọ hiện tại
     */
    public function show(Request $request, $id)
    {
        $user = $request->user();

        $p = Phong::with('dayTro')
            ->whereHas('dayTro', fn($q) => $q->where('chu_tro_id', $user->id))
            ->find($id);

        if (!$p) {
            return response()->json(['message' => 'Không tìm thấy phòng hoặc bạn không sở hữu phòng này.'], 404);
        }

        $tienIch = DB::table('phong_tien_ich as pti')
            ->join('tien_ich as t', 't.id', '=', 'pti.tien_ich_id')
            ->where('pti.phong_id', $p->id)
            ->pluck('t.ten');

        return response()->json([
            'id' => $p->id,
            'so_phong' => $p->so_phong,
            'gia' => (float) $p->gia,
            'trang_thai' => $p->trang_thai,
            'dien_tich' => (float) $p->dien_tich,
            'suc_chua' => $p->suc_chua,
            'tang' => $p->tang,
            'ten_day_tro' => $p->dayTro->ten_day_tro ?? null,
            'tien_ich' => $tienIch,
            'ngay_tao' => $p->ngay_tao,
            'ngay_cap_nhat' => $p->ngay_cap_nhat,
        ]);
    }

    /**
     * PUT /api/chu-tro/phong/{id}
     * → Cập nhật thông tin phòng
     */
    public function update(Request $request, $id)
    {
        $user = $request->user();

        $exists = DB::table('phong as p')
            ->join('day_tro as d', 'd.id', '=', 'p.day_tro_id')
            ->where('p.id', $id)
            ->where('d.chu_tro_id', $user->id)
            ->exists();

        if (!$exists) {
            return response()->json(['message' => 'Không tìm thấy phòng hoặc bạn không sở hữu phòng này.'], 404);
        }

        $data = $request->validate([
            'gia' => 'nullable|numeric|min:0',
            'trang_thai' => 'nullable|in:trong,da_thue,bao_tri',
            'dien_tich' => 'nullable|numeric|min:1',
            'suc_chua' => 'nullable|integer|min:1',
            'tang' => 'nullable|integer|min:0',
        ]);

        $data['ngay_cap_nhat'] = now();

        DB::table('phong')->where('id', $id)->update($data);

        return response()->json([
            'message' => 'Cập nhật phòng thành công!',
            'data' => DB::table('phong')->find($id),
        ]);
    }

    /**
     * DELETE /api/chu-tro/phong/{id}
     * → Xoá phòng nếu chưa có hợp đồng
     */
    public function destroy(Request $request, $id)
    {
        $user = $request->user();

        $isOwn = DB::table('phong as p')
            ->join('day_tro as d', 'd.id', '=', 'p.day_tro_id')
            ->where('p.id', $id)
            ->where('d.chu_tro_id', $user->id)
            ->exists();

        if (!$isOwn) {
            return response()->json(['message' => 'Không thể xoá: bạn không sở hữu phòng này.'], 403);
        }

        $hasContract = DB::table('hop_dong')->where('phong_id', $id)->exists();
        if ($hasContract) {
            return response()->json(['message' => 'Phòng đã có hợp đồng, không thể xoá.'], 400);
        }

        DB::table('phong')->where('id', $id)->delete();

        return response()->json(['message' => ' Xoá phòng thành công!']);
    }
    public function danhSachPhongDangSuDung()
    {
        $user = Auth::user();
        if (!$user)
            return response()->json(['message' => 'Chưa đăng nhập'], 401);

        $phongs = Phong::with('dayTro')
            ->whereHas('dayTro', fn($q) => $q->where('chu_tro_id', $user->id))
            ->whereIn('trang_thai', ['da_thue', 'dang_thue'])
            ->orderBy('day_tro_id')
            ->orderBy('so_phong')
            ->get(['id', 'so_phong', 'day_tro_id', 'trang_thai']);

        return response()->json($phongs);
    }

}
