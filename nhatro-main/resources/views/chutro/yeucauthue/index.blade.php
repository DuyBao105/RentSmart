@extends('layouts.chu-tro')

@section('title', 'Yêu cầu thuê - Hệ Thống Trọ')
@section('header_title', 'Hồ Sơ Yêu Cầu Thuê Phòng')
@section('header_subtitle', 'Xét duyệt hồ sơ khách gửi từ tin đăng, chuyển đổi thành hợp đồng chính thức hoặc gửi phản hồi')

@section('content')
<div class="max-w-7xl mx-auto space-y-6 animate-fade-in">
    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white dark:bg-[#181B19] p-6 rounded-xl border border-[#E5E3DC] dark:border-[#282D2A] shadow-2xs">
        <div>
            <div class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded text-[10px] font-bold bg-[#E5EDE8] dark:bg-[#23352B] text-[#1B3D2F] dark:text-[#8BB39D] uppercase tracking-wider mb-1.5">
                <i class="ri-mail-open-line"></i> Yêu cầu khách hàng
            </div>
            <h1 class="text-xl sm:text-2xl font-black text-[#171A19] dark:text-white tracking-tight">
                Danh Sách Yêu Cầu Thuê
            </h1>
            <p class="text-xs text-[#85877F] mt-0.5">
                Xét duyệt các yêu cầu liên hệ giữ phòng gửi từ khách thuê trực tuyến
            </p>
        </div>

        <a href="{{ route('chu-tro.dashboard') }}"
            class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-lg bg-[#FAF9F6] dark:bg-[#222724] border border-[#E5E3DC] dark:border-[#282D2A] text-[#171A19] dark:text-[#EAE8E1] text-xs font-bold hover:border-[#1B3D2F] transition shadow-2xs">
            <i class="ri-arrow-left-line"></i>
            <span>Bảng điều khiển</span>
        </a>
    </div>

    {{-- Bảng danh sách --}}
    <div class="bg-white dark:bg-[#181B19] rounded-xl border border-[#E5E3DC] dark:border-[#282D2A] shadow-2xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-[#FAF9F6] dark:bg-[#202522] border-b border-[#E5E3DC] dark:border-[#282D2A] text-[10px] font-bold uppercase tracking-wider text-[#85877F]">
                        <th class="py-3 px-3.5 text-center w-12">#</th>
                        <th class="py-3 px-4">Phòng & Dãy</th>
                        <th class="py-3 px-4">Khách thuê</th>
                        <th class="py-3 px-4">Ghi chú</th>
                        <th class="py-3 px-3.5 text-center">Thời gian gửi</th>
                        <th class="py-3 px-3.5 text-center">Trạng thái</th>
                        <th class="py-3 px-4 text-center">Thao tác</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#E5E3DC]/60 dark:divide-[#282D2A] text-[#202421] dark:text-[#EAE8E1]">
                    @forelse ($yeu_cau as $row)
                        @php 
                            $st = $row['trang_thai'] ?? 'cho_duyet'; 
                            $statusConfig = match($st) {
                                'cho_duyet' => ['bg' => 'bg-amber-50 dark:bg-amber-950/40', 'text' => 'text-amber-800 dark:text-amber-300', 'border' => 'border-amber-200 dark:border-amber-900', 'label' => 'Chờ duyệt', 'dot' => 'bg-amber-500'],
                                'chap_nhan' => ['bg' => 'bg-[#FAF9F6] dark:bg-[#202522]', 'text' => 'text-[#171A19] dark:text-white', 'border' => 'border-[#E5E3DC] dark:border-[#282D2A]', 'label' => 'Đã chấp nhận', 'dot' => 'bg-emerald-600'],
                                'da_tao_hop_dong' => ['bg' => 'bg-[#E5EDE8] dark:bg-[#23352B]', 'text' => 'text-[#1B3D2F] dark:text-[#8BB39D]', 'border' => 'border-[#C7D9CE] dark:border-[#2D4537]', 'label' => 'Đã tạo HĐ', 'dot' => 'bg-[#1B3D2F]'],
                                'tu_choi' => ['bg' => 'bg-rose-50 dark:bg-rose-950/40', 'text' => 'text-rose-800 dark:text-rose-300', 'border' => 'border-rose-200 dark:border-rose-900', 'label' => 'Đã từ chối', 'dot' => 'bg-rose-500'],
                                'huy' => ['bg' => 'bg-[#FAF9F6] dark:bg-[#202522]', 'text' => 'text-[#85877F]', 'border' => 'border-[#E5E3DC] dark:border-[#282D2A]', 'label' => 'Khách hủy', 'dot' => 'bg-[#85877F]'],
                                default => ['bg' => 'bg-[#FAF9F6] dark:bg-[#202522]', 'text' => 'text-[#85877F]', 'border' => 'border-[#E5E3DC] dark:border-[#282D2A]', 'label' => str_replace('_', ' ', ucfirst($st)), 'dot' => 'bg-[#85877F]'],
                            };
                        @endphp

                        <tr class="hover:bg-[#FAF9F6] dark:hover:bg-[#202522] transition-colors">
                            {{-- STT --}}
                            <td class="py-3.5 px-3.5 text-center font-bold text-[#85877F]">
                                {{ $loop->iteration }}
                            </td>

                            {{-- Phòng & Dãy --}}
                            <td class="py-3.5 px-4 font-bold text-[#171A19] dark:text-white">
                                <div class="flex items-center gap-2">
                                    <div class="w-7 h-7 rounded-lg bg-[#E5EDE8] dark:bg-[#23352B] text-[#1B3D2F] dark:text-[#8BB39D] flex items-center justify-center text-xs shrink-0 font-bold">
                                        <i class="ri-door-closed-line"></i>
                                    </div>
                                    <div>
                                        <span class="block font-black">Phòng {{ $row['so_phong'] ?? '—' }}</span>
                                        <span class="text-[10px] text-[#85877F] block">{{ $row['ten_day_tro'] ?? 'Chưa rõ dãy' }}</span>
                                    </div>
                                </div>
                            </td>

                            {{-- Khách thuê --}}
                            <td class="py-3.5 px-4">
                                <div class="flex items-center gap-2">
                                    <div class="w-6 h-6 rounded bg-[#FAF9F6] dark:bg-[#202522] border border-[#E5E3DC] dark:border-[#282D2A] flex items-center justify-center text-[#85877F] text-xs font-bold">
                                        <i class="ri-user-line"></i>
                                    </div>
                                    <span class="font-bold text-[#171A19] dark:text-white">{{ $row['khach_thue'] ?? 'Ẩn danh' }}</span>
                                </div>
                            </td>

                            {{-- Ghi chú --}}
                            <td class="py-3.5 px-4 text-[#85877F] max-w-xs truncate" title="{{ $row['ghi_chu'] }}">
                                {{ $row['ghi_chu'] ?: 'Không có ghi chú' }}
                            </td>

                            {{-- Thời gian gửi --}}
                            <td class="py-3.5 px-3.5 text-center text-[11px] text-[#85877F]">
                                {{ \Carbon\Carbon::parse($row['ngay_tao'])->format('d/m/Y H:i') }}
                            </td>

                            {{-- Trạng thái --}}
                            <td class="py-3.5 px-3.5 text-center">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded text-[11px] font-bold border {{ $statusConfig['bg'] }} {{ $statusConfig['text'] }} {{ $statusConfig['border'] }}">
                                    <span class="w-1.5 h-1.5 rounded-full {{ $statusConfig['dot'] }}"></span>
                                    {{ $statusConfig['label'] }}
                                </span>
                            </td>

                            {{-- Thao tác --}}
                            <td class="py-3.5 px-4 text-center">
                                <div class="inline-flex items-center gap-1.5">
                                    {{-- Xem chi tiết --}}
                                    <a href="{{ route('chu-tro.yeu-cau-thue.show', $row['id']) }}" 
                                        class="w-7 h-7 rounded-md flex items-center justify-center bg-[#FAF9F6] dark:bg-[#202522] border border-[#E5E3DC] dark:border-[#282D2A] text-[#85877F] hover:text-[#1B3D2F] hover:border-[#1B3D2F] transition"
                                        title="Xem chi tiết hồ sơ">
                                        <i class="ri-eye-line text-sm"></i>
                                    </a>

                                    @if ($st === 'cho_duyet')
                                        {{-- Chấp nhận --}}
                                        <form action="{{ route('chu-tro.yeu-cau-thue.chap-nhan', $row['id']) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit"
                                                onclick="return confirm('Chấp nhận yêu cầu này và tạo hợp đồng?')"
                                                class="px-2 py-1 rounded bg-[#1B3D2F] hover:bg-[#142E23] text-white font-bold text-[11px] flex items-center gap-1 transition shadow-2xs"
                                                title="Chấp nhận yêu cầu">
                                                <i class="ri-check-line"></i> Duyệt
                                            </button>
                                        </form>

                                        {{-- Từ chối --}}
                                        <form action="{{ route('chu-tro.yeu-cau-thue.tu-choi', $row['id']) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit"
                                                onclick="return confirm('Từ chối yêu cầu thuê này?')"
                                                class="px-2 py-1 rounded bg-rose-50 dark:bg-rose-950/40 border border-rose-200 dark:border-rose-900 text-rose-700 dark:text-rose-300 font-bold text-[11px] flex items-center gap-1 transition"
                                                title="Từ chối yêu cầu">
                                                <i class="ri-close-line"></i> Từ chối
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-12 px-6 text-center">
                                <div class="max-w-sm mx-auto space-y-3">
                                    <div class="w-12 h-12 rounded-xl bg-[#E5EDE8] dark:bg-[#23352B] text-[#1B3D2F] dark:text-[#8BB39D] flex items-center justify-center text-2xl mx-auto">
                                        <i class="ri-inbox-archive-line"></i>
                                    </div>
                                    <h3 class="text-sm font-extrabold text-[#171A19] dark:text-white">Chưa có yêu cầu thuê nào</h3>
                                    <p class="text-xs text-[#85877F]">
                                        Khi khách thuê quan tâm các bài đăng của bạn, thông tin liên hệ và yêu cầu sẽ xuất hiện tại đây.
                                    </p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
