@extends('layouts.tenant-layout')

@section('title', 'Bảng điều khiển Khách thuê - Hệ Thống Trọ')
@section('page_title', 'Bảng điều khiển tổng quan')
@section('page_subtitle', 'Tổng quan hợp đồng cư trú, nghĩa vụ thanh toán định kỳ và thông báo từ ban quản lý')

@section('tenant_content')
@php
    $curUser = session('user') ?? auth()->user();
    $hoTen = $curUser['ho_ten'] ?? $curUser->ho_ten ?? 'Cư dân';
    $email = $curUser['email'] ?? $curUser->email ?? '';
    $sdt = $curUser['so_dien_thoai'] ?? $curUser->so_dien_thoai ?? '';

    $hopDongList = collect($hopDong ?? []);
    $hoaDonList = collect($hoaDon ?? []);
    $thongBaoList = collect($thongBao ?? []);
    $yeuCauList = collect($yeuCauThue ?? []);

    $activeHopDong = $hopDongList->where('trang_thai', 'hieu_luc')->first() ?? $hopDongList->first();

    $unpaidInvoices = $hoaDonList->where('trang_thai', 'chua_thanh_toan');
    $unpaidCount = $unpaidInvoices->count();
    $unpaidTotal = $unpaidInvoices->sum('tong_tien');

    $pendingYeuCauCount = $yeuCauList->where('trang_thai', 'cho_duyet')->count();
    $unreadNoticeCount = $thongBaoList->where('da_xem', 0)->count();
@endphp

<div class="space-y-6">

    {{-- 1. EXECUTIVE WELCOME STRIP --}}
    <div class="motion-reveal card-lift-hover bg-[#FAF9F6] dark:bg-[#1F2321] rounded-xl p-5 sm:p-6 border border-[#E5E3DC] dark:border-[#2D3330] flex flex-col md:flex-row md:items-center justify-between gap-5">
        <div class="space-y-1.5">
            <div class="flex items-center gap-2">
                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded text-[11px] font-semibold bg-emerald-50 dark:bg-emerald-950/60 text-emerald-800 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800">
                    <i class="ri-shield-check-fill text-emerald-600 dark:text-emerald-400"></i> Hồ sơ khách thuê xác thực
                </span>
                <span class="text-xs text-[#85877F]">• Cư dân hệ thống</span>
            </div>
            <h2 class="text-xl sm:text-2xl font-extrabold text-[#171A19] dark:text-white tracking-tight">
                Xin chào, {{ $hoTen }}
            </h2>
            <p class="text-xs sm:text-sm text-[#70746F] dark:text-[#A6AAA7] max-w-xl">
                Theo dõi tình trạng phòng trọ, đối soát chỉ số công tơ điện nước hàng tháng và quản lý hợp đồng thuê phòng minh bạch.
            </p>
        </div>

        <div class="flex items-center gap-2.5 shrink-0">
            <a href="{{ route('khach-thue.hoa-don.index') }}"
                class="micro-press inline-flex items-center gap-2 px-4 py-2.5 rounded-lg bg-[#1B3D2F] hover:bg-[#142F24] text-white text-xs sm:text-sm font-semibold transition shadow-2xs cursor-pointer">
                <i class="ri-qr-code-line text-sm"></i>
                <span>Thanh toán hóa đơn</span>
            </a>
            <a href="{{ route('listing') }}"
                class="micro-press inline-flex items-center gap-2 px-4 py-2.5 rounded-lg bg-white dark:bg-[#181B19] hover:bg-[#FAF9F6] dark:hover:bg-[#202522] text-[#171A19] dark:text-white border border-[#E5E3DC] dark:border-[#303632] text-xs sm:text-sm font-semibold transition">
                <i class="ri-search-line text-sm text-[#85877F]"></i>
                <span>Khám phá phòng</span>
            </a>
        </div>
    </div>

    {{-- 2. OPERATIONAL KPI METRICS --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">

        {{-- KPI 1: HỢP ĐỒNG ĐANG THUÊ --}}
        <div class="motion-reveal motion-stagger-1 card-lift-hover bg-white dark:bg-[#181B19] rounded-xl p-4.5 border border-[#E5E3DC] dark:border-[#282D2A] shadow-2xs flex flex-col justify-between">
            <div class="flex items-center justify-between gap-2">
                <span class="text-[11px] font-bold uppercase tracking-wider text-[#85877F]">Hợp đồng cư trú</span>
                <span class="w-7 h-7 rounded-md bg-[#FAF9F6] dark:bg-[#202522] text-[#1B3D2F] dark:text-[#A3B899] flex items-center justify-center text-sm border border-[#E5E3DC] dark:border-[#303632]">
                    <i class="ri-file-text-line"></i>
                </span>
            </div>
            <div class="my-2.5">
                <span class="text-2xl font-black text-[#171A19] dark:text-white tracking-tight">
                    <span class="count-up" data-counter="{{ (int)$hopDongList->count() }}">{{ $hopDongList->count() }}</span>
                </span>
            </div>
            <div class="flex items-center gap-1.5 text-xs font-medium {{ $activeHopDong ? 'text-emerald-700 dark:text-emerald-400' : 'text-[#85877F]' }}">
                <span class="w-1.5 h-1.5 rounded-full {{ $activeHopDong ? 'bg-emerald-500' : 'bg-stone-300' }}"></span>
                <span>{{ $activeHopDong ? 'Đang hiệu lực cư trú' : 'Chưa có hợp đồng nào' }}</span>
            </div>
        </div>

        {{-- KPI 2: HÓA ĐƠN CẦN THANH TOÁN --}}
        <div class="motion-reveal motion-stagger-2 card-lift-hover bg-white dark:bg-[#181B19] rounded-xl p-4.5 border border-[#E5E3DC] dark:border-[#282D2A] shadow-2xs flex flex-col justify-between">
            <div class="flex items-center justify-between gap-2">
                <span class="text-[11px] font-bold uppercase tracking-wider text-[#85877F]">Nghĩa vụ chưa thanh toán</span>
                <span class="w-7 h-7 rounded-md bg-[#FAF9F6] dark:bg-[#202522] text-[#A6824D] flex items-center justify-center text-sm border border-[#E5E3DC] dark:border-[#303632]">
                    <i class="ri-bill-line"></i>
                </span>
            </div>
            <div class="my-2.5">
                <span class="text-2xl font-black text-[#171A19] dark:text-white tracking-tight">
                    <span class="count-up" data-counter="{{ (int)$unpaidTotal }}">{{ number_format($unpaidTotal) }}</span><span class="text-xs font-semibold text-[#85877F] ml-0.5">₫</span>
                </span>
            </div>
            <div class="flex items-center gap-1.5 text-xs font-medium {{ $unpaidCount > 0 ? 'text-amber-700 dark:text-amber-400' : 'text-emerald-700 dark:text-emerald-400' }}">
                <i class="{{ $unpaidCount > 0 ? 'ri-time-line' : 'ri-check-line' }}"></i>
                <span>{{ $unpaidCount > 0 ? ($unpaidCount . ' hóa đơn cần đối soát') : 'Đã tất toán toàn bộ' }}</span>
            </div>
        </div>

        {{-- KPI 3: YÊU CẦU GIỮ CHỖ --}}
        <div class="motion-reveal motion-stagger-3 card-lift-hover bg-white dark:bg-[#181B19] rounded-xl p-4.5 border border-[#E5E3DC] dark:border-[#282D2A] shadow-2xs flex flex-col justify-between">
            <div class="flex items-center justify-between gap-2">
                <span class="text-[11px] font-bold uppercase tracking-wider text-[#85877F]">Hồ sơ yêu cầu thuê</span>
                <span class="w-7 h-7 rounded-md bg-[#FAF9F6] dark:bg-[#202522] text-[#1B3D2F] dark:text-[#A3B899] flex items-center justify-center text-sm border border-[#E5E3DC] dark:border-[#303632]">
                    <i class="ri-mail-send-line"></i>
                </span>
            </div>
            <div class="my-2.5">
                <span class="text-2xl font-black text-[#171A19] dark:text-white tracking-tight">
                    <span class="count-up" data-counter="{{ (int)$pendingYeuCauCount }}">{{ $pendingYeuCauCount }}</span>
                </span>
            </div>
            <div class="flex items-center gap-1.5 text-xs font-medium text-[#70746F] dark:text-[#A6AAA7]">
                <span class="w-1.5 h-1.5 rounded-full {{ $pendingYeuCauCount > 0 ? 'bg-amber-500' : 'bg-stone-300' }}"></span>
                <span>{{ $pendingYeuCauCount > 0 ? 'Đang chờ chủ trọ duyệt' : 'Không có hồ sơ chờ' }}</span>
            </div>
        </div>

        {{-- KPI 4: THÔNG BÁO MỚI --}}
        <div class="motion-reveal motion-stagger-4 card-lift-hover bg-white dark:bg-[#181B19] rounded-xl p-4.5 border border-[#E5E3DC] dark:border-[#282D2A] shadow-2xs flex flex-col justify-between">
            <div class="flex items-center justify-between gap-2">
                <span class="text-[11px] font-bold uppercase tracking-wider text-[#85877F]">Thông báo mới</span>
                <span class="w-7 h-7 rounded-md bg-[#FAF9F6] dark:bg-[#202522] text-rose-600 flex items-center justify-center text-sm border border-[#E5E3DC] dark:border-[#303632]">
                    <i class="ri-notification-3-line"></i>
                </span>
            </div>
            <div class="my-2.5">
                <span class="text-2xl font-black text-[#171A19] dark:text-white tracking-tight">
                    <span class="count-up" data-counter="{{ (int)$unreadNoticeCount }}">{{ $unreadNoticeCount }}</span>
                </span>
            </div>
            <div class="flex items-center gap-1.5 text-xs font-medium {{ $unreadNoticeCount > 0 ? 'text-rose-600 dark:text-rose-400' : 'text-[#85877F]' }}">
                <i class="ri-message-3-line"></i>
                <span>{{ $unreadNoticeCount > 0 ? ($unreadNoticeCount . ' tin nhắn chưa đọc') : 'Đã cập nhật hết tin' }}</span>
            </div>
        </div>

    </div>

    {{-- 3. TWO-COLUMN MAIN CONTENT --}}
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">

        {{-- LEFT COLUMN (7 COLS): ACTIVE ROOM & RECENT INVOICES --}}
        <div class="lg:col-span-7 space-y-6">

            {{-- CĂN HỘ ĐANG THUÊ --}}
            <div class="bg-white dark:bg-[#181B19] rounded-xl p-5 border border-[#E5E3DC] dark:border-[#282D2A] shadow-2xs space-y-4">
                <div class="flex items-center justify-between border-b border-[#EAE8E1] dark:border-[#262B28] pb-3">
                    <div class="flex items-center gap-2">
                        <span class="w-6 h-6 rounded bg-[#FAF9F6] dark:bg-[#202522] text-[#1B3D2F] dark:text-[#A3B899] flex items-center justify-center text-xs font-bold border border-[#E5E3DC] dark:border-[#303632]">
                            <i class="ri-home-4-line"></i>
                        </span>
                        <h3 class="text-xs sm:text-sm font-bold text-[#171A19] dark:text-white uppercase tracking-wider">Căn hộ đang cư trú</h3>
                    </div>
                    <a href="{{ route('khach-thue.phong.index') }}" class="text-xs font-semibold text-[#1B3D2F] dark:text-[#A3B899] hover:underline">
                        Quản lý phòng &rarr;
                    </a>
                </div>

                @if($activeHopDong)
                    @php
                        $phongActive = $activeHopDong['phong'] ?? [];
                        $dayTroActive = $phongActive['day_tro'] ?? [];
                    @endphp
                    <div class="p-4 rounded-lg bg-[#FAF9F6] dark:bg-[#1F2321] border border-[#E5E3DC] dark:border-[#2D3330] space-y-3">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                            <div>
                                <span class="inline-block px-2 py-0.5 rounded text-[10px] font-bold bg-emerald-50 text-emerald-800 dark:bg-emerald-950 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800 mb-1">
                                    Đang hiệu lực
                                </span>
                                <h4 class="text-base font-bold text-[#171A19] dark:text-white">
                                    Phòng {{ $phongActive['so_phong'] ?? 'Phòng' }} • {{ $dayTroActive['ten_day_tro'] ?? 'Khu trọ' }}
                                </h4>
                                <p class="text-xs text-[#70746F] dark:text-[#A6AAA7] mt-0.5 flex items-center gap-1">
                                    <i class="ri-map-pin-line text-[#85877F]"></i>
                                    {{ $dayTroActive['dia_chi'] ?? 'TP. Hồ Chí Minh' }}
                                </p>
                            </div>

                            <div class="text-left sm:text-right shrink-0">
                                <span class="text-[11px] text-[#85877F] block">Giá thuê niêm yết:</span>
                                <span class="text-base font-black text-[#1B3D2F] dark:text-[#A3B899]">
                                    {{ number_format($phongActive['gia'] ?? 0) }}₫/tháng
                                </span>
                            </div>
                        </div>

                        <div class="flex items-center justify-between pt-2.5 border-t border-[#EAE8E1] dark:border-[#262B28] text-xs">
                            <span class="text-[#70746F] dark:text-[#A6AAA7]">Thời hạn HĐ: <strong class="text-[#171A19] dark:text-white">{{ !empty($activeHopDong['ngay_ket_thuc']) ? \Carbon\Carbon::parse($activeHopDong['ngay_ket_thuc'])->format('d/m/Y') : '--' }}</strong></span>
                            <a href="{{ route('khach-thue.hop-dong.show', $activeHopDong['id'] ?? 1) }}" class="text-[#1B3D2F] dark:text-[#A3B899] font-bold hover:underline">
                                Xem hợp đồng điện tử &rarr;
                            </a>
                        </div>
                    </div>
                @else
                    <div class="text-center py-8 text-xs text-[#85877F] space-y-2">
                        <i class="ri-home-line text-2xl text-[#85877F] block"></i>
                        <p>Bạn chưa có hợp đồng phòng nào đang có hiệu lực.</p>
                        <a href="{{ route('listing') }}" class="inline-block text-[#1B3D2F] dark:text-[#A3B899] font-bold hover:underline">
                            Khám phá phòng trọ phù hợp &rarr;
                        </a>
                    </div>
                @endif
            </div>

            {{-- HÓA ĐƠN TIỀN PHÒNG --}}
            <div class="bg-white dark:bg-[#181B19] rounded-xl p-5 border border-[#E5E3DC] dark:border-[#282D2A] shadow-2xs space-y-4">
                <div class="flex items-center justify-between border-b border-[#EAE8E1] dark:border-[#262B28] pb-3">
                    <div class="flex items-center gap-2">
                        <span class="w-6 h-6 rounded bg-[#FAF9F6] dark:bg-[#202522] text-[#A6824D] flex items-center justify-center text-xs font-bold border border-[#E5E3DC] dark:border-[#303632]">
                            <i class="ri-bill-line"></i>
                        </span>
                        <h3 class="text-xs sm:text-sm font-bold text-[#171A19] dark:text-white uppercase tracking-wider">Hóa đơn định kỳ gần nhất</h3>
                    </div>
                    <a href="{{ route('khach-thue.hoa-don.index') }}" class="text-xs font-semibold text-[#1B3D2F] dark:text-[#A3B899] hover:underline">
                        Xem tất cả &rarr;
                    </a>
                </div>

                <div class="divide-y divide-[#EAE8E1] dark:divide-[#262B28]">
                    @forelse($hoaDonList->take(3) as $hd)
                        @php
                            $isPaid = ($hd['trang_thai'] ?? '') === 'da_thanh_toan';
                        @endphp
                        <div class="py-3 flex items-center justify-between gap-3 text-xs">
                            <div class="flex items-center gap-2.5">
                                <span class="w-2 h-2 rounded-full {{ $isPaid ? 'bg-emerald-500' : 'bg-amber-500' }}"></span>
                                <div>
                                    <p class="font-bold text-[#171A19] dark:text-white">Hóa đơn Tháng {{ $hd['thang'] ?? '--' }}</p>
                                    <p class="text-[11px] text-[#85877F]">Hạn thanh toán: {{ !empty($hd['han_thanh_toan']) ? \Carbon\Carbon::parse($hd['han_thanh_toan'])->format('d/m/Y') : '--' }}</p>
                                </div>
                            </div>

                            <div class="flex items-center gap-3">
                                <span class="font-extrabold text-[#171A19] dark:text-white">{{ number_format($hd['tong_tien'] ?? 0) }}₫</span>
                                <a href="{{ route('khach-thue.hoa-don.show', $hd['id']) }}" class="text-[#1B3D2F] dark:text-[#A3B899] font-bold hover:underline">
                                    Chi tiết
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-6 text-xs text-[#85877F]">
                            Không có hóa đơn nào trong hệ thống.
                        </div>
                    @endforelse
                </div>
            </div>

        </div>

        {{-- RIGHT COLUMN (5 COLS): REQUESTS PROGRESS & NOTIFICATIONS --}}
        <div class="lg:col-span-5 space-y-6">

            {{-- TIẾN ĐỘ YÊU CẦU THUÊ PHÒNG --}}
            <div class="bg-white dark:bg-[#181B19] rounded-xl p-5 border border-[#E5E3DC] dark:border-[#282D2A] shadow-2xs space-y-4">
                <div class="flex items-center justify-between border-b border-[#EAE8E1] dark:border-[#262B28] pb-3">
                    <h3 class="text-xs sm:text-sm font-bold text-[#171A19] dark:text-white uppercase tracking-wider flex items-center gap-2">
                        <i class="ri-mail-send-line text-[#1B3D2F] dark:text-[#A3B899]"></i> Hồ sơ yêu cầu thuê
                    </h3>
                    <a href="{{ route('khach-thue.yeu-cau-thue.index') }}" class="text-xs font-semibold text-[#1B3D2F] dark:text-[#A3B899] hover:underline">
                        Tất cả ({{ $yeuCauList->count() }}) &rarr;
                    </a>
                </div>

                <div class="space-y-2.5">
                    @forelse($yeuCauList->take(3) as $ycItem)
                        @php
                            $stYc = $ycItem['trang_thai'] ?? 'cho_duyet';
                            $lbl = match($stYc) {
                                'cho_duyet' => 'Chờ duyệt',
                                'chap_nhan' => 'Đã duyệt',
                                'da_tao_hop_dong' => 'Đã có HĐ',
                                default => 'Đã hủy'
                            };
                            $cls = match($stYc) {
                                'cho_duyet' => 'bg-amber-50 text-amber-800 dark:bg-amber-950 dark:text-amber-300 border border-amber-200 dark:border-amber-800',
                                'chap_nhan' => 'bg-emerald-50 text-emerald-800 dark:bg-emerald-950 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800',
                                'da_tao_hop_dong' => 'bg-[#FAF9F6] text-[#1B3D2F] border border-[#E5E3DC]',
                                default => 'bg-stone-100 text-stone-600'
                            };
                        @endphp
                        <div class="p-3 rounded-lg bg-[#FAF9F6] dark:bg-[#1F2321] border border-[#E5E3DC] dark:border-[#2D3330] space-y-1.5 text-xs">
                            <div class="flex items-center justify-between gap-2">
                                <h4 class="font-bold text-[#171A19] dark:text-white truncate">
                                    {{ $ycItem['bai_dang']['tieu_de'] ?? 'Hồ sơ thuê phòng' }}
                                </h4>
                                <span class="px-2 py-0.5 rounded text-[10px] font-bold {{ $cls }} shrink-0">
                                    {{ $lbl }}
                                </span>
                            </div>
                            <div class="flex justify-between items-center text-[11px] text-[#85877F]">
                                <span>Cọc giữ chỗ: <strong class="text-[#171A19] dark:text-white">{{ number_format($ycItem['tien_coc'] ?? 0) }}₫</strong></span>
                                <span>{{ !empty($ycItem['ngay_tao']) ? \Carbon\Carbon::parse($ycItem['ngay_tao'])->diffForHumans() : '' }}</span>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-6 text-xs text-[#85877F]">
                            Chưa có hồ sơ yêu cầu thuê phòng nào.
                        </div>
                    @endforelse
                </div>
            </div>

            {{-- THÔNG BÁO TỪ CHỦ NHÀ --}}
            <div class="bg-white dark:bg-[#181B19] rounded-xl p-5 border border-[#E5E3DC] dark:border-[#282D2A] shadow-2xs space-y-4">
                <div class="flex items-center justify-between border-b border-[#EAE8E1] dark:border-[#262B28] pb-3">
                    <h3 class="text-xs sm:text-sm font-bold text-[#171A19] dark:text-white uppercase tracking-wider flex items-center gap-2">
                        <i class="ri-notification-3-line text-[#85877F]"></i> Thông báo từ ban quản lý
                    </h3>
                    <a href="{{ route('khach-thue.thong-bao.index') }}" class="text-xs font-semibold text-[#1B3D2F] dark:text-[#A3B899] hover:underline">
                        Tất cả &rarr;
                    </a>
                </div>

                <div class="divide-y divide-[#EAE8E1] dark:divide-[#262B28]">
                    @forelse($thongBaoList->take(3) as $tb)
                        <div class="py-2.5 flex items-start gap-2.5 text-xs">
                            <span class="w-1.5 h-1.5 rounded-full {{ ($tb['da_xem'] ?? 0) == 0 ? 'bg-[#1B3D2F] dark:bg-emerald-400 mt-1.5' : 'bg-stone-300 mt-1.5' }} shrink-0"></span>
                            <div class="min-w-0 flex-1">
                                <p class="text-[#171A19] dark:text-[#E8EAE9] line-clamp-2 leading-relaxed">
                                    {{ $tb['noi_dung'] ?? '(Không có nội dung)' }}
                                </p>
                                <span class="text-[10px] text-[#85877F] block mt-0.5">
                                    {{ !empty($tb['ngay_tao']) ? \Carbon\Carbon::parse($tb['ngay_tao'])->diffForHumans() : '' }}
                                </span>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-6 text-xs text-[#85877F]">
                            Không có thông báo mới.
                        </div>
                    @endforelse
                </div>
            </div>

        </div>

    </div>

</div>
@endsection
