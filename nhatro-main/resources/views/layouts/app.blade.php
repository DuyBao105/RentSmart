<!DOCTYPE html>
<html lang="vi" class="scroll-smooth" x-data="darkMode()" x-init="init()" :class="{ 'dark': isDark }">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">


  <title>@yield('title', 'Hệ Thống Trọ - Tìm kiếm & Quản lý phòng trọ')</title>

  {{-- 🌟 Google Fonts: Plus Jakarta Sans & Inter --}}
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@400;500;600;700;800;900&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

  {{-- ✅ Tailwind Configuration with Premium PropTech Teal Palette --}}
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      darkMode: 'class',
      theme: {
        extend: {
          fontFamily: {
            sans: ['"Be Vietnam Pro"', '"Plus Jakarta Sans"', 'Inter', 'system-ui', 'sans-serif'],
            display: ['"Be Vietnam Pro"', 'sans-serif'],
          },
          colors: {
            primary: {
              DEFAULT: '#0D9488', // Teal-600
              hover: '#0F766E',   // Teal-700
              deep: '#134E4A',    // Teal-900
              50: '#ECFDF8',
              100: '#CCFBF1',
              200: '#99F6E4',
              300: '#5EEAD4',
              400: '#2DD4BF',
              500: '#14B8A6',
              600: '#0D9488',
              700: '#0F766E',
              800: '#115E59',
              900: '#134E4A',
              950: '#042F2E',
            },
            proptech: {
              primary: '#0D9488',
              hover: '#0F766E',
              deep: '#134E4A',
              bg: '#FFFFFF',
              soft: '#F7FAFA',
              mint: '#ECFDF8',
              text: '#172B3A',
              secondary: '#64748B',
              border: '#E2E8F0',
            }
          }
        }
      }
    }
  </script>
  <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

  {{-- ✅ Remix Icons & SweetAlert2 --}}
  <link href="https://cdn.jsdelivr.net/npm/remixicon@4.3.0/fonts/remixicon.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  {{-- 🗺️ Leaflet Map (OpenStreetMap) --}}
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
  <style>
    :root {
      --motion-timing-instant: 120ms;
      --motion-timing-fast: 180ms;
      --motion-timing-base: 280ms;
      --motion-timing-slow: 480ms;
      --motion-timing-reveal: 600ms;
      --motion-ease-spring: cubic-bezier(0.16, 1, 0.3, 1);
      --motion-ease-smooth: cubic-bezier(0.4, 0, 0.2, 1);
      --motion-ease-bounce: cubic-bezier(0.34, 1.56, 0.64, 1);
      --motion-ease-out: cubic-bezier(0, 0, 0.2, 1);
    }

    [x-cloak] { display: none !important; }
    
    body {
      font-family: 'Be Vietnam Pro', 'Plus Jakarta Sans', Inter, sans-serif;
      text-rendering: optimizeLegibility;
      -webkit-font-smoothing: antialiased;
    }

    /* 🌊 Page-Level Fade-In on Navigation */
    .page-enter-fade {
      animation: pageEnterFade 0.22s var(--motion-ease-smooth) forwards;
    }
    @keyframes pageEnterFade {
      from { opacity: 0; transform: translateY(6px); }
      to { opacity: 1; transform: translateY(0); }
    }

    /* 🌟 Progressive Scroll-Triggered Reveal System */
    html[data-motion-ready="true"] .motion-reveal {
      opacity: 0;
      transform: translateY(18px);
      transition: opacity 0.65s var(--motion-ease-spring), transform 0.65s var(--motion-ease-spring);
      will-change: opacity, transform;
    }

    html[data-motion-ready="true"] .motion-reveal.is-revealed {
      opacity: 1;
      transform: translateY(0);
    }

    /* Stagger Delays */
    html[data-motion-ready="true"] .motion-stagger-1 { transition-delay: 50ms; }
    html[data-motion-ready="true"] .motion-stagger-2 { transition-delay: 100ms; }
    html[data-motion-ready="true"] .motion-stagger-3 { transition-delay: 150ms; }
    html[data-motion-ready="true"] .motion-stagger-4 { transition-delay: 200ms; }
    html[data-motion-ready="true"] .motion-stagger-5 { transition-delay: 250ms; }
    html[data-motion-ready="true"] .motion-stagger-6 { transition-delay: 300ms; }
    html[data-motion-ready="true"] .motion-stagger-7 { transition-delay: 350ms; }
    html[data-motion-ready="true"] .motion-stagger-8 { transition-delay: 400ms; }

    /* Legacy compatibility for .reveal */
    .reveal {
      opacity: 0;
      transform: translateY(20px);
      transition: all .6s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .reveal.active {
      opacity: 1;
      transform: translateY(0);
    }

    /* Restrained Floating Animations for Hero Cards */
    @keyframes floatSubtleA {
      0%, 100% { transform: translateY(0px); }
      50% { transform: translateY(-6px); }
    }
    @keyframes floatSubtleB {
      0%, 100% { transform: translateY(0px); }
      50% { transform: translateY(-5px); }
    }
    @keyframes floatSubtleC {
      0%, 100% { transform: translateX(-50%) translateY(0px); }
      50% { transform: translateX(-50%) translateY(-6px); }
    }

    .animate-float-card-1 {
      animation: floatSubtleA 6s ease-in-out infinite;
    }
    .animate-float-card-2 {
      animation: floatSubtleB 7s ease-in-out 1s infinite;
    }
    .animate-float-card-3 {
      animation: floatSubtleC 6.5s ease-in-out 2s infinite;
    }

    .animate-float-card-1:hover,
    .animate-float-card-2:hover,
    .animate-float-card-3:hover {
      animation-play-state: paused;
    }

    /* ⚡ Micro-interactions */
    .micro-press {
      transition: transform 0.15s var(--motion-ease-spring), opacity 0.15s;
    }
    .micro-press:active {
      transform: scale(0.97);
    }

    .card-lift-hover {
      transition: transform 0.28s var(--motion-ease-spring), box-shadow 0.28s var(--motion-ease-spring), border-color 0.28s var(--motion-ease-spring);
    }
    .card-lift-hover:hover {
      transform: translateY(-4px);
    }

    /* Primary CTA Button Shimmer & Elevation */
    .btn-glow-teal {
      transition: transform 0.22s var(--motion-ease-spring), box-shadow 0.22s var(--motion-ease-spring), background-color 0.2s;
    }
    .btn-glow-teal:hover {
      box-shadow: 0 8px 24px -4px rgba(13, 148, 136, 0.38);
      transform: translateY(-1.5px);
    }
    .btn-glow-teal:active {
      transform: scale(0.98);
      box-shadow: 0 2px 8px -2px rgba(13, 148, 136, 0.2);
    }

    /* 🏛️ Header elevation scroll effect */
    header.header-scrolled {
      box-shadow: 0 4px 20px -2px rgba(15, 23, 42, 0.08);
      background-color: rgba(255, 255, 255, 0.98);
    }
    html.dark header.header-scrolled {
      box-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.4);
      background-color: rgba(23, 26, 25, 0.98);
    }

    /* 🚀 Floating Back to Top Button */
    #backToTopBtn {
      opacity: 0;
      visibility: hidden;
      transform: translateY(12px) scale(0.92);
      transition: opacity 0.25s var(--motion-ease-smooth), transform 0.25s var(--motion-ease-spring), visibility 0.25s, background-color 0.2s, color 0.2s;
    }
    #backToTopBtn.visible {
      opacity: 1;
      visibility: visible;
      transform: translateY(0) scale(1);
    }

    /* 🪟 Global Modals & Dialogs */
    .modal-backdrop-animate {
      animation: modalBackdropFadeIn 0.22s var(--motion-ease-smooth) forwards;
    }
    .modal-panel-animate {
      animation: modalPanelScaleUp 0.26s var(--motion-ease-spring) forwards;
    }
    @keyframes modalBackdropFadeIn {
      from { opacity: 0; }
      to { opacity: 1; }
    }
    @keyframes modalPanelScaleUp {
      from { opacity: 0; transform: scale(0.96) translateY(8px); }
      to { opacity: 1; transform: scale(1) translateY(0); }
    }

    /* 🔽 Dropdowns & Popovers */
    .dropdown-menu-animate {
      animation: dropdownSlideDown 0.2s var(--motion-ease-spring) forwards;
      transform-origin: top;
    }
    @keyframes dropdownSlideDown {
      from { opacity: 0; transform: translateY(-6px) scale(0.98); }
      to { opacity: 1; transform: translateY(0) scale(1); }
    }

    /* 🏷️ Badge Pulse & Status Indicators */
    .badge-pulse {
      position: relative;
    }
    .badge-pulse::after {
      content: '';
      position: absolute;
      inset: 0;
      border-radius: inherit;
      box-shadow: 0 0 0 0 currentColor;
      animation: badgePulseRing 2.2s cubic-bezier(0.66, 0, 0, 1) infinite;
      opacity: 0.5;
    }
    @keyframes badgePulseRing {
      0% { box-shadow: 0 0 0 0 currentColor; opacity: 0.5; }
      70% { box-shadow: 0 0 0 6px currentColor; opacity: 0; }
      100% { box-shadow: 0 0 0 0 currentColor; opacity: 0; }
    }

    /* 📝 Form Controls & Inputs Smooth Focus Ring */
    .input-focus-smooth {
      transition: border-color var(--motion-timing-fast) var(--motion-ease-smooth),
                  box-shadow var(--motion-timing-fast) var(--motion-ease-smooth),
                  background-color var(--motion-timing-fast);
    }
    .input-focus-smooth:focus {
      outline: none;
      border-color: #0D9488;
      box-shadow: 0 0 0 3px rgba(13, 148, 136, 0.18);
    }
    html.dark .input-focus-smooth:focus {
      border-color: #2DD4BF;
      box-shadow: 0 0 0 3px rgba(45, 212, 191, 0.22);
    }

    /* 📊 Data Table Row Hover */
    .table-row-hover {
      transition: background-color 0.16s var(--motion-ease-smooth);
    }
    .table-row-hover:hover {
      background-color: rgba(244, 247, 245, 0.7);
    }
    html.dark .table-row-hover:hover {
      background-color: rgba(19, 78, 74, 0.2);
    }

    /* ⭐ Star Rating Micro-Bounce */
    .star-hover {
      transition: transform 0.18s var(--motion-ease-spring), color 0.15s;
    }
    .star-hover:hover {
      transform: scale(1.25);
    }

    /* ❤️ Heart Favorite Bounce */
    .heart-bounce {
      animation: heartPop 0.32s var(--motion-ease-bounce);
    }
    @keyframes heartPop {
      0% { transform: scale(1); }
      45% { transform: scale(1.35); }
      100% { transform: scale(1); }
    }

    /* 💀 Skeleton Loading Shimmer */
    .skeleton-shimmer {
      background: linear-gradient(90deg, rgba(226, 232, 240, 0.6) 25%, rgba(241, 245, 249, 0.9) 37%, rgba(226, 232, 240, 0.6) 63%);
      background-size: 400% 100%;
      animation: skeletonWave 1.4s ease infinite;
    }
    html.dark .skeleton-shimmer {
      background: linear-gradient(90deg, rgba(30, 41, 59, 0.6) 25%, rgba(51, 65, 85, 0.8) 37%, rgba(30, 41, 59, 0.6) 63%);
      background-size: 400% 100%;
    }
    @keyframes skeletonWave {
      0% { background-position: 100% 50%; }
      100% { background-position: 0 50%; }
    }

    /* 🍞 Toast Notification Entrance */
    .toast-slide-in {
      animation: toastSlideDown 0.28s var(--motion-ease-spring) forwards;
    }
    @keyframes toastSlideDown {
      from { opacity: 0; transform: translateY(-12px) scale(0.96); }
      to { opacity: 1; transform: translateY(0) scale(1); }
    }

    /* 🎨 SweetAlert2 Design System Alignment */
    .swal2-popup {
      border-radius: 1.25rem !important;
      font-family: 'Be Vietnam Pro', 'Plus Jakarta Sans', sans-serif !important;
      box-shadow: 0 20px 40px -12px rgba(15, 23, 42, 0.22) !important;
      border: 1px solid rgba(226, 232, 240, 0.8) !important;
    }
    html.dark .swal2-popup {
      background: #181B19 !important;
      color: #E2E8F0 !important;
      border-color: #2D3330 !important;
      box-shadow: 0 20px 40px -12px rgba(0, 0, 0, 0.5) !important;
    }
    .swal2-title {
      font-weight: 800 !important;
      letter-spacing: -0.02em !important;
    }
    .swal2-confirm {
      border-radius: 0.75rem !important;
      padding: 0.65rem 1.4rem !important;
      font-weight: 700 !important;
      font-size: 0.875rem !important;
      box-shadow: 0 4px 14px -2px rgba(13, 148, 136, 0.4) !important;
      transition: transform 0.15s ease !important;
    }
    .swal2-confirm:active {
      transform: scale(0.96) !important;
    }

    /* 🚥 Top Page Loading Bar */
    #global-top-progress {
      position: fixed;
      top: 0;
      left: 0;
      height: 3px;
      background: linear-gradient(90deg, #134E4A, #0D9488, #2DD4BF);
      z-index: 99999;
      width: 0%;
      opacity: 0;
      pointer-events: none;
      transition: width 0.35s var(--motion-ease-smooth), opacity 0.25s;
    }
    #global-top-progress.loading {
      opacity: 1;
      width: 75%;
    }
    #global-top-progress.finished {
      opacity: 1;
      width: 100%;
      transition: width 0.15s ease-out, opacity 0.3s ease-out 0.15s;
    }

    .animate-fade-in {
      animation: fadeIn .25s ease-out;
    }

    /* ♿ Accessibility: prefers-reduced-motion */
    @media (prefers-reduced-motion: reduce) {
      *,
      *::before,
      *::after {
        animation-duration: 0.01ms !important;
        animation-iteration-count: 1 !important;
        transition-duration: 0.01ms !important;
        scroll-behavior: auto !important;
      }
      html[data-motion-ready="true"] .motion-reveal,
      .page-enter-fade {
        opacity: 1 !important;
        transform: none !important;
        transition: none !important;
        animation: none !important;
      }
      .animate-float-card-1,
      .animate-float-card-2,
      .animate-float-card-3 {
        animation: none !important;
      }
    }
  </style>
  </style>
</head>

<body class="antialiased flex flex-col min-h-screen bg-white dark:bg-[#121514] text-[#172B3A] dark:text-[#E8EAE9] selection:bg-[#0D9488] selection:text-white transition-colors duration-200">

  {{-- 🚥 Top Loading Bar --}}
  <div id="global-top-progress"></div>

  {{-- ⚡ FLASH MESSAGE --}}
  @if (session('ok') || session('success') || session('error'))
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)"
      class="fixed top-5 right-5 z-[9999] px-4 py-3 rounded-xl shadow-lg backdrop-blur-md text-white text-xs sm:text-sm font-semibold flex items-center gap-2.5 border border-white/10 animate-fade-in
             {{ session('error') ? 'bg-rose-600/95 shadow-rose-600/20' : 'bg-[#0D9488]/95 shadow-teal-900/20' }}">
      <i class="{{ session('error') ? 'ri-error-warning-fill' : 'ri-checkbox-circle-fill text-emerald-300' }} text-base"></i>
      <span>{{ session('ok') ?? session('success') ?? session('error') }}</span>
    </div>
  @endif

  {{-- 🏛️ COMMERCIAL REAL ESTATE NAVIGATION BAR --}}
  @unless (Request::is('login') || Request::is('register'))
    <header class="sticky top-0 z-50 bg-white/95 dark:bg-[#171A19]/95 backdrop-blur-md border-b border-[#E2E8F0] dark:border-stone-800/80 transition-all duration-200 shadow-xs"
      x-data="{ mobileMenu: false }">
      <nav class="max-w-7xl mx-auto flex items-center justify-between px-3 sm:px-6 h-16 lg:h-18 gap-1.5 xl:gap-3">

        {{-- 🏠 Brand Logo & Wordmark --}}
        <a href="{{ route('home') }}" class="flex items-center gap-2 group shrink-0">
          <img src="{{ asset('images/Logo.png') }}" alt="Logo" class="h-9 sm:h-10 w-auto object-contain transition-transform group-hover:scale-102">
          <div class="flex flex-col text-left">
            <span class="text-base sm:text-lg xl:text-xl font-extrabold tracking-tight text-[#172B3A] dark:text-white leading-tight whitespace-nowrap">
              Hệ Thống Trọ
            </span>
            <span class="text-[9px] xl:text-[10px] font-semibold tracking-wider uppercase text-[#0D9488] dark:text-[#5EEAD4] leading-none whitespace-nowrap hidden xl:block">
              Nền Tảng Cho Thuê & Quản Lý
            </span>
          </div>
        </a>

        {{-- 📋 Center Navigation Links --}}
        <div class="hidden lg:flex items-center gap-0.5 xl:gap-1.5 shrink-0">
          <a href="{{ route('home') }}"
            class="px-2.5 py-1.5 xl:px-3 xl:py-2 rounded-lg text-xs xl:text-sm font-semibold transition-colors whitespace-nowrap {{ Request::is('/') ? 'bg-[#ECFDF8] dark:bg-[#134E4A]/30 text-[#0D9488] dark:text-[#5EEAD4] font-bold' : 'text-[#64748B] dark:text-stone-300 hover:text-[#172B3A] dark:hover:text-white hover:bg-slate-100/60 dark:hover:bg-stone-800/50' }}">
            Trang chủ
          </a>

          <a href="{{ route('listing') }}"
            class="px-2.5 py-1.5 xl:px-3 xl:py-2 rounded-lg text-xs xl:text-sm font-semibold transition-colors whitespace-nowrap {{ Request::is('bai-dang*') && !request()->has('dia_chi') && !request()->has('category') ? 'bg-[#ECFDF8] dark:bg-[#134E4A]/30 text-[#0D9488] dark:text-[#5EEAD4] font-bold' : 'text-[#64748B] dark:text-stone-300 hover:text-[#172B3A] dark:hover:text-white hover:bg-slate-100/60 dark:hover:bg-stone-800/50' }}">
            Khám phá phòng
          </a>

          <a href="{{ route('listing', ['category' => 'sinh_vien']) }}"
            class="px-2.5 py-1.5 xl:px-3 xl:py-2 rounded-lg text-xs xl:text-sm font-semibold transition-colors whitespace-nowrap {{ request('category') === 'sinh_vien' ? 'bg-[#ECFDF8] dark:bg-[#134E4A]/30 text-[#0D9488] dark:text-[#5EEAD4] font-bold' : 'text-[#64748B] dark:text-stone-300 hover:text-[#172B3A] dark:hover:text-white hover:bg-slate-100/60 dark:hover:bg-stone-800/50' }}">
            Trọ sinh viên
          </a>

          <a href="{{ route('listing', ['category' => 'studio']) }}"
            class="px-2.5 py-1.5 xl:px-3 xl:py-2 rounded-lg text-xs xl:text-sm font-semibold transition-colors whitespace-nowrap {{ request('category') === 'studio' ? 'bg-[#ECFDF8] dark:bg-[#134E4A]/30 text-[#0D9488] dark:text-[#5EEAD4] font-bold' : 'text-[#64748B] dark:text-stone-300 hover:text-[#172B3A] dark:hover:text-white hover:bg-slate-100/60 dark:hover:bg-stone-800/50' }}">
            Căn hộ Studio
          </a>

          <a href="{{ route('home') }}#community"
            class="px-2.5 py-1.5 xl:px-3 xl:py-2 rounded-lg text-xs xl:text-sm font-semibold transition-colors whitespace-nowrap text-[#64748B] dark:text-stone-300 hover:text-[#172B3A] dark:hover:text-white hover:bg-slate-100/60 dark:hover:bg-stone-800/50">
            Cẩm nang<span class="hidden 2xl:inline"> thuê trọ</span>
          </a>

          @php
            $u = session('user', []);
          @endphp

          @if (!empty($u) && ($u['vai_tro'] ?? null) === 'khach_thue')
            <a href="{{ route('khach-thue.yeu-thich') }}"
              class="px-2.5 py-1.5 xl:px-3 xl:py-2 rounded-lg text-xs xl:text-sm font-semibold transition-colors whitespace-nowrap flex items-center gap-1.5 text-[#64748B] dark:text-stone-300 hover:text-rose-600 hover:bg-slate-100/60 dark:hover:bg-stone-800/50 {{ Request::is('khach-thue/yeu-thich') ? 'text-rose-600 font-bold' : '' }}">
              <i class="ri-heart-3-line text-rose-500"></i>
              <span>Yêu thích</span>
            </a>
          @endif
        </div>

        {{-- 👤 Right Action Area --}}
        <div class="hidden lg:flex items-center gap-1.5 xl:gap-2.5 shrink-0">
          {{-- Đăng tin cho thuê button --}}
          @if (!session('user') || ($u['vai_tro'] ?? null) === 'chu_tro')
            <a href="{{ session('user') ? route('chu-tro.index') : route('login') }}"
              class="flex items-center gap-1.5 px-3 py-1.5 xl:px-3.5 xl:py-2 bg-[#0D9488] hover:bg-[#0F766E] text-white rounded-lg text-xs font-bold transition-all shadow-xs hover:shadow-md hover:shadow-teal-700/20 whitespace-nowrap micro-press">
              <i class="ri-add-line text-sm"></i>
              <span>Đăng tin<span class="hidden xl:inline"> cho thuê</span></span>
            </a>
          @endif

          @if (!session('user'))
            <div class="h-4 w-px bg-stone-200 dark:bg-stone-700 mx-0.5 xl:mx-1"></div>
            <a href="{{ route('login') }}"
              class="px-2.5 py-1.5 xl:px-3 xl:py-2 text-[#172B3A] dark:text-stone-200 hover:text-[#0D9488] dark:hover:text-emerald-400 text-xs xl:text-sm font-semibold transition whitespace-nowrap">
              Đăng nhập
            </a>
            <a href="{{ route('register') }}"
              class="px-3 py-1.5 xl:px-3.5 xl:py-2 bg-stone-900 hover:bg-stone-800 text-white dark:bg-stone-100 dark:text-stone-900 dark:hover:bg-white rounded-lg text-xs xl:text-sm font-bold transition whitespace-nowrap">
              Đăng ký
            </a>
          @else
            @php
              $rawAvatar = $u['anh_dai_dien'] ?? '/images/default-avatar.png';
              if (!str_starts_with($rawAvatar, 'http') && !str_starts_with($rawAvatar, '/')) {
                $rawAvatar = rtrim(env('API_BASE_URL', 'http://127.0.0.1:8000'), '/') . '/' . ltrim($rawAvatar, '/');
              }
              $buster = session('avatar_bust') ?? time();
              $avatar = $rawAvatar . (str_contains($rawAvatar, '?') ? '&' : '?') . 'v=' . $buster;
              $role = $u['vai_tro'] ?? 'guest';
              $redirectRoute = match ($role) {
                'quan_tri' => route('admin.dashboard'),
                'chu_tro' => route('chu-tro.dashboard'),
                'khach_thue' => route('khach-thue.dashboard'),
                default => route('home'),
              };
            @endphp

            @if ($role === 'quan_tri')
              <a href="{{ route('admin.dashboard') }}"
                class="flex items-center gap-1.5 px-3 py-1.5 bg-gradient-to-r from-amber-600 to-amber-500 hover:from-amber-700 hover:to-amber-600 text-white rounded-lg text-xs font-bold transition-all shadow-xs whitespace-nowrap">
                <i class="ri-shield-keyhole-line text-sm"></i>
                <span>Trang Quản Trị</span>
              </a>
            @endif

            <div class="flex items-center gap-2.5 bg-stone-100 dark:bg-stone-800/80 pl-2 pr-2.5 py-1.5 rounded-xl border border-stone-200/70 dark:border-stone-700/70">
              <a href="{{ $redirectRoute }}" class="flex items-center gap-2 hover:opacity-85 transition" title="Bảng điều khiển">
                <img src="{{ $avatar }}" alt="Avatar"
                  class="w-7 h-7 rounded-full border border-stone-300 dark:border-stone-600 object-cover"
                  onerror="if (!this.dataset.fallback) { this.dataset.fallback = true; this.src='/images/default-avatar.png'; }">
                <div class="flex flex-col text-left">
                  <span class="text-xs font-bold text-stone-900 dark:text-white leading-tight max-w-[100px] truncate">
                    {{ $u['ho_ten'] ?? 'Người dùng' }}
                  </span>
                  <span class="text-[9px] text-[#0D9488] dark:text-[#5EEAD4] font-semibold leading-none mt-0.5 flex items-center gap-0.5">
                    @if($role === 'quan_tri')
                      <i class="ri-shield-star-line text-amber-500" aria-hidden="true"></i> Quản trị
                    @elseif($role === 'chu_tro')
                      <i class="ri-community-line text-[#0D9488]" aria-hidden="true"></i> Chủ trọ
                    @elseif($role === 'khach_thue')
                      <i class="ri-user-smile-line text-[#0D9488]" aria-hidden="true"></i> Khách thuê
                    @else
                      Thành viên
                    @endif
                  </span>
                </div>
              </a>

              <form method="POST" action="{{ route('logout') }}" class="inline ml-0.5">
                @csrf
                <button type="submit" title="Đăng xuất"
                  class="p-1 text-stone-400 hover:text-rose-600 rounded transition">
                  <i class="ri-logout-box-r-line text-sm"></i>
                </button>
              </form>
            </div>
          @endif

          {{-- 🌙 Dark Mode Button --}}
          <button @click="toggleDark()"
            class="p-2 rounded-lg bg-stone-100 dark:bg-stone-800 text-stone-600 dark:text-amber-400 hover:bg-stone-200 dark:hover:bg-stone-700 transition"
            aria-label="Toggle theme">
            <template x-if="!isDark"><i class="ri-moon-line text-sm"></i></template>
            <template x-if="isDark"><i class="ri-sun-line text-sm"></i></template>
          </button>
        </div>

        {{-- Mobile Hamburger & Theme Toggle --}}
        <div class="flex items-center gap-1.5 lg:hidden">
          <button @click="toggleDark()" class="p-2 rounded-lg bg-stone-100 dark:bg-stone-800 text-stone-600 dark:text-amber-400 text-sm">
            <template x-if="!isDark"><i class="ri-moon-line"></i></template>
            <template x-if="isDark"><i class="ri-sun-line"></i></template>
          </button>
          <button @click="mobileMenu = !mobileMenu" class="p-2 rounded-lg bg-stone-100 dark:bg-stone-800 text-stone-700 dark:text-white">
            <i :class="mobileMenu ? 'ri-close-line' : 'ri-menu-line'" class="text-lg"></i>
          </button>
        </div>

      </nav>

      {{-- Mobile Drawer Menu --}}
      <div x-show="mobileMenu" x-cloak
        class="lg:hidden bg-white dark:bg-[#171A19] border-b border-stone-200 dark:border-stone-800 px-5 py-4 space-y-2">
        <a href="{{ route('home') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-lg font-semibold text-xs sm:text-sm text-stone-700 dark:text-stone-200 hover:bg-stone-100 dark:hover:bg-stone-800">
          <i class="ri-home-line text-stone-500"></i> Trang chủ
        </a>
        <a href="{{ route('listing') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-lg font-semibold text-xs sm:text-sm text-stone-700 dark:text-stone-200 hover:bg-stone-100 dark:hover:bg-stone-800">
          <i class="ri-compass-line text-stone-500"></i> Khám phá phòng
        </a>
        <a href="{{ route('listing', ['category' => 'sinh_vien']) }}" class="flex items-center justify-between px-3 py-2 rounded-lg font-semibold text-xs sm:text-sm text-stone-700 dark:text-stone-200 hover:bg-stone-100 dark:hover:bg-stone-800">
          <span class="flex items-center gap-2.5">
            <i class="ri-graduation-cap-line text-stone-500"></i> Phòng sinh viên
          </span>
          <span class="px-1.5 py-0.5 rounded text-[10px] font-bold bg-[#ECFDF8] text-[#0D9488]">Giá tốt</span>
        </a>
        <a href="{{ route('listing', ['category' => 'studio']) }}" class="flex items-center gap-2.5 px-3 py-2 rounded-lg font-semibold text-xs sm:text-sm text-stone-700 dark:text-stone-200 hover:bg-stone-100 dark:hover:bg-stone-800">
          <i class="ri-building-line text-stone-500"></i> Căn hộ Studio
        </a>
        <a href="{{ route('home') }}#community" class="flex items-center gap-2.5 px-3 py-2 rounded-lg font-semibold text-xs sm:text-sm text-stone-700 dark:text-stone-200 hover:bg-stone-100 dark:hover:bg-stone-800">
          <i class="ri-article-line text-stone-500"></i> Cẩm nang thuê trọ
        </a>

        @if (!empty($u) && ($u['vai_tro'] ?? null) === 'khach_thue')
          <a href="{{ route('khach-thue.yeu-thich') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-lg font-semibold text-xs sm:text-sm text-stone-700 dark:text-stone-200 hover:bg-stone-100 dark:hover:bg-stone-800">
            <i class="ri-heart-line text-rose-500"></i> Danh sách yêu thích
          </a>
        @endif

        <div class="pt-3 border-t border-stone-200 dark:border-stone-800 flex flex-col gap-2">
          @if (!session('user'))
            <a href="{{ route('login') }}" class="w-full text-center py-2 rounded-lg border border-stone-300 dark:border-stone-700 font-semibold text-xs text-[#172B3A] dark:text-stone-200">
              Đăng nhập
            </a>
            <a href="{{ route('register') }}" class="w-full text-center py-2 rounded-lg bg-[#0D9488] text-white font-bold text-xs">
              Đăng ký tài khoản
            </a>
          @else
            <a href="{{ $redirectRoute }}" class="w-full text-center py-2 rounded-lg {{ $role === 'quan_tri' ? 'bg-amber-600' : 'bg-[#0D9488]' }} text-white font-bold text-xs flex items-center justify-center gap-1.5">
              @if($role === 'quan_tri')
                <i class="ri-shield-star-line"></i> Trang Quản Trị
              @else
                <i class="ri-dashboard-line"></i> Bảng điều khiển ({{ $u['ho_ten'] ?? 'Tài khoản' }})
              @endif
            </a>
            <form method="POST" action="{{ route('logout') }}">
              @csrf
              <button class="w-full text-center py-1.5 text-rose-600 font-semibold text-xs">
                Đăng xuất
              </button>
            </form>
          @endif
        </div>
      </div>
    </header>
  @endunless

  <main class="flex-grow page-enter-fade">@yield('content')</main>

  {{-- 🏛️ AUTHORITATIVE REAL ESTATE FOOTER --}}
  <footer class="mt-20 bg-[#141716] text-[#A6AAA7] border-t border-stone-800 relative">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-14 pb-10">
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-10 mb-12">
        {{-- Brand info --}}
        <div class="lg:col-span-2 space-y-4">
          <div class="flex items-center space-x-2.5">
            <img src="{{ asset('images/Logo.png') }}" alt="Logo" class="h-9 w-auto object-contain brightness-110">
            <div class="flex flex-col">
              <span class="text-lg font-bold text-white tracking-tight leading-tight">Hệ Thống Trọ</span>
              <span class="text-[10px] uppercase tracking-wider text-[#0D9488] font-medium">Commercial Rental Network</span>
            </div>
          </div>
          <p class="text-stone-400 text-xs leading-relaxed max-w-sm">
            Nền tảng kết nối trực tiếp khách thuê và đơn vị vận hành nhà trọ. Xác thực thông tin thực địa, minh bạch biểu phí điện nước và chuẩn hóa quy trình thuê phòng an toàn.
          </p>
          <div class="flex items-center space-x-2 pt-1">
            <span class="w-8 h-8 rounded-lg bg-stone-800 hover:bg-[#0D9488] hover:text-white flex items-center justify-center text-stone-400 cursor-pointer transition text-sm">
              <i class="ri-facebook-fill"></i>
            </span>
            <span class="w-8 h-8 rounded-lg bg-stone-800 hover:bg-[#0D9488] hover:text-white flex items-center justify-center text-stone-400 cursor-pointer transition text-sm">
              <i class="ri-youtube-fill"></i>
            </span>
            <span class="w-8 h-8 rounded-lg bg-stone-800 hover:bg-[#0D9488] hover:text-white flex items-center justify-center text-stone-400 cursor-pointer transition text-sm">
              <i class="ri-customer-service-2-fill"></i>
            </span>
          </div>
        </div>

        {{-- Quick Links --}}
        <div>
          <h4 class="text-white text-xs font-bold uppercase tracking-wider mb-3.5">Khám phá BĐS</h4>
          <ul class="space-y-2 text-xs">
            <li><a href="{{ route('home') }}" class="hover:text-white transition">Trang chủ</a></li>
            <li><a href="{{ route('listing') }}" class="hover:text-white transition">Tất cả phòng cho thuê</a></li>
            <li><a href="{{ route('listing', ['category' => 'sinh_vien']) }}" class="hover:text-white transition">Trọ sinh viên giá tốt</a></li>
            <li><a href="{{ route('listing', ['category' => 'studio']) }}" class="hover:text-white transition">Căn hộ Studio mini</a></li>
            <li><a href="{{ route('listing', ['sort' => 'newest']) }}" class="hover:text-white transition">Phòng mới xác minh</a></li>
          </ul>
        </div>

        {{-- Landlord --}}
        <div>
          <h4 class="text-white text-xs font-bold uppercase tracking-wider mb-3.5">Dành cho chủ nhà</h4>
          <ul class="space-y-2 text-xs">
            <li><a href="{{ route('chu-tro.index') }}" class="hover:text-white transition">Đăng tin phòng trống</a></li>
            <li><a href="{{ route('chu-tro.index') }}" class="hover:text-white transition">Quản lý tòa nhà & dãy trọ</a></li>
            <li><a href="{{ route('chu-tro.index') }}" class="hover:text-white transition">Hợp đồng thuê & Hóa đơn</a></li>
            <li><a href="{{ route('register') }}" class="hover:text-white transition">Đăng ký đối tác vận hành</a></li>
          </ul>
        </div>

        {{-- Support --}}
        <div>
          <h4 class="text-white text-xs font-bold uppercase tracking-wider mb-3.5">Trung tâm hỗ trợ</h4>
          <ul class="space-y-2 text-xs">
            <li class="flex items-center gap-2"><i class="ri-map-pin-2-line text-[#0D9488]"></i> TP. Hồ Chí Minh, Việt Nam</li>
            <li class="flex items-center gap-2"><i class="ri-mail-line text-[#0D9488]"></i> hotro@hethongtro.vn</li>
            <li class="flex items-center gap-2"><i class="ri-phone-line text-[#0D9488]"></i> Hotline: 1900 8888 (24/7)</li>
            <li class="pt-1 text-[11px] text-stone-500">Khuyến cáo: Luôn xem phòng trực tiếp trước khi giao dịch tiền cọc.</li>
          </ul>
        </div>
      </div>

      <div class="pt-6 border-t border-stone-800 flex flex-col sm:flex-row items-center justify-between gap-3 text-[11px] text-stone-500">
        <p>© {{ date('Y') }} Hệ Thống Trọ. Nền tảng bất động sản cho thuê trực tuyến. Bảo lưu mọi quyền.</p>
        <div class="flex items-center gap-5">
          <a href="#" class="hover:text-stone-400 transition">Quy chế hoạt động</a>
          <a href="#" class="hover:text-stone-400 transition">Chính sách bảo mật</a>
          <a href="#" class="hover:text-stone-400 transition">Giải quyết tranh chấp</a>
        </div>
      </div>
    </div>
  </footer>

  {{-- 🌙 Dark Mode Script --}}
  <script>
    function darkMode() {
      return {
        isDark: false,
        init() {
          const saved = localStorage.getItem('darkMode');
          this.isDark = saved ? JSON.parse(saved) : window.matchMedia('(prefers-color-scheme: dark)').matches;
          this.applyMode();
        },
        toggleDark() {
          this.isDark = !this.isDark;
          localStorage.setItem('darkMode', JSON.stringify(this.isDark));
          this.applyMode();
        },
        applyMode() {
          document.documentElement.classList.toggle('dark', this.isDark);
        }
      }
    }

    document.addEventListener("DOMContentLoaded", () => {
      // 1. Mark motion ready for progressive enhancement
      document.documentElement.dataset.motionReady = "true";

      // 2. Scroll-triggered reveal system
      const reveals = document.querySelectorAll(".motion-reveal, .reveal, .reveal-left, .reveal-right");
      if ("IntersectionObserver" in window) {
        const revealObserver = new IntersectionObserver(entries => {
          entries.forEach(entry => {
            if (entry.isIntersecting) {
              entry.target.classList.add("is-revealed", "active");
              revealObserver.unobserve(entry.target);
            }
          });
        }, { threshold: 0.12, rootMargin: "0px 0px -30px 0px" });

        reveals.forEach(el => revealObserver.observe(el));
      } else {
        // Fallback for older browsers
        reveals.forEach(el => el.classList.add("is-revealed", "active"));
      }

      // 3. Smooth Counter Animation for Operational Metrics
      const counterEls = document.querySelectorAll("[data-counter]");
      if (counterEls.length > 0 && "IntersectionObserver" in window) {
        const counterObserver = new IntersectionObserver(entries => {
          entries.forEach(entry => {
            if (entry.isIntersecting) {
              const el = entry.target;
              counterObserver.unobserve(el);

              const rawTarget = el.getAttribute("data-counter");
              const targetVal = parseFloat(rawTarget) || 0;
              const suffix = el.getAttribute("data-suffix") || "";
              const prefix = el.getAttribute("data-prefix") || "";
              const duration = parseInt(el.getAttribute("data-duration")) || 1200;
              const isInt = !rawTarget.includes(".");

              let startTimestamp = null;
              const step = (timestamp) => {
                if (!startTimestamp) startTimestamp = timestamp;
                const progress = Math.min((timestamp - startTimestamp) / duration, 1);
                // Ease Out Cubic
                const easeOut = 1 - Math.pow(1 - progress, 3);
                const currentVal = easeOut * targetVal;

                let formatted = isInt
                  ? Math.round(currentVal).toLocaleString("vi-VN")
                  : currentVal.toFixed(1);

                el.textContent = `${prefix}${formatted}${suffix}`;

                if (progress < 1) {
                  window.requestAnimationFrame(step);
                } else {
                  el.textContent = `${prefix}${isInt ? targetVal.toLocaleString("vi-VN") : targetVal}${suffix}`;
                }
              };
              window.requestAnimationFrame(step);
            }
          });
        }, { threshold: 0.2 });

        counterEls.forEach(el => counterObserver.observe(el));
      }

      // 4. Header Elevation On Scroll
      const header = document.querySelector("header");
      if (header) {
        const checkHeader = () => {
          if (window.scrollY > 20) {
            header.classList.add("header-scrolled");
          } else {
            header.classList.remove("header-scrolled");
          }
        };
        window.addEventListener("scroll", checkHeader, { passive: true });
        checkHeader();
      }

      // 5. Back To Top Button
      const backToTopBtn = document.getElementById("backToTopBtn");
      if (backToTopBtn) {
        window.addEventListener("scroll", () => {
          if (window.scrollY > 400) {
            backToTopBtn.classList.add("visible");
          } else {
            backToTopBtn.classList.remove("visible");
          }
        }, { passive: true });

        backToTopBtn.addEventListener("click", () => {
          window.scrollTo({ top: 0, behavior: "smooth" });
        });
      }

      // 6. Global Top Progress on Page Navigation
      const topProgress = document.getElementById("global-top-progress");
      if (topProgress) {
        document.addEventListener("click", (e) => {
          const a = e.target.closest("a");
          if (!a || !a.href || a.target === "_blank" || a.hasAttribute("download")) return;
          if (e.metaKey || e.ctrlKey || e.shiftKey || e.altKey) return;
          if (a.href.startsWith("javascript:") || (a.href.includes("#") && a.pathname === window.location.pathname)) return;
          if (a.href.startsWith(window.location.origin)) {
            topProgress.classList.remove("finished");
            topProgress.classList.add("loading");
          }
        });
        window.addEventListener("pageshow", () => {
          topProgress.classList.add("finished");
          setTimeout(() => {
            topProgress.classList.remove("loading", "finished");
          }, 350);
        });
      }
    });
  </script>

  @stack('scripts')
  @if (session('js_token'))
    <script>
      localStorage.setItem("token", "{{ session('js_token') }}");
    </script>
  @endif


  <script src="//unpkg.com/alpinejs" defer></script>
  <script>
    window.API_URL = "{{ env('API_URL', 'http://127.0.0.1:8000/api') }}";
    console.log('✅ API_URL =', window.API_URL);
  </script>

  @if (!empty(session('user')) && (session('user')['vai_tro'] ?? null) === 'khach_thue')
    <script>
      const API_BASE_URL = "{{ env('API_BASE_URL', 'http://127.0.0.1:8000') }}/api";

      document.addEventListener('DOMContentLoaded', () => {
        capNhatSoLuongYeuThich();
      });

      async function capNhatSoLuongYeuThich() {
        const token = localStorage.getItem('token') || getCookie('api_token');
        if (!token) return;

        try {
          const res = await fetch(`${API_BASE_URL}/khach-thue/yeu-thich`, {
            headers: { 'Authorization': `Bearer ${token}` }
          });

          if (!res.ok) return;

          const data = await res.json();
          const count = data.data?.length ?? 0;
          const badge = document.getElementById('favorite-count');
          if (!badge) return;

          if (count > 0) {
            badge.textContent = count;
            badge.classList.remove('hidden');
          } else {
            badge.classList.add('hidden');
          }
        } catch (err) {
          console.warn('Không thể lấy danh sách yêu thích:', err);
        }
      }

      function getCookie(name) {
        const match = document.cookie.match(new RegExp('(^| )' + name + '=([^;]+)'));
        return match ? match[2] : null;
      }
    </script>
  @endif

  {{-- 🚀 Floating Back to Top Button --}}
  <button id="backToTopBtn" type="button" aria-label="Cuộn lên đầu trang"
    class="fixed bottom-6 right-6 z-40 w-11 h-11 rounded-full bg-white dark:bg-[#1E2320] text-[#0D9488] dark:text-[#5EEAD4] shadow-lg shadow-teal-900/10 border border-[#CCFBF1] dark:border-[#2D3330] flex items-center justify-center hover:bg-[#0D9488] hover:text-white dark:hover:bg-[#0D9488] dark:hover:text-white transition-all cursor-pointer focus:outline-none focus:ring-2 focus:ring-[#0D9488]/40">
    <i class="ri-arrow-up-line text-xl"></i>
  </button>

</body>

</html>