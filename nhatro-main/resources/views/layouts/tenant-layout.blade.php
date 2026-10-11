@extends('layouts.app')

@section('title', 'Khu vực Khách Thuê - Hệ Thống Trọ Bất Động Sản')

@section('content')
    {{-- Top Slim Loading Progress Bar for Instant Navigation --}}
    <div id="tenant-top-progress" class="fixed top-0 left-0 h-1 bg-[#1B3D2F] transition-all duration-300 z-[9999] opacity-0 pointer-events-none" style="width: 0%;"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 flex flex-col md:flex-row gap-7 min-h-[82vh]">
        {{-- ================= SIDEBAR ================= --}}
        <aside
            class="w-full md:w-72 bg-white dark:bg-[#181B19] border border-[#E5E3DC] dark:border-[#282D2A] rounded-xl p-5 flex flex-col justify-between shadow-2xs shrink-0 h-fit md:sticky md:top-24">

            {{-- Header Sidebar --}}
            <div>
                <div class="px-2 pb-4 mb-3 border-b border-[#EAE8E1] dark:border-[#262B28] flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg bg-[#1B3D2F] flex items-center justify-center text-white font-bold text-xs tracking-wider shrink-0 shadow-2xs">
                        KT
                    </div>
                    <div>
                        <span class="text-[10px] font-bold uppercase tracking-wider text-[#85877F] block">Khu vực cá nhân</span>
                        <p class="text-sm font-extrabold text-[#171A19] dark:text-white leading-tight">Khách Thuê Phòng</p>
                    </div>
                </div>

                {{-- Navigation --}}
                <nav class="space-y-1 text-xs sm:text-sm font-medium">
                    {{-- 1. Bảng điều khiển --}}
                    <a href="{{ route('khach-thue.dashboard') }}"
                        class="flex items-center px-3.5 py-2.5 rounded-lg transition-all duration-150
                        {{ Request::is('khach-thue/dashboard') 
                            ? 'bg-[#1B3D2F] text-white font-bold shadow-2xs' 
                            : 'text-[#4A4E4B] dark:text-[#C5C8C4] hover:bg-[#FAF9F6] dark:hover:bg-[#202522] hover:text-[#171A19] dark:hover:text-white' }}">
                        <i class="ri-dashboard-3-line mr-3 text-base {{ Request::is('khach-thue/dashboard') ? 'text-white' : 'text-[#85877F]' }}"></i>
                        <span>Bảng điều khiển</span>
                    </a>

                    {{-- 2. Phòng trọ của tôi --}}
                    <a href="{{ route('khach-thue.phong.index') }}"
                        class="flex items-center px-3.5 py-2.5 rounded-lg transition-all duration-150
                        {{ Request::is('khach-thue/phong*') 
                            ? 'bg-[#1B3D2F] text-white font-bold shadow-2xs' 
                            : 'text-[#4A4E4B] dark:text-[#C5C8C4] hover:bg-[#FAF9F6] dark:hover:bg-[#202522] hover:text-[#171A19] dark:hover:text-white' }}">
                        <i class="ri-door-line mr-3 text-base {{ Request::is('khach-thue/phong*') ? 'text-white' : 'text-[#85877F]' }}"></i>
                        <span>Phòng trọ của tôi</span>
                    </a>

                    {{-- 3. Yêu cầu thuê phòng --}}
                    <a href="{{ route('khach-thue.yeu-cau-thue.index') }}"
                        class="flex items-center px-3.5 py-2.5 rounded-lg transition-all duration-150
                        {{ Request::is('khach-thue/yeu-cau-thue*') 
                            ? 'bg-[#1B3D2F] text-white font-bold shadow-2xs' 
                            : 'text-[#4A4E4B] dark:text-[#C5C8C4] hover:bg-[#FAF9F6] dark:hover:bg-[#202522] hover:text-[#171A19] dark:hover:text-white' }}">
                        <i class="ri-mail-send-line mr-3 text-base {{ Request::is('khach-thue/yeu-cau-thue*') ? 'text-white' : 'text-[#85877F]' }}"></i>
                        <span>Yêu cầu thuê phòng</span>
                    </a>

                    {{-- 4. Hợp đồng điện tử --}}
                    <a href="{{ route('khach-thue.hop-dong.index') }}"
                        class="flex items-center px-3.5 py-2.5 rounded-lg transition-all duration-150
                        {{ Request::is('khach-thue/hop-dong*') 
                            ? 'bg-[#1B3D2F] text-white font-bold shadow-2xs' 
                            : 'text-[#4A4E4B] dark:text-[#C5C8C4] hover:bg-[#FAF9F6] dark:hover:bg-[#202522] hover:text-[#171A19] dark:hover:text-white' }}">
                        <i class="ri-file-text-line mr-3 text-base {{ Request::is('khach-thue/hop-dong*') ? 'text-white' : 'text-[#85877F]' }}"></i>
                        <span>Hợp đồng điện tử</span>
                    </a>

                    {{-- 5. Hóa đơn tiền phòng --}}
                    <a href="{{ route('khach-thue.hoa-don.index') }}"
                        class="flex items-center px-3.5 py-2.5 rounded-lg transition-all duration-150
                        {{ Request::is('khach-thue/hoa-don*') 
                            ? 'bg-[#1B3D2F] text-white font-bold shadow-2xs' 
                            : 'text-[#4A4E4B] dark:text-[#C5C8C4] hover:bg-[#FAF9F6] dark:hover:bg-[#202522] hover:text-[#171A19] dark:hover:text-white' }}">
                        <i class="ri-bill-line mr-3 text-base {{ Request::is('khach-thue/hoa-don*') ? 'text-white' : 'text-[#85877F]' }}"></i>
                        <span>Hóa đơn tiền phòng</span>
                    </a>

                    {{-- 6. Phòng trọ yêu thích --}}
                    <a href="{{ route('khach-thue.yeu-thich') }}"
                        class="flex items-center px-3.5 py-2.5 rounded-lg transition-all duration-150
                        {{ Request::is('khach-thue/yeu-thich*') 
                            ? 'bg-[#1B3D2F] text-white font-bold shadow-2xs' 
                            : 'text-[#4A4E4B] dark:text-[#C5C8C4] hover:bg-[#FAF9F6] dark:hover:bg-[#202522] hover:text-[#171A19] dark:hover:text-white' }}">
                        <i class="ri-heart-line mr-3 text-base {{ Request::is('khach-thue/yeu-thich*') ? 'text-white' : 'text-rose-400' }}"></i>
                        <span>Phòng đã lưu</span>
                    </a>

                    {{-- 7. Thông báo --}}
                    @php
                        $unreadCount = session('thong_bao_chua_doc', 0);
                    @endphp
                    <a href="{{ route('khach-thue.thong-bao.index') }}"
                        class="flex items-center justify-between px-3.5 py-2.5 rounded-lg transition-all duration-150
                        {{ Request::is('khach-thue/thong-bao*') 
                            ? 'bg-[#1B3D2F] text-white font-bold shadow-2xs' 
                            : 'text-[#4A4E4B] dark:text-[#C5C8C4] hover:bg-[#FAF9F6] dark:hover:bg-[#202522] hover:text-[#171A19] dark:hover:text-white' }}">
                        <div class="flex items-center">
                            <i class="ri-notification-3-line mr-3 text-base {{ Request::is('khach-thue/thong-bao*') ? 'text-white' : 'text-[#85877F]' }}"></i>
                            <span>Thông báo</span>
                        </div>
                        @if($unreadCount > 0)
                            <span class="px-1.5 py-0.5 rounded text-[10px] font-bold bg-rose-500 text-white">
                                {{ $unreadCount }}
                            </span>
                        @endif
                    </a>

                    {{-- 8. Đánh giá & Review --}}
                    <a href="{{ route('khach-thue.danh-gia.index') }}"
                        class="flex items-center px-3.5 py-2.5 rounded-lg transition-all duration-150
                        {{ Request::is('khach-thue/danh-gia*') 
                            ? 'bg-[#1B3D2F] text-white font-bold shadow-2xs' 
                            : 'text-[#4A4E4B] dark:text-[#C5C8C4] hover:bg-[#FAF9F6] dark:hover:bg-[#202522] hover:text-[#171A19] dark:hover:text-white' }}">
                        <i class="ri-star-line mr-3 text-base {{ Request::is('khach-thue/danh-gia*') ? 'text-white' : 'text-[#85877F]' }}"></i>
                        <span>Đánh giá & Nhận xét</span>
                    </a>

                    {{-- 9. Hồ sơ cá nhân --}}
                    <a href="{{ route('khach-thue.profile.edit') }}"
                        class="flex items-center px-3.5 py-2.5 rounded-lg transition-all duration-150
                        {{ Request::is('khach-thue/ho-so*') 
                            ? 'bg-[#1B3D2F] text-white font-bold shadow-2xs' 
                            : 'text-[#4A4E4B] dark:text-[#C5C8C4] hover:bg-[#FAF9F6] dark:hover:bg-[#202522] hover:text-[#171A19] dark:hover:text-white' }}">
                        <i class="ri-user-settings-line mr-3 text-base {{ Request::is('khach-thue/ho-so*') ? 'text-white' : 'text-[#85877F]' }}"></i>
                        <span>Hồ sơ cá nhân</span>
                    </a>
                </nav>
            </div>

            {{-- Logout Button --}}
            <div class="pt-4 mt-4 border-t border-[#EAE8E1] dark:border-[#262B28]">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="w-full flex items-center justify-center gap-2 px-3 py-2 rounded-lg text-xs font-semibold text-rose-700 dark:text-rose-400 bg-rose-50 dark:bg-rose-950/30 hover:bg-rose-100 dark:hover:bg-rose-950/50 border border-rose-200 dark:border-rose-900/50 transition cursor-pointer">
                        <i class="ri-logout-box-r-line"></i>
                        <span>Đăng xuất tài khoản</span>
                    </button>
                </form>
            </div>
        </aside>

        {{-- ================= MAIN CONTENT ================= --}}
        <main class="flex-1 min-w-0">
            <div class="mb-5 flex items-center justify-between">
                <div>
                    <h1 id="tenant-page-title" class="text-xl sm:text-2xl font-extrabold tracking-tight text-[#171A19] dark:text-white">
                        @yield('page_title', 'Khu vực khách thuê')
                    </h1>
                    <p id="tenant-page-subtitle" class="text-[#70746F] dark:text-[#A6AAA7] text-xs sm:text-sm mt-0.5">@yield('page_subtitle')</p>
                </div>
                {{-- Chuông thông báo + dropdown --}}
                @php
                    $miniThongBao = session('thong_bao_moi_nhat', []);
                    $soChuaDoc = session('thong_bao_chua_doc', 0);
                    if (empty($miniThongBao) && $soChuaDoc > 0) {
                        $soChuaDoc = 0;
                    }
                @endphp

                <div class="relative">
                    <button id="tenant-bell-btn"
                            class="relative w-10 h-10 rounded-lg bg-white dark:bg-[#181B19] border border-[#E5E3DC] dark:border-[#282D2A] flex items-center justify-center text-[#171A19] dark:text-white hover:border-[#1B3D2F] dark:hover:border-[#7EA089] shadow-2xs transition cursor-pointer">
                        <i id="tenant-bell-icon"
                           class="ri-notification-3-line text-lg {{ $soChuaDoc > 0 ? 'tenant-bell-ring text-[#1B3D2F] dark:text-emerald-400' : '' }}"></i>

                        @if($soChuaDoc > 0)
                            <span id="tenant-bell-badge"
                                data-count="{{ $soChuaDoc }}"
                                class="absolute -top-1 -right-1 bg-rose-600 text-white text-[9px] font-bold
                                        w-4 h-4 rounded-full flex items-center justify-center shadow-xs">
                                {{ $soChuaDoc > 99 ? '99+' : $soChuaDoc }}
                            </span>
                        @endif
                    </button>

                    {{-- Dropdown danh sách thông báo --}}
                    <div id="tenant-bell-dropdown"
                        class="hidden absolute right-0 mt-2 w-80 bg-white dark:bg-[#181B19]
                                border border-[#E5E3DC] dark:border-[#282D2A] rounded-xl shadow-xl z-50 overflow-hidden">
                        <div class="px-4 py-2.5 border-b border-[#EAE8E1] dark:border-[#262B28] flex items-center justify-between bg-[#FAF9F6] dark:bg-[#1F2321]">
                            <span class="font-bold text-[#171A19] dark:text-white text-xs uppercase tracking-wider">
                                Thông báo hệ thống
                            </span>
                            @if($soChuaDoc > 0)
                                <span class="text-[11px] text-rose-600 dark:text-rose-400 font-semibold">
                                    {{ $soChuaDoc }} chưa đọc
                                </span>
                            @endif
                        </div>

                        <div class="max-h-80 overflow-y-auto divide-y divide-[#EAE8E1] dark:divide-[#262B28]">
                            @forelse($miniThongBao as $tb)
                                <a href="{{ $tb['lien_ket'] ?? route('khach-thue.thong-bao.index') }}"
                                class="block px-4 py-3 text-xs hover:bg-[#FAF9F6] dark:hover:bg-[#202522] transition">
                                    <p class="text-[#171A19] dark:text-[#E8EAE9] line-clamp-2 leading-relaxed">
                                        {{ $tb['noi_dung'] ?? '(Không có nội dung)' }}
                                    </p>
                                    <p class="text-[11px] text-[#85877F] mt-1 flex items-center gap-1.5">
                                        <span>{{ \Carbon\Carbon::parse($tb['ngay_tao'])->diffForHumans() }}</span>
                                        @if(($tb['da_xem'] ?? 0) == 0)
                                            <span class="px-1.5 py-0.2 rounded bg-emerald-50 text-[#1B3D2F] dark:bg-emerald-950 dark:text-emerald-300 font-semibold text-[10px]">
                                                Mới
                                            </span>
                                        @endif
                                    </p>
                                </a>
                            @empty
                                <div class="px-4 py-8 text-center text-xs text-[#85877F]">
                                    <i class="ri-notification-off-line text-2xl text-[#85877F] block mb-1"></i>
                                    Không có thông báo mới nào.
                                </div>
                            @endforelse
                        </div>

                        <div class="border-t border-[#EAE8E1] dark:border-[#262B28] p-2 text-center bg-[#FAF9F6] dark:bg-[#1F2321]">
                            <a href="{{ route('khach-thue.thong-bao.index') }}"
                            class="block w-full py-1 text-xs font-semibold text-[#1B3D2F] dark:text-[#A3B899] hover:underline">
                                Xem tất cả thông báo &rarr;
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Nội dung của từng trang (main pane) --}}
            <div id="tenant-main-pane" class="bg-white dark:bg-[#181B19] rounded-xl border border-[#E5E3DC] dark:border-[#282D2A] shadow-2xs p-5 sm:p-7">
                @yield('tenant_content')
            </div>
        </main>
    </div>
    
    {{-- Inline script toggle dropdown chuông thông báo --}}
    <script>
    (function () {
        const bellBtn = document.getElementById('tenant-bell-btn');
        const dropdown = document.getElementById('tenant-bell-dropdown');

        if (!bellBtn || !dropdown) return;

        bellBtn.addEventListener('click', function (e) {
            e.stopPropagation();
            dropdown.classList.toggle('hidden');
        });

        document.addEventListener('click', function (e) {
            if (!dropdown.classList.contains('hidden')) {
                if (!dropdown.contains(e.target) && !bellBtn.contains(e.target)) {
                    dropdown.classList.add('hidden');
                }
            }
        });

        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') dropdown.classList.add('hidden');
        });
    })();
</script>
<style>
    @keyframes tenant-bell-shake {
        0%   { transform: rotate(0); }
        15%  { transform: rotate(15deg); }
        30%  { transform: rotate(-15deg); }
        45%  { transform: rotate(10deg); }
        60%  { transform: rotate(-10deg); }
        75%  { transform: rotate(5deg); }
        100% { transform: rotate(0); }
    }

    .tenant-bell-ring {
        animation: tenant-bell-shake 0.8s ease-in-out infinite;
        transform-origin: top center;
    }
</style>

{{-- ⚡ INSTANT SPA NAVIGATOR (Zero Full-Page Reloads) --}}
<script>
(function () {
    const mainPane = document.getElementById('tenant-main-pane');
    const progressBar = document.getElementById('tenant-top-progress');
    const pageTitle = document.getElementById('tenant-page-title');
    const pageSubtitle = document.getElementById('tenant-page-subtitle');
    const cache = new Map();

    function showProgress() {
        if (!progressBar) return;
        progressBar.style.opacity = '1';
        progressBar.style.width = '35%';
        setTimeout(() => { if (progressBar) progressBar.style.width = '75%'; }, 80);
    }

    function finishProgress() {
        if (!progressBar) return;
        progressBar.style.width = '100%';
        setTimeout(() => {
            if (progressBar) {
                progressBar.style.opacity = '0';
                setTimeout(() => { if (progressBar) progressBar.style.width = '0%'; }, 200);
            }
        }, 150);
    }

    function updateSidebarActive(targetUrl) {
        try {
            const targetPath = new URL(targetUrl, window.location.origin).pathname;
            document.querySelectorAll('aside nav a').forEach(a => {
                const aPath = new URL(a.href, window.location.origin).pathname;
                const isDashboard = (aPath === '/khach-thue/dashboard');
                const isActive = (aPath === targetPath) || (!isDashboard && targetPath.startsWith(aPath) && aPath !== '/khach-thue');
                const icon = a.querySelector('i');

                if (isActive) {
                    a.className = 'flex items-center px-3.5 py-2.5 rounded-lg transition-all duration-150 bg-[#1B3D2F] text-white font-bold shadow-2xs';
                    if (icon) icon.className = icon.className.replace('text-[#85877F]', 'text-white');
                } else {
                    a.className = 'flex items-center px-3.5 py-2.5 rounded-lg transition-all duration-150 text-[#4A4E4B] dark:text-[#C5C8C4] hover:bg-[#FAF9F6] dark:hover:bg-[#202522] hover:text-[#171A19] dark:hover:text-white font-medium';
                    if (icon) icon.className = icon.className.replace('text-white', 'text-[#85877F]');
                }
            });
        } catch (e) {}
    }

    async function loadTenantPage(url, push = true) {
        showProgress();
        updateSidebarActive(url);

        try {
            let html = cache.get(url);
            if (!html) {
                const res = await fetch(url, {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                });
                if (!res.ok) throw new Error('HTTP ' + res.status);
                html = await res.text();
                cache.set(url, html);
            }

            const parser = new DOMParser();
            const doc = parser.parseFromString(html, 'text/html');

            const newPane = doc.getElementById('tenant-main-pane');
            const newTitle = doc.getElementById('tenant-page-title');
            const newSubtitle = doc.getElementById('tenant-page-subtitle');

            if (newPane && mainPane) {
                mainPane.style.opacity = '0.4';
                mainPane.style.transform = 'translateY(6px)';
                mainPane.style.transition = 'all 120ms ease-out';

                setTimeout(() => {
                    mainPane.innerHTML = newPane.innerHTML;
                    if (newTitle && pageTitle) pageTitle.textContent = newTitle.textContent;
                    if (newSubtitle && pageSubtitle) pageSubtitle.textContent = newSubtitle.textContent;
                    if (doc.title) document.title = doc.title;

                    if (push) {
                        window.history.pushState({ url }, '', url);
                    }

                    // Re-run inline scripts inside new content
                    newPane.querySelectorAll('script').forEach(oldScript => {
                        const s = document.createElement('script');
                        Array.from(oldScript.attributes).forEach(attr => s.setAttribute(attr.name, attr.value));
                        s.textContent = oldScript.textContent;
                        document.body.appendChild(s);
                        setTimeout(() => s.remove(), 60);
                    });

                    // Re-initialize Alpine.js on the swapped pane
                    if (window.Alpine) {
                        window.Alpine.initTree(mainPane);
                    }

                    mainPane.style.opacity = '1';
                    mainPane.style.transform = 'translateY(0)';
                    finishProgress();
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                }, 120);
            } else {
                window.location.href = url;
            }
        } catch (err) {
            console.warn('Instant navigation fallback to standard reload:', err);
            finishProgress();
            window.location.href = url;
        }
    }

    // Prefetch on hover (0ms instant transition upon click)
    document.addEventListener('mouseover', e => {
        const link = e.target.closest('a');
        if (!link || !link.href) return;
        if (link.href.includes('/khach-thue/') && !link.href.includes('/logout') && !cache.has(link.href)) {
            fetch(link.href, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
                .then(r => r.text())
                .then(html => cache.set(link.href, html))
                .catch(() => {});
        }
    });

    // Intercept clicks on tenant links
    document.addEventListener('click', e => {
        const link = e.target.closest('a');
        if (!link || !link.href) return;

        // Skip external, downloads, or modifier keys
        if (e.metaKey || e.ctrlKey || e.shiftKey || e.altKey || link.target === '_blank' || link.hasAttribute('download')) return;
        if (link.href.endsWith('.pdf')) return;
        if (link.getAttribute('data-no-spa') === 'true') return;

        const url = link.href;
        if (url.includes('/khach-thue/') && !url.includes('/logout')) {
            e.preventDefault();
            loadTenantPage(url, true);
        }
    });

    // Handle Back / Forward browser buttons
    window.addEventListener('popstate', () => {
        loadTenantPage(window.location.href, false);
    });
})();
</script>

@endsection