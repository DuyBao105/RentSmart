@extends('layouts.chu-tro')

@section('title', 'Chi tiết Dãy Trọ - Hệ Thống Trọ')

@section('content')
<div class="max-w-5xl mx-auto space-y-8 animate-fade-in">
    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-sky-100 dark:bg-sky-950 text-sky-700 dark:text-sky-300 mb-2">
                <i class="ri-community-line"></i> Thông Tin Cơ Sở
            </div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 dark:text-white tracking-tight">
                {{ $dayTro->ten_day_tro }}
            </h1>
            <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 mt-1 flex items-center gap-1">
                <i class="ri-map-pin-2-line text-sky-500"></i>
                <span>{{ $dayTro->dia_chi }}</span>
            </p>
        </div>

        <div class="flex items-center gap-3">
            <a href="{{ route('chu-tro.day-tro.edit', $dayTro->id) }}"
                class="inline-flex items-center gap-1.5 px-4 py-2.5 rounded-xl bg-gradient-to-r from-sky-600 to-sky-500 hover:from-sky-700 hover:to-sky-600 text-white text-xs sm:text-sm font-bold shadow-md shadow-sky-500/25 transition">
                <i class="ri-edit-2-line"></i>
                <span>Chỉnh sửa thông tin</span>
            </a>
            <a href="{{ route('chu-tro.day-tro.index') }}"
                class="inline-flex items-center gap-1.5 px-4 py-2.5 rounded-xl bg-white dark:bg-slate-800 border border-slate-200/80 dark:border-slate-700 hover:bg-slate-50 text-slate-700 dark:text-slate-200 text-xs sm:text-sm font-bold shadow-xs transition">
                <i class="ri-arrow-left-line"></i>
                <span>Quay lại</span>
            </a>
        </div>
    </div>

    {{-- KPI Cards --}}
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
        <div class="bg-white dark:bg-slate-800 rounded-3xl p-5 border border-slate-200/80 dark:border-slate-700 shadow-sm">
            <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400 block mb-1">Quy mô</span>
            <div class="flex items-baseline gap-1">
                <span class="text-2xl font-black text-slate-900 dark:text-white">{{ $dayTro->so_phong ?? '0' }}</span>
                <span class="text-xs text-slate-400 font-semibold">phòng</span>
            </div>
        </div>

        <div class="bg-white dark:bg-slate-800 rounded-3xl p-5 border border-slate-200/80 dark:border-slate-700 shadow-sm">
            <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400 block mb-1">Diện tích TB</span>
            <div class="flex items-baseline gap-1">
                <span class="text-2xl font-black text-slate-900 dark:text-white">{{ $dayTro->dien_tich_tb ?? '—' }}</span>
                <span class="text-xs text-slate-400 font-semibold">m²</span>
            </div>
        </div>

        <div class="bg-white dark:bg-slate-800 rounded-3xl p-5 border border-slate-200/80 dark:border-slate-700 shadow-sm">
            <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400 block mb-1">Giá thuê TB</span>
            <div class="flex items-baseline gap-1">
                <span class="text-2xl font-black text-emerald-600 dark:text-emerald-400">
                    {{ $dayTro->gia_trung_binh ? number_format($dayTro->gia_trung_binh, 0, ',', '.') : '—' }}
                </span>
                <span class="text-xs text-slate-400 font-semibold">đ/th</span>
            </div>
        </div>

        <div class="bg-white dark:bg-slate-800 rounded-3xl p-5 border border-slate-200/80 dark:border-slate-700 shadow-sm">
            <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400 block mb-1">Ngày tạo</span>
            <span class="text-sm font-bold text-slate-800 dark:text-slate-200 block mt-1">
                {{ $dayTro->ngay_tao ? \Carbon\Carbon::parse($dayTro->ngay_tao)->format('d/m/Y') : '—' }}
            </span>
        </div>
    </div>

    {{-- Details Card --}}
    <div class="bg-white dark:bg-slate-800 rounded-3xl border border-slate-200/80 dark:border-slate-700 shadow-sm p-6 sm:p-8 space-y-6">
        <h2 class="text-lg font-bold text-slate-900 dark:text-white border-b border-slate-100 dark:border-slate-700/60 pb-4">
            Mô Tả & Tiện Nghi
        </h2>

        {{-- Tiện ích --}}
        <div>
            <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-3">Tiện ích hỗ trợ</h3>
            @if($dayTro->tien_ich)
                <div class="flex flex-wrap gap-2">
                    @foreach(explode(',', $dayTro->tien_ich) as $item)
                        @if(trim($item))
                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-sky-50 dark:bg-sky-950/60 text-sky-700 dark:text-sky-300 text-xs font-semibold border border-sky-100 dark:border-sky-900/40">
                                <i class="ri-checkbox-circle-fill text-sky-500"></i>
                                {{ trim($item) }}
                            </span>
                        @endif
                    @endforeach
                </div>
            @else
                <p class="text-xs text-slate-400 italic">Chưa có thông tin tiện ích cụ thể.</p>
            @endif
        </div>

        {{-- Mô tả --}}
        <div>
            <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-2">Mô tả chi tiết</h3>
            @if($dayTro->mo_ta)
                <div class="p-4 rounded-2xl bg-slate-50/70 dark:bg-slate-900/60 text-slate-700 dark:text-slate-300 text-sm whitespace-pre-line leading-relaxed">
                    {{ $dayTro->mo_ta }}
                </div>
            @else
                <p class="text-xs text-slate-400 italic">Chưa có mô tả chi tiết.</p>
            @endif
        </div>

        {{-- Thông tin kiểm toán --}}
        <div class="pt-4 border-t border-slate-100 dark:border-slate-700/60 flex flex-wrap items-center justify-between text-xs text-slate-400 gap-4">
            <div>
                Ngày khởi tạo: <span class="font-semibold text-slate-600 dark:text-slate-300">{{ $dayTro->ngay_tao ? \Carbon\Carbon::parse($dayTro->ngay_tao)->format('d/m/Y H:i') : '—' }}</span>
            </div>
            <div>
                Cập nhật lần cuối: <span class="font-semibold text-slate-600 dark:text-slate-300">{{ $dayTro->ngay_cap_nhat ? \Carbon\Carbon::parse($dayTro->ngay_cap_nhat)->format('d/m/Y H:i') : '—' }}</span>
            </div>
        </div>
    </div>
</div>
@endsection