@extends('admin.layout')

@section('title', 'Admin — Quản lý Phân quyền')

@section('content')
<div class="space-y-6">
  {{-- Header --}}
  <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-2 border-b border-[#E5E3DC] dark:border-[#282D2A]">
    <div>
      <div class="inline-flex items-center gap-2 px-2.5 py-1 rounded-full bg-[#1B3D2F]/10 dark:bg-[#244B3B]/30 text-[#1B3D2F] dark:text-[#A3E635] text-xs font-semibold mb-2">
        <i class="ri-shield-keyhole-line"></i> Ma trận Đặc quyền & Quyền hạn
      </div>
      <h1 class="text-2xl sm:text-3xl font-serif font-bold text-[#171A19] dark:text-[#FAF9F6] tracking-tight">
        Quản Lý Phân Quyền
      </h1>
      <p class="text-xs sm:text-sm text-[#5A605B] dark:text-[#9EA39E] mt-1 font-sans">
        Thiết lập phạm vi thao tác và phân quyền chi tiết cho từng nhóm vai trò trên hệ thống.
      </p>
    </div>
  </div>

  <div class="bg-white dark:bg-[#1E2320] rounded-2xl shadow-sm border border-[#E5E3DC] dark:border-[#2D332F] p-6">
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5">
      @foreach ([
        ['role' => 'Quản trị viên (Admin)', 'key' => 'admin', 'perms' => ['duyet_bai', 'quan_ly_tai_khoan', 'quan_ly_khu_vuc', 'xem_thong_ke']],
        ['role' => 'Chủ trọ / Đối tác', 'key' => 'chutro', 'perms' => ['tao_bai_viet', 'sua_bai_viet', 'quan_ly_hop_dong', 'thu_tien_phong']],
        ['role' => 'Khách thuê phòng', 'key' => 'khachthue', 'perms' => ['xem_bai_viet', 'gui_yeu_cau_thue', 'xem_hop_dong', 'danh_gia_phong']],
      ] as $r)
      <div class="border border-[#E5E3DC] dark:border-[#2D332F] rounded-2xl p-5 bg-[#FAF9F6]/40 dark:bg-[#282D2A]/30">
        <div class="flex items-center justify-between mb-3 pb-3 border-b border-[#E5E3DC] dark:border-[#282D2A]">
          <span class="font-serif font-bold text-sm text-[#171A19] dark:text-white">{{ $r['role'] }}</span>
          <span class="text-[11px] font-mono uppercase px-2 py-0.5 rounded bg-white dark:bg-[#1E2320] border border-[#E5E3DC] dark:border-[#343B36] text-[#5A605B] dark:text-[#9EA39E]">{{ $r['key'] }}</span>
        </div>
        <div class="flex flex-wrap gap-1.5 mb-4">
          @foreach ($r['perms'] as $p)
            <span class="px-2.5 py-1 rounded-lg bg-white dark:bg-[#1E2320] border border-[#E5E3DC] dark:border-[#343B36] text-[#1B3D2F] dark:text-[#A3E635] text-xs font-mono">
              {{ $p }}
            </span>
          @endforeach
        </div>
        <div class="flex items-center gap-2 pt-2 border-t border-[#E5E3DC] dark:border-[#282D2A]">
          <button type="button" class="px-3 py-1.5 rounded-lg border border-[#E5E3DC] dark:border-[#2D332F] text-xs font-medium text-[#5A605B] dark:text-[#9EA39E] hover:text-[#171A19] dark:hover:text-white bg-white dark:bg-[#1E2320] transition">
            Chỉnh sửa
          </button>
        </div>
      </div>
      @endforeach
    </div>
  </div>
</div>
@endsection
