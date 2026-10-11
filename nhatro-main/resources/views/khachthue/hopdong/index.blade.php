@extends('layouts.tenant-layout')

@section('title', 'Hợp đồng điện tử — Khách thuê')
@section('page_title', 'Hợp đồng thuê điện tử')
@section('page_subtitle', 'Văn bản cam kết pháp lý số hóa, lưu trữ an toàn và bảo vệ quyền lợi giữa khách thuê và chủ trọ')

@section('tenant_content')
@php
    $hopDongList = collect($hopDong ?? []);
    $totalHd = $hopDongList->count();
    $activeHd = $hopDongList->filter(function($i) {
        $st = data_get($i, 'trang_thai', '');
        return in_array($st, ['hieu_luc', 'active', 'dang_hieu_luc']);
    })->count();
    $expiredHd = $totalHd - $activeHd;
@endphp

<div x-data="{ activeTab: 'all' }" class="space-y-6">

    {{-- TOP ACTION & KPI SUMMARY --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-2 border-b border-[#E5E3DC] dark:border-[#282D2A]">
        <div>
            <h2 class="text-xl sm:text-2xl font-serif font-bold text-[#171A19] dark:text-white tracking-tight">
                Kho Lưu Trữ Hợp Đồng Số
            </h2>
            <p class="text-xs sm:text-sm text-[#5A605B] dark:text-[#9EA39E] mt-1 font-sans">
                Tất cả hợp đồng được xác thực và bảo vệ quyền lợi pháp lý theo đúng quy chuẩn hợp đồng thuê nhà.
            </p>
        </div>

        <a href="{{ route('listing') }}"
            class="inline-flex items-center justify-center gap-2 px-4 py-2 rounded-xl bg-white dark:bg-[#1E2320] border border-[#E5E3DC] dark:border-[#2D332F] hover:bg-[#FAF9F6] text-[#171A19] dark:text-white text-xs sm:text-sm font-medium shadow-xs transition">
            <i class="ri-search-line text-[#1B3D2F] dark:text-[#A3E635]"></i>
            <span>Tìm thuê thêm phòng</span>
        </a>
    </div>

    {{-- STATS GRID --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
        <div class="bg-white dark:bg-[#1E2320] rounded-2xl p-5 border border-[#E5E3DC] dark:border-[#2D332F] shadow-sm flex items-center justify-between">
            <div>
                <span class="text-[11px] font-bold uppercase tracking-wider text-[#5A605B] dark:text-[#9EA39E] block mb-1">Tổng hợp đồng</span>
                <p class="text-2xl sm:text-3xl font-serif font-bold text-[#171A19] dark:text-white">{{ $totalHd }}</p>
            </div>
            <div class="w-11 h-11 rounded-xl bg-[#FAF9F6] dark:bg-[#282D2A] border border-[#E5E3DC] dark:border-[#343B36] text-[#171A19] dark:text-white flex items-center justify-center text-xl">
                <i class="ri-file-text-line"></i>
            </div>
        </div>

        <div class="bg-white dark:bg-[#1E2320] rounded-2xl p-5 border border-emerald-200/80 dark:border-emerald-900/40 shadow-sm flex items-center justify-between">
            <div>
                <span class="text-[11px] font-bold uppercase tracking-wider text-emerald-700 dark:text-emerald-400 block mb-1">Đang có hiệu lực</span>
                <p class="text-2xl sm:text-3xl font-serif font-bold text-emerald-700 dark:text-emerald-400">{{ $activeHd }}</p>
            </div>
            <div class="w-11 h-11 rounded-xl bg-emerald-50 dark:bg-emerald-950/60 text-emerald-700 dark:text-emerald-400 flex items-center justify-center text-xl">
                <i class="ri-shield-check-line"></i>
            </div>
        </div>

        <div class="bg-white dark:bg-[#1E2320] rounded-2xl p-5 border border-[#E5E3DC] dark:border-[#2D332F] shadow-sm flex items-center justify-between">
            <div>
                <span class="text-[11px] font-bold uppercase tracking-wider text-[#5A605B] dark:text-[#9EA39E] block mb-1">Đã kết thúc / Hết hạn</span>
                <p class="text-2xl sm:text-3xl font-serif font-bold text-[#5A605B] dark:text-[#9EA39E]">{{ $expiredHd }}</p>
            </div>
            <div class="w-11 h-11 rounded-xl bg-[#FAF9F6] dark:bg-[#282D2A] text-gray-400 flex items-center justify-center text-xl">
                <i class="ri-history-line"></i>
            </div>
        </div>
    </div>

    {{-- FILTER DROPDOWN --}}
    <div class="bg-white dark:bg-[#1E2320] rounded-2xl p-3 border border-[#E5E3DC] dark:border-[#2D332F] shadow-2xs flex items-center justify-between">
        <div class="flex items-center gap-2.5">
            <label class="text-xs font-semibold text-[#5A605B] dark:text-[#9EA39E] whitespace-nowrap flex items-center gap-1.5">
                <i class="ri-filter-3-line"></i> Lọc hợp đồng:
            </label>
            <div class="relative min-w-[210px]">
                <select x-model="activeTab"
                    class="w-full appearance-none py-2 pl-3.5 pr-8 text-xs font-medium rounded-xl border border-[#E5E3DC] dark:border-[#343B36] bg-[#FAF9F6] dark:bg-[#282D2A] text-[#171A19] dark:text-white focus:outline-none focus:ring-1 focus:ring-[#1B3D2F] cursor-pointer transition">
                    <option value="all">Tất cả hợp đồng ({{ $totalHd }})</option>
                    <option value="active">Đang hiệu lực ({{ $activeHd }})</option>
                    <option value="expired">Đã kết thúc / Hủy ({{ $expiredHd }})</option>
                </select>
                <i class="ri-arrow-down-s-line absolute right-2.5 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none text-sm"></i>
            </div>
        </div>
    </div>

    {{-- CONTENT LIST --}}
    @if($hopDongList->isEmpty())
        <div class="bg-white dark:bg-[#1E2320] rounded-3xl p-12 border border-dashed border-[#E5E3DC] dark:border-[#2D332F] text-center space-y-4">
            <div class="w-16 h-16 rounded-2xl bg-[#1B3D2F]/10 dark:bg-[#244B3B]/40 text-[#1B3D2F] dark:text-[#A3E635] flex items-center justify-center text-3xl mx-auto">
                <i class="ri-file-shield-line"></i>
            </div>
            <div class="space-y-1">
                <h3 class="text-base font-serif font-bold text-[#171A19] dark:text-white">Hiện bạn chưa có hợp đồng nào</h3>
                <p class="text-xs sm:text-sm text-[#5A605B] dark:text-[#9EA39E] max-w-md mx-auto">
                    Sau khi chủ nhà duyệt yêu cầu thuê của bạn, hợp đồng số sẽ được khởi tạo và lưu trữ đầy đủ tại đây.
                </p>
            </div>
            <div class="pt-2">
                <a href="{{ route('khach-thue.yeu-cau-thue.index') }}"
                    class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-[#1B3D2F] hover:bg-[#244B3B] text-white text-xs sm:text-sm font-semibold transition shadow-sm">
                    <i class="ri-mail-send-line"></i> Xem yêu cầu thuê đang gửi
                </a>
            </div>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach($hopDongList as $hd)
                @php
                    $phong = data_get($hd, 'phong', []);
                    $dayTro = data_get($phong, 'day_tro', []);
                    $st = data_get($hd, 'trang_thai', 'hieu_luc');
                    $hdId = data_get($hd, 'id') ?? data_get($hd, 'hop_dong_id');

                    $isActive = in_array($st, ['hieu_luc', 'active', 'dang_hieu_luc']);
                    $badgeClass = $isActive ? 'bg-emerald-50 text-emerald-800 border-emerald-200 dark:bg-emerald-950/40 dark:text-emerald-400 dark:border-emerald-800' : 'bg-gray-100 text-gray-700 border-gray-200 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-700';
                    $badgeText = $isActive ? 'Đang có hiệu lực' : 'Đã kết thúc / Hết hạn';

                    $nbd = data_get($hd, 'ngay_bat_dau');
                    $nkt = data_get($hd, 'ngay_ket_thuc');

                    $progressPct = 50;
                    if ($nbd && $nkt) {
                        $start = \Carbon\Carbon::parse($nbd)->timestamp;
                        $end = \Carbon\Carbon::parse($nkt)->timestamp;
                        $now = time();
                        if ($end > $start) {
                            $progressPct = max(0, min(100, round((($now - $start) / ($end - $start)) * 100)));
                        }
                    }
                @endphp

                <div x-show="activeTab === 'all' || (activeTab === 'active' && {{ $isActive ? 'true' : 'false' }}) || (activeTab === 'expired' && {{ !$isActive ? 'true' : 'false' }})"
                    class="bg-white dark:bg-[#1E2320] rounded-2xl p-5 border border-[#E5E3DC] dark:border-[#2D332F] shadow-sm hover:border-[#1B3D2F]/30 transition flex flex-col justify-between gap-4">

                    <div class="space-y-4">
                        {{-- Header Row --}}
                        <div class="flex items-center justify-between gap-3 border-b border-[#E5E3DC] dark:border-[#282D2A] pb-3.5">
                            <div class="flex items-center gap-2">
                                <span class="w-8 h-8 rounded-xl bg-[#1B3D2F]/10 dark:bg-[#244B3B]/40 text-[#1B3D2F] dark:text-[#A3E635] flex items-center justify-center text-base font-bold">
                                    <i class="ri-file-text-line"></i>
                                </span>
                                <div>
                                    <span class="text-xs font-serif font-bold text-[#171A19] dark:text-white">HỢP ĐỒNG SỐ</span>
                                    <p class="text-[11px] font-mono font-bold text-[#A6824D]">#HĐ-{{ $hdId ?? '00' }}</p>
                                </div>
                            </div>

                            <span class="px-2.5 py-1 rounded-full text-[11px] font-semibold border {{ $badgeClass }}">
                                {{ $badgeText }}
                            </span>
                        </div>

                        {{-- Main Info --}}
                        <div>
                            <h3 class="text-base font-serif font-bold text-[#171A19] dark:text-white">
                                Phòng {{ data_get($phong, 'so_phong', '—') }} • {{ data_get($dayTro, 'ten_day_tro', 'Khu trọ') }}
                            </h3>
                            <p class="text-xs text-[#5A605B] dark:text-[#9EA39E] mt-1 flex items-center gap-1.5">
                                <i class="ri-map-pin-line text-[#A6824D]"></i>
                                <span class="truncate">{{ data_get($dayTro, 'dia_chi', 'Chưa có địa chỉ') }}</span>
                            </p>
                        </div>

                        {{-- Lease Dates & Progress --}}
                        <div class="space-y-2 p-3.5 rounded-xl bg-[#FAF9F6] dark:bg-[#282D2A]/60 border border-[#E5E3DC] dark:border-[#343B36] text-xs">
                            <div class="flex justify-between items-center text-[#5A605B] dark:text-[#9EA39E]">
                                <span>Bắt đầu: <strong class="text-[#171A19] dark:text-white">{{ $nbd ? \Carbon\Carbon::parse($nbd)->format('d/m/Y') : '—' }}</strong></span>
                                <span>Hết hạn: <strong class="text-[#171A19] dark:text-white">{{ $nkt ? \Carbon\Carbon::parse($nkt)->format('d/m/Y') : '—' }}</strong></span>
                            </div>

                            {{-- Progress Bar --}}
                            @if($isActive)
                                <div class="w-full bg-[#E5E3DC] dark:bg-[#343B36] h-1.5 rounded-full overflow-hidden">
                                    <div class="bg-[#1B3D2F] dark:bg-[#A3E635] h-1.5 rounded-full transition-all duration-500"
                                        style="width: {{ $progressPct }}%"></div>
                                </div>
                                <div class="flex justify-between items-center text-[10px] text-[#5A605B] dark:text-[#9EA39E]">
                                    <span>Thời hạn cư trú</span>
                                    <span class="font-semibold text-[#1B3D2F] dark:text-[#A3E635]">{{ $progressPct }}% thời gian</span>
                                </div>
                            @endif
                        </div>

                        {{-- Money Row --}}
                        <div class="grid grid-cols-2 gap-3 text-xs">
                            <div>
                                <span class="text-[#5A605B] dark:text-[#9EA39E] text-[11px] block">Giá thuê tháng:</span>
                                <span class="font-bold text-[#171A19] dark:text-white">
                                    {{ number_format(data_get($phong, 'gia', 0)) }} đ
                                </span>
                            </div>
                            <div>
                                <span class="text-[#5A605B] dark:text-[#9EA39E] text-[11px] block">Tiền cọc đảm bảo:</span>
                                <span class="font-bold text-[#1B3D2F] dark:text-[#4ADE80]">
                                    {{ number_format(data_get($hd, 'tien_coc', 0)) }} đ
                                </span>
                            </div>
                        </div>
                    </div>

                    {{-- Actions --}}
                    <div class="pt-3 border-t border-[#E5E3DC] dark:border-[#282D2A] flex items-center justify-between gap-2">
                        @if(!empty($hd['url_file_hop_dong']))
                            <a href="{{ $hd['url_file_hop_dong'] }}" target="_blank"
                                class="px-3 py-1.5 rounded-lg border border-[#E5E3DC] dark:border-[#2D332F] bg-[#FAF9F6] dark:bg-[#282D2A] hover:bg-white text-[#171A19] dark:text-white text-xs font-medium transition flex items-center gap-1.5">
                                <i class="ri-file-pdf-line text-rose-500"></i> File PDF
                            </a>
                        @else
                            <a href="{{ asset('files/hopdong_mau.pdf') }}" target="_blank"
                                class="px-3 py-1.5 rounded-lg border border-[#E5E3DC] dark:border-[#2D332F] bg-[#FAF9F6] dark:bg-[#282D2A] hover:bg-white text-[#171A19] dark:text-white text-xs font-medium transition flex items-center gap-1.5">
                                <i class="ri-file-pdf-line text-rose-500"></i> Hợp đồng mẫu
                            </a>
                        @endif

                        @if($hdId)
                            <a href="{{ route('khach-thue.hop-dong.show', $hdId) }}"
                                class="px-3.5 py-1.5 rounded-lg bg-[#1B3D2F] hover:bg-[#244B3B] text-white text-xs font-medium transition flex items-center gap-1 shadow-xs">
                                <span>Xem chi tiết</span>
                                <i class="ri-arrow-right-line"></i>
                            </a>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @endif

</div>
@endsection
