@extends('layouts.chu-tro')

@section('title', 'Quản lý Hợp đồng - Hệ Thống Trọ')
@section('header_title', 'Hồ Sơ Hợp Đồng Thuê')
@section('header_subtitle', 'Theo dõi thời hạn cư trú, mức ký quỹ đặt cọc và quản lý tệp hợp đồng điện tử')

@section('content')
<div class="max-w-7xl mx-auto space-y-6 animate-fade-in">

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white dark:bg-[#181B19] p-6 rounded-xl border border-[#E5E3DC] dark:border-[#282D2A] shadow-2xs">
        <div>
            <div class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded text-[10px] font-bold bg-[#E5EDE8] dark:bg-[#23352B] text-[#1B3D2F] dark:text-[#8BB39D] uppercase tracking-wider mb-1.5">
                <i class="ri-file-text-line"></i> Pháp lý & Hợp đồng
            </div>
            <h1 class="text-xl sm:text-2xl font-black text-[#171A19] dark:text-white tracking-tight">
                Danh Sách Hợp Đồng Thuê
            </h1>
            <p class="text-xs text-[#85877F] mt-0.5">
                Quản lý các cam kết ràng buộc pháp lý, thời hạn và tệp đính kèm điện tử
            </p>
        </div>

        <div class="flex items-center gap-2.5">
            <a href="{{ route('chu-tro.dashboard') }}"
                class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-lg bg-[#FAF9F6] dark:bg-[#222724] border border-[#E5E3DC] dark:border-[#282D2A] text-[#171A19] dark:text-[#EAE8E1] text-xs font-bold hover:border-[#1B3D2F] transition">
                <i class="ri-arrow-left-line"></i>
                <span>Bảng điều khiển</span>
            </a>

            <a href="{{ route('chu-tro.hop-dong.create') }}"
                class="inline-flex items-center gap-1.5 px-4 py-2 rounded-lg bg-[#1B3D2F] hover:bg-[#142E23] text-white font-bold text-xs shadow-2xs transition">
                <i class="ri-add-line text-sm"></i>
                <span>Tạo hợp đồng mới</span>
            </a>
        </div>
    </div>

    {{-- Filter bar --}}
    <div class="bg-white dark:bg-[#181B19] p-3.5 rounded-xl border border-[#E5E3DC] dark:border-[#282D2A] shadow-2xs flex flex-col sm:flex-row items-center justify-between gap-3">
        <form method="GET" action="{{ route('chu-tro.hop-dong.index') }}" class="flex items-center gap-2.5 w-full sm:w-auto">
            <label class="text-[10px] font-bold uppercase tracking-wider text-[#85877F] whitespace-nowrap">
                Khu / Dãy trọ:
            </label>
            <select name="day_tro_id" onchange="this.form.submit()"
                class="px-3 py-1.5 rounded-lg bg-[#FAF9F6] dark:bg-[#202522] border border-[#E5E3DC] dark:border-[#282D2A] text-xs text-[#171A19] dark:text-[#EAE8E1] font-semibold focus:outline-none focus:border-[#1B3D2F]">
                <option value="">Tất cả các dãy</option>
                @foreach($day_tros as $day)
                    <option value="{{ $day->id }}" {{ request('day_tro_id') == $day->id ? 'selected' : '' }}>
                        {{ $day->ten_day_tro }}
                    </option>
                @endforeach
            </select>
        </form>

        <span class="text-xs text-[#85877F] font-medium">
            Tổng cộng: <strong class="text-[#171A19] dark:text-white font-bold">{{ count($hop_dong) }}</strong> hợp đồng
        </span>
    </div>

    {{-- Bảng hợp đồng --}}
    <div class="bg-white dark:bg-[#181B19] rounded-xl border border-[#E5E3DC] dark:border-[#282D2A] shadow-2xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-[#FAF9F6] dark:bg-[#202522] border-b border-[#E5E3DC] dark:border-[#282D2A] text-[10px] font-bold uppercase tracking-wider text-[#85877F]">
                        <th class="py-3 px-3.5 text-center w-12">#</th>
                        <th class="py-3 px-4">Số phòng</th>
                        <th class="py-3 px-4">Đại diện thuê</th>
                        <th class="py-3 px-4">Thời gian hiệu lực</th>
                        <th class="py-3 px-4 text-right">Mức ký quỹ (cọc)</th>
                        <th class="py-3 px-4">Tệp đính kèm</th>
                        <th class="py-3 px-3.5 text-center">Trạng thái</th>
                        <th class="py-3 px-4 text-center">Thao tác</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#E5E3DC]/60 dark:divide-[#282D2A] text-[#202421] dark:text-[#EAE8E1]">
                    @forelse ($hop_dong as $hd)
                        <tr class="hover:bg-[#FAF9F6] dark:hover:bg-[#202522] transition-colors">
                            {{-- STT --}}
                            <td class="py-3.5 px-3.5 text-center font-bold text-[#85877F]">
                                {{ $loop->iteration }}
                            </td>

                            {{-- Phòng --}}
                            <td class="py-3.5 px-4 font-black text-[#171A19] dark:text-white">
                                <span class="inline-flex items-center gap-1.5 font-bold">
                                    <i class="ri-door-closed-line text-[#85877F]"></i>
                                    Phòng {{ $hd['so_phong'] ?? '—' }}
                                </span>
                            </td>

                            {{-- Khách thuê --}}
                            <td class="py-3.5 px-4">
                                <div class="flex items-center gap-2">
                                    <div class="w-6 h-6 rounded bg-[#FAF9F6] dark:bg-[#202522] border border-[#E5E3DC] dark:border-[#282D2A] flex items-center justify-center text-[#85877F] text-xs font-bold">
                                        <i class="ri-user-line"></i>
                                    </div>
                                    <span class="font-bold text-[#171A19] dark:text-white">{{ $hd['khach_thue'] ?? 'Chưa xác định' }}</span>
                                </div>
                            </td>

                            {{-- Thời gian thuê --}}
                            <td class="py-3.5 px-4 text-[#85877F] text-[11px]">
                                <div class="flex items-center gap-1.5">
                                    <i class="ri-calendar-line text-[#85877F]"></i>
                                    <span>{{ \Carbon\Carbon::parse($hd['ngay_bat_dau'])->format('d/m/Y') }}</span>
                                    <span class="text-[#85877F]">&rarr;</span>
                                    <span>{{ \Carbon\Carbon::parse($hd['ngay_ket_thuc'])->format('d/m/Y') }}</span>
                                </div>
                            </td>

                            {{-- Tiền cọc --}}
                            <td class="py-3.5 px-4 text-right font-black text-[#1B3D2F] dark:text-[#8BB39D]">
                                @if(isset($hd['tien_coc']) && $hd['tien_coc'] > 0)
                                    {{ number_format($hd['tien_coc'], 0, ',', '.') }} đ
                                @else
                                    <span class="text-[#85877F] font-normal italic text-xs">Chưa cọc</span>
                                @endif
                            </td>

                            {{-- File hợp đồng --}}
                            <td class="py-3.5 px-4">
                                @if (!empty($hd['url_file_hop_dong']))
                                    <a href="{{ env('API_BASE_URL') . '/storage/' . $hd['url_file_hop_dong'] }}" target="_blank"
                                        class="inline-flex items-center gap-1 text-[#1B3D2F] dark:text-[#8BB39D] font-bold text-xs hover:underline">
                                        <i class="ri-attachment-line"></i>
                                        <span class="truncate max-w-[140px]">{{ basename($hd['url_file_hop_dong']) }}</span>
                                    </a>
                                @else
                                    <span class="text-[#85877F] italic text-[11px]">Chưa đính kèm</span>
                                @endif
                            </td>

                            {{-- Trạng thái --}}
                            <td class="py-3.5 px-3.5 text-center">
                                @php
                                    $st = $hd['trang_thai'] ?? '';
                                    $badge = match ($st) {
                                        'hieu_luc' => ['bg' => 'bg-[#E5EDE8] dark:bg-[#23352B]', 'text' => 'text-[#1B3D2F] dark:text-[#8BB39D]', 'border' => 'border-[#C7D9CE] dark:border-[#2D4537]', 'label' => 'Hiệu lực', 'dot' => 'bg-[#1B3D2F]'],
                                        'ket_thuc' => ['bg' => 'bg-[#FAF9F6] dark:bg-[#202522]', 'text' => 'text-[#85877F]', 'border' => 'border-[#E5E3DC] dark:border-[#282D2A]', 'label' => 'Kết thúc', 'dot' => 'bg-[#85877F]'],
                                        default => ['bg' => 'bg-rose-50 dark:bg-rose-950/40', 'text' => 'text-rose-800 dark:text-rose-300', 'border' => 'border-rose-200 dark:border-rose-900', 'label' => ucfirst($st), 'dot' => 'bg-rose-500'],
                                    };
                                @endphp
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded text-[11px] font-bold border {{ $badge['bg'] }} {{ $badge['text'] }} {{ $badge['border'] }}">
                                    <span class="w-1.5 h-1.5 rounded-full {{ $badge['dot'] }}"></span>
                                    {{ $badge['label'] }}
                                </span>
                            </td>

                            {{-- Thao tác --}}
                            <td class="py-3.5 px-4 text-center">
                                <div class="inline-flex items-center gap-1">
                                    <a href="{{ route('chu-tro.hop-dong.show', $hd['id']) }}"
                                        class="w-7 h-7 rounded-md flex items-center justify-center bg-[#FAF9F6] dark:bg-[#202522] border border-[#E5E3DC] dark:border-[#282D2A] text-[#85877F] hover:text-[#1B3D2F] hover:border-[#1B3D2F] transition"
                                        title="Xem chi tiết">
                                        <i class="ri-eye-line text-sm"></i>
                                    </a>

                                    <a href="{{ route('chu-tro.hop-dong.edit', $hd['id']) }}"
                                        class="w-7 h-7 rounded-md flex items-center justify-center bg-[#FAF9F6] dark:bg-[#202522] border border-[#E5E3DC] dark:border-[#282D2A] text-[#85877F] hover:text-[#1B3D2F] hover:border-[#1B3D2F] transition"
                                        title="Chỉnh sửa">
                                        <i class="ri-edit-line text-sm"></i>
                                    </a>

                                    <form action="{{ route('chu-tro.hop-dong.destroy', $hd['id']) }}" method="POST" class="inline">
                                        @csrf @method('DELETE')
                                        <button type="submit"
                                            onclick="return confirm('Bạn có chắc chắn muốn xóa hợp đồng này?')"
                                            class="w-7 h-7 rounded-md flex items-center justify-center bg-[#FAF9F6] dark:bg-[#202522] border border-[#E5E3DC] dark:border-[#282D2A] text-[#85877F] hover:text-rose-600 hover:border-rose-400 transition"
                                            title="Xóa">
                                            <i class="ri-delete-bin-line text-sm"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="py-12 px-6 text-center">
                                <div class="max-w-sm mx-auto space-y-3">
                                    <div class="w-12 h-12 rounded-xl bg-[#E5EDE8] dark:bg-[#23352B] text-[#1B3D2F] dark:text-[#8BB39D] flex items-center justify-center text-2xl mx-auto">
                                        <i class="ri-file-text-line"></i>
                                    </div>
                                    <h3 class="text-sm font-extrabold text-[#171A19] dark:text-white">Chưa có hợp đồng nào</h3>
                                    <p class="text-xs text-[#85877F]">
                                        Khi có người thuê phòng, hãy tạo hợp đồng để xác nhận kỳ hạn thuê và các cam kết thanh toán.
                                    </p>
                                    <a href="{{ route('chu-tro.hop-dong.create') }}"
                                        class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-lg bg-[#1B3D2F] hover:bg-[#142E23] text-white font-bold text-xs shadow-2xs transition">
                                        <i class="ri-add-line"></i> Tạo hợp đồng ngay
                                    </a>
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