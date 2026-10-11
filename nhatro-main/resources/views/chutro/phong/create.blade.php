@extends('layouts.chu-tro')

@section('title', 'Thêm Phòng Trọ Mới - Hệ Thống Trọ')

@section('content')
<div class="max-w-4xl mx-auto space-y-8 animate-fade-in">
    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-sky-100 dark:bg-sky-950 text-sky-700 dark:text-sky-300 mb-2">
                <i class="ri-add-circle-line"></i> Quản Lý Phòng
            </div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 dark:text-white tracking-tight">
                Thêm Phòng Trọ Mới
            </h1>
            <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 mt-1">
                Khai báo số phòng, mức giá, tầng và sức chứa để bắt đầu tiếp nhận khách thuê
            </p>
        </div>

        <a href="{{ route('chu-tro.phong.index') }}"
            class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-white dark:bg-slate-800 border border-slate-200/80 dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-700/50 text-slate-700 dark:text-slate-200 text-xs sm:text-sm font-bold shadow-xs transition">
            <i class="ri-arrow-left-line"></i>
            <span>Quay lại danh sách</span>
        </a>
    </div>

    {{-- Form Container --}}
    <div class="bg-white dark:bg-slate-800 rounded-3xl border border-slate-200/80 dark:border-slate-700 shadow-sm p-6 sm:p-8">
        <form action="{{ route('chu-tro.phong.store') }}" method="POST" class="space-y-6">
            @csrf

            {{-- Dãy trọ --}}
            <div class="space-y-2">
                <label for="day_tro_id" class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300">
                    Thuộc Dãy trọ <span class="text-rose-500">*</span>
                </label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                        <i class="ri-community-line text-lg"></i>
                    </span>
                    <select id="day_tro_id" name="day_tro_id" required
                        class="w-full pl-10 pr-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-900 text-slate-900 dark:text-white text-sm focus:bg-white dark:focus:bg-slate-900 focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 transition">
                        <option value="">-- Chọn dãy trọ chứa phòng này --</option>
                        @foreach ($dayTros as $dt)
                            <option value="{{ $dt->id }}" {{ old('day_tro_id') == $dt->id ? 'selected' : '' }}>
                                {{ $dt->ten_day_tro }} ({{ $dt->dia_chi ?? 'Khu vực' }})
                            </option>
                        @endforeach
                    </select>
                </div>
                @error('day_tro_id')
                    <p class="text-rose-500 text-xs mt-1 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Số phòng --}}
                <div class="space-y-2">
                    <label for="so_phong" class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300">
                        Mã / Số phòng <span class="text-rose-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <i class="ri-door-line text-lg"></i>
                        </span>
                        <input type="text" id="so_phong" name="so_phong" value="{{ old('so_phong') }}" required
                            placeholder="Ví dụ: P.101, P.202"
                            class="w-full pl-10 pr-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-900 text-slate-900 dark:text-white placeholder-slate-400 text-sm focus:bg-white dark:focus:bg-slate-900 focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 transition">
                    </div>
                    @error('so_phong')
                        <p class="text-rose-500 text-xs mt-1 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Tầng --}}
                <div class="space-y-2">
                    <label for="tang" class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300">
                        Vị trí tầng <span class="text-rose-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <i class="ri-building-line text-lg"></i>
                        </span>
                        <input type="number" id="tang" name="tang" value="{{ old('tang', 1) }}" required min="0"
                            placeholder="Ví dụ: 1, 2, 3"
                            class="w-full pl-10 pr-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-900 text-slate-900 dark:text-white placeholder-slate-400 text-sm focus:bg-white dark:focus:bg-slate-900 focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 transition">
                    </div>
                    @error('tang')
                        <p class="text-rose-500 text-xs mt-1 font-medium">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                {{-- Giá thuê --}}
                <div class="space-y-2">
                    <label for="gia" class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300">
                        Giá thuê niêm yết (VNĐ) <span class="text-rose-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <i class="ri-money-dollar-circle-line text-lg"></i>
                        </span>
                        <input type="number" id="gia" name="gia" value="{{ old('gia') }}" required min="0"
                            placeholder="3000000"
                            class="w-full pl-10 pr-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-900 text-slate-900 dark:text-white placeholder-slate-400 text-sm focus:bg-white dark:focus:bg-slate-900 focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 transition">
                    </div>
                    @error('gia')
                        <p class="text-rose-500 text-xs mt-1 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Sức chứa --}}
                <div class="space-y-2">
                    <label for="suc_chua" class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300">
                        Sức chứa tối đa (người) <span class="text-rose-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <i class="ri-user-line text-lg"></i>
                        </span>
                        <input type="number" id="suc_chua" name="suc_chua" value="{{ old('suc_chua', 2) }}" required min="1"
                            placeholder="2"
                            class="w-full pl-10 pr-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-900 text-slate-900 dark:text-white placeholder-slate-400 text-sm focus:bg-white dark:focus:bg-slate-900 focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 transition">
                    </div>
                    @error('suc_chua')
                        <p class="text-rose-500 text-xs mt-1 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Diện tích --}}
                <div class="space-y-2">
                    <label for="dien_tich" class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300">
                        Diện tích phòng (m²) <span class="text-rose-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <i class="ri-ruler-2-line text-lg"></i>
                        </span>
                        <input type="number" step="0.1" id="dien_tich" name="dien_tich" value="{{ old('dien_tich', 25) }}"
                            required min="1" placeholder="25.5"
                            class="w-full pl-10 pr-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-900 text-slate-900 dark:text-white placeholder-slate-400 text-sm focus:bg-white dark:focus:bg-slate-900 focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 transition">
                    </div>
                    @error('dien_tich')
                        <p class="text-rose-500 text-xs mt-1 font-medium">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Trạng thái phòng ban đầu --}}
            <div class="space-y-2">
                <label for="trang_thai" class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300">
                    Trạng thái ban đầu
                </label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                        <i class="ri-flag-line text-lg"></i>
                    </span>
                    <select id="trang_thai" name="trang_thai"
                        class="w-full pl-10 pr-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-900 text-slate-900 dark:text-white text-sm focus:bg-white dark:focus:bg-slate-900 focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 transition">
                        <option value="trong" {{ old('trang_thai') == 'trong' ? 'selected' : '' }}>🟢 Phòng trống (Sẵn sàng cho thuê)</option>
                        <option value="da_thue" {{ old('trang_thai') == 'da_thue' ? 'selected' : '' }}>🔵 Đang có người thuê</option>
                        <option value="bao_tri" {{ old('trang_thai') == 'bao_tri' ? 'selected' : '' }}>🟡 Đang bảo trì / Sửa chữa</option>
                    </select>
                </div>
            </div>

            {{-- Action Buttons --}}
            <div class="pt-4 flex items-center justify-end gap-3 border-t border-slate-100 dark:border-slate-700/60">
                <a href="{{ route('chu-tro.phong.index') }}"
                    class="px-5 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-700 dark:text-slate-300 hover:bg-slate-50 text-xs sm:text-sm font-bold transition">
                    Hủy bỏ
                </a>
                <button type="submit"
                    class="inline-flex items-center gap-2 px-6 py-2.5 rounded-xl bg-gradient-to-r from-sky-600 to-sky-500 hover:from-sky-700 hover:to-sky-600 text-white text-xs sm:text-sm font-bold shadow-lg shadow-sky-500/25 transition">
                    <i class="ri-check-line text-base"></i>
                    <span>Lưu Phòng Trọ</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection