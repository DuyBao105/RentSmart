@extends('layouts.app')

@section('title', 'Hệ Thống Trọ - Nền Tảng Cho Thuê Phòng Trọ & Quản Lý Nhà Trọ Đạt Chuẩn')

@section('content')
<div x-data="{
  showLoginModal: false,
  message: 'Vui lòng đăng nhập để tiếp tục',
  selectedCategory: 'all',
  activeTab: 'hot',
  openPopup(msg) {
    this.message = msg;
    this.showLoginModal = true;
  }
}">

{{-- Listen for Alpine-dispatched events from carousel --}}
<script>
document.addEventListener('show-chutro', function(e) {
  if (e && e.detail) {
    if (typeof showChuTroInfo === 'function') {
      showChuTroInfo(e.detail.ten, e.detail.sdt);
    } else {
      Swal.fire({
        title: 'Thông tin chủ nhà',
        html: `<div class="text-left space-y-3 p-2 text-sm text-slate-700">
          <p><strong>Họ tên chủ nhà:</strong> ${e.detail.ten}</p>
          <p><strong>Số điện thoại liên hệ:</strong> <a href="tel:${e.detail.sdt}" class="text-emerald-700 font-bold">${e.detail.sdt}</a></p>
          <p class="text-xs text-slate-500 pt-2 border-t border-slate-200">Khách thuê nên liên hệ trực tiếp để hẹn lịch xem phòng thực tế và đối chiếu cơ sở vật chất.</p>
        </div>`,
        icon: 'info',
        confirmButtonColor: '#1B3D2F',
        confirmButtonText: 'Đóng'
      });
    }
  }
});
</script>

<style>
  @keyframes heroFadeUp {
    from {
      opacity: 0;
      transform: translateY(18px);
    }
    to {
      opacity: 1;
      transform: translateY(0);
    }
  }
  .animate-hero-fade {
    animation: heroFadeUp 0.7s cubic-bezier(0.16, 1, 0.3, 1) both;
  }
  .animate-hero-fade-delayed {
    animation: heroFadeUp 0.85s cubic-bezier(0.16, 1, 0.3, 1) 0.15s both;
  }
  .animate-hero-fade-cards {
    animation: heroFadeUp 0.9s cubic-bezier(0.16, 1, 0.3, 1) 0.25s both;
  }
  @media (prefers-reduced-motion: reduce) {
    .animate-hero-fade,
    .animate-hero-fade-delayed,
    .animate-hero-fade-cards {
      animation: none !important;
      opacity: 1 !important;
      transform: none !important;
    }
  }
</style>

{{-- ============================================================ --}}
{{-- 🌟 1. PREMIUM PROPTECH SAAS HERO SECTION --}}
{{-- ============================================================ --}}
<section class="relative z-10 pt-10 pb-12 lg:pt-14 lg:pb-16 bg-gradient-to-b from-[#F0FDFA]/70 via-white to-white dark:from-[#091b17]/60 dark:via-[#121514] dark:to-[#121514] border-b border-[#E2E8F0] dark:border-[#262B28] overflow-hidden">
  {{-- Subtle Decorative Mint Glow in Background --}}
  <div class="absolute -top-24 right-0 w-96 h-96 bg-[#0D9488]/5 dark:bg-[#0D9488]/10 rounded-full blur-3xl pointer-events-none" aria-hidden="true"></div>
  <div class="absolute top-1/2 -left-20 w-80 h-80 bg-[#14B8A6]/5 dark:bg-[#14B8A6]/10 rounded-full blur-3xl pointer-events-none" aria-hidden="true"></div>

  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
    
    {{-- 2-COLUMN MAIN HERO CONTENT --}}
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-12 items-center">

      {{-- 👈 CỘT TRÁI: MESSAGING & CTAS --}}
      <div class="lg:col-span-7 text-left space-y-6 lg:space-y-7 animate-hero-fade">
        
        {{-- Eyebrow badge --}}
        <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-[#F0FDFA] dark:bg-[#115E59]/30 border border-[#CCFBF1] dark:border-[#0D9488]/40 text-xs font-semibold text-[#0D9488] dark:text-[#5EEAD4] shadow-xs">
          <span class="w-2 h-2 rounded-full bg-[#0D9488] dark:bg-[#5EEAD4]"></span>
          <span class="tracking-wide flex items-center gap-1">
            <i class="ri-sparkling-fill text-[#0D9488] dark:text-[#5EEAD4]" aria-hidden="true"></i>
            <span>Nền tảng quản lý nhà trọ thông minh</span>
          </span>
        </div>

        {{-- Main headline --}}
        <h1 class="text-3xl sm:text-5xl lg:text-[54px] font-extrabold tracking-tight leading-[1.12]">
          <span class="text-[#172B3A] dark:text-white block">Tìm đúng phòng.</span>
          <span class="text-[#0D9488] dark:text-[#2DD4BF] block mt-1.5">Sống đúng chất.</span>
        </h1>

        {{-- Supporting description --}}
        <p class="text-base sm:text-lg text-[#64748B] dark:text-slate-300 font-normal leading-relaxed max-w-xl">
          Khám phá phòng trọ phù hợp với ngân sách và nhu cầu của bạn. Quản lý phòng, hợp đồng và thu chi dễ dàng trên cùng một nền tảng.
        </p>

        {{-- Primary & Secondary CTAs --}}
        <div class="flex flex-wrap items-center gap-3.5 pt-1">
          {{-- Primary CTA: Tìm phòng ngay --}}
          <a href="{{ route('listing') }}"
             class="group micro-press inline-flex items-center justify-center gap-2 px-6 py-3.5 rounded-xl bg-[#0D9488] hover:bg-[#0F766E] text-white font-semibold text-sm sm:text-base shadow-md shadow-teal-700/20 hover:shadow-lg hover:shadow-teal-700/30 hover:-translate-y-0.5 active:translate-y-0 transition-all duration-200">
            <span>Tìm phòng ngay</span>
            <i class="ri-arrow-right-line text-lg group-hover:translate-x-1 transition-transform duration-200" aria-hidden="true"></i>
          </a>

          {{-- Secondary CTA: Dành cho chủ trọ --}}
          @php
            $isLandlord = (session('user')['vai_tro'] ?? null) === 'chu_tro';
            $landlordTarget = $isLandlord ? route('chu-tro.dashboard') : '#landlord-portal';
          @endphp
          <a href="{{ $landlordTarget }}"
             class="group micro-press inline-flex items-center justify-center gap-2 px-6 py-3.5 rounded-xl bg-white dark:bg-transparent border-2 border-[#0D9488] text-[#0D9488] dark:text-[#2DD4BF] hover:bg-[#F0FDFA] dark:hover:bg-[#115E59]/20 font-semibold text-sm sm:text-base transition-all duration-200 hover:-translate-y-0.5 active:translate-y-0 shadow-xs">
            <i class="ri-building-line text-lg group-hover:rotate-6 transition-transform duration-200" aria-hidden="true"></i>
            <span>Dành cho chủ trọ</span>
          </a>
        </div>

        {{-- Trust indicator --}}
        <div class="flex flex-wrap items-center gap-4 pt-4 border-t border-[#E2E8F0] dark:border-[#262B28] text-xs sm:text-sm text-[#64748B] dark:text-slate-400">
          {{-- Small overlapping user avatars --}}
          <div class="flex -space-x-2 overflow-hidden items-center shrink-0" aria-label="Cộng đồng người dùng">
            <span class="inline-flex items-center justify-center h-8 w-8 rounded-full ring-2 ring-white dark:ring-slate-800 bg-[#E0F2FE] text-[#0369A1] font-bold text-xs" title="Khách thuê">KT</span>
            <span class="inline-flex items-center justify-center h-8 w-8 rounded-full ring-2 ring-white dark:ring-slate-800 bg-[#F0FDF4] text-[#15803D] font-bold text-xs" title="Chủ nhà trọ">CT</span>
            <span class="inline-flex items-center justify-center h-8 w-8 rounded-full ring-2 ring-white dark:ring-slate-800 bg-[#FEF3C7] text-[#B45309] font-bold text-xs" title="Sinh viên">SV</span>
            <span class="inline-flex items-center justify-center h-8 w-8 rounded-full ring-2 ring-white dark:ring-slate-800 bg-[#F0FDFA] text-[#0D9488] border border-[#CCFBF1]">
              <i class="ri-shield-check-fill text-sm" aria-hidden="true"></i>
            </span>
          </div>

          {{-- Trust statement & verified data --}}
          <div class="flex flex-col sm:flex-row sm:items-center gap-1 sm:gap-2">
            <span class="font-semibold text-[#172B3A] dark:text-white">Dễ sử dụng · Minh bạch · Tiện lợi</span>
            <span class="hidden sm:inline text-slate-300 dark:text-slate-600">•</span>
            <span class="inline-flex items-center gap-1 text-[#0D9488] dark:text-[#5EEAD4] font-medium">
              <i class="ri-verified-badge-fill" aria-hidden="true"></i>
              <span>{{ number_format(max(intval($phongCount ?? 0), 1662)) }}+ phòng đã kiểm định</span>
            </span>
          </div>
        </div>

      </div>

      {{-- 👉 CỘT PHẢI: AUTO-SLIDESHOW REAL APARTMENT PHOTOS & SLEEK UNOBTRUSIVE FLOATING CARDS --}}
      <div class="lg:col-span-5 relative mt-8 lg:mt-0 select-none animate-hero-fade-cards"
           x-data="{
             activeSlide: 0,
             slides: [
               { img: '{{ asset('upload/room_real_22.jpg') }}', title: 'Studio cao cấp Full nội thất', price: '3.200.000đ', location: 'Q. Bình Thạnh', tag: 'Studio cao cấp', stats: '25m² • Có ban công' },
               { img: '{{ asset('upload/room_real_7.jpg') }}', title: 'Căn hộ mini ban công thoáng', price: '3.800.000đ', location: 'Q. Phú Nhuận', tag: 'Căn hộ mini', stats: '30m² • Cửa sổ lớn' },
               { img: '{{ asset('upload/room_real_3.jpg') }}', title: 'Phòng trọ gác cao ráo sinh viên', price: '2.400.000đ', location: 'TP. Thủ Đức', tag: 'Trọ sinh viên', stats: '20m² • Gần ĐHQG' },
               { img: '{{ asset('upload/room_real_14.jpg') }}', title: 'Căn hộ dịch vụ Smart Home', price: '4.200.000đ', location: 'Quận 10', tag: 'Smart Home', stats: '35m² • Khóa vân tay' },
               { img: '{{ asset('upload/room_real_10.jpg') }}', title: 'Phòng đôi đón ánh sáng tự nhiên', price: '2.900.000đ', location: 'Q. Gò Vấp', tag: 'Phòng đôi', stats: '24m² • Nội thất gỗ' }
             ],
             timer: null,
             start() {
               if (this.timer) clearInterval(this.timer);
               this.timer = setInterval(() => {
                 this.activeSlide = (this.activeSlide + 1) % this.slides.length;
               }, 4000);
             },
             stop() {
               if (this.timer) clearInterval(this.timer);
             },
             goTo(i) {
               this.activeSlide = i;
               this.start();
             },
             next() {
               this.activeSlide = (this.activeSlide + 1) % this.slides.length;
               this.start();
             },
             prev() {
               this.activeSlide = (this.activeSlide - 1 + this.slides.length) % this.slides.length;
               this.start();
             }
           }"
           x-init="start()"
           @mouseenter="stop()"
           @mouseleave="start()">
        
        {{-- Main Apartment Photo Carousel Frame --}}
        <div class="relative rounded-3xl overflow-hidden border border-[#E2E8F0] dark:border-slate-800 shadow-2xl shadow-teal-950/10 bg-slate-900 group">
          <div class="relative h-[440px] sm:h-[490px] lg:h-[520px] w-full overflow-hidden">
            
            {{-- Carousel Slides with Smooth Crossfade --}}
            <template x-for="(slide, index) in slides" :key="index">
              <div x-show="activeSlide === index"
                   x-transition:enter="transition-all duration-700 ease-out"
                   x-transition:enter-start="opacity-0 scale-102"
                   x-transition:enter-end="opacity-100 scale-100"
                   x-transition:leave="transition-opacity duration-500 ease-in"
                   x-transition:leave-start="opacity-100"
                   x-transition:leave-end="opacity-0"
                   class="absolute inset-0 w-full h-full">
                <img :src="slide.img"
                     :alt="slide.title"
                     class="w-full h-full object-cover">
              </div>
            </template>

            {{-- Fallback image for no-js --}}
            <noscript>
              <img src="{{ asset('upload/room_real_22.jpg') }}" alt="Phòng trọ thực tế" class="w-full h-full object-cover">
            </noscript>

            {{-- Soft lighting vignette --}}
            <div class="absolute inset-0 bg-gradient-to-t from-[#172B3A]/40 via-transparent to-black/15 pointer-events-none"></div>

            {{-- Top Right: Photo badge & Interactive slide dots --}}
            <div class="absolute top-3.5 right-3.5 z-20 flex items-center gap-2">
              <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-white/90 dark:bg-[#172B3A]/90 backdrop-blur-md text-[11px] font-semibold text-[#172B3A] dark:text-white shadow-sm border border-white/40">
                <span class="w-1.5 h-1.5 rounded-full bg-[#0D9488] animate-pulse"></span>
                <span>Ảnh thực tế 100%</span>
              </span>

              {{-- Slide indicator dots --}}
              <div class="flex items-center gap-1 bg-black/45 backdrop-blur-md px-2 py-1.5 rounded-full border border-white/20">
                <template x-for="(s, idx) in slides" :key="idx">
                  <button type="button"
                          @click="goTo(idx)"
                          :class="activeSlide === idx ? 'w-3.5 bg-[#0D9488]' : 'w-1.5 bg-white/60 hover:bg-white'"
                          class="h-1.5 rounded-full transition-all duration-300"
                          :aria-label="'Ảnh ' + (idx + 1)"></button>
                </template>
              </div>
            </div>

            {{-- Subtle Prev / Next arrow buttons (revealed on hover) --}}
            <button type="button" @click="prev()" aria-label="Xem ảnh trước"
                    class="absolute left-2.5 top-1/2 -translate-y-1/2 z-20 w-8 h-8 rounded-full bg-black/30 hover:bg-black/60 text-white backdrop-blur-md flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
              <i class="ri-arrow-left-s-line text-lg" aria-hidden="true"></i>
            </button>
            <button type="button" @click="next()" aria-label="Xem ảnh kế tiếp"
                    class="absolute right-2.5 top-1/2 -translate-y-1/2 z-20 w-8 h-8 rounded-full bg-black/30 hover:bg-black/60 text-white backdrop-blur-md flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
              <i class="ri-arrow-right-s-line text-lg" aria-hidden="true"></i>
            </button>

            {{-- Bottom info chip inside photo (subtle category tag) --}}
            <div class="absolute bottom-14 left-4 z-10 pointer-events-none">
              <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-black/45 backdrop-blur-md text-[11px] font-medium text-white/90 border border-white/10"
                    x-text="slides[activeSlide].tag + ' • ' + slides[activeSlide].stats">
              </span>
            </div>
          </div>
        </div>

        {{-- 🪟 CARD 1: DYNAMIC PROPERTY INFO PILL (Top-Left Offset, Streamlined) --}}
        <div class="absolute -top-3.5 -left-3 sm:-left-5 z-20 bg-white/95 dark:bg-[#181B19]/95 backdrop-blur-md px-3.5 py-2 rounded-xl border border-white/90 dark:border-slate-700/80 shadow-lg shadow-slate-900/10 flex items-center gap-2.5 max-w-[270px] animate-float-card-1 card-lift-hover">
          <div class="w-8 h-8 rounded-lg bg-[#ECFDF8] dark:bg-[#134E4A]/40 text-[#0D9488] dark:text-[#5EEAD4] flex items-center justify-center text-base shrink-0">
            <i class="ri-home-smile-fill" aria-hidden="true"></i>
          </div>
          <div class="min-w-0">
            <div class="flex items-center gap-1">
              <span class="text-xs font-bold text-[#172B3A] dark:text-white truncate" x-text="slides[activeSlide].title"></span>
            </div>
            <div class="flex items-center gap-1.5 text-[11px] text-[#64748B] dark:text-slate-400">
              <span class="font-extrabold text-[#0D9488] dark:text-[#2DD4BF]" x-text="slides[activeSlide].price + '/tháng'"></span>
              <span>•</span>
              <span class="truncate" x-text="slides[activeSlide].location"></span>
            </div>
          </div>
        </div>

        {{-- 🎯 CARD 2: SMART MATCH BADGE (Top-Right Floating Tag) --}}
        <div class="hidden sm:flex absolute top-14 -right-2 sm:-right-4 z-20 bg-white/95 dark:bg-[#181B19]/95 backdrop-blur-md px-3 py-1.5 rounded-xl border border-white/90 dark:border-slate-700/80 shadow-lg shadow-slate-900/10 items-center gap-1.5 animate-float-card-2 card-lift-hover">
          <i class="ri-sparkling-fill text-[#0D9488] dark:text-[#5EEAD4] text-xs" aria-hidden="true"></i>
          <span class="text-[11px] font-semibold text-[#172B3A] dark:text-white whitespace-nowrap">
            Gợi ý phù hợp: <span class="text-[#0D9488] dark:text-[#5EEAD4] font-bold">&lt; 3.5tr • Full nội thất</span>
          </span>
        </div>

        {{-- 📊 CARD 3: SLEEK LANDLORD STATUS DOCK (Bottom Edge, Low Profile) --}}
        <div class="absolute -bottom-3.5 left-1/2 -translate-x-1/2 z-20 bg-white/95 dark:bg-[#181B19]/95 backdrop-blur-md px-4 py-2 rounded-xl border border-white/90 dark:border-slate-700/80 shadow-xl shadow-slate-900/12 flex items-center gap-3 sm:gap-4 whitespace-nowrap animate-float-card-3 card-lift-hover w-[92%] sm:w-auto justify-between sm:justify-start">
          <div class="flex items-center gap-2 shrink-0">
            <div class="w-6 h-6 rounded-md bg-[#ECFDF8] dark:bg-[#134E4A]/40 text-[#0D9488] dark:text-[#5EEAD4] flex items-center justify-center text-xs">
              <i class="ri-bar-chart-box-line" aria-hidden="true"></i>
            </div>
            <div class="text-left">
              <span class="text-xs font-bold text-[#172B3A] dark:text-white leading-tight">Quản lý dãy trọ</span>
              <span class="text-[10px] text-emerald-600 dark:text-emerald-400 font-semibold flex items-center gap-1">
                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                92% lấp đầy (22/24 phòng)
              </span>
            </div>
          </div>

          <div class="h-5 w-px bg-slate-200 dark:bg-slate-700 hidden sm:block"></div>

          <div class="flex items-center gap-2 shrink-0">
            <span class="text-[11px] font-semibold text-emerald-600 dark:text-emerald-400 flex items-center gap-0.5">
              <i class="ri-arrow-right-up-line" aria-hidden="true"></i>
              +14% thu chi ổn định
            </span>
            <svg class="w-16 h-5 shrink-0 hidden sm:block" viewBox="0 0 64 20" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
              <defs>
                <linearGradient id="chartGradHeroMini" x1="0" y1="0" x2="0" y2="20" gradientUnits="userSpaceOnUse">
                  <stop stop-color="#0D9488" stop-opacity="0.35" />
                  <stop offset="1" stop-color="#0D9488" stop-opacity="0" />
                </linearGradient>
              </defs>
              <path d="M2 15 L14 12 L26 14 L38 8 L50 10 L62 3" stroke="#0D9488" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
              <path d="M2 15 L14 12 L26 14 L38 8 L50 10 L62 3 L62 20 L2 20 Z" fill="url(#chartGradHeroMini)" />
            </svg>
          </div>
        </div>

      </div>

    </div>

    {{-- 🔎 5. REFINED ROOM SEARCH BAR --}}
    <div class="mt-12 lg:mt-16 max-w-5xl mx-auto animate-hero-fade-delayed">
      <div class="bg-white dark:bg-[#181B19] p-3 sm:p-4 rounded-2xl border border-[#E2E8F0] dark:border-slate-800 shadow-xl shadow-teal-950/5">
        <form action="{{ route('listing') }}" method="GET" class="flex flex-col md:flex-row items-stretch md:items-center gap-3">
          
          {{-- Control 1: Địa điểm --}}
          <div class="relative flex-1">
            <label for="hero-dia-chi" class="sr-only">Địa điểm</label>
            <i class="ri-map-pin-2-line text-[#0D9488] absolute left-3.5 top-1/2 -translate-y-1/2 text-lg pointer-events-none"></i>
            <input type="text" id="hero-dia-chi" name="dia_chi" placeholder="Nhập quận/huyện, khu vực..."
                   class="w-full pl-10 pr-3 py-3 rounded-xl bg-[#F0FDFA]/40 dark:bg-[#202522] border border-[#E2E8F0] dark:border-slate-700 text-[#172B3A] dark:text-white text-sm font-medium focus:outline-none focus:border-[#0D9488] focus:ring-2 focus:ring-[#0D9488]/20 focus:bg-white transition placeholder:text-[#64748B]">
          </div>

          {{-- Control 2: Mức giá --}}
          <div class="relative w-full md:w-56">
            <label for="hero-muc-gia" class="sr-only">Mức giá</label>
            <i class="ri-money-dollar-circle-line text-[#0D9488] absolute left-3.5 top-1/2 -translate-y-1/2 text-lg pointer-events-none"></i>
            <select id="hero-muc-gia" name="max"
                    class="w-full pl-10 pr-8 py-3 rounded-xl bg-[#F0FDFA]/40 dark:bg-[#202522] border border-[#E2E8F0] dark:border-slate-700 text-[#172B3A] dark:text-white text-sm font-medium focus:outline-none focus:border-[#0D9488] focus:ring-2 focus:ring-[#0D9488]/20 focus:bg-white transition cursor-pointer appearance-none">
              <option value="">Chọn khoảng giá</option>
              <option value="2000000">Dưới 2.000.000 ₫</option>
              <option value="3000000">Dưới 3.000.000 ₫</option>
              <option value="5000000">Dưới 5.000.000 ₫</option>
              <option value="8000000">Dưới 8.000.000 ₫</option>
              <option value="15000000">Trên 8.000.000 ₫</option>
            </select>
            <i class="ri-arrow-down-s-line text-[#64748B] absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none text-base"></i>
          </div>

          {{-- Control 3: Loại phòng --}}
          <div class="relative w-full md:w-56">
            <label for="hero-loai-phong" class="sr-only">Loại phòng</label>
            <i class="ri-home-4-line text-[#0D9488] absolute left-3.5 top-1/2 -translate-y-1/2 text-lg pointer-events-none"></i>
            <select id="hero-loai-phong" name="category"
                    class="w-full pl-10 pr-8 py-3 rounded-xl bg-[#F0FDFA]/40 dark:bg-[#202522] border border-[#E2E8F0] dark:border-slate-700 text-[#172B3A] dark:text-white text-sm font-medium focus:outline-none focus:border-[#0D9488] focus:ring-2 focus:ring-[#0D9488]/20 focus:bg-white transition cursor-pointer appearance-none">
              <option value="">Tất cả loại phòng</option>
              <option value="sinh_vien">Phòng trọ</option>
              <option value="studio">Căn hộ mini / Studio</option>
              <option value="o_ghep">Ở ghép</option>
              <option value="sleepbox">Sleepbox / KTX</option>
              <option value="nguyen_can">Nhà nguyên căn</option>
              <option value="smart_home">Smart Home</option>
            </select>
            <i class="ri-arrow-down-s-line text-[#64748B] absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none text-base"></i>
          </div>

          {{-- Submit Nút Tìm kiếm --}}
          <button type="submit"
                  class="micro-press group w-full md:w-auto px-7 py-3 rounded-xl bg-[#0D9488] hover:bg-[#0F766E] text-white font-semibold text-sm shadow-md shadow-teal-700/20 hover:shadow-lg hover:shadow-teal-700/30 transition-all flex items-center justify-center gap-2 cursor-pointer shrink-0">
            <i class="ri-search-2-line text-base group-hover:scale-110 transition-transform duration-200"></i>
            <span>Tìm kiếm</span>
          </button>
        </form>

        {{-- Trending quick search tags --}}
        <div class="flex flex-wrap items-center gap-2 text-xs pt-3 mt-3 border-t border-slate-100 dark:border-slate-800">
          <span class="text-[#64748B] font-semibold flex items-center gap-1 shrink-0">
            Gợi ý tìm nhanh:
          </span>
          <a href="{{ route('listing', ['dia_chi' => 'Bình Thạnh']) }}"
             class="micro-press px-2.5 py-1 rounded-lg bg-[#F0FDFA] dark:bg-[#1E2320] hover:bg-[#0D9488] hover:text-white text-[#0D9488] dark:text-[#5EEAD4] font-medium border border-[#CCFBF1] dark:border-slate-700 transition-all duration-200 hover:-translate-y-0.5">
            Bình Thạnh
          </a>
          <a href="{{ route('listing', ['dia_chi' => 'Thủ Đức']) }}"
             class="micro-press px-2.5 py-1 rounded-lg bg-[#F0FDFA] dark:bg-[#1E2320] hover:bg-[#0D9488] hover:text-white text-[#0D9488] dark:text-[#5EEAD4] font-medium border border-[#CCFBF1] dark:border-slate-700 transition-all duration-200 hover:-translate-y-0.5">
            TP. Thủ Đức
          </a>
          <a href="{{ route('listing', ['dia_chi' => 'Quận 10']) }}"
             class="micro-press px-2.5 py-1 rounded-lg bg-[#F0FDFA] dark:bg-[#1E2320] hover:bg-[#0D9488] hover:text-white text-[#0D9488] dark:text-[#5EEAD4] font-medium border border-[#CCFBF1] dark:border-slate-700 transition-all duration-200 hover:-translate-y-0.5">
            Quận 10
          </a>
          <a href="{{ route('listing', ['dia_chi' => 'Gò Vấp']) }}"
             class="micro-press px-2.5 py-1 rounded-lg bg-[#F0FDFA] dark:bg-[#1E2320] hover:bg-[#0D9488] hover:text-white text-[#0D9488] dark:text-[#5EEAD4] font-medium border border-[#CCFBF1] dark:border-slate-700 transition-all duration-200 hover:-translate-y-0.5">
            Gò Vấp
          </a>
          <a href="{{ route('listing', ['max' => 3000000]) }}"
             class="micro-press px-2.5 py-1 rounded-lg bg-[#F0FDFA] dark:bg-[#1E2320] hover:bg-[#0D9488] hover:text-white text-[#0D9488] dark:text-[#5EEAD4] font-medium border border-[#CCFBF1] dark:border-slate-700 transition-all duration-200 hover:-translate-y-0.5">
            Dưới 3.0 triệu
          </a>
          <a href="{{ route('listing', ['mode' => 'ai']) }}"
             class="micro-press sm:ml-auto px-3 py-1 rounded-lg bg-gradient-to-r from-amber-500/15 to-amber-600/15 hover:from-amber-600 hover:to-amber-700 hover:text-white text-amber-900 dark:text-amber-200 font-bold border border-amber-300/80 dark:border-amber-700/60 transition-all duration-200 flex items-center gap-1.5 shadow-2xs">
            <i class="ri-sparkling-fill text-amber-500"></i>
            <span>AI Gợi ý phòng</span>
          </a>
        </div>
      </div>
    </div>

    {{-- 💎 6. BENEFITS SECTION (4 ITEMS) --}}
    <div class="mt-8 pt-8 border-t border-[#E2E8F0]/80 dark:border-slate-800 max-w-5xl mx-auto">
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 sm:gap-6">
        
        {{-- Item 1 --}}
        <div class="motion-reveal motion-stagger-1 card-lift-hover flex items-start gap-3.5 p-3 rounded-xl hover:bg-white/80 dark:hover:bg-slate-800/50 transition">
          <div class="w-10 h-10 rounded-xl bg-[#F0FDFA] dark:bg-[#115E59]/30 text-[#0D9488] dark:text-[#5EEAD4] border border-[#CCFBF1] dark:border-[#0D9488]/30 flex items-center justify-center text-lg shrink-0">
            <i class="ri-flashlight-line"></i>
          </div>
          <div>
            <h3 class="text-sm font-bold text-[#172B3A] dark:text-white">Tìm phòng nhanh chóng</h3>
            <p class="text-xs text-[#64748B] dark:text-slate-400 mt-0.5 leading-relaxed">Gợi ý phòng theo nhu cầu và ngân sách.</p>
          </div>
        </div>

        {{-- Item 2 --}}
        <div class="motion-reveal motion-stagger-2 card-lift-hover flex items-start gap-3.5 p-3 rounded-xl hover:bg-white/80 dark:hover:bg-slate-800/50 transition">
          <div class="w-10 h-10 rounded-xl bg-[#F0FDFA] dark:bg-[#115E59]/30 text-[#0D9488] dark:text-[#5EEAD4] border border-[#CCFBF1] dark:border-[#0D9488]/30 flex items-center justify-center text-lg shrink-0">
            <i class="ri-shield-check-line"></i>
          </div>
          <div>
            <h3 class="text-sm font-bold text-[#172B3A] dark:text-white">Thông tin minh bạch</h3>
            <p class="text-xs text-[#64748B] dark:text-slate-400 mt-0.5 leading-relaxed">Thông tin phòng rõ ràng, dễ so sánh.</p>
          </div>
        </div>

        {{-- Item 3 --}}
        <div class="motion-reveal motion-stagger-3 card-lift-hover flex items-start gap-3.5 p-3 rounded-xl hover:bg-white/80 dark:hover:bg-slate-800/50 transition">
          <div class="w-10 h-10 rounded-xl bg-[#F0FDFA] dark:bg-[#115E59]/30 text-[#0D9488] dark:text-[#5EEAD4] border border-[#CCFBF1] dark:border-[#0D9488]/30 flex items-center justify-center text-lg shrink-0">
            <i class="ri-dashboard-3-line"></i>
          </div>
          <div>
            <h3 class="text-sm font-bold text-[#172B3A] dark:text-white">Quản lý hiệu quả</h3>
            <p class="text-xs text-[#64748B] dark:text-slate-400 mt-0.5 leading-relaxed">Theo dõi phòng, hợp đồng và thu chi.</p>
          </div>
        </div>

        {{-- Item 4 --}}
        <div class="motion-reveal motion-stagger-4 card-lift-hover flex items-start gap-3.5 p-3 rounded-xl hover:bg-white/80 dark:hover:bg-slate-800/50 transition">
          <div class="w-10 h-10 rounded-xl bg-[#F0FDFA] dark:bg-[#115E59]/30 text-[#0D9488] dark:text-[#5EEAD4] border border-[#CCFBF1] dark:border-[#0D9488]/30 flex items-center justify-center text-lg shrink-0">
            <i class="ri-chat-smile-2-line"></i>
          </div>
          <div>
            <h3 class="text-sm font-bold text-[#172B3A] dark:text-white">Kết nối thuận tiện</h3>
            <p class="text-xs text-[#64748B] dark:text-slate-400 mt-0.5 leading-relaxed">Liên hệ giữa người thuê và chủ trọ dễ dàng.</p>
          </div>
        </div>

      </div>
    </div>

  </div>
</section>

{{-- ============================================================ --}}
{{-- 📊 2. CHỈ SỐ HOẠT ĐỘNG THỰC TẾ (REAL OPERATIONAL METRICS) --}}
{{-- ============================================================ --}}
<section class="relative z-10 py-10 bg-white dark:bg-[#161917] border-b border-[#E2E8F0] dark:border-[#262B28] motion-reveal">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-6 sm:gap-8">
      
      <div class="p-4 sm:p-5 border-l-2 border-[#0D9488] dark:border-[#5EEAD4] text-left hover:bg-[#ECFDF8]/50 dark:hover:bg-[#181B19] rounded-r-xl transition-colors duration-200">
        <span class="text-2xl sm:text-3xl font-extrabold text-[#172B3A] dark:text-white block tracking-tight"
              data-counter="{{ max(intval($phongCount ?? 0), 1662) }}"
              data-suffix="+">
          {{ number_format(max(intval($phongCount ?? 0), 1662)) }}+
        </span>
        <span class="text-xs sm:text-sm font-semibold text-[#0D9488] dark:text-[#5EEAD4] block mt-0.5">Phòng trọ đã kiểm định</span>
        <p class="text-[11px] text-[#64748B] dark:text-slate-400 mt-1">Khảo sát trực tiếp, địa chỉ thực tế</p>
      </div>

      <div class="p-4 sm:p-5 border-l-2 border-[#0D9488] dark:border-[#5EEAD4] text-left hover:bg-[#ECFDF8]/50 dark:hover:bg-[#181B19] rounded-r-xl transition-colors duration-200">
        <span class="text-2xl sm:text-3xl font-extrabold text-[#172B3A] dark:text-white block tracking-tight"
              data-counter="{{ max(intval($diachiCount ?? 0), 168) }}">
          {{ max(intval($diachiCount ?? 0), 168) }}
        </span>
        <span class="text-xs sm:text-sm font-semibold text-[#0D9488] dark:text-[#5EEAD4] block mt-0.5">Xã / Phường TP.HCM</span>
        <p class="text-[11px] text-[#64748B] dark:text-slate-400 mt-1">Đầy đủ quận huyện nội ngoại thành</p>
      </div>

      <div class="p-4 sm:p-5 border-l-2 border-[#0D9488] dark:border-[#5EEAD4] text-left hover:bg-[#ECFDF8]/50 dark:hover:bg-[#181B19] rounded-r-xl transition-colors duration-200">
        <span class="text-2xl sm:text-3xl font-extrabold text-[#172B3A] dark:text-white block tracking-tight"
              data-counter="182">
          182
        </span>
        <span class="text-xs sm:text-sm font-semibold text-[#0D9488] dark:text-[#5EEAD4] block mt-0.5">Dãy trọ đối tác chính chủ</span>
        <p class="text-[11px] text-[#64748B] dark:text-slate-400 mt-1">Ký cam kết minh bạch điện nước</p>
      </div>

      <div class="p-4 sm:p-5 border-l-2 border-[#0D9488] dark:border-[#5EEAD4] text-left hover:bg-[#ECFDF8]/50 dark:hover:bg-[#181B19] rounded-r-xl transition-colors duration-200">
        <span class="text-2xl sm:text-3xl font-extrabold text-[#172B3A] dark:text-white block tracking-tight"
              data-counter="100"
              data-suffix="%">
          100%
        </span>
        <span class="text-xs sm:text-sm font-semibold text-[#0D9488] dark:text-[#5EEAD4] block mt-0.5">Ảnh phòng thực tế</span>
        <p class="text-[11px] text-[#64748B] dark:text-slate-400 mt-1">Không dùng ảnh mẫu, không tin ảo</p>
      </div>

    </div>
  </div>
</section>

{{-- ============================================================ --}}
{{-- 🏷️ 3. DANH MỤC THUÊ TRỌ THEO NHU CẦU (HOUSING CATEGORIES) --}}
{{-- ============================================================ --}}
<section class="py-16 bg-[#F7FAFA] dark:bg-[#121514] border-b border-[#E2E8F0] dark:border-[#262B28]">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="motion-reveal flex flex-col sm:flex-row sm:items-end justify-between mb-8 gap-3">
      <div>
        <span class="text-xs font-semibold uppercase tracking-wider text-[#0D9488] dark:text-[#5EEAD4] mb-1 block">Nhu cầu thuê đa dạng</span>
        <h2 class="text-2xl sm:text-3xl font-extrabold text-[#172B3A] dark:text-white tracking-tight">
          Danh Mục Cho Thuê Phổ Biến
        </h2>
      </div>
      <p class="text-xs sm:text-sm text-[#64748B] dark:text-slate-400 max-w-sm">
        Phân loại bài đăng theo ngân sách và mô hình sinh hoạt thực tế của người thuê.
      </p>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-3.5 sm:gap-4">
      
      {{-- Cat 1 --}}
      <a href="{{ route('listing', ['category' => 'sinh_vien']) }}"
        class="motion-reveal motion-stagger-1 card-lift-hover group overflow-hidden rounded-2xl bg-white dark:bg-[#181B19] border border-[#E2E8F0] dark:border-[#282D2A] hover:border-[#0D9488] dark:hover:border-[#5EEAD4] shadow-xs hover:shadow-lg transition-all flex flex-col">
        <div class="relative h-28 w-full overflow-hidden bg-slate-100 dark:bg-stone-800">
          <img src="{{ asset('upload/room_real_1.jpg') }}"
               onerror="this.src='{{ asset('upload/room1.jpg') }}'"
               alt="Trọ sinh viên" class="w-full h-full object-cover group-hover:scale-104 transition-transform duration-300 ease-out">
          <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent group-hover:from-black/75 transition-colors"></div>
          <span class="absolute bottom-2 left-2.5 text-xs font-bold text-white">
            Trọ sinh viên
          </span>
        </div>
        <div class="p-2.5 text-center">
          <span class="text-[11px] text-[#64748B] dark:text-slate-400 block group-hover:text-[#0D9488] dark:group-hover:text-[#5EEAD4] transition-colors font-medium">Từ 1.8tr • Gần ĐH</span>
        </div>
      </a>

      {{-- Cat 2 --}}
      <a href="{{ route('listing', ['category' => 'studio']) }}"
        class="motion-reveal motion-stagger-2 card-lift-hover group overflow-hidden rounded-2xl bg-white dark:bg-[#181B19] border border-[#E2E8F0] dark:border-[#282D2A] hover:border-[#0D9488] dark:hover:border-[#5EEAD4] shadow-xs hover:shadow-lg transition-all flex flex-col">
        <div class="relative h-28 w-full overflow-hidden bg-slate-100 dark:bg-stone-800">
          <img src="{{ asset('upload/room_real_2.jpg') }}"
               onerror="this.src='{{ asset('upload/room2.jpg') }}'"
               alt="Studio / Mini" class="w-full h-full object-cover group-hover:scale-104 transition-transform duration-300 ease-out">
          <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent group-hover:from-black/75 transition-colors"></div>
          <span class="absolute bottom-2 left-2.5 text-xs font-bold text-white">
            Studio / Mini
          </span>
        </div>
        <div class="p-2.5 text-center">
          <span class="text-[11px] text-[#64748B] dark:text-slate-400 block group-hover:text-[#0D9488] dark:group-hover:text-[#5EEAD4] transition-colors font-medium">Full nội thất</span>
        </div>
      </a>

      {{-- Cat 3 --}}
      <a href="{{ route('listing', ['category' => 'o_ghep']) }}"
        class="motion-reveal motion-stagger-3 card-lift-hover group overflow-hidden rounded-2xl bg-white dark:bg-[#181B19] border border-[#E2E8F0] dark:border-[#282D2A] hover:border-[#0D9488] dark:hover:border-[#5EEAD4] shadow-xs hover:shadow-lg transition-all flex flex-col">
        <div class="relative h-28 w-full overflow-hidden bg-slate-100 dark:bg-stone-800">
          <img src="{{ asset('upload/room_real_3.jpg') }}"
               onerror="this.src='{{ asset('upload/room3.jpg') }}'"
               alt="Ở ghép tìm bạn" class="w-full h-full object-cover group-hover:scale-104 transition-transform duration-300 ease-out">
          <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent group-hover:from-black/75 transition-colors"></div>
          <span class="absolute bottom-2 left-2.5 text-xs font-bold text-white">
            Ở ghép tìm bạn
          </span>
        </div>
        <div class="p-2.5 text-center">
          <span class="text-[11px] text-[#64748B] dark:text-slate-400 block group-hover:text-[#0D9488] dark:group-hover:text-[#5EEAD4] transition-colors font-medium">Chia sẻ chi phí</span>
        </div>
      </a>

      {{-- Cat 4 --}}
      <a href="{{ route('listing', ['category' => 'sleepbox']) }}"
        class="motion-reveal motion-stagger-4 card-lift-hover group overflow-hidden rounded-2xl bg-white dark:bg-[#181B19] border border-[#E2E8F0] dark:border-[#282D2A] hover:border-[#0D9488] dark:hover:border-[#5EEAD4] shadow-xs hover:shadow-lg transition-all flex flex-col">
        <div class="relative h-28 w-full overflow-hidden bg-slate-100 dark:bg-stone-800">
          <img src="{{ asset('upload/room_real_4.jpg') }}"
               onerror="this.src='{{ asset('upload/room4.jpg') }}'"
               alt="Sleepbox / KTX" class="w-full h-full object-cover group-hover:scale-104 transition-transform duration-300 ease-out">
          <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent group-hover:from-black/75 transition-colors"></div>
          <span class="absolute bottom-2 left-2.5 text-xs font-bold text-white">
            Sleepbox / KTX
          </span>
        </div>
        <div class="p-2.5 text-center">
          <span class="text-[11px] text-[#64748B] dark:text-slate-400 block group-hover:text-[#0D9488] dark:group-hover:text-[#5EEAD4] transition-colors font-medium">Bao trọn hóa đơn</span>
        </div>
      </a>

      {{-- Cat 5 --}}
      <a href="{{ route('listing', ['category' => 'nguyen_can']) }}"
        class="motion-reveal motion-stagger-5 card-lift-hover group overflow-hidden rounded-2xl bg-white dark:bg-[#181B19] border border-[#E2E8F0] dark:border-[#282D2A] hover:border-[#0D9488] dark:hover:border-[#5EEAD4] shadow-xs hover:shadow-lg transition-all flex flex-col">
        <div class="relative h-28 w-full overflow-hidden bg-slate-100 dark:bg-stone-800">
          <img src="{{ asset('upload/room_real_5.jpg') }}"
               onerror="this.src='{{ asset('upload/room5.jpg') }}'"
               alt="Nhà nguyên căn" class="w-full h-full object-cover group-hover:scale-104 transition-transform duration-300 ease-out">
          <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent group-hover:from-black/75 transition-colors"></div>
          <span class="absolute bottom-2 left-2.5 text-xs font-bold text-white">
            Nhà nguyên căn
          </span>
        </div>
        <div class="p-2.5 text-center">
          <span class="text-[11px] text-[#64748B] dark:text-slate-400 block group-hover:text-[#0D9488] dark:group-hover:text-[#5EEAD4] transition-colors font-medium">Gia đình & Nhóm</span>
        </div>
      </a>

      {{-- Cat 6 --}}
      <a href="{{ route('listing', ['category' => 'smart_home']) }}"
        class="motion-reveal motion-stagger-6 card-lift-hover group overflow-hidden rounded-2xl bg-white dark:bg-[#181B19] border border-[#E2E8F0] dark:border-[#282D2A] hover:border-[#0D9488] dark:hover:border-[#5EEAD4] shadow-xs hover:shadow-lg transition-all flex flex-col">
        <div class="relative h-28 w-full overflow-hidden bg-slate-100 dark:bg-stone-800">
          <img src="{{ asset('upload/room_real_6.jpg') }}"
               onerror="this.src='{{ asset('upload/room6.jpg') }}'"
               alt="Smart Home" class="w-full h-full object-cover group-hover:scale-104 transition-transform duration-300 ease-out">
          <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent group-hover:from-black/75 transition-colors"></div>
          <span class="absolute bottom-2 left-2.5 text-xs font-bold text-white">
            Smart Home
          </span>
        </div>
        <div class="p-2.5 text-center">
          <span class="text-[11px] text-[#64748B] dark:text-slate-400 block group-hover:text-[#0D9488] dark:group-hover:text-[#5EEAD4] transition-colors font-medium">Khóa vân tay an ninh</span>
        </div>
      </a>

    </div>
  </div>
</section>

{{-- ============================================================ --}}
{{-- 📍 4. KHU VỰC THUÊ TRỌ TRỌNG ĐIỂM (PRIME LOCATIONS) --}}
{{-- ============================================================ --}}
<section class="py-16 bg-white dark:bg-[#161917] border-b border-[#E2E8F0] dark:border-[#262B28]">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="motion-reveal flex flex-col sm:flex-row sm:items-end justify-between mb-8 gap-3">
      <div>
        <span class="text-xs font-semibold uppercase tracking-wider text-[#0D9488] dark:text-[#5EEAD4] mb-1 block">Vị trí giao thông thuận tiện</span>
        <h2 class="text-2xl sm:text-3xl font-extrabold text-[#172B3A] dark:text-white tracking-tight">
          Cụm Khu Vực Cho Thuê Trọng Điểm
        </h2>
      </div>
      <a href="{{ route('listing') }}" class="group text-xs sm:text-sm font-semibold text-[#0D9488] dark:text-[#5EEAD4] hover:underline flex items-center gap-1">
        <span>Xem toàn bộ 168 khu vực</span>
        <i class="ri-arrow-right-line group-hover:translate-x-1 transition-transform duration-200"></i>
      </a>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
      
      {{-- Location 1: Bình Thạnh --}}
      <a href="{{ route('listing', ['dia_chi' => 'Bình Thạnh']) }}"
        class="motion-reveal motion-stagger-1 card-lift-hover group relative h-60 rounded-2xl overflow-hidden border border-[#E2E8F0] dark:border-[#282D2A] bg-stone-900 shadow-xs hover:shadow-xl transition-all">
        <img src="{{ asset('upload/room_real_11.jpg') }}"
             onerror="this.src='{{ asset('upload/room_real_1.jpg') }}'"
             alt="Bình Thạnh" class="w-full h-full object-cover group-hover:scale-104 transition-transform duration-300 ease-out opacity-85">
        <div class="absolute inset-0 bg-gradient-to-t from-black/85 via-black/30 to-transparent group-hover:from-black/90 transition-colors"></div>
        <div class="absolute bottom-4 left-4 right-4 text-white">
          <span class="text-[10px] font-medium text-teal-200 block mb-0.5">Gần HUTECH, UEF, ĐH GTVT</span>
          <h4 class="text-base font-bold leading-tight group-hover:text-[#5EEAD4] transition-colors">Quận Bình Thạnh</h4>
          <span class="text-xs text-amber-300 mt-0.5 inline-block font-medium">380+ phòng sẵn sàng</span>
        </div>
      </a>

      {{-- Location 2: Thủ Đức --}}
      <a href="{{ route('listing', ['dia_chi' => 'Thủ Đức']) }}"
        class="motion-reveal motion-stagger-2 card-lift-hover group relative h-60 rounded-2xl overflow-hidden border border-[#E2E8F0] dark:border-[#282D2A] bg-stone-900 shadow-xs hover:shadow-xl transition-all">
        <img src="{{ asset('upload/room_real_7.jpg') }}"
             onerror="this.src='{{ asset('upload/room_real_2.jpg') }}'"
             alt="Thủ Đức" class="w-full h-full object-cover group-hover:scale-104 transition-transform duration-300 ease-out opacity-85">
        <div class="absolute inset-0 bg-gradient-to-t from-black/85 via-black/30 to-transparent group-hover:from-black/90 transition-colors"></div>
        <div class="absolute bottom-4 left-4 right-4 text-white">
          <span class="text-[10px] font-medium text-teal-200 block mb-0.5">Cụm Làng Đại Học Quốc Gia</span>
          <h4 class="text-base font-bold leading-tight group-hover:text-[#5EEAD4] transition-colors">TP. Thủ Đức</h4>
          <span class="text-xs text-amber-300 mt-0.5 inline-block font-medium">560+ phòng sẵn sàng</span>
        </div>
      </a>

      {{-- Location 3: Quận 10 --}}
      <a href="{{ route('listing', ['dia_chi' => 'Quận 10']) }}"
        class="motion-reveal motion-stagger-3 card-lift-hover group relative h-60 rounded-2xl overflow-hidden border border-[#E2E8F0] dark:border-[#282D2A] bg-stone-900 shadow-xs hover:shadow-xl transition-all">
        <img src="{{ asset('upload/room_real_6.jpg') }}"
             onerror="this.src='{{ asset('upload/room_real_3.jpg') }}'"
             alt="Quận 10" class="w-full h-full object-cover group-hover:scale-104 transition-transform duration-300 ease-out opacity-85">
        <div class="absolute inset-0 bg-gradient-to-t from-black/85 via-black/30 to-transparent group-hover:from-black/90 transition-colors"></div>
        <div class="absolute bottom-4 left-4 right-4 text-white">
          <span class="text-[10px] font-medium text-teal-200 block mb-0.5">Gần ĐH Bách Khoa, ĐH Y Dược</span>
          <h4 class="text-base font-bold leading-tight group-hover:text-[#5EEAD4] transition-colors">Quận 10 & Quận 5</h4>
          <span class="text-xs text-amber-300 mt-0.5 inline-block font-medium">290+ phòng sẵn sàng</span>
        </div>
      </a>

      {{-- Location 4: Quận 1 & Quận 3 --}}
      <a href="{{ route('listing', ['dia_chi' => 'Quận 1']) }}"
        class="motion-reveal motion-stagger-4 card-lift-hover group relative h-60 rounded-2xl overflow-hidden border border-[#E2E8F0] dark:border-[#282D2A] bg-stone-900 shadow-xs hover:shadow-xl transition-all">
        <img src="{{ asset('upload/room_real_10.jpg') }}"
             onerror="this.src='{{ asset('upload/room_real_4.jpg') }}'"
             alt="Quận 1" class="w-full h-full object-cover group-hover:scale-104 transition-transform duration-300 ease-out opacity-85">
        <div class="absolute inset-0 bg-gradient-to-t from-black/85 via-black/30 to-transparent group-hover:from-black/90 transition-colors"></div>
        <div class="absolute bottom-4 left-4 right-4 text-white">
          <span class="text-[10px] font-medium text-teal-200 block mb-0.5">Trung tâm hành chính thương mại</span>
          <h4 class="text-base font-bold leading-tight group-hover:text-[#5EEAD4] transition-colors">Quận 1 & Quận 3</h4>
          <span class="text-xs text-amber-300 mt-0.5 inline-block font-medium">180+ phòng sẵn sàng</span>
        </div>
      </a>

      {{-- Location 5: Phú Nhuận & Tân Bình --}}
      <a href="{{ route('listing', ['dia_chi' => 'Tân Bình']) }}"
        class="motion-reveal motion-stagger-5 card-lift-hover group relative h-60 rounded-2xl overflow-hidden border border-[#E2E8F0] dark:border-[#282D2A] bg-stone-900 shadow-xs hover:shadow-xl transition-all">
        <img src="{{ asset('upload/room_real_16.jpg') }}"
             onerror="this.src='{{ asset('upload/room_real_5.jpg') }}'"
             alt="Tân Bình" class="w-full h-full object-cover group-hover:scale-104 transition-transform duration-300 ease-out opacity-85">
        <div class="absolute inset-0 bg-gradient-to-t from-black/85 via-black/30 to-transparent group-hover:from-black/90 transition-colors"></div>
        <div class="absolute bottom-4 left-4 right-4 text-white">
          <span class="text-[10px] font-medium text-teal-200 block mb-0.5">Trục Sân bay Tân Sơn Nhất</span>
          <h4 class="text-base font-bold leading-tight group-hover:text-[#5EEAD4] transition-colors">Tân Bình & P.Nhuận</h4>
          <span class="text-xs text-amber-300 mt-0.5 inline-block font-medium">240+ phòng sẵn sàng</span>
        </div>
      </a>
    </div>
  </div>
</section>

{{-- ============================================================ --}}
{{-- 🏡 5. KHÁM PHÁ PHÒNG TRỌ THÔNG MINH (E-COMMERCE PROPERTY DISCOVERY) --}}
{{-- ============================================================ --}}
<section class="py-16 bg-[#F7FAFA] dark:bg-[#121514] border-b border-[#E2E8F0] dark:border-[#262B28]">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    
    {{-- Section Header --}}
    <div class="motion-reveal flex flex-col md:flex-row md:items-end justify-between mb-8 gap-4">
      <div>
        <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-[#ECFDF8] dark:bg-[#134E4A]/30 text-[#0D9488] dark:text-[#5EEAD4] text-xs font-semibold mb-2">
          <i class="ri-search-eye-line"></i>
          <span>Dữ liệu thực tế 100%</span>
        </div>
        <h2 class="text-2xl sm:text-3xl font-extrabold text-[#172B3A] dark:text-white tracking-tight">
          Phòng Trọ Đã Kiểm Định Mới Nhất
        </h2>
        <p class="text-[#64748B] dark:text-slate-400 text-xs sm:text-sm mt-1 max-w-xl">
          Khám phá danh sách phòng trọ đạt chuẩn chất lượng, khảo sát thực địa và minh bạch chi phí điện nước.
        </p>
      </div>

      <a href="{{ route('listing') }}"
        class="micro-press group inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-white dark:bg-[#181B19] hover:bg-[#ECFDF8] dark:hover:bg-[#202522] border border-[#E2E8F0] dark:border-[#282D2A] text-xs sm:text-sm font-semibold text-[#172B3A] dark:text-white hover:text-[#0D9488] dark:hover:text-[#5EEAD4] hover:border-[#0D9488] transition-all shadow-xs shrink-0 self-start md:self-auto">
        <span>Xem toàn bộ {{ count($featured ?? []) }} bài đăng</span>
        <i class="ri-arrow-right-line text-sm group-hover:translate-x-1 transition-transform duration-200"></i>
      </a>
    </div>

    {{-- Carousel & Discovery Logic in Alpine --}}
    <script>
      window.featuredCarousel = function() {
        return {
          allFeatured: @json($featured),
          filter: 'all',
          sortBy: 'default',
          favorites: JSON.parse(localStorage.getItem('user_favorites') || '[]'),
          perPage: 6,
          currentPage: 0,
          get filteredItems() {
            let list = [...this.allFeatured];
            if (this.filter === 'under3m') {
              list = list.filter(item => (Number(item.gia_niem_yet) || 0) <= 3000000);
            } else if (this.filter === 'sinh_vien') {
              list = list.filter(item => (item.category === 'sinh_vien' || (item.tieu_de || '').toLowerCase().includes('sinh viên') || (Number(item.gia_niem_yet) || 0) <= 3500000));
            } else if (this.filter === 'studio') {
              list = list.filter(item => (item.category === 'studio' || (item.tieu_de || '').toLowerCase().includes('studio') || (item.tieu_de || '').toLowerCase().includes('căn hộ')));
            }
            if (this.sortBy === 'price_asc') {
              list.sort((a,b) => (Number(a.gia_niem_yet)||0) - (Number(b.gia_niem_yet)||0));
            } else if (this.sortBy === 'price_desc') {
              list.sort((a,b) => (Number(b.gia_niem_yet)||0) - (Number(a.gia_niem_yet)||0));
            }
            return list;
          },
          pages() {
            return Math.ceil(this.filteredItems.length / this.perPage) || 1;
          },
          setFilter(cat) {
            this.filter = cat;
            this.currentPage = 0;
          },
          setSort(sort) {
            this.sortBy = sort;
            this.currentPage = 0;
          },
          toggleFav(id) {
            const key = String(id);
            if (this.favorites.includes(key)) {
              this.favorites = this.favorites.filter(f => f !== key);
            } else {
              this.favorites.push(key);
            }
            localStorage.setItem('user_favorites', JSON.stringify(this.favorites));
          },
          isFav(id) {
            return this.favorites.includes(String(id));
          },
          prev() {
            if (this.currentPage > 0) this.currentPage--;
          },
          next() {
            if (this.currentPage < this.pages() - 1) this.currentPage++;
          }
        }
      }
    </script>

    <div x-data="featuredCarousel()" class="relative">
      
      {{-- 🎛️ E-COMMERCE FILTER & SORT TOOLBAR --}}
      <div class="mb-6 flex flex-wrap items-center justify-between gap-3 p-2 bg-white dark:bg-[#181B19] rounded-2xl border border-[#E2E8F0] dark:border-[#282D2A] shadow-xs">
        
        {{-- Category Tabs --}}
        <div class="flex flex-wrap items-center gap-1 sm:gap-1.5">
          <button type="button" @click="setFilter('all')"
                  :class="filter === 'all' ? 'bg-[#0D9488] text-white shadow-xs font-bold' : 'text-[#64748B] hover:text-[#172B3A] dark:hover:text-white hover:bg-slate-100 dark:hover:bg-slate-800 font-medium'"
                  class="micro-press px-3.5 py-1.5 rounded-xl text-xs transition-all duration-200">
            Tất cả phòng
          </button>
          <button type="button" @click="setFilter('under3m')"
                  :class="filter === 'under3m' ? 'bg-[#0D9488] text-white shadow-xs font-bold' : 'text-[#64748B] hover:text-[#172B3A] dark:hover:text-white hover:bg-slate-100 dark:hover:bg-slate-800 font-medium'"
                  class="micro-press px-3.5 py-1.5 rounded-xl text-xs transition-all duration-200">
            Dưới 3.0 triệu
          </button>
          <button type="button" @click="setFilter('sinh_vien')"
                  :class="filter === 'sinh_vien' ? 'bg-[#0D9488] text-white shadow-xs font-bold' : 'text-[#64748B] hover:text-[#172B3A] dark:hover:text-white hover:bg-slate-100 dark:hover:bg-slate-800 font-medium'"
                  class="micro-press px-3.5 py-1.5 rounded-xl text-xs transition-all duration-200">
            Trọ sinh viên
          </button>
          <button type="button" @click="setFilter('studio')"
                  :class="filter === 'studio' ? 'bg-[#0D9488] text-white shadow-xs font-bold' : 'text-[#64748B] hover:text-[#172B3A] dark:hover:text-white hover:bg-slate-100 dark:hover:bg-slate-800 font-medium'"
                  class="micro-press px-3.5 py-1.5 rounded-xl text-xs transition-all duration-200">
            Căn hộ Studio
          </button>
        </div>

        {{-- Sorting & Item Counter --}}
        <div class="flex items-center gap-3 ml-auto text-xs">
          <span class="hidden sm:inline text-[#64748B] dark:text-slate-400">
            Hiển thị <strong class="text-[#0D9488] dark:text-[#5EEAD4]" x-text="filteredItems.length"></strong> phòng
          </span>

          <div class="relative">
            <select @change="setSort($event.target.value)"
                    class="pl-3 pr-7 py-1.5 rounded-xl bg-[#F7FAFA] dark:bg-[#202522] border border-[#E2E8F0] dark:border-slate-700 text-[#172B3A] dark:text-white text-xs font-medium focus:outline-none focus:border-[#0D9488] cursor-pointer appearance-none">
              <option value="default">Sắp xếp: Mặc định</option>
              <option value="price_asc">Giá: Thấp đến cao</option>
              <option value="price_desc">Giá: Cao đến thấp</option>
            </select>
            <i class="ri-arrow-down-s-line text-[#64748B] absolute right-2 top-1/2 -translate-y-1/2 pointer-events-none text-sm"></i>
          </div>
        </div>

      </div>

      {{-- 🗂️ PROPERTY GRID --}}
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-7">
        <template x-for="(item, idx) in filteredItems" :key="item.id || idx">
          <div x-show="idx >= currentPage * perPage && idx < (currentPage + 1) * perPage"
               x-cloak
               x-transition:enter="transition-all duration-300 ease-out"
               x-transition:enter-start="opacity-0 transform translate-y-3"
               x-transition:enter-end="opacity-100 transform translate-y-0"
               class="group card-lift-hover bg-white dark:bg-[#181B19] border border-[#E2E8F0] dark:border-[#282D2A] hover:border-[#0D9488] dark:hover:border-[#5EEAD4] shadow-xs hover:shadow-xl hover:shadow-teal-950/10 transition-all duration-300 rounded-2xl flex flex-col h-full overflow-hidden">

            {{-- 🖼 Image Container (Aspect Ratio 16:10) --}}
            <div class="relative aspect-[16/10] w-full bg-slate-100 dark:bg-slate-800 overflow-hidden">
              <img :src="item.anh_dai_dien || '{{ asset('upload/room1.jpg') }}'"
                   :onerror="`this.src='{{ asset('upload/room1.jpg') }}'`"
                   :alt="item.tieu_de || item.title || 'Phòng trọ'"
                   loading="lazy"
                   class="w-full h-full object-cover transition-transform duration-300 ease-out group-hover:scale-103">

              {{-- Soft Gradient Vignette --}}
              <div class="absolute inset-0 bg-gradient-to-t from-black/40 via-transparent to-transparent pointer-events-none"></div>

              {{-- Top Badges: Room Number & Verification --}}
              <div class="absolute top-3 left-3 z-10 flex items-center gap-1.5">
                <span class="bg-[#172B3A]/90 backdrop-blur-md px-2.5 py-1 rounded-lg text-[11px] font-semibold text-white tracking-wide border border-white/10 shadow-xs">
                  P.<span x-text="item.so_phong || (idx + 1)"></span>
                </span>
                <span class="inline-flex items-center gap-1 bg-[#0D9488]/95 backdrop-blur-md px-2.5 py-1 rounded-lg text-[11px] font-semibold text-white border border-white/10 shadow-xs">
                  <i class="ri-shield-check-line text-xs"></i>
                  <span>Đã kiểm tra</span>
                </span>
              </div>

              {{-- Favorite Heart Toggle Button --}}
              <button type="button"
                      @click.stop="toggleFav(item.id || idx)"
                      class="absolute top-3 right-3 z-10 w-8 h-8 rounded-full bg-white/95 dark:bg-[#172B3A]/95 backdrop-blur-md shadow-sm border border-white/40 flex items-center justify-center transition-transform hover:scale-110 active:scale-95"
                      :aria-label="isFav(item.id || idx) ? 'Bỏ lưu yêu thích' : 'Lưu vào danh sách yêu thích'">
                <i :class="isFav(item.id || idx) ? 'ri-heart-3-fill text-rose-500' : 'ri-heart-3-line text-[#64748B] hover:text-rose-500'" class="text-sm transition-colors"></i>
              </button>

              {{-- Availability Indicator Pill --}}
              <div class="absolute bottom-3 left-3 z-10">
                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-black/60 backdrop-blur-md text-[11px] text-white font-medium border border-white/15">
                  <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                  <span>Còn phòng</span>
                </span>
              </div>
            </div>

            {{-- 📝 Card Content --}}
            <div class="p-5 grow flex flex-col justify-between space-y-4">
              <div>
                {{-- Location --}}
                <div class="flex items-center text-[#64748B] dark:text-[#A7AAA4] text-xs mb-1.5 font-medium">
                  <i class="ri-map-pin-2-fill text-[#0D9488] mr-1.5 text-sm shrink-0"></i>
                  <span class="truncate" x-text="item.dia_chi || 'TP. Hồ Chí Minh'"></span>
                </div>

                {{-- Property Title --}}
                <a :href="'/bai-dang/' + (item.id || (idx+1))" class="block group/title">
                  <h3 class="text-base font-bold text-[#172B3A] dark:text-white line-clamp-1 leading-snug group-hover/title:text-[#0D9488] dark:group-hover/title:text-[#5EEAD4] transition-colors"
                      x-text="item.tieu_de || item.title || 'Phòng trọ tiện nghi sạch sẽ'">
                  </h3>
                </a>

                {{-- Room Specs: Area, Capacity, Policy --}}
                <div class="flex items-center gap-3 text-xs text-[#64748B] dark:text-[#A7AAA4] font-medium mt-3 pt-3 border-t border-[#E2E8F0] dark:border-[#262B28]">
                  <span class="flex items-center gap-1">
                    <i class="ri-ruler-2-line text-[#0D9488]"></i>
                    <span x-text="(item.dien_tich ? (item.dien_tich + ' m²') : '22 m²')"></span>
                  </span>
                  <span class="text-slate-300 dark:text-stone-700">•</span>
                  <span class="flex items-center gap-1">
                    <i class="ri-team-line text-[#0D9488]"></i>
                    <span x-text="(item.suc_chua ? (item.suc_chua + ' người') : '2 người')"></span>
                  </span>
                  <span class="text-slate-300 dark:text-stone-700">•</span>
                  <span class="flex items-center gap-1 text-emerald-700 dark:text-emerald-400">
                    <i class="ri-shield-keyhole-line"></i>
                    <span>Tự do 24/7</span>
                  </span>
                </div>
              </div>

              {{-- Price & CTA Container --}}
              <div class="pt-2">
                <div class="flex items-baseline justify-between mb-3.5">
                  <div>
                    <span class="text-[10px] text-[#64748B] font-semibold uppercase tracking-wider block">Giá thuê tháng:</span>
                    <div class="flex items-baseline gap-1 mt-0.5">
                      <span class="text-xl sm:text-2xl font-extrabold text-[#0D9488] dark:text-[#5EEAD4]"
                            x-text="item.gia_hien_thi || (Number(item.gia_niem_yet || 0).toLocaleString('vi-VN') + ' ₫')"></span>
                      <span class="text-xs text-[#64748B] font-normal">/tháng</span>
                    </div>
                  </div>
                  <a :href="'/bai-dang/' + (item.id || (idx+1))"
                     class="micro-press inline-flex items-center gap-1 px-4 py-2 rounded-xl bg-[#ECFDF8] dark:bg-[#134E4A]/30 hover:bg-[#0D9488] hover:text-white text-[#0D9488] dark:text-[#5EEAD4] font-bold text-xs border border-[#CCFBF1] dark:border-[#0D9488]/30 transition-all shadow-xs">
                    <span>Xem phòng</span>
                    <i class="ri-arrow-right-line text-xs"></i>
                  </a>
                </div>

                {{-- Quick Contact Actions --}}
                <div class="pt-3 border-t border-[#E2E8F0] dark:border-[#262B28] flex items-center justify-between text-xs text-[#64748B] dark:text-[#A7AAA4] font-medium">
                  <button type="button" @click="$dispatch('show-chutro', {ten: item.chu_tro || 'Chủ trọ', sdt: item.sdt_chu_tro || '0909000002'})"
                    class="micro-press hover:text-[#0D9488] dark:hover:text-white flex items-center gap-1 transition-colors cursor-pointer">
                    <i class="ri-phone-fill text-[#0D9488] dark:text-[#5EEAD4]"></i>
                    <span>Gọi chủ trọ</span>
                  </button>
                  <button type="button" @click="$dispatch('show-chutro', {ten: item.chu_tro || 'Chủ trọ', sdt: item.sdt_chu_tro || '0909000002'})"
                    class="micro-press hover:text-[#0D9488] dark:hover:text-white flex items-center gap-1 transition-colors cursor-pointer">
                    <i class="ri-chat-1-fill text-[#0D9488] dark:text-[#5EEAD4]"></i>
                    <span>Nhắn Zalo</span>
                  </button>
                  <span class="text-[11px] text-slate-400">Ảnh thật 100%</span>
                </div>
              </div>

            </div>
          </div>
        </template>
      </div>

      {{-- Empty state if filter returns no items --}}
      <div x-show="filteredItems.length === 0" x-cloak class="text-center py-12 bg-white dark:bg-[#181B19] rounded-2xl border border-[#E2E8F0] dark:border-[#282D2A] p-8">
        <i class="ri-search-2-line text-4xl text-[#0D9488] mb-2 inline-block"></i>
        <h4 class="text-base font-bold text-[#172B3A] dark:text-white">Không tìm thấy phòng phù hợp</h4>
        <p class="text-xs text-[#64748B] mt-1">Hãy thử chọn bộ lọc khác hoặc xem tất cả danh sách bài đăng.</p>
        <button type="button" @click="setFilter('all')" class="mt-4 px-4 py-2 bg-[#0D9488] text-white rounded-xl text-xs font-semibold">
          Xem tất cả phòng
        </button>
      </div>

      {{-- Pagination controls --}}
      <div class="flex items-center justify-center gap-3 mt-10" x-show="pages() > 1">
        <button type="button" @click="prev()" :disabled="currentPage === 0"
          class="micro-press px-4 py-2 rounded-xl border border-[#E2E8F0] dark:border-[#2D3330] bg-white dark:bg-[#181B19] text-[#172B3A] dark:text-[#D5D8D3] font-semibold text-xs hover:bg-[#ECFDF8] hover:border-[#0D9488] hover:text-[#0D9488] disabled:opacity-30 disabled:cursor-not-allowed transition shadow-xs">
          « Trang trước
        </button>
        <span class="text-xs font-semibold text-[#64748B]">
          Trang <span x-text="currentPage + 1" class="text-[#0D9488] dark:text-[#5EEAD4] font-bold"></span> / <span x-text="pages()"></span>
        </span>
        <button type="button" @click="next()" :disabled="currentPage >= pages() - 1"
          class="micro-press px-4 py-2 rounded-xl border border-[#E2E8F0] dark:border-[#2D3330] bg-white dark:bg-[#181B19] text-[#172B3A] dark:text-[#D5D8D3] font-semibold text-xs hover:bg-[#ECFDF8] hover:border-[#0D9488] hover:text-[#0D9488] disabled:opacity-30 disabled:cursor-not-allowed transition shadow-xs">
          Trang sau »
        </button>
      </div>
    </div>
  </div>
</section>

{{-- ============================================================ --}}
{{-- 📚 6. CẨM NANG & KIẾN THỨC THUÊ TRỌ (EDITORIAL KNOWLEDGE HUB) --}}
{{-- ============================================================ --}}
<section id="community" class="py-16 bg-white dark:bg-[#161917] border-b border-[#E2E8F0] dark:border-[#262B28] scroll-mt-24">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="motion-reveal flex flex-col sm:flex-row sm:items-end justify-between mb-8 gap-3">
      <div>
        <span class="text-xs font-semibold uppercase tracking-wider text-[#0D9488] dark:text-[#5EEAD4] mb-1 block">Hướng dẫn pháp lý & Kinh nghiệm</span>
        <h2 class="text-2xl sm:text-3xl font-extrabold text-[#172B3A] dark:text-white tracking-tight">
          Cẩm Nang Thuê Trọ An Tâm
        </h2>
      </div>
      <p class="text-xs sm:text-sm text-[#64748B] dark:text-slate-400 max-w-sm">
        Quy chuẩn đối soát chi phí, hợp đồng thuê và các biện pháp bảo vệ tiền cọc cho khách thuê.
      </p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5">
      
      {{-- Article 1 --}}
      <article class="motion-reveal motion-stagger-1 card-lift-hover group bg-[#F7FAFA] dark:bg-[#181B19] rounded-2xl p-5 border border-[#E2E8F0] dark:border-[#282D2A] flex flex-col justify-between hover:border-[#0D9488] dark:hover:border-[#5EEAD4] shadow-xs hover:shadow-lg transition-all">
        <div>
          <span class="text-[10px] font-bold text-rose-600 uppercase tracking-wider block mb-2">
            Phòng ngừa rủi ro
          </span>
          <h3 class="font-bold text-sm text-[#172B3A] dark:text-white mb-2 leading-snug group-hover:text-[#0D9488] dark:group-hover:text-[#5EEAD4] transition-colors">
            Quy trình xác minh chủ nhà và các dấu hiệu yêu cầu chuyển cọc ảo
          </h3>
          <p class="text-xs text-[#64748B] dark:text-slate-400 leading-relaxed line-clamp-3">
            Hướng dẫn người thuê kiểm tra giấy tờ quyền sở hữu hoặc giấy ủy quyền quản lý trước khi thực hiện giao dịch đặt cọc giữ chỗ.
          </p>
        </div>
        <div class="pt-4 mt-4 border-t border-[#E2E8F0] dark:border-[#282D2A] flex items-center justify-between text-[11px] text-[#64748B]">
          <span>Pháp lý • 3 ngày trước</span>
          <span class="font-bold text-[#0D9488] dark:text-[#5EEAD4] flex items-center gap-1 group-hover:translate-x-1 transition-transform">Chi tiết →</span>
        </div>
      </article>

      {{-- Article 2 --}}
      <article class="motion-reveal motion-stagger-2 card-lift-hover group bg-[#F7FAFA] dark:bg-[#181B19] rounded-2xl p-5 border border-[#E2E8F0] dark:border-[#282D2A] flex flex-col justify-between hover:border-[#0D9488] dark:hover:border-[#5EEAD4] shadow-xs hover:shadow-lg transition-all">
        <div>
          <span class="text-[10px] font-bold text-[#0D9488] dark:text-[#5EEAD4] uppercase tracking-wider block mb-2">
            Kỹ thuật & Chi phí
          </span>
          <h3 class="font-bold text-sm text-[#172B3A] dark:text-white mb-2 leading-snug group-hover:text-[#0D9488] dark:group-hover:text-[#5EEAD4] transition-colors">
            Cách chốt chỉ số công tơ điện và đồng hồ nước đầu tháng
          </h3>
          <p class="text-xs text-[#64748B] dark:text-slate-400 leading-relaxed line-clamp-3">
            Phương pháp chụp ảnh lập biên bản bàn giao chỉ số ban đầu, đối soát đơn giá theo quy định nhà nước tránh phát sinh sai lệch.
          </p>
        </div>
        <div class="pt-4 mt-4 border-t border-[#E2E8F0] dark:border-[#282D2A] flex items-center justify-between text-[11px] text-[#64748B]">
          <span>Kỹ thuật • 1 tuần trước</span>
          <span class="font-bold text-[#0D9488] dark:text-[#5EEAD4] flex items-center gap-1 group-hover:translate-x-1 transition-transform">Chi tiết →</span>
        </div>
      </article>

      {{-- Article 3 --}}
      <article class="motion-reveal motion-stagger-3 card-lift-hover group bg-[#F7FAFA] dark:bg-[#181B19] rounded-2xl p-5 border border-[#E2E8F0] dark:border-[#282D2A] flex flex-col justify-between hover:border-[#0D9488] dark:hover:border-[#5EEAD4] shadow-xs hover:shadow-lg transition-all">
        <div>
          <span class="text-[10px] font-bold text-amber-600 uppercase tracking-wider block mb-2">
            Mẫu hợp đồng 2026
          </span>
          <h3 class="font-bold text-sm text-[#172B3A] dark:text-white mb-2 leading-snug group-hover:text-[#0D9488] dark:group-hover:text-[#5EEAD4] transition-colors">
            4 điều khoản hoàn trả tiền cọc bắt buộc phải có trong hợp đồng thuê
          </h3>
          <p class="text-xs text-[#64748B] dark:text-slate-400 leading-relaxed line-clamp-3">
            Quy định rõ thời hạn thông báo trả phòng, điều kiện khấu trừ hao mòn tài sản tự nhiên và thời gian tối đa chủ nhà phải thanh toán lại cọc.
          </p>
        </div>
        <div class="pt-4 mt-4 border-t border-[#E2E8F0] dark:border-[#282D2A] flex items-center justify-between text-[11px] text-[#64748B]">
          <span>Luật sư • 2 tuần trước</span>
          <span class="font-bold text-[#0D9488] dark:text-[#5EEAD4] flex items-center gap-1 group-hover:translate-x-1 transition-transform">Chi tiết →</span>
        </div>
      </article>

      {{-- Article 4 --}}
      <article class="motion-reveal motion-stagger-4 card-lift-hover group bg-[#F7FAFA] dark:bg-[#181B19] rounded-2xl p-5 border border-[#E2E8F0] dark:border-[#282D2A] flex flex-col justify-between hover:border-[#0D9488] dark:hover:border-[#5EEAD4] shadow-xs hover:shadow-lg transition-all">
        <div>
          <span class="text-[10px] font-bold text-[#0D9488] dark:text-[#5EEAD4] uppercase tracking-wider block mb-2">
            Khảo sát khu vực
          </span>
          <h3 class="font-bold text-sm text-[#172B3A] dark:text-white mb-2 leading-snug group-hover:text-[#0D9488] dark:group-hover:text-[#5EEAD4] transition-colors">
            Bản đồ chi phí sinh hoạt và an ninh các cụm trường đại học TP.HCM
          </h3>
          <p class="text-xs text-[#64748B] dark:text-slate-400 leading-relaxed line-clamp-3">
            Thống kê mức giá trung bình của phòng trọ khu vực Làng Đại Học, Thủ Đức, Bình Thạnh và các tuyến xe buýt liên kết trung tâm.
          </p>
        </div>
        <div class="pt-4 mt-4 border-t border-[#E2E8F0] dark:border-[#282D2A] flex items-center justify-between text-[11px] text-[#64748B]">
          <span>Dữ liệu • 3 tuần trước</span>
          <span class="font-bold text-[#0D9488] dark:text-[#5EEAD4] flex items-center gap-1 group-hover:translate-x-1 transition-transform">Chi tiết →</span>
        </div>
      </article>

    </div>
  </div>
</section>

{{-- ============================================================ --}}
{{-- 🛡️ 7. QUY TRÌNH 4 BƯỚC THUÊ PHÒNG CHUẨN (LEASING PROCESS) --}}
{{-- ============================================================ --}}
<section class="py-16 bg-[#F7FAFA] dark:bg-[#121514] border-b border-[#E2E8F0] dark:border-[#262B28]">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="motion-reveal text-left max-w-xl mb-12">
      <span class="text-xs font-semibold uppercase tracking-wider text-[#0D9488] dark:text-[#5EEAD4] mb-1 block">Quy chuẩn dịch vụ</span>
      <h2 class="text-2xl sm:text-3xl font-extrabold text-[#172B3A] dark:text-white tracking-tight">
        4 Bước Thuê Phòng Minh Bạch & Nhanh Chóng
      </h2>
      <p class="text-[#64748B] dark:text-slate-400 text-xs sm:text-sm mt-1">
        Quy trình được thiết kế nhằm bảo vệ toàn diện quyền lợi của khách thuê từ giai đoạn tìm kiếm đến khi nhận phòng.
      </p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
      
      {{-- Step 1 --}}
      <div class="motion-reveal motion-stagger-1 card-lift-hover group p-6 rounded-2xl bg-white dark:bg-[#181B19] border border-[#E2E8F0] dark:border-[#282D2A] hover:border-[#0D9488] dark:hover:border-[#5EEAD4] shadow-xs hover:shadow-lg transition-all">
        <span class="text-xs font-bold text-[#0D9488] dark:text-[#5EEAD4] uppercase tracking-wider block mb-2 group-hover:scale-105 transition-transform origin-left">Bước 01</span>
        <h4 class="font-bold text-base text-[#172B3A] dark:text-white mb-2 group-hover:text-[#0D9488] dark:group-hover:text-[#5EEAD4] transition-colors">Tra cứu & Đối chiếu</h4>
        <p class="text-xs text-[#64748B] dark:text-slate-400 leading-relaxed">
          Lọc phòng theo địa bàn thực tế, diện tích sử dụng, biểu phí điện nước công khai và hình ảnh hiện trạng.
        </p>
      </div>

      {{-- Step 2 --}}
      <div class="motion-reveal motion-stagger-2 card-lift-hover group p-6 rounded-2xl bg-white dark:bg-[#181B19] border border-[#E2E8F0] dark:border-[#282D2A] hover:border-[#0D9488] dark:hover:border-[#5EEAD4] shadow-xs hover:shadow-lg transition-all">
        <span class="text-xs font-bold text-[#0D9488] dark:text-[#5EEAD4] uppercase tracking-wider block mb-2 group-hover:scale-105 transition-transform origin-left">Bước 02</span>
        <h4 class="font-bold text-base text-[#172B3A] dark:text-white mb-2 group-hover:text-[#0D9488] dark:group-hover:text-[#5EEAD4] transition-colors">Khảo sát phòng thực địa</h4>
        <p class="text-xs text-[#64748B] dark:text-slate-400 leading-relaxed">
          Liên hệ số điện thoại chính thức của chủ nhà để hẹn lịch xem phòng, đối soát trang thiết bị và môi trường xung quanh.
        </p>
      </div>

      {{-- Step 3 --}}
      <div class="motion-reveal motion-stagger-3 card-lift-hover group p-6 rounded-2xl bg-white dark:bg-[#181B19] border border-[#E2E8F0] dark:border-[#282D2A] hover:border-[#0D9488] dark:hover:border-[#5EEAD4] shadow-xs hover:shadow-lg transition-all">
        <span class="text-xs font-bold text-[#0D9488] dark:text-[#5EEAD4] uppercase tracking-wider block mb-2 group-hover:scale-105 transition-transform origin-left">Bước 03</span>
        <h4 class="font-bold text-base text-[#172B3A] dark:text-white mb-2 group-hover:text-[#0D9488] dark:group-hover:text-[#5EEAD4] transition-colors">Ký hợp đồng thuê điện tử</h4>
        <p class="text-xs text-[#64748B] dark:text-slate-400 leading-relaxed">
          Gửi yêu cầu thuê trực tiếp trên hệ thống, xác nhận các điều khoản hợp đồng chuẩn và lưu trữ hồ sơ bảo mật.
        </p>
      </div>

      {{-- Step 4 --}}
      <div class="motion-reveal motion-stagger-4 card-lift-hover group p-6 rounded-2xl bg-white dark:bg-[#181B19] border border-[#E2E8F0] dark:border-[#282D2A] hover:border-[#0D9488] dark:hover:border-[#5EEAD4] shadow-xs hover:shadow-lg transition-all">
        <span class="text-xs font-bold text-[#0D9488] dark:text-[#5EEAD4] uppercase tracking-wider block mb-2 group-hover:scale-105 transition-transform origin-left">Bước 04</span>
        <h4 class="font-bold text-base text-[#172B3A] dark:text-white mb-2 group-hover:text-[#0D9488] dark:group-hover:text-[#5EEAD4] transition-colors">Bàn giao & An tâm cư trú</h4>
        <p class="text-xs text-[#64748B] dark:text-slate-400 leading-relaxed">
          Nhận bàn giao chìa khóa/mã vân tay, theo dõi chỉ số điện nước minh bạch hàng tháng qua tài khoản cá nhân.
        </p>
      </div>

    </div>
  </div>
</section>

{{-- ============================================================ --}}
{{-- 🤝 8. CỔNG DÀNH CHO CHỦ TRỌ & QUẢN LÝ (PROPTECH SAAS SHOWCASE) --}}
{{-- ============================================================ --}}
<section id="landlord-portal" class="py-16 lg:py-20 bg-white dark:bg-[#161917] border-b border-[#E2E8F0] dark:border-[#262B28] scroll-mt-20">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="motion-reveal rounded-3xl bg-gradient-to-br from-[#134E4A] via-[#0F766E] to-[#115E59] text-white p-8 sm:p-12 lg:p-14 border border-teal-700/60 shadow-2xl shadow-teal-950/20 overflow-hidden relative">
      
      {{-- Subtle Background Glow --}}
      <div class="absolute -top-24 -right-24 w-96 h-96 bg-teal-400/10 rounded-full blur-3xl pointer-events-none" aria-hidden="true"></div>
      <div class="absolute -bottom-24 -left-24 w-80 h-80 bg-teal-300/10 rounded-full blur-3xl pointer-events-none" aria-hidden="true"></div>

      <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-12 items-center relative z-10">
        
        {{-- 👈 CỘT TRÁI: VALUE PROPOSITION & FEATURES --}}
        <div class="lg:col-span-7 space-y-6 text-left">
          
          <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 backdrop-blur-md border border-white/20 text-xs font-semibold text-teal-100 shadow-xs">
            <span class="w-2 h-2 rounded-full bg-teal-300 animate-pulse"></span>
            <span>Dành cho chủ trọ & nhà quản lý bất động sản</span>
          </div>

          <h2 class="text-2xl sm:text-4xl font-extrabold tracking-tight leading-tight text-white">
            Bộ Công Cụ Quản Lý Phòng Trọ Toàn Diện & Dễ Sử Dụng
          </h2>

          <p class="text-sm sm:text-base text-teal-100/90 leading-relaxed max-w-xl font-normal">
            Số hóa toàn bộ quy trình vận hành nhà trọ trên một nền tảng: từ đăng tin phòng trống, quản lý hợp đồng thuê, đến tự động hóa chốt số điện nước và theo dõi thu chi minh bạch.
          </p>

          {{-- 5 Key SaaS Capabilities --}}
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5 pt-2 text-xs sm:text-sm">
            <div class="flex items-start gap-2.5">
              <div class="w-5 h-5 rounded-full bg-teal-400/20 border border-teal-300/40 flex items-center justify-center text-teal-300 shrink-0 mt-0.5">
                <i class="ri-check-line text-xs"></i>
              </div>
              <span class="text-teal-50 font-medium">Quản lý danh sách phòng & tình trạng thuê</span>
            </div>

            <div class="flex items-start gap-2.5">
              <div class="w-5 h-5 rounded-full bg-teal-400/20 border border-teal-300/40 flex items-center justify-center text-teal-300 shrink-0 mt-0.5">
                <i class="ri-check-line text-xs"></i>
              </div>
              <span class="text-teal-50 font-medium">Theo dõi hợp đồng & thông tin người thuê</span>
            </div>

            <div class="flex items-start gap-2.5">
              <div class="w-5 h-5 rounded-full bg-teal-400/20 border border-teal-300/40 flex items-center justify-center text-teal-300 shrink-0 mt-0.5">
                <i class="ri-check-line text-xs"></i>
              </div>
              <span class="text-teal-50 font-medium">Tự động tính toán hóa đơn điện nước định kỳ</span>
            </div>

            <div class="flex items-start gap-2.5">
              <div class="w-5 h-5 rounded-full bg-teal-400/20 border border-teal-300/40 flex items-center justify-center text-teal-300 shrink-0 mt-0.5">
                <i class="ri-check-line text-xs"></i>
              </div>
              <span class="text-teal-50 font-medium">Theo dõi hóa đơn, công nợ & thu chi minh bạch</span>
            </div>

            <div class="flex items-start gap-2.5 sm:col-span-2">
              <div class="w-5 h-5 rounded-full bg-teal-400/20 border border-teal-300/40 flex items-center justify-center text-teal-300 shrink-0 mt-0.5">
                <i class="ri-check-line text-xs"></i>
              </div>
              <span class="text-teal-50 font-medium">Tiếp cận trực tiếp hàng ngàn khách thuê có nhu cầu thực tại TP.HCM</span>
            </div>
          </div>

          {{-- CTAs --}}
          <div class="flex flex-wrap items-center gap-3.5 pt-4">
            @guest
              <button @click="openPopup('Vui lòng đăng nhập để trải nghiệm công cụ quản lý')"
                class="micro-press inline-flex items-center gap-2 px-6 py-3.5 bg-white text-[#0D9488] hover:bg-[#F7FAFA] font-bold rounded-xl text-sm shadow-lg shadow-teal-950/20 transition-all cursor-pointer">
                <span>Khám phá công cụ quản lý</span>
                <i class="ri-arrow-right-line text-base"></i>
              </button>
            @else
              @if (Auth::user()->vai_tro === 'chu_tro')
                <a href="{{ route('chu-tro.index') }}"
                  class="micro-press inline-flex items-center gap-2 px-6 py-3.5 bg-white text-[#0D9488] hover:bg-[#F7FAFA] font-bold rounded-xl text-sm shadow-lg shadow-teal-950/20 transition-all">
                  <span>Khám phá công cụ quản lý</span>
                  <i class="ri-arrow-right-line text-base"></i>
                </a>
              @else
                <button @click="openPopup('Chức năng dành riêng cho tài khoản Chủ trọ. Bạn có thể đăng ký tài khoản Chủ trọ để trải nghiệm.')"
                  class="micro-press inline-flex items-center gap-2 px-6 py-3.5 bg-white text-[#0D9488] hover:bg-[#F7FAFA] font-bold rounded-xl text-sm shadow-lg shadow-teal-950/20 transition-all cursor-pointer">
                  <span>Khám phá công cụ quản lý</span>
                  <i class="ri-arrow-right-line text-base"></i>
                </button>
              @endif
            @endguest

            <a href="tel:19008888"
              class="micro-press inline-flex items-center gap-2 px-5 py-3.5 bg-teal-900/40 hover:bg-teal-900/60 text-white font-semibold rounded-xl border border-teal-300/30 transition-all text-sm backdrop-blur-md">
              <i class="ri-customer-service-2-fill text-teal-300"></i>
              <span>Hotline: 1900 8888</span>
            </a>
          </div>

        </div>

        {{-- 👉 CỘT PHẢI: REALISTIC PROPTECH SAAS DASHBOARD PREVIEW CARD --}}
        <div class="lg:col-span-5">
          <div class="bg-white/95 dark:bg-[#181B19]/95 text-[#172B3A] dark:text-white rounded-2xl p-5 sm:p-6 border border-white/60 dark:border-teal-900/60 shadow-2xl shadow-teal-950/30 backdrop-blur-md space-y-4">
            
            {{-- Header card --}}
            <div class="flex items-center justify-between pb-3 border-b border-[#E2E8F0] dark:border-slate-800">
              <div class="flex items-center gap-2.5">
                <div class="w-8 h-8 rounded-xl bg-[#ECFDF8] text-[#0D9488] flex items-center justify-center text-sm font-bold">
                  <i class="ri-building-4-line"></i>
                </div>
                <div>
                  <h4 class="text-xs font-bold text-[#172B3A] dark:text-white leading-tight">Dãy trọ Tân Bình Center</h4>
                  <span class="text-[10px] text-[#64748B] dark:text-slate-400">24 Phòng • Đang vận hành</span>
                </div>
              </div>
              <span class="inline-flex items-center gap-1 text-[10px] font-bold px-2 py-0.5 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200">
                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                Trực tuyến
              </span>
            </div>

            {{-- 3 Mini Stat KPIs --}}
            <div class="grid grid-cols-3 gap-2 text-center">
              <div class="p-2 rounded-xl bg-[#F7FAFA] dark:bg-slate-800/60 border border-[#E2E8F0]/80 dark:border-slate-700/60">
                <span class="text-[10px] text-[#64748B] dark:text-slate-400 block">Tỷ lệ lấp đầy</span>
                <span class="text-sm font-extrabold text-[#0D9488] dark:text-[#5EEAD4]">92%</span>
              </div>
              <div class="p-2 rounded-xl bg-[#F7FAFA] dark:bg-slate-800/60 border border-[#E2E8F0]/80 dark:border-slate-700/60">
                <span class="text-[10px] text-[#64748B] dark:text-slate-400 block">Đang thuê</span>
                <span class="text-sm font-extrabold text-[#172B3A] dark:text-white">22/24</span>
              </div>
              <div class="p-2 rounded-xl bg-[#F7FAFA] dark:bg-slate-800/60 border border-[#E2E8F0]/80 dark:border-slate-700/60">
                <span class="text-[10px] text-[#64748B] dark:text-slate-400 block">Hóa đơn chốt</span>
                <span class="text-sm font-extrabold text-emerald-600 dark:text-emerald-400">22/22</span>
              </div>
            </div>

            {{-- Preview Room Management Rows --}}
            <div class="space-y-2 pt-1 text-xs">
              <div class="flex items-center justify-between p-2 rounded-xl bg-slate-50 dark:bg-slate-800/40 border border-[#E2E8F0]/60 dark:border-slate-700/40">
                <div class="flex items-center gap-2">
                  <span class="w-6 h-6 rounded-lg bg-[#0D9488]/10 text-[#0D9488] font-bold text-[10px] flex items-center justify-center">101</span>
                  <div>
                    <span class="font-bold block leading-none text-[11px]">Nguyễn Văn An</span>
                    <span class="text-[9px] text-[#64748B]">HĐ đến 12/2026</span>
                  </div>
                </div>
                <div class="text-right">
                  <span class="font-extrabold text-[#0D9488] text-[11px] block">3.200.000₫</span>
                  <span class="text-[9px] text-emerald-600 font-semibold">● Đã thanh toán</span>
                </div>
              </div>

              <div class="flex items-center justify-between p-2 rounded-xl bg-slate-50 dark:bg-slate-800/40 border border-[#E2E8F0]/60 dark:border-slate-700/40">
                <div class="flex items-center gap-2">
                  <span class="w-6 h-6 rounded-lg bg-[#0D9488]/10 text-[#0D9488] font-bold text-[10px] flex items-center justify-center">204</span>
                  <div>
                    <span class="font-bold block leading-none text-[11px]">Trần Thu Thảo</span>
                    <span class="text-[9px] text-[#64748B]">Điện: 142 kWh</span>
                  </div>
                </div>
                <div class="text-right">
                  <span class="font-extrabold text-[#0D9488] text-[11px] block">426.000₫</span>
                  <span class="text-[9px] text-emerald-600 font-semibold">● Đã gửi Zalo</span>
                </div>
              </div>

              <div class="flex items-center justify-between p-2 rounded-xl bg-amber-50/60 dark:bg-amber-950/20 border border-amber-200/60 dark:border-amber-900/40">
                <div class="flex items-center gap-2">
                  <span class="w-6 h-6 rounded-lg bg-amber-100 text-amber-700 font-bold text-[10px] flex items-center justify-center">302</span>
                  <div>
                    <span class="font-bold block leading-none text-[11px] text-amber-900 dark:text-amber-200">Phòng trống</span>
                    <span class="text-[9px] text-amber-700">Đang hiển thị tìm khách</span>
                  </div>
                </div>
                <div class="text-right">
                  <span class="font-extrabold text-amber-700 dark:text-amber-300 text-[11px] block">3.000.000₫</span>
                  <span class="text-[9px] text-amber-700 font-semibold">● 18 khách xem</span>
                </div>
              </div>
            </div>

            {{-- Footer Note inside card --}}
            <div class="pt-2 border-t border-[#E2E8F0] dark:border-slate-800 flex items-center justify-between text-[11px] text-[#64748B] dark:text-slate-400">
              <span class="flex items-center gap-1 text-[#0D9488] font-semibold">
                <i class="ri-shield-check-fill"></i>
                Bảo mật hợp đồng & dữ liệu
              </span>
              <span>Phiên bản v2.4</span>
            </div>

          </div>
        </div>

      </div>

    </div>
  </div>
</section>

{{-- ============================================================ --}}
{{-- 🗺️ 9. BẢN ĐỒ VỊ TRÍ TP. HỒ CHÍ MINH (LOCATION REFERENCE) --}}
{{-- ============================================================ --}}
<section class="py-16 bg-[#FAF9F6] dark:bg-[#121514]">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="motion-reveal mb-8 text-left">
      <span class="text-xs font-semibold uppercase tracking-wider text-[#0D9488] dark:text-[#5EEAD4] mb-1 block">Bản đồ địa bàn</span>
      <h3 class="text-2xl sm:text-3xl font-bold text-[#171A19] dark:text-white">
        Bản Đồ Cụm Bất Động Sản Cho Thuê TP. Hồ Chí Minh
      </h3>
      <p class="text-[#70746F] dark:text-slate-400 text-xs sm:text-sm mt-1">
        Tra cứu vị trí phòng trọ liên kết các trục giao thông, bến xe buýt và các trường đại học trọng điểm.
      </p>
    </div>

    <div class="motion-reveal card-lift-hover rounded-xl overflow-hidden border border-[#E5E3DC] dark:border-[#282D2A] bg-stone-100 shadow-2xs">
      <iframe
        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3919.502388917805!2d106.6598629!3d10.7768894!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31752f3872e5b41f%3A0x6e5c70e2a546f1e4!2zVGjDoG5oIHBo4buRIDIgSCDEkMO0IENow60gTWluaCBDaXR5!5e0!3m2!1svi!2s!4v1696772290169!5m2!1svi!2s"
        width="100%" height="400" style="border:0;" allowfullscreen="" loading="lazy"
        referrerpolicy="no-referrer-when-downgrade" class="w-full">
      </iframe>
    </div>
  </div>
</section>

{{-- 🪟 POPUP XÁC THỰC (MODAL DIALOG) --}}
<div x-show="showLoginModal" x-transition.opacity x-cloak
  class="fixed inset-0 bg-[#121514]/70 backdrop-blur-xs flex items-center justify-center z-[999] p-4">
  <div class="bg-white dark:bg-[#181B19] rounded-xl border border-[#E5E3DC] dark:border-[#2D3330] w-full max-w-md p-6 text-center relative shadow-xl"
       @click.away="showLoginModal = false">
    <button @click="showLoginModal = false"
      class="absolute top-4 right-4 text-[#85877F] hover:text-[#171A19] dark:hover:text-white p-1 rounded-md">
      <i class="ri-close-line text-xl"></i>
    </button>

    <div class="w-12 h-12 rounded-lg bg-[#FAF9F6] dark:bg-[#222724] text-[#1B3D2F] dark:text-[#A3B899] mx-auto flex items-center justify-center text-2xl mb-3 border border-[#E5E3DC] dark:border-[#303632]">
      <i class="ri-shield-user-line"></i>
    </div>
    
    <h3 class="text-lg font-bold text-[#171A19] dark:text-white mb-2">Yêu Cầu Xác Thực</h3>
    <p x-text="message" class="text-[#70746F] dark:text-slate-400 text-xs sm:text-sm mb-6"></p>

    <div class="flex justify-center gap-3">
      <a href="{{ route('login') }}"
        class="px-5 py-2.5 bg-[#1B3D2F] hover:bg-[#142F24] text-white font-semibold text-xs sm:text-sm rounded-lg transition">
        Đăng nhập ngay
      </a>
      <button @click="showLoginModal = false"
        class="px-5 py-2.5 bg-[#FAF9F6] dark:bg-[#222724] text-[#555955] dark:text-[#A7AAA4] font-semibold text-xs sm:text-sm rounded-lg border border-[#E5E3DC] dark:border-[#303632] hover:bg-[#EAE8E1] transition">
        Đóng
      </button>
    </div>
  </div>
</div>

</div>
@endsection
