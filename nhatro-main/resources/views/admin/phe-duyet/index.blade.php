@extends('admin.layout')

@section('title', 'Admin — Kiểm duyệt Tin đăng')

@section('content')
<div class="space-y-6">
  {{-- Header --}}
  <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-2 border-b border-[#E5E3DC] dark:border-[#282D2A]">
    <div>
      <div class="inline-flex items-center gap-2 px-2.5 py-1 rounded-full bg-amber-50 dark:bg-amber-950/40 text-amber-800 dark:text-amber-300 text-xs font-semibold mb-2">
        <i class="ri-shield-check-line"></i> Kiểm duyệt Nội dung & Bản quyền
      </div>
      <h1 class="text-2xl sm:text-3xl font-serif font-bold text-[#171A19] dark:text-[#FAF9F6] tracking-tight">
        Xét Duyệt Bài Viết
      </h1>
      <p class="text-xs sm:text-sm text-[#5A605B] dark:text-[#9EA39E] mt-1 font-sans">
        Xác minh chất lượng thông tin, kiểm tra hình ảnh thực tế và biểu phí niêm yết trước khi xuất bản.
      </p>
    </div>
  </div>

  {{-- Flash Notices --}}
  @if(session('success'))
    <div class="p-4 bg-emerald-50 dark:bg-emerald-950/40 border border-emerald-200 dark:border-emerald-800 rounded-xl text-emerald-800 dark:text-emerald-300 text-xs sm:text-sm font-medium flex items-center gap-2">
      <i class="ri-checkbox-circle-fill text-emerald-600 text-base"></i>
      {{ session('success') }}
    </div>
  @endif

  @if(session('error'))
    <div class="p-4 bg-rose-50 dark:bg-rose-950/40 border border-rose-200 dark:border-rose-800 rounded-xl text-rose-800 dark:text-rose-300 text-xs sm:text-sm font-medium flex items-center gap-2">
      <i class="ri-error-warning-fill text-rose-600 text-base"></i>
      {{ session('error') }}
    </div>
  @endif

  @if(isset($error))
    <div class="p-4 bg-rose-50 dark:bg-rose-950/40 border border-rose-200 dark:border-rose-800 rounded-xl text-rose-800 dark:text-rose-300 text-xs sm:text-sm font-medium flex items-center gap-2">
      <i class="ri-error-warning-fill text-rose-600 text-base"></i>
      Lỗi khi tải dữ liệu: {{ $error }}
    </div>
  @endif

  {{-- Moderation Statistics --}}
  @if(isset($stats))
  <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
    <div class="motion-reveal motion-stagger-1 card-lift-hover bg-white dark:bg-[#1E2320] p-5 rounded-2xl border border-[#E5E3DC] dark:border-[#2D332F] shadow-sm">
      <div class="flex items-center justify-between">
        <div>
          <p class="text-xs font-medium text-[#5A605B] dark:text-[#9EA39E] uppercase tracking-wider">Đang chờ duyệt</p>
          <p class="text-2xl sm:text-3xl font-serif font-bold text-amber-600 dark:text-amber-400 mt-1">
            <span class="count-up" data-counter="{{ (int)($stats['dang_cho_duyet'] ?? 0) }}">{{ number_format($stats['dang_cho_duyet'] ?? 0) }}</span>
          </p>
        </div>
        <div class="w-10 h-10 rounded-xl bg-amber-50 dark:bg-amber-950/40 text-amber-600 dark:text-amber-400 grid place-items-center">
          <i class="ri-time-line text-xl"></i>
        </div>
      </div>
    </div>
    
    <div class="motion-reveal motion-stagger-2 card-lift-hover bg-white dark:bg-[#1E2320] p-5 rounded-2xl border border-[#E5E3DC] dark:border-[#2D332F] shadow-sm">
      <div class="flex items-center justify-between">
        <div>
          <p class="text-xs font-medium text-[#5A605B] dark:text-[#9EA39E] uppercase tracking-wider">Đã duyệt tháng này</p>
          <p class="text-2xl sm:text-3xl font-serif font-bold text-emerald-700 dark:text-emerald-400 mt-1">
            <span class="count-up" data-counter="{{ (int)($stats['da_duyet_thang_nay'] ?? 0) }}">{{ number_format($stats['da_duyet_thang_nay'] ?? 0) }}</span>
          </p>
        </div>
        <div class="w-10 h-10 rounded-xl bg-emerald-50 dark:bg-emerald-950/40 text-emerald-700 dark:text-emerald-400 grid place-items-center">
          <i class="ri-checkbox-circle-line text-xl"></i>
        </div>
      </div>
    </div>

    <div class="motion-reveal motion-stagger-3 card-lift-hover bg-white dark:bg-[#1E2320] p-5 rounded-2xl border border-[#E5E3DC] dark:border-[#2D332F] shadow-sm">
      <div class="flex items-center justify-between">
        <div>
          <p class="text-xs font-medium text-[#5A605B] dark:text-[#9EA39E] uppercase tracking-wider">Đã từ chối tháng này</p>
          <p class="text-2xl sm:text-3xl font-serif font-bold text-rose-600 dark:text-rose-400 mt-1">
            <span class="count-up" data-counter="{{ (int)($stats['da_tu_choi_thang_nay'] ?? 0) }}">{{ number_format($stats['da_tu_choi_thang_nay'] ?? 0) }}</span>
          </p>
        </div>
        <div class="w-10 h-10 rounded-xl bg-rose-50 dark:bg-rose-950/40 text-rose-600 dark:text-rose-400 grid place-items-center">
          <i class="ri-close-circle-line text-xl"></i>
        </div>
      </div>
    </div>
  </div>
  @endif

  {{-- Filter Toolbar --}}
  <div class="bg-white dark:bg-[#1E2320] p-4 rounded-2xl border border-[#E5E3DC] dark:border-[#2D332F] shadow-sm">
    <form id="approvalsFilterForm" method="GET" class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
      <div class="flex flex-wrap items-center gap-3">
        <div class="relative min-w-[220px]">
          <select name="dia_chi" class="w-full bg-[#FAF9F6] dark:bg-[#282D2A] border border-[#E5E3DC] dark:border-[#343B36] rounded-xl px-3.5 py-2 text-xs sm:text-sm text-[#171A19] dark:text-white focus:outline-none focus:ring-1 focus:ring-[#1B3D2F]">
            <option value="">Tất cả quận/huyện</option>
            @foreach($regions ?? [] as $r)
              <option value="{{ $r->ten_dia_chi }}" {{ request('dia_chi') == $r->ten_dia_chi ? 'selected' : '' }}>
                {{ $r->ten_dia_chi }}
              </option>
            @endforeach
          </select>
        </div>

        <button id="filterBtn" type="button" class="px-4 py-2 bg-[#1B3D2F] hover:bg-[#244B3B] text-white text-xs sm:text-sm font-medium rounded-xl transition shadow-xs flex items-center gap-1.5">
          <i class="ri-filter-3-line"></i>
          <span>Lọc hồ sơ</span>
        </button>

        @if(request('dia_chi'))
          <a href="{{ route('admin.approvals') }}" class="px-3 py-2 text-xs text-[#5A605B] dark:text-[#9EA39E] hover:text-[#171A19] dark:hover:text-white transition">
            Xóa lọc
          </a>
        @endif
      </div>

      <div class="text-xs text-[#5A605B] dark:text-[#9EA39E]">
        Tổng cộng: <strong class="text-[#171A19] dark:text-white font-semibold">{{ $posts['total'] ?? (isset($posts['data']) ? count($posts['data']) : 0) }}</strong> hồ sơ
      </div>
    </form>
  </div>

  {{-- Moderation Queue Table --}}
  <div class="bg-white dark:bg-[#1E2320] rounded-2xl shadow-sm border border-[#E5E3DC] dark:border-[#2D332F] overflow-hidden">
    <div class="overflow-x-auto">
      <table class="min-w-full divide-y divide-[#E5E3DC] dark:divide-[#282D2A]">
        <thead class="bg-[#FAF9F6] dark:bg-[#282D2A]/60">
          <tr>
            <th class="px-5 py-3.5 text-left text-xs font-semibold uppercase tracking-wider text-[#5A605B] dark:text-[#9EA39E]">Tiêu đề tin đăng</th>
            <th class="px-5 py-3.5 text-left text-xs font-semibold uppercase tracking-wider text-[#5A605B] dark:text-[#9EA39E]">Đối tác đăng tin</th>
            <th class="px-5 py-3.5 text-left text-xs font-semibold uppercase tracking-wider text-[#5A605B] dark:text-[#9EA39E]">Thời điểm gửi</th>
            <th class="px-5 py-3.5 text-left text-xs font-semibold uppercase tracking-wider text-[#5A605B] dark:text-[#9EA39E]">Địa chỉ phòng</th>
            <th class="px-5 py-3.5 text-right text-xs font-semibold uppercase tracking-wider text-[#5A605B] dark:text-[#9EA39E]">Thao tác duyệt</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-[#E5E3DC] dark:divide-[#282D2A] text-xs sm:text-sm">
          @if(isset($posts) && isset($posts['data']) && count($posts['data']) > 0)
            @foreach ($posts['data'] as $post)
            <tr class="table-row-hover transition">
              <td class="px-5 py-4">
                <a href="{{ route('admin.approvals.show', $post['id']) }}" class="font-medium text-[#171A19] dark:text-white hover:text-[#1B3D2F] dark:hover:text-[#A3E635] block transition">
                  {{ $post['tieu_de'] ?? 'N/A' }}
                </a>
                <div class="text-xs text-[#5A605B] dark:text-[#9EA39E] mt-0.5 flex items-center gap-1.5">
                  <span class="inline-block px-1.5 py-0.5 rounded bg-[#FAF9F6] dark:bg-[#282D2A] border border-[#E5E3DC] dark:border-[#343B36]">
                    Phòng: {{ $post['so_phong'] ?? 'N/A' }}
                  </span>
                  @if(!empty($post['gia_niem_yet']))
                    <span class="font-semibold text-[#1B3D2F] dark:text-[#A3E635]">
                      {{ number_format($post['gia_niem_yet']) }} đ/tháng
                    </span>
                  @endif
                </div>
              </td>
              <td class="px-5 py-4">
                @php
                  $authorName = $post['tac_gia'] ?? data_get($post, 'chu_tro.ho_ten') ?? data_get($post, 'chuTro.ho_ten') ?? data_get($post, 'nguoi_dung.ho_ten');
                  $authorEmail = $post['email'] ?? data_get($post, 'chu_tro.email') ?? data_get($post, 'chuTro.email') ?? data_get($post, 'nguoi_dung.email');
                @endphp
                <div class="font-medium text-[#171A19] dark:text-white">{{ $authorName ?? 'N/A' }}</div>
                <div class="text-xs text-[#5A605B] dark:text-[#9EA39E]">{{ $authorEmail ?? '' }}</div>
              </td>
              <td class="px-5 py-4 text-[#5A605B] dark:text-[#9EA39E]">
                {{ isset($post['ngay_tao']) ? date('d/m/Y H:i', strtotime($post['ngay_tao'])) : 'N/A' }}
              </td>
              <td class="px-5 py-4">
                <div class="font-medium text-[#171A19] dark:text-white">{{ $post['ten_day_tro'] ?? 'N/A' }}</div>
                <div class="text-xs text-[#5A605B] dark:text-[#9EA39E] truncate max-w-xs">{{ $post['dia_chi'] ?? '' }}</div>
              </td>
              <td class="px-5 py-4 text-right whitespace-nowrap">
                <div class="inline-flex items-center gap-1.5">
                  <a href="{{ route('admin.approvals.show', $post['id']) }}" 
                     class="micro-press px-3 py-1.5 rounded-lg border border-[#E5E3DC] dark:border-[#2D332F] text-xs font-medium text-[#5A605B] dark:text-[#9EA39E] hover:text-[#171A19] dark:hover:text-white hover:bg-[#FAF9F6] dark:hover:bg-[#282D2A] transition">
                    Chi tiết
                  </a>

                  <form method="POST" action="{{ route('admin.approvals.approve', $post['id']) }}" class="inline">
                    @csrf
                    <button type="submit" 
                            onclick="return confirm('Xác nhận phê duyệt và xuất bản bài viết này?')"
                            class="micro-press px-3 py-1.5 rounded-lg bg-[#1B3D2F] hover:bg-[#244B3B] text-white text-xs font-medium transition shadow-xs">
                      <i class="ri-check-line mr-0.5"></i> Duyệt
                    </button>
                  </form>

                  <button type="button"
                          data-post-id="{{ $post['id'] }}" 
                          data-post-title="{{ $post['tieu_de'] }}"
                          class="reject-btn micro-press px-3 py-1.5 rounded-lg bg-rose-50 hover:bg-rose-100 text-rose-700 dark:bg-rose-950/40 dark:hover:bg-rose-900/50 dark:text-rose-300 text-xs font-medium border border-rose-200 dark:border-rose-900 transition">
                    Từ chối
                  </button>
                </div>
              </td>
            </tr>
            @endforeach
          @else
            <tr>
              <td colspan="5" class="px-5 py-12 text-center text-[#5A605B] dark:text-[#9EA39E]">
                <div class="w-12 h-12 rounded-2xl bg-emerald-50 dark:bg-emerald-950/40 text-emerald-600 dark:text-emerald-400 grid place-items-center mx-auto mb-3 text-2xl">
                  <i class="ri-checkbox-circle-line"></i>
                </div>
                <p class="font-medium text-[#171A19] dark:text-white">Không có bài viết nào đang chờ duyệt</p>
                <p class="text-xs text-[#5A605B] dark:text-[#9EA39E] mt-1">Toàn bộ hồ sơ đăng tin đã được xử lý xong.</p>
              </td>
            </tr>
          @endif
        </tbody>
      </table>
    </div>

    {{-- Pagination --}}
    @if(isset($posts['links']) && count($posts['data']) > 0)
    <div class="px-5 py-3.5 border-t border-[#E5E3DC] dark:border-[#282D2A] bg-[#FAF9F6]/50 dark:bg-[#282D2A]/30">
      <div class="flex flex-col sm:flex-row items-center justify-between gap-3">
        <div class="text-xs text-[#5A605B] dark:text-[#9EA39E]">
          Hiển thị <strong class="text-[#171A19] dark:text-white">{{ $posts['from'] ?? 0 }} - {{ $posts['to'] ?? 0 }}</strong> trong tổng số <strong class="text-[#171A19] dark:text-white">{{ $posts['total'] ?? 0 }}</strong> hồ sơ
        </div>
        <div class="flex items-center gap-2">
          @if(isset($posts['current_page']) && $posts['current_page'] > 1)
            <a href="{{ request()->fullUrlWithQuery(['page' => $posts['current_page'] - 1]) }}" class="px-3 py-1.5 border border-[#E5E3DC] dark:border-[#2D332F] rounded-lg text-xs font-medium text-[#171A19] dark:text-white bg-white dark:bg-[#1E2320] hover:bg-[#FAF9F6] transition">« Trước</a>
          @else
            <button class="px-3 py-1.5 border border-[#E5E3DC] dark:border-[#2D332F] rounded-lg text-xs font-medium text-gray-300 dark:text-gray-600 bg-gray-50 dark:bg-gray-800/50 cursor-not-allowed" disabled>« Trước</button>
          @endif

          <span class="text-xs text-[#5A605B] dark:text-[#9EA39E] px-2 font-medium">Trang {{ $posts['current_page'] ?? 1 }} / {{ $posts['last_page'] ?? 1 }}</span>

          @if(isset($posts['current_page']) && $posts['current_page'] < ($posts['last_page'] ?? 1))
            <a href="{{ request()->fullUrlWithQuery(['page' => $posts['current_page'] + 1]) }}" class="px-3 py-1.5 border border-[#E5E3DC] dark:border-[#2D332F] rounded-lg text-xs font-medium text-[#171A19] dark:text-white bg-white dark:bg-[#1E2320] hover:bg-[#FAF9F6] transition">Sau »</a>
          @else
            <button class="px-3 py-1.5 border border-[#E5E3DC] dark:border-[#2D332F] rounded-lg text-xs font-medium text-gray-300 dark:text-gray-600 bg-gray-50 dark:bg-gray-800/50 cursor-not-allowed" disabled>Sau »</button>
          @endif
        </div>
      </div>
    </div>
    @endif
  </div>

  {{-- Modal từ chối --}}
  <div id="rejectModal" class="hidden modal-backdrop-animate fixed inset-0 bg-black/60 backdrop-blur-xs flex items-center justify-center z-50 p-4">
    <div class="modal-panel-animate bg-white dark:bg-[#1E2320] rounded-2xl p-6 max-w-md w-full border border-[#E5E3DC] dark:border-[#2D332F] shadow-2xl pointer-events-auto" id="rejectModalContent">
      <div class="flex items-center gap-2 mb-3 text-rose-600 dark:text-rose-400">
        <i class="ri-alert-line text-xl"></i>
        <h3 class="text-lg font-serif font-bold text-[#171A19] dark:text-white">Từ chối xuất bản bài viết</h3>
      </div>
      <p class="text-xs text-[#5A605B] dark:text-[#9EA39E] mb-4">
        Vui lòng cung cấp lý do cụ thể để chủ trọ chỉnh sửa lại nội dung hoặc cập nhật hình ảnh đúng quy chuẩn.
      </p>

      <form id="rejectForm" method="POST" action="" data-no-ajax="true">
        @csrf
        <input type="hidden" name="post_id" id="reject_post_id">
        <div class="mb-4">
          <label class="block text-xs font-semibold uppercase tracking-wider text-[#5A605B] dark:text-[#9EA39E] mb-2">Lý do từ chối:</label>
          <textarea name="ly_do" 
                    required 
                    rows="4" 
                    class="input-focus-smooth w-full bg-[#FAF9F6] dark:bg-[#282D2A] border border-[#E5E3DC] dark:border-[#343B36] rounded-xl px-3.5 py-2.5 text-xs sm:text-sm text-[#171A19] dark:text-white focus:outline-none focus:ring-1 focus:ring-rose-500"
                    placeholder="Ví dụ: Hình ảnh mờ, sai thông tin giá phòng hoặc thiếu tiện ích cơ bản..."></textarea>
        </div>
        <div class="flex items-center justify-end gap-2.5 pt-2 border-t border-[#E5E3DC] dark:border-[#282D2A]">
          <button type="button" 
                  onclick="hideRejectModal()"
                  class="micro-press px-4 py-2 border border-[#E5E3DC] dark:border-[#2D332F] text-xs font-medium rounded-xl text-[#5A605B] dark:text-[#9EA39E] hover:text-[#171A19] dark:hover:text-white transition">
            Hủy
          </button>
          <button type="submit" data-no-ajax="true"
                  class="micro-press px-4 py-2 bg-rose-600 hover:bg-rose-700 text-white text-xs font-medium rounded-xl transition shadow-xs">
            Xác nhận từ chối
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
  // Xử lý nút từ chối
  document.querySelectorAll('.reject-btn').forEach(btn => {
    btn.addEventListener('click', function() {
      const postId = this.dataset.postId;
      const postTitle = this.dataset.postTitle;
      showRejectModal(postId, postTitle);
    });
  });

  function showRejectModal(postId, postTitle) {
    document.getElementById('reject_post_id').value = postId;
    document.getElementById('rejectForm').action = `/admin/approvals/${postId}/reject`;
    document.getElementById('rejectModal').classList.remove('hidden');
  }

  function hideRejectModal() {
    document.getElementById('rejectModal').classList.add('hidden');
  }

  document.getElementById('rejectModal').addEventListener('click', function(e) {
    if (e.target === this) {
      hideRejectModal();
    }
  });

  // Filter submit helper
  (function(){
    var filterBtn = document.getElementById('filterBtn');
    var form = document.getElementById('approvalsFilterForm');
    if (!filterBtn || !form) return;
    filterBtn.addEventListener('click', function(e){
      e.preventDefault();
      var diaChi = (form.querySelector('[name="dia_chi"]') || {value: ''}).value.trim();
      var perPage = (form.querySelector('[name="per_page"]') || {value: ''}).value;

      var params = new URLSearchParams();
      if (perPage) params.set('per_page', perPage);
      if (diaChi) params.set('dia_chi', diaChi);
      params.set('suspected', '0');

      var url = "{{ route('admin.approvals') }}";
      var q = params.toString();
      if (q.length) url = url + '?' + q;
      window.location.href = url;
    });
  })();
</script>
@endsection
