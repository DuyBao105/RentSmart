<?php

namespace App\Http\Controllers\ChuTro;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PhongController extends Controller
{

    public function index(Request $r)
    {
        $chuTroId = session('user')['id'] ?? null;

        $phongs = DB::table('phong')
            ->join('day_tro', 'day_tro.id', '=', 'phong.day_tro_id')
            ->where('day_tro.chu_tro_id', $chuTroId)
            ->select(
                'phong.id',
                'phong.so_phong',
                'phong.gia',
                'phong.trang_thai',
                'phong.suc_chua',
                'phong.dien_tich',
                'phong.tang',
                'day_tro.ten_day_tro',
                'phong.ngay_tao',
                'phong.ngay_cap_nhat'
            )
            ->orderBy('day_tro.ten_day_tro')
            ->orderBy('so_phong')
            ->get();

        return view('chutro.phong.index', compact('phongs'));
    }

    public function create()
    {
        $chuTroId = session('user')['id'] ?? null;

        $dayTros = DB::table('day_tro')
            ->where('chu_tro_id', $chuTroId)
            ->select('id', 'ten_day_tro')
            ->orderBy('ten_day_tro')
            ->get();

        return view('chutro.phong.create', compact('dayTros'));
    }

    public function store(Request $r)
    {
        $chuTroId = session('user')['id'] ?? null;

        // 1️⃣ Validate dữ liệu đầu vào
        $data = $r->validate([
            'day_tro_id' => 'required|integer|exists:day_tro,id',
            'so_phong' => 'required|string|max:50',
            'gia' => 'required|numeric|min:0',
            'trang_thai' => 'nullable|in:trong,da_thue,bao_tri',
            'suc_chua' => 'required|integer|min:1',
            'dien_tich' => 'required|numeric|min:1',
            'tang' => 'required|integer|min:0',
        ]);

        // 2️⃣ Gán giá trị mặc định
        $data['trang_thai'] = $data['trang_thai'] ?? 'trong';
        $data['ngay_tao'] = now();
        $data['ngay_cap_nhat'] = now();

        // 3️⃣ Lưu phòng mới và lấy ID
        $phongId = DB::table('phong')->insertGetId($data);

        // 4️⃣ Tạo đồng hồ điện & nước tự động
        $dongHoDienId = DB::table('dong_ho')->insertGetId([
            'phong_id' => $phongId,
            'dich_vu_id' => 1, // 1 = Điện
            'ma_dong_ho' => 'DH_Dien_' . $data['so_phong'],
        ]);

        $dongHoNuocId = DB::table('dong_ho')->insertGetId([
            'phong_id' => $phongId,
            'dich_vu_id' => 2, // 2 = Nước
            'ma_dong_ho' => 'DH_Nuoc_' . $data['so_phong'],
        ]);

        // 5️⃣ Ghi chỉ số đầu = 0 cho cả hai đồng hồ
        DB::table('chi_so')->insert([
            [
                'dong_ho_id' => $dongHoDienId,
                'thoi_gian' => now(),
                'gia_tri' => 0,
                'ghi_chu' => 'Chỉ số đầu',
                'nguoi_nhap_id' => $chuTroId,
                'ngay_tao' => now(),
            ],
            [
                'dong_ho_id' => $dongHoNuocId,
                'thoi_gian' => now(),
                'gia_tri' => 0,
                'ghi_chu' => 'Chỉ số đầu',
                'nguoi_nhap_id' => $chuTroId,
                'ngay_tao' => now(),
            ],
        ]);

        // 6️⃣ Thông báo thành công
        return redirect()->route('chu-tro.phong.index')
            ->with('success', '✅ Thêm phòng thành công, đã tự tạo đồng hồ điện & nước!');
    }


    public function show($id)
    {
        $phong = DB::table('phong')
            ->join('day_tro', 'day_tro.id', '=', 'phong.day_tro_id')
            ->select(
                'phong.*',
                'day_tro.ten_day_tro',
                'day_tro.dia_chi'
            )
            ->where('phong.id', $id)
            ->first();

        if (!$phong) {
            abort(404, 'Không tìm thấy phòng.');
        }

        $tienIch = DB::table('phong_tien_ich')
            ->join('tien_ich', 'tien_ich.id', '=', 'phong_tien_ich.tien_ich_id')
            ->where('phong_tien_ich.phong_id', $id)
            ->pluck('tien_ich.ten');

        return view('chutro.phong.show', compact('phong', 'tienIch'));
    }

    public function edit($id)
    {
        $chuTroId = session('user')['id'] ?? null;

        $dayTros = DB::table('day_tro')
            ->where('chu_tro_id', $chuTroId)
            ->select('id', 'ten_day_tro')
            ->get();

        $phong = DB::table('phong')->find($id);

        if (!$phong) {
            abort(404, 'Không tìm thấy phòng.');
        }

        return view('chutro.phong.edit', compact('phong', 'dayTros'));
    }

    public function update(Request $r, $id)
    {
        $data = $r->validate([
            'day_tro_id' => 'required|integer|exists:day_tro,id',
            'so_phong' => 'required|string|max:50',
            'gia' => 'required|numeric|min:0',
            'trang_thai' => 'nullable|in:trong,da_thue,bao_tri',
            'suc_chua' => 'required|integer|min:1',
            'dien_tich' => 'required|numeric|min:1',
            'tang' => 'required|integer|min:0',
        ]);

        $data['ngay_cap_nhat'] = Carbon::now();

        DB::table('phong')->where('id', $id)->update($data);

        return redirect()->route('chu-tro.phong.index')
            ->with('success', '✅ Cập nhật thông tin phòng thành công!');
    }

    public function destroy($id)
    {
        $hasContract = DB::table('hop_dong')->where('phong_id', $id)->exists();

        if ($hasContract) {
            return back()->with('error', 'Phòng đã có hợp đồng, không thể xóa.');
        }

        DB::table('phong')->where('id', $id)->delete();

        return redirect()->route('chu-tro.phong.index')
            ->with('success', '🗑️ Đã xóa phòng thành công!');
    }
}
