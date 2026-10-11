@extends('layouts.app')

@section('title', 'Tìm kiếm bất động sản cho thuê - Hệ Thống Trọ')

@section('content')
<section class="relative py-16 bg-[#FAF9F6] dark:bg-[#121514] min-h-screen" x-data="searchForm()">
  <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="text-left mb-8 pb-4 border-b border-[#E5E3DC] dark:border-[#262B28]">
      <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded text-[11px] font-semibold bg-white dark:bg-[#181B19] text-[#1B3D2F] dark:text-[#A3B899] border border-[#E5E3DC] dark:border-[#2D3330] mb-2 uppercase tracking-wider">
        Công cụ lọc đa tiêu chí
      </span>
      <h1 class="text-2xl sm:text-3xl font-bold tracking-tight text-[#171A19] dark:text-white">
        Tìm Kiếm Phòng Trọ Phù Hợp
      </h1>
      <p class="text-[#70746F] dark:text-stone-400 text-xs sm:text-sm mt-1">
        Tùy chỉnh khoảng ngân sách, khu vực và tiêu chí sắp xếp để tìm kiếm căn phòng phù hợp nhất.
      </p>
    </div>

    <form action="{{ route('listing') }}" method="GET" class="bg-white dark:bg-[#181B19] rounded-xl border border-[#E5E3DC] dark:border-[#282D2A] shadow-sm p-6 sm:p-8 space-y-6">
      {{-- Khu vực --}}
      <div>
        <label class="block text-xs font-semibold uppercase tracking-wider text-[#171A19] dark:text-white mb-2">
          Khu vực cần tìm
        </label>
        <div class="relative">
          <input type="text" name="dia_chi" placeholder="Nhập quận, huyện, xã phường hoặc tên đường..." x-model="filters.area"
            class="w-full pl-9 pr-4 py-2.5 bg-[#FAF9F6] dark:bg-[#1F2321] border border-[#E5E3DC] dark:border-[#303632] rounded-lg focus:border-[#1B3D2F] focus:bg-white dark:focus:bg-[#181B19] focus:outline-none placeholder-[#9EA09B] text-[#171A19] dark:text-white text-xs sm:text-sm transition">
          <i class="ri-map-pin-line absolute left-3 top-1/2 -translate-y-1/2 text-[#85877F] text-sm"></i>
        </div>

        {{-- Khu vực phổ biến --}}
        <div class="mt-3">
          <p class="text-xs text-[#85877F] mb-1.5">
            Gợi ý nhanh:
          </p>
          <div class="flex flex-wrap gap-1.5">
            @foreach (['Quận 1', 'Quận 3', 'Quận 7', 'Thủ Đức', 'Bình Thạnh', 'Quận 10', 'Gò Vấp', 'Tân Bình'] as $kv)
              <button type="button"
                @click="toggleArea('{{ $kv }}')"
                :class="filters.area === '{{ $kv }}'
                  ? 'bg-[#1B3D2F] text-white border-[#1B3D2F] font-semibold'
                  : 'bg-[#FAF9F6] dark:bg-[#1E2320] text-[#555955] dark:text-[#A7AAA4] border-[#E5E3DC] dark:border-[#2D3330] hover:bg-[#EAE8E1]'"
                class="px-2.5 py-1 rounded-md text-xs border transition cursor-pointer">
                {{ $kv }}
              </button>
            @endforeach
          </div>
        </div>
      </div>

      {{-- Khoảng giá --}}
      <div>
        <label class="block text-xs font-semibold uppercase tracking-wider text-[#171A19] dark:text-white mb-2">
          Khoảng ngân sách (VNĐ / tháng)
        </label>
        <div class="flex items-center gap-2.5">
          <input type="number" x-model="filters.min" name="min" placeholder="Giá từ (₫)..."
            class="flex-1 px-3.5 py-2.5 bg-[#FAF9F6] dark:bg-[#1F2321] border border-[#E5E3DC] dark:border-[#303632] rounded-lg focus:border-[#1B3D2F] focus:bg-white dark:focus:bg-[#181B19] focus:outline-none placeholder-[#9EA09B] text-xs sm:text-sm text-[#171A19] dark:text-white transition">
          <span class="text-[#85877F] font-bold text-xs">—</span>
          <input type="number" x-model="filters.max" name="max" placeholder="Đến (₫)..."
            class="flex-1 px-3.5 py-2.5 bg-[#FAF9F6] dark:bg-[#1F2321] border border-[#E5E3DC] dark:border-[#303632] rounded-lg focus:border-[#1B3D2F] focus:bg-white dark:focus:bg-[#181B19] focus:outline-none placeholder-[#9EA09B] text-xs sm:text-sm text-[#171A19] dark:text-white transition">
        </div>

        {{-- Gợi ý giá nhanh --}}
        <div class="flex flex-wrap gap-1.5 mt-2.5">
          @foreach (['Dưới 2 triệu' => [0, 2000000], '2 - 3 triệu' => [2000000, 3000000], '3 - 5 triệu' => [3000000, 5000000], 'Trên 5 triệu' => [5000000, '']] as $label => $range)
            <button type="button"
              @click="setPrice('{{ $range[0] }}', '{{ $range[1] }}')"
              :class="filters.min == '{{ $range[0] }}' && filters.max == '{{ $range[1] }}'
                ? 'bg-[#1B3D2F] text-white border-[#1B3D2F] font-semibold'
                : 'bg-[#FAF9F6] dark:bg-[#1E2320] text-[#555955] dark:text-[#A7AAA4] border-[#E5E3DC] dark:border-[#2D3330] hover:bg-[#EAE8E1]'"
              class="px-2.5 py-1 rounded-md text-xs border transition cursor-pointer">
              {{ $label }}
            </button>
          @endforeach
        </div>
      </div>

      {{-- Sắp xếp + Submit --}}
      <div class="flex flex-col sm:flex-row sm:items-end gap-3 pt-4 border-t border-[#EAE8E1] dark:border-[#282D2A]">
        <div class="flex-1">
          <label class="block text-xs font-semibold uppercase tracking-wider text-[#171A19] dark:text-white mb-1.5">
            Tiêu chí sắp xếp
          </label>
          <select name="sort" x-model="filters.sort"
            class="w-full px-3.5 py-2.5 bg-[#FAF9F6] dark:bg-[#1F2321] border border-[#E5E3DC] dark:border-[#303632] rounded-lg focus:border-[#1B3D2F] focus:bg-white dark:focus:bg-[#181B19] focus:outline-none text-[#171A19] dark:text-white text-xs sm:text-sm transition cursor-pointer">
            <option value="newest">Mới cập nhật</option>
            <option value="asc">Giá thấp → cao</option>
            <option value="desc">Giá cao → thấp</option>
            <option value="area">Diện tích lớn → nhỏ</option>
          </select>
        </div>

        <button type="submit"
          class="px-6 py-2.5 bg-[#1B3D2F] hover:bg-[#142F24] text-white font-semibold text-xs sm:text-sm rounded-lg shadow-2xs transition flex items-center justify-center gap-2 cursor-pointer">
          <i class="ri-search-line"></i>
          <span>Tìm kiếm phòng</span>
        </button>
      </div>
    </form>
  </div>
</section>

{{-- Alpine helper --}}
<script>
  function searchForm() {
    return {
      filters: { area:'', min:'', max:'', sort:'newest' },
      toggleArea(area){ this.filters.area = this.filters.area === area ? '' : area },
      setPrice(min,max){ this.filters.min=min; this.filters.max=max }
    }
  }
</script>
@endsection
