@extends('layouts.chu-tro')
@php use Carbon\Carbon; @endphp

@section('title', 'Quản lý Phòng trọ - Hệ Thống Trọ')
@section('header_title', 'Danh Mục Phòng Trọ')
@section('header_subtitle', 'Theo dõi hiện trạng cho thuê, đơn giá, diện tích và cấu hình từng phòng')

@section('content')
<div class="max-w-7xl mx-auto space-y-6">

    {{-- Header --}}
    <div class="motion-reveal card-lift-hover flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white dark:bg-[#181B19] p-6 rounded-xl border border-[#E5E3DC] dark:border-[#282D2A] shadow-2xs">
        <div>
            <div class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded text-[10px] font-bold bg-[#E5EDE8] dark:bg-[#23352B] text-[#1B3D2F] dark:text-[#8BB39D] uppercase tracking-wider mb-1.5">
                <i class="ri-door-open-line"></i> Quản lý không gian
            </div>
            <h1 class="text-xl sm:text-2xl font-black text-[#171A19] dark:text-white tracking-tight">
                Danh Sách Phòng Trọ
            </h1>
            <p class="text-xs text-[#85877F] mt-0.5">
                Theo dõi tình trạng thuê, giá niêm yết, diện tích và các thông số kỹ thuật phòng
            </p>
        </div>

        <div class="flex items-center gap-2.5">
            <a href="{{ route('chu-tro.dashboard') }}"
                class="micro-press inline-flex items-center gap-1.5 px-3.5 py-2 rounded-lg bg-[#FAF9F6] dark:bg-[#222724] border border-[#E5E3DC] dark:border-[#282D2A] text-[#171A19] dark:text-[#EAE8E1] text-xs font-bold hover:border-[#1B3D2F] transition">
                <i class="ri-arrow-left-line"></i>
                <span>Bảng điều khiển</span>
            </a>

            <a href="{{ route('chu-tro.phong.create') }}"
                class="micro-press inline-flex items-center gap-1.5 px-4 py-2 rounded-lg bg-[#1B3D2F] hover:bg-[#142E23] text-white font-bold text-xs shadow-2xs transition">
                <i class="ri-add-line text-sm"></i>
                <span>Thêm phòng mới</span>
            </a>
        </div>
    </div>

    {{-- Bảng danh sách phòng --}}
    <div class="motion-reveal bg-white dark:bg-[#181B19] rounded-xl border border-[#E5E3DC] dark:border-[#282D2A] shadow-2xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-[#FAF9F6] dark:bg-[#202522] border-b border-[#E5E3DC] dark:border-[#282D2A] text-[10px] font-bold uppercase tracking-wider text-[#85877F]">
                        <th class="py-3 px-3.5 text-center w-12">#</th>
                        <th class="py-3 px-4">Khu / Dãy</th>
                        <th class="py-3 px-4">Mã số phòng</th>
                        <th class="py-3 px-3.5 text-center">Tầng</th>
                        <th class="py-3 px-3.5 text-center">Diện tích</th>
                        <th class="py-3 px-4 text-right">Giá thuê niêm yết</th>
                        <th class="py-3 px-3.5 text-center">Sức chứa</th>
                        <th class="py-3 px-4 text-center">Hiện trạng</th>
                        <th class="py-3 px-3.5 text-center">Ngày tạo</th>
                        <th class="py-3 px-4 text-center">Thao tác</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#E5E3DC]/60 dark:divide-[#282D2A] text-[#202421] dark:text-[#EAE8E1]">
                    @forelse ($phongs as $p)
                        <tr class="table-row-hover transition-colors">
                            {{-- STT --}}
                            <td class="py-3.5 px-3.5 text-center font-bold text-[#85877F]">
                                {{ $loop->iteration }}
                            </td>

                            {{-- Thuộc dãy --}}
                            <td class="py-3.5 px-4 font-bold text-[#1B3D2F] dark:text-[#8BB39D]">
                                {{ $p->ten_day_tro }}
                            </td>

                            {{-- Số phòng --}}
                            <td class="py-3.5 px-4 font-black text-[#171A19] dark:text-white">
                                <span class="inline-flex items-center gap-1.5">
                                    <i class="ri-door-closed-line text-[#85877F]"></i>
                                    Phòng {{ $p->so_phong }}
                                </span>
                            </td>

                            {{-- Tầng --}}
                            <td class="py-3.5 px-3.5 text-center text-[#85877F] font-semibold">
                                Tầng {{ $p->tang }}
                            </td>

                            {{-- Diện tích --}}
                            <td class="py-3.5 px-3.5 text-center font-bold text-[#171A19] dark:text-[#EAE8E1]">
                                {{ $p->dien_tich ? number_format($p->dien_tich, 1) . ' m²' : '—' }}
                            </td>

                            {{-- Giá thuê --}}
                            <td class="py-3.5 px-4 text-right font-black text-[#1B3D2F] dark:text-[#8BB39D]">
                                {{ number_format($p->gia, 0, ',', '.') }} đ
                            </td>

                            {{-- Sức chứa --}}
                            <td class="py-3.5 px-3.5 text-center text-[#85877F] font-medium">
                                {{ $p->suc_chua }} người
                            </td>

                            {{-- Trạng thái --}}
                            <td class="py-3.5 px-4 text-center">
                                @php
                                    $statusConfig = [
                                        'trong' => ['bg' => 'bg-[#E5EDE8] dark:bg-[#23352B]', 'text' => 'text-[#1B3D2F] dark:text-[#8BB39D]', 'border' => 'border-[#C7D9CE] dark:border-[#2D4537]', 'label' => 'Còn trống', 'dot' => 'bg-[#1B3D2F]'],
                                        'da_thue' => ['bg' => 'bg-[#FAF9F6] dark:bg-[#202522]', 'text' => 'text-[#171A19] dark:text-[#EAE8E1]', 'border' => 'border-[#E5E3DC] dark:border-[#282D2A]', 'label' => 'Đã thuê', 'dot' => 'bg-emerald-600'],
                                        'bao_tri' => ['bg' => 'bg-amber-50 dark:bg-amber-950/40', 'text' => 'text-amber-800 dark:text-amber-300', 'border' => 'border-amber-200 dark:border-amber-900', 'label' => 'Bảo trì', 'dot' => 'bg-amber-500'],
                                    ];
                                    $cfg = $statusConfig[$p->trang_thai] ?? ['bg' => 'bg-[#FAF9F6]', 'text' => 'text-[#85877F]', 'border' => 'border-[#E5E3DC]', 'label' => $p->trang_thai, 'dot' => 'bg-[#85877F]'];
                                @endphp
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded text-[11px] font-bold border {{ $cfg['bg'] }} {{ $cfg['text'] }} {{ $cfg['border'] }}">
                                    <span class="w-1.5 h-1.5 rounded-full {{ $cfg['dot'] }}"></span>
                                    {{ $cfg['label'] }}
                                </span>
                            </td>

                            {{-- Ngày tạo --}}
                            <td class="py-3.5 px-3.5 text-center text-[11px] text-[#85877F]">
                                {{ Carbon::parse($p->ngay_tao)->format('d/m/Y') }}
                            </td>

                            {{-- Thao tác --}}
                            <td class="py-3.5 px-4 text-center">
                                <div class="inline-flex items-center gap-1">
                                    {{-- Xem chi tiết --}}
                                    <a href="{{ route('chu-tro.phong.show', $p->id) }}"
                                        class="micro-press w-7 h-7 rounded-md flex items-center justify-center bg-[#FAF9F6] dark:bg-[#202522] border border-[#E5E3DC] dark:border-[#282D2A] text-[#85877F] hover:text-[#1B3D2F] hover:border-[#1B3D2F] transition"
                                        title="Xem chi tiết">
                                        <i class="ri-eye-line text-sm"></i>
                                    </a>

                                    {{-- Sửa --}}
                                    <a href="{{ route('chu-tro.phong.edit', $p->id) }}"
                                        class="micro-press w-7 h-7 rounded-md flex items-center justify-center bg-[#FAF9F6] dark:bg-[#202522] border border-[#E5E3DC] dark:border-[#282D2A] text-[#85877F] hover:text-[#1B3D2F] hover:border-[#1B3D2F] transition"
                                        title="Chỉnh sửa">
                                        <i class="ri-edit-line text-sm"></i>
                                    </a>

                                    {{-- Xóa --}}
                                    <form action="{{ route('chu-tro.phong.destroy', $p->id) }}" method="POST" class="inline">
                                        @csrf @method('DELETE')
                                        <button type="submit"
                                            onclick="return confirm('Xác nhận xóa phòng này? Thao tác này không thể hoàn tác.')"
                                            class="micro-press w-7 h-7 rounded-md flex items-center justify-center bg-[#FAF9F6] dark:bg-[#202522] border border-[#E5E3DC] dark:border-[#282D2A] text-[#85877F] hover:text-rose-600 hover:border-rose-400 transition"
                                            title="Xóa">
                                            <i class="ri-delete-bin-line text-sm"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="py-12 px-6 text-center">
                                <div class="max-w-sm mx-auto space-y-3">
                                    <div class="w-12 h-12 rounded-xl bg-[#E5EDE8] dark:bg-[#23352B] text-[#1B3D2F] dark:text-[#8BB39D] flex items-center justify-center text-2xl mx-auto">
                                        <i class="ri-door-open-line"></i>
                                    </div>
                                    <h3 class="text-sm font-extrabold text-[#171A19] dark:text-white">Chưa có phòng nào</h3>
                                    <p class="text-xs text-[#85877F]">
                                        Hãy tạo phòng trọ mới cho các dãy trọ hiện có để quản lý người thuê và xuất bản bài đăng.
                                    </p>
                                    <a href="{{ route('chu-tro.phong.create') }}"
                                        class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-lg bg-[#1B3D2F] hover:bg-[#142E23] text-white font-bold text-xs shadow-2xs transition">
                                        <i class="ri-add-line"></i> Thêm phòng ngay
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