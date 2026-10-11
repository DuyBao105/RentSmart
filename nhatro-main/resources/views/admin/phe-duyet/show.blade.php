@extends('admin.layout')

@section('title', 'Admin — Chi tiết Kiểm duyệt Tin đăng')

@section('content')
@if(isset($post) && is_array($post))
  <div class="space-y-6 max-w-6xl mx-auto">
    {{-- Top bar --}}
    <div class="flex items-center justify-between pb-3 border-b border-[#E5E3DC] dark:border-[#282D2A]">
      <div class="flex items-center gap-3">
        <a href="{{ route('admin.approvals') }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl border border-[#E5E3DC] dark:border-[#2D332F] text-xs font-medium text-[#5A605B] dark:text-[#9EA39E] hover:text-[#171A19] dark:hover:text-white bg-white dark:bg-[#1E2320] transition">
          <i class="ri-arrow-left-line"></i>
          <span>Danh sách chờ duyệt</span>
        </a>
        <span class="text-xs text-[#5A605B] dark:text-[#9EA39E]">•</span>
        <span class="text-xs font-semibold uppercase tracking-wider text-[#A6824D]">Hồ sơ ID #{{ $post['id'] ?? '—' }}</span>
      </div>

      <div class="flex items-center gap-2">
        <form method="POST" action="{{ route('admin.approvals.approve', $post['id']) }}" class="inline">
          @csrf
          <button type="submit" onclick="return confirm('Xác nhận phê duyệt và đăng bài ngay bây giờ?')" class="px-4 py-2 bg-[#1B3D2F] hover:bg-[#244B3B] text-white text-xs sm:text-sm font-medium rounded-xl transition shadow-xs flex items-center gap-1.5">
            <i class="ri-checkbox-circle-line"></i>
            <span>Duyệt bài đăng</span>
          </button>
        </form>

        <button id="rejectBtn" type="button" class="px-4 py-2 bg-rose-50 hover:bg-rose-100 text-rose-700 dark:bg-rose-950/40 dark:hover:bg-rose-900/50 dark:text-rose-300 text-xs sm:text-sm font-medium rounded-xl border border-rose-200 dark:border-rose-900 transition flex items-center gap-1.5">
          <i class="ri-close-circle-line"></i>
          <span>Từ chối</span>
        </button>
      </div>
    </div>

    {{-- Main Inspection Card --}}
    <div class="bg-white dark:bg-[#1E2320] rounded-2xl border border-[#E5E3DC] dark:border-[#2D332F] shadow-sm overflow-hidden p-6 sm:p-8">
      <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

        {{-- Left 5 Cols: Photography Inspection --}}
        <div class="lg:col-span-5 space-y-4">
          @php
            $mainImg = !empty($post['anh_dai_dien']) ? $post['anh_dai_dien'] : (is_array($post['images'] ?? null) && !empty($post['images'][0]['url']) ? $post['images'][0]['url'] : asset("images/no-image.png"));
          @endphp

          <div class="relative aspect-4/3 rounded-2xl overflow-hidden bg-[#FAF9F6] dark:bg-[#282D2A] border border-[#E5E3DC] dark:border-[#2D332F] shadow-inner">
            <img id="post-main-image" src="{{ $mainImg }}" class="w-full h-full object-cover transition duration-300" alt="Ảnh phòng chính">
            <div class="absolute top-3 left-3 px-2.5 py-1 rounded-full bg-black/60 backdrop-blur-xs text-white text-[11px] font-medium">
              Ảnh chính
            </div>
          </div>

          @if(!empty($post['images']) && is_array($post['images']))
            <div class="grid grid-cols-4 gap-2.5">
              @foreach($post['images'] as $img)
                @php $url = is_array($img) ? ($img['url'] ?? '') : ($img->url ?? ''); @endphp
                @if(!empty($url))
                  <button type="button" class="thumb-btn thumbnail-btn aspect-square rounded-xl overflow-hidden border border-[#E5E3DC] dark:border-[#2D332F] hover:border-[#1B3D2F] dark:hover:border-[#A3E635] focus:ring-2 focus:ring-[#1B3D2F] transition group" data-url="{{ $url }}">
                    <img src="{{ $url }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" alt="thumbnail">
                  </button>
                @endif
              @endforeach
            </div>
          @endif

          <div class="p-4 rounded-xl bg-[#FAF9F6] dark:bg-[#282D2A]/60 border border-[#E5E3DC] dark:border-[#343B36] text-xs text-[#5A605B] dark:text-[#9EA39E]">
            <p class="font-medium text-[#171A19] dark:text-white mb-1"><i class="ri-information-line text-[#A6824D] mr-1"></i> Kiểm tra hình ảnh</p>
            Đảm bảo hình ảnh rõ nét, không bị chèn logo chìm của các sàn bất động sản khác hoặc thông tin liên hệ cấm.
          </div>
        </div>

        {{-- Right 7 Cols: Detailed Dossier --}}
        <div class="lg:col-span-7 space-y-6">
          <div>
            <div class="inline-flex items-center gap-2 px-2.5 py-0.5 rounded-full bg-emerald-50 dark:bg-emerald-950/40 text-emerald-800 dark:text-emerald-300 text-xs font-semibold mb-2">
              Chờ phê duyệt
            </div>
            <h1 class="text-xl sm:text-2xl font-serif font-bold text-[#171A19] dark:text-white leading-snug">
              {{ $post['tieu_de'] ?? '---' }}
            </h1>
            <p class="text-xs text-[#5A605B] dark:text-[#9EA39E] mt-1.5 flex items-center gap-1.5">
              <i class="ri-map-pin-2-fill text-[#A6824D]"></i>
              <span>{{ $post['dia_chi'] ?? '---' }}</span>
            </p>
          </div>

          {{-- Pricing Strip --}}
          <div class="p-4 rounded-xl bg-[#FAF9F6] dark:bg-[#282D2A]/60 border border-[#E5E3DC] dark:border-[#343B36] flex flex-wrap items-center justify-between gap-4">
            <div>
              <span class="text-xs uppercase font-medium text-[#5A605B] dark:text-[#9EA39E] block">Giá thuê niêm yết</span>
              <span class="text-2xl font-serif font-bold text-[#1B3D2F] dark:text-[#4ADE80]">
                {{ $post['gia_hien_thi'] ?? (isset($post['gia_niem_yet']) ? number_format($post['gia_niem_yet'],0,',','.') . ' đ/tháng' : '---') }}
              </span>
            </div>
            <div class="text-right">
              <span class="text-xs uppercase font-medium text-[#5A605B] dark:text-[#9EA39E] block">Thời gian đăng</span>
              <span class="text-xs font-medium text-[#171A19] dark:text-white">
                {{ $post['ngay_hien_thi'] ?? (isset($post['ngay_tao']) ? date('d/m/Y H:i', strtotime($post['ngay_tao'])) : '---') }}
              </span>
            </div>
          </div>

          {{-- Specifications Grid --}}
          <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
            <div class="p-3 rounded-xl bg-white dark:bg-[#1E2320] border border-[#E5E3DC] dark:border-[#2D332F]">
              <span class="text-[11px] text-[#5A605B] dark:text-[#9EA39E] block">Phòng số</span>
              <span class="text-sm font-bold text-[#171A19] dark:text-white">{{ $post['so_phong'] ?? '---' }}</span>
            </div>
            <div class="p-3 rounded-xl bg-white dark:bg-[#1E2320] border border-[#E5E3DC] dark:border-[#2D332F]">
              <span class="text-[11px] text-[#5A605B] dark:text-[#9EA39E] block">Diện tích</span>
              <span class="text-sm font-bold text-[#171A19] dark:text-white">{{ $post['dien_tich'] ?? '---' }} m²</span>
            </div>
            <div class="p-3 rounded-xl bg-white dark:bg-[#1E2320] border border-[#E5E3DC] dark:border-[#2D332F]">
              <span class="text-[11px] text-[#5A605B] dark:text-[#9EA39E] block">Tầng lầu</span>
              <span class="text-sm font-bold text-[#171A19] dark:text-white">Tầng {{ $post['tang'] ?? '---' }}</span>
            </div>
            <div class="p-3 rounded-xl bg-white dark:bg-[#1E2320] border border-[#E5E3DC] dark:border-[#2D332F]">
              <span class="text-[11px] text-[#5A605B] dark:text-[#9EA39E] block">Sức chứa</span>
              <span class="text-sm font-bold text-[#171A19] dark:text-white">{{ $post['suc_chua'] ?? '---' }} người</span>
            </div>
          </div>

          {{-- Owner Identification --}}
          @php
            $ownerName = null;
            $ownerPhone = null;
            if (isset($post['chu_tro'])) {
                if (is_array($post['chu_tro'])) {
                    $ownerName = $post['chu_tro']['ho_ten'] ?? $post['chu_tro']['name'] ?? null;
                    $ownerPhone = $post['chu_tro']['so_dien_thoai'] ?? $post['chu_tro']['sdt'] ?? null;
                } else {
                    $ownerName = $post['chu_tro'];
                }
            }
            $ownerName = $ownerName ?? ($post['tac_gia'] ?? data_get($post, 'chuTro.ho_ten') ?? '---');
            $ownerPhone = $ownerPhone ?? ($post['sdt_chu_tro'] ?? $post['sdt'] ?? data_get($post, 'chuTro.so_dien_thoai') ?? '');
          @endphp
          <div class="p-4 rounded-xl border border-[#E5E3DC] dark:border-[#2D332F] flex items-center justify-between">
            <div class="flex items-center gap-3">
              <div class="w-10 h-10 rounded-full bg-[#FAF9F6] dark:bg-[#282D2A] border border-[#E5E3DC] dark:border-[#343B36] grid place-items-center text-[#1B3D2F] dark:text-[#A3E635] font-bold text-sm">
                {{ substr($ownerName, 0, 1) }}
              </div>
              <div>
                <span class="text-[11px] uppercase tracking-wider font-semibold text-[#5A605B] dark:text-[#9EA39E]">Chủ trọ / Đối tác</span>
                <p class="font-bold text-sm text-[#171A19] dark:text-white">{{ $ownerName }}</p>
              </div>
            </div>
            @if($ownerPhone)
              <div class="text-right">
                <span class="text-[11px] text-[#5A605B] dark:text-[#9EA39E] block">Điện thoại</span>
                <span class="text-xs font-semibold text-[#171A19] dark:text-white">{{ $ownerPhone }}</span>
              </div>
            @endif
          </div>

          {{-- Description --}}
          <div>
            <h3 class="text-xs font-semibold uppercase tracking-wider text-[#5A605B] dark:text-[#9EA39E] mb-2">Nội dung mô tả</h3>
            <div class="p-4 rounded-xl bg-[#FAF9F6]/60 dark:bg-[#282D2A]/40 border border-[#E5E3DC] dark:border-[#343B36] text-xs sm:text-sm text-[#171A19] dark:text-[#FAF9F6] leading-relaxed whitespace-pre-line max-h-60 overflow-y-auto">
              {{ $post['mo_ta'] ?? 'Chưa có nội dung mô tả chi tiết.' }}
            </div>
          </div>

          {{-- Services Table --}}
          <div>
            <h3 class="text-xs font-semibold uppercase tracking-wider text-[#5A605B] dark:text-[#9EA39E] mb-2">Dịch vụ & Tiện ích đi kèm</h3>
            @if(!empty($post['dich_vu']) && count($post['dich_vu']) > 0)
              <div class="border border-[#E5E3DC] dark:border-[#2D332F] rounded-xl overflow-hidden">
                <table class="w-full text-xs">
                  <thead class="bg-[#FAF9F6] dark:bg-[#282D2A] text-[#5A605B] dark:text-[#9EA39E]">
                    <tr>
                      <th class="p-2.5 text-left font-semibold">Tên dịch vụ</th>
                      <th class="p-2.5 text-left font-semibold">Đơn giá</th>
                      <th class="p-2.5 text-left font-semibold">Đơn vị</th>
                    </tr>
                  </thead>
                  <tbody class="divide-y divide-[#E5E3DC] dark:divide-[#282D2A]">
                    @foreach($post['dich_vu'] as $dv)
                      <tr>
                        <td class="p-2.5 font-medium text-[#171A19] dark:text-white">{{ $dv['ten'] ?? ($dv['ten_tien_ich'] ?? '') }}</td>
                        <td class="p-2.5 font-semibold text-[#1B3D2F] dark:text-[#4ADE80]">{{ isset($dv['gia']) ? number_format($dv['gia'], 0, ',', '.') . ' đ' : 'Miễn phí' }}</td>
                        <td class="p-2.5 text-[#5A605B] dark:text-[#9EA39E]">{{ $dv['don_vi'] ?? 'Lượt' }}</td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            @else
              <p class="text-xs text-[#5A605B] dark:text-[#9EA39E] italic">Không có dịch vụ định kỳ đi kèm.</p>
            @endif
          </div>

        </div>
      </div>
    </div>

    {{-- Reject Modal --}}
    <div id="rejectModal" class="fixed inset-0 flex items-center justify-center bg-black/60 backdrop-blur-xs hidden z-50 p-4">
      <div class="bg-white dark:bg-[#1E2320] rounded-2xl p-6 w-full max-w-lg border border-[#E5E3DC] dark:border-[#2D332F] shadow-2xl">
        <div class="flex items-center gap-2 mb-3 text-rose-600 dark:text-rose-400">
          <i class="ri-alert-line text-xl"></i>
          <h3 class="text-lg font-serif font-bold text-[#171A19] dark:text-white">Từ chối duyệt bài viết này</h3>
        </div>
        <p class="text-xs text-[#5A605B] dark:text-[#9EA39E] mb-4">
          Nêu rõ nguyên nhân từ chối để hệ thống gửi thông báo phản hồi cho chủ phòng trọ.
        </p>
        <form id="rejectForm" method="POST" action="{{ route('admin.approvals.reject', $post['id']) }}">
          @csrf
          <input type="hidden" name="rejected_image_ids" id="rejected_image_ids_input" value="">
          <div class="mb-4">
            <textarea name="ly_do" rows="4" class="w-full bg-[#FAF9F6] dark:bg-[#282D2A] border border-[#E5E3DC] dark:border-[#343B36] rounded-xl px-3.5 py-2.5 text-xs sm:text-sm text-[#171A19] dark:text-white focus:outline-none focus:ring-1 focus:ring-rose-500" placeholder="Nhập lý do chi tiết..." required></textarea>
          </div>
          <div class="flex justify-end gap-2.5 pt-2 border-t border-[#E5E3DC] dark:border-[#282D2A]">
            <button type="button" id="cancelReject" class="px-4 py-2 border border-[#E5E3DC] dark:border-[#2D332F] text-xs font-medium rounded-xl text-[#5A605B] dark:text-[#9EA39E] hover:text-[#171A19] dark:hover:text-white transition">Hủy</button>
            <button type="submit" class="px-4 py-2 bg-rose-600 hover:bg-rose-700 text-white text-xs font-medium rounded-xl transition shadow-xs">Gửi quyết định từ chối</button>
          </div>
        </form>
      </div>
    </div>
  </div>
@else
  <div class="p-8 bg-white dark:bg-[#1E2320] rounded-2xl border border-[#E5E3DC] dark:border-[#2D332F] text-center text-[#5A605B] dark:text-[#9EA39E]">
    Không tìm thấy dữ liệu bài viết này.
  </div>
@endif

@push('scripts')
  <script>
    document.getElementById('rejectBtn')?.addEventListener('click', function(){
      document.getElementById('rejectModal').classList.remove('hidden');
    });
    document.getElementById('cancelReject')?.addEventListener('click', function(){
      document.getElementById('rejectModal').classList.add('hidden');
    });

    document.getElementById('rejectForm')?.addEventListener('submit', function(e){
      const checked = Array.from(document.querySelectorAll('.reject-image-checkbox:checked')).map(cb => cb.value).filter(Boolean);
      document.getElementById('rejected_image_ids_input').value = JSON.stringify(checked);
      return true;
    });

    document.querySelectorAll('.thumbnail-btn').forEach(btn => {
      btn.addEventListener('click', function(){
        try {
          var url = this.dataset.url;
          var main = document.getElementById('post-main-image');
          if (main && url) main.src = url;
        } catch(e){ console.debug('thumb click', e); }
      });
    });
  </script>
@endpush
@endsection
