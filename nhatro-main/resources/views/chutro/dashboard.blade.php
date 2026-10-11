@extends('layouts.chu-tro')

@section('title', 'Bảng điều khiển Quản Trị Chủ Nhà - Hệ Thống Trọ')
@section('header_title', 'Bảng Điều Khiển Vận Hành')
@section('header_subtitle', 'Tổng quan chỉ số phòng trọ, công suất lấp đầy và dòng tiền theo thời gian thực')

@section('content')
    <div class="max-w-7xl mx-auto space-y-7 animate-fade-in">

        {{-- 🔹 HEADER ACTIONS --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white dark:bg-[#181B19] p-6 rounded-xl border border-[#E5E3DC] dark:border-[#282D2A] shadow-2xs">
            <div>
                <h1 class="text-xl sm:text-2xl font-black tracking-tight text-[#171A19] dark:text-white flex items-center gap-2.5">
                    <span class="w-8 h-8 rounded-lg bg-[#1B3D2F] text-white flex items-center justify-center text-base shadow-2xs">
                        <i class="ri-dashboard-fill"></i>
                    </span>
                    Tổng Quan Danh Mục Bất Động Sản
                </h1>
                <p class="text-xs text-[#85877F] mt-1 font-medium">Báo cáo cập nhật tự động lúc {{ date('H:i, d/m/Y') }}</p>
            </div>

            <div class="flex flex-wrap items-center gap-2.5">
                <a href="{{ route('chu-tro.hoa-don.export') }}"
                    class="inline-flex items-center gap-2 px-3.5 py-2 rounded-lg bg-[#FAF9F6] dark:bg-[#222724] text-[#171A19] dark:text-[#EAE8E1] border border-[#E5E3DC] dark:border-[#282D2A] text-xs font-bold hover:border-[#1B3D2F] dark:hover:border-[#1B3D2F] transition shadow-2xs micro-press">
                    <i class="ri-file-excel-2-line text-sm text-[#1B3D2F] dark:text-[#8BB39D]"></i> Xuất báo cáo tài chính
                </a>

                <a href="{{ route('chu-tro.bai-dang.create') }}"
                    class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-lg bg-[#1B3D2F] text-white text-xs font-bold hover:bg-[#142E23] transition shadow-2xs micro-press">
                    <i class="ri-add-line text-sm"></i> Đăng phòng mới
                </a>
            </div>
        </div>

        {{-- 🔹 THỐNG KÊ CARDS --}}
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3.5">
            @php
                $cards = [
                    ['label' => 'Dãy / Khu trọ', 'value' => $stats['so_day_tro'] ?? 0, 'icon' => 'ri-community-line', 'color' => 'text-[#1B3D2F] dark:text-[#8BB39D]', 'bg' => 'bg-[#E5EDE8] dark:bg-[#23352B]'],
                    ['label' => 'Tổng số phòng', 'value' => $stats['so_phong'] ?? 0, 'icon' => 'ri-building-2-line', 'color' => 'text-[#202421] dark:text-white', 'bg' => 'bg-[#FAF9F6] dark:bg-[#222724] border border-[#E5E3DC] dark:border-[#282D2A]'],
                    ['label' => 'Đang cho thuê', 'value' => $stats['so_phong_dang_thue'] ?? 0, 'icon' => 'ri-door-open-line', 'color' => 'text-emerald-700 dark:text-emerald-400', 'bg' => 'bg-emerald-50 dark:bg-emerald-950/40'],
                    ['label' => 'Phòng còn trống', 'value' => $stats['so_phong_trong'] ?? 0, 'icon' => 'ri-door-closed-line', 'color' => 'text-amber-700 dark:text-amber-400', 'bg' => 'bg-amber-50 dark:bg-amber-950/40'],
                    ['label' => 'Đang bảo trì', 'value' => $stats['so_phong_bao_tri'] ?? 0, 'icon' => 'ri-tools-line', 'color' => 'text-rose-700 dark:text-rose-400', 'bg' => 'bg-rose-50 dark:bg-rose-950/40'],
                    ['label' => 'Thu tháng (VNĐ)', 'value' => number_format($stats['doanh_thu_thang'] ?? 0), 'icon' => 'ri-wallet-3-line', 'color' => 'text-[#1B3D2F] dark:text-[#8BB39D]', 'bg' => 'bg-[#E5EDE8] dark:bg-[#23352B]'],
                ];
            @endphp

            @foreach($cards as $c)
                <div
                    class="rounded-xl bg-white dark:bg-[#181B19] p-4 border border-[#E5E3DC] dark:border-[#282D2A] shadow-2xs hover:border-[#1B3D2F]/50 transition-all flex flex-col justify-between card-lift-hover motion-reveal motion-stagger-{{ $loop->iteration }}">
                    <div class="flex items-center justify-between mb-2.5">
                        <span class="w-8 h-8 rounded-lg flex items-center justify-center {{ $c['bg'] }} {{ $c['color'] }} text-base font-bold">
                            <i class="{{ $c['icon'] }}"></i>
                        </span>
                    </div>
                    <div>
                        <span class="text-[#85877F] text-[11px] font-bold block mb-0.5 uppercase tracking-wider">{{ $c['label'] }}</span>
                        <div class="text-lg sm:text-xl font-black text-[#171A19] dark:text-white tracking-tight count-up"
                            data-count="{{ preg_replace('/[^0-9]/', '', $c['value']) }}">
                            0
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- 🔹 BIỂU ĐỒ --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- Doanh thu 6 tháng --}}
            <div class="lg:col-span-2 bg-white dark:bg-[#181B19] rounded-xl border border-[#E5E3DC] dark:border-[#282D2A] shadow-2xs p-6 relative card-lift-hover motion-reveal">
                <div class="flex items-center justify-between mb-5">
                    <div>
                        <h2 class="text-sm sm:text-base font-bold text-[#171A19] dark:text-white flex items-center gap-2">
                            <i class="ri-line-chart-line text-[#1B3D2F] dark:text-[#8BB39D]"></i> Dòng Tiền & Doanh Thu (6 Tháng)
                        </h2>
                        <p class="text-xs text-[#85877F] mt-0.5">Xu hướng thực thu từ tiền phòng, điện nước và tiện ích</p>
                    </div>
                    <span class="text-[10px] font-bold px-2 py-0.5 rounded bg-[#FAF9F6] dark:bg-[#222724] border border-[#E5E3DC] dark:border-[#282D2A] text-[#85877F]">
                        Đơn vị: VNĐ
                    </span>
                </div>
                <div class="w-full aspect-[21/9]">
                    <canvas id="chartRevenue"></canvas>
                </div>
            </div>

            {{-- Tình trạng phòng Doughnut --}}
            <div class="bg-white dark:bg-[#181B19] rounded-xl border border-[#E5E3DC] dark:border-[#282D2A] shadow-2xs p-6 flex flex-col justify-between card-lift-hover motion-reveal">
                <div>
                    <h2 class="text-sm sm:text-base font-bold text-[#171A19] dark:text-white flex items-center gap-2 mb-1">
                        <i class="ri-pie-chart-2-line text-[#1B3D2F] dark:text-[#8BB39D]"></i> Tỷ Lệ Lấp Đầy Phòng
                    </h2>
                    <p class="text-xs text-[#85877F] mb-5">Phân bổ hiện trạng vận hành phòng thực tế</p>
                    
                    <div class="relative w-44 h-44 mx-auto">
                        <canvas id="chartOccupancy"></canvas>
                    </div>
                </div>

                <div class="mt-5 pt-5 border-t border-[#E5E3DC] dark:border-[#282D2A] grid grid-cols-3 text-center text-xs">
                    <div>
                        <div class="flex items-center justify-center gap-1.5 mb-1">
                            <span class="inline-block h-2 w-2 rounded-full bg-[#1B3D2F]"></span>
                            <span class="text-[#85877F] text-[10px] font-semibold">Đang thuê</span>
                        </div>
                        <span class="font-extrabold text-[#171A19] dark:text-white text-sm">{{ (int)($stats['so_phong_dang_thue'] ?? 0) }}</span>
                    </div>
                    <div>
                        <div class="flex items-center justify-center gap-1.5 mb-1">
                            <span class="inline-block h-2 w-2 rounded-full bg-amber-500"></span>
                            <span class="text-[#85877F] text-[10px] font-semibold">Trống</span>
                        </div>
                        <span class="font-extrabold text-[#171A19] dark:text-white text-sm">{{ (int)($stats['so_phong_trong'] ?? 0) }}</span>
                    </div>
                    <div>
                        <div class="flex items-center justify-center gap-1.5 mb-1">
                            <span class="inline-block h-2 w-2 rounded-full bg-rose-500"></span>
                            <span class="text-[#85877F] text-[10px] font-semibold">Bảo trì</span>
                        </div>
                        <span class="font-extrabold text-[#171A19] dark:text-white text-sm">{{ (int)($stats['so_phong_bao_tri'] ?? 0) }}</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- 🔹 BẢNG BÀI ĐĂNG GẦN ĐÂY & HOẠT ĐỘNG --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- Bài đăng gần đây --}}
            <div class="lg:col-span-2 bg-white dark:bg-[#181B19] rounded-xl border border-[#E5E3DC] dark:border-[#282D2A] shadow-2xs p-6 card-lift-hover motion-reveal">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h2 class="text-sm sm:text-base font-bold text-[#171A19] dark:text-white flex items-center gap-2">
                            <i class="ri-newspaper-line text-[#1B3D2F] dark:text-[#8BB39D]"></i> Tin Đăng Cho Thuê Gần Đây
                        </h2>
                        <p class="text-xs text-[#85877F] mt-0.5">Trạng thái hiển thị trên cổng tìm kiếm thị trường</p>
                    </div>
                    <a href="{{ route('chu-tro.bai-dang.index') }}" class="text-xs font-bold text-[#1B3D2F] dark:text-[#8BB39D] hover:underline">
                        Quản lý toàn bộ &rarr;
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full text-xs text-[#202421] dark:text-[#EAE8E1]">
                        <thead class="bg-[#FAF9F6] dark:bg-[#202522] text-[#85877F] font-bold uppercase tracking-wider text-[10px] border-y border-[#E5E3DC] dark:border-[#282D2A]">
                            <tr>
                                <th class="py-3 px-3.5 text-left">Tiêu đề bài đăng</th>
                                <th class="py-3 px-3.5 text-right">Giá niêm yết</th>
                                <th class="py-3 px-3.5 text-center">Trạng thái</th>
                                <th class="py-3 px-3.5 text-center">Ngày cập nhật</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[#E5E3DC]/60 dark:divide-[#282D2A] font-medium">
                            @forelse($bai_dang_gan_day as $b)
                                <tr class="hover:bg-[#FAF9F6] dark:hover:bg-[#202522] transition-colors table-row-hover">
                                    <td class="py-3 px-3.5 font-bold text-[#171A19] dark:text-white truncate max-w-xs">{{ $b['tieu_de'] }}</td>
                                    <td class="py-3 px-3.5 text-right text-[#1B3D2F] dark:text-[#8BB39D] font-extrabold">{{ number_format($b['gia_niem_yet']) }} đ</td>
                                    <td class="py-3 px-3.5 text-center">
                                        <span class="px-2 py-0.5 rounded text-[10px] font-bold 
                                            {{ match ($b['trang_thai']) {
                                                'duyet', 'dang' => 'bg-[#E5EDE8] text-[#1B3D2F] dark:bg-[#23352B] dark:text-[#8BB39D]',
                                                'cho_duyet' => 'bg-amber-100 text-amber-800 dark:bg-amber-950/40 dark:text-amber-300',
                                                'an' => 'bg-slate-100 text-slate-600 dark:bg-slate-800 dark:text-slate-400',
                                                default => 'bg-slate-100 text-slate-600 dark:bg-slate-800 dark:text-slate-400'
                                            } }}">
                                            {{ match ($b['trang_thai']) {
                                                'duyet' => 'Đã duyệt',
                                                'cho_duyet' => 'Chờ duyệt',
                                                'dang' => 'Đang hiển thị',
                                                'an' => 'Đang ẩn',
                                                default => $b['trang_thai']
                                            } }}
                                        </span>
                                    </td>
                                    <td class="py-3 px-3.5 text-center text-[#85877F]">{{ \Carbon\Carbon::parse($b['ngay_tao'])->format('d/m/Y') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="p-8 text-center text-[#85877F]">Chưa có bài đăng tin nào trên hệ thống.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Dòng thời gian Hoạt động gần đây --}}
            <div class="bg-white dark:bg-[#181B19] rounded-xl border border-[#E5E3DC] dark:border-[#282D2A] shadow-2xs p-6 card-lift-hover motion-reveal">
                <h2 class="text-sm sm:text-base font-bold text-[#171A19] dark:text-white flex items-center gap-2 mb-1">
                    <i class="ri-history-line text-[#1B3D2F] dark:text-[#8BB39D]"></i> Nhật Ký Vận Hành
                </h2>
                <p class="text-xs text-[#85877F] mb-5">Lịch sử sự kiện và tương tác với khách thuê</p>

                <ol class="relative border-s border-[#E5E3DC] dark:border-[#282D2A] ml-2">
                    @forelse($hoat_dong_gan_day as $hd)
                        <li class="mb-4 ms-3.5">
                            <div class="absolute w-2 h-2 bg-[#1B3D2F] dark:bg-[#8BB39D] rounded-full mt-1.5 -start-[4.5px] ring-4 ring-white dark:ring-[#181B19]"></div>
                            <time class="mb-0.5 text-[10px] font-bold uppercase tracking-wider text-[#85877F] block">
                                {{ \Carbon\Carbon::parse($hd->ngay_tao)->diffForHumans() }}
                            </time>
                            <p class="text-xs font-medium text-[#4A4E4B] dark:text-[#C5C8C4] leading-relaxed">{{ $hd->noi_dung }}</p>
                        </li>
                    @empty
                        <li class="ms-3.5 text-[#85877F] text-xs py-4">Chưa có hoạt động nào được ghi lại.</li>
                    @endforelse
                </ol>
            </div>
        </div>

    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            // Count up animation
            document.querySelectorAll(".count-up").forEach(el => {
                const target = parseInt(el.dataset.count);
                if (!target || isNaN(target)) return;
                let val = 0;
                const duration = 800;
                const start = performance.now();
                const step = (t) => {
                    const p = Math.min((t - start) / duration, 1);
                    val = Math.floor(p * target);
                    el.textContent = val.toLocaleString('vi-VN');
                    if (p < 1) requestAnimationFrame(step);
                };
                requestAnimationFrame(step);
            });

            // === BIỂU ĐỒ DOANH THU ===
            const ctx = document.getElementById('chartRevenue')?.getContext('2d');
            if (ctx) {
                const data = @json($doanh_thu_6_thang ?? []);
                const labels = Object.keys(data);
                const values = Object.values(data);
                const VND = new Intl.NumberFormat('vi-VN');

                const gradient = ctx.createLinearGradient(0, 0, 0, 240);
                gradient.addColorStop(0, 'rgba(27, 61, 47, 0.25)');
                gradient.addColorStop(0.7, 'rgba(27, 61, 47, 0.05)');
                gradient.addColorStop(1, 'rgba(27, 61, 47, 0.0)');

                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: labels.length ? labels.map(m => 'Thg ' + m.split('-')[1]) : ['Chưa có số liệu'],
                        datasets: [{
                            label: 'Doanh thu (VNĐ)',
                            data: values.length ? values : [0],
                            borderColor: '#1B3D2F',
                            backgroundColor: gradient,
                            fill: true,
                            tension: 0.35,
                            borderWidth: 2.5,
                            pointRadius: 4,
                            pointHoverRadius: 6,
                            pointBackgroundColor: '#1B3D2F',
                            pointBorderColor: '#ffffff',
                            pointBorderWidth: 2,
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { display: false },
                            tooltip: {
                                backgroundColor: '#171A19',
                                titleFont: { size: 11, weight: 'bold' },
                                bodyFont: { size: 12 },
                                padding: 10,
                                cornerRadius: 6,
                                displayColors: false,
                                callbacks: {
                                    label: c => ' ' + VND.format(c.parsed.y) + ' đ'
                                }
                            }
                        },
                        scales: {
                            x: { 
                                ticks: { color: '#85877F', font: { size: 11, family: 'Plus Jakarta Sans' } }, 
                                grid: { display: false } 
                            },
                            y: {
                                beginAtZero: true,
                                ticks: { callback: v => VND.format(v) + ' đ', color: '#85877F', font: { size: 10, family: 'Plus Jakarta Sans' } },
                                grid: { color: 'rgba(229, 227, 220, 0.6)' }
                            }
                        },
                        animation: { duration: 900, easing: 'easeOutQuart' }
                    }
                });
            }

            // === BIỂU ĐỒ TÌNH TRẠNG PHÒNG ===
            const occ = {
                dangThue: {{ (int) ($stats['so_phong_dang_thue'] ?? 0) }},
                trong: {{ (int) ($stats['so_phong_trong'] ?? 0) }},
                baoTri: {{ (int) ($stats['so_phong_bao_tri'] ?? 0) }},
            };

            const occCtx = document.getElementById('chartOccupancy')?.getContext('2d');
            if (occCtx) {
                const total = occ.dangThue + occ.trong + occ.baoTri;
                new Chart(occCtx, {
                    type: 'doughnut',
                    data: {
                        labels: ['Đang thuê', 'Trống', 'Bảo trì'],
                        datasets: [{
                            data: total > 0 ? [occ.dangThue, occ.trong, occ.baoTri] : [1],
                            backgroundColor: total > 0 ? ['#1B3D2F', '#F59E0B', '#EF4444'] : ['#E5E3DC'],
                            borderWidth: 2,
                            borderColor: '#ffffff'
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        cutout: '74%',
                        plugins: {
                            legend: { display: false },
                            tooltip: {
                                backgroundColor: '#171A19',
                                cornerRadius: 6,
                                padding: 8,
                                callbacks: {
                                    label: (ctx) => ` ${ctx.label}: ${ctx.parsed} phòng`
                                }
                            }
                        },
                        animation: { animateRotate: true, duration: 900 }
                    }
                });
            }
        });
    </script>
@endpush