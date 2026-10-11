@extends('layouts.chu-tro')

@section('title', 'Chi tiết Phòng ' . $phong->so_phong . ' - Hệ Thống Trọ')

@section('content')
<div class="max-w-5xl mx-auto space-y-8 animate-fade-in">
    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-sky-100 dark:bg-sky-950 text-sky-700 dark:text-sky-300 mb-2">
                <i class="ri-door-open-line"></i> Thông Tin Chi Tiết Phòng
            </div>
            <div class="flex items-center gap-3">
                <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 dark:text-white tracking-tight">
                    Phòng {{ $phong->so_phong }}
                </h1>
                {{-- Status badge --}}
                @if($phong->trang_thai === 'trong')
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-700 dark:bg-emerald-950/60 dark:text-emerald-400">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span> Phòng trống
                    </span>
                @elseif($phong->trang_thai === 'da_thue')
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-sky-100 text-sky-700 dark:bg-sky-950/60 dark:text-sky-400">
                        <span class="w-2 h-2 rounded-full bg-sky-500"></span> Đã thuê
                    </span>
                @else
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-amber-100 text-amber-700 dark:bg-amber-950/60 dark:text-amber-400">
                        <span class="w-2 h-2 rounded-full bg-amber-500"></span> Bảo trì
                    </span>
                @endif
            </div>
            <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 mt-1 flex items-center gap-1">
                <i class="ri-community-line text-sky-500"></i>
                <span>{{ $phong->ten_day_tro }}</span>
                <span class="text-slate-300 dark:text-slate-600">•</span>
                <i class="ri-map-pin-line text-sky-500"></i>
                <span>{{ $phong->dia_chi }}</span>
            </p>
        </div>

        <div class="flex items-center gap-3">
            <a href="{{ route('chu-tro.phong.edit', $phong->id) }}"
                class="inline-flex items-center gap-1.5 px-4 py-2.5 rounded-xl bg-gradient-to-r from-sky-600 to-sky-500 hover:from-sky-700 hover:to-sky-600 text-white text-xs sm:text-sm font-bold shadow-md shadow-sky-500/25 transition">
                <i class="ri-edit-2-line"></i>
                <span>Chỉnh sửa phòng</span>
            </a>
            <a href="{{ route('chu-tro.phong.index') }}"
                class="inline-flex items-center gap-1.5 px-4 py-2.5 rounded-xl bg-white dark:bg-slate-800 border border-slate-200/80 dark:border-slate-700 hover:bg-slate-50 text-slate-700 dark:text-slate-200 text-xs sm:text-sm font-bold shadow-xs transition">
                <i class="ri-arrow-left-line"></i>
                <span>Quay lại</span>
            </a>
        </div>
    </div>

    {{-- KPI Cards --}}
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
        <div class="bg-white dark:bg-slate-800 rounded-3xl p-5 border border-slate-200/80 dark:border-slate-700 shadow-sm">
            <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400 block mb-1">Giá thuê</span>
            <div class="flex items-baseline gap-1">
                <span class="text-2xl font-black text-emerald-600 dark:text-emerald-400">
                    {{ number_format($phong->gia, 0, ',', '.') }}
                </span>
                <span class="text-xs text-slate-400 font-semibold">đ/th</span>
            </div>
        </div>

        <div class="bg-white dark:bg-slate-800 rounded-3xl p-5 border border-slate-200/80 dark:border-slate-700 shadow-sm">
            <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400 block mb-1">Diện tích</span>
            <div class="flex items-baseline gap-1">
                <span class="text-2xl font-black text-slate-900 dark:text-white">{{ $phong->dien_tich }}</span>
                <span class="text-xs text-slate-400 font-semibold">m²</span>
            </div>
        </div>

        <div class="bg-white dark:bg-slate-800 rounded-3xl p-5 border border-slate-200/80 dark:border-slate-700 shadow-sm">
            <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400 block mb-1">Sức chứa</span>
            <div class="flex items-baseline gap-1">
                <span class="text-2xl font-black text-slate-900 dark:text-white">{{ $phong->suc_chua }}</span>
                <span class="text-xs text-slate-400 font-semibold">người</span>
            </div>
        </div>

        <div class="bg-white dark:bg-slate-800 rounded-3xl p-5 border border-slate-200/80 dark:border-slate-700 shadow-sm">
            <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400 block mb-1">Vị trí tầng</span>
            <div class="flex items-baseline gap-1">
                <span class="text-2xl font-black text-slate-900 dark:text-white">Tầng {{ $phong->tang }}</span>
            </div>
        </div>
    </div>

    {{-- Main Info Container --}}
    <div class="bg-white dark:bg-slate-800 rounded-3xl border border-slate-200/80 dark:border-slate-700 shadow-sm p-6 sm:p-8 space-y-6">
        <h2 class="text-lg font-bold text-slate-900 dark:text-white border-b border-slate-100 dark:border-slate-700/60 pb-4">
            Chi Tiết Tiện Nghi & Hạ Tầng
        </h2>

        {{-- Tiện ích của phòng --}}
        <div>
            <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-3">Tiện ích trang bị sẵn</h3>
            @if($tienIch->isEmpty())
                <p class="text-xs text-slate-400 italic">Chưa có tiện ích nào được gắn với phòng này.</p>
            @else
                <div class="flex flex-wrap gap-2.5">
                    @foreach ($tienIch as $ti)
                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-sky-50 dark:bg-sky-950/60 text-sky-700 dark:text-sky-300 text-xs font-semibold border border-sky-100 dark:border-sky-900/40">
                            <i class="ri-checkbox-circle-fill text-sky-500"></i>
                            {{ $ti }}
                        </span>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- Audit Log --}}
        <div class="pt-4 border-t border-slate-100 dark:border-slate-700/60 flex flex-wrap items-center justify-between text-xs text-slate-400 gap-4">
            <div>
                Ngày khởi tạo: <span class="font-semibold text-slate-600 dark:text-slate-300">{{ \Carbon\Carbon::parse($phong->ngay_tao)->format('d/m/Y H:i') }}</span>
            </div>
            <div>
                Cập nhật lần cuối: <span class="font-semibold text-slate-600 dark:text-slate-300">{{ \Carbon\Carbon::parse($phong->ngay_cap_nhat)->format('d/m/Y H:i') }}</span>
            </div>
        </div>
    </div>
</div>
@endsection