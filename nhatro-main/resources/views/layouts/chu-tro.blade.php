<!DOCTYPE html>
<html lang="vi" class="h-full" :class="{ 'dark': darkMode }" x-data="{ mobileNav: false, darkMode: localStorage.theme === 'dark' }">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title', 'Cổng Quản Trị Chủ Nhà - Hệ Thống Trọ')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/Logo.png') }}">
    <link rel="shortcut icon" href="{{ asset('images/Logo.png') }}">

    {{-- Fonts: Plus Jakarta Sans --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@400;500;600;700;800;900&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    {{-- Tailwind + AlpineJS --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'Inter', 'sans-serif'],
                        serif: ['"Be Vietnam Pro"', '"Plus Jakarta Sans"', 'sans-serif'],
                    },
                    colors: {
                        primary: {
                            50: '#F4F7F5',
                            100: '#E5EDE8',
                            200: '#C7D9CE',
                            300: '#9FBFA9',
                            400: '#6FA082',
                            500: '#3D7A5C',
                            600: '#244B3B',
                            700: '#1B3D2F',
                            800: '#142E23',
                            900: '#0E2018',
                        },
                        charcoal: {
                            50: '#F6F6F5',
                            100: '#E7E7E5',
                            200: '#D1D1CD',
                            700: '#373A35',
                            800: '#202421',
                            900: '#171A19',
                        },
                        bone: {
                            50: '#FAF9F6',
                            100: '#F4F2EC',
                            200: '#E5E3DC',
                        },
                        bronze: {
                            500: '#A6824D',
                            600: '#8E6E3F',
                        }
                    },
                    boxShadow: {
                        '2xs': '0 1px 2px 0 rgba(0, 0, 0, 0.05)',
                        'subtle': '0 2px 8px -2px rgba(27, 61, 47, 0.08)',
                    }
                }
            }
        }
    </script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    {{-- Remix Icons --}}
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.3.0/fonts/remixicon.css" rel="stylesheet">

    {{-- Preload Chart.js --}}
    <link rel="preload" as="script" href="https://cdn.jsdelivr.net/npm/chart.js">

    <style>
        :root {
            --motion-timing-fast: 180ms;
            --motion-timing-base: 280ms;
            --motion-timing-slow: 480ms;
            --motion-ease-spring: cubic-bezier(0.16, 1, 0.3, 1);
            --motion-ease-smooth: cubic-bezier(0.4, 0, 0.2, 1);
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        /* 🎬 Scroll & Page Reveal System */
        html[data-motion-ready="true"] .motion-reveal {
            opacity: 0;
            transform: translateY(16px);
            transition: opacity var(--motion-timing-slow) var(--motion-ease-smooth),
                        transform var(--motion-timing-slow) var(--motion-ease-spring);
            will-change: opacity, transform;
        }

        html[data-motion-ready="true"] .motion-reveal.is-revealed {
            opacity: 1;
            transform: translateY(0);
        }

        .motion-stagger-1 { transition-delay: 40ms !important; }
        .motion-stagger-2 { transition-delay: 90ms !important; }
        .motion-stagger-3 { transition-delay: 140ms !important; }
        .motion-stagger-4 { transition-delay: 190ms !important; }
        .motion-stagger-5 { transition-delay: 240ms !important; }
        .motion-stagger-6 { transition-delay: 290ms !important; }

        /* ⚡ Micro-Interactions */
        .micro-press {
            transition: transform 0.15s var(--motion-ease-spring);
        }
        .micro-press:active {
            transform: scale(0.97);
        }

        .card-lift-hover {
            transition: transform 0.25s var(--motion-ease-spring), box-shadow 0.25s var(--motion-ease-spring), border-color 0.25s var(--motion-ease-spring);
        }
        .card-lift-hover:hover {
            transform: translateY(-3px);
        }

        .table-row-hover {
            transition: background-color 0.16s var(--motion-ease-smooth);
        }
        .table-row-hover:hover {
            background-color: rgba(244, 247, 245, 0.8);
        }
        html.dark .table-row-hover:hover {
            background-color: rgba(36, 75, 59, 0.2);
        }

        /* 🪟 Modals & Dialogs */
        .modal-backdrop-animate {
            animation: modalBackdropFadeIn 0.24s var(--motion-ease-smooth) forwards;
        }
        .modal-panel-animate {
            animation: modalPanelScaleUp 0.28s var(--motion-ease-spring) forwards;
        }
        @keyframes modalBackdropFadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        @keyframes modalPanelScaleUp {
            from { opacity: 0; transform: scale(0.96) translateY(10px); }
            to { opacity: 1; transform: scale(1) translateY(0); }
        }

        /* 🏷️ Badge Pulse */
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

        /* 🚥 Top Loading Bar */
        #global-top-progress {
            position: fixed;
            top: 0;
            left: 0;
            height: 3px;
            background: linear-gradient(90deg, #1B3D2F, #3D7A5C, #6FA082);
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

        /* 🚀 Floating Back to Top Button */
        #backToTopBtn {
            opacity: 0;
            visibility: hidden;
            transform: translateY(12px) scale(0.92);
            transition: opacity 0.25s var(--motion-ease-smooth), transform 0.25s var(--motion-ease-spring), visibility 0.25s;
        }
        #backToTopBtn.visible {
            opacity: 1;
            visibility: visible;
            transform: translateY(0) scale(1);
        }

        @keyframes bell-ring {
            0% { transform: rotate(0); }
            15% { transform: rotate(12deg); }
            30% { transform: rotate(-10deg); }
            45% { transform: rotate(8deg); }
            60% { transform: rotate(-6deg); }
            75% { transform: rotate(3deg); }
            100% { transform: rotate(0); }
        }

        .bell-shake {
            animation: bell-ring 1.4s ease-in-out infinite;
            transform-origin: top center;
            display: inline-block;
        }

        /* Custom subtle scrollbar */
        ::-webkit-scrollbar {
            width: 5px;
            height: 5px;
        }
        ::-webkit-scrollbar-track {
            background: transparent;
        }
        ::-webkit-scrollbar-thumb {
            background: #D1D1CD;
            border-radius: 9999px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #9FBFA9;
        }
        .dark ::-webkit-scrollbar-thumb {
            background: #373A35;
        }

        /* 📄 Smooth Page Level Enter */
        .page-enter-fade {
            animation: pageFadeIn 0.22s var(--motion-ease-smooth) forwards;
        }
        @keyframes pageFadeIn {
            from {
                opacity: 0;
                transform: translateY(4px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* 🖋️ Unified Form Input Focus States */
        .input-focus-smooth {
            transition: border-color var(--motion-timing-fast) var(--motion-ease-smooth),
                        box-shadow var(--motion-timing-fast) var(--motion-ease-smooth),
                        background-color var(--motion-timing-fast) var(--motion-ease-smooth);
        }
        .input-focus-smooth:focus {
            outline: none;
            border-color: #1B3D2F !important;
            box-shadow: 0 0 0 3px rgba(27, 61, 47, 0.15) !important;
        }
        html.dark .input-focus-smooth:focus {
            border-color: #6FA082 !important;
            box-shadow: 0 0 0 3px rgba(111, 160, 130, 0.2) !important;
        }

        /* 🌟 Unified Button Hover Glow */
        .btn-glow-primary {
            transition: transform var(--motion-timing-fast) var(--motion-ease-spring),
                        box-shadow var(--motion-timing-fast) var(--motion-ease-smooth),
                        background-color var(--motion-timing-fast) var(--motion-ease-smooth);
        }
        .btn-glow-primary:hover {
            box-shadow: 0 4px 14px -1px rgba(27, 61, 47, 0.35);
            transform: translateY(-1px);
        }
        .btn-glow-primary:active {
            transform: translateY(0) scale(0.98);
        }

        /* 💀 Loading Skeleton Wave */
        .skeleton-shimmer {
            background: linear-gradient(90deg, rgba(229, 227, 220, 0.6) 25%, rgba(250, 249, 246, 0.9) 50%, rgba(229, 227, 220, 0.6) 75%);
            background-size: 200% 100%;
            animation: shimmerWave 1.6s infinite;
        }
        html.dark .skeleton-shimmer {
            background: linear-gradient(90deg, rgba(32, 36, 33, 0.6) 25%, rgba(55, 58, 53, 0.9) 50%, rgba(32, 36, 33, 0.6) 75%);
            background-size: 200% 100%;
        }
        @keyframes shimmerWave {
            0% { background-position: 200% 0; }
            100% { background-position: -200% 0; }
        }

        /* 🔔 SweetAlert2 Custom Styling for Landlord Portal */
        .swal2-popup {
            border-radius: 1rem !important;
            font-family: inherit !important;
            padding: 1.5rem !important;
        }
        html.dark .swal2-popup {
            background: #181B19 !important;
            color: #EAE8E1 !important;
            border: 1px solid #282D2A !important;
        }
        .swal2-confirm {
            background-color: #1B3D2F !important;
            border-radius: 0.5rem !important;
            font-weight: 600 !important;
            font-size: 0.875rem !important;
            padding: 0.625rem 1.25rem !important;
        }

        /* ♿ Accessibility: prefers-reduced-motion */
        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after {
                animation-duration: 0.01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: 0.01ms !important;
                scroll-behavior: auto !important;
            }
            html[data-motion-ready="true"] .motion-reveal {
                opacity: 1 !important;
                transform: none !important;
                transition: none !important;
            }
            .page-enter-fade {
                animation: none !important;
                opacity: 1 !important;
                transform: none !important;
            }
            .bell-shake {
                animation: none !important;
            }
        }
    </style>
</head>

<body class="bg-[#FAF9F6] dark:bg-[#121413] text-[#202421] dark:text-[#EAE8E1] flex min-h-screen antialiased selection:bg-[#1B3D2F] selection:text-white">

    {{-- 🚥 Top Loading Bar --}}
    <div id="global-top-progress"></div>

    {{-- SIDEBAR DESKTOP --}}
    <aside
        class="hidden lg:flex w-72 bg-white dark:bg-[#181B19] border-r border-[#E5E3DC] dark:border-[#282D2A] flex-col sticky top-0 h-screen z-30 transition-colors duration-200">
        
        {{-- Brand / Logo --}}
        <div class="px-6 py-5 border-b border-[#E5E3DC] dark:border-[#282D2A] flex items-center justify-between">
            <a href="{{ route('chu-tro.dashboard') }}" class="flex items-center space-x-3 group">
                <img src="{{ asset('images/Logo.png') }}" alt="Logo" class="h-9 w-auto object-contain transition-transform group-hover:scale-105" onerror="this.style.display='none'; this.nextElementSibling.classList.remove('hidden');">
                <div class="hidden w-9 h-9 rounded-lg bg-[#1B3D2F] flex items-center justify-center text-white font-bold text-sm shadow-2xs">
                    CT
                </div>
                <div>
                    <span class="text-sm font-black tracking-tight text-[#171A19] dark:text-white flex items-center gap-1.5">
                        Hệ Thống Trọ
                        <span class="text-[9px] font-bold px-1.5 py-0.5 rounded bg-[#E5EDE8] dark:bg-[#23352B] text-[#1B3D2F] dark:text-[#8BB39D] uppercase tracking-wider">Chủ Nhà</span>
                    </span>
                    <p class="text-[11px] text-[#85877F] dark:text-[#85877F] font-medium">Cổng vận hành bất động sản</p>
                </div>
            </a>

            {{-- Nút về trang chủ --}}
            <a href="{{ url('/') }}" class="w-8 h-8 rounded-lg flex items-center justify-center text-[#85877F] hover:text-[#1B3D2F] dark:hover:text-white hover:bg-[#FAF9F6] dark:hover:bg-[#222724] transition border border-transparent hover:border-[#E5E3DC] dark:hover:border-[#282D2A]"
                title="Về trang chủ công khai">
                <i class="ri-arrow-left-up-line text-base"></i>
            </a>
        </div>

        {{-- Navigation Menu --}}
        <nav class="flex-1 px-3.5 py-4 space-y-6 overflow-y-auto text-xs sm:text-sm font-medium">
            @php 
                $cur = request()->route()?->getName() ?? ''; 
                
                function isNavActive($cur, $prefixes) {
                    foreach ((array)$prefixes as $p) {
                        if (str_starts_with($cur, $p)) return true;
                    }
                    return false;
                }
            @endphp

            {{-- Nhóm 1: Tổng quan --}}
            <div>
                <p class="px-3 mb-2 text-[10px] font-bold uppercase tracking-wider text-[#85877F] dark:text-[#6C706B]">Vận hành chính</p>
                <div class="space-y-1">
                    <a href="{{ route('chu-tro.dashboard') }}"
                        class="flex items-center px-3.5 py-2.5 rounded-lg transition-all duration-150
                        {{ isNavActive($cur, 'chu-tro.dashboard') 
                            ? 'bg-[#1B3D2F] text-white font-bold shadow-2xs' 
                            : 'text-[#4A4E4B] dark:text-[#C5C8C4] hover:bg-[#FAF9F6] dark:hover:bg-[#222724] hover:text-[#171A19] dark:hover:text-white' }}">
                        <i class="ri-dashboard-3-line mr-3 text-base {{ isNavActive($cur, 'chu-tro.dashboard') ? 'text-white' : 'text-[#85877F]' }}"></i>
                        <span>Bảng điều khiển</span>
                    </a>
                </div>
            </div>

            {{-- Nhóm 2: Quản lý phòng trọ --}}
            <div>
                <p class="px-3 mb-2 text-[10px] font-bold uppercase tracking-wider text-[#85877F] dark:text-[#6C706B]">Bất động sản & Phòng</p>
                <div class="space-y-1">
                    <a href="{{ route('chu-tro.day-tro.index') }}"
                        class="flex items-center px-3.5 py-2.5 rounded-lg transition-all duration-150
                        {{ isNavActive($cur, 'chu-tro.day-tro') 
                            ? 'bg-[#1B3D2F] text-white font-bold shadow-2xs' 
                            : 'text-[#4A4E4B] dark:text-[#C5C8C4] hover:bg-[#FAF9F6] dark:hover:bg-[#222724] hover:text-[#171A19] dark:hover:text-white' }}">
                        <i class="ri-community-line mr-3 text-base {{ isNavActive($cur, 'chu-tro.day-tro') ? 'text-white' : 'text-[#85877F]' }}"></i>
                        <span>Khu / Dãy trọ</span>
                    </a>

                    <a href="{{ route('chu-tro.phong.index') }}"
                        class="flex items-center px-3.5 py-2.5 rounded-lg transition-all duration-150
                        {{ isNavActive($cur, 'chu-tro.phong') 
                            ? 'bg-[#1B3D2F] text-white font-bold shadow-2xs' 
                            : 'text-[#4A4E4B] dark:text-[#C5C8C4] hover:bg-[#FAF9F6] dark:hover:bg-[#222724] hover:text-[#171A19] dark:hover:text-white' }}">
                        <i class="ri-door-line mr-3 text-base {{ isNavActive($cur, 'chu-tro.phong') ? 'text-white' : 'text-[#85877F]' }}"></i>
                        <span>Danh sách phòng</span>
                    </a>

                    <a href="{{ route('chu-tro.bai-dang.index') }}"
                        class="flex items-center px-3.5 py-2.5 rounded-lg transition-all duration-150
                        {{ isNavActive($cur, 'chu-tro.bai-dang') 
                            ? 'bg-[#1B3D2F] text-white font-bold shadow-2xs' 
                            : 'text-[#4A4E4B] dark:text-[#C5C8C4] hover:bg-[#FAF9F6] dark:hover:bg-[#222724] hover:text-[#171A19] dark:hover:text-white' }}">
                        <i class="ri-megaphone-line mr-3 text-base {{ isNavActive($cur, 'chu-tro.bai-dang') ? 'text-white' : 'text-[#85877F]' }}"></i>
                        <span>Tin đăng thị trường</span>
                    </a>
                </div>
            </div>

            {{-- Nhóm 3: Khách thuê & Hợp đồng --}}
            <div>
                <p class="px-3 mb-2 text-[10px] font-bold uppercase tracking-wider text-[#85877F] dark:text-[#6C706B]">Khách thuê & Thủ tục</p>
                <div class="space-y-1">
                    <a href="{{ route('chu-tro.yeu-cau-thue.index') }}"
                        class="flex items-center px-3.5 py-2.5 rounded-lg transition-all duration-150
                        {{ isNavActive($cur, 'chu-tro.yeu-cau-thue') 
                            ? 'bg-[#1B3D2F] text-white font-bold shadow-2xs' 
                            : 'text-[#4A4E4B] dark:text-[#C5C8C4] hover:bg-[#FAF9F6] dark:hover:bg-[#222724] hover:text-[#171A19] dark:hover:text-white' }}">
                        <i class="ri-user-shared-line mr-3 text-base {{ isNavActive($cur, 'chu-tro.yeu-cau-thue') ? 'text-white' : 'text-[#85877F]' }}"></i>
                        <span>Yêu cầu thuê mới</span>
                    </a>

                    <a href="{{ route('chu-tro.khachthue.index') }}"
                        class="flex items-center px-3.5 py-2.5 rounded-lg transition-all duration-150
                        {{ isNavActive($cur, 'chu-tro.khachthue') 
                            ? 'bg-[#1B3D2F] text-white font-bold shadow-2xs' 
                            : 'text-[#4A4E4B] dark:text-[#C5C8C4] hover:bg-[#FAF9F6] dark:hover:bg-[#222724] hover:text-[#171A19] dark:hover:text-white' }}">
                        <i class="ri-group-line mr-3 text-base {{ isNavActive($cur, 'chu-tro.khachthue') ? 'text-white' : 'text-[#85877F]' }}"></i>
                        <span>Khách thuê hiện tại</span>
                    </a>

                    <a href="{{ route('chu-tro.hop-dong.index') }}"
                        class="flex items-center px-3.5 py-2.5 rounded-lg transition-all duration-150
                        {{ isNavActive($cur, 'chu-tro.hop-dong') 
                            ? 'bg-[#1B3D2F] text-white font-bold shadow-2xs' 
                            : 'text-[#4A4E4B] dark:text-[#C5C8C4] hover:bg-[#FAF9F6] dark:hover:bg-[#222724] hover:text-[#171A19] dark:hover:text-white' }}">
                        <i class="ri-file-text-line mr-3 text-base {{ isNavActive($cur, 'chu-tro.hop-dong') ? 'text-white' : 'text-[#85877F]' }}"></i>
                        <span>Hợp đồng điện tử</span>
                    </a>

                    <a href="{{ route('chu-tro.nguoi-than.index') }}"
                        class="flex items-center px-3.5 py-2.5 rounded-lg transition-all duration-150
                        {{ isNavActive($cur, 'chu-tro.nguoi-than') 
                            ? 'bg-[#1B3D2F] text-white font-bold shadow-2xs' 
                            : 'text-[#4A4E4B] dark:text-[#C5C8C4] hover:bg-[#FAF9F6] dark:hover:bg-[#222724] hover:text-[#171A19] dark:hover:text-white' }}">
                        <i class="ri-parent-line mr-3 text-base {{ isNavActive($cur, 'chu-tro.nguoi-than') ? 'text-white' : 'text-[#85877F]' }}"></i>
                        <span>Người cùng lưu trú</span>
                    </a>
                </div>
            </div>

            {{-- Nhóm 4: Tài chính & Tiện ích --}}
            <div>
                <p class="px-3 mb-2 text-[10px] font-bold uppercase tracking-wider text-[#85877F] dark:text-[#6C706B]">Tài chính & Dịch vụ</p>
                <div class="space-y-1">
                    <a href="{{ route('chu-tro.dien-nuoc.index') }}"
                        class="flex items-center px-3.5 py-2.5 rounded-lg transition-all duration-150
                        {{ isNavActive($cur, 'chu-tro.dien-nuoc') 
                            ? 'bg-[#1B3D2F] text-white font-bold shadow-2xs' 
                            : 'text-[#4A4E4B] dark:text-[#C5C8C4] hover:bg-[#FAF9F6] dark:hover:bg-[#222724] hover:text-[#171A19] dark:hover:text-white' }}">
                        <i class="ri-flashlight-line mr-3 text-base {{ isNavActive($cur, 'chu-tro.dien-nuoc') ? 'text-white' : 'text-[#85877F]' }}"></i>
                        <span>Ghi số điện nước</span>
                    </a>

                    <a href="{{ route('chu-tro.dich-vu.index') }}"
                        class="flex items-center px-3.5 py-2.5 rounded-lg transition-all duration-150
                        {{ isNavActive($cur, 'chu-tro.dich-vu') 
                            ? 'bg-[#1B3D2F] text-white font-bold shadow-2xs' 
                            : 'text-[#4A4E4B] dark:text-[#C5C8C4] hover:bg-[#FAF9F6] dark:hover:bg-[#222724] hover:text-[#171A19] dark:hover:text-white' }}">
                        <i class="ri-service-line mr-3 text-base {{ isNavActive($cur, 'chu-tro.dich-vu') ? 'text-white' : 'text-[#85877F]' }}"></i>
                        <span>Danh mục dịch vụ</span>
                    </a>

                    <a href="{{ route('chu-tro.hoa-don.index') }}"
                        class="flex items-center px-3.5 py-2.5 rounded-lg transition-all duration-150
                        {{ isNavActive($cur, 'chu-tro.hoa-don') 
                            ? 'bg-[#1B3D2F] text-white font-bold shadow-2xs' 
                            : 'text-[#4A4E4B] dark:text-[#C5C8C4] hover:bg-[#FAF9F6] dark:hover:bg-[#222724] hover:text-[#171A19] dark:hover:text-white' }}">
                        <i class="ri-bill-line mr-3 text-base {{ isNavActive($cur, 'chu-tro.hoa-don') ? 'text-white' : 'text-[#85877F]' }}"></i>
                        <span>Hóa đơn thu tiền</span>
                    </a>
                </div>
            </div>
        </nav>

        {{-- Bottom User Profile & Logout --}}
        <div class="p-3.5 border-t border-[#E5E3DC] dark:border-[#282D2A] bg-[#FAF9F6]/80 dark:bg-[#181B19]">
            <div class="flex items-center justify-between">
                <a href="{{ route('chu-tro.profile.show') }}" class="flex items-center space-x-2.5 overflow-hidden group">
                    <img src="{{ session('user')['anh_dai_dien'] ?? '/images/default-avatar.png' }}"
                        class="w-8 h-8 rounded-lg ring-1 ring-[#E5E3DC] dark:ring-[#282D2A] object-cover shrink-0"
                        alt="Avatar" onerror="this.src='/images/default-avatar.png';">
                    <div class="truncate">
                        <p class="text-xs font-bold text-[#171A19] dark:text-white truncate group-hover:text-[#1B3D2F] transition-colors">{{ session('user')['ho_ten'] ?? 'Chủ trọ' }}</p>
                        <p class="text-[10px] text-[#85877F] truncate">{{ session('user')['email'] ?? 'Chủ nhà' }}</p>
                    </div>
                </a>

                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" title="Đăng xuất"
                        class="w-7 h-7 rounded-md flex items-center justify-center text-[#85877F] hover:text-rose-600 hover:bg-rose-50 dark:hover:bg-rose-950/30 transition">
                        <i class="ri-logout-box-r-line text-sm"></i>
                    </button>
                </form>
            </div>
        </div>
    </aside>

    {{-- MOBILE DRAWER --}}
    <div x-show="mobileNav" x-cloak class="fixed inset-0 z-50 lg:hidden" role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-black/50 backdrop-blur-xs transition-opacity" @click="mobileNav = false"></div>
        <div class="fixed inset-y-0 left-0 w-72 bg-white dark:bg-[#181B19] border-r border-[#E5E3DC] dark:border-[#282D2A] p-4 flex flex-col justify-between shadow-xl">
            <div>
                <div class="flex items-center justify-between pb-4 border-b border-[#E5E3DC] dark:border-[#282D2A]">
                    <div class="flex items-center gap-2.5">
                        <div class="w-8 h-8 rounded-lg bg-[#1B3D2F] flex items-center justify-center text-white font-bold text-xs">
                            CT
                        </div>
                        <span class="text-sm font-extrabold text-[#171A19] dark:text-white">Cổng Chủ Nhà</span>
                    </div>
                    <button @click="mobileNav = false" class="p-1 rounded-md text-[#85877F] hover:bg-[#FAF9F6] dark:hover:bg-[#222724]">
                        <i class="ri-close-line text-xl"></i>
                    </button>
                </div>
                <nav class="mt-4 space-y-1 text-xs font-medium">
                    <a href="{{ route('chu-tro.dashboard') }}" class="flex items-center px-3 py-2 rounded-lg text-[#171A19] dark:text-white hover:bg-[#FAF9F6] dark:hover:bg-[#222724]">
                        <i class="ri-dashboard-3-line mr-2.5 text-base text-[#85877F]"></i> Bảng điều khiển
                    </a>
                    <a href="{{ route('chu-tro.day-tro.index') }}" class="flex items-center px-3 py-2 rounded-lg text-[#171A19] dark:text-white hover:bg-[#FAF9F6] dark:hover:bg-[#222724]">
                        <i class="ri-community-line mr-2.5 text-base text-[#85877F]"></i> Khu / Dãy trọ
                    </a>
                    <a href="{{ route('chu-tro.phong.index') }}" class="flex items-center px-3 py-2 rounded-lg text-[#171A19] dark:text-white hover:bg-[#FAF9F6] dark:hover:bg-[#222724]">
                        <i class="ri-door-line mr-2.5 text-base text-[#85877F]"></i> Danh sách phòng
                    </a>
                    <a href="{{ route('chu-tro.bai-dang.index') }}" class="flex items-center px-3 py-2 rounded-lg text-[#171A19] dark:text-white hover:bg-[#FAF9F6] dark:hover:bg-[#222724]">
                        <i class="ri-megaphone-line mr-2.5 text-base text-[#85877F]"></i> Tin đăng thị trường
                    </a>
                    <a href="{{ route('chu-tro.yeu-cau-thue.index') }}" class="flex items-center px-3 py-2 rounded-lg text-[#171A19] dark:text-white hover:bg-[#FAF9F6] dark:hover:bg-[#222724]">
                        <i class="ri-user-shared-line mr-2.5 text-base text-[#85877F]"></i> Yêu cầu thuê mới
                    </a>
                    <a href="{{ route('chu-tro.khachthue.index') }}" class="flex items-center px-3 py-2 rounded-lg text-[#171A19] dark:text-white hover:bg-[#FAF9F6] dark:hover:bg-[#222724]">
                        <i class="ri-group-line mr-2.5 text-base text-[#85877F]"></i> Khách thuê
                    </a>
                    <a href="{{ route('chu-tro.hop-dong.index') }}" class="flex items-center px-3 py-2 rounded-lg text-[#171A19] dark:text-white hover:bg-[#FAF9F6] dark:hover:bg-[#222724]">
                        <i class="ri-file-text-line mr-2.5 text-base text-[#85877F]"></i> Hợp đồng điện tử
                    </a>
                    <a href="{{ route('chu-tro.dien-nuoc.index') }}" class="flex items-center px-3 py-2 rounded-lg text-[#171A19] dark:text-white hover:bg-[#FAF9F6] dark:hover:bg-[#222724]">
                        <i class="ri-flashlight-line mr-2.5 text-base text-[#85877F]"></i> Ghi điện nước
                    </a>
                    <a href="{{ route('chu-tro.hoa-don.index') }}" class="flex items-center px-3 py-2 rounded-lg text-[#171A19] dark:text-white hover:bg-[#FAF9F6] dark:hover:bg-[#222724]">
                        <i class="ri-bill-line mr-2.5 text-base text-[#85877F]"></i> Hóa đơn thu tiền
                    </a>
                </nav>
            </div>
            <div class="pt-4 border-t border-[#E5E3DC] dark:border-[#282D2A]">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full flex items-center justify-center gap-2 py-2 px-3 rounded-lg text-xs font-semibold text-rose-600 bg-rose-50 dark:bg-rose-950/20">
                        <i class="ri-logout-box-r-line"></i> Đăng xuất
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- MAIN CONTENT AREA --}}
    <div class="flex-1 flex flex-col min-w-0 overflow-y-auto">

        {{-- TOPBAR --}}
        <header class="sticky top-0 z-20 bg-white/90 dark:bg-[#181B19]/90 backdrop-blur-md border-b border-[#E5E3DC] dark:border-[#282D2A] px-4 sm:px-8 py-3.5 flex items-center justify-between transition-colors duration-200">
            <div class="flex items-center gap-3">
                <button @click="mobileNav = true" class="lg:hidden p-2 rounded-lg text-[#4A4E4B] hover:bg-[#FAF9F6] dark:hover:bg-[#222724]">
                    <i class="ri-menu-2-line text-lg"></i>
                </button>
                <div>
                    <h2 class="text-base font-extrabold text-[#171A19] dark:text-white tracking-tight">
                        @yield('header_title', 'Hệ thống Quản lý')
                    </h2>
                    <p class="text-[11px] text-[#85877F] dark:text-[#85877F]">@yield('header_subtitle', 'Theo dõi vận hành, tài chính và danh mục cho thuê')</p>
                </div>
            </div>

            <div class="flex items-center space-x-3">
                {{-- Quick Link Website --}}
                <a href="{{ route('listing') }}" target="_blank"
                    class="hidden md:inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold text-[#4A4E4B] dark:text-[#C5C8C4] bg-[#FAF9F6] dark:bg-[#222724] border border-[#E5E3DC] dark:border-[#282D2A] hover:border-[#1B3D2F] dark:hover:border-[#1B3D2F] transition">
                    <i class="ri-external-link-line"></i>
                    <span>Xem thị trường</span>
                </a>

                {{-- Dark Mode Toggle --}}
                <button @click="darkMode = !darkMode; localStorage.theme = darkMode ? 'dark' : 'light'"
                    class="w-9 h-9 rounded-lg border border-[#E5E3DC] dark:border-[#282D2A] bg-[#FAF9F6] dark:bg-[#222724] text-[#4A4E4B] dark:text-[#C5C8C4] flex items-center justify-center hover:text-[#1B3D2F] dark:hover:text-white transition">
                    <i :class="darkMode ? 'ri-sun-line text-amber-400' : 'ri-moon-line'"></i>
                </button>

                {{-- Notification Dropdown --}}
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" 
                        class="relative w-9 h-9 rounded-lg border border-[#E5E3DC] dark:border-[#282D2A] bg-[#FAF9F6] dark:bg-[#222724] hover:border-[#1B3D2F] flex items-center justify-center text-[#4A4E4B] dark:text-[#C5C8C4] transition">
                        <i class="ri-notification-3-line text-base 
                            {{ ($thong_bao_chua_xem ?? 0) > 0 ? 'bell-shake text-[#1B3D2F] dark:text-[#8BB39D]' : '' }}">
                        </i>
                        @if(($thong_bao_chua_xem ?? 0) > 0)
                            <span
                                class="absolute -top-1 -right-1 bg-[#1B3D2F] text-white text-[9px] font-bold w-4 h-4 flex items-center justify-center rounded-full">
                                {{ $thong_bao_chua_xem }}
                            </span>
                        @endif
                    </button>

                    {{-- Dropdown content --}}
                    <div x-show="open" @click.away="open = false" x-transition
                        class="absolute right-0 mt-2 w-84 bg-white dark:bg-[#181B19] shadow-xl rounded-xl border border-[#E5E3DC] dark:border-[#282D2A] z-50 overflow-hidden divide-y divide-[#E5E3DC] dark:divide-[#282D2A]"
                        style="width: 320px;">
                        <div class="p-3.5 flex items-center justify-between bg-[#FAF9F6] dark:bg-[#202522]">
                            <span class="font-bold text-[#171A19] dark:text-white text-xs">Thông báo vận hành</span>
                            <button onclick="markAllAsRead()" class="text-[11px] font-semibold text-[#1B3D2F] dark:text-[#8BB39D] hover:underline">
                                Đã đọc tất cả
                            </button>
                        </div>
                        <div class="max-h-72 overflow-y-auto divide-y divide-[#E5E3DC]/60 dark:divide-[#282D2A]">
                            @forelse($thong_bao ?? [] as $tb)
                                <div @click.stop="open = false"
                                    onclick="markAsRead({{ $tb->id }}, '{{ $tb->lien_ket ?? '#' }}')"
                                    class="block p-3 text-xs cursor-pointer transition 
                                        {{ $tb->da_xem ? 'bg-white dark:bg-[#181B19] opacity-60' : 'bg-[#E5EDE8]/40 dark:bg-[#202522] font-semibold hover:bg-[#E5EDE8]/70' }}">
                                    <p class="text-[#171A19] dark:text-[#EAE8E1] leading-relaxed">{{ $tb->noi_dung }}</p>
                                    <p class="text-[10px] text-[#85877F] mt-1 font-normal">
                                        {{ \Carbon\Carbon::parse($tb->ngay_tao)->diffForHumans() }}
                                    </p>
                                </div>
                            @empty
                                <div class="p-6 text-center text-[#85877F] text-xs">
                                    <i class="ri-checkbox-circle-line text-2xl text-[#85877F] block mb-1"></i>
                                    Không có thông báo mới nào
                                </div>
                            @endforelse
                        </div>
                        <div class="p-2.5 bg-[#FAF9F6] dark:bg-[#202522] flex justify-between items-center text-xs px-3.5">
                            <button onclick="xoaThongBaoDaDoc()" class="text-[#85877F] hover:text-rose-600 text-[11px]">
                                Xóa đã đọc
                            </button>
                            <a href="{{ route('chu-tro.thong-bao.index') }}"
                                class="font-bold text-[#1B3D2F] dark:text-[#8BB39D] text-[11px] hover:underline">
                                Xem tất cả &rarr;
                            </a>
                        </div>
                    </div>
                </div>

                {{-- User Avatar --}}
                <div class="flex items-center space-x-2.5 pl-2 border-l border-[#E5E3DC] dark:border-[#282D2A]">
                    <img src="{{ session('user')['anh_dai_dien'] ?? '/images/default-avatar.png' }}"
                        class="w-9 h-9 rounded-lg ring-1 ring-[#E5E3DC] dark:ring-[#282D2A] object-cover"
                        alt="Avatar" onerror="this.src='/images/default-avatar.png';">
                    <div class="hidden sm:block text-left">
                        <span class="text-xs font-bold text-[#171A19] dark:text-white block leading-tight">
                            {{ session('user')['ho_ten'] ?? 'Chủ trọ' }}
                        </span>
                        <span class="text-[10px] text-[#1B3D2F] dark:text-[#8BB39D] font-semibold">Tài khoản xác thực</span>
                    </div>
                </div>
            </div>
        </header>

        {{-- MAIN CONTENT --}}
        <main class="flex-1 p-4 sm:p-8 page-enter-fade">
            @yield('content')
        </main>

        {{-- FOOTER --}}
        <footer class="px-8 py-4 border-t border-[#E5E3DC] dark:border-[#282D2A] text-center text-xs text-[#85877F]">
            &copy; {{ date('Y') }} Hệ Thống Trọ - Nền tảng quản lý cho thuê bất động sản đô thị cao cấp.
        </footer>
    </div>

    {{-- SweetAlert2 Notification handlers --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @if (session('ok'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Thành công!',
                text: '{{ session('ok') }}',
                confirmButtonColor: '#1B3D2F'
            });
        </script>
    @endif

    @if (session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Lỗi!',
                text: '{{ session('error') }}',
                confirmButtonColor: '#B91C1C'
            });
        </script>
    @endif

    @if ($errors->any())
        <script>
            Swal.fire({
                icon: 'warning',
                title: 'Thiếu thông tin!',
                html: `{!! implode('<br>', $errors->all()) !!}`,
                confirmButtonColor: '#D97706'
            });
        </script>
    @endif

    @stack('scripts')
    <script src="https://js.pusher.com/8.2/pusher.min.js"></script>
    <script>
        const pusher = new Pusher("{{ env('PUSHER_APP_KEY') }}", {
            cluster: "{{ env('PUSHER_APP_CLUSTER') }}"
        });

        const channel = pusher.subscribe('chu-tro-thong-bao');
        channel.bind('ThongBaoMoi', function (data) {
            const bell = document.querySelector('.ri-notification-3-line');
            bell?.classList.add('bell-shake', 'text-[#1B3D2F]');

            let badge = document.querySelector('.bg-\\[\\#1B3D2F\\]');
            if (badge) {
                let current = parseInt(badge.textContent || "0");
                badge.textContent = current + 1;
            } else {
                const newBadge = document.createElement('span');
                newBadge.className =
                    "absolute -top-1 -right-1 bg-[#1B3D2F] text-white text-[9px] font-bold w-4 h-4 flex items-center justify-center rounded-full";
                newBadge.textContent = "1";
                bell?.parentNode?.appendChild(newBadge);
            }
            const list = document.querySelector('.max-h-72');
            if (list) {
                const item = document.createElement('a');
                item.href = data.thongBao?.lien_ket || '#';
                item.className = 'block p-3 text-xs bg-[#E5EDE8]/60 font-semibold hover:bg-[#E5EDE8] transition';
                item.innerHTML = `
                    <p class="text-[#171A19] leading-relaxed">${data.thongBao?.noi_dung || 'Bạn có thông báo mới'}</p>
                    <p class="text-[10px] text-[#1B3D2F] mt-1 font-normal">vừa xong</p>
                `;
                list.prepend(item);
            }
        });
    </script>
    <script>
        function markAsRead(id, link) {
            fetch(`/chu-tro/thong-bao/${id}/mark-as-read`, {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]')?.content,
                    "Accept": "application/json"
                }
            })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        const badge = document.querySelector('.bg-\\[\\#1B3D2F\\]');
                        if (badge) {
                            let current = parseInt(badge.textContent || "0");
                            if (current > 1) badge.textContent = current - 1;
                            else badge.remove();
                        }

                        const bell = document.querySelector('.ri-notification-3-line');
                        if (!badge || parseInt(badge.textContent || "0") <= 0) {
                            bell?.classList.remove('bell-shake', 'text-[#1B3D2F]');
                        }

                        if (link && link !== '#') window.location.href = link;
                    }
                })
                .catch(() => {
                    if (link && link !== '#') window.location.href = link;
                });
        }
    </script>
    <script>
        async function markAllAsRead() {
            try {
                const res = await fetch('/chu-tro/thong-bao/mark-all-read', {
                    method: 'POST',
                    headers: {
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
                        "Accept": "application/json"
                    }
                });

                const data = await res.json();

                if (data.success) {
                    document.querySelectorAll('.ri-notification-3-line').forEach(icon => {
                        icon.classList.remove('bell-shake', 'text-[#1B3D2F]');
                    });
                    document.querySelectorAll('.bg-\\[\\#1B3D2F\\]').forEach(el => el.remove());

                    document.querySelectorAll('.max-h-72 .bg-\\[\\#E5EDE8\\]\\/40').forEach(el => {
                        el.classList.remove('bg-[#E5EDE8]/40', 'font-semibold');
                        el.classList.add('bg-white', 'opacity-60');
                    });

                    Swal.fire({
                        icon: 'success',
                        title: 'Đã đọc tất cả',
                        text: data.message,
                        timer: 1500,
                        confirmButtonColor: '#1B3D2F',
                        showConfirmButton: false
                    });
                }
            } catch (err) {
                console.error('markAllAsRead error:', err);
                Swal.fire('Lỗi', 'Không thể đánh dấu tất cả thông báo là đã đọc.', 'error');
            }
        }
    </script>
    <script>
        async function xoaThongBaoDaDoc() {
            const confirm = await Swal.fire({
                icon: 'warning',
                title: 'Xóa tất cả thông báo đã đọc?',
                text: 'Các thông báo chưa đọc sẽ được giữ lại.',
                showCancelButton: true,
                confirmButtonText: 'Xóa luôn',
                cancelButtonText: 'Hủy',
                confirmButtonColor: '#B91C1C'
            });

            if (!confirm.isConfirmed) return;

            try {
                const res = await fetch('/chu-tro/thong-bao/xoa-da-doc', {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    }
                });

                const data = await res.json();

                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Đã xóa hoàn tất',
                        text: data.message,
                        timer: 1800,
                        confirmButtonColor: '#1B3D2F',
                        showConfirmButton: false
                    });

                    document.querySelectorAll('.max-h-72 .bg-white.opacity-60').forEach(el => el.remove());
                } else {
                    Swal.fire('Lỗi!', data.message || 'Không thể xóa thông báo.', 'error');
                }
            } catch (err) {
                console.error(err);
                Swal.fire('Lỗi!', 'Không thể kết nối máy chủ.', 'error');
            }
        }
    </script>

    {{-- 🚀 Floating Back to Top Button --}}
    <button id="backToTopBtn" type="button" aria-label="Cuộn lên đầu trang"
        class="fixed bottom-6 right-6 z-40 w-11 h-11 rounded-full bg-white dark:bg-[#1E2320] text-[#1B3D2F] dark:text-[#8BB39D] shadow-lg shadow-black/10 border border-[#E5E3DC] dark:border-[#2D3330] flex items-center justify-center hover:bg-[#1B3D2F] hover:text-white dark:hover:bg-[#1B3D2F] dark:hover:text-white transition-all cursor-pointer focus:outline-none focus:ring-2 focus:ring-[#1B3D2F]/40">
        <i class="ri-arrow-up-line text-xl"></i>
    </button>

    {{-- 🎬 Unified Motion Engine --}}
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            // 1. Enable motion CSS
            document.documentElement.dataset.motionReady = "true";

            // 2. IntersectionObserver for scroll reveals
            const revealObserver = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add("is-revealed");
                        observer.unobserve(entry.target);
                    }
                });
            }, {
                root: null,
                rootMargin: "0px 0px -40px 0px",
                threshold: 0.08
            });

            document.querySelectorAll(".motion-reveal").forEach(el => revealObserver.observe(el));

            // 3. Stats Counter Ticker Engine
            const counterObserver = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const el = entry.target;
                        observer.unobserve(el);

                        const targetStr = el.getAttribute("data-counter") || el.getAttribute("data-count") || el.textContent;
                        const match = targetStr.match(/\d[\d,.]*/);
                        if (!match) return;

                        const rawDigits = match[0].replace(/[^\d]/g, "");
                        const targetNum = parseInt(rawDigits, 10);
                        if (isNaN(targetNum) || targetNum <= 0) return;

                        const duration = 1200;
                        const startTime = performance.now();

                        const updateCounter = (currentTime) => {
                            const elapsed = currentTime - startTime;
                            const progress = Math.min(elapsed / duration, 1);
                            const easeOutProgress = 1 - Math.pow(1 - progress, 3);
                            const currentVal = Math.round(easeOutProgress * targetNum);

                            el.textContent = currentVal.toLocaleString('vi-VN');

                            if (progress < 1) {
                                requestAnimationFrame(updateCounter);
                            }
                        };

                        requestAnimationFrame(updateCounter);
                    }
                });
            }, { threshold: 0.2 });

            document.querySelectorAll("[data-counter], .count-up").forEach(el => counterObserver.observe(el));

            // 4. Back To Top Button
            const backToTopBtn = document.getElementById("backToTopBtn");
            if (backToTopBtn) {
                window.addEventListener("scroll", () => {
                    if (window.scrollY > 350) {
                        backToTopBtn.classList.add("visible");
                    } else {
                        backToTopBtn.classList.remove("visible");
                    }
                }, { passive: true });

                backToTopBtn.addEventListener("click", () => {
                    window.scrollTo({ top: 0, behavior: "smooth" });
                });
            }

            // 5. Global Top Progress on Page Navigation
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
</body>

</html>