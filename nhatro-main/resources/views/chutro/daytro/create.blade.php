@extends('layouts.chu-tro')

@section('title', 'Tạo Dãy Trọ Mới - Hệ Thống Trọ')

@section('content')
<div class="max-w-4xl mx-auto space-y-8 animate-fade-in">
    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-sky-100 dark:bg-sky-950 text-sky-700 dark:text-sky-300 mb-2">
                <i class="ri-add-circle-line"></i> Thêm Cơ Sở Mới
            </div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 dark:text-white tracking-tight">
                Tạo Dãy Trọ Mới
            </h1>
            <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 mt-1">
                Khai báo thông tin cơ sở phòng trọ để bắt đầu vận hành, phân chia phòng và đăng tin
            </p>
        </div>

        <a href="{{ route('chu-tro.day-tro.index') }}"
            class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-white dark:bg-slate-800 border border-slate-200/80 dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-700/50 text-slate-700 dark:text-slate-200 text-xs sm:text-sm font-bold shadow-xs transition">
            <i class="ri-arrow-left-line"></i>
            <span>Quay lại danh sách</span>
        </a>
    </div>

    {{-- Form Container --}}
    <div class="bg-white dark:bg-slate-800 rounded-3xl border border-slate-200/80 dark:border-slate-700 shadow-sm p-6 sm:p-8">
        <form action="{{ route('chu-tro.day-tro.store') }}" method="POST" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Tên dãy trọ --}}
                <div class="space-y-2">
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300">
                        Tên dãy trọ <span class="text-rose-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <i class="ri-community-line text-lg"></i>
                        </span>
                        <input type="text" name="ten_day_tro" value="{{ old('ten_day_tro') }}" required
                            placeholder="VD: Dãy trọ Hưng Thịnh - Khu A"
                            class="w-full pl-10 pr-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-900 text-slate-900 dark:text-white placeholder-slate-400 text-sm focus:bg-white dark:focus:bg-slate-900 focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 transition">
                    </div>
                    @error('ten_day_tro')
                        <p class="text-rose-500 text-xs mt-1 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Địa chỉ khu vực --}}
                <div class="space-y-2">
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300">
                        Địa chỉ (Khu vực) <span class="text-rose-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <i class="ri-map-pin-line text-lg"></i>
                        </span>
                        <select name="dia_chi" required
                            class="w-full pl-10 pr-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-900 text-slate-900 dark:text-white text-sm focus:bg-white dark:focus:bg-slate-900 focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 transition">
                            <option value="">-- Chọn khu vực địa chỉ --</option>
                            @foreach($regions ?? [] as $r)
                                <option value="{{ $r->ten_dia_chi }}" {{ old('dia_chi') == $r->ten_dia_chi ? 'selected' : '' }}>
                                    {{ $r->ten_dia_chi }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <p class="text-[11px] text-slate-400">Khu vực dùng để tối ưu tìm kiếm cho khách thuê xung quanh.</p>
                    @error('dia_chi')
                        <p class="text-rose-500 text-xs mt-1 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Số phòng --}}
                <div class="space-y-2">
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300">
                        Tổng số phòng dự kiến
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <i class="ri-door-open-line text-lg"></i>
                        </span>
                        <input type="number" name="so_phong" min="0" value="{{ old('so_phong', 1) }}"
                            placeholder="VD: 10"
                            class="w-full pl-10 pr-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-900 text-slate-900 dark:text-white placeholder-slate-400 text-sm focus:bg-white dark:focus:bg-slate-900 focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 transition">
                    </div>
                    @error('so_phong')
                        <p class="text-rose-500 text-xs mt-1 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Diện tích trung bình --}}
                <div class="space-y-2">
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300">
                        Diện tích TB (m²)
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <i class="ri-ruler-2-line text-lg"></i>
                        </span>
                        <input type="number" step="0.1" name="dien_tich_tb" min="0" value="{{ old('dien_tich_tb', 25) }}"
                            placeholder="VD: 25.5"
                            class="w-full pl-10 pr-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-900 text-slate-900 dark:text-white placeholder-slate-400 text-sm focus:bg-white dark:focus:bg-slate-900 focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 transition">
                    </div>
                    @error('dien_tich_tb')
                        <p class="text-rose-500 text-xs mt-1 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Giá trung bình --}}
                <div class="space-y-2">
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300">
                        Giá thuê trung bình (VNĐ/tháng)
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <i class="ri-money-dollar-circle-line text-lg"></i>
                        </span>
                        <input type="number" name="gia_trung_binh" min="0" value="{{ old('gia_trung_binh', 3000000) }}"
                            placeholder="VD: 3000000"
                            class="w-full pl-10 pr-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-900 text-slate-900 dark:text-white placeholder-slate-400 text-sm focus:bg-white dark:focus:bg-slate-900 focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 transition">
                    </div>
                    @error('gia_trung_binh')
                        <p class="text-rose-500 text-xs mt-1 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Tiện ích --}}
                <div class="space-y-2">
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300">
                        Tiện ích chung
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <i class="ri-sparkling-line text-lg"></i>
                        </span>
                        <input type="text" name="tien_ich" value="{{ old('tien_ich') }}"
                            placeholder="Wifi tốc độ cao, camera an ninh, nhà để xe riêng..."
                            class="w-full pl-10 pr-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-900 text-slate-900 dark:text-white placeholder-slate-400 text-sm focus:bg-white dark:focus:bg-slate-900 focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 transition">
                    </div>
                    <p class="text-[11px] text-slate-400">Các tiện ích phân tách nhau bằng dấu phẩy (,).</p>
                    @error('tien_ich')
                        <p class="text-rose-500 text-xs mt-1 font-medium">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Mô tả --}}
            <div class="space-y-2">
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300">
                    Mô tả dãy trọ
                </label>
                <textarea name="mo_ta" rows="4"
                    placeholder="Mô tả chi tiết môi trường sống, vị trí giao thông thuận tiện, giờ giấc, an ninh trật tự..."
                    class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-900 text-slate-900 dark:text-white placeholder-slate-400 text-sm focus:bg-white dark:focus:bg-slate-900 focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 transition">{{ old('mo_ta') }}</textarea>
                @error('mo_ta')
                    <p class="text-rose-500 text-xs mt-1 font-medium">{{ $message }}</p>
                @enderror
            </div>

            {{-- Action Buttons --}}
            <div class="pt-4 flex items-center justify-end gap-3 border-t border-slate-100 dark:border-slate-700/60">
                <a href="{{ route('chu-tro.day-tro.index') }}"
                    class="px-5 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700 text-xs sm:text-sm font-bold transition">
                    Hủy bỏ
                </a>
                <button type="submit"
                    class="inline-flex items-center gap-2 px-6 py-2.5 rounded-xl bg-gradient-to-r from-sky-600 to-sky-500 hover:from-sky-700 hover:to-sky-600 text-white text-xs sm:text-sm font-bold shadow-lg shadow-sky-500/25 transition">
                    <i class="ri-check-line text-base"></i>
                    <span>Lưu Dãy Trọ</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection