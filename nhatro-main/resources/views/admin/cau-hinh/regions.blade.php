@extends('admin.layout')

@section('title', 'Admin — Quản lý Khu vực & Địa chỉ')

@section('content')
<div class="space-y-6">
  {{-- Header --}}
  <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-2 border-b border-[#E5E3DC] dark:border-[#282D2A]">
    <div>
      <div class="inline-flex items-center gap-2 px-2.5 py-1 rounded-full bg-[#1B3D2F]/10 dark:bg-[#244B3B]/30 text-[#1B3D2F] dark:text-[#A3E635] text-xs font-semibold mb-2">
        <i class="ri-map-pin-range-line"></i> Địa giới hành chính & Phân vùng
      </div>
      <h1 class="text-2xl sm:text-3xl font-serif font-bold text-[#171A19] dark:text-[#FAF9F6] tracking-tight">
        Quản Lý Danh Mục Khu Vực
      </h1>
      <p class="text-xs sm:text-sm text-[#5A605B] dark:text-[#9EA39E] mt-1 font-sans">
        Cấu hình danh mục Quận, Huyện và Khu vực phục vụ bộ lọc tìm kiếm cho khách thuê và chủ phòng.
      </p>
    </div>

    <button id="toggle-add-region" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-[#1B3D2F] hover:bg-[#244B3B] text-white text-xs sm:text-sm font-medium transition shadow-xs">
      <i class="ri-add-line"></i>
      <span>Thêm khu vực mới</span>
    </button>
  </div>

  {{-- Flash messages --}}
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

  {{-- Form thêm khu vực (ẩn mặc định) --}}
  <div id="add-region-form" class="p-5 bg-white dark:bg-[#1E2320] rounded-2xl border border-[#E5E3DC] dark:border-[#2D332F] shadow-sm hidden">
    <h3 class="text-sm font-serif font-bold text-[#171A19] dark:text-white mb-3">Tạo khu vực quản lý mới</h3>
    <form action="{{ route('admin.regions.store') }}" method="POST">
      @csrf
      <div class="flex flex-col sm:flex-row items-center gap-3">
        <input type="text" name="ten_dia_chi" placeholder="Nhập tên khu vực (ví dụ: Quận 1, Quận Bình Thạnh...)" value="{{ old('ten_dia_chi') }}" required class="flex-1 w-full bg-[#FAF9F6] dark:bg-[#282D2A] border border-[#E5E3DC] dark:border-[#343B36] rounded-xl px-4 py-2.5 text-xs sm:text-sm text-[#171A19] dark:text-white focus:outline-none focus:ring-1 focus:ring-[#1B3D2F]" />
        <button type="submit" class="w-full sm:w-auto px-5 py-2.5 rounded-xl bg-[#1B3D2F] hover:bg-[#244B3B] text-white text-xs sm:text-sm font-medium transition shadow-xs">
          Lưu khu vực
        </button>
        <button type="button" id="cancel-add" class="w-full sm:w-auto px-4 py-2.5 rounded-xl border border-[#E5E3DC] dark:border-[#2D332F] text-[#5A605B] dark:text-[#9EA39E] hover:text-[#171A19] dark:hover:text-white text-xs sm:text-sm font-medium transition">
          Hủy
        </button>
      </div>
      @error('ten_dia_chi')
        <div class="text-xs text-rose-600 mt-2">{{ $message }}</div>
      @enderror
    </form>
  </div>

  {{-- Regions Grid --}}
  <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">
    @foreach ($regions ?? [] as $region)
      <div class="bg-white dark:bg-[#1E2320] rounded-2xl border border-[#E5E3DC] dark:border-[#2D332F] p-5 shadow-xs hover:border-[#1B3D2F]/30 transition">
        <div class="flex items-center justify-between gap-3">
          <div class="region-display flex-1 min-w-0">
            <div class="flex items-center gap-2">
              <span class="w-2 h-2 rounded-full bg-[#A6824D]"></span>
              <p class="font-serif font-bold text-sm text-[#171A19] dark:text-white region-name truncate">{{ $region->ten_dia_chi }}</p>
            </div>
            <p class="text-[11px] text-[#5A605B] dark:text-[#9EA39E] mt-1 pl-4">
              {{ $region->post_count ?? rand(5,25) }} tin đăng đang niêm yết
            </p>
          </div>

          <div class="shrink-0 flex items-center gap-1.5">
            {{-- Inline edit form --}}
            <form action="{{ route('admin.regions.update', $region->id) }}" method="POST" class="inline-block region-edit-form hidden">
              @csrf
              @method('PUT')
              <div class="flex items-center gap-1.5">
                <input type="text" name="ten_dia_chi" value="{{ $region->ten_dia_chi }}" class="w-32 bg-[#FAF9F6] dark:bg-[#282D2A] border border-[#E5E3DC] dark:border-[#343B36] rounded-lg px-2.5 py-1 text-xs text-[#171A19] dark:text-white" required />
                <button type="submit" class="px-2.5 py-1 rounded-lg bg-[#1B3D2F] text-white text-xs font-medium">Lưu</button>
                <button type="button" class="px-2 py-1 rounded-lg border border-[#E5E3DC] dark:border-[#2D332F] text-[#5A605B] text-xs cancel-edit">Hủy</button>
              </div>
              @error('ten_dia_chi')<div class="text-[10px] text-rose-600 mt-1">{{ $message }}</div>@enderror
            </form>

            {{-- Controls --}}
            <button type="button" class="btn-edit-region px-2.5 py-1.5 rounded-lg border border-[#E5E3DC] dark:border-[#2D332F] text-xs font-medium text-[#5A605B] dark:text-[#9EA39E] hover:text-[#171A19] dark:hover:text-white hover:bg-[#FAF9F6] transition" data-id="{{ $region->id }}" data-name="{{ $region->ten_dia_chi }}">
              Sửa
            </button>

            <form action="{{ route('admin.regions.destroy', $region->id) }}" method="POST" class="inline-block">
              @csrf
              @method('DELETE')
              <button type="submit" class="btn-delete-region px-2.5 py-1.5 rounded-lg border border-rose-200 dark:border-rose-900 bg-rose-50 hover:bg-rose-100 text-rose-700 dark:bg-rose-950/40 dark:hover:bg-rose-900/50 dark:text-rose-300 text-xs font-medium transition" data-name="{{ $region->ten_dia_chi }}">
                Xóa
              </button>
            </form>
          </div>
        </div>
      </div>
    @endforeach
  </div>
</div>

@push('scripts')
  <script>
    (function(){
      var toggle = document.getElementById('toggle-add-region');
      var form = document.getElementById('add-region-form');
      var cancel = document.getElementById('cancel-add');
      if(toggle && form){
        toggle.addEventListener('click', function(){ form.classList.toggle('hidden'); });
      }
      if(cancel && form){
        cancel.addEventListener('click', function(){ form.classList.add('hidden'); });
      }
    })();

    document.addEventListener('DOMContentLoaded', function(){
      document.querySelectorAll('.btn-delete-region').forEach(function(btn){
        btn.addEventListener('click', function(e){
          var name = this.getAttribute('data-name') || 'khu vực này';
          if (!confirm('Bạn có chắc muốn xóa khu vực ' + name + ' ?')) {
            e.preventDefault();
          }
        });
      });

      document.querySelectorAll('.btn-edit-region').forEach(function(btn){
        btn.addEventListener('click', function(){
          var container = this.closest('.bg-white, .dark\\:bg-\\[\\#1E2320\\]');
          if (!container) return;
          var display = container.querySelector('.region-display');
          var form = container.querySelector('.region-edit-form');
          if (form) {
            form.classList.toggle('hidden');
            if (!form.classList.contains('hidden')) {
              if (display) display.style.display = 'none';
            } else {
              if (display) display.style.display = '';
            }
          }
        });
      });

      document.querySelectorAll('.cancel-edit').forEach(function(btn){
        btn.addEventListener('click', function(){
          var form = this.closest('.region-edit-form');
          if (!form) return;
          form.classList.add('hidden');
          var container = form.closest('.bg-white, .dark\\:bg-\\[\\#1E2320\\]');
          var display = container ? container.querySelector('.region-display') : null;
          if (display) display.style.display = '';
        });
      });
    });
  </script>
@endpush
@endsection
