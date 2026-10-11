@extends('layouts.chu-tro')
@section('title', 'Quản lý khách thuê - Hệ Thống Trọ')
@section('header_title', 'Hồ Sơ Cư Dân & Khách Thuê')
@section('header_subtitle', 'Theo dõi tình trạng cư trú, căn cước công dân và thông tin liên lạc của toàn bộ người thuê')

@section('content')
<div class="max-w-7xl mx-auto space-y-6 animate-fade-in">

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white dark:bg-[#181B19] p-6 rounded-xl border border-[#E5E3DC] dark:border-[#282D2A] shadow-2xs">
        <div>
            <div class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded text-[10px] font-bold bg-[#E5EDE8] dark:bg-[#23352B] text-[#1B3D2F] dark:text-[#8BB39D] uppercase tracking-wider mb-1.5">
                <i class="ri-user-star-line"></i> Quản lý cư dân
            </div>
            <h1 class="text-xl sm:text-2xl font-black text-[#171A19] dark:text-white tracking-tight">
                Danh Sách Khách Thuê
            </h1>
            <p class="text-xs text-[#85877F] mt-0.5">
                Theo dõi tình trạng cư trú, căn cước công dân và thông tin liên lạc của toàn bộ người thuê
            </p>
        </div>

        <div class="flex items-center gap-2.5">
            <a href="{{ route('chu-tro.nguoi-than.all') }}"
                class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-[#FAF9F6] dark:bg-[#222724] text-[#171A19] dark:text-[#EAE8E1] border border-[#E5E3DC] dark:border-[#282D2A] hover:border-[#1B3D2F] rounded-lg text-xs font-bold shadow-2xs transition">
                <i class="ri-parent-line text-[#1B3D2F] dark:text-[#8BB39D]"></i>
                <span>Xem người thân</span>
            </a>

            <a href="{{ route('chu-tro.khachthue.create') }}"
                class="inline-flex items-center gap-1.5 px-4 py-2 bg-[#1B3D2F] hover:bg-[#142E23] text-white rounded-lg text-xs font-bold shadow-2xs transition">
                <i class="ri-user-add-line text-sm"></i>
                <span>Thêm khách thuê</span>
            </a>
        </div>
    </div>

    {{-- Bộ lọc dãy trọ --}}
    <div class="bg-white dark:bg-[#181B19] border border-[#E5E3DC] dark:border-[#282D2A] rounded-xl p-3.5 shadow-2xs flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-3">
        <form method="GET" class="flex items-center gap-2.5 flex-wrap">
            <label class="text-[10px] font-bold uppercase tracking-wider text-[#85877F] flex items-center gap-1">
                <i class="ri-filter-3-line text-[#1B3D2F] dark:text-[#8BB39D]"></i> Dãy trọ:
            </label>
            <div class="relative min-w-[200px]">
                <select name="day_tro_id" onchange="this.form.submit()"
                    class="w-full appearance-none pl-3 pr-8 py-1.5 text-xs bg-[#FAF9F6] dark:bg-[#202522] border border-[#E5E3DC] dark:border-[#282D2A] text-[#171A19] dark:text-[#EAE8E1] font-semibold rounded-lg focus:outline-none focus:border-[#1B3D2F] transition">
                    <option value="">Tất cả dãy trọ</option>
                    @foreach ($day_tros as $day)
                        <option value="{{ $day->id }}" {{ request('day_tro_id') == $day->id ? 'selected' : '' }}>
                            {{ $day->ten_day_tro }}
                        </option>
                    @endforeach
                </select>
                <i class="ri-arrow-down-s-line absolute right-2.5 top-1/2 -translate-y-1/2 text-[#85877F] pointer-events-none text-xs"></i>
            </div>
            @if(request('day_tro_id'))
                <a href="{{ route('chu-tro.khachthue.index') }}" class="text-xs text-rose-600 font-semibold inline-flex items-center gap-1 hover:underline">
                    <i class="ri-close-circle-line"></i> Bỏ lọc
                </a>
            @endif
        </form>

        <div class="text-xs text-[#85877F] flex items-center gap-2">
            <span>Tổng cộng: <strong class="text-[#171A19] dark:text-white font-bold">{{ count($khach) }}</strong> khách</span>
        </div>
    </div>

    {{-- Bảng danh sách --}}
    <div class="bg-white dark:bg-[#181B19] rounded-xl border border-[#E5E3DC] dark:border-[#282D2A] shadow-2xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-[#202421] dark:text-[#EAE8E1]">
                <thead class="bg-[#FAF9F6] dark:bg-[#202522] border-b border-[#E5E3DC] dark:border-[#282D2A] text-[10px] font-bold text-[#85877F] uppercase tracking-wider">
                    <tr>
                        <th class="py-3 px-3.5 text-center w-12">#</th>
                        <th class="py-3 px-4">Họ tên & Khách</th>
                        <th class="py-3 px-4">Thông tin liên hệ</th>
                        <th class="py-3 px-4">Số phòng</th>
                        <th class="py-3 px-4 text-center">Trạng thái hợp đồng</th>
                        <th class="py-3 px-4 text-center">Thao tác</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-[#E5E3DC]/60 dark:divide-[#282D2A]">
                    @forelse ($khach as $k)
                        <tr class="hover:bg-[#FAF9F6] dark:hover:bg-[#202522] transition-colors">
                            <td class="py-3.5 px-3.5 text-center font-bold text-[#85877F]">{{ $loop->iteration }}</td>
                            
                            {{-- Họ tên & Avatar --}}
                            <td class="py-3.5 px-4">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-8 h-8 rounded-lg bg-[#E5EDE8] dark:bg-[#23352B] text-[#1B3D2F] dark:text-[#8BB39D] flex items-center justify-center font-bold text-xs flex-shrink-0">
                                        {{ strtoupper(mb_substr($k['ho_ten'] ?? 'K', 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="font-bold text-[#171A19] dark:text-white leading-tight">
                                            {{ $k['ho_ten'] ?? 'N/A' }}
                                        </div>
                                        <div class="text-[10px] text-[#85877F] mt-0.5 flex items-center gap-1">
                                            <i class="ri-fingerprint-line"></i> CCCD: {{ $k['cccd'] ?? 'Chưa cập nhật' }}
                                        </div>
                                    </div>
                                </div>
                            </td>

                            {{-- Liên hệ --}}
                            <td class="py-3.5 px-4">
                                <div class="space-y-0.5">
                                    <div class="flex items-center gap-1.5 font-semibold text-[#171A19] dark:text-white">
                                        <i class="ri-phone-line text-[#1B3D2F] dark:text-[#8BB39D]"></i> {{ $k['so_dien_thoai'] ?? '—' }}
                                    </div>
                                    <div class="flex items-center gap-1.5 text-[11px] text-[#85877F] truncate max-w-[200px]" title="{{ $k['email'] ?? '' }}">
                                        <i class="ri-mail-line"></i> {{ $k['email'] ?? '—' }}
                                    </div>
                                </div>
                            </td>

                            {{-- Phòng --}}
                            <td class="py-3.5 px-4">
                                @if(!empty($k['so_phong']))
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-[11px] font-bold bg-[#FAF9F6] dark:bg-[#202522] border border-[#E5E3DC] dark:border-[#282D2A] text-[#171A19] dark:text-[#EAE8E1]">
                                        <i class="ri-door-open-line text-[#1B3D2F] dark:text-[#8BB39D]"></i> Phòng {{ $k['so_phong'] }}
                                    </span>
                                @else
                                    <span class="text-[11px] text-[#85877F] italic">Chưa xếp phòng</span>
                                @endif
                            </td>

                            {{-- Trạng thái --}}
                            <td class="py-3.5 px-4 text-center">
                                @php
                                    $status = strtolower($k['trang_thai_thue'] ?? 'không có hợp đồng');
                                    $badge = match ($status) {
                                        'đang thuê' => 'bg-[#E5EDE8] dark:bg-[#23352B] text-[#1B3D2F] dark:text-[#8BB39D] border-[#C7D9CE] dark:border-[#2D4537]',
                                        'sắp hết hạn' => 'bg-amber-50 dark:bg-amber-950/40 text-amber-800 dark:text-amber-300 border-amber-200 dark:border-amber-900',
                                        'đã hết hạn' => 'bg-[#FAF9F6] dark:bg-[#202522] text-[#85877F] border-[#E5E3DC] dark:border-[#282D2A]',
                                        default => 'bg-rose-50 dark:bg-rose-950/40 text-rose-800 dark:text-rose-300 border-rose-200 dark:border-rose-900'
                                    };
                                @endphp
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 text-[11px] font-bold rounded border {{ $badge }}">
                                    <span class="w-1.5 h-1.5 rounded-full bg-current"></span>
                                    {{ ucfirst($status) }}
                                </span>
                            </td>

                            {{-- Thao tác --}}
                            <td class="py-3.5 px-4 text-center">
                                <div class="inline-flex items-center gap-1">
                                    {{-- Xem --}}
                                    <a href="{{ route('chu-tro.khachthue.show', $k['id']) }}" title="Xem chi tiết"
                                        class="w-7 h-7 rounded-md flex items-center justify-center bg-[#FAF9F6] dark:bg-[#202522] border border-[#E5E3DC] dark:border-[#282D2A] text-[#85877F] hover:text-[#1B3D2F] hover:border-[#1B3D2F] transition">
                                        <i class="ri-eye-line text-sm"></i>
                                    </a>

                                    {{-- Sửa --}}
                                    <a href="{{ route('chu-tro.khachthue.edit', $k['id']) }}" title="Chỉnh sửa"
                                        class="w-7 h-7 rounded-md flex items-center justify-center bg-[#FAF9F6] dark:bg-[#202522] border border-[#E5E3DC] dark:border-[#282D2A] text-[#85877F] hover:text-[#1B3D2F] hover:border-[#1B3D2F] transition">
                                        <i class="ri-pencil-line text-sm"></i>
                                    </a>

                                    {{-- Xóa --}}
                                    <form action="{{ route('chu-tro.khachthue.destroy', $k['id']) }}" method="POST" class="inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" title="Xóa khách thuê"
                                            onclick="return confirm('Bạn chắc chắn muốn xóa khách thuê này?')"
                                            class="w-7 h-7 rounded-md flex items-center justify-center bg-[#FAF9F6] dark:bg-[#202522] border border-[#E5E3DC] dark:border-[#282D2A] text-[#85877F] hover:text-rose-600 hover:border-rose-400 transition">
                                            <i class="ri-delete-bin-line text-sm"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-12">
                                <div class="w-12 h-12 mx-auto rounded-xl bg-[#E5EDE8] dark:bg-[#23352B] text-[#1B3D2F] dark:text-[#8BB39D] flex items-center justify-center text-2xl mb-2.5">
                                    <i class="ri-user-unfollow-line"></i>
                                </div>
                                <h4 class="text-sm font-bold text-[#171A19] dark:text-white">Không tìm thấy khách thuê</h4>
                                <p class="text-xs text-[#85877F] mt-0.5">Chưa có khách thuê nào thuộc dãy trọ đã chọn.</p>
                                <a href="{{ route('chu-tro.khachthue.create') }}" class="inline-flex items-center gap-1.5 px-3.5 py-2 mt-3 text-xs font-bold text-white bg-[#1B3D2F] hover:bg-[#142E23] rounded-lg transition shadow-2xs">
                                    <i class="ri-add-line"></i> Thêm khách thuê mới
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection