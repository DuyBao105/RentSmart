@extends('layouts.chu-tro')
@php use Illuminate\Support\Str; @endphp

@section('title', 'Quản lý Khu / Dãy trọ - Hệ Thống Trọ')
@section('header_title', 'Danh Mục Khu & Dãy Trọ')
@section('header_subtitle', 'Theo dõi quy mô cơ sở, địa chỉ chi tiết và thông số bình quân của từng bất động sản')

@section('content')
<div class="max-w-7xl mx-auto space-y-6 animate-fade-in">
    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white dark:bg-[#181B19] p-6 rounded-xl border border-[#E5E3DC] dark:border-[#282D2A] shadow-2xs">
        <div>
            <div class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded text-[10px] font-bold bg-[#E5EDE8] dark:bg-[#23352B] text-[#1B3D2F] dark:text-[#8BB39D] uppercase tracking-wider mb-1.5">
                <i class="ri-community-line"></i> Quản lý cơ sở vật chất
            </div>
            <h1 class="text-xl sm:text-2xl font-black text-[#171A19] dark:text-white tracking-tight">
                Danh Sách Khu / Dãy Trọ
            </h1>
            <p class="text-xs text-[#85877F] mt-0.5">
                Quản lý các tòa nhà, dãy phòng và cơ sở lưu trú trực thuộc tài khoản chủ nhà
            </p>
        </div>

        <div class="flex items-center gap-2.5">
            <a href="{{ route('chu-tro.dashboard') }}"
                class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-lg bg-[#FAF9F6] dark:bg-[#222724] border border-[#E5E3DC] dark:border-[#282D2A] text-[#171A19] dark:text-[#EAE8E1] text-xs font-bold hover:border-[#1B3D2F] transition">
                <i class="ri-arrow-left-line"></i>
                <span>Bảng điều khiển</span>
            </a>

            <a href="{{ route('chu-tro.day-tro.create') }}"
                class="inline-flex items-center gap-1.5 px-4 py-2 rounded-lg bg-[#1B3D2F] hover:bg-[#142E23] text-white font-bold text-xs shadow-2xs transition">
                <i class="ri-add-line text-sm"></i>
                <span>Thêm cơ sở mới</span>
            </a>
        </div>
    </div>

    {{-- Bảng danh sách dãy trọ --}}
    <div class="bg-white dark:bg-[#181B19] rounded-xl border border-[#E5E3DC] dark:border-[#282D2A] shadow-2xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-[#FAF9F6] dark:bg-[#202522] border-b border-[#E5E3DC] dark:border-[#282D2A] text-[10px] font-bold uppercase tracking-wider text-[#85877F]">
                        <th class="py-3 px-3.5 text-center w-12">#</th>
                        <th class="py-3 px-4">Tên cơ sở / Dãy trọ</th>
                        <th class="py-3 px-4">Địa chỉ khu vực</th>
                        <th class="py-3 px-3.5 text-center">Số phòng</th>
                        <th class="py-3 px-3.5 text-center">Diện tích TB</th>
                        <th class="py-3 px-4 text-right">Giá thuê TB</th>
                        <th class="py-3 px-4">Tiện ích tích hợp</th>
                        <th class="py-3 px-3.5 text-center">Ngày tạo</th>
                        <th class="py-3 px-4 text-center">Thao tác</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#E5E3DC]/60 dark:divide-[#282D2A] text-[#202421] dark:text-[#EAE8E1]">
                    @forelse ($dayTroList as $day)
                        <tr class="hover:bg-[#FAF9F6] dark:hover:bg-[#202522] transition-colors">
                            {{-- STT --}}
                            <td class="py-3.5 px-3.5 text-center font-bold text-[#85877F]">
                                {{ $loop->iteration }}
                            </td>

                            {{-- Tên dãy --}}
                            <td class="py-3.5 px-4 font-bold text-[#171A19] dark:text-white">
                                <a href="{{ route('chu-tro.day-tro.show', $day->id) }}" class="hover:text-[#1B3D2F] dark:hover:text-[#8BB39D] transition flex items-center gap-2">
                                    <div class="w-7 h-7 rounded-lg bg-[#E5EDE8] dark:bg-[#23352B] text-[#1B3D2F] dark:text-[#8BB39D] flex items-center justify-center text-xs shrink-0 font-bold">
                                        <i class="ri-community-line"></i>
                                    </div>
                                    <span>{{ $day->ten_day_tro }}</span>
                                </a>
                            </td>

                            {{-- Địa chỉ --}}
                            <td class="py-3.5 px-4 text-[#85877F] max-w-xs">
                                <div class="flex items-start gap-1.5">
                                    <i class="ri-map-pin-2-line text-[#1B3D2F] dark:text-[#8BB39D] text-xs shrink-0 mt-0.5"></i>
                                    <span class="truncate" title="{{ $day->dia_chi }}">{{ $day->dia_chi }}</span>
                                </div>
                            </td>

                            {{-- Số phòng --}}
                            <td class="py-3.5 px-3.5 text-center">
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-bold bg-[#FAF9F6] dark:bg-[#202522] border border-[#E5E3DC] dark:border-[#282D2A] text-[#171A19] dark:text-[#EAE8E1]">
                                    {{ $day->so_phong ?? 0 }} phòng
                                </span>
                            </td>

                            {{-- Diện tích trung bình --}}
                            <td class="py-3.5 px-3.5 text-center font-bold text-[#171A19] dark:text-[#EAE8E1]">
                                {{ $day->dien_tich_tb ? $day->dien_tich_tb . ' m²' : '—' }}
                            </td>

                            {{-- Giá trung bình --}}
                            <td class="py-3.5 px-4 text-right font-black text-[#1B3D2F] dark:text-[#8BB39D]">
                                {{ $day->gia_trung_binh ? number_format($day->gia_trung_binh, 0, ',', '.') . ' đ' : '—' }}
                            </td>

                            {{-- Tiện ích --}}
                            <td class="py-3.5 px-4 text-[#85877F] max-w-[180px] truncate" title="{{ $day->tien_ich }}">
                                {{ $day->tien_ich ?? '—' }}
                            </td>

                            {{-- Ngày tạo --}}
                            <td class="py-3.5 px-3.5 text-center text-[11px] text-[#85877F]">
                                {{ $day->ngay_tao ? \Carbon\Carbon::parse($day->ngay_tao)->format('d/m/Y') : '—' }}
                            </td>

                            {{-- Thao tác --}}
                            <td class="py-3.5 px-4 text-center">
                                <div class="inline-flex items-center gap-1">
                                    {{-- Xem chi tiết --}}
                                    <a href="{{ route('chu-tro.day-tro.show', $day->id) }}"
                                        class="w-7 h-7 rounded-md flex items-center justify-center bg-[#FAF9F6] dark:bg-[#202522] border border-[#E5E3DC] dark:border-[#282D2A] text-[#85877F] hover:text-[#1B3D2F] hover:border-[#1B3D2F] transition"
                                        title="Xem chi tiết">
                                        <i class="ri-eye-line text-sm"></i>
                                    </a>

                                    {{-- Sửa --}}
                                    <a href="{{ route('chu-tro.day-tro.edit', $day->id) }}"
                                        class="w-7 h-7 rounded-md flex items-center justify-center bg-[#FAF9F6] dark:bg-[#202522] border border-[#E5E3DC] dark:border-[#282D2A] text-[#85877F] hover:text-[#1B3D2F] hover:border-[#1B3D2F] transition"
                                        title="Chỉnh sửa">
                                        <i class="ri-edit-line text-sm"></i>
                                    </a>

                                    {{-- Xóa --}}
                                    <form action="{{ route('chu-tro.day-tro.destroy', $day->id) }}" method="POST" class="inline">
                                        @csrf @method('DELETE')
                                        <button onclick="return confirm('Bạn có chắc chắn muốn xóa dãy trọ này?')"
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
                            <td colspan="9" class="py-12 px-6 text-center">
                                <div class="max-w-sm mx-auto space-y-3">
                                    <div class="w-12 h-12 rounded-xl bg-[#E5EDE8] dark:bg-[#23352B] text-[#1B3D2F] dark:text-[#8BB39D] flex items-center justify-center text-2xl mx-auto">
                                        <i class="ri-community-line"></i>
                                    </div>
                                    <h3 class="text-sm font-extrabold text-[#171A19] dark:text-white">Chưa có cơ sở nào</h3>
                                    <p class="text-xs text-[#85877F]">
                                        Hãy tạo dãy hoặc khu nhà trọ đầu tiên để bắt đầu thêm phòng và phân bổ quản lý.
                                    </p>
                                    <a href="{{ route('chu-tro.day-tro.create') }}"
                                        class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-lg bg-[#1B3D2F] hover:bg-[#142E23] text-white font-bold text-xs shadow-2xs transition">
                                        <i class="ri-add-line"></i> Thêm dãy trọ ngay
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