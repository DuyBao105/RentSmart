@extends('admin.layout')

@section('title', 'Admin — Quản lý Bài viết')

@section('content')
<div class="space-y-6">
  {{-- Header --}}
  <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-2 border-b border-[#E5E3DC] dark:border-[#282D2A]">
    <div>
      <div class="inline-flex items-center gap-2 px-2.5 py-1 rounded-full bg-[#1B3D2F]/10 dark:bg-[#244B3B]/30 text-[#1B3D2F] dark:text-[#A3E635] text-xs font-semibold mb-2">
        <i class="ri-article-line"></i> Kho Dữ liệu & Xuất bản
      </div>
      <h1 class="text-2xl sm:text-3xl font-serif font-bold text-[#171A19] dark:text-[#FAF9F6] tracking-tight">
        Quản Lý Toàn Bộ Bài Viết
      </h1>
      <p class="text-xs sm:text-sm text-[#5A605B] dark:text-[#9EA39E] mt-1 font-sans">
        Theo dõi trạng thái niêm yết, kiểm duyệt và thông tin phòng trọ trên toàn hệ thống.
      </p>
    </div>
  </div>

  {{-- Filter Console --}}
  <form method="GET" action="{{ route('admin.posts') }}" class="bg-white dark:bg-[#1E2320] p-4 sm:p-5 rounded-2xl shadow-sm border border-[#E5E3DC] dark:border-[#2D332F]">
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3.5">
      <div>
        <label class="text-xs font-semibold uppercase tracking-wider text-[#5A605B] dark:text-[#9EA39E] block mb-1.5">Từ khóa tìm kiếm</label>
        <div class="relative">
          <i class="ri-search-line absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
          <input type="text" name="q" value="{{ request()->get('q') }}" class="w-full bg-[#FAF9F6] dark:bg-[#282D2A] border border-[#E5E3DC] dark:border-[#343B36] rounded-xl pl-9 pr-3.5 py-2 text-xs sm:text-sm text-[#171A19] dark:text-white focus:outline-none focus:ring-1 focus:ring-[#1B3D2F]" placeholder="Tiêu đề, mô tả, số phòng...">
        </div>
      </div>

      <div>
        <label class="text-xs font-semibold uppercase tracking-wider text-[#5A605B] dark:text-[#9EA39E] block mb-1.5">Chủ trọ / Đối tác</label>
        <select name="chu_tro" class="w-full bg-[#FAF9F6] dark:bg-[#282D2A] border border-[#E5E3DC] dark:border-[#343B36] rounded-xl px-3.5 py-2 text-xs sm:text-sm text-[#171A19] dark:text-white focus:outline-none focus:ring-1 focus:ring-[#1B3D2F]">
          <option value="">— Tất cả chủ trọ —</option>
          @if(isset($owners))
            @foreach($owners as $owner)
              <option value="{{ $owner->id }}" {{ (string)request()->get('chu_tro') === (string)$owner->id ? 'selected' : '' }}>
                {{ $owner->ho_ten }}
              </option>
            @endforeach
          @endif
        </select>
      </div>

      <div>
        <label class="text-xs font-semibold uppercase tracking-wider text-[#5A605B] dark:text-[#9EA39E] block mb-1.5">Địa chỉ / Khu vực</label>
        <select name="dia_chi" class="w-full bg-[#FAF9F6] dark:bg-[#282D2A] border border-[#E5E3DC] dark:border-[#343B36] rounded-xl px-3.5 py-2 text-xs sm:text-sm text-[#171A19] dark:text-white focus:outline-none focus:ring-1 focus:ring-[#1B3D2F]">
          <option value="">— Tất cả khu vực —</option>
          @if(isset($regions))
            @foreach($regions as $r)
              <option value="{{ $r->ten_dia_chi }}" {{ request()->get('dia_chi') === $r->ten_dia_chi ? 'selected' : '' }}>
                {{ $r->ten_dia_chi }}
              </option>
            @endforeach
          @endif
        </select>
      </div>

      <div>
        <label class="text-xs font-semibold uppercase tracking-wider text-transparent block mb-1.5">Thao tác</label>
        <div class="flex items-center gap-2">
          <button type="submit" class="flex-1 px-4 py-2 bg-[#1B3D2F] hover:bg-[#244B3B] text-white text-xs sm:text-sm font-medium rounded-xl transition shadow-xs flex items-center justify-center gap-1.5">
            <i class="ri-filter-3-line"></i>
            <span>Lọc tin</span>
          </button>
          <a href="{{ route('admin.posts') }}" class="px-3.5 py-2 border border-[#E5E3DC] dark:border-[#2D332F] rounded-xl text-xs font-medium text-[#5A605B] dark:text-[#9EA39E] hover:text-[#171A19] dark:hover:text-white bg-[#FAF9F6] dark:bg-[#282D2A] transition">
            Reset
          </a>
        </div>
      </div>
    </div>
  </form>

  {{-- Notices --}}
  @if(isset($error))
    <div class="p-4 bg-rose-50 dark:bg-rose-950/40 border border-rose-200 dark:border-rose-800 rounded-xl text-rose-800 dark:text-rose-300 text-xs sm:text-sm font-medium flex items-center gap-2">
      <i class="ri-error-warning-fill text-rose-600 text-base"></i>
      <strong>Lỗi:</strong> {{ $error }}
    </div>
  @endif

  @if(session('success'))
    <div class="p-4 bg-emerald-50 dark:bg-emerald-950/40 border border-emerald-200 dark:border-emerald-800 rounded-xl text-emerald-800 dark:text-emerald-300 text-xs sm:text-sm font-medium flex items-center gap-2">
      <i class="ri-checkbox-circle-fill text-emerald-600 text-base"></i>
      {{ session('success') }}
    </div>
  @endif

  {{-- Master Posts Table --}}
  <div class="bg-white dark:bg-[#1E2320] rounded-2xl shadow-sm border border-[#E5E3DC] dark:border-[#2D332F] overflow-hidden">
    <div class="overflow-x-auto">
      <table class="min-w-full divide-y divide-[#E5E3DC] dark:divide-[#282D2A]">
        <thead class="bg-[#FAF9F6] dark:bg-[#282D2A]/60">
          <tr>
            <th class="px-5 py-3.5 text-left text-xs font-semibold uppercase tracking-wider text-[#5A605B] dark:text-[#9EA39E]">Tiêu đề bài đăng</th>
            <th class="px-5 py-3.5 text-left text-xs font-semibold uppercase tracking-wider text-[#5A605B] dark:text-[#9EA39E]">Người đăng</th>
            <th class="px-5 py-3.5 text-left text-xs font-semibold uppercase tracking-wider text-[#5A605B] dark:text-[#9EA39E]">Địa chỉ dãy trọ</th>
            <th class="px-5 py-3.5 text-left text-xs font-semibold uppercase tracking-wider text-[#5A605B] dark:text-[#9EA39E]">Trạng thái</th>
            <th class="px-5 py-3.5 text-right text-xs font-semibold uppercase tracking-wider text-[#5A605B] dark:text-[#9EA39E]">Thao tác</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-[#E5E3DC] dark:divide-[#282D2A] text-xs sm:text-sm">
          @if(isset($posts) && isset($posts['data']) && count($posts['data']) > 0)
            @foreach ($posts['data'] as $post)
            <tr class="hover:bg-[#FAF9F6]/60 dark:hover:bg-[#282D2A]/40 transition">
              <td class="px-5 py-4">
                <a href="{{ route('admin.posts.show', $post['id']) }}" class="font-medium text-[#171A19] dark:text-white hover:text-[#1B3D2F] dark:hover:text-[#A3E635] block transition">
                  {{ $post['tieu_de'] ?? 'N/A' }}
                </a>
                <span class="text-[11px] text-[#5A605B] dark:text-[#9EA39E] mt-0.5 block">
                  ID: #{{ $post['id'] ?? '—' }}
                </span>
              </td>
              <td class="px-5 py-4 text-[#171A19] dark:text-white font-medium">
                {{ $post['tac_gia'] ?? 'N/A' }}
              </td>
              <td class="px-5 py-4 text-[#5A605B] dark:text-[#9EA39E] max-w-xs truncate">
                {{ $post['dia_chi'] ?? ($post['phong']['day_tro']['dia_chi'] ?? 'N/A') }}
              </td>
              <td class="px-5 py-4">
                @php
                  $st = $post['trang_thai'] ?? '';
                  $statusClass = match($st) {
                    'nhap' => 'bg-gray-100 text-gray-700 border-gray-200 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-700',
                    'cho_duyet' => 'bg-amber-50 text-amber-800 border-amber-200 dark:bg-amber-950/40 dark:text-amber-400 dark:border-amber-800',
                    'dang' => 'bg-emerald-50 text-emerald-800 border-emerald-200 dark:bg-emerald-950/40 dark:text-emerald-400 dark:border-emerald-800',
                    'an' => 'bg-gray-100 text-gray-700 border-gray-200 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-700',
                    'tu_choi' => 'bg-rose-50 text-rose-800 border-rose-200 dark:bg-rose-950/40 dark:text-rose-400 dark:border-rose-800',
                    'da_cho_thue' => 'bg-blue-50 text-blue-800 border-blue-200 dark:bg-blue-950/40 dark:text-blue-400 dark:border-blue-800',
                    default => 'bg-[#FAF9F6] text-[#5A605B] border-[#E5E3DC] dark:bg-[#282D2A] dark:text-[#9EA39E] dark:border-[#343B36]'
                  };
                  $statusText = match($st) {
                    'nhap' => 'Bản nháp',
                    'cho_duyet' => 'Chờ duyệt',
                    'dang' => 'Đang hiển thị',
                    'an' => 'Tạm ẩn',
                    'tu_choi' => 'Từ chối',
                    'da_cho_thue' => 'Đã thuê',
                    default => ucfirst($st ?: 'N/A')
                  };
                @endphp
                <span class="inline-block px-2.5 py-1 rounded-full text-xs font-medium border {{ $statusClass }}">
                  {{ $statusText }}
                </span>
              </td>
              <td class="px-5 py-4 text-right whitespace-nowrap">
                <div class="inline-flex items-center gap-1.5">
                  <a href="{{ route('admin.posts.show', $post['id']) }}" class="view-link force-nav px-3 py-1.5 rounded-lg border border-[#E5E3DC] dark:border-[#2D332F] text-xs font-medium text-[#5A605B] dark:text-[#9EA39E] hover:text-[#171A19] dark:hover:text-white hover:bg-[#FAF9F6] dark:hover:bg-[#282D2A] transition" data-no-ajax="true" target="_self">
                    Xem chi tiết
                  </a>
                  <form method="POST" action="{{ route('admin.posts.delete', $post['id']) }}" class="inline" onsubmit="return confirm('Bạn chắc chắn muốn xóa bài viết này?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-3 py-1.5 rounded-lg border border-rose-200 dark:border-rose-900 bg-rose-50 hover:bg-rose-100 text-rose-700 dark:bg-rose-950/40 dark:hover:bg-rose-900/50 dark:text-rose-300 text-xs font-medium transition">
                      Xóa
                    </button>
                  </form>
                </div>
              </td>
            </tr>
            @endforeach
          @else
            <tr>
              <td colspan="5" class="px-5 py-12 text-center text-[#5A605B] dark:text-[#9EA39E]">
                <div class="w-12 h-12 rounded-2xl bg-[#FAF9F6] dark:bg-[#282D2A] text-gray-400 grid place-items-center mx-auto mb-3 text-2xl">
                  <i class="ri-folder-open-line"></i>
                </div>
                <p class="font-medium text-[#171A19] dark:text-white">Không tìm thấy bài viết nào phù hợp</p>
                <p class="text-xs text-[#5A605B] dark:text-[#9EA39E] mt-1">Thử thay đổi từ khóa tìm kiếm hoặc bỏ bộ lọc.</p>
              </td>
            </tr>
          @endif
        </tbody>
      </table>
    </div>

    {{-- Pagination --}}
    @if(isset($posts) && isset($posts['total']) && $posts['total'] > 0)
      <div class="px-5 py-3.5 border-t border-[#E5E3DC] dark:border-[#282D2A] bg-[#FAF9F6]/50 dark:bg-[#282D2A]/30">
        <div class="flex flex-col sm:flex-row items-center justify-between gap-3 text-xs">
          <div class="text-[#5A605B] dark:text-[#9EA39E]">
            Hiển thị <strong class="text-[#171A19] dark:text-white">{{ count($posts['data']) }}</strong> / <strong class="text-[#171A19] dark:text-white">{{ $posts['total'] }}</strong> bài viết
          </div>
          @if(isset($posts['current_page']) && isset($posts['last_page']))
            <div class="flex items-center gap-2">
              @if($posts['current_page'] > 1)
                <a href="{{ request()->fullUrlWithQuery(['page' => $posts['current_page'] - 1]) }}" class="px-3 py-1.5 border border-[#E5E3DC] dark:border-[#2D332F] rounded-lg text-xs font-medium text-[#171A19] dark:text-white bg-white dark:bg-[#1E2320] hover:bg-[#FAF9F6] transition">« Trước</a>
              @else
                <button class="px-3 py-1.5 border border-[#E5E3DC] dark:border-[#2D332F] rounded-lg text-xs font-medium text-gray-300 dark:text-gray-600 bg-gray-50 dark:bg-gray-800/50 cursor-not-allowed" disabled>« Trước</button>
              @endif

              <span class="text-xs text-[#5A605B] dark:text-[#9EA39E] px-2 font-medium">Trang {{ $posts['current_page'] }} / {{ $posts['last_page'] }}</span>

              @if($posts['current_page'] < $posts['last_page'])
                <a href="{{ request()->fullUrlWithQuery(['page' => $posts['current_page'] + 1]) }}" class="px-3 py-1.5 border border-[#E5E3DC] dark:border-[#2D332F] rounded-lg text-xs font-medium text-[#171A19] dark:text-white bg-white dark:bg-[#1E2320] hover:bg-[#FAF9F6] transition">Sau »</a>
              @else
                <button class="px-3 py-1.5 border border-[#E5E3DC] dark:border-[#2D332F] rounded-lg text-xs font-medium text-gray-300 dark:text-gray-600 bg-gray-50 dark:bg-gray-800/50 cursor-not-allowed" disabled>Sau »</button>
              @endif
            </div>
          @endif
        </div>
      </div>
    @endif
  </div>
</div>

<script>
  (function(){
    function forceNavHandler(e) {
      try {
        var el = e.target.closest && e.target.closest('.force-nav');
        if (!el) return;
        var href = el.getAttribute('href');
        if (!href) return;
        e.preventDefault();
        e.stopImmediatePropagation();
        setTimeout(function(){ window.location.href = href; }, 10);
      } catch(err) { console.debug('forceNav error', err); }
    }

    document.addEventListener('click', forceNavHandler, true);
  })();
</script>
@endsection
