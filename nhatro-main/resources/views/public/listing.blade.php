@extends('layouts.app')
@section('title', 'Khám Phá Phòng Trọ & Bất Động Sản Cho Thuê - Hệ Thống Trọ')

@section('content')

@php
  $recommendations = $recommendations ?? session('recommendations', []);
  $recommend_no_match = $recommend_no_match ?? session('recommend_no_match', false);
  $recommend_no_match_data = $recommend_no_match_data ?? session('recommend_no_match_data', null);
  $recommend_audit = $recommend_audit ?? session('recommend_audit', null);
  $recommend_error = $recommend_error ?? null;
  $recommend_payload = $recommend_payload ?? session('recommend_payload', null);
  $activeMode = $activeMode ?? 'search';
  $serviceOptions = collect($services ?? [])->map(function ($service) {
    $item = is_array($service) ? $service : (array) $service;
    $name = $item['ten_hien_thi'] ?? $item['ten_dich_vu'] ?? $item['ten'] ?? null;
    $price = $item['gia_hien_thi'] ?? $item['gia'] ?? $item['don_gia'] ?? null;
    return [
      'id' => $item['id'] ?? null,
      'name' => $name,
      'price' => $price,
      'unit' => $item['don_vi'] ?? null,
      'code' => $item['ma'] ?? null,
    ];
  })->filter(function ($service) {
    return !empty($service['id']) && !empty($service['name']);
  })->values()->toArray();
  $selectedServiceIds = array_values(array_filter(array_map(function ($value) {
    $value = trim((string) $value);
    return $value === '' ? null : $value;
  }, explode(',', old('dich_vu_id', request('dich_vu_id', ''))))));
  $hasActiveSearch = request()->filled('dia_chi') || request()->filled('min') || request()->filled('max') || request()->filled('category') || request()->filled('district') || request()->filled('area') || request()->filled('search');
  $regionNames = array_values(array_filter(array_map(function($r) {
    if (is_array($r)) return $r['ten_dia_chi'] ?? '';
    if (is_object($r)) return $r->ten_dia_chi ?? '';
    return (string)$r;
  }, $regions ?? [])));

  $recListItems = array_values(array_map(function($r, $idx) {
      $item = is_array($r) ? $r : (array) $r;
      $thumb = $item['anh_dai_dien'] ?? asset('upload/room1.jpg');
      $priceFmt = $item['gia_hien_thi'] ?? ($item['gia_niem_yet'] ? number_format($item['gia_niem_yet'], 0, ',', '.') . ' ₫' : 'Liên hệ');
      return [
          'id' => $item['id'] ?? null,
          'tieu_de' => $item['tieu_de'] ?? 'Phòng trọ',
          'gia_hien_thi' => $priceFmt,
          'gia_niem_yet' => $item['gia_niem_yet'] ?? 0,
          'tien_coc' => isset($item['tien_coc']) && $item['tien_coc'] ? number_format($item['tien_coc'], 0, ',', '.') . ' ₫' : '1 tháng',
          'dien_tich' => ($item['dien_tich'] ?? 0) . ' m²',
          'suc_chua' => ($item['suc_chua'] ?? 2) . ' người',
          'dia_chi' => $item['dia_chi'] ?? 'TP. Hồ Chí Minh',
          'anh_dai_dien' => $thumb,
          'satisfaction_score' => round(floatval($item['satisfaction_score'] ?? 95), 1),
          'ranking_rank' => $item['ranking_rank'] ?? ($idx + 1),
          'ai_reasons' => $item['ai_reasons'] ?? [],
          'explanations' => $item['explanations'] ?? null,
          'chu_tro_ten' => $item['chu_tro']['name'] ?? $item['nguoi_dang']['ho_ten'] ?? 'Chủ nhà',
          'chu_tro_sdt' => $item['chu_tro']['phone'] ?? $item['nguoi_dang']['so_dien_thoai'] ?? '',
      ];
  }, $recommendations ?? [], array_keys($recommendations ?? [])));
  $recListJson = json_encode($recListItems, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE);
@endphp

<div x-data="listingPage()">

  {{-- ============================================================ --}}
  {{-- 🎛️ 1. THANH BỘ LỌC THƯƠNG MẠI CỐ ĐỊNH (COMMERCIAL CONTROL BAR) --}}
  {{-- ============================================================ --}}
  <section class="py-3.5 bg-white/95 dark:bg-[#161917]/95 backdrop-blur-md border-b border-[#E5E3DC] dark:border-[#282D2A] sticky top-16 z-30 shadow-2xs">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex flex-col lg:flex-row items-center justify-between gap-3">

        {{-- Form lọc nhanh: Khu vực, Giá, Sắp xếp --}}
        <form action="{{ route('listing') }}" method="GET" class="flex flex-wrap sm:flex-nowrap items-center gap-2 grow w-full">
          <input type="hidden" name="mode" value="search">
          @if(request('category'))
            <input type="hidden" name="category" value="{{ request('category') }}">
          @endif

          {{-- 1. Khu vực (Custom Autocomplete Dropdown) --}}
          <div class="relative grow min-w-[210px]" x-data="areaDropdownComponent()"
               @click.away="openAreaDropdown = false">

            <i class="ri-map-pin-2-line text-[#85877F] absolute left-3 top-1/2 -translate-y-1/2 text-sm z-10 pointer-events-none"></i>
            
            <input type="text" name="dia_chi" x-model="areaKeyword"
              @focus="openAreaDropdown = true"
              @input="openAreaDropdown = true"
              autocomplete="off"
              placeholder="Nhập quận, huyện, xã phường..."
              class="w-full pl-8 pr-7 py-2 text-xs sm:text-sm font-medium rounded-lg bg-[#FAF9F6] dark:bg-[#1F2321] border border-[#E5E3DC] dark:border-[#303632] text-[#171A19] dark:text-white focus:bg-white dark:focus:bg-[#181B19] focus:outline-none focus:border-[#1B3D2F] dark:focus:border-[#7EA089] placeholder-[#9EA09B]">

            {{-- Clear button --}}
            <button type="button" x-show="areaKeyword" @click="areaKeyword = ''; openAreaDropdown = true"
              class="absolute right-2.5 top-1/2 -translate-y-1/2 text-[#85877F] hover:text-[#171A19] dark:hover:text-white text-xs p-1 cursor-pointer">
              <i class="ri-close-line"></i>
            </button>

            {{-- Autocomplete Dropdown Popover --}}
            <div x-show="openAreaDropdown" style="display: none;"
              x-transition:enter="transition ease-out duration-150"
              x-transition:enter-start="opacity-0 translate-y-1 scale-98"
              x-transition:enter-end="opacity-100 translate-y-0 scale-100"
              class="absolute left-0 top-full mt-1.5 w-80 sm:w-96 bg-white dark:bg-[#181B19] rounded-xl p-3 border border-[#E5E3DC] dark:border-[#2D3330] shadow-xl z-[100] max-h-80 overflow-y-auto">

              <div class="px-2 pb-2 mb-1.5 border-b border-[#EAE8E1] dark:border-[#262B28] flex items-center justify-between text-[11px] font-semibold text-[#85877F] uppercase tracking-wider">
                <span x-text="areaKeyword ? 'Gợi ý (' + filteredRegions().length + ')' : 'Khu vực trọng điểm'"></span>
                <span class="text-[10px] text-[#1B3D2F] dark:text-[#A3B899] font-medium">Bấm chọn nhanh</span>
              </div>

              {{-- Popular Quick Chips --}}
              <div x-show="!areaKeyword" class="mb-2 p-1 flex flex-wrap gap-1.5">
                <template x-for="p in popularAreas" :key="p">
                  <button type="button" @click="selectArea(p)"
                    class="px-2.5 py-1 text-xs font-medium rounded-md bg-[#FAF9F6] dark:bg-[#222724] hover:bg-[#1B3D2F] hover:text-white dark:hover:bg-[#1B3D2F] text-[#2D312E] dark:text-[#D5D8D3] border border-[#E5E3DC] dark:border-[#303632] transition cursor-pointer flex items-center gap-1">
                    <span x-text="p"></span>
                  </button>
                </template>
              </div>

              {{-- Matching Results --}}
              <div class="space-y-0.5">
                <template x-for="item in (areaKeyword ? filteredRegions() : allRegions.slice(0, 15))" :key="item">
                  <button type="button" @click="selectArea(item)"
                    class="w-full px-2.5 py-1.5 rounded-lg text-left text-xs sm:text-sm font-medium text-[#171A19] dark:text-stone-200 hover:bg-[#FAF9F6] dark:hover:bg-[#222724] hover:text-[#1B3D2F] dark:hover:text-[#A3B899] transition flex items-center justify-between group cursor-pointer">
                    <div class="flex items-center gap-2 min-w-0">
                      <i class="ri-map-pin-line text-[#85877F] group-hover:text-[#1B3D2F] text-xs shrink-0"></i>
                      <span class="truncate" x-text="item"></span>
                    </div>
                    <i class="ri-arrow-right-s-line text-stone-300 group-hover:text-[#1B3D2F] text-sm shrink-0"></i>
                  </button>
                </template>

                <div x-show="areaKeyword && filteredRegions().length === 0" class="py-3 text-center text-xs text-[#85877F]">
                  Không tìm thấy khu vực khớp với "<span x-text="areaKeyword"></span>".<br>
                  <span class="text-[11px] text-stone-400">Bạn vẫn có thể bấm "Lọc phòng" để tìm theo từ khóa tự do.</span>
                </div>
              </div>
            </div>
          </div>

          {{-- 2. Khoảng giá (Từ - Đến) --}}
          <div class="flex items-center gap-1.5 grow min-w-[200px]">
            <input type="number" name="min" value="{{ request('min') }}" placeholder="Giá từ (₫)"
              class="w-1/2 px-3 py-2 text-xs sm:text-sm font-medium rounded-lg bg-[#FAF9F6] dark:bg-[#1F2321] border border-[#E5E3DC] dark:border-[#303632] text-[#171A19] dark:text-white focus:bg-white dark:focus:bg-[#181B19] focus:outline-none focus:border-[#1B3D2F] dark:focus:border-[#7EA089] placeholder-[#9EA09B]">
            <span class="text-[#85877F] text-xs font-bold">—</span>
            <input type="number" name="max" value="{{ request('max') }}" placeholder="Đến (₫)"
              class="w-1/2 px-3 py-2 text-xs sm:text-sm font-medium rounded-lg bg-[#FAF9F6] dark:bg-[#1F2321] border border-[#E5E3DC] dark:border-[#303632] text-[#171A19] dark:text-white focus:bg-white dark:focus:bg-[#181B19] focus:outline-none focus:border-[#1B3D2F] dark:focus:border-[#7EA089] placeholder-[#9EA09B]">
          </div>

          {{-- 3. Sắp xếp --}}
          <div class="w-full sm:w-auto min-w-[130px]">
            <select name="sort"
              class="w-full px-3 py-2 text-xs sm:text-sm font-medium rounded-lg bg-[#FAF9F6] dark:bg-[#1F2321] border border-[#E5E3DC] dark:border-[#303632] text-[#171A19] dark:text-white focus:bg-white dark:focus:bg-[#181B19] focus:outline-none focus:border-[#1B3D2F] dark:focus:border-[#7EA089] cursor-pointer">
              <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Mới cập nhật</option>
              <option value="asc" {{ request('sort') == 'asc' ? 'selected' : '' }}>Giá: Thấp → Cao</option>
              <option value="desc" {{ request('sort') == 'desc' ? 'selected' : '' }}>Giá: Cao → Thấp</option>
              <option value="area" {{ request('sort') == 'area' ? 'selected' : '' }}>Diện tích lớn nhất</option>
            </select>
          </div>

          {{-- Nút Tìm / Lọc --}}
          <button type="submit" class="w-full sm:w-auto px-5 py-2 bg-[#1B3D2F] hover:bg-[#142F24] text-white font-semibold text-xs sm:text-sm rounded-lg shadow-2xs transition flex items-center justify-center gap-1.5 shrink-0 cursor-pointer">
            <i class="ri-search-2-line"></i>
            <span>Lọc phòng</span>
          </button>
        </form>

        {{-- Nút Tư vấn AI Gợi ý --}}
        <button type="button" @click="openAiModal = true"
          class="w-full lg:w-auto px-3.5 py-2 rounded-lg bg-[#FAF9F6] dark:bg-[#202522] hover:bg-[#EAE8E1] dark:hover:bg-[#29302B] text-[#1B3D2F] dark:text-[#A3B899] font-semibold text-xs sm:text-sm border border-[#D8D4CA] dark:border-[#353C37] transition flex items-center justify-center gap-1.5 shrink-0 cursor-pointer whitespace-nowrap">
          <i class="ri-sparkling-fill text-[#A6824D] text-sm"></i>
          <span>AI Gợi ý phòng</span>
        </button>

      </div>

      {{-- Hàng chọn nhanh danh mục (Quick Category Strip) --}}
      @php
        $currentCat = request('category', '');
        $categoriesMap = [
          '' => ['label' => 'Tất cả phòng', 'icon' => 'ri-home-line'],
          'sinh_vien' => ['label' => 'Sinh viên', 'icon' => 'ri-graduation-cap-line'],
          'studio' => ['label' => 'Studio / Mini', 'icon' => 'ri-building-line'],
          'o_ghep' => ['label' => 'Ở ghép', 'icon' => 'ri-team-line'],
          'sleepbox' => ['label' => 'Sleepbox / KTX', 'icon' => 'ri-hotel-bed-line'],
          'nguyen_can' => ['label' => 'Nguyên căn', 'icon' => 'ri-community-line'],
          'smart_home' => ['label' => 'Smart Home', 'icon' => 'ri-cpu-line'],
        ];
      @endphp
      <div class="mt-2.5 pt-2 border-t border-[#EAE8E1] dark:border-[#262B28] flex items-center gap-1.5 overflow-x-auto no-scrollbar pb-0.5">
        <span class="text-[11px] font-semibold text-[#85877F] uppercase tracking-wider shrink-0 mr-1">
          Phân loại:
        </span>
        @foreach($categoriesMap as $catKey => $catInfo)
          <a href="{{ request()->fullUrlWithQuery(['category' => $catKey ?: null, 'page' => 1]) }}"
             class="px-2.5 py-1 rounded-md text-xs font-medium whitespace-nowrap transition shrink-0 flex items-center gap-1 cursor-pointer {{ $currentCat === $catKey ? 'bg-[#1B3D2F] text-white shadow-2xs font-semibold' : 'bg-[#FAF9F6] dark:bg-[#1E2320] text-[#555955] dark:text-[#A7AAA4] hover:bg-[#EAE8E1] dark:hover:bg-[#282E2A] border border-[#E5E3DC] dark:border-[#2D3330]' }}">
            <i class="{{ $catInfo['icon'] }} text-xs"></i>
            <span>{{ $catInfo['label'] }}</span>
          </a>
        @endforeach
      </div>

    </div>
  </section>

  {{-- ============================================================ --}}
  {{-- 📋 2. KẾT QUẢ TÌM KIẾM & DANH SÁCH BẤT ĐỘNG SẢN --}}
  {{-- ============================================================ --}}
  <section id="danh-sach-phong" class="py-8 bg-[#FAF9F6] dark:bg-[#121514] scroll-mt-28 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

      {{-- Thống kê số lượng & Thẻ bộ lọc đang hoạt động (Active Filter Chips) --}}
      @php
        $activeArea = request('dia_chi') ?: request('district') ?: request('area') ?: request('search');
        $hasFilters = !empty($activeArea) || request()->filled('min') || request()->filled('max') || request()->filled('category') || (request()->filled('sort') && request('sort') !== 'newest');
      @endphp
      <div class="mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-3 border-b border-[#E5E3DC] dark:border-[#262B28]">
        <div class="flex items-center gap-2.5 flex-wrap">
          <h1 class="text-base sm:text-lg font-bold text-[#171A19] dark:text-white">
            Tìm thấy <span class="text-[#1B3D2F] dark:text-[#A3B899] font-black">{{ count($data ?? []) }}</span> phòng phù hợp
          </h1>
          @if(!$hasFilters && !empty($activeFilterTitle))
            <span class="text-xs px-2.5 py-0.5 rounded-md bg-stone-100 dark:bg-stone-800 text-stone-700 dark:text-stone-300 font-medium border border-stone-200 dark:border-stone-700">
              {{ $activeFilterTitle }}
            </span>
          @endif
        </div>

        @if($hasFilters)
          <div class="flex items-center gap-2 flex-wrap">
            {{-- Chip Khu vực --}}
            @if(!empty($activeArea))
              <a href="{{ request()->fullUrlWithQuery(['dia_chi' => null, 'district' => null, 'area' => null, 'search' => null, 'page' => 1]) }}"
                 class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-xs font-medium bg-white dark:bg-[#181B19] text-[#171A19] dark:text-white border border-[#E5E3DC] dark:border-[#303632] hover:border-red-400 hover:text-red-600 transition group cursor-pointer"
                 title="Xóa bộ lọc khu vực này">
                <i class="ri-map-pin-line text-[#85877F]"></i>
                <span>{{ $activeArea }}</span>
                <i class="ri-close-line text-xs text-stone-400 group-hover:text-red-600"></i>
              </a>
            @endif

            {{-- Chip Khoảng giá --}}
            @if(request()->filled('min') && request()->filled('max'))
              @php
                $minVal = floatval(request('min'));
                $maxVal = floatval(request('max'));
                $minFmt = ($minVal % 1000000 === 0) ? ($minVal / 1000000) : number_format($minVal / 1000000, 1);
                $maxFmt = ($maxVal % 1000000 === 0) ? ($maxVal / 1000000) : number_format($maxVal / 1000000, 1);
              @endphp
              <a href="{{ request()->fullUrlWithQuery(['min' => null, 'max' => null, 'page' => 1]) }}"
                 class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-xs font-medium bg-white dark:bg-[#181B19] text-[#171A19] dark:text-white border border-[#E5E3DC] dark:border-[#303632] hover:border-red-400 hover:text-red-600 transition group cursor-pointer"
                 title="Xóa bộ lọc giá">
                <i class="ri-money-dollar-circle-line text-[#85877F]"></i>
                <span>{{ $minFmt }}tr - {{ $maxFmt }}tr</span>
                <i class="ri-close-line text-xs text-stone-400 group-hover:text-red-600"></i>
              </a>
            @elseif(request()->filled('min'))
              @php
                $minVal = floatval(request('min'));
                $minFmt = ($minVal % 1000000 === 0) ? ($minVal / 1000000) : number_format($minVal / 1000000, 1);
              @endphp
              <a href="{{ request()->fullUrlWithQuery(['min' => null, 'page' => 1]) }}"
                 class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-xs font-medium bg-white dark:bg-[#181B19] text-[#171A19] dark:text-white border border-[#E5E3DC] dark:border-[#303632] hover:border-red-400 hover:text-red-600 transition group cursor-pointer"
                 title="Xóa bộ lọc giá">
                <span>Từ {{ $minFmt }}tr</span>
                <i class="ri-close-line text-xs text-stone-400 group-hover:text-red-600"></i>
              </a>
            @elseif(request()->filled('max'))
              @php
                $maxVal = floatval(request('max'));
                $maxFmt = ($maxVal % 1000000 === 0) ? ($maxVal / 1000000) : number_format($maxVal / 1000000, 1);
              @endphp
              <a href="{{ request()->fullUrlWithQuery(['max' => null, 'page' => 1]) }}"
                 class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-xs font-medium bg-white dark:bg-[#181B19] text-[#171A19] dark:text-white border border-[#E5E3DC] dark:border-[#303632] hover:border-red-400 hover:text-red-600 transition group cursor-pointer"
                 title="Xóa bộ lọc giá">
                <span>Đến {{ $maxFmt }}tr</span>
                <i class="ri-close-line text-xs text-stone-400 group-hover:text-red-600"></i>
              </a>
            @endif

            {{-- Chip Danh mục --}}
            @if(request()->filled('category') && isset($categoriesMap[request('category')]))
              <a href="{{ request()->fullUrlWithQuery(['category' => null, 'page' => 1]) }}"
                 class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-xs font-medium bg-white dark:bg-[#181B19] text-[#171A19] dark:text-white border border-[#E5E3DC] dark:border-[#303632] hover:border-red-400 hover:text-red-600 transition group cursor-pointer">
                <span>{{ $categoriesMap[request('category')]['label'] }}</span>
                <i class="ri-close-line text-xs text-stone-400 group-hover:text-red-600"></i>
              </a>
            @endif

            {{-- Nút Xóa tất cả --}}
            <a href="{{ route('listing') }}"
               class="inline-flex items-center gap-1 px-2.5 py-1 rounded-md bg-[#FAF9F6] hover:bg-stone-200 dark:bg-[#1E2320] dark:hover:bg-[#282E2A] text-[#70746F] dark:text-stone-300 text-xs font-medium border border-[#E5E3DC] dark:border-[#2D3330] transition cursor-pointer"
               title="Đặt lại toàn bộ tiêu chí">
              <i class="ri-refresh-line"></i> Xóa tất cả
            </a>
          </div>
        @endif
      </div>

      {{-- 🏛️ TRƯỜNG HỢP: KHÔNG CÓ PHÒNG THỎA MÃN TIÊU CHÍ BẮT BUỘC --}}
      @if($recommend_no_match)
        <div class="mb-10 rounded-2xl bg-white dark:bg-[#181B19] border border-amber-200/80 dark:border-amber-800/40 p-6 sm:p-8 shadow-xs">
          <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 pb-5 border-b border-[#EAE8E1] dark:border-[#282D2A]">
            <div class="flex items-center gap-3">
              <div class="w-10 h-10 rounded-xl bg-amber-50 dark:bg-amber-950/40 text-amber-700 dark:text-amber-400 flex items-center justify-center text-xl border border-amber-200 dark:border-amber-800/50 shrink-0">
                <i class="ri-shield-keyhole-line"></i>
              </div>
              <div>
                <div class="flex items-center gap-2">
                  <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider bg-amber-100/70 dark:bg-amber-900/40 text-amber-800 dark:text-amber-300 border border-amber-200 dark:border-amber-700/50">
                    Lọc Theo Yêu Cầu
                  </span>
                  <span class="text-xs text-[#70746F] dark:text-stone-400">Không có phòng vi phạm</span>
                </div>
                <h3 class="text-lg sm:text-xl font-bold text-[#171A19] dark:text-white mt-0.5">
                  Chưa Tìm Thấy Phòng Nào Thỏa Mãn Đầy Đủ Yêu Cầu Này
                </h3>
              </div>
            </div>
            <button type="button" @click="openAiModal = true"
              class="px-4 py-2 bg-[#1B3D2F] hover:bg-[#142F24] text-white text-xs font-semibold rounded-lg transition flex items-center gap-1.5 cursor-pointer shrink-0">
              <i class="ri-equalizer-line"></i>
              <span>Điều chỉnh tiêu chí</span>
            </button>
          </div>

          <div class="mt-5 grid sm:grid-cols-2 lg:grid-cols-4 gap-3 text-xs">
            <div class="p-3.5 rounded-xl bg-[#FAF9F6] dark:bg-[#1E2320] border border-[#E5E3DC] dark:border-[#282D2A]">
              <span class="text-[#70746F] dark:text-stone-400 block mb-1 font-medium">Ngân sách tối đa</span>
              <span class="text-sm font-bold text-[#171A19] dark:text-white block">
                {{ number_format($recommend_payload['budget'] ?? 0, 0, ',', '.') }} ₫/tháng
              </span>
              <span class="text-[11px] text-emerald-700 dark:text-emerald-400 mt-1 inline-flex items-center gap-1">
                <i class="ri-lock-line"></i> Trong giới hạn ngân sách
              </span>
            </div>

            <div class="p-3.5 rounded-xl bg-[#FAF9F6] dark:bg-[#1E2320] border border-[#E5E3DC] dark:border-[#282D2A]">
              <span class="text-[#70746F] dark:text-stone-400 block mb-1 font-medium">Số người ở</span>
              <span class="text-sm font-bold text-[#171A19] dark:text-white block">
                {{ $recommend_payload['people'] ?? 1 }} người
              </span>
              <span class="text-[11px] text-emerald-700 dark:text-emerald-400 mt-1 inline-flex items-center gap-1">
                <i class="ri-user-follow-line"></i> Đủ chỗ ở
              </span>
            </div>

            <div class="p-3.5 rounded-xl bg-[#FAF9F6] dark:bg-[#1E2320] border border-[#E5E3DC] dark:border-[#282D2A]">
              <span class="text-[#70746F] dark:text-stone-400 block mb-1 font-medium">Trạng thái phòng</span>
              <span class="text-sm font-bold text-[#171A19] dark:text-white block">
                Chỉ phòng đang trống
              </span>
              <span class="text-[11px] text-emerald-700 dark:text-emerald-400 mt-1 inline-flex items-center gap-1">
                <i class="ri-checkbox-circle-line"></i> Sẵn sàng dọn vào
              </span>
            </div>

            <div class="p-3.5 rounded-xl bg-[#FAF9F6] dark:bg-[#1E2320] border border-[#E5E3DC] dark:border-[#282D2A]">
              <span class="text-[#70746F] dark:text-stone-400 block mb-1 font-medium">Khu vực tìm kiếm</span>
              <span class="text-sm font-bold text-[#171A19] dark:text-white block truncate">
                {{ !empty($recommend_payload['dia_chi']) ? $recommend_payload['dia_chi'] : 'Toàn thành phố' }}
              </span>
              <span class="text-[11px] text-[#70746F] dark:text-stone-400 mt-1 inline-flex items-center gap-1">
                <i class="ri-map-pin-line"></i> {{ !empty($recommend_payload['strict_location']) ? 'Bắt buộc đúng quận' : 'Ưu tiên khu vực' }}
              </span>
            </div>
          </div>

          <div class="mt-5 p-4 rounded-xl bg-amber-50/60 dark:bg-amber-950/20 border border-amber-200/70 dark:border-amber-800/40 text-xs text-amber-900 dark:text-amber-200">
            <h4 class="font-bold flex items-center gap-1.5 mb-1.5 text-amber-950 dark:text-amber-100">
              <i class="ri-information-line"></i> Gợi ý điều chỉnh để tìm thấy nhiều phòng hơn:
            </h4>
            <p class="mb-2 leading-relaxed">
              {{ $recommend_no_match_data['message'] ?? 'Không tìm thấy phòng trọ nào đáp ứng đầy đủ đồng thời ngân sách và yêu cầu số người ở hiện tại.' }}
            </p>
            @if(!empty($recommend_no_match_data['adjustment_advice']))
              <div class="flex flex-wrap gap-2 mt-2">
                @foreach($recommend_no_match_data['adjustment_advice'] as $advice)
                  <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md bg-white/80 dark:bg-[#181B19]/80 border border-amber-300 dark:border-amber-700/60 font-medium text-amber-900 dark:text-amber-200">
                    <i class="ri-lightbulb-line text-amber-500" aria-hidden="true"></i> {{ $advice }}
                  </span>
                @endforeach
              </div>
            @endif
          </div>
        </div>
      @endif

      {{-- 💡 TOP 3 PHÒNG ĐỀ XUẤT THÔNG MINH --}}
      @if(!empty($recommendations))
        <div class="mb-10 rounded-2xl bg-white dark:bg-[#181B19] border-2 border-[#1B3D2F]/25 dark:border-[#7EA089]/30 p-6 sm:p-8 shadow-xs">
          
          {{-- Header Showcase --}}
          <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 pb-6 border-b border-[#EAE8E1] dark:border-[#282D2A] mb-6">
            <div>
              <div class="flex flex-wrap items-center gap-2 mb-1.5">
                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded text-[11px] font-bold bg-[#FAF6EE] dark:bg-[#2A241B] text-[#8C6D3B] dark:text-[#E8D7B8] border border-[#E5DAC0] dark:border-[#524430] uppercase tracking-wider">
                  <i class="ri-sparkling-fill text-[#A6824D]"></i>
                  Gợi Ý Thông Minh Bằng AI
                </span>
                <span class="text-xs text-[#70746F] dark:text-stone-400 font-medium">
                  Đã lọc kỹ theo ngân sách & sức chứa
                </span>
              </div>
              <h3 class="text-xl sm:text-2xl font-bold text-[#171A19] dark:text-white">
                Top 3 Phương Án Phòng Trọ Phù Hợp Nhất
              </h3>
              <p class="text-xs text-[#70746F] dark:text-stone-400 mt-1 max-w-2xl leading-relaxed">
                Hệ thống đã chọn lọc các phòng còn trống, phù hợp ngân sách và sắp xếp theo mức độ tiện nghi đúng với nhu cầu của bạn.
              </p>
            </div>

            <div class="flex flex-wrap items-center gap-2 shrink-0">
              @if(!empty($recommend_payload))
                <div class="hidden sm:inline-flex items-center text-xs text-[#70746F] dark:text-stone-400 font-medium bg-[#FAF9F6] dark:bg-[#222724] px-3 py-1.5 rounded-lg border border-[#E5E3DC] dark:border-[#303632]">
                  Ngân sách: <span class="font-bold text-[#1B3D2F] dark:text-[#A3B899] ml-1">{{ number_format($recommend_payload['budget'] ?? 0, 0, ',', '.') }} ₫</span>
                  <span class="mx-1.5">•</span>
                  {{ $recommend_payload['people'] ?? 1 }} người
                </div>
              @endif

              {{-- Nút Mở So Sánh 3 Phòng --}}
              <button type="button" @click="openCompareModal = true"
                class="px-3.5 py-2 bg-[#FAF9F6] dark:bg-[#222724] hover:bg-[#EAE8E1] dark:hover:bg-[#2C322F] text-[#171A19] dark:text-white font-semibold text-xs rounded-lg border border-[#E5E3DC] dark:border-[#303632] transition flex items-center gap-1.5 cursor-pointer">
                <i class="ri-scales-3-line text-[#1B3D2F] dark:text-[#A3B899]"></i>
                <span>So sánh 3 phòng</span>
              </button>

              {{-- Nút Điều chỉnh lại --}}
              <button type="button" @click="openAiModal = true"
                class="px-3.5 py-2 bg-[#1B3D2F] hover:bg-[#142F24] text-white font-semibold text-xs rounded-lg transition flex items-center gap-1.5 cursor-pointer">
                <i class="ri-equalizer-line"></i>
                <span>Chỉnh tiêu chí</span>
              </button>
            </div>
          </div>

          {{-- 3 Recommended Room Cards Grid --}}
          <div class="grid gap-6 md:grid-cols-3">
            @foreach($recommendations as $idx => $rec)
              @php
                $item = is_array($rec) ? $rec : (array) $rec;
                $detailUrl = isset($item['id']) ? url('/bai-dang/' . $item['id']) : '#';
                $thumb = $item['anh_dai_dien'] ?? asset('upload/room1.jpg');
                $priceDisplay = $item['gia_hien_thi']
                  ?? ($item['gia_niem_yet'] ?? null ? number_format($item['gia_niem_yet'], 0, ',', '.') . ' ₫' : 'Liên hệ');
                $satisfaction = round(floatval($item['satisfaction_score'] ?? 95), 1);
                $rankNum = $item['ranking_rank'] ?? ($idx + 1);
                $explanations = $item['explanations'] ?? null;
                $factualMatches = $explanations['factual_matches'] ?? [];
                $prefMatches = $explanations['preference_matches'] ?? [];
                $tradeOffs = $explanations['trade_offs'] ?? [];
                $chuTroName = $item['chu_tro']['name'] ?? $item['nguoi_dang']['ho_ten'] ?? 'Chủ nhà';
                $chuTroPhone = $item['chu_tro']['phone'] ?? $item['nguoi_dang']['so_dien_thoai'] ?? '';
              @endphp

              <article class="motion-reveal motion-stagger-{{ ($idx % 3) + 1 }} card-lift-hover bg-[#FAF9F6] dark:bg-[#1E2320] rounded-xl border border-[#E5E3DC] dark:border-[#2D3330] overflow-hidden flex flex-col h-full hover:border-[#1B3D2F] dark:hover:border-[#7EA089] hover:shadow-md transition-all duration-200">
                
                {{-- Card Media --}}
                <div class="relative aspect-[16/10] w-full bg-stone-200 overflow-hidden">
                  <a href="{{ $detailUrl }}" class="block w-full h-full cursor-pointer" title="{{ $item['tieu_de'] ?? 'Xem chi tiết phòng trọ' }}">
                    <img src="{{ $thumb }}" alt="{{ $item['tieu_de'] ?? 'Phòng trọ' }}" class="w-full h-full object-cover">
                  </a>

                  {{-- Rank & Satisfaction Badge --}}
                  <div class="absolute top-2.5 left-2.5 z-10 flex items-center gap-1.5 pointer-events-none">
                    @if($rankNum === 1)
                      <span class="bg-[#1B3D2F] text-white text-[11px] font-bold px-2.5 py-0.5 rounded shadow-sm border border-white/10 flex items-center gap-1">
                        <i class="ri-vip-crown-fill text-[#C5A574]"></i> #1 Khuyên dùng
                      </span>
                    @else
                      <span class="bg-[#171A19]/85 text-white text-[11px] font-bold px-2 py-0.5 rounded backdrop-blur-md border border-white/10">
                        #{{ $rankNum }}
                      </span>
                    @endif
                    <span class="bg-white/90 dark:bg-[#181B19]/90 text-[#171A19] dark:text-white text-[10px] font-bold px-2 py-0.5 rounded backdrop-blur-md border border-[#E5E3DC] dark:border-[#303632]">
                      Khớp {{ $satisfaction }}%
                    </span>
                  </div>

                  {{-- Room Availability Chip --}}
                  <span class="absolute top-2.5 right-2.5 z-10 bg-emerald-800/90 text-white text-[10px] font-semibold px-2 py-0.5 rounded backdrop-blur-md pointer-events-none">
                    Phòng trống
                  </span>
                </div>

                {{-- Card Content --}}
                <div class="p-4 sm:p-5 grow flex flex-col justify-between">
                  <div>
                    {{-- Title --}}
                    <h4 class="text-sm font-bold text-[#171A19] dark:text-white line-clamp-2 mb-1.5 min-h-[2.5rem] leading-snug">
                      <a href="{{ $detailUrl }}" class="hover:text-[#1B3D2F] dark:hover:text-[#A3B899] transition">
                        {{ $item['tieu_de'] ?? 'Phòng trọ' }}
                      </a>
                    </h4>

                    {{-- Address --}}
                    <p class="text-xs text-[#70746F] dark:text-stone-400 mb-3 flex items-center gap-1 truncate">
                      <i class="ri-map-pin-line text-[#85877F] shrink-0"></i>
                      <span>{{ $item['dia_chi'] ?? 'TP. Hồ Chí Minh' }}</span>
                    </p>

                    {{-- Specs Matrix --}}
                    <div class="grid grid-cols-3 gap-2 py-2 px-2.5 rounded-lg bg-white dark:bg-[#181B19] border border-[#EAE8E1] dark:border-[#282D2A] text-center mb-3">
                      <div>
                        <span class="text-[10px] text-[#85877F] block">Diện tích</span>
                        <span class="text-xs font-bold text-[#171A19] dark:text-white">{{ $item['dien_tich'] ?? '--' }} m²</span>
                      </div>
                      <div class="border-x border-[#EAE8E1] dark:border-[#282D2A]">
                        <span class="text-[10px] text-[#85877F] block">Sức chứa</span>
                        <span class="text-xs font-bold text-[#171A19] dark:text-white">{{ $item['suc_chua'] ?? 2 }} người</span>
                      </div>
                      <div>
                        <span class="text-[10px] text-[#85877F] block">Tiền cọc</span>
                        <span class="text-xs font-bold text-[#171A19] dark:text-white truncate block">
                          {{ isset($item['tien_coc']) && $item['tien_coc'] ? number_format($item['tien_coc'], 0, ',', '.') . '₫' : '1 tháng' }}
                        </span>
                      </div>
                    </div>

                    {{-- Grounded AI Explainability Breakdown --}}
                    <div class="rounded-lg bg-white dark:bg-[#181B19] p-3 border border-[#EAE8E1] dark:border-[#282D2A] space-y-2 mb-3 text-[11px]">
                      {{-- 1. Factual Hard Requirements Satisfied --}}
                      <div>
                        <span class="font-bold text-emerald-800 dark:text-emerald-400 block mb-1 flex items-center gap-1">
                          <i class="ri-checkbox-circle-fill text-xs"></i> Tiêu chí đáp ứng:
                        </span>
                        <ul class="space-y-0.5 text-[#555955] dark:text-stone-300 pl-4 list-disc marker:text-emerald-600">
                          @if(!empty($factualMatches))
                            @foreach(array_slice($factualMatches, 0, 2) as $fact)
                              <li class="line-clamp-1">{{ $fact }}</li>
                            @endforeach
                          @else
                            <li>Đúng ngân sách và phòng đang trống</li>
                            <li>Sức chứa đáp ứng {{ $recommend_payload['people'] ?? 1 }} người</li>
                          @endif
                        </ul>
                      </div>

                      {{-- 2. Soft Preferences Matched --}}
                      @if(!empty($prefMatches))
                        <div class="pt-1.5 border-t border-[#F0EFEA] dark:border-[#222724]">
                          <span class="font-bold text-[#1B3D2F] dark:text-[#A3B899] block mb-1 flex items-center gap-1">
                            <i class="ri-thumb-up-fill text-xs"></i> Tiện ích nổi bật:
                          </span>
                          <ul class="space-y-0.5 text-[#555955] dark:text-stone-300 pl-4 list-disc marker:text-[#1B3D2F]">
                            @foreach(array_slice($prefMatches, 0, 2) as $pref)
                              <li class="line-clamp-1">{{ $pref }}</li>
                            @endforeach
                          </ul>
                        </div>
                      @endif

                      {{-- 3. Trade-offs to note (if any) --}}
                      @if(!empty($tradeOffs))
                        <div class="pt-1.5 border-t border-[#F0EFEA] dark:border-[#222724]">
                          <span class="font-bold text-amber-700 dark:text-amber-400 block mb-0.5 flex items-center gap-1">
                            <i class="ri-alert-line text-xs"></i> Điểm cần lưu ý:
                          </span>
                          <p class="text-[10px] text-amber-800 dark:text-amber-300 line-clamp-1">
                            {{ $tradeOffs[0] }}
                          </p>
                        </div>
                      @endif
                    </div>
                  </div>

                  {{-- Card Footer --}}
                  <div class="pt-3 border-t border-[#EAE8E1] dark:border-[#282D2A] flex items-center justify-between gap-2">
                    <div>
                      <span class="text-[10px] text-[#85877F] block">Giá thuê niêm yết</span>
                      <span class="text-base font-bold text-[#1B3D2F] dark:text-[#A3B899]">{{ $priceDisplay }}</span>
                    </div>

                    <div class="flex items-center gap-1.5">
                      @if(!empty($chuTroPhone))
                        <button type="button" onclick="showChuTroInfo('{{ addslashes($chuTroName) }}', '{{ addslashes($chuTroPhone) }}')"
                          title="Liên hệ chủ trọ"
                          class="p-2 rounded-lg bg-stone-100 hover:bg-stone-200 dark:bg-[#282D2A] dark:hover:bg-[#343B37] text-[#171A19] dark:text-white transition cursor-pointer">
                          <i class="ri-phone-line text-sm"></i>
                        </button>
                      @endif

                      <a href="{{ $detailUrl }}"
                        class="px-3 py-2 bg-[#1B3D2F] hover:bg-[#142F24] text-white font-semibold text-xs rounded-lg transition inline-flex items-center gap-1">
                        <span>Chi tiết</span>
                        <i class="ri-arrow-right-line text-xs"></i>
                      </a>
                    </div>
                  </div>

                </div>
              </article>
            @endforeach
          </div>
        </div>
      @endif

      {{-- 🏛️ DANH SÁCH THẺ BẤT ĐỘNG SẢN (ARCHITECTURAL INVENTORY GRID) --}}
      @if(empty($data))
        <div class="text-center py-16 bg-white dark:bg-[#181B19] rounded-xl border border-[#E5E3DC] dark:border-[#282D2A] p-6 sm:p-10 shadow-2xs">
          <div class="w-14 h-14 rounded-xl bg-[#FAF9F6] dark:bg-[#222724] text-[#85877F] mx-auto flex items-center justify-center text-2xl mb-4 border border-[#E5E3DC] dark:border-[#303632]">
            <i class="ri-search-line"></i>
          </div>
          <h3 class="text-lg sm:text-xl font-bold text-[#171A19] dark:text-white mb-2">
            Không tìm thấy phòng trọ khớp với tiêu chí lựa chọn
          </h3>
          <p class="text-[#70746F] dark:text-stone-400 text-xs sm:text-sm max-w-md mx-auto mb-6">
            Quý khách có thể thử mở rộng khoảng giá, thay đổi khu vực tìm kiếm hoặc sử dụng tính năng AI Gợi ý phòng.
          </p>
          <div class="flex flex-wrap items-center justify-center gap-3">
            <a href="{{ route('listing') }}"
               class="px-4 py-2 rounded-lg bg-[#FAF9F6] hover:bg-stone-200 dark:bg-[#222724] dark:hover:bg-[#2C322F] text-[#171A19] dark:text-white font-medium text-xs sm:text-sm border border-[#E5E3DC] dark:border-[#303632] transition">
              Xóa bộ lọc xem tất cả
            </a>
            <button type="button" @click="openAiModal = true"
              class="px-4 py-2 rounded-lg bg-[#1B3D2F] hover:bg-[#142F24] text-white font-semibold text-xs sm:text-sm transition flex items-center gap-1.5 cursor-pointer">
              <i class="ri-sparkling-fill text-[#A6824D]"></i>
              <span>Nhờ AI Gợi ý phòng</span>
            </button>
          </div>
        </div>
      @else
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-7">
          @foreach($data as $item)
            <article class="motion-reveal motion-stagger-{{ ($loop->iteration % 3) + 1 }} card-lift-hover group bg-white dark:bg-[#181B19] border border-[#E5E3DC] dark:border-[#282D2A] hover:border-[#1B3D2F] dark:hover:border-[#7EA089] shadow-2xs hover:shadow-md transition-all duration-300 rounded-xl overflow-hidden flex flex-col h-full">

              {{-- 🖼 Picture Container --}}
              <div class="relative h-56 w-full bg-stone-100 dark:bg-stone-800 overflow-hidden">
                <a href="{{ url('/bai-dang/' . $item['id']) }}" class="block w-full h-full cursor-pointer" title="{{ $item['tieu_de'] }}">
                  @if(!empty($item['anh_dai_dien']))
                    <img src="{{ $item['anh_dai_dien'] }}" alt="{{ $item['tieu_de'] }}"
                         class="w-full h-full object-cover transition-transform duration-500 ease-out group-hover:scale-104">
                  @else
                    <div class="w-full h-full flex items-center justify-center bg-stone-100 dark:bg-stone-800 text-stone-400 text-xs">
                      Chưa có ảnh thực tế
                    </div>
                  @endif
                </a>

                {{-- Status Badges --}}
                <div class="absolute top-3 left-3 z-10 flex items-center gap-1.5 pointer-events-none">
                  <span class="bg-[#171A19]/90 backdrop-blur-md px-2.5 py-0.5 rounded text-[11px] font-semibold text-white tracking-wide border border-white/10">
                    P.{{ $item['so_phong'] ?? ($loop->iteration) }}
                  </span>
                  <span class="bg-[#1B3D2F]/90 backdrop-blur-md px-2.5 py-0.5 rounded text-[11px] font-medium text-white border border-white/10">
                    Đã xác minh
                  </span>
                </div>

                {{-- Availability Indicator --}}
                <div class="absolute bottom-3 left-3 z-10 pointer-events-none">
                  <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded bg-[#171A19]/80 backdrop-blur-md text-[11px] text-white font-medium border border-white/10">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                    <span>Còn phòng</span>
                  </span>
                </div>
              </div>

              {{-- 📝 Card Content --}}
              <div class="p-5 grow flex flex-col justify-between">
                <div>
                  {{-- Location --}}
                  <div class="flex items-center text-[#70746F] dark:text-[#A7AAA4] text-xs mb-1.5 font-medium">
                    <i class="ri-map-pin-line text-[#85877F] mr-1 text-sm shrink-0"></i>
                    <span class="truncate">{{ $item['dia_chi'] ?? 'TP. Hồ Chí Minh' }}</span>
                  </div>

                  {{-- Title --}}
                  <a href="{{ url('/bai-dang/' . $item['id']) }}" class="block mb-3">
                    <h3 class="text-base font-bold text-[#171A19] dark:text-white line-clamp-1 leading-snug group-hover:text-[#1B3D2F] dark:group-hover:text-[#A3B899] transition">
                      {{ $item['tieu_de'] }}
                    </h3>
                  </a>

                  {{-- Specs chips --}}
                  <div class="flex items-center gap-3 text-xs text-[#555955] dark:text-[#A7AAA4] font-medium mb-4 pb-3 border-b border-[#EAE8E1] dark:border-[#262B28]">
                    <span class="flex items-center gap-1">
                      <i class="ri-ruler-2-line text-[#85877F]"></i>
                      <span>{{ $item['dien_tich'] ? ($item['dien_tich'] . ' m²') : '22 m²' }}</span>
                    </span>
                    <span class="text-stone-300 dark:text-stone-700">•</span>
                    @php $tags = array_slice(explode(',', $item['tien_ich'] ?? ''), 0, 2); @endphp
                    @foreach($tags as $t)
                      @if(!empty(trim($t)))
                        <span class="truncate max-w-[90px]">{{ trim($t) }}</span>
                      @endif
                    @endforeach
                  </div>
                </div>

                <div>
                  {{-- Price & Details button --}}
                  <div class="flex items-baseline justify-between mb-3">
                    <div>
                      <span class="text-[10px] text-[#85877F] uppercase tracking-wider block">Giá thuê tháng:</span>
                      <span class="text-lg sm:text-xl font-bold text-[#1B3D2F] dark:text-[#A3B899]">
                        {{ $item['gia_hien_thi'] ?? 'Liên hệ' }}
                      </span>
                    </div>

                    <a href="{{ url('/bai-dang/' . $item['id']) }}"
                       class="px-3.5 py-2 rounded-lg bg-[#FAF9F6] dark:bg-[#202522] hover:bg-[#1B3D2F] hover:text-white dark:hover:bg-[#1B3D2F] text-[#1B3D2F] dark:text-[#A3B899] font-semibold text-xs border border-[#E5E3DC] dark:border-[#303632] transition">
                      Chi tiết
                    </a>
                  </div>

                  {{-- Quick Action Buttons --}}
                  <div class="pt-2.5 border-t border-[#EAE8E1] dark:border-[#262B28] flex justify-between text-xs text-[#555955] dark:text-[#A7AAA4] font-medium">
                    <button onclick="showChuTroInfo(this.dataset.chuTro, this.dataset.sdtChuTro)"
                            data-chu-tro="{{ e($item['chu_tro'] ?? 'Chủ nhà') }}"
                            data-sdt-chu-tro="{{ e($item['sdt_chu_tro'] ?? '0909000002') }}"
                            class="hover:text-[#1B3D2F] dark:hover:text-white flex items-center gap-1 transition cursor-pointer">
                      <i class="ri-phone-line text-[#1B3D2F] dark:text-[#A3B899]"></i> Gọi chủ nhà
                    </button>
                    <button onclick="showChuTroInfo(this.dataset.chuTro, this.dataset.sdtChuTro)"
                            data-chu-tro="{{ e($item['chu_tro'] ?? 'Chủ nhà') }}"
                            data-sdt-chu-tro="{{ e($item['sdt_chu_tro'] ?? '0909000002') }}"
                            class="hover:text-[#1B3D2F] dark:hover:text-white flex items-center gap-1 transition cursor-pointer">
                      <i class="ri-chat-1-line text-[#1B3D2F] dark:text-[#A3B899]"></i> Nhắn Zalo
                    </button>
                    <a href="{{ url('/bai-dang/' . $item['id']) }}" class="hover:text-[#1B3D2F] dark:hover:text-white flex items-center gap-1 transition">
                      Xem phòng <i class="ri-arrow-right-s-line text-stone-400"></i>
                    </a>
                  </div>
                </div>

              </div>
            </article>
          @endforeach
        </div>

        {{-- Phân trang Pagination --}}
        @if(!empty($meta))
          <div class="flex justify-center items-center gap-3 mt-12">
            @if($meta['current_page'] > 1)
              <a href="{{ request()->fullUrlWithQuery(['page' => $meta['current_page'] - 1]) }}"
                 class="px-3.5 py-1.5 rounded-lg border border-[#E5E3DC] dark:border-[#2D3330] text-[#171A19] dark:text-[#D5D8D3] font-medium text-xs hover:bg-white dark:hover:bg-[#1E2320] transition">
                « Trang trước
              </a>
            @endif
            <span class="text-xs font-semibold text-[#85877F]">
              Trang <span class="text-[#1B3D2F] dark:text-[#A3B899] font-bold">{{ $meta['current_page'] }}</span> / {{ $meta['last_page'] }}
            </span>
            @if($meta['current_page'] < $meta['last_page'])
              <a href="{{ request()->fullUrlWithQuery(['page' => $meta['current_page'] + 1]) }}"
                 class="px-3.5 py-1.5 rounded-lg border border-[#E5E3DC] dark:border-[#2D3330] text-[#171A19] dark:text-[#D5D8D3] font-medium text-xs hover:bg-white dark:hover:bg-[#1E2320] transition">
                Trang sau »
              </a>
            @endif
          </div>
        @endif
      @endif

    </div>

    {{-- Modal thông tin chủ nhà --}}
    <div id="modalChuTro" class="modal-backdrop-animate fixed inset-0 bg-[#121514]/70 backdrop-blur-xs hidden items-center justify-center z-50 p-4">
      <div class="modal-panel-animate bg-white dark:bg-[#181B19] rounded-xl border border-[#E5E3DC] dark:border-[#2D3330] w-full max-w-md p-6 text-center relative shadow-xl">
        <button onclick="closeModalChuTro()" class="micro-press absolute top-4 right-4 text-[#85877F] hover:text-[#171A19] dark:hover:text-white p-1">
          <i class="ri-close-line text-xl"></i>
        </button>

        <div class="w-12 h-12 rounded-lg bg-[#FAF9F6] dark:bg-[#222724] text-[#1B3D2F] dark:text-[#A3B899] mx-auto flex items-center justify-center text-2xl mb-3 border border-[#E5E3DC] dark:border-[#303632]">
          <i class="ri-user-star-line"></i>
        </div>

        <h3 class="text-base font-bold text-[#171A19] dark:text-white mb-2">Thông Tin Chủ Quản Lý</h3>
        <p id="modalChuTroName" class="text-[#555955] dark:text-[#A7AAA4] text-sm font-semibold"></p>
        <p id="modalChuTroPhone" class="mt-2 text-lg font-bold text-[#1B3D2F] dark:text-[#A3B899]"></p>

        <button onclick="closeModalChuTro()" 
                class="micro-press mt-6 w-full py-2.5 bg-[#FAF9F6] dark:bg-[#222724] hover:bg-[#EAE8E1] dark:hover:bg-[#2C322F] text-[#171A19] dark:text-white font-semibold text-xs rounded-lg border border-[#E5E3DC] dark:border-[#303632] transition">
          Đóng
        </button>
      </div>
    </div>
  </section>

  {{-- 🤖 POPUP MODAL: TƯ VẤN & GỢI Ý PHÒNG TỐI ƯU (DQN MODEL CONSULTANT) --}}
  <template x-teleport="body">
  <div x-show="openAiModal" style="display: none;"
    class="fixed inset-0 z-[9999] flex items-center justify-center p-4 bg-[#121514]/75 backdrop-blur-xs"
    x-transition:enter="transition ease-out duration-200"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-150"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0">

    <div @click.away="openAiModal = false"
      class="bg-white dark:bg-[#181B19] rounded-2xl max-w-2xl w-full p-6 sm:p-7 border border-[#E5E3DC] dark:border-[#2D3330] shadow-2xl relative flex flex-col max-h-[90vh] overflow-y-auto"
      x-transition:enter="transition ease-out duration-200"
      x-transition:enter-start="opacity-0 scale-98 translate-y-1"
      x-transition:enter-end="opacity-100 scale-100 translate-y-0">
      
      {{-- Modal Header --}}
      <div class="flex items-center justify-between border-b border-[#EAE8E1] dark:border-[#262B28] pb-4 mb-5">
        <div class="flex items-center gap-3">
          <div class="w-10 h-10 rounded-xl bg-[#FAF6EE] dark:bg-[#2A241B] text-[#A6824D] flex items-center justify-center text-xl border border-[#E5DAC0] dark:border-[#524430] shrink-0">
            <i class="ri-sparkling-fill"></i>
          </div>
          <div>
            <h3 class="text-base sm:text-lg font-bold text-[#171A19] dark:text-white">
              Gợi Ý Phòng Trọ Phù Hợp Bằng AI
            </h3>
            <p class="text-xs text-[#70746F] dark:text-stone-400">
              Tự động phân tích nhu cầu và chọn lọc những căn phòng trống, đúng ngân sách và tiện nghi nhất
            </p>
          </div>
        </div>
        <button type="button" @click="openAiModal = false"
          class="w-8 h-8 rounded-lg text-[#85877F] hover:text-[#171A19] dark:hover:text-white flex items-center justify-center transition cursor-pointer">
          <i class="ri-close-line text-xl"></i>
        </button>
      </div>

      {{-- 1-Click Persona Presets --}}
      <div class="mb-5">
        <label class="block text-[11px] font-bold text-[#85877F] uppercase tracking-wider mb-2">
          Gợi ý theo nhu cầu phổ biến (Chọn nhanh):
        </label>
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-2">
          <button type="button" @click="setPersona('student')"
            :class="aiPersona === 'student' ? 'border-[#1B3D2F] bg-[#FAF9F6] dark:bg-[#1E2320] text-[#1B3D2F] dark:text-[#A3B899] font-bold shadow-2xs' : 'border-[#E5E3DC] dark:border-[#282D2A] bg-white dark:bg-[#181B19] text-[#555955] dark:text-[#A7AAA4]'"
            class="p-2.5 rounded-xl border text-left transition cursor-pointer">
            <span class="font-bold text-xs block">Sinh viên</span>
            <span class="text-[10px] text-[#85877F] block mt-0.5">2.2tr • 18m² • 1 ng</span>
          </button>
          <button type="button" @click="setPersona('worker')"
            :class="aiPersona === 'worker' ? 'border-[#1B3D2F] bg-[#FAF9F6] dark:bg-[#1E2320] text-[#1B3D2F] dark:text-[#A3B899] font-bold shadow-2xs' : 'border-[#E5E3DC] dark:border-[#282D2A] bg-white dark:bg-[#181B19] text-[#555955] dark:text-[#A7AAA4]'"
            class="p-2.5 rounded-xl border text-left transition cursor-pointer">
            <span class="font-bold text-xs block">Người đi làm</span>
            <span class="text-[10px] text-[#85877F] block mt-0.5">4.0tr • 28m² • 1 ng</span>
          </button>
          <button type="button" @click="setPersona('roommates')"
            :class="aiPersona === 'roommates' ? 'border-[#1B3D2F] bg-[#FAF9F6] dark:bg-[#1E2320] text-[#1B3D2F] dark:text-[#A3B899] font-bold shadow-2xs' : 'border-[#E5E3DC] dark:border-[#282D2A] bg-white dark:bg-[#181B19] text-[#555955] dark:text-[#A7AAA4]'"
            class="p-2.5 rounded-xl border text-left transition cursor-pointer">
            <span class="font-bold text-xs block">Ở ghép</span>
            <span class="text-[10px] text-[#85877F] block mt-0.5">3.5tr • 32m² • 2 ng</span>
          </button>
          <button type="button" @click="setPersona('serviced')"
            :class="aiPersona === 'serviced' ? 'border-[#1B3D2F] bg-[#FAF9F6] dark:bg-[#1E2320] text-[#1B3D2F] dark:text-[#A3B899] font-bold shadow-2xs' : 'border-[#E5E3DC] dark:border-[#282D2A] bg-white dark:bg-[#181B19] text-[#555955] dark:text-[#A7AAA4]'"
            class="p-2.5 rounded-xl border text-left transition cursor-pointer">
            <span class="font-bold text-xs block">Căn hộ mini</span>
            <span class="text-[10px] text-[#85877F] block mt-0.5">5.5tr • 35m² • Full NT</span>
          </button>
        </div>
      </div>

      {{-- Form submit to recommend --}}
      <form action="{{ route('listing.recommend') }}" method="POST" @submit="aiIsLoading = true" class="space-y-5">
        @csrf
        <input type="hidden" name="mode" value="ai">
        <input type="hidden" name="dich_vu_id" :value="aiServices">
        <input type="hidden" name="people" :value="aiPeople">

        {{-- ======================================================== --}}
        {{-- PHẦN 1: TIÊU CHÍ BẮT BUỘC (NGÂN SÁCH & SỨC CHỨA) --}}
        {{-- ======================================================== --}}
        <div class="p-4 rounded-xl bg-amber-50/50 dark:bg-amber-950/20 border border-amber-200/60 dark:border-amber-800/40 space-y-3.5">
          <div class="flex items-center justify-between">
            <span class="inline-flex items-center gap-1.5 text-xs font-bold text-amber-900 dark:text-amber-200 uppercase tracking-wider">
              <i class="ri-shield-check-line text-amber-700 dark:text-amber-400"></i>
              1. Tiêu Chí Bắt Buộc (Ngân Sách & Sức Chứa)
            </span>
            <span class="text-[10px] text-amber-800/80 dark:text-amber-400 font-medium">Bắt buộc</span>
          </div>

          {{-- Budget Field --}}
          <div class="p-3 rounded-lg bg-white dark:bg-[#181B19] border border-amber-200/50 dark:border-amber-800/30 space-y-1.5">
            <div class="flex items-center justify-between">
              <label class="text-xs font-semibold text-[#171A19] dark:text-white">Ngân sách tối đa mỗi tháng:</label>
              <span class="text-xs font-bold text-[#1B3D2F] dark:text-[#A3B899]" x-text="formatMoney(aiBudget)"></span>
            </div>
            <input type="range" name="budget" min="1000000" max="10000000" step="200000" x-model.number="aiBudget"
              class="w-full accent-[#1B3D2F] cursor-pointer">
            <div class="flex justify-between text-[10px] text-[#85877F]">
              <span>1.0 Triệu</span>
              <span>10.0 Triệu</span>
            </div>
            <label class="flex items-center gap-2 pt-1 cursor-pointer">
              <input type="checkbox" name="strict_budget" value="1" x-model="aiStrictBudget"
                class="rounded accent-[#1B3D2F] text-xs">
              <span class="text-[11px] text-[#555955] dark:text-stone-300 font-medium">
                Giới hạn ngân sách nghiêm ngặt (Chỉ tìm phòng có giá bằng hoặc thấp hơn số tiền này)
              </span>
            </label>
          </div>

          {{-- Capacity & Room Status --}}
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
            {{-- Capacity --}}
            <div class="p-3 rounded-lg bg-white dark:bg-[#181B19] border border-amber-200/50 dark:border-amber-800/30 space-y-1.5">
              <div class="flex items-center justify-between">
                <label class="text-xs font-semibold text-[#171A19] dark:text-white">Số người ở:</label>
                <span class="text-xs font-bold text-[#1B3D2F] dark:text-[#A3B899]" x-text="aiPeople + ' người'"></span>
              </div>
              <div class="grid grid-cols-4 gap-1.5 pt-1">
                <button type="button" @click="aiPeople = 1"
                  :class="aiPeople === 1 ? 'bg-[#1B3D2F] text-white font-bold' : 'bg-[#FAF9F6] dark:bg-[#202522] text-[#555955] dark:text-stone-300 border border-[#E5E3DC] dark:border-[#303632]'"
                  class="py-1 rounded text-xs transition cursor-pointer">1 người</button>
                <button type="button" @click="aiPeople = 2"
                  :class="aiPeople === 2 ? 'bg-[#1B3D2F] text-white font-bold' : 'bg-[#FAF9F6] dark:bg-[#202522] text-[#555955] dark:text-stone-300 border border-[#E5E3DC] dark:border-[#303632]'"
                  class="py-1 rounded text-xs transition cursor-pointer">2 người</button>
                <button type="button" @click="aiPeople = 3"
                  :class="aiPeople === 3 ? 'bg-[#1B3D2F] text-white font-bold' : 'bg-[#FAF9F6] dark:bg-[#202522] text-[#555955] dark:text-stone-300 border border-[#E5E3DC] dark:border-[#303632]'"
                  class="py-1 rounded text-xs transition cursor-pointer">3 người</button>
                <button type="button" @click="aiPeople = 4"
                  :class="aiPeople >= 4 ? 'bg-[#1B3D2F] text-white font-bold' : 'bg-[#FAF9F6] dark:bg-[#202522] text-[#555955] dark:text-stone-300 border border-[#E5E3DC] dark:border-[#303632]'"
                  class="py-1 rounded text-xs transition cursor-pointer">4+ người</button>
              </div>
              <span class="text-[10px] text-[#85877F] block">Chỉ gợi ý phòng đủ chỗ cho số người này</span>
            </div>

            {{-- Room Availability --}}
            <div class="p-3 rounded-lg bg-white dark:bg-[#181B19] border border-amber-200/50 dark:border-amber-800/30 flex flex-col justify-between">
              <div>
                <span class="text-xs font-semibold text-[#171A19] dark:text-white block">Tình trạng phòng:</span>
                <span class="text-[11px] text-emerald-700 dark:text-emerald-400 font-bold flex items-center gap-1 mt-1">
                  <i class="ri-checkbox-circle-fill"></i> Chỉ tìm phòng đang trống
                </span>
              </div>
              <span class="text-[10px] text-[#85877F] block">Tất cả phòng đã có người thuê sẽ tự động được bỏ qua</span>
            </div>
          </div>

          {{-- Preferred Location --}}
          <div class="p-3 rounded-lg bg-white dark:bg-[#181B19] border border-amber-200/50 dark:border-amber-800/30 space-y-2">
            <div class="flex items-center justify-between">
              <label class="text-xs font-semibold text-[#171A19] dark:text-white">Khu vực tìm kiếm:</label>
              <label class="flex items-center gap-1.5 cursor-pointer">
                <input type="checkbox" name="strict_location" value="1" x-model="aiStrictLocation"
                  class="rounded accent-[#1B3D2F] text-xs">
                <span class="text-[11px] text-[#555955] dark:text-stone-300 font-medium">Bắt buộc đúng quận</span>
              </label>
            </div>

            <div class="relative">
              <i class="ri-map-pin-line text-[#85877F] absolute left-3 top-1/2 -translate-y-1/2 text-xs pointer-events-none"></i>
              <input type="text" name="dia_chi" x-model="aiDistrict" list="aiDistrictListModal"
                placeholder="Nhập quận, huyện, xã phường (hoặc để trống để tìm toàn thành phố)..."
                class="w-full pl-8 pr-7 py-2 text-xs bg-[#FAF9F6] dark:bg-[#1F2321] border border-[#E5E3DC] dark:border-[#303632] rounded-lg text-[#171A19] dark:text-white focus:bg-white dark:focus:bg-[#181B19] focus:outline-none focus:border-[#1B3D2F] transition">
              <button type="button" x-show="aiDistrict" @click="aiDistrict = ''"
                class="absolute right-2 top-1/2 -translate-y-1/2 text-[#85877F] hover:text-[#171A19] dark:hover:text-white text-xs p-1 cursor-pointer">
                <i class="ri-close-line"></i>
              </button>
              <datalist id="aiDistrictListModal">
                @foreach($regionNames ?? [] as $regName)
                  <option value="{{ $regName }}">
                @endforeach
              </datalist>
            </div>

            <div class="flex flex-wrap gap-1.5 text-xs">
              <button type="button" @click="aiDistrict = ''"
                :class="aiDistrict === '' ? 'bg-[#1B3D2F] text-white font-semibold' : 'bg-[#FAF9F6] dark:bg-[#1E2320] text-[#555955] dark:text-[#A7AAA4] border border-[#E5E3DC] dark:border-[#2D3330]'"
                class="px-2 py-0.5 rounded text-[11px] transition cursor-pointer">Tất cả</button>
              <button type="button" @click="aiDistrict = 'Bình Thạnh'"
                :class="aiDistrict.toLowerCase() === 'bình thạnh' ? 'bg-[#1B3D2F] text-white font-semibold' : 'bg-[#FAF9F6] dark:bg-[#1E2320] text-[#555955] dark:text-[#A7AAA4] border border-[#E5E3DC] dark:border-[#2D3330]'"
                class="px-2 py-0.5 rounded text-[11px] transition cursor-pointer">Bình Thạnh</button>
              <button type="button" @click="aiDistrict = 'Thủ Đức'"
                :class="aiDistrict.toLowerCase().includes('thủ đức') ? 'bg-[#1B3D2F] text-white font-semibold' : 'bg-[#FAF9F6] dark:bg-[#1E2320] text-[#555955] dark:text-[#A7AAA4] border border-[#E5E3DC] dark:border-[#2D3330]'"
                class="px-2 py-0.5 rounded text-[11px] transition cursor-pointer">TP. Thủ Đức</button>
              <button type="button" @click="aiDistrict = 'Quận 10'"
                :class="aiDistrict.toLowerCase() === 'quận 10' ? 'bg-[#1B3D2F] text-white font-semibold' : 'bg-[#FAF9F6] dark:bg-[#1E2320] text-[#555955] dark:text-[#A7AAA4] border border-[#E5E3DC] dark:border-[#2D3330]'"
                class="px-2 py-0.5 rounded text-[11px] transition cursor-pointer">Quận 10</button>
              <button type="button" @click="aiDistrict = 'Gò Vấp'"
                :class="aiDistrict.toLowerCase() === 'gò vấp' ? 'bg-[#1B3D2F] text-white font-semibold' : 'bg-[#FAF9F6] dark:bg-[#1E2320] text-[#555955] dark:text-[#A7AAA4] border border-[#E5E3DC] dark:border-[#2D3330]'"
                class="px-2 py-0.5 rounded text-[11px] transition cursor-pointer">Gò Vấp</button>
              <button type="button" @click="aiDistrict = 'Tân Bình'"
                :class="aiDistrict.toLowerCase() === 'tân bình' ? 'bg-[#1B3D2F] text-white font-semibold' : 'bg-[#FAF9F6] dark:bg-[#1E2320] text-[#555955] dark:text-[#A7AAA4] border border-[#E5E3DC] dark:border-[#2D3330]'"
                class="px-2 py-0.5 rounded text-[11px] transition cursor-pointer">Tân Bình</button>
            </div>
          </div>
        </div>

        {{-- ======================================================== --}}
        {{-- PHẦN 2: TIÊU CHÍ ƯU TIÊN (DIỆN TÍCH & TIỆN NGHI) --}}
        {{-- ======================================================== --}}
        <div class="p-4 rounded-xl bg-[#FAF9F6] dark:bg-[#1E2320] border border-[#E5E3DC] dark:border-[#282D2A] space-y-3.5">
          <div class="flex items-center justify-between">
            <span class="inline-flex items-center gap-1.5 text-xs font-bold text-[#1B3D2F] dark:text-[#A3B899] uppercase tracking-wider">
              <i class="ri-sparkling-line"></i>
              2. Tiêu Chí Ưu Tiên (Diện Tích & Tiện Nghi)
            </span>
            <span class="text-[10px] text-[#85877F] font-medium">Ưu tiên sắp xếp</span>
          </div>

          {{-- Area Slider --}}
          <div class="p-3 rounded-lg bg-white dark:bg-[#181B19] border border-[#EAE8E1] dark:border-[#282D2A] space-y-1">
            <div class="flex items-center justify-between">
              <label class="text-xs font-semibold text-[#171A19] dark:text-white">Diện tích phòng mong muốn:</label>
              <span class="text-xs font-bold text-[#1B3D2F] dark:text-[#A3B899]" x-text="aiArea + ' m²'"></span>
            </div>
            <input type="range" name="area" min="10" max="60" step="2" x-model.number="aiArea"
              class="w-full accent-[#1B3D2F] cursor-pointer">
            <div class="flex justify-between text-[10px] text-[#85877F]">
              <span>10 m² (Nhỏ gọn)</span>
              <span>30 m² (Rộng rãi)</span>
              <span>60 m² (Rất lớn)</span>
            </div>
          </div>

          {{-- Utilities Chips --}}
          <div class="p-3 rounded-lg bg-white dark:bg-[#181B19] border border-[#EAE8E1] dark:border-[#282D2A] space-y-1.5">
            <div class="flex items-center justify-between">
              <label class="text-xs font-semibold text-[#171A19] dark:text-white">Tiện ích ưu tiên:</label>
              <span class="text-[10px] text-[#85877F]">Bấm chọn hoặc bỏ chọn</span>
            </div>

            <div class="flex flex-wrap gap-1.5 text-xs pt-1">
              <button type="button" @click="toggleService('1')" :class="hasService('1') ? 'bg-[#1B3D2F] text-white font-semibold' : 'bg-[#FAF9F6] dark:bg-[#202522] text-[#555955] dark:text-[#A7AAA4] border border-[#E5E3DC] dark:border-[#2D3330]'"
                class="px-2.5 py-1 rounded-md transition cursor-pointer">Điện riêng</button>
              <button type="button" @click="toggleService('2')" :class="hasService('2') ? 'bg-[#1B3D2F] text-white font-semibold' : 'bg-[#FAF9F6] dark:bg-[#202522] text-[#555955] dark:text-[#A7AAA4] border border-[#E5E3DC] dark:border-[#2D3330]'"
                class="px-2.5 py-1 rounded-md transition cursor-pointer">Nước máy</button>
              <button type="button" @click="toggleService('3')" :class="hasService('3') ? 'bg-[#1B3D2F] text-white font-semibold' : 'bg-[#FAF9F6] dark:bg-[#202522] text-[#555955] dark:text-[#A7AAA4] border border-[#E5E3DC] dark:border-[#2D3330]'"
                class="px-2.5 py-1 rounded-md transition cursor-pointer">Wifi</button>
              <button type="button" @click="toggleService('4')" :class="hasService('4') ? 'bg-[#1B3D2F] text-white font-semibold' : 'bg-[#FAF9F6] dark:bg-[#202522] text-[#555955] dark:text-[#A7AAA4] border border-[#E5E3DC] dark:border-[#2D3330]'"
                class="px-2.5 py-1 rounded-md transition cursor-pointer">Máy lạnh</button>
              <button type="button" @click="toggleService('5')" :class="hasService('5') ? 'bg-[#1B3D2F] text-white font-semibold' : 'bg-[#FAF9F6] dark:bg-[#202522] text-[#555955] dark:text-[#A7AAA4] border border-[#E5E3DC] dark:border-[#2D3330]'"
                class="px-2.5 py-1 rounded-md transition cursor-pointer">Chỗ để xe</button>
              <button type="button" @click="toggleService('6')" :class="hasService('6') ? 'bg-[#1B3D2F] text-white font-semibold' : 'bg-[#FAF9F6] dark:bg-[#202522] text-[#555955] dark:text-[#A7AAA4] border border-[#E5E3DC] dark:border-[#2D3330]'"
                class="px-2.5 py-1 rounded-md transition cursor-pointer">Bếp nấu</button>
              <button type="button" @click="toggleService('8')" :class="hasService('8') ? 'bg-[#1B3D2F] text-white font-semibold' : 'bg-[#FAF9F6] dark:bg-[#202522] text-[#555955] dark:text-[#A7AAA4] border border-[#E5E3DC] dark:border-[#2D3330]'"
                class="px-2.5 py-1 rounded-md transition cursor-pointer">Khóa vân tay</button>
              <button type="button" @click="toggleService('10')" :class="hasService('10') ? 'bg-[#1B3D2F] text-white font-semibold' : 'bg-[#FAF9F6] dark:bg-[#202522] text-[#555955] dark:text-[#A7AAA4] border border-[#E5E3DC] dark:border-[#2D3330]'"
                class="px-2.5 py-1 rounded-md transition cursor-pointer">Giờ giấc tự do</button>
            </div>
          </div>
        </div>

        {{-- Submit & Reset actions --}}
        <div class="pt-3 border-t border-[#EAE8E1] dark:border-[#262B28] flex items-center justify-between gap-2.5">
          <button type="button" @click="resetForm()"
            class="px-3 py-2 text-[#70746F] hover:text-[#171A19] dark:hover:text-white text-xs font-medium transition cursor-pointer flex items-center gap-1">
            <i class="ri-refresh-line"></i> Đặt lại
          </button>

          <div class="flex items-center gap-2">
            <button type="button" @click="openAiModal = false"
              class="px-4 py-2 rounded-lg bg-[#FAF9F6] hover:bg-stone-200 dark:bg-[#222724] dark:hover:bg-[#2C322F] text-[#555955] dark:text-stone-300 font-medium text-xs transition cursor-pointer">
              Đóng
            </button>
            <button type="submit" :disabled="aiIsLoading"
              class="px-5 py-2.5 bg-[#1B3D2F] hover:bg-[#142F24] text-white font-semibold text-xs rounded-lg transition cursor-pointer flex items-center gap-2 disabled:opacity-50 shadow-sm">
              <template x-if="!aiIsLoading">
                <span class="flex items-center gap-1.5">
                  <i class="ri-sparkling-fill text-[#A6824D]"></i>
                  <span>Tìm Phòng Phù Hợp Nhất</span>
                </span>
              </template>
              <template x-if="aiIsLoading">
                <span class="flex items-center gap-1.5">
                  <i class="ri-loader-4-line animate-spin"></i>
                  <span>Đang tìm phòng phù hợp...</span>
                </span>
              </template>
            </button>
          </div>
        </div>
      </form>
    </div>
  </div>
  </template>

  {{-- 📊 POPUP MODAL: SO SÁNH 3 PHÒNG ĐỀ XUẤT (DECISION SUPPORT COMPARISON TABLE) --}}
  <template x-teleport="body">
  <div x-show="openCompareModal" style="display: none;"
    class="fixed inset-0 z-[9999] flex items-center justify-center p-3 sm:p-6 bg-[#121514]/80 backdrop-blur-xs"
    x-transition:enter="transition ease-out duration-200"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-150"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0">

    <div @click.away="openCompareModal = false"
      class="bg-white dark:bg-[#181B19] rounded-2xl max-w-5xl w-full p-5 sm:p-7 border border-[#E5E3DC] dark:border-[#2D3330] shadow-2xl relative flex flex-col max-h-[92vh]"
      x-transition:enter="transition ease-out duration-200"
      x-transition:enter-start="opacity-0 scale-98 translate-y-1"
      x-transition:enter-end="opacity-100 scale-100 translate-y-0">

      {{-- Compare Header --}}
      <div class="flex items-center justify-between border-b border-[#EAE8E1] dark:border-[#262B28] pb-4 mb-4">
        <div class="flex items-center gap-3">
          <div class="w-10 h-10 rounded-xl bg-[#FAF9F6] dark:bg-[#222724] text-[#1B3D2F] dark:text-[#A3B899] flex items-center justify-center text-xl border border-[#E5E3DC] dark:border-[#303632]">
            <i class="ri-scales-3-line"></i>
          </div>
          <div>
            <h3 class="text-base sm:text-lg font-bold text-[#171A19] dark:text-white">
              Bảng So Sánh Các Phương Án Đề Xuất
            </h3>
            <p class="text-xs text-[#70746F] dark:text-stone-400">
              Đối chiếu chi tiết diện tích, chi phí và các tiện ích thực tế
            </p>
          </div>
        </div>
        <button type="button" @click="openCompareModal = false"
          class="w-8 h-8 rounded-lg text-[#85877F] hover:text-[#171A19] dark:hover:text-white flex items-center justify-center transition cursor-pointer">
          <i class="ri-close-line text-xl"></i>
        </button>
      </div>

      {{-- Table Content Container --}}
      <div class="grow overflow-auto border border-[#EAE8E1] dark:border-[#282D2A] rounded-xl">
        <template x-if="compareList.length === 0">
          <div class="py-12 text-center text-xs text-[#85877F]">
            Chưa có phòng nào được chọn để so sánh.
          </div>
        </template>

        <template x-if="compareList.length > 0">
          <table class="w-full text-left text-xs border-collapse min-w-[650px]">
            <thead>
              <tr class="bg-[#FAF9F6] dark:bg-[#1E2320] border-b border-[#EAE8E1] dark:border-[#282D2A]">
                <th class="p-3.5 font-bold text-[#70746F] dark:text-stone-400 w-36 uppercase tracking-wider text-[10px]">
                  Tiêu chí
                </th>
                <template x-for="(item, idx) in compareList" :key="item.id || idx">
                  <th class="p-3.5 border-l border-[#EAE8E1] dark:border-[#282D2A] w-1/3 align-top">
                    <div class="space-y-2">
                      <div class="relative aspect-[16/10] w-full rounded-lg overflow-hidden bg-stone-100">
                        <img :src="item.anh_dai_dien" :alt="item.tieu_de" class="w-full h-full object-cover">
                        <span class="absolute top-2 left-2 px-2 py-0.5 rounded text-[10px] font-bold bg-[#1B3D2F] text-white"
                          x-text="'#' + (item.ranking_rank || (idx + 1)) + ' • ' + (item.satisfaction_score || 95) + '%'">
                        </span>
                      </div>
                      <h4 class="font-bold text-xs text-[#171A19] dark:text-white line-clamp-2 min-h-[2rem]" x-text="item.tieu_de"></h4>
                    </div>
                  </th>
                </template>
              </tr>
            </thead>
            <tbody class="divide-y divide-[#EAE8E1] dark:divide-[#282D2A]">
              {{-- Giá thuê --}}
              <tr>
                <td class="p-3.5 font-semibold text-[#70746F] dark:text-stone-400 bg-[#FAF9F6]/50 dark:bg-[#1E2320]/50">
                  Giá thuê tháng
                </td>
                <template x-for="item in compareList" :key="'price-' + item.id">
                  <td class="p-3.5 border-l border-[#EAE8E1] dark:border-[#282D2A] font-bold text-sm text-[#1B3D2F] dark:text-[#A3B899]"
                    x-text="item.gia_hien_thi">
                  </td>
                </template>
              </tr>

              {{-- Tiền đặt cọc --}}
              <tr>
                <td class="p-3.5 font-semibold text-[#70746F] dark:text-stone-400 bg-[#FAF9F6]/50 dark:bg-[#1E2320]/50">
                  Tiền đặt cọc
                </td>
                <template x-for="item in compareList" :key="'deposit-' + item.id">
                  <td class="p-3.5 border-l border-[#EAE8E1] dark:border-[#282D2A] text-[#171A19] dark:text-white"
                    x-text="item.tien_coc || '1 tháng'">
                  </td>
                </template>
              </tr>

              {{-- Diện tích & Sức chứa --}}
              <tr>
                <td class="p-3.5 font-semibold text-[#70746F] dark:text-stone-400 bg-[#FAF9F6]/50 dark:bg-[#1E2320]/50">
                  Diện tích / Sức chứa
                </td>
                <template x-for="item in compareList" :key="'specs-' + item.id">
                  <td class="p-3.5 border-l border-[#EAE8E1] dark:border-[#282D2A] text-[#171A19] dark:text-white">
                    <span class="font-bold" x-text="item.dien_tich"></span>
                    <span class="text-stone-400 mx-1">•</span>
                    <span x-text="item.suc_chua"></span>
                  </td>
                </template>
              </tr>

              {{-- Địa chỉ --}}
              <tr>
                <td class="p-3.5 font-semibold text-[#70746F] dark:text-stone-400 bg-[#FAF9F6]/50 dark:bg-[#1E2320]/50">
                  Khu vực / Địa chỉ
                </td>
                <template x-for="item in compareList" :key="'addr-' + item.id">
                  <td class="p-3.5 border-l border-[#EAE8E1] dark:border-[#282D2A] text-[#555955] dark:text-stone-300 leading-relaxed"
                    x-text="item.dia_chi">
                  </td>
                </template>
              </tr>

              {{-- Lý do tối ưu --}}
              <tr>
                <td class="p-3.5 font-semibold text-[#70746F] dark:text-stone-400 bg-[#FAF9F6]/50 dark:bg-[#1E2320]/50">
                  Đánh giá phù hợp
                </td>
                <template x-for="item in compareList" :key="'reason-' + item.id">
                  <td class="p-3.5 border-l border-[#EAE8E1] dark:border-[#282D2A] text-[11px] space-y-1">
                    <template x-if="item.ai_reasons && item.ai_reasons.length">
                      <div>
                        <template x-for="(r, rIdx) in item.ai_reasons.slice(0, 2)" :key="rIdx">
                          <span class="inline-flex items-center gap-1 text-emerald-800 dark:text-emerald-400 font-medium"><i class="ri-check-line text-xs font-bold text-emerald-600 dark:text-emerald-400"></i> <span x-text="r"></span></span>
                        </template>
                      </div>
                    </template>
                    <template x-if="!item.ai_reasons || !item.ai_reasons.length">
                      <span class="text-stone-500">Đạt đầy đủ các tiêu chí bạn cần</span>
                    </template>
                  </td>
                </template>
              </tr>

              {{-- Thao tác --}}
              <tr>
                <td class="p-3.5 font-semibold text-[#70746F] dark:text-stone-400 bg-[#FAF9F6]/50 dark:bg-[#1E2320]/50">
                  Thao tác
                </td>
                <template x-for="item in compareList" :key="'action-' + item.id">
                  <td class="p-3.5 border-l border-[#EAE8E1] dark:border-[#282D2A]">
                    <div class="flex items-center gap-2">
                      <a :href="'/bai-dang/' + item.id"
                        class="px-3 py-1.5 bg-[#1B3D2F] hover:bg-[#142F24] text-white text-xs font-semibold rounded-lg transition inline-flex items-center gap-1">
                        <span>Xem phòng</span>
                        <i class="ri-arrow-right-line"></i>
                      </a>
                      <button type="button" x-show="item.chu_tro_sdt"
                        @click="showChuTroInfo(item.chu_tro_ten, item.chu_tro_sdt)"
                        class="p-1.5 rounded-lg bg-stone-100 hover:bg-stone-200 dark:bg-[#282D2A] text-[#171A19] dark:text-white transition cursor-pointer"
                        title="Gọi chủ trọ">
                        <i class="ri-phone-line"></i>
                      </button>
                    </div>
                  </td>
                </template>
              </tr>
            </tbody>
          </table>
        </template>
      </div>

      {{-- Compare Footer --}}
      <div class="pt-4 mt-4 border-t border-[#EAE8E1] dark:border-[#262B28] flex justify-end">
        <button type="button" @click="openCompareModal = false"
          class="px-5 py-2 rounded-lg bg-[#FAF9F6] hover:bg-stone-200 dark:bg-[#222724] dark:hover:bg-[#2C322F] text-[#555955] dark:text-stone-300 font-semibold text-xs transition cursor-pointer">
          Đóng bảng so sánh
        </button>
      </div>
    </div>
  </div>
  </template>

</div>

<script>
function listingPage() {
  const recommendationsData = {!! $recListJson !!};
  return {
    openAiModal: {{ (request('mode') === 'ai' && empty($recommendations) && !$recommend_no_match) ? 'true' : 'false' }},
    openCompareModal: false,
    aiPersona: 'student',
    aiBudget: {{ intval(old('budget', $recommend_payload['budget'] ?? request('budget', request('max', 3500000)))) }},
    aiArea: {{ intval(old('area', $recommend_payload['area'] ?? request('area', 22))) }},
    aiPeople: {{ intval(old('people', $recommend_payload['people'] ?? request('people', 1))) }},
    aiStrictBudget: {{ (old('strict_budget', $recommend_payload['strict_budget'] ?? true) ? true : false) ? 'true' : 'false' }},
    aiStrictLocation: {{ (old('strict_location', $recommend_payload['strict_location'] ?? false) ? true : false) ? 'true' : 'false' }},
    aiDistrict: {!! json_encode(old('dia_chi', $recommend_payload['dia_chi'] ?? request('dia_chi', ''))) !!},
    aiServices: {!! json_encode(old('dich_vu_id', is_array($recommend_payload['dich_vu_id'] ?? null) ? implode(',', $recommend_payload['dich_vu_id']) : request('dich_vu_id', '1,2,3'))) !!},
    aiIsLoading: false,
    recommendationsData: recommendationsData,
    compareList: {!! !empty($recommendations) ? 'recommendationsData' : '[]' !!},

    setPersona(p) {
      this.aiPersona = p;
      if (p === 'student') {
        this.aiBudget = 2200000;
        this.aiArea = 18;
        this.aiPeople = 1;
        this.aiStrictBudget = true;
        this.aiServices = '1,3';
        this.aiDistrict = 'Thủ Đức';
      } else if (p === 'worker') {
        this.aiBudget = 4000000;
        this.aiArea = 28;
        this.aiPeople = 1;
        this.aiStrictBudget = true;
        this.aiServices = '1,2,3,4';
        this.aiDistrict = 'Bình Thạnh';
      } else if (p === 'roommates') {
        this.aiBudget = 3500000;
        this.aiArea = 32;
        this.aiPeople = 2;
        this.aiStrictBudget = true;
        this.aiServices = '1,2,5';
        this.aiDistrict = 'Quận 10';
      } else if (p === 'serviced') {
        this.aiBudget = 5500000;
        this.aiArea = 35;
        this.aiPeople = 1;
        this.aiStrictBudget = false;
        this.aiServices = '1,2,3,4,8,10';
        this.aiDistrict = 'Tân Bình';
      }
    },

    resetForm() {
      this.aiPersona = 'student';
      this.aiBudget = 3500000;
      this.aiArea = 22;
      this.aiPeople = 1;
      this.aiStrictBudget = true;
      this.aiStrictLocation = false;
      this.aiDistrict = '';
      this.aiServices = '1,2,3';
    },

    hasService(id) {
      const arr = String(this.aiServices).split(',').map(s => s.trim());
      return arr.includes(String(id));
    },

    toggleService(id) {
      let arr = this.aiServices ? String(this.aiServices).split(',').map(s => s.trim()).filter(Boolean) : [];
      const strId = String(id);
      if (arr.includes(strId)) {
        arr = arr.filter(x => x !== strId);
      } else {
        arr.push(strId);
      }
      this.aiServices = arr.join(',');
    },

    toggleCompare(room) {
      const idx = this.compareList.findIndex(r => r.id === room.id);
      if (idx >= 0) {
        this.compareList.splice(idx, 1);
      } else {
        if (this.compareList.length >= 3) {
          alert('Bạn chỉ có thể so sánh tối đa 3 phòng cùng lúc.');
          return;
        }
        this.compareList.push(room);
      }
    },

    isInCompare(id) {
      return this.compareList.some(r => r.id === id);
    },

    removeFromCompare(id) {
      this.compareList = this.compareList.filter(r => r.id !== id);
    },

    formatMoney(num) {
      return new Intl.NumberFormat('vi-VN').format(num) + ' ₫';
    }
  };
}

function areaDropdownComponent() {
  return {
    openAreaDropdown: false,
    areaKeyword: {!! json_encode(request('dia_chi', request('district', request('area', '')))) !!},
    popularAreas: ['Bình Thạnh', 'TP. Thủ Đức', 'Quận 10', 'Quận 7', 'Gò Vấp', 'Tân Bình', 'Quận 1', 'Quận 3', 'Phú Nhuận', 'Tân Phú', 'Quận 5', 'Quận 8'],
    allRegions: {!! json_encode($regionNames ?? []) !!},
    filteredRegions() {
      const kw = (this.areaKeyword || '').trim().toLowerCase();
      if (!kw) return this.popularAreas;
      return this.allRegions.filter(r => r && r.toLowerCase().includes(kw)).slice(0, 15);
    },
    selectArea(val) {
      this.areaKeyword = val;
      this.openAreaDropdown = false;
    }
  };
}

function showChuTroInfo(ten, sdt) {
  document.getElementById('modalChuTroName').innerHTML = '<i class="ri-user-3-line text-[#0D9488] mr-1.5 align-middle"></i><span>' + (ten || 'Chưa có thông tin') + '</span>';
  document.getElementById('modalChuTroPhone').innerHTML = '<i class="ri-phone-fill text-[#0D9488] mr-1.5 align-middle"></i><a href="tel:' + (sdt || '') + '" class="text-[#0D9488] dark:text-[#2DD4BF] hover:underline">' + (sdt || 'Chưa có SĐT') + '</a>';
  const modal = document.getElementById('modalChuTro');
  modal.classList.remove('hidden');
  modal.classList.add('flex');
}

function closeModalChuTro() {
  const modal = document.getElementById('modalChuTro');
  modal.classList.add('hidden');
  modal.classList.remove('flex');
}
</script>
@endsection
