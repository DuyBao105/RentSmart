@extends('layouts.tenant-layout')

@section('title', 'Yêu cầu thuê phòng — Khách thuê')
@section('page_title', 'Hồ sơ yêu cầu thuê phòng')
@section('page_subtitle', 'Theo dõi trạng thái xét duyệt hồ sơ giữ chỗ từ chủ trọ và hoàn tất ký hợp đồng số')

@section('tenant_content')
@php
    $collection = collect($yeuCauThue ?? []);
    $totalCount = $collection->count();
    $choDuyetCount = $collection->where('trang_thai', 'cho_duyet')->count();
    $chapNhanCount = $collection->where('trang_thai', 'chap_nhan')->count();
    $hopDongCount = $collection->where('trang_thai', 'da_tao_hop_dong')->count();
    $tuChoiCount = $collection->filter(function($i) {
        return in_array($i['trang_thai'] ?? '', ['tu_choi', 'huy', 'chu_tro_huy_hop_dong']);
    })->count();
@endphp

<div x-data="{
    activeTab: 'all',
    search: '',
    matches(st, searchData) {
        let tabMatch = (this.activeTab === 'all');
        if (this.activeTab === 'cho_duyet') tabMatch = (st === 'cho_duyet');
        else if (this.activeTab === 'chap_nhan') tabMatch = (st === 'chap_nhan');
        else if (this.activeTab === 'da_tao_hop_dong') tabMatch = (st === 'da_tao_hop_dong');
        else if (this.activeTab === 'tu_choi') tabMatch = ['tu_choi', 'huy', 'chu_tro_huy_hop_dong'].includes(st);

        const kw = this.search.trim().toLowerCase();
        const searchMatch = !kw || searchData.includes(kw);
        return tabMatch && searchMatch;
    }
}" class="space-y-6">

    {{-- TOP BAR --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-2 border-b border-[#E5E3DC] dark:border-[#282D2A]">
        <div>
            <h2 class="text-xl sm:text-2xl font-serif font-bold text-[#171A19] dark:text-white tracking-tight">
                Danh Sách Hồ Sơ Giữ Chỗ & Thuê Phòng
            </h2>
            <p class="text-xs sm:text-sm text-[#5A605B] dark:text-[#9EA39E] mt-1 font-sans">
                Quản lý các đề xuất thuê đã gửi, kiểm tra phản hồi từ chủ trọ trong vòng 24 giờ làm việc.
            </p>
        </div>

        <a href="{{ route('khach-thue.yeu-cau-thue.create') }}"
            class="inline-flex items-center justify-center gap-1.5 px-4 py-2.5 rounded-xl bg-[#1B3D2F] hover:bg-[#244B3B] text-white text-xs sm:text-sm font-semibold transition shadow-xs shrink-0">
            <i class="ri-add-line text-sm"></i>
            <span>Tạo yêu cầu thuê mới</span>
        </a>
    </div>

    {{-- STATS PILLS --}}
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 sm:gap-4">
        <div class="bg-white dark:bg-[#1E2320] rounded-2xl p-4 border border-[#E5E3DC] dark:border-[#2D332F] shadow-2xs flex items-center justify-between">
            <div>
                <span class="text-[11px] font-bold uppercase tracking-wider text-[#5A605B] dark:text-[#9EA39E] block mb-0.5">Tổng hồ sơ</span>
                <span class="text-xl sm:text-2xl font-serif font-bold text-[#171A19] dark:text-white">{{ $totalCount }}</span>
            </div>
            <span class="w-8 h-8 rounded-xl bg-[#FAF9F6] dark:bg-[#282D2A] border border-[#E5E3DC] dark:border-[#343B36] text-[#171A19] dark:text-white flex items-center justify-center text-sm">
                <i class="ri-folder-line"></i>
            </span>
        </div>

        <div class="bg-white dark:bg-[#1E2320] rounded-2xl p-4 border border-amber-200/80 dark:border-amber-900/40 shadow-2xs flex items-center justify-between">
            <div>
                <span class="text-[11px] font-bold uppercase tracking-wider text-amber-700 dark:text-amber-400 block mb-0.5">Chờ chủ duyệt</span>
                <span class="text-xl sm:text-2xl font-serif font-bold text-amber-600 dark:text-amber-400">{{ $choDuyetCount }}</span>
            </div>
            <span class="w-8 h-8 rounded-xl bg-amber-50 dark:bg-amber-950/60 text-amber-600 flex items-center justify-center text-sm">
                <i class="ri-time-line"></i>
            </span>
        </div>

        <div class="bg-white dark:bg-[#1E2320] rounded-2xl p-4 border border-sky-200/80 dark:border-sky-900/40 shadow-2xs flex items-center justify-between">
            <div>
                <span class="text-[11px] font-bold uppercase tracking-wider text-sky-700 dark:text-sky-400 block mb-0.5">Đã chấp thuận</span>
                <span class="text-xl sm:text-2xl font-serif font-bold text-sky-600 dark:text-sky-400">{{ $chapNhanCount }}</span>
            </div>
            <span class="w-8 h-8 rounded-xl bg-sky-50 dark:bg-sky-950/60 text-sky-600 flex items-center justify-center text-sm">
                <i class="ri-check-line"></i>
            </span>
        </div>

        <div class="bg-white dark:bg-[#1E2320] rounded-2xl p-4 border border-emerald-200/80 dark:border-emerald-900/40 shadow-2xs flex items-center justify-between">
            <div>
                <span class="text-[11px] font-bold uppercase tracking-wider text-emerald-700 dark:text-emerald-400 block mb-0.5">Đã có hợp đồng</span>
                <span class="text-xl sm:text-2xl font-serif font-bold text-emerald-700 dark:text-emerald-400">{{ $hopDongCount }}</span>
            </div>
            <span class="w-8 h-8 rounded-xl bg-emerald-50 dark:bg-emerald-950/60 text-emerald-700 flex items-center justify-center text-sm">
                <i class="ri-file-shield-line"></i>
            </span>
        </div>
    </div>

    {{-- FILTER DROPDOWN & SEARCH INPUT --}}
    <div class="bg-white dark:bg-[#1E2320] rounded-2xl p-3 border border-[#E5E3DC] dark:border-[#2D332F] shadow-2xs flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <div class="flex items-center gap-2.5">
            <label class="text-xs font-semibold text-[#5A605B] dark:text-[#9EA39E] whitespace-nowrap flex items-center gap-1.5">
                <i class="ri-filter-3-line"></i> Lọc trạng thái:
            </label>
            <div class="relative min-w-[210px]">
                <select x-model="activeTab"
                    class="w-full appearance-none py-2 pl-3.5 pr-8 text-xs font-medium rounded-xl border border-[#E5E3DC] dark:border-[#343B36] bg-[#FAF9F6] dark:bg-[#282D2A] text-[#171A19] dark:text-white focus:outline-none focus:ring-1 focus:ring-[#1B3D2F] cursor-pointer transition">
                    <option value="all">Tất cả hồ sơ ({{ $totalCount }})</option>
                    <option value="cho_duyet">Chờ duyệt ({{ $choDuyetCount }})</option>
                    <option value="chap_nhan">Đã đồng ý ({{ $chapNhanCount }})</option>
                    <option value="da_tao_hop_dong">Đã có hợp đồng ({{ $hopDongCount }})</option>
                    <option value="tu_choi">Từ chối / Hủy ({{ $tuChoiCount }})</option>
                </select>
                <i class="ri-arrow-down-s-line absolute right-2.5 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none text-sm"></i>
            </div>
        </div>

        <div class="relative w-full sm:w-64 shrink-0">
            <i class="ri-search-line absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
            <input type="text" x-model="search" placeholder="Tìm theo tên phòng, dãy, mã..."
                class="w-full pl-8 pr-3 py-2 text-xs rounded-xl border border-[#E5E3DC] dark:border-[#343B36] bg-[#FAF9F6] dark:bg-[#282D2A] text-[#171A19] dark:text-white focus:outline-none focus:ring-1 focus:ring-[#1B3D2F]">
        </div>
    </div>

    {{-- FLASH MESSAGES --}}
    @if(session('success'))
        <div class="p-3.5 rounded-xl bg-emerald-50 dark:bg-emerald-950/60 border border-emerald-200 dark:border-emerald-800 text-emerald-800 dark:text-emerald-200 text-xs font-semibold flex items-center gap-2">
            <i class="ri-checkbox-circle-fill text-base text-emerald-600"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif
    @if(session('error'))
        <div class="p-3.5 rounded-xl bg-rose-50 dark:bg-rose-950/60 border border-rose-200 dark:border-rose-800 text-rose-800 dark:text-rose-200 text-xs font-semibold flex items-center gap-2">
            <i class="ri-error-warning-fill text-base text-rose-600"></i>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    {{-- EMPTY STATE --}}
    @if($collection->isEmpty())
        <div class="bg-white dark:bg-[#1E2320] rounded-3xl p-10 border border-dashed border-[#E5E3DC] dark:border-[#2D332F] text-center space-y-3">
            <div class="w-14 h-14 rounded-2xl bg-[#1B3D2F]/10 dark:bg-[#244B3B]/40 text-[#1B3D2F] dark:text-[#A3E635] flex items-center justify-center text-2xl mx-auto">
                <i class="ri-mail-open-line"></i>
            </div>
            <div>
                <h3 class="text-base font-serif font-bold text-[#171A19] dark:text-white">Bạn chưa gửi yêu cầu thuê phòng nào</h3>
                <p class="text-xs text-[#5A605B] dark:text-[#9EA39E] mt-1 max-w-sm mx-auto">
                    Tìm kiếm phòng trọ phù hợp trên hệ thống và gửi yêu cầu để giữ chỗ và khởi tạo hợp đồng thuê.
                </p>
            </div>
            <div class="pt-2">
                <a href="{{ route('listing') }}"
                    class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-[#1B3D2F] hover:bg-[#244B3B] text-white text-xs font-semibold transition shadow-xs">
                    <i class="ri-search-line"></i> Tìm phòng trọ ngay
                </a>
            </div>
        </div>
    @else
        {{-- LIST OF RENTAL REQUESTS --}}
        <div class="space-y-4">
            @foreach ($collection as $yc)
                @php
                    $baiDang = $yc['bai_dang'] ?? [];
                    $phong = $baiDang['phong'] ?? [];
                    $dayTro = $phong['day_tro'] ?? [];
                    $chuTro = $baiDang['chu_tro'] ?? $dayTro['chu_tro'] ?? [];
                    $st = $yc['trang_thai'] ?? 'cho_duyet';

                    $anhRaw = $baiDang['anh'] ?? [];
                    $thumb = asset('upload/room1.jpg');
                    if (!empty($anhRaw)) {
                        if (is_array($anhRaw) && isset($anhRaw[0]['url'])) $thumb = asset($anhRaw[0]['url']);
                        elseif (is_array($anhRaw) && is_string($anhRaw[0])) $thumb = asset($anhRaw[0]);
                        elseif (is_string($anhRaw)) $thumb = asset($anhRaw);
                    }

                    $badgeText = match($st) {
                        'cho_duyet' => 'Chờ chủ trọ duyệt',
                        'chap_nhan' => 'Chủ trọ đã đồng ý',
                        'da_tao_hop_dong' => 'Đã phát hành hợp đồng',
                        'tu_choi' => 'Chủ trọ từ chối',
                        'chu_tro_huy_hop_dong' => 'Chủ trọ hủy',
                        default => 'Đã hủy'
                    };

                    $badgeClass = match($st) {
                        'cho_duyet' => 'bg-amber-50 text-amber-800 border-amber-200 dark:bg-amber-950/40 dark:text-amber-400 dark:border-amber-800',
                        'chap_nhan' => 'bg-sky-50 text-sky-800 border-sky-200 dark:bg-sky-950/40 dark:text-sky-300 dark:border-sky-800',
                        'da_tao_hop_dong' => 'bg-emerald-50 text-emerald-800 border-emerald-200 dark:bg-emerald-950/40 dark:text-emerald-400 dark:border-emerald-800',
                        'tu_choi' => 'bg-rose-50 text-rose-800 border-rose-200 dark:bg-rose-950/40 dark:text-rose-400 dark:border-rose-800',
                        default => 'bg-[#FAF9F6] text-[#5A605B] border-[#E5E3DC] dark:bg-[#282D2A] dark:text-[#9EA39E] dark:border-[#343B36]'
                    };

                    $searchString = addslashes(mb_strtolower(
                        ($baiDang['tieu_de'] ?? '') . ' ' .
                        ($dayTro['ten_day_tro'] ?? '') . ' ' .
                        ($dayTro['dia_chi'] ?? '') . ' ' .
                        ($phong['so_phong'] ?? '') . ' ' .
                        ($chuTro['ho_ten'] ?? '') . ' ' .
                        $yc['id']
                    ));
                @endphp

                <div x-show="matches('{{ $st }}', '{{ $searchString }}')"
                    class="bg-white dark:bg-[#1E2320] rounded-2xl border border-[#E5E3DC] dark:border-[#2D332F] shadow-sm hover:border-[#1B3D2F]/30 transition p-5 space-y-4">

                    {{-- Header Row: Code, Title, Status --}}
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2.5 pb-3 border-b border-[#E5E3DC] dark:border-[#282D2A]">
                        <div class="flex items-center gap-2.5">
                            <span class="px-2 py-0.5 rounded-lg bg-[#FAF9F6] dark:bg-[#282D2A] border border-[#E5E3DC] dark:border-[#343B36] text-[#171A19] dark:text-white font-mono font-bold text-xs">
                                #YC-{{ $yc['id'] }}
                            </span>
                            <span class="text-xs text-[#5A605B] dark:text-[#9EA39E]">
                                Gửi lúc {{ !empty($yc['ngay_tao']) ? \Carbon\Carbon::parse($yc['ngay_tao'])->format('d/m/Y H:i') : '--' }}
                            </span>
                        </div>

                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold border {{ $badgeClass }} self-start sm:self-auto">
                            <span class="w-1.5 h-1.5 rounded-full {{ $st === 'cho_duyet' ? 'bg-amber-500 animate-pulse' : ($st === 'da_tao_hop_dong' ? 'bg-emerald-500' : 'bg-gray-400') }}"></span>
                            {{ $badgeText }}
                        </span>
                    </div>

                    {{-- Main Row: Image & Content --}}
                    <div class="flex flex-col sm:flex-row items-start gap-4">
                        <div class="w-full sm:w-36 h-28 rounded-xl overflow-hidden bg-[#FAF9F6] dark:bg-[#282D2A] border border-[#E5E3DC] dark:border-[#2D332F] shrink-0">
                            <img src="{{ $thumb }}" alt="Room" class="w-full h-full object-cover">
                        </div>

                        <div class="flex-1 min-w-0 space-y-2">
                            <h4 class="text-sm font-serif font-bold text-[#171A19] dark:text-white line-clamp-1">
                                {{ $baiDang['tieu_de'] ?? ('Phòng ' . ($phong['so_phong'] ?? '') . ' - ' . ($dayTro['ten_day_tro'] ?? 'Khu trọ')) }}
                            </h4>

                            <p class="text-xs text-[#5A605B] dark:text-[#9EA39E] flex items-center gap-1 truncate">
                                <i class="ri-map-pin-line text-[#A6824D] shrink-0"></i>
                                <span>{{ $dayTro['dia_chi'] ?? 'TP. Hồ Chí Minh' }}</span>
                            </p>

                            <div class="grid grid-cols-2 sm:grid-cols-4 gap-2 text-xs pt-1">
                                <div>
                                    <span class="text-[#5A605B] dark:text-[#9EA39E] text-[11px] block">Giá thuê:</span>
                                    <span class="font-bold text-[#171A19] dark:text-white">{{ number_format($baiDang['gia_niem_yet'] ?? 0) }} đ/tháng</span>
                                </div>
                                <div>
                                    <span class="text-[#5A605B] dark:text-[#9EA39E] text-[11px] block">Tiền cọc giữ chỗ:</span>
                                    <span class="font-bold text-[#1B3D2F] dark:text-[#4ADE80]">{{ number_format($yc['tien_coc'] ?? 0) }} đ</span>
                                </div>
                                <div>
                                    <span class="text-[#5A605B] dark:text-[#9EA39E] text-[11px] block">Dọn vào:</span>
                                    <span class="font-medium text-[#171A19] dark:text-white">{{ !empty($yc['ngay_bat_dau']) ? \Carbon\Carbon::parse($yc['ngay_bat_dau'])->format('d/m/Y') : '--' }}</span>
                                </div>
                                <div>
                                    <span class="text-[#5A605B] dark:text-[#9EA39E] text-[11px] block">Thời hạn đến:</span>
                                    <span class="font-medium text-[#171A19] dark:text-white">{{ !empty($yc['ngay_ket_thuc']) ? \Carbon\Carbon::parse($yc['ngay_ket_thuc'])->format('d/m/Y') : '--' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Stepper Progress --}}
                    <div class="pt-3 border-t border-[#E5E3DC] dark:border-[#282D2A]">
                        <div class="grid grid-cols-4 gap-2 text-center text-[11px]">
                            <div class="flex items-center gap-1.5 justify-center font-bold text-emerald-700 dark:text-emerald-400">
                                <i class="ri-checkbox-circle-fill text-xs"></i> <span>1. Gửi hồ sơ</span>
                            </div>
                            <div class="flex items-center gap-1.5 justify-center font-bold {{ in_array($st, ['chap_nhan', 'da_tao_hop_dong']) ? 'text-emerald-700 dark:text-emerald-400' : ($st === 'cho_duyet' ? 'text-amber-600' : 'text-gray-400') }}">
                                @if(in_array($st, ['chap_nhan', 'da_tao_hop_dong']))
                                    <i class="ri-checkbox-circle-fill text-xs"></i>
                                @else
                                    <span class="w-4 h-4 rounded-full border border-current inline-flex items-center justify-center text-[10px]">2</span>
                                @endif
                                <span>2. Chủ duyệt</span>
                            </div>
                            <div class="flex items-center gap-1.5 justify-center font-bold {{ $st === 'da_tao_hop_dong' ? 'text-emerald-700 dark:text-emerald-400' : 'text-gray-400' }}">
                                @if($st === 'da_tao_hop_dong')
                                    <i class="ri-checkbox-circle-fill text-xs"></i>
                                @else
                                    <span class="w-4 h-4 rounded-full border border-current inline-flex items-center justify-center text-[10px]">3</span>
                                @endif
                                <span>3. Hợp đồng</span>
                            </div>
                            <div class="flex items-center gap-1.5 justify-center font-bold {{ $st === 'da_tao_hop_dong' ? 'text-[#0D9488] dark:text-[#2DD4BF]' : 'text-gray-400' }}">
                                <span class="w-4 h-4 rounded-full border border-current inline-flex items-center justify-center text-[10px]">4</span>
                                <span>4. Nhận phòng</span>
                            </div>
                        </div>
                    </div>

                    {{-- Actions & Landlord Contact --}}
                    <div class="flex flex-wrap items-center justify-between gap-3 pt-3 border-t border-[#E5E3DC] dark:border-[#282D2A]">
                        <div class="flex items-center gap-2 text-xs">
                            <span class="text-[#5A605B] dark:text-[#9EA39E]">Chủ trọ:</span>
                            <span class="font-bold text-[#171A19] dark:text-white">{{ $chuTro['ho_ten'] ?? 'Chủ nhà' }}</span>
                            @if(!empty($chuTro['so_dien_thoai']))
                                <a href="tel:{{ $chuTro['so_dien_thoai'] }}" class="text-[#1B3D2F] dark:text-[#A3E635] font-semibold hover:underline">
                                    {{ $chuTro['so_dien_thoai'] }}
                                </a>
                            @endif
                        </div>

                        <div class="flex items-center gap-2">
                            @if($st === 'da_tao_hop_dong')
                                <a href="{{ route('khach-thue.hop-dong.index') }}"
                                    class="px-3.5 py-1.5 rounded-xl bg-[#1B3D2F] hover:bg-[#244B3B] text-white font-medium text-xs transition flex items-center gap-1 shadow-xs">
                                    <i class="ri-file-shield-line"></i> Xem hợp đồng điện tử
                                </a>
                            @elseif($st === 'cho_duyet')
                                <form action="{{ route('khach-thue.yeu-cau-thue.huy', $yc['id']) }}" method="POST"
                                    onsubmit="return confirm('Bạn có chắc chắn muốn hủy yêu cầu thuê này?')" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="px-3 py-1.5 rounded-xl bg-rose-50 hover:bg-rose-100 text-rose-700 dark:bg-rose-950/40 dark:hover:bg-rose-900/50 dark:text-rose-300 text-xs font-medium border border-rose-200 dark:border-rose-900 transition">
                                        Hủy yêu cầu
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>

                </div>
            @endforeach
        </div>
    @endif

</div>
@endsection
