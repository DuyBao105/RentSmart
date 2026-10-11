@extends('admin.layout')

@section('title', 'Admin — Chi tiết Bài viết')

@section('content')
@if(isset($post) && is_array($post))
  <div class="space-y-6 max-w-5xl mx-auto">
    {{-- Top Action Bar --}}
    <div class="flex items-center justify-between pb-3 border-b border-[#E5E3DC] dark:border-[#282D2A]">
      <div class="flex items-center gap-3">
        <a href="{{ route('admin.posts') }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl border border-[#E5E3DC] dark:border-[#2D332F] text-xs font-medium text-[#5A605B] dark:text-[#9EA39E] hover:text-[#171A19] dark:hover:text-white bg-white dark:bg-[#1E2320] transition">
          <i class="ri-arrow-left-line"></i>
          <span>Danh sách bài viết</span>
        </a>
        <span class="text-xs text-[#5A605B] dark:text-[#9EA39E]">•</span>
        <span class="text-xs font-semibold uppercase tracking-wider text-[#A6824D]">Tin đăng #{{ $post['id'] ?? '—' }}</span>
      </div>

      <div class="flex items-center gap-2">
        <button type="button" id="open-status-modal" class="px-4 py-2 border border-[#E5E3DC] dark:border-[#2D332F] bg-white dark:bg-[#1E2320] hover:bg-[#FAF9F6] text-xs sm:text-sm font-medium text-[#171A19] dark:text-white rounded-xl transition flex items-center gap-1.5">
          <i class="ri-edit-2-line text-[#1B3D2F] dark:text-[#A3E635]"></i>
          <span>Đổi trạng thái</span>
        </button>

        <form method="POST" action="{{ route('admin.posts.delete', $post['id']) }}" onsubmit="return confirm('Bạn chắc chắn muốn xóa bài viết này?')">
          @csrf
          @method('DELETE')
          <button type="submit" class="px-4 py-2 border border-rose-200 dark:border-rose-900 bg-rose-50 hover:bg-rose-100 text-rose-700 dark:bg-rose-950/40 dark:hover:bg-rose-900/50 dark:text-rose-300 text-xs sm:text-sm font-medium rounded-xl transition flex items-center gap-1.5">
            <i class="ri-delete-bin-line"></i>
            <span>Xóa tin</span>
          </button>
        </form>
      </div>
    </div>

    {{-- Post Detail Card --}}
    <div class="bg-white dark:bg-[#1E2320] rounded-2xl border border-[#E5E3DC] dark:border-[#2D332F] shadow-sm p-6 sm:p-8 space-y-6">
      <div class="grid grid-cols-1 md:grid-cols-12 gap-8">
        {{-- Images Col (5 cols) --}}
        <div class="md:col-span-5 space-y-3">
          <div class="relative aspect-4/3 rounded-2xl overflow-hidden bg-[#FAF9F6] dark:bg-[#282D2A] border border-[#E5E3DC] dark:border-[#2D332F]">
            @if(!empty($post['anh_dai_dien']))
              <img id="post-main-image" src="{{ $post['anh_dai_dien'] }}" alt="Ảnh bài viết" class="w-full h-full object-cover">
            @else
              <div class="w-full h-full flex items-center justify-center text-xs text-[#5A605B] dark:text-[#9EA39E]">
                Chưa có ảnh đại diện
              </div>
            @endif
          </div>

          @if(!empty($post['images']) && is_array($post['images']))
            <div class="grid grid-cols-4 gap-2">
              @foreach($post['images'] as $img)
                @php $url = is_array($img) ? ($img['url'] ?? '') : ($img->url ?? ''); @endphp
                @if(!empty($url))
                  <button type="button" class="thumbnail-btn aspect-square rounded-xl overflow-hidden border border-[#E5E3DC] dark:border-[#2D332F] hover:border-[#1B3D2F] transition" data-url="{{ $url }}">
                    <img src="{{ $url }}" class="w-full h-full object-cover" alt="thumb">
                  </button>
                @endif
              @endforeach
            </div>
          @endif
        </div>

        {{-- Content Col (7 cols) --}}
        <div class="md:col-span-7 space-y-5">
          <div>
            @php
              $trangThai = $post['trang_thai'] ?? '';
              $badgeClass = match($trangThai) {
                'dang' => 'bg-emerald-50 text-emerald-800 border-emerald-200 dark:bg-emerald-950/40 dark:text-emerald-400 dark:border-emerald-800',
                'cho_duyet' => 'bg-amber-50 text-amber-800 border-amber-200 dark:bg-amber-950/40 dark:text-amber-400 dark:border-amber-800',
                'tu_choi' => 'bg-rose-50 text-rose-800 border-rose-200 dark:bg-rose-950/40 dark:text-rose-400 dark:border-rose-800',
                'an' => 'bg-gray-100 text-gray-700 border-gray-200 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-700',
                default => 'bg-[#FAF9F6] text-[#5A605B] border-[#E5E3DC] dark:bg-[#282D2A] dark:text-[#9EA39E] dark:border-[#343B36]'
              };
              $badgeText = match($trangThai) {
                'dang' => 'Đang hiển thị công khai',
                'cho_duyet' => 'Chờ kiểm duyệt',
                'tu_choi' => 'Bị từ chối xuất bản',
                'an' => 'Tạm ẩn bài đăng',
                'nhap' => 'Bản nháp',
                default => 'N/A'
              };
            @endphp
            <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold border mb-2 {{ $badgeClass }}">
              {{ $badgeText }}
            </span>

            <h1 class="text-xl sm:text-2xl font-serif font-bold text-[#171A19] dark:text-white leading-snug">
              {{ $post['tieu_de'] ?? '---' }}
            </h1>
          </div>

          {{-- Pricing --}}
          <div class="p-4 rounded-xl bg-[#FAF9F6] dark:bg-[#282D2A]/60 border border-[#E5E3DC] dark:border-[#343B36] flex items-center justify-between">
            <span class="text-xs uppercase font-medium text-[#5A605B] dark:text-[#9EA39E]">Giá niêm yết</span>
            <span class="text-2xl font-serif font-bold text-[#1B3D2F] dark:text-[#4ADE80]">
              {{ isset($post['gia_niem_yet']) ? number_format($post['gia_niem_yet']) . ' đ/tháng' : 'Liên hệ' }}
            </span>
          </div>

          {{-- Amenities --}}
          @if(!empty($post['tien_ich']) && is_array($post['tien_ich']))
            <div>
              <span class="text-xs font-semibold uppercase tracking-wider text-[#5A605B] dark:text-[#9EA39E] block mb-2">Tiện ích phòng</span>
              <div class="flex flex-wrap gap-2">
                @foreach($post['tien_ich'] as $t)
                  @php $name = is_array($t) ? ($t['ten_tien_ich'] ?? ($t['ten'] ?? '')) : ($t->ten_tien_ich ?? $t->ten ?? ''); @endphp
                  <span class="px-3 py-1 bg-[#FAF9F6] dark:bg-[#282D2A] border border-[#E5E3DC] dark:border-[#343B36] rounded-lg text-xs font-medium text-[#171A19] dark:text-white">
                    {{ $name }}
                  </span>
                @endforeach
              </div>
            </div>
          @endif

          {{-- Description --}}
          <div>
            <span class="text-xs font-semibold uppercase tracking-wider text-[#5A605B] dark:text-[#9EA39E] block mb-2">Mô tả bài đăng</span>
            <div class="p-4 rounded-xl bg-[#FAF9F6]/60 dark:bg-[#282D2A]/40 border border-[#E5E3DC] dark:border-[#343B36] text-xs sm:text-sm text-[#171A19] dark:text-[#FAF9F6] leading-relaxed max-h-60 overflow-y-auto">
              {!! nl2br(e($post['mo_ta'] ?? 'Không có nội dung mô tả.')) !!}
            </div>
          </div>
        </div>
      </div>
    </div>

    {{-- Status edit modal --}}
    <div id="status-modal" class="fixed inset-0 bg-black/60 backdrop-blur-xs hidden items-center justify-center z-50 p-4">
      <div class="bg-white dark:bg-[#1E2320] rounded-2xl max-w-md w-full p-6 border border-[#E5E3DC] dark:border-[#2D332F] shadow-2xl">
        <h3 class="text-lg font-serif font-bold text-[#171A19] dark:text-white mb-2">Cập nhật trạng thái bài viết</h3>
        <p class="text-xs text-[#5A605B] dark:text-[#9EA39E] mb-4">Chọn trạng thái hiển thị mới cho tin đăng này trên sàn giao dịch.</p>
        <form method="POST" action="{{ route('admin.posts.status', $post['id']) }}">
          @csrf
          @method('PATCH')
          <div class="mb-4">
            <select name="trang_thai" class="w-full bg-[#FAF9F6] dark:bg-[#282D2A] border border-[#E5E3DC] dark:border-[#343B36] rounded-xl px-3.5 py-2.5 text-xs sm:text-sm text-[#171A19] dark:text-white focus:outline-none focus:ring-1 focus:ring-[#1B3D2F]">
              <option value="">-- Giữ nguyên --</option>
              <option value="nhap" {{ ($post['trang_thai'] ?? '') === 'nhap' ? 'selected' : '' }}>Nháp (Chưa công khai)</option>
              <option value="dang" {{ ($post['trang_thai'] ?? '') === 'dang' ? 'selected' : '' }}>Đang hiển thị công khai</option>
              <option value="cho_duyet" {{ ($post['trang_thai'] ?? '') === 'cho_duyet' ? 'selected' : '' }}>Chờ duyệt</option>
              <option value="an" {{ ($post['trang_thai'] ?? '') === 'an' ? 'selected' : '' }}>Tạm ẩn tin đăng</option>
              <option value="tu_choi" {{ ($post['trang_thai'] ?? '') === 'tu_choi' ? 'selected' : '' }}>Từ chối / Khóa tin</option>
            </select>
          </div>
          <div class="flex justify-end gap-2.5 pt-2 border-t border-[#E5E3DC] dark:border-[#282D2A]">
            <button type="button" id="status-cancel" class="px-4 py-2 border border-[#E5E3DC] dark:border-[#2D332F] text-xs font-medium rounded-xl text-[#5A605B] dark:text-[#9EA39E] hover:text-[#171A19] dark:hover:text-white transition">Hủy</button>
            <button type="submit" class="px-4 py-2 bg-[#1B3D2F] hover:bg-[#244B3B] text-white text-xs font-medium rounded-xl transition shadow-xs">Lưu thay đổi</button>
          </div>
        </form>
      </div>
    </div>
  </div>
@else
  <div class="p-8 bg-white dark:bg-[#1E2320] rounded-2xl border border-[#E5E3DC] dark:border-[#2D332F] text-center text-[#5A605B] dark:text-[#9EA39E]">
    Không có dữ liệu bài viết.
  </div>
@endif

@push('scripts')
  <script>
    document.querySelectorAll('.thumbnail-btn').forEach(btn => {
      btn.addEventListener('click', function(){
        try {
          var url = this.dataset.url;
          var main = document.getElementById('post-main-image');
          if (main && url) main.src = url;
        } catch(e){ console.debug('thumb click', e); }
      });
    });
    
    document.addEventListener('DOMContentLoaded', function(){
      var open = document.getElementById('open-status-modal');
      var modal = document.getElementById('status-modal');
      var cancel = document.getElementById('status-cancel');
      if (open && modal) {
        open.addEventListener('click', function(){ modal.classList.remove('hidden'); modal.classList.add('flex'); });
      }
      if (cancel && modal) {
        cancel.addEventListener('click', function(){ modal.classList.add('hidden'); modal.classList.remove('flex'); });
      }
      if (modal) modal.addEventListener('click', function(e){ if (e.target === modal) { modal.classList.add('hidden'); modal.classList.remove('flex'); } });
    });
  </script>
@endpush
@endsection
