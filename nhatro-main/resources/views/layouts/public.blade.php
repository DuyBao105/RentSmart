<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Hệ Thống Trọ - Thị trường thuê phòng thông minh')</title>
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/Logo.png') }}">
    <link rel="shortcut icon" href="{{ asset('images/Logo.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.3.0/fonts/remixicon.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        :root {
            --motion-timing-fast: 180ms;
            --motion-timing-base: 280ms;
            --motion-timing-slow: 480ms;
            --motion-ease-spring: cubic-bezier(0.16, 1, 0.3, 1);
            --motion-ease-smooth: cubic-bezier(0.4, 0, 0.2, 1);
        }
        html[data-motion-ready="true"] .motion-reveal {
            opacity: 0;
            transform: translateY(16px);
            transition: opacity var(--motion-timing-slow) var(--motion-ease-smooth),
                        transform var(--motion-timing-slow) var(--motion-ease-spring);
        }
        html[data-motion-ready="true"] .motion-reveal.is-revealed {
            opacity: 1;
            transform: translateY(0);
        }
        .micro-press { transition: transform 0.15s var(--motion-ease-spring); }
        .micro-press:active { transform: scale(0.97); }
        .card-lift-hover { transition: transform 0.25s var(--motion-ease-spring), box-shadow 0.25s; }
        .card-lift-hover:hover { transform: translateY(-3px); }
        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after {
                animation-duration: 0.01ms !important;
                transition-duration: 0.01ms !important;
            }
            html[data-motion-ready="true"] .motion-reveal { opacity: 1 !important; transform: none !important; }
        }
    </style>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-50 text-slate-800 font-['Plus_Jakarta_Sans',sans-serif] antialiased">
    <nav class="bg-white/90 backdrop-blur-md border-b border-slate-200/80 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-6 py-3.5 flex justify-between items-center">
            <a href="{{ route('public.bai-dang.index') }}" class="flex items-center gap-2.5 group">
                <img src="{{ asset('images/Logo.png') }}" alt="Logo" class="h-9 w-auto object-contain group-hover:scale-105 transition-transform" onerror="this.style.display='none'; this.nextElementSibling.classList.remove('hidden');">
                <div class="hidden w-8 h-8 rounded-xl bg-gradient-to-tr from-sky-600 to-cyan-500 flex items-center justify-center text-white font-bold text-xs shadow-md shadow-sky-500/20">
                    <i class="ri-home-5-fill text-base"></i>
                </div>
                <span class="text-lg font-extrabold tracking-tight text-slate-900">Hệ Thống Trọ</span>
            </a>
            <a href="{{ url('/') }}" class="text-sm font-semibold text-sky-600 hover:text-sky-700 transition micro-press">
                Về trang chủ &rarr;
            </a>
        </div>
    </nav>

    <main class="motion-reveal is-revealed">@yield('content')</main>

    <footer class="mt-16 py-8 text-center text-slate-400 text-xs border-t border-slate-200/80">
        &copy; {{ date('Y') }} Hệ Thống Trọ — Nền tảng cho thuê phòng trọ hiện đại.
    </footer>

    <script>
        document.documentElement.dataset.motionReady = "true";
        document.addEventListener("DOMContentLoaded", () => {
            const obs = new IntersectionObserver((entries, o) => {
                entries.forEach(e => {
                    if (e.isIntersecting) {
                        e.target.classList.add("is-revealed");
                        o.unobserve(e.target);
                    }
                });
            }, { threshold: 0.1 });
            document.querySelectorAll(".motion-reveal").forEach(el => obs.observe(el));
        });
    </script>
</body>

</html>