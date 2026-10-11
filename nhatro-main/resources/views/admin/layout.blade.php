<!DOCTYPE html>
<html lang="vi" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Quản Trị Hệ Thống - Hệ Thống Trọ')</title>
    {{-- Favicon for admin area --}}
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/Logo.png') }}">
    <link rel="shortcut icon" href="{{ asset('images/Logo.png') }}">

    {{-- Fonts: Plus Jakarta Sans --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@400;500;600;700;800;900&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

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
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.3.0/fonts/remixicon.css" rel="stylesheet">
    <style>
        :root {
            --motion-timing-fast: 180ms;
            --motion-timing-base: 280ms;
            --motion-timing-slow: 480ms;
            --motion-ease-spring: cubic-bezier(0.16, 1, 0.3, 1);
            --motion-ease-smooth: cubic-bezier(0.4, 0, 0.2, 1);
        }

        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .scrollbar::-webkit-scrollbar{width:6px;height:6px}
        .scrollbar::-webkit-scrollbar-thumb{background:#373A35;border-radius:9999px}
        .scrollbar::-webkit-scrollbar-track{background:transparent}

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

        /* 🔽 Dropdowns */
        .dropdown-menu-animate {
            animation: dropdownSlideDown 0.2s var(--motion-ease-spring) forwards;
            transform-origin: top;
        }
        @keyframes dropdownSlideDown {
            from { opacity: 0; transform: translateY(-6px) scale(0.98); }
            to { opacity: 1; transform: translateY(0) scale(1); }
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
        @keyframes shimmerWave {
            0% { background-position: 200% 0; }
            100% { background-position: -200% 0; }
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
        }
    </style>
    @stack('head')
</head>
<body class="bg-[#FAF9F6] text-[#202421] min-h-screen antialiased selection:bg-[#1B3D2F] selection:text-white">
    {{-- 🚥 Top Loading Bar --}}
    <div id="global-top-progress"></div>
    <script>
      // Early-capture navigation handler: listen on pointerdown so we run before most click interceptors.
      (function(){
        function goToHref(el) {
          try {
            var a = el.closest && el.closest('.force-nav');
            if (!a) return false;
            var href = a.getAttribute('href');
            if (!href || href === '#') return false;
            window.location.href = href;
            return true;
          } catch(e) { console.debug('earlyNav error', e); return false; }
        }

        document.addEventListener('pointerdown', function(e){
          try {
            var el = e.target;
            if (goToHref(el)) {
              e.preventDefault();
              e.stopImmediatePropagation();
            }
          } catch(err) { console.debug('pointerdown handler error', err); }
        }, true);
      })();
    </script>

    <div class="flex min-h-screen">
      <!-- Sidebar (Architectural Deep Charcoal) -->
      <aside class="hidden md:flex md:w-68 flex-col bg-[#171A19] text-[#EAE8E1] border-r border-[#282D2A] sticky top-0 h-screen z-30 transition-all duration-200" style="width: 270px;">
        <div class="px-6 py-5 border-b border-[#282D2A] flex items-center justify-between">
          <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-3 group">
            <img src="{{ asset('images/Logo.png') }}" alt="Admin" class="h-9 w-auto object-contain transition-transform group-hover:scale-105" onerror="this.style.display='none'; this.nextElementSibling.classList.remove('hidden');">
            <div class="hidden w-9 h-9 rounded-lg bg-[#1B3D2F] flex items-center justify-center text-white font-bold text-sm shadow-2xs">
              AD
            </div>
            <div>
              <span class="text-sm font-black tracking-tight text-white flex items-center gap-1.5">
                Hệ Thống Trọ
                <span class="text-[9px] font-bold px-1.5 py-0.5 rounded bg-[#23352B] text-[#8BB39D] uppercase tracking-wider">Admin</span>
              </span>
              <p class="text-[11px] text-[#85877F] font-medium">Ban điều hành nền tảng</p>
            </div>
          </a>
        </div>

        <!-- Navigation Menu -->
        <nav class="flex-1 overflow-y-auto p-3.5 space-y-1.5 scrollbar text-xs sm:text-sm font-medium">
          <p class="px-3 pt-2 pb-1 text-[10px] font-bold uppercase tracking-wider text-[#6C706B]">Hệ thống</p>
          
          <a href="{{ route('admin.dashboard') }}" class="flex items-center px-3.5 py-2.5 rounded-lg transition-all duration-150 {{ request()->routeIs('admin.dashboard') ? 'bg-[#1B3D2F] text-white font-bold shadow-2xs' : 'text-[#C5C8C4] hover:bg-[#202522] hover:text-white' }}">
            <i class="ri-dashboard-line mr-3 text-base {{ request()->routeIs('admin.dashboard') ? 'text-white' : 'text-[#85877F]' }}"></i>
            <span>Tổng quan vận hành</span>
          </a>

          <p class="px-3 pt-3 pb-1 text-[10px] font-bold uppercase tracking-wider text-[#6C706B]">Kiểm duyệt & Bài đăng</p>

          <a href="{{ route('admin.approvals') }}" class="flex items-center px-3.5 py-2.5 rounded-lg transition-all duration-150 {{ request()->routeIs('admin.approvals') ? 'bg-[#1B3D2F] text-white font-bold shadow-2xs' : 'text-[#C5C8C4] hover:bg-[#202522] hover:text-white' }}">
            <i class="ri-checkbox-circle-line mr-3 text-base {{ request()->routeIs('admin.approvals') ? 'text-white' : 'text-[#85877F]' }}"></i>
            <span>Xét duyệt tin đăng</span>
          </a>

          <a href="{{ route('admin.posts') }}" class="flex items-center px-3.5 py-2.5 rounded-lg transition-all duration-150 {{ request()->routeIs('admin.posts') ? 'bg-[#1B3D2F] text-white font-bold shadow-2xs' : 'text-[#C5C8C4] hover:bg-[#202522] hover:text-white' }}">
            <i class="ri-article-line mr-3 text-base {{ request()->routeIs('admin.posts') ? 'text-white' : 'text-[#85877F]' }}"></i>
            <span>Quản lý kho bài viết</span>
          </a>

          <p class="px-3 pt-3 pb-1 text-[10px] font-bold uppercase tracking-wider text-[#6C706B]">Người dùng & Phân quyền</p>

          <a href="{{ route('admin.accounts') }}" class="flex items-center px-3.5 py-2.5 rounded-lg transition-all duration-150 {{ request()->routeIs('admin.accounts') ? 'bg-[#1B3D2F] text-white font-bold shadow-2xs' : 'text-[#C5C8C4] hover:bg-[#202522] hover:text-white' }}">
            <i class="ri-user-3-line mr-3 text-base {{ request()->routeIs('admin.accounts') ? 'text-white' : 'text-[#85877F]' }}"></i>
            <span>Quản lý tài khoản</span>
          </a>

          <a href="{{ route('admin.permissions') }}" class="flex items-center px-3.5 py-2.5 rounded-lg transition-all duration-150 {{ request()->routeIs('admin.permissions') ? 'bg-[#1B3D2F] text-white font-bold shadow-2xs' : 'text-[#C5C8C4] hover:bg-[#202522] hover:text-white' }}">
            <i class="ri-shield-keyhole-line mr-3 text-base {{ request()->routeIs('admin.permissions') ? 'text-white' : 'text-[#85877F]' }}"></i>
            <span>Phân quyền vai trò</span>
          </a>

          <p class="px-3 pt-3 pb-1 text-[10px] font-bold uppercase tracking-wider text-[#6C706B]">Dữ liệu vùng</p>

          <a href="{{ route('admin.regions') }}" class="flex items-center px-3.5 py-2.5 rounded-lg transition-all duration-150 {{ request()->routeIs('admin.regions') ? 'bg-[#1B3D2F] text-white font-bold shadow-2xs' : 'text-[#C5C8C4] hover:bg-[#202522] hover:text-white' }}">
            <i class="ri-map-pin-line mr-3 text-base {{ request()->routeIs('admin.regions') ? 'text-white' : 'text-[#85877F]' }}"></i>
            <span>Quản lý khu vực</span>
          </a>
        </nav>

        <div class="px-4 py-3.5 border-t border-[#282D2A] text-xs text-[#85877F] flex items-center justify-between">
          <span>&copy; {{ date('Y') }} Central Admin</span>
          <a href="{{ url('/') }}" class="text-[11px] text-[#8BB39D] hover:underline flex items-center gap-1">
            <span>Website</span>
            <i class="ri-external-link-line"></i>
          </a>
        </div>
      </aside>

      <!-- Main Content Area -->
      <div class="flex-1 flex flex-col min-w-0">
        <!-- Top bar -->
        <header class="sticky top-0 bg-white/90 backdrop-blur-md border-b border-[#E5E3DC] z-20 transition-colors">
          <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <div class="flex items-center gap-3">
              <button class="md:hidden p-2 rounded-lg text-[#4A4E4B] hover:bg-[#FAF9F6]" onclick="document.getElementById('mobileMenu').classList.remove('hidden')">
                <i class="ri-menu-line text-lg"></i>
              </button>
              <div>
                <span class="text-xs font-bold uppercase tracking-wider text-[#85877F]">Bảng Quản Trị Trung Tâm</span>
                <p class="text-sm font-extrabold text-[#171A19]">Hệ Thống Trọ</p>
              </div>
            </div>

            <div class="flex items-center gap-3">
              <a href="{{ route('admin.approvals') }}" class="hidden sm:inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-[#FAF9F6] border border-[#E5E3DC] text-[#171A19] hover:border-[#1B3D2F] text-xs font-bold transition">
                <i class="ri-shield-check-line text-[#1B3D2F]"></i>
                <span>Kiểm duyệt tin</span>
              </a>

              <a href="{{ route('admin.accounts') }}" class="px-3.5 py-1.5 rounded-lg bg-[#1B3D2F] text-white hover:bg-[#142E23] text-xs font-bold transition shadow-2xs">
                Tài khoản
              </a>

              <!-- Avatar with dropdown -->
              <div class="relative">
                <button id="avatarBtn" aria-haspopup="true" aria-expanded="false" class="w-9 h-9 rounded-lg bg-[#171A19] border border-[#282D2A] text-white flex items-center justify-center font-bold text-xs focus:outline-none">
                  AD
                </button>

                <div id="avatarMenu" class="hidden absolute right-0 mt-2 w-44 bg-white rounded-xl shadow-xl border border-[#E5E3DC] py-1 text-xs z-50">
                  <div class="px-3.5 py-2 border-b border-[#E5E3DC] bg-[#FAF9F6]">
                    <p class="font-bold text-[#171A19]">Quản trị viên</p>
                    <p class="text-[10px] text-[#85877F]">{{ session('user')['email'] ?? 'admin@system.local' }}</p>
                  </div>
                  <a href="{{ url('/') }}" target="_blank" class="block px-3.5 py-2 text-[#4A4E4B] hover:bg-[#FAF9F6] hover:text-[#171A19]">
                    <i class="ri-external-link-line mr-1 text-[#85877F]"></i> Xem website
                  </a>
                  <form method="POST" action="{{ route('logout') }}" class="px-1 py-1 border-t border-[#E5E3DC]">
                    @csrf
                    <button type="submit" class="w-full text-left text-rose-600 hover:bg-rose-50 px-2.5 py-1.5 rounded-lg font-semibold flex items-center gap-1.5">
                      <i class="ri-logout-box-r-line"></i> Đăng xuất
                    </button>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </header>

        <!-- Content -->
        <main class="flex-1 p-4 sm:p-6 lg:p-8 page-enter-fade">
          @yield('content')
        </main>
      </div>
    </div>

    <!-- Mobile drawer -->
    <div id="mobileMenu" class="fixed inset-0 z-50 hidden">
      <div class="absolute inset-0 bg-black/50 backdrop-blur-xs" onclick="document.getElementById('mobileMenu').classList.add('hidden')"></div>
      <div class="absolute inset-y-0 left-0 w-72 bg-[#171A19] text-[#EAE8E1] border-r border-[#282D2A] p-4 flex flex-col justify-between shadow-2xl">
        <div>
          <div class="flex items-center justify-between mb-5 pb-3 border-b border-[#282D2A]">
            <div class="flex items-center space-x-2.5">
                <div class="w-8 h-8 rounded-lg bg-[#1B3D2F] flex items-center justify-center text-white font-bold text-xs">
                  AD
                </div>
                <span class="font-black text-sm text-white">Admin Panel</span>
            </div>
            <button class="p-1 rounded-md text-[#85877F] hover:bg-[#202522]" onclick="document.getElementById('mobileMenu').classList.add('hidden')">
              <i class="ri-close-line text-xl"></i>
            </button>
          </div>
          <nav class="space-y-1 text-xs font-medium">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center px-3 py-2 rounded-lg text-[#C5C8C4] hover:bg-[#202522] hover:text-white">
              <i class="ri-dashboard-line mr-2.5 text-base text-[#85877F]"></i> Tổng quan
            </a>
            <a href="{{ route('admin.approvals') }}" class="flex items-center px-3 py-2 rounded-lg text-[#C5C8C4] hover:bg-[#202522] hover:text-white">
              <i class="ri-checkbox-circle-line mr-2.5 text-base text-[#85877F]"></i> Xét duyệt Bài viết
            </a>
            <a href="{{ route('admin.posts') }}" class="flex items-center px-3 py-2 rounded-lg text-[#C5C8C4] hover:bg-[#202522] hover:text-white">
              <i class="ri-article-line mr-2.5 text-base text-[#85877F]"></i> Quản lý Bài viết
            </a>
            <a href="{{ route('admin.accounts') }}" class="flex items-center px-3 py-2 rounded-lg text-[#C5C8C4] hover:bg-[#202522] hover:text-white">
              <i class="ri-user-3-line mr-2.5 text-base text-[#85877F]"></i> Quản lý Tài khoản
            </a>
            <a href="{{ route('admin.permissions') }}" class="flex items-center px-3 py-2 rounded-lg text-[#C5C8C4] hover:bg-[#202522] hover:text-white">
              <i class="ri-shield-keyhole-line mr-2.5 text-base text-[#85877F]"></i> Quản lý Phân quyền
            </a>
            <a href="{{ route('admin.regions') }}" class="flex items-center px-3 py-2 rounded-lg text-[#C5C8C4] hover:bg-[#202522] hover:text-white">
              <i class="ri-map-pin-line mr-2.5 text-base text-[#85877F]"></i> Quản lý Khu vực
            </a>
          </nav>
        </div>
        <div class="pt-3 border-t border-[#282D2A]">
          <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full py-2 px-3 rounded-lg text-xs font-semibold text-rose-400 bg-rose-950/30 flex items-center justify-center gap-1.5">
              <i class="ri-logout-box-r-line"></i> Đăng xuất
            </button>
          </form>
        </div>
      </div>
    </div>

  <script>
    // Global bypass: for anchors/buttons marked with data-no-ajax
    (function(){
      function shouldBypass(el) {
        if (!el) return false;
        if (el.closest && el.closest('[data-no-ajax]')) return true;
        if (el.closest && el.closest('#rejectModalContent')) return true;
        if (el.closest && el.closest('#editRoleModalContent')) return true;
        return false;
      }

      document.addEventListener('click', function(e){
        try {
          var el = e.target;
          if (shouldBypass(el)) {
            e.stopImmediatePropagation();
            e.stopPropagation();
            if (window.console && console.debug) console.debug('BYPASS click for', el);
          }
        } catch(err) {
          console.debug('bypass error', err);
        }
      }, true);
    })();
  </script>

  <script>
    // Avatar dropdown toggle
    (function(){
      var btn = document.getElementById('avatarBtn');
      var menu = document.getElementById('avatarMenu');
      if (!btn || !menu) return;

      function hide() {
        menu.classList.add('hidden');
        menu.classList.remove('dropdown-menu-animate');
        btn.setAttribute('aria-expanded', 'false');
      }
      function show() {
        menu.classList.remove('hidden');
        menu.classList.add('dropdown-menu-animate');
        btn.setAttribute('aria-expanded', 'true');
      }

      btn.addEventListener('click', function(e){
        e.stopPropagation();
        if (menu.classList.contains('hidden')) show(); else hide();
      });

      // close when clicking outside
      document.addEventListener('click', function(e){
        if (!menu.contains(e.target) && !btn.contains(e.target)) hide();
      });

      // close on escape
      document.addEventListener('keydown', function(e){ if (e.key === 'Escape') hide(); });
    })();
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

  @stack('scripts')

</body>
</html>
