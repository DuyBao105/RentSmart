@extends('layouts.app')

@section('title', ($item['tieu_de'] ?? 'Chi tiết phòng trọ') . ' - Hệ Thống Trọ')

@section('content')
@php
    $images = !empty($item['anh']) && is_array($item['anh']) ? array_values($item['anh']) : [];
    if (empty($images)) {
        $images = [asset('images/no-image.png')];
    }
    $mainImage = $images[0];
    $rating = (float) ($item['rating'] ?? 4.8);
    $reviewCount = !empty($item['danh_gia']) && is_array($item['danh_gia']) ? count($item['danh_gia']) : 8;
    $tienIchRaw = $item['tien_ich'] ?? '';
    $tienIchList = array_filter(array_map('trim', explode(',', $tienIchRaw)));
    $isAvailable = ($item['trang_thai_phong'] ?? 'trong') === 'trong';
    $giaNiemYet = (float) ($item['gia_niem_yet'] ?? 0);
    $chuTroSdt = $item['sdt_chu_tro'] ?? '0909000002';
    $chuTroTen = $item['chu_tro'] ?? 'Chủ nhà thân thiện';
@endphp

<section class="min-h-screen bg-[#FAF9F6] dark:bg-[#121514] text-[#171A19] dark:text-[#E8EAE6] pb-20 pt-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- 🧭 Breadcrumbs & Metadata Bar --}}
        <div class="flex flex-wrap items-center justify-between gap-3 mb-4 text-xs font-medium text-[#70746F] dark:text-[#9EA09B]">
            <nav class="flex items-center gap-1.5 flex-wrap">
                <a href="{{ route('home') }}" class="hover:text-[#1B3D2F] dark:hover:text-[#A3B899] transition flex items-center gap-1">
                    <i class="ri-home-line text-sm"></i> Trang chủ
                </a>
                <i class="ri-arrow-right-s-line text-stone-400"></i>
                <a href="{{ route('listing') }}" class="hover:text-[#1B3D2F] dark:hover:text-[#A3B899] transition">Phòng trọ</a>
                <i class="ri-arrow-right-s-line text-stone-400"></i>
                <span class="hover:text-[#1B3D2F] dark:hover:text-[#A3B899] transition">{{ $item['ten_day_tro'] ?? 'Khu trọ' }}</span>
                <i class="ri-arrow-right-s-line text-stone-400"></i>
                <span class="text-[#171A19] dark:text-white font-semibold truncate max-w-[200px] sm:max-w-xs">
                    {{ $item['tieu_de'] ?? 'Chi tiết phòng' }}
                </span>
            </nav>

            <div class="flex items-center gap-2">
                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-md text-[11px] font-semibold bg-white dark:bg-[#181B19] text-[#555955] dark:text-stone-300 border border-[#E5E3DC] dark:border-[#2D3330]">
                    Mã tin: #PT-{{ $item['id'] ?? 1 }}
                </span>
                <span class="hidden sm:inline-flex items-center gap-1 px-2.5 py-0.5 rounded-md text-[11px] font-semibold bg-white dark:bg-[#181B19] text-[#555955] dark:text-stone-300 border border-[#E5E3DC] dark:border-[#2D3330]">
                    Cập nhật: {{ $item['ngay_hien_thi'] ?? date('d/m/Y') }}
                </span>
            </div>
        </div>

        {{-- 🏷️ Header: Tiêu đề, Badges, Đánh giá, Nút Chia sẻ / Lưu --}}
        <div class="mb-6 flex flex-col lg:flex-row lg:items-start lg:justify-between gap-4 pb-6 border-b border-[#E5E3DC] dark:border-[#262B28]">
            <div class="space-y-2.5 max-w-4xl">
                <div class="flex flex-wrap items-center gap-2">
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-xs font-semibold bg-[#FAF9F6] dark:bg-[#1A1E1C] text-[#1B3D2F] dark:text-[#A3B899] border border-[#D8D4CA] dark:border-[#353C37]">
                        <i class="ri-shield-check-fill text-[#1B3D2F] dark:text-[#A3B899]"></i> Đã kiểm tra thực địa
                    </span>
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-xs font-semibold bg-[#FAF9F6] dark:bg-[#1A1E1C] text-[#171A19] dark:text-stone-200 border border-[#D8D4CA] dark:border-[#353C37]">
                        <i class="ri-user-star-line text-[#A6824D]"></i> Tin chính chủ
                    </span>
                    @if($isAvailable)
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-xs font-semibold bg-emerald-50 dark:bg-emerald-950/50 text-emerald-800 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Còn phòng • Nhận phòng ngay
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-xs font-semibold bg-stone-100 dark:bg-stone-800 text-stone-600 dark:text-stone-300 border border-stone-200 dark:border-stone-700">
                            Đã có người thuê
                        </span>
                    @endif
                </div>

                <h1 class="text-2xl sm:text-3xl lg:text-[34px] font-bold text-[#171A19] dark:text-white tracking-tight leading-snug">
                    {{ $item['tieu_de'] ?? 'Phòng trọ cao cấp tiện nghi, an ninh tuyệt đối' }}
                </h1>

                <div class="flex flex-wrap items-center gap-y-2 gap-x-4 text-xs sm:text-sm text-[#70746F] dark:text-[#A7AAA4] pt-0.5">
                    <a href="#reviews-section" class="flex items-center gap-1 font-semibold text-[#A6824D] hover:underline">
                        <i class="ri-star-fill"></i>
                        <span>{{ number_format($rating, 1) }}</span>
                        <span class="text-stone-400 font-normal">({{ $reviewCount }} đánh giá)</span>
                    </a>
                    <span class="text-stone-300 dark:text-stone-700">•</span>
                    <a href="#map-section" class="flex items-center gap-1 hover:text-[#1B3D2F] dark:hover:text-[#A3B899] transition font-medium">
                        <i class="ri-map-pin-line text-[#85877F]"></i>
                        <span>{{ $item['dia_chi'] ?? 'Địa chỉ đang cập nhật' }}</span>
                    </a>
                    <span class="hidden sm:inline text-stone-300 dark:text-stone-700">•</span>
                    <span class="hidden sm:flex items-center gap-1 text-[#85877F]">
                        <i class="ri-eye-line"></i> 1.2k+ lượt xem
                    </span>
                </div>
            </div>

            {{-- Actions: Share & Wishlist --}}
            <div class="flex items-center gap-2 self-start shrink-0">
                <button type="button" onclick="shareProperty()"
                    class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-lg bg-white dark:bg-[#181B19] hover:bg-[#F3F1EC] dark:hover:bg-[#222724] border border-[#E5E3DC] dark:border-[#2D3330] text-xs sm:text-sm font-semibold text-[#171A19] dark:text-white transition shadow-2xs">
                    <i class="ri-share-forward-line text-base text-[#85877F]"></i>
                    <span>Chia sẻ</span>
                </button>

                <button id="btn-yeu-thich" data-favorite="false" onclick="toggleYeuThich({{ $item['id'] ?? 1 }})"
                    class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-lg bg-white dark:bg-[#181B19] hover:bg-rose-50 dark:hover:bg-rose-950/40 border border-[#E5E3DC] dark:border-[#2D3330] text-xs sm:text-sm font-semibold text-[#171A19] dark:text-white hover:text-rose-600 transition shadow-2xs">
                    <i id="iconYeuThich" class="ri-heart-3-line text-base text-[#85877F]"></i>
                    <span id="textYeuThich">Lưu tin</span>
                </button>
            </div>
        </div>

        {{-- 📸 BENTO PHOTO GALLERY (AIRBNB ARCHITECTURAL STYLE) --}}
        <div class="mb-10 relative">
            @if(count($images) >= 5)
                {{-- Bento 5-Grid --}}
                <div class="grid grid-cols-1 md:grid-cols-4 gap-2.5 h-[340px] sm:h-[440px] md:h-[480px] rounded-xl overflow-hidden border border-[#E5E3DC] dark:border-[#282D2A] bg-stone-900 shadow-sm">
                    {{-- Main large image (Left half) --}}
                    <div class="md:col-span-2 relative h-full overflow-hidden group cursor-pointer" onclick="openLightbox(0)">
                        <img src="{{ $images[0] }}" alt="Ảnh chính"
                            class="w-full h-full object-cover group-hover:scale-103 transition-transform duration-500">
                        <span class="absolute top-3 left-3 px-2.5 py-1 rounded text-xs font-semibold text-white bg-[#121514]/80 backdrop-blur-md border border-white/10">
                            Ảnh toàn cảnh phòng
                        </span>
                    </div>

                    {{-- 4 side grid images --}}
                    <div class="hidden md:grid md:col-span-2 grid-cols-2 gap-2.5 h-full">
                        @for($k = 1; $k <= 4; $k++)
                            <div class="relative h-full overflow-hidden group cursor-pointer" onclick="openLightbox({{ $k }})">
                                <img src="{{ $images[$k] ?? $images[0] }}" alt="Ảnh chi tiết {{ $k }}"
                                    class="w-full h-full object-cover group-hover:scale-103 transition-transform duration-500">
                            </div>
                        @endfor
                    </div>
                </div>
            @else
                {{-- Single / Multi Carousel Showcase --}}
                <div class="relative w-full h-[340px] sm:h-[460px] md:h-[500px] rounded-xl overflow-hidden border border-[#E5E3DC] dark:border-[#282D2A] bg-stone-900 shadow-sm group">
                    <img id="mainGalleryImage" src="{{ $mainImage }}" alt="Ảnh phòng trọ"
                        class="w-full h-full object-cover select-none cursor-pointer group-hover:scale-[1.02] transition-transform duration-500"
                        onclick="openLightbox(currentImageIndex)">

                    {{-- Badges on top --}}
                    <div class="absolute top-4 left-4 flex items-center gap-2">
                        <span class="bg-[#121514]/85 backdrop-blur-md px-3 py-1 rounded text-xs font-semibold text-white border border-white/10">
                            {{ $item['ten_day_tro'] ?? 'Khu trọ' }} • P.{{ $item['so_phong'] ?? '101' }}
                        </span>
                    </div>

                    {{-- Navigation Arrows --}}
                    @if(count($images) > 1)
                        <button type="button" onclick="prevImage(event)" aria-label="Previous"
                            class="absolute left-4 top-1/2 -translate-y-1/2 w-9 h-9 rounded-md bg-[#121514]/70 hover:bg-[#121514]/90 text-white shadow-md flex items-center justify-center transition border border-white/10">
                            <i class="ri-arrow-left-s-line text-xl"></i>
                        </button>
                        <button type="button" onclick="nextImage(event)" aria-label="Next"
                            class="absolute right-4 top-1/2 -translate-y-1/2 w-9 h-9 rounded-md bg-[#121514]/70 hover:bg-[#121514]/90 text-white shadow-md flex items-center justify-center transition border border-white/10">
                            <i class="ri-arrow-right-s-line text-xl"></i>
                        </button>
                    @endif

                    {{-- Thumbnail strip on bottom --}}
                    @if(count($images) > 1)
                        <div class="absolute bottom-3 left-3 right-3 flex items-center justify-center gap-2 overflow-x-auto py-1">
                            @foreach($images as $idx => $imgUrl)
                                <button type="button" onclick="selectImage({{ $idx }})"
                                    class="thumb-btn relative w-14 h-10 rounded-md overflow-hidden border-2 transition-all shrink-0 {{ $idx === 0 ? 'border-white scale-105' : 'border-white/40 opacity-70 hover:opacity-100' }}"
                                    data-idx="{{ $idx }}">
                                    <img src="{{ $imgUrl }}" class="w-full h-full object-cover" alt="Thumb">
                                </button>
                            @endforeach
                        </div>
                    @endif
                </div>
            @endif

            {{-- Floating Button "Xem tất cả X ảnh" --}}
            <button type="button" onclick="openLightbox(0)"
                class="absolute bottom-4 right-4 z-10 inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-lg bg-[#121514]/85 hover:bg-[#121514] text-white backdrop-blur-md border border-white/20 text-xs font-semibold shadow-md transition">
                <i class="ri-camera-line text-sm"></i>
                <span>Xem tất cả ({{ count($images) }} ảnh)</span>
            </button>
        </div>

        {{-- 🏛️ MAIN 2-COLUMN COMMERCIAL LAYOUT --}}
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">

            {{-- ⬅️ LEFT COLUMN: CHI TIẾT SẢN PHẨM / THÔNG SỐ (8 cols) --}}
            <div class="lg:col-span-8 space-y-8">

                {{-- 1. THẺ THÔNG SỐ NỔI BẬT (HIGHLIGHT SPECIFICATIONS) --}}
                <div class="bg-white dark:bg-[#181B19] rounded-xl p-6 border border-[#E5E3DC] dark:border-[#282D2A] shadow-2xs">
                    <div class="flex items-center justify-between mb-5 pb-3 border-b border-[#EAE8E1] dark:border-[#262B28]">
                        <h2 class="text-base sm:text-lg font-bold text-[#171A19] dark:text-white flex items-center gap-2">
                            <span class="w-2 h-4 rounded-xs bg-[#1B3D2F] dark:bg-[#7EA089]"></span>
                            Thông Số & Đặc Điểm Căn Phòng
                        </h2>
                        <span class="text-xs font-medium text-[#70746F]">Mã phòng: P.{{ $item['so_phong'] ?? '101' }}</span>
                    </div>

                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                        {{-- Diện tích --}}
                        <div class="p-3.5 rounded-lg bg-[#FAF9F6] dark:bg-[#1E2320] border border-[#E5E3DC] dark:border-[#282D2A]">
                            <span class="text-[11px] font-semibold text-[#85877F] uppercase tracking-wider block">Diện tích</span>
                            <span class="text-base sm:text-lg font-bold text-[#171A19] dark:text-white mt-0.5 block">
                                {{ $item['dien_tich'] ?? '20' }} m²
                            </span>
                        </div>

                        {{-- Tầng lầu --}}
                        <div class="p-3.5 rounded-lg bg-[#FAF9F6] dark:bg-[#1E2320] border border-[#E5E3DC] dark:border-[#282D2A]">
                            <span class="text-[11px] font-semibold text-[#85877F] uppercase tracking-wider block">Vị trí tầng</span>
                            <span class="text-base sm:text-lg font-bold text-[#171A19] dark:text-white mt-0.5 block">
                                Tầng {{ $item['tang'] ?? '1' }}
                            </span>
                        </div>

                        {{-- Sức chứa --}}
                        <div class="p-3.5 rounded-lg bg-[#FAF9F6] dark:bg-[#1E2320] border border-[#E5E3DC] dark:border-[#282D2A]">
                            <span class="text-[11px] font-semibold text-[#85877F] uppercase tracking-wider block">Sức chứa</span>
                            <span class="text-base sm:text-lg font-bold text-[#171A19] dark:text-white mt-0.5 block">
                                {{ $item['suc_chua'] ?? '2' }} người
                            </span>
                        </div>

                        {{-- Dãy trọ --}}
                        <div class="p-3.5 rounded-lg bg-[#FAF9F6] dark:bg-[#1E2320] border border-[#E5E3DC] dark:border-[#282D2A]">
                            <span class="text-[11px] font-semibold text-[#85877F] uppercase tracking-wider block">Dãy trọ</span>
                            <span class="text-base sm:text-lg font-bold text-[#171A19] dark:text-white truncate block mt-0.5">
                                {{ $item['ten_day_tro'] ?? 'Dãy A' }}
                            </span>
                        </div>

                        {{-- Tiền đặt cọc --}}
                        <div class="p-3.5 rounded-lg bg-[#FAF9F6] dark:bg-[#1E2320] border border-[#E5E3DC] dark:border-[#282D2A]">
                            <span class="text-[11px] font-semibold text-[#85877F] uppercase tracking-wider block">Tiền cọc</span>
                            <span class="text-base sm:text-lg font-bold text-[#171A19] dark:text-white mt-0.5 block">
                                {{ !empty($item['tien_coc']) ? number_format($item['tien_coc'], 0, ',', '.') . ' ₫' : '1 tháng tiền phòng' }}
                            </span>
                        </div>

                        {{-- Giờ giấc --}}
                        <div class="p-3.5 rounded-lg bg-[#FAF9F6] dark:bg-[#1E2320] border border-[#E5E3DC] dark:border-[#282D2A]">
                            <span class="text-[11px] font-semibold text-[#85877F] uppercase tracking-wider block">Giờ giấc</span>
                            <span class="text-base sm:text-lg font-bold text-[#171A19] dark:text-white mt-0.5 block">
                                Tự do 24/7
                            </span>
                        </div>
                    </div>
                </div>

                {{-- 2. TIỆN ÍCH & TRANG THIẾT BỊ (AMENITIES GRID) --}}
                <div class="bg-white dark:bg-[#181B19] rounded-xl p-6 border border-[#E5E3DC] dark:border-[#282D2A] shadow-2xs">
                    <h2 class="text-base sm:text-lg font-bold text-[#171A19] dark:text-white mb-1 flex items-center gap-2">
                        <span class="w-2 h-4 rounded-xs bg-[#1B3D2F] dark:bg-[#7EA089]"></span>
                        Tiện Nghi & Trang Thiết Bị Đi Kèm
                    </h2>
                    <p class="text-xs text-[#70746F] dark:text-stone-400 mb-5">Danh mục tiện ích được kiểm tra xác thực bởi ban quản trị hệ thống.</p>

                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                        @php
                            $standardAmenities = [
                                ['icon' => 'ri-temp-cold-line', 'label' => 'Máy lạnh / Điều hòa', 'desc' => 'Tiết kiệm điện'],
                                ['icon' => 'ri-drop-line', 'label' => 'Bình nóng lạnh', 'desc' => 'Nước nóng ổn định'],
                                ['icon' => 'ri-wifi-line', 'label' => 'Wifi cáp quang', 'desc' => 'Tốc độ cao'],
                                ['icon' => 'ri-fingerprint-line', 'label' => 'Khóa vân tay / Thẻ từ', 'desc' => 'An toàn bảo mật'],
                                ['icon' => 'ri-video-line', 'label' => 'Camera an ninh', 'desc' => 'Giám sát 24/7'],
                                ['icon' => 'ri-motorbike-line', 'label' => 'Nhà để xe có mái che', 'desc' => 'Tầng trệt'],
                                ['icon' => 'ri-sun-line', 'label' => 'Cửa sổ / Ban công', 'desc' => 'Thoáng sáng tự nhiên'],
                                ['icon' => 'ri-restaurant-line', 'label' => 'Kệ bếp nấu ăn', 'desc' => 'Bếp riêng'],
                                ['icon' => 'ri-shield-user-line', 'label' => 'Không chung chủ', 'desc' => 'Giờ giấc tự do'],
                            ];
                        @endphp

                        @foreach($standardAmenities as $am)
                            <div class="p-3 rounded-lg bg-[#FAF9F6] dark:bg-[#1E2320] border border-[#E5E3DC] dark:border-[#282D2A] flex items-start gap-2.5">
                                <i class="{{ $am['icon'] }} text-[#1B3D2F] dark:text-[#A3B899] text-base mt-0.5 shrink-0"></i>
                                <div>
                                    <span class="font-semibold text-xs text-[#171A19] dark:text-white block">{{ $am['label'] }}</span>
                                    <span class="text-[11px] text-[#85877F] block">{{ $am['desc'] }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    @if(!empty($tienIchList))
                        <div class="mt-5 pt-4 border-t border-[#EAE8E1] dark:border-[#262B28]">
                            <span class="text-xs font-semibold text-[#85877F] uppercase tracking-wider block mb-2">Tiện ích bổ sung từ bài đăng:</span>
                            <div class="flex flex-wrap gap-1.5">
                                @foreach($tienIchList as $ti)
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-md text-xs font-medium bg-[#FAF9F6] dark:bg-[#1E2320] text-[#171A19] dark:text-white border border-[#E5E3DC] dark:border-[#282D2A]">
                                        <i class="ri-check-line text-[#1B3D2F] dark:text-[#A3B899]"></i> {{ $ti }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

                {{-- 3. MINH BẠCH CHI PHÍ & CÔNG CỤ TÍNH THỬ (TRANSPARENT UTILITIES) --}}
                <div class="bg-white dark:bg-[#181B19] rounded-xl p-6 border border-[#E5E3DC] dark:border-[#282D2A] shadow-2xs">
                    <div class="flex flex-wrap items-center justify-between gap-2 mb-1">
                        <h2 class="text-base sm:text-lg font-bold text-[#171A19] dark:text-white flex items-center gap-2">
                            <span class="w-2 h-4 rounded-xs bg-[#1B3D2F] dark:bg-[#7EA089]"></span>
                            Biểu Phí Dịch Vụ & Ước Tính Chi Phí Hàng Tháng
                        </h2>
                        <span class="px-2.5 py-0.5 rounded text-[11px] font-semibold bg-[#FAF6EE] dark:bg-[#2A241B] text-[#8C6D3B] dark:text-[#E8D7B8] border border-[#E5DAC0] dark:border-[#524430]">
                            Công khai minh bạch
                        </span>
                    </div>
                    <p class="text-xs text-[#70746F] dark:text-stone-400 mb-5">Đơn giá niêm yết áp dụng theo chỉ số đồng hồ thực tế hàng tháng.</p>

                    {{-- Table chi phí --}}
                    <div class="rounded-lg border border-[#E5E3DC] dark:border-[#282D2A] overflow-hidden mb-5 text-xs sm:text-sm">
                        <table class="w-full text-left">
                            <thead class="bg-[#FAF9F6] dark:bg-[#1E2320] text-[#555955] dark:text-stone-300 font-semibold border-b border-[#E5E3DC] dark:border-[#282D2A]">
                                <tr>
                                    <th class="py-2.5 px-3.5">Hạng mục chi phí</th>
                                    <th class="py-2.5 px-3.5">Đơn giá niêm yết</th>
                                    <th class="py-2.5 px-3.5">Đơn vị tính</th>
                                    <th class="py-2.5 px-3.5 hidden sm:table-cell">Cách tính</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-[#EAE8E1] dark:divide-[#282D2A] font-medium">
                                <tr>
                                    <td class="py-2.5 px-3.5 font-bold text-[#171A19] dark:text-white">Tiền phòng trọ</td>
                                    <td class="py-2.5 px-3.5 text-[#1B3D2F] dark:text-[#A3B899] font-bold">{{ $item['gia_hien_thi'] ?? number_format($giaNiemYet, 0, ',', '.') . ' ₫' }}</td>
                                    <td class="py-2.5 px-3.5 text-[#85877F]">Tháng</td>
                                    <td class="py-2.5 px-3.5 text-[#70746F] hidden sm:table-cell">Cố định hàng tháng</td>
                                </tr>
                                @if(!empty($item['dich_vu']) && count($item['dich_vu']) > 0)
                                    @foreach($item['dich_vu'] as $dv)
                                        <tr>
                                            <td class="py-2.5 px-3.5 font-medium text-[#171A19] dark:text-white">{{ $dv['ten'] ?? $dv['ten_dich_vu'] ?? 'Dịch vụ' }}</td>
                                            <td class="py-2.5 px-3.5 font-bold text-[#171A19] dark:text-white">{{ number_format($dv['gia'] ?? $dv['don_gia'] ?? 0, 0, ',', '.') }} ₫</td>
                                            <td class="py-2.5 px-3.5 text-[#85877F]">{{ $dv['don_vi'] ?? $dv['don_vi_tinh'] ?? '' }}</td>
                                            <td class="py-2.5 px-3.5 text-[#70746F] hidden sm:table-cell">Theo chỉ số thực tế</td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td class="py-2.5 px-3.5 font-medium text-[#171A19] dark:text-white">Điện sinh hoạt</td>
                                        <td class="py-2.5 px-3.5 font-bold text-[#171A19] dark:text-white">3.500 ₫</td>
                                        <td class="py-2.5 px-3.5 text-[#85877F]">kWh</td>
                                        <td class="py-2.5 px-3.5 text-[#70746F] hidden sm:table-cell">Đồng hồ riêng từng phòng</td>
                                    </tr>
                                    <tr>
                                        <td class="py-2.5 px-3.5 font-medium text-[#171A19] dark:text-white">Nước sinh hoạt</td>
                                        <td class="py-2.5 px-3.5 font-bold text-[#171A19] dark:text-white">15.000 ₫</td>
                                        <td class="py-2.5 px-3.5 text-[#85877F]">m³</td>
                                        <td class="py-2.5 px-3.5 text-[#70746F] hidden sm:table-cell">Đồng hồ riêng từng phòng</td>
                                    </tr>
                                    <tr>
                                        <td class="py-2.5 px-3.5 font-medium text-[#171A19] dark:text-white">Wifi & Rác</td>
                                        <td class="py-2.5 px-3.5 font-bold text-[#171A19] dark:text-white">50.000 ₫</td>
                                        <td class="py-2.5 px-3.5 text-[#85877F]">Phòng/tháng</td>
                                        <td class="py-2.5 px-3.5 text-[#70746F] hidden sm:table-cell">Trọn gói dịch vụ</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>

                    {{-- 🧮 Interactive Calculator Box --}}
                    <div class="p-4 rounded-lg bg-[#FAF9F6] dark:bg-[#1E2320] border border-[#E5E3DC] dark:border-[#282D2A]">
                        <div class="flex items-center justify-between mb-2.5">
                            <span class="text-xs font-bold uppercase tracking-wider text-[#171A19] dark:text-white flex items-center gap-1.5">
                                <i class="ri-calculator-line text-sm text-[#1B3D2F] dark:text-[#A3B899]"></i> Ước tính ngân sách tháng đầu tiên
                            </span>
                            <span class="text-[11px] text-[#85877F]">Ước tính tiêu chuẩn 2 người ở</span>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-2.5 mb-3 text-xs">
                            <div class="bg-white dark:bg-[#181B19] p-2.5 rounded-md border border-[#E5E3DC] dark:border-[#282D2A]">
                                <span class="text-[#85877F] block mb-0.5 text-[11px]">Tiền phòng tháng đầu:</span>
                                <span class="font-bold text-[#171A19] dark:text-white text-sm" id="calcRoomPrice">{{ number_format($giaNiemYet ?: 3000000, 0, ',', '.') }} ₫</span>
                            </div>
                            <div class="bg-white dark:bg-[#181B19] p-2.5 rounded-md border border-[#E5E3DC] dark:border-[#282D2A]">
                                <span class="text-[#85877F] block mb-0.5 text-[11px]">Điện + Nước ước tính (~80kWh + 5m³):</span>
                                <span class="font-bold text-[#171A19] dark:text-white text-sm">~355.000 ₫</span>
                            </div>
                            <div class="bg-white dark:bg-[#181B19] p-2.5 rounded-md border border-[#E5E3DC] dark:border-[#282D2A]">
                                <span class="text-[#85877F] block mb-0.5 text-[11px]">Tiền cọc giữ phòng:</span>
                                <span class="font-bold text-[#1B3D2F] dark:text-[#A3B899] text-sm">{{ number_format($item['tien_coc'] ?? $giaNiemYet, 0, ',', '.') }} ₫</span>
                            </div>
                        </div>

                        <div class="flex flex-wrap items-center justify-between gap-2 pt-2.5 border-t border-[#EAE8E1] dark:border-[#282D2A]">
                            <span class="text-xs font-medium text-[#555955] dark:text-stone-300">
                                Tổng ngân sách dự trù tháng đầu (gồm cọc + tiền phòng + điện nước):
                            </span>
                            <span class="text-base sm:text-lg font-bold text-[#1B3D2F] dark:text-[#A3B899]">
                                ~{{ number_format(($giaNiemYet * 2) + 355000, 0, ',', '.') }} ₫
                            </span>
                        </div>
                    </div>
                </div>

                {{-- 4. MÔ TẢ CHI TIẾT PHÒNG TRỌ --}}
                <div class="bg-white dark:bg-[#181B19] rounded-xl p-6 border border-[#E5E3DC] dark:border-[#282D2A] shadow-2xs">
                    <h2 class="text-base sm:text-lg font-bold text-[#171A19] dark:text-white mb-3 flex items-center gap-2">
                        <span class="w-2 h-4 rounded-xs bg-[#1B3D2F] dark:bg-[#7EA089]"></span>
                        Mô Tả Chi Tiết Phòng Trọ
                    </h2>

                    <div class="prose dark:prose-invert max-w-none text-[#555955] dark:text-stone-300 text-xs sm:text-sm leading-relaxed space-y-2">
                        @if(!empty($item['mo_ta']))
                            @foreach(explode("\n", $item['mo_ta']) as $paragraph)
                                @if(trim($paragraph) !== '')
                                    <p class="flex items-start gap-2">
                                        <i class="ri-checkbox-circle-line text-[#1B3D2F] dark:text-[#A3B899] shrink-0 mt-0.5"></i>
                                        <span>{{ trim($paragraph) }}</span>
                                    </p>
                                @endif
                            @endforeach
                        @else
                            <p>Phòng trọ mới xây, sạch sẽ, thoáng mát, khu vực an ninh cao.</p>
                            <p>Vị trí thuận lợi di chuyển, gần chợ, siêu thị, trường đại học lớn.</p>
                            <p>Không gian yên tĩnh, thích hợp cho sinh viên và người đi làm.</p>
                        @endif
                    </div>
                </div>

                {{-- 5. NỘI QUY VÀ CHÍNH SÁCH TÒA NHÀ --}}
                <div class="bg-white dark:bg-[#181B19] rounded-xl p-6 border border-[#E5E3DC] dark:border-[#282D2A] shadow-2xs">
                    <h2 class="text-base sm:text-lg font-bold text-[#171A19] dark:text-white mb-3 flex items-center gap-2">
                        <span class="w-2 h-4 rounded-xs bg-[#1B3D2F] dark:bg-[#7EA089]"></span>
                        Nội Quy & Quy Định Tòa Nhà
                    </h2>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-xs sm:text-sm">
                        <div class="p-3.5 rounded-lg bg-[#FAF9F6] dark:bg-[#1E2320] border border-[#E5E3DC] dark:border-[#282D2A] flex items-start gap-2.5">
                            <i class="ri-alarm-warning-line text-[#A6824D] text-base mt-0.5"></i>
                            <div>
                                <span class="font-bold text-[#171A19] dark:text-white block">Trật tự chung</span>
                                <span class="text-[#70746F] text-xs">Giữ yên tĩnh chung sau 23:00, không gây ồn ào ảnh hưởng phòng kế bên.</span>
                            </div>
                        </div>

                        <div class="p-3.5 rounded-lg bg-[#FAF9F6] dark:bg-[#1E2320] border border-[#E5E3DC] dark:border-[#282D2A] flex items-start gap-2.5">
                            <i class="ri-fire-line text-[#B84A39] text-base mt-0.5"></i>
                            <div>
                                <span class="font-bold text-[#171A19] dark:text-white block">An toàn PCCC</span>
                                <span class="text-[#70746F] text-xs">Trang bị bình chữa cháy từng tầng; ngắt các thiết bị điện sinh nhiệt khi ra khỏi phòng.</span>
                            </div>
                        </div>

                        <div class="p-3.5 rounded-lg bg-[#FAF9F6] dark:bg-[#1E2320] border border-[#E5E3DC] dark:border-[#282D2A] flex items-start gap-2.5">
                            <i class="ri-file-shield-line text-[#1B3D2F] dark:text-[#A3B899] text-base mt-0.5"></i>
                            <div>
                                <span class="font-bold text-[#171A19] dark:text-white block">Thời hạn hợp đồng</span>
                                <span class="text-[#70746F] text-xs">Hợp đồng thuê tiêu chuẩn từ 06 đến 12 tháng (có điều khoản gia hạn linh hoạt).</span>
                            </div>
                        </div>

                        <div class="p-3.5 rounded-lg bg-[#FAF9F6] dark:bg-[#1E2320] border border-[#E5E3DC] dark:border-[#282D2A] flex items-start gap-2.5">
                            <i class="ri-user-follow-line text-[#1B3D2F] dark:text-[#A3B899] text-base mt-0.5"></i>
                            <div>
                                <span class="font-bold text-[#171A19] dark:text-white block">Thủ tục tạm trú</span>
                                <span class="text-[#70746F] text-xs">Chủ nhà hỗ trợ hoàn tất thủ tục đăng ký tạm trú với công an phường sở tại.</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- 6. VỊ TRÍ & TIỆN ÍCH KHU VỰC XUNG QUANH --}}
                <div id="map-section" class="bg-white dark:bg-[#181B19] rounded-xl p-6 border border-[#E5E3DC] dark:border-[#282D2A] shadow-2xs">
                    <h2 class="text-base sm:text-lg font-bold text-[#171A19] dark:text-white mb-1 flex items-center gap-2">
                        <span class="w-2 h-4 rounded-xs bg-[#1B3D2F] dark:bg-[#7EA089]"></span>
                        Vị Trí & Tiện Ích Ngoại Khu Lân Cận
                    </h2>
                    <p class="text-xs text-[#70746F] dark:text-stone-400 mb-4 flex items-center gap-1">
                        <i class="ri-map-pin-line text-[#85877F]"></i>
                        <span>{{ $item['dia_chi'] ?? 'Thành phố Hồ Chí Minh' }}</span>
                    </p>

                    {{-- Google Maps Embed --}}
                    <div class="w-full h-72 rounded-lg overflow-hidden border border-[#E5E3DC] dark:border-[#282D2A] mb-4 bg-stone-100">
                        <iframe
                            width="100%"
                            height="100%"
                            style="border:0;"
                            loading="lazy"
                            allowfullscreen
                            referrerpolicy="no-referrer-when-downgrade"
                            src="https://www.google.com/maps?q={{ urlencode($item['dia_chi'] ?? 'TP Hồ Chí Minh') }}&output=embed">
                        </iframe>
                    </div>

                    {{-- Tiện ích xung quanh --}}
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-2.5 text-xs">
                        <div class="p-2.5 rounded-lg bg-[#FAF9F6] dark:bg-[#1E2320] border border-[#E5E3DC] dark:border-[#282D2A] text-center">
                            <span class="font-bold text-[#171A19] dark:text-white block">Chợ / Siêu thị</span>
                            <span class="text-[#85877F] text-[11px]">Cách ~200m</span>
                        </div>
                        <div class="p-2.5 rounded-lg bg-[#FAF9F6] dark:bg-[#1E2320] border border-[#E5E3DC] dark:border-[#282D2A] text-center">
                            <span class="font-bold text-[#171A19] dark:text-white block">Trường ĐH / CĐ</span>
                            <span class="text-[#85877F] text-[11px]">Cách ~500m - 1km</span>
                        </div>
                        <div class="p-2.5 rounded-lg bg-[#FAF9F6] dark:bg-[#1E2320] border border-[#E5E3DC] dark:border-[#282D2A] text-center">
                            <span class="font-bold text-[#171A19] dark:text-white block">Trạm xe buýt</span>
                            <span class="text-[#85877F] text-[11px]">Cách ~100m</span>
                        </div>
                        <div class="p-2.5 rounded-lg bg-[#FAF9F6] dark:bg-[#1E2320] border border-[#E5E3DC] dark:border-[#282D2A] text-center">
                            <span class="font-bold text-[#171A19] dark:text-white block">Trạm y tế</span>
                            <span class="text-[#85877F] text-[11px]">Cách ~800m</span>
                        </div>
                    </div>
                </div>

                {{-- 7. CHÍNH SÁCH BẢO VỆ NGƯỜI THUÊ --}}
                <div class="p-6 rounded-xl bg-[#1B3D2F] text-white border border-[#2E5846]">
                    <span class="text-xs font-semibold text-[#D5E5DC] uppercase tracking-wider block mb-1">
                        Cam kết pháp lý hệ thống
                    </span>
                    <h3 class="text-lg font-bold mb-2">Bảo Vệ Quyền Lợi Khách Thuê Phòng</h3>
                    <p class="text-xs sm:text-sm text-stone-200 mb-5">Mọi giao dịch giữ chỗ và hợp đồng đều có biên bản đối soát bảo vệ quyền lợi hai bên.</p>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 text-xs">
                        <div class="p-3 rounded-lg bg-[#274F3E] border border-[#3A6B54]">
                            <span class="font-bold block text-white mb-0.5">Hoàn tiền giữ phòng</span>
                            <span class="text-stone-300">Nếu thông tin thực tế sai lệch so với bài đăng.</span>
                        </div>
                        <div class="p-3 rounded-lg bg-[#274F3E] border border-[#3A6B54]">
                            <span class="font-bold block text-white mb-0.5">Hợp đồng điện tử</span>
                            <span class="text-stone-300">Quy định điều khoản bồi thường và hoàn cọc minh bạch.</span>
                        </div>
                        <div class="p-3 rounded-lg bg-[#274F3E] border border-[#3A6B54]">
                            <span class="font-bold block text-white mb-0.5">Hỗ trợ trung gian</span>
                            <span class="text-stone-300">Đường dây hỗ trợ tiếp nhận thắc mắc và giải quyết tranh chấp.</span>
                        </div>
                    </div>
                </div>

                {{-- 8. ĐÁNH GIÁ TỪ CỘNG ĐỒNG KHÁCH THUÊ (REVIEWS) --}}
                <div id="reviews-section" class="bg-white dark:bg-[#181B19] rounded-xl p-6 border border-[#E5E3DC] dark:border-[#282D2A] shadow-2xs">
                    <div class="flex flex-wrap items-center justify-between gap-3 mb-6 pb-4 border-b border-[#EAE8E1] dark:border-[#262B28]">
                        <div>
                            <h2 class="text-base sm:text-lg font-bold text-[#171A19] dark:text-white flex items-center gap-2">
                                <span class="w-2 h-4 rounded-xs bg-[#1B3D2F] dark:bg-[#7EA089]"></span>
                                Đánh Giá Từ Khách Đã Thuê
                            </h2>
                            <p class="text-xs text-[#70746F] dark:text-stone-400 mt-0.5">Nhận xét thực tế từ người thuê phòng tại địa chỉ này.</p>
                        </div>

                        <button type="button" onclick="openReviewModal()"
                            class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-lg bg-[#FAF9F6] dark:bg-[#202522] hover:bg-[#1B3D2F] hover:text-white dark:hover:bg-[#1B3D2F] text-[#1B3D2F] dark:text-[#A3B899] font-semibold text-xs border border-[#E5E3DC] dark:border-[#303632] transition">
                            <i class="ri-edit-2-line"></i> Viết đánh giá
                        </button>
                    </div>

                    {{-- Review Score Overview --}}
                    <div class="p-4 rounded-lg bg-[#FAF9F6] dark:bg-[#1E2320] border border-[#E5E3DC] dark:border-[#282D2A] mb-5 flex flex-col md:flex-row items-center gap-6">
                        <div class="text-center md:text-left shrink-0">
                            <span class="text-3xl sm:text-4xl font-bold text-[#171A19] dark:text-white block">4.9</span>
                            <div class="flex text-[#A6824D] text-sm my-1 justify-center md:justify-start">
                                <i class="ri-star-fill"></i>
                                <i class="ri-star-fill"></i>
                                <i class="ri-star-fill"></i>
                                <i class="ri-star-fill"></i>
                                <i class="ri-star-fill"></i>
                            </div>
                            <span class="text-xs text-[#85877F] font-medium">Khách thuê đánh giá tích cực</span>
                        </div>

                        {{-- 4 Criteria --}}
                        <div class="w-full grid grid-cols-1 sm:grid-cols-2 gap-2 text-xs">
                            <div class="p-2 rounded-md bg-white dark:bg-[#181B19] border border-[#E5E3DC] dark:border-[#282D2A] flex items-center justify-between">
                                <span class="font-medium text-[#555955] dark:text-stone-300">An ninh & Trật tự</span>
                                <span class="font-bold text-[#171A19] dark:text-white">5.0 / 5.0</span>
                            </div>
                            <div class="p-2 rounded-md bg-white dark:bg-[#181B19] border border-[#E5E3DC] dark:border-[#282D2A] flex items-center justify-between">
                                <span class="font-medium text-[#555955] dark:text-stone-300">Vị trí & Đi lại</span>
                                <span class="font-bold text-[#171A19] dark:text-white">4.9 / 5.0</span>
                            </div>
                            <div class="p-2 rounded-md bg-white dark:bg-[#181B19] border border-[#E5E3DC] dark:border-[#282D2A] flex items-center justify-between">
                                <span class="font-medium text-[#555955] dark:text-stone-300">Chủ nhà hỗ trợ</span>
                                <span class="font-bold text-[#171A19] dark:text-white">5.0 / 5.0</span>
                            </div>
                            <div class="p-2 rounded-md bg-white dark:bg-[#181B19] border border-[#E5E3DC] dark:border-[#282D2A] flex items-center justify-between">
                                <span class="font-medium text-[#555955] dark:text-stone-300">Minh bạch điện nước</span>
                                <span class="font-bold text-[#171A19] dark:text-white">4.8 / 5.0</span>
                            </div>
                        </div>
                    </div>

                    {{-- Review List --}}
                    <div id="reviewsListContainer" class="divide-y divide-[#EAE8E1] dark:divide-[#282D2A] space-y-3.5">
                        <div class="pt-3.5 first:pt-0">
                            <div class="flex items-center justify-between mb-1.5">
                                <div class="flex items-center gap-2">
                                    <span class="font-bold text-xs sm:text-sm text-[#171A19] dark:text-white">Nguyễn Hoàng Nam</span>
                                    <span class="inline-flex items-center gap-1 text-[10px] font-semibold text-[#0D9488] dark:text-[#2DD4BF] bg-teal-50 dark:bg-teal-950/40 px-1.5 py-0.5 rounded border border-teal-200 dark:border-teal-800/60"><i class="ri-checkbox-circle-fill text-[11px]"></i> Đã thuê</span>
                                </div>
                                <span class="text-xs text-[#85877F]">12/09/2026</span>
                            </div>
                            <div class="flex text-[#A6824D] text-xs mb-1.5">
                                <i class="ri-star-fill"></i>
                                <i class="ri-star-fill"></i>
                                <i class="ri-star-fill"></i>
                                <i class="ri-star-fill"></i>
                                <i class="ri-star-fill"></i>
                            </div>
                            <p class="text-[#555955] dark:text-stone-300 text-xs sm:text-sm leading-relaxed">
                                “Phòng mới và rất thoáng mát, có ban công phơi đồ riêng. Chú chủ trọ rất dễ tính, hỗ trợ làm thủ tục đăng ký tạm trú nhanh gọn. Giờ giấc tự do 24/24 về khuya mở cổng vân tay rất an tâm.”
                            </p>
                        </div>

                        <div class="pt-3.5">
                            <div class="flex items-center justify-between mb-1.5">
                                <div class="flex items-center gap-2">
                                    <span class="font-bold text-xs sm:text-sm text-[#171A19] dark:text-white">Trần Thị Mỹ Duyên</span>
                                    <span class="inline-flex items-center gap-1 text-[10px] font-semibold text-[#0D9488] dark:text-[#2DD4BF] bg-teal-50 dark:bg-teal-950/40 px-1.5 py-0.5 rounded border border-teal-200 dark:border-teal-800/60"><i class="ri-checkbox-circle-fill text-[11px]"></i> Đã thuê</span>
                                </div>
                                <span class="text-xs text-[#85877F]">28/08/2026</span>
                            </div>
                            <div class="flex text-[#A6824D] text-xs mb-1.5">
                                <i class="ri-star-fill"></i>
                                <i class="ri-star-fill"></i>
                                <i class="ri-star-fill"></i>
                                <i class="ri-star-fill"></i>
                                <i class="ri-star-fill"></i>
                            </div>
                            <p class="text-[#555955] dark:text-stone-300 text-xs sm:text-sm leading-relaxed">
                                “Điện nước đồng hồ riêng tính đúng chỉ số niêm yết, cuối tháng nhận thông báo hóa đơn rõ ràng minh bạch trên hệ thống không bị phát sinh thêm phí lạ.”
                            </p>
                        </div>

                        {{-- Additional reviews from database if present --}}
                        @if(!empty($item['danh_gia']) && count($item['danh_gia']) > 0)
                            @foreach($item['danh_gia'] as $dg)
                                <div class="pt-3.5">
                                    <div class="flex items-center justify-between mb-1.5">
                                        <div class="flex items-center gap-2">
                                            <span class="font-bold text-xs sm:text-sm text-[#171A19] dark:text-white">{{ $dg['nguoi_danh_gia'] ?? 'Khách thuê' }}</span>
                                            <span class="inline-flex items-center gap-1 text-[10px] font-semibold text-[#0D9488] dark:text-[#2DD4BF] bg-teal-50 dark:bg-teal-950/40 px-1.5 py-0.5 rounded border border-teal-200 dark:border-teal-800/60"><i class="ri-checkbox-circle-fill text-[11px]"></i> Đã thuê</span>
                                        </div>
                                        <span class="text-xs text-[#85877F]">{{ \Carbon\Carbon::parse($dg['ngay_tao'] ?? now())->format('d/m/Y') }}</span>
                                    </div>
                                    <div class="flex text-[#A6824D] text-xs mb-1.5">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="{{ $i <= ($dg['diem_so'] ?? 5) ? 'ri-star-fill' : 'ri-star-line text-stone-300' }}"></i>
                                        @endfor
                                    </div>
                                    <p class="text-[#555955] dark:text-stone-300 text-xs sm:text-sm leading-relaxed">
                                        “{{ $dg['binh_luan'] ?? 'Phòng sạch sẽ, chủ trọ nhiệt tình hỗ trợ, khu vực an ninh tốt.' }}”
                                    </p>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>

            </div>


            {{-- ➡️ RIGHT COLUMN: STICKY BOOKING & HOST CARD (4 cols) --}}
            <div class="lg:col-span-4 space-y-6 lg:sticky lg:top-24">

                {{-- 💳 THẺ ĐẶT PHÒNG THƯƠNG MẠI (COMMERCIAL RESERVATION CARD) --}}
                <div class="bg-white dark:bg-[#181B19] rounded-xl p-6 border-2 border-[#1B3D2F]/20 dark:border-[#7EA089]/30 shadow-md">
                    
                    {{-- Giá thuê & Status --}}
                    <div class="flex items-baseline justify-between mb-4">
                        <div>
                            <span class="text-[10px] font-semibold uppercase tracking-wider text-[#85877F] block">Giá thuê niêm yết</span>
                            <div class="text-2xl sm:text-3xl font-bold text-[#1B3D2F] dark:text-[#A3B899] tracking-tight">
                                {{ $item['gia_hien_thi'] ?? number_format($giaNiemYet, 0, ',', '.') . ' ₫' }}
                                <span class="text-xs font-normal text-[#85877F]">/ tháng</span>
                            </div>
                        </div>

                        <div>
                            @if($isAvailable)
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded text-xs font-bold bg-emerald-50 text-emerald-800 dark:bg-emerald-950/60 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                    Còn phòng
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded text-xs font-bold bg-stone-100 text-stone-600 dark:bg-stone-800 dark:text-stone-300 border border-stone-200 dark:border-stone-700">
                                    Đã cho thuê
                                </span>
                            @endif
                        </div>
                    </div>

                    {{-- Thông tin tóm tắt nhanh --}}
                    <div class="p-3 rounded-lg bg-[#FAF9F6] dark:bg-[#1E2320] border border-[#E5E3DC] dark:border-[#282D2A] space-y-2 text-xs mb-5">
                        <div class="flex justify-between items-center">
                            <span class="text-[#70746F]">Phí cọc giữ phòng:</span>
                            <span class="font-bold text-[#171A19] dark:text-white">
                                {{ !empty($item['tien_coc']) ? number_format($item['tien_coc'], 0, ',', '.') . ' ₫' : '1 tháng tiền phòng' }}
                            </span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-[#70746F]">Thời hạn thuê tối thiểu:</span>
                            <span class="font-bold text-[#171A19] dark:text-white">06 tháng</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-[#70746F]">Phí môi giới / trung gian:</span>
                            <span class="font-bold text-[#1B3D2F] dark:text-[#A3B899]">0 ₫ (Miễn phí 100%)</span>
                        </div>
                    </div>

                    {{-- NÚT GỬI YÊU CẦU THUÊ PHÒNG (PRIMARY CTA) --}}
                    @if($isAvailable)
                        <button type="button" onclick="showYeuCauThuePopup({{ $item['id'] ?? 1 }})"
                            class="w-full py-3.5 px-5 rounded-lg bg-[#1B3D2F] hover:bg-[#142F24] text-white font-bold text-sm shadow-sm transition-all flex items-center justify-center gap-2 mb-3 cursor-pointer micro-press btn-glow-teal">
                            <i class="ri-file-edit-line text-base"></i>
                            <span>GỬI YÊU CẦU THUÊ PHÒNG</span>
                        </button>
                    @else
                        <button disabled
                            class="w-full py-3 px-5 rounded-lg bg-stone-200 dark:bg-stone-800 text-stone-400 font-bold text-xs cursor-not-allowed mb-3 flex items-center justify-center gap-2">
                            <span>PHÒNG ĐÃ CÓ NGƯỜI THUÊ</span>
                        </button>
                    @endif

                    {{-- NÚT LIÊN HỆ TRỰC TIẾP (CALL & ZALO) --}}
                    <div class="grid grid-cols-2 gap-2 mb-4">
                        <a href="tel:{{ $chuTroSdt }}"
                            class="py-2.5 px-3 rounded-lg bg-[#FAF9F6] hover:bg-stone-200 dark:bg-[#1E2320] dark:hover:bg-[#282E2A] text-[#171A19] dark:text-white font-semibold text-xs flex items-center justify-center gap-1.5 transition text-center border border-[#E5E3DC] dark:border-[#282D2A]">
                            <i class="ri-phone-line text-[#1B3D2F] dark:text-[#A3B899]"></i>
                            <span>Gọi điện</span>
                        </a>

                        <a href="https://zalo.me/{{ $chuTroSdt }}" target="_blank" rel="noopener noreferrer"
                            class="py-2.5 px-3 rounded-lg bg-[#FAF9F6] hover:bg-stone-200 dark:bg-[#1E2320] dark:hover:bg-[#282E2A] text-[#171A19] dark:text-white font-semibold text-xs flex items-center justify-center gap-1.5 transition text-center border border-[#E5E3DC] dark:border-[#282D2A]">
                            <i class="ri-chat-1-line text-[#1B3D2F] dark:text-[#A3B899]"></i>
                            <span>Nhắn Zalo</span>
                        </a>
                    </div>

                    {{-- Cam kết quy chuẩn --}}
                    <div class="pt-3 border-t border-[#EAE8E1] dark:border-[#282D2A] space-y-1.5 text-[11px] text-[#70746F]">
                        <div class="flex items-center gap-1.5">
                            <i class="ri-checkbox-circle-line text-[#1B3D2F] dark:text-[#A3B899]"></i>
                            <span>Giữ chỗ ngay sau khi chủ nhà xác nhận</span>
                        </div>
                        <div class="flex items-center gap-1.5">
                            <i class="ri-checkbox-circle-line text-[#1B3D2F] dark:text-[#A3B899]"></i>
                            <span>Ký kết hợp đồng điện tử bảo mật</span>
                        </div>
                    </div>
                </div>

                {{-- 👤 THẺ CHỦ TRỌ UY TÍN (HOST PROFILE CARD) --}}
                <div class="bg-white dark:bg-[#181B19] rounded-xl p-5 border border-[#E5E3DC] dark:border-[#282D2A] shadow-2xs">
                    <span class="text-[10px] font-semibold uppercase tracking-wider text-[#85877F] block mb-3">Thông tin chủ quản lý</span>

                    <div class="flex items-center gap-3 mb-3.5">
                        <div class="w-11 h-11 rounded-lg bg-[#FAF9F6] dark:bg-[#222724] text-[#1B3D2F] dark:text-[#A3B899] font-bold flex items-center justify-center text-lg border border-[#E5E3DC] dark:border-[#303632]">
                            {{ mb_substr($chuTroTen, 0, 1) }}
                        </div>
                        <div>
                            <h4 class="font-bold text-sm text-[#171A19] dark:text-white flex items-center gap-1">
                                {{ $chuTroTen }}
                                <i class="ri-verified-badge-fill text-[#1B3D2F] dark:text-[#A3B899] text-sm" title="Đã xác minh danh tính"></i>
                            </h4>
                            <span class="text-[11px] text-[#70746F] dark:text-stone-400 font-medium">
                                Chủ nhà đối tác chính thức
                            </span>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-2 text-center text-xs py-2.5 border-y border-[#EAE8E1] dark:border-[#282D2A] mb-3">
                        <div>
                            <span class="text-[#85877F] block text-[10px]">Tỉ lệ phản hồi</span>
                            <span class="font-bold text-[#171A19] dark:text-white">100%</span>
                        </div>
                        <div>
                            <span class="text-[#85877F] block text-[10px]">Thời gian phản hồi</span>
                            <span class="font-bold text-[#171A19] dark:text-white">&lt; 15 phút</span>
                        </div>
                    </div>

                    <div class="flex items-center justify-between text-xs font-medium text-[#555955] dark:text-stone-300">
                        <span>Hotline:</span>
                        <a href="tel:{{ $chuTroSdt }}" class="font-bold text-[#1B3D2F] dark:text-[#A3B899] hover:underline">
                            {{ $chuTroSdt }}
                        </a>
                    </div>
                </div>

            </div>

        </div>

        {{-- 🏘️ SECTION: PHÒNG TRỌ TƯƠNG TỰ CÙNG KHU VỰC (SIMILAR INVENTORY) --}}
        @if(!empty($similarPosts) && count($similarPosts) > 0)
            <div class="mt-16 pt-8 border-t border-[#E5E3DC] dark:border-[#262B28]">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <span class="text-xs font-semibold uppercase tracking-wider text-[#1B3D2F] dark:text-[#A3B899] block mb-0.5">Lựa chọn thay thế</span>
                        <h2 class="text-xl sm:text-2xl font-bold text-[#171A19] dark:text-white">Phòng Trọ Tương Tự Cùng Khu Vực</h2>
                    </div>
                    <a href="{{ route('listing') }}" class="text-xs sm:text-sm font-semibold text-[#1B3D2F] dark:text-[#A3B899] hover:underline flex items-center gap-1">
                        Xem tất cả <i class="ri-arrow-right-line"></i>
                    </a>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                    @foreach($similarPosts as $sim)
                        @php
                            $simImg = !empty($sim['anh']) && is_array($sim['anh']) ? ($sim['anh'][0] ?? null) : ($sim['anh_dai_dien'] ?? null);
                            if (empty($simImg)) $simImg = asset('images/no-image.png');
                        @endphp
                        <div class="group bg-white dark:bg-[#181B19] rounded-xl border border-[#E5E3DC] dark:border-[#282D2A] overflow-hidden shadow-2xs hover:shadow-md transition-all flex flex-col justify-between">
                            <div>
                                <div class="relative h-40 overflow-hidden bg-stone-100">
                                    <img src="{{ $simImg }}" alt="{{ $sim['tieu_de'] ?? 'Phòng' }}"
                                        class="w-full h-full object-cover group-hover:scale-104 transition-transform duration-500">
                                    <span class="absolute top-2.5 left-2.5 px-2 py-0.5 rounded text-[10px] font-semibold bg-[#121514]/80 text-white backdrop-blur-md">
                                        {{ $sim['ten_day_tro'] ?? 'Trọ' }}
                                    </span>
                                </div>

                                <div class="p-3.5 space-y-1.5">
                                    <h4 class="font-bold text-xs sm:text-sm text-[#171A19] dark:text-white line-clamp-1 group-hover:text-[#1B3D2F] dark:group-hover:text-[#A3B899] transition">
                                        {{ $sim['tieu_de'] ?? 'Phòng trọ tiện nghi' }}
                                    </h4>
                                    <p class="text-xs text-[#70746F] line-clamp-1">
                                        <i class="ri-map-pin-line text-[#85877F]"></i> {{ $sim['dia_chi'] ?? 'TP.HCM' }}
                                    </p>
                                    <div class="flex items-center gap-2 text-xs text-[#85877F] pt-0.5">
                                        <span>{{ $sim['dien_tich'] ?? '20' }} m²</span>
                                        <span>•</span>
                                        <span>{{ $sim['suc_chua'] ?? '2' }} người</span>
                                    </div>
                                </div>
                            </div>

                            <div class="px-3.5 pb-3.5 pt-2 flex items-center justify-between border-t border-[#EAE8E1] dark:border-[#282D2A] mt-1">
                                <span class="font-bold text-sm text-[#1B3D2F] dark:text-[#A3B899]">
                                    {{ $sim['gia_hien_thi'] ?? (number_format($sim['gia_niem_yet'] ?? 0, 0, ',', '.') . ' ₫') }}
                                </span>
                                <a href="{{ url('/bai-dang/' . $sim['id']) }}"
                                    class="px-2.5 py-1 rounded-md bg-[#FAF9F6] dark:bg-[#1E2320] hover:bg-[#1B3D2F] hover:text-white text-[#1B3D2F] dark:text-[#A3B899] text-xs font-semibold border border-[#E5E3DC] dark:border-[#2D3330] transition">
                                    Chi tiết
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

    </div>

    {{-- 📱 STICKY MOBILE BOTTOM BAR --}}
    <div class="lg:hidden fixed bottom-0 left-0 right-0 z-40 bg-white/95 dark:bg-[#161917]/95 backdrop-blur-md border-t border-[#E5E3DC] dark:border-[#282D2A] p-3 shadow-lg flex items-center justify-between gap-3">
        <div>
            <span class="text-[10px] text-[#85877F] uppercase tracking-wider block font-semibold">Giá thuê</span>
            <span class="text-base font-bold text-[#1B3D2F] dark:text-[#A3B899]">
                {{ $item['gia_hien_thi'] ?? number_format($giaNiemYet, 0, ',', '.') . ' ₫' }}
            </span>
        </div>

        <div class="flex items-center gap-2">
            <a href="tel:{{ $chuTroSdt }}" aria-label="Gọi điện"
                class="w-10 h-10 rounded-lg bg-[#FAF9F6] dark:bg-[#1E2320] text-[#171A19] dark:text-white flex items-center justify-center text-base border border-[#E5E3DC] dark:border-[#282D2A] shrink-0">
                <i class="ri-phone-line text-[#1B3D2F] dark:text-[#A3B899]"></i>
            </a>

            @if($isAvailable)
                <button type="button" onclick="showYeuCauThuePopup({{ $item['id'] ?? 1 }})"
                    class="micro-press py-2.5 px-4 rounded-lg bg-[#1B3D2F] hover:bg-[#142F24] text-white font-semibold text-xs transition-all shadow-sm">
                    Đặt phòng ngay
                </button>
            @else
                <button disabled
                    class="py-2.5 px-3 rounded-lg bg-stone-200 dark:bg-stone-800 text-stone-400 font-semibold text-xs cursor-not-allowed">
                    Đã cho thuê
                </button>
            @endif
        </div>
    </div>

    {{-- 🔍 FULLSCREEN LIGHTBOX MODAL (PORTALED TO BODY) --}}
    <div id="lightboxModal" class="hidden fixed inset-0 z-[9999] bg-black/95 backdrop-blur-md flex flex-col items-center justify-between p-4 sm:p-6 select-none" onclick="if(event.target === this) closeLightbox()">
        {{-- Top Bar --}}
        <div class="w-full flex items-center justify-between z-20 text-white/90 px-2 py-1 max-w-6xl">
            <div id="lightboxCaption" class="text-xs sm:text-sm font-semibold tracking-wide bg-white/10 px-3.5 py-1 rounded-full backdrop-blur-sm">
                Ảnh 1 / {{ count($images) }}
            </div>
            <button type="button" onclick="closeLightbox()"
                class="micro-press w-10 h-10 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center text-2xl transition cursor-pointer"
                title="Đóng (Esc)">
                <i class="ri-close-line"></i>
            </button>
        </div>

        {{-- Main Stage & Navigation Arrows --}}
        <div class="relative w-full flex-1 flex items-center justify-center max-w-6xl my-auto overflow-hidden">
            <button type="button" onclick="prevLightbox(event)"
                class="micro-press absolute left-2 sm:left-4 z-20 w-11 h-11 rounded-full bg-white/15 hover:bg-white/30 text-white flex items-center justify-center text-2xl transition shadow-lg backdrop-blur-sm cursor-pointer"
                title="Ảnh trước (Mũi tên trái)">
                <i class="ri-arrow-left-s-line"></i>
            </button>

            <button type="button" onclick="nextLightbox(event)"
                class="micro-press absolute right-2 sm:right-4 z-20 w-11 h-11 rounded-full bg-white/15 hover:bg-white/30 text-white flex items-center justify-center text-2xl transition shadow-lg backdrop-blur-sm cursor-pointer"
                title="Ảnh tiếp theo (Mũi tên phải)">
                <i class="ri-arrow-right-s-line"></i>
            </button>

            <div class="relative max-w-full max-h-[75vh] flex items-center justify-center p-2">
                <img id="lightboxImg" src="" alt="Fullscreen image"
                    class="max-w-full max-h-[75vh] object-contain rounded-xl shadow-2xl transition-all duration-300">
            </div>
        </div>

        {{-- Bottom Thumbnail Strip --}}
        <div class="w-full max-w-4xl z-20 flex items-center justify-center gap-2 py-2 overflow-x-auto">
            @foreach($images as $idx => $imgUrl)
                <button type="button" onclick="selectLightboxImage({{ $idx }})"
                    class="lightbox-thumb-btn relative w-14 h-11 sm:w-16 sm:h-12 rounded-lg overflow-hidden border-2 transition-all shrink-0 cursor-pointer {{ $idx === 0 ? 'border-white scale-105 opacity-100' : 'border-white/30 opacity-60 hover:opacity-90' }}"
                    data-lb-idx="{{ $idx }}">
                    <img src="{{ $imgUrl }}" class="w-full h-full object-cover" alt="Thumb {{ $idx + 1 }}">
                </button>
            @endforeach
        </div>
    </div>

</section>

{{-- Flash messages handler --}}
@if(session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Thành công!',
            text: '{{ session('success') }}',
            confirmButtonColor: '#1B3D2F'
        });
    </script>
@endif

@if(session('error'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Lỗi!',
            text: '{{ session('error') }}',
            confirmButtonColor: '#B84A39'
        });
    </script>
@endif

<script>
    // Gallery State & Handlers
    const galleryImages = @json($images);
    let currentImageIndex = 0;

    function selectImage(idx) {
        if (!galleryImages[idx]) return;
        currentImageIndex = idx;
        const mainImg = document.getElementById('mainGalleryImage');
        if (mainImg) mainImg.src = galleryImages[idx];

        document.querySelectorAll('.thumb-btn').forEach(btn => {
            const btnIdx = parseInt(btn.dataset.idx, 10);
            if (btnIdx === idx) {
                btn.classList.add('border-white', 'scale-105');
                btn.classList.remove('border-white/40', 'opacity-70');
            } else {
                btn.classList.remove('border-white', 'scale-105');
                btn.classList.add('border-white/40', 'opacity-70');
            }
        });
    }

    function prevImage(e) {
        if (e) e.stopPropagation();
        currentImageIndex = (currentImageIndex - 1 + galleryImages.length) % galleryImages.length;
        selectImage(currentImageIndex);
    }

    function nextImage(e) {
        if (e) e.stopPropagation();
        currentImageIndex = (currentImageIndex + 1) % galleryImages.length;
        selectImage(currentImageIndex);
    }

    // Lightbox Handlers
    function ensureLightboxInBody() {
        const modal = document.getElementById('lightboxModal');
        if (modal && modal.parentElement !== document.body) {
            document.body.appendChild(modal);
        }
    }

    function selectLightboxImage(idx) {
        if (!galleryImages[idx]) return;
        currentImageIndex = idx;
        const img = document.getElementById('lightboxImg');
        const caption = document.getElementById('lightboxCaption');
        if (img) img.src = galleryImages[currentImageIndex];
        if (caption) caption.textContent = `Ảnh ${currentImageIndex + 1} / ${galleryImages.length}`;

        document.querySelectorAll('.lightbox-thumb-btn').forEach(btn => {
            const btnIdx = parseInt(btn.dataset.lbIdx, 10);
            if (btnIdx === idx) {
                btn.classList.add('border-white', 'scale-105', 'opacity-100');
                btn.classList.remove('border-white/30', 'opacity-60');
            } else {
                btn.classList.remove('border-white', 'scale-105', 'opacity-100');
                btn.classList.add('border-white/30', 'opacity-60');
            }
        });
    }

    function openLightbox(idx) {
        ensureLightboxInBody();
        const modal = document.getElementById('lightboxModal');
        const img = document.getElementById('lightboxImg');
        if (!modal || !img) return;

        selectLightboxImage(idx);
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeLightbox() {
        const modal = document.getElementById('lightboxModal');
        if (modal) modal.classList.add('hidden');
        document.body.style.overflow = '';
    }

    function prevLightbox(e) {
        if (e) e.stopPropagation();
        const newIdx = (currentImageIndex - 1 + galleryImages.length) % galleryImages.length;
        selectLightboxImage(newIdx);
    }

    function nextLightbox(e) {
        if (e) e.stopPropagation();
        const newIdx = (currentImageIndex + 1) % galleryImages.length;
        selectLightboxImage(newIdx);
    }

    // Keyboard navigation (Esc, Left, Right)
    document.addEventListener('keydown', function(e) {
        const modal = document.getElementById('lightboxModal');
        if (!modal || modal.classList.contains('hidden')) return;

        if (e.key === 'Escape') {
            closeLightbox();
        } else if (e.key === 'ArrowLeft') {
            prevLightbox();
        } else if (e.key === 'ArrowRight') {
            nextLightbox();
        }
    });

    // Auto-portal lightbox on load
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', ensureLightboxInBody);
    } else {
        ensureLightboxInBody();
    }

    // Quick Share Functionality
    function shareProperty() {
        if (navigator.clipboard) {
            navigator.clipboard.writeText(window.location.href).then(() => {
                Swal.fire({
                    icon: 'success',
                    title: 'Đã sao chép liên kết!',
                    text: 'Bạn có thể gửi liên kết này cho bạn bè qua Zalo, tin nhắn,...',
                    timer: 2000,
                    showConfirmButton: false
                });
            }).catch(() => {
                prompt('Sao chép đường dẫn bài đăng:', window.location.href);
            });
        } else {
            prompt('Sao chép đường dẫn bài đăng:', window.location.href);
        }
    }

    // Open Review Modal
    function openReviewModal() {
        Swal.fire({
            title: 'Viết đánh giá phòng trọ',
            html: `
                <div class="text-left space-y-3 pt-2 text-xs sm:text-sm">
                    <div>
                        <label class="block font-semibold text-slate-700 mb-1">Họ và tên của bạn:</label>
                        <input type="text" id="reviewAuthor" class="swal2-input !mt-0 !mb-1 !w-full" placeholder="VD: Nguyễn Văn A">
                    </div>
                    <div>
                        <label class="block font-semibold text-slate-700 mb-1">Mô tả người thuê:</label>
                        <input type="text" id="reviewRole" class="swal2-input !mt-0 !mb-1 !w-full" placeholder="VD: Sinh viên ĐH Bách Khoa • Đã ở 6 tháng">
                    </div>
                    <div>
                        <label class="block font-semibold text-slate-700 mb-1">Mức độ hài lòng:</label>
                        <select id="reviewRating" class="swal2-input !mt-0 !mb-1 !w-full">
                            <option value="5">Rất hài lòng (5 sao)</option>
                            <option value="4">Hài lòng (4 sao)</option>
                            <option value="3">Bình thường (3 sao)</option>
                        </select>
                    </div>
                    <div>
                        <label class="block font-semibold text-slate-700 mb-1">Nội dung nhận xét:</label>
                        <textarea id="reviewComment" rows="3" class="swal2-textarea !mt-0 !w-full" placeholder="Chia sẻ cảm nhận về an ninh, chủ nhà, điện nước, wifi..."></textarea>
                    </div>
                </div>
            `,
            confirmButtonText: 'Gửi đánh giá',
            confirmButtonColor: '#1B3D2F',
            showCancelButton: true,
            cancelButtonText: 'Hủy',
            preConfirm: () => {
                const author = document.getElementById('reviewAuthor').value.trim();
                const role = document.getElementById('reviewRole').value.trim() || 'Khách thuê phòng';
                const rating = document.getElementById('reviewRating').value;
                const comment = document.getElementById('reviewComment').value.trim();
                if (!author || !comment) {
                    Swal.showValidationMessage('Vui lòng nhập tên và nội dung đánh giá');
                    return false;
                }
                return { author, role, rating, comment };
            }
        }).then(result => {
            if (result.isConfirmed) {
                const { author, role, rating, comment } = result.value;
                const container = document.getElementById('reviewsListContainer');
                if (container) {
                    const starsHtml = '<i class="ri-star-fill text-[#A6824D]"></i>'.repeat(parseInt(rating, 10));
                    const newReviewHtml = `
                        <div class="pt-3.5 border-t border-[#EAE8E1] dark:border-[#282D2A]">
                            <div class="flex items-center justify-between mb-1.5">
                                <div class="flex items-center gap-2">
                                    <span class="font-bold text-xs sm:text-sm text-[#171A19] dark:text-white">${author}</span>
                                    <span class="inline-flex items-center gap-1 text-[10px] font-semibold text-[#0D9488] dark:text-[#2DD4BF] bg-teal-50 dark:bg-teal-950/40 px-1.5 py-0.5 rounded border border-teal-200 dark:border-teal-800/60"><i class="ri-checkbox-circle-fill text-[11px]"></i> Vừa gửi</span>
                                    <span class="text-[11px] text-[#85877F]">${role}</span>
                                </div>
                                <span class="text-xs text-[#85877F]">Vừa xong</span>
                            </div>
                            <div class="flex text-xs mb-1.5">
                                ${starsHtml}
                            </div>
                            <p class="text-[#555955] dark:text-stone-300 text-xs sm:text-sm leading-relaxed">
                                “${comment}”
                            </p>
                        </div>
                    `;
                    container.insertAdjacentHTML('afterbegin', newReviewHtml);
                }
                Swal.fire({
                    icon: 'success',
                    title: 'Đã gửi đánh giá thành công!',
                    text: 'Cảm ơn đóng góp của bạn cho cộng đồng thuê phòng.',
                    timer: 2000,
                    showConfirmButton: false
                });
            }
        });
    }

    // Wishlist Toggle
    async function toggleYeuThich(baiDangId) {
        const token = localStorage.getItem('token');
        if (!token) {
            Swal.fire({
                icon: 'warning',
                title: 'Yêu cầu đăng nhập',
                text: 'Vui lòng đăng nhập để lưu phòng trọ yêu thích.',
                confirmButtonText: 'Đăng nhập',
                confirmButtonColor: '#1B3D2F'
            }).then(r => {
                if (r.isConfirmed) window.location.href = '/login';
            });
            return;
        }

        const btn = document.getElementById('btn-yeu-thich');
        const icon = document.getElementById('iconYeuThich');
        const text = document.getElementById('textYeuThich');
        const isFav = btn.getAttribute('data-favorite') === 'true';

        try {
            const res = await fetch(`{{ url('/api/khach-thue/yeu-thich/toggle') }}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${token}`
                },
                body: JSON.stringify({ bai_dang_id: baiDangId })
            });
            const data = await res.json();
            if (data.status) {
                const nowFav = !isFav;
                btn.setAttribute('data-favorite', nowFav ? 'true' : 'false');
                if (nowFav) {
                    icon.className = 'ri-heart-3-fill text-base text-rose-500';
                    text.textContent = 'Đã lưu';
                } else {
                    icon.className = 'ri-heart-3-line text-base text-[#85877F]';
                    text.textContent = 'Lưu tin';
                }
                Swal.fire({
                    icon: 'success',
                    title: data.message || 'Thành công',
                    timer: 1500,
                    showConfirmButton: false
                });
            }
        } catch (e) {
            console.error('Favorite error:', e);
        }
    }

    // Rental Booking Flow
    function showYeuCauThuePopup(baiDangId) {
        const isAuth = {{ (session('user') || auth()->check()) ? 'true' : 'false' }};
        const token = localStorage.getItem('token') || '{{ session('api_token') }}';

        if (!isAuth && !token) {
            Swal.fire({
                icon: 'warning',
                title: 'Yêu cầu đăng nhập',
                text: 'Quý khách vui lòng đăng nhập tài khoản Khách thuê để gửi yêu cầu giữ chỗ và ký hợp đồng thuê phòng.',
                showCancelButton: true,
                confirmButtonText: 'Đăng nhập ngay',
                cancelButtonText: 'Để sau',
                confirmButtonColor: '#1B3D2F'
            }).then(result => {
                if (result.isConfirmed) {
                    window.location.href = '{{ route("login") }}';
                }
            });
            return;
        }

        // Navigate directly to modern booking & digital contract checkout flow
        window.location.href = `{{ url('/khach-thue/yeu-cau-thue/tao-moi') }}/${baiDangId}`;
    }
</script>

@endsection
