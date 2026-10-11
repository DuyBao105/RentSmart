@extends('layouts.chu-tro')

@section('title', 'Cập nhật người thân')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    {{-- 🔹 Header --}}
    <div class="flex items-center justify-between">
        <div>
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-amber-50 dark:bg-amber-950/60 text-amber-600 dark:text-amber-400 text-xs font-semibold uppercase tracking-wider mb-2 border border-amber-100 dark:border-amber-900/50">
                <i class="ri-edit-line"></i> Điều chỉnh lưu trú
            </div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 dark:text-white tracking-tight flex items-center gap-2.5">
                <span class="w-2.5 h-8 bg-gradient-to-b from-amber-500 to-indigo-500 rounded-full inline-block"></span>
                Cập nhật thông tin người thân
            </h1>
            <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">
                Sửa đổi dữ liệu định danh hoặc số điện thoại của người thân đang ở cùng
            </p>
        </div>

        <a href="{{ route('chu-tro.nguoi-than.index', $khachThueId) }}"
            class="inline-flex items-center gap-2 px-4 py-2 text-sm font-semibold text-slate-600 dark:text-slate-300 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl hover:bg-slate-50 dark:hover:bg-slate-700/60 shadow-sm transition">
            <i class="ri-arrow-left-line"></i> Quay lại
        </a>
    </div>

    {{-- 🔹 Thông báo --}}
    @if (session('success'))
        <div class="p-4 rounded-2xl bg-emerald-50 dark:bg-emerald-950/40 border border-emerald-200 dark:border-emerald-800 text-emerald-800 dark:text-emerald-300 text-sm flex items-center gap-3">
            <i class="ri-checkbox-circle-fill text-lg text-emerald-500"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif
    @if (session('error'))
        <div class="p-4 rounded-2xl bg-rose-50 dark:bg-rose-950/40 border border-rose-200 dark:border-rose-800 text-rose-800 dark:text-rose-300 text-sm flex items-center gap-3">
            <i class="ri-error-warning-fill text-lg text-rose-500"></i>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    {{-- 🔹 Form Card --}}
    <div class="bg-white dark:bg-slate-900 p-6 sm:p-8 rounded-3xl border border-slate-200/80 dark:border-slate-800 shadow-sm">
        <form method="POST" action="{{ route('chu-tro.nguoi-than.update', [$nguoiThan['id'], $khachThueId]) }}" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Họ và tên --}}
                <div>
                    <label for="ho_ten" class="block text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-300 mb-2">
                        Họ và tên <span class="text-rose-500">*</span>
                    </label>
                    <div class="relative">
                        <i class="ri-user-3-line absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-base"></i>
                        <input type="text" name="ho_ten" id="ho_ten" required
                            value="{{ old('ho_ten', $nguoiThan['ho_ten']) }}"
                            class="w-full pl-10 pr-4 py-2.5 text-sm bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white rounded-xl focus:ring-2 focus:ring-indigo-500/30 focus:border-indigo-500 outline-none transition">
                    </div>
                </div>

                {{-- Quan hệ --}}
                <div>
                    <label for="moi_quan_he" class="block text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-300 mb-2">
                        Mối quan hệ <span class="text-rose-500">*</span>
                    </label>
                    <div class="relative">
                        <i class="ri-heart-line absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-base"></i>
                        <input type="text" name="moi_quan_he" id="moi_quan_he" required
                            value="{{ old('moi_quan_he', $nguoiThan['moi_quan_he']) }}"
                            class="w-full pl-10 pr-4 py-2.5 text-sm bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white rounded-xl focus:ring-2 focus:ring-indigo-500/30 focus:border-indigo-500 outline-none transition">
                    </div>
                </div>

                {{-- CCCD --}}
                <div>
                    <label for="so_cccd" class="block text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-300 mb-2">
                        Số CCCD / CMND
                    </label>
                    <div class="relative">
                        <i class="ri-id-card-line absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-base"></i>
                        <input type="text" name="so_cccd" id="so_cccd"
                            value="{{ old('so_cccd', $nguoiThan['so_cccd']) }}"
                            class="w-full pl-10 pr-4 py-2.5 text-sm bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white rounded-xl focus:ring-2 focus:ring-indigo-500/30 focus:border-indigo-500 outline-none transition">
                    </div>
                </div>

                {{-- Ngày sinh --}}
                <div>
                    <label for="ngay_sinh" class="block text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-300 mb-2">
                        Ngày sinh
                    </label>
                    <div class="relative">
                        <i class="ri-calendar-line absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-base"></i>
                        <input type="date" name="ngay_sinh" id="ngay_sinh"
                            value="{{ old('ngay_sinh', $nguoiThan['ngay_sinh']) }}"
                            class="w-full pl-10 pr-4 py-2.5 text-sm bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white rounded-xl focus:ring-2 focus:ring-indigo-500/30 focus:border-indigo-500 outline-none transition">
                    </div>
                </div>

                {{-- Nghề nghiệp --}}
                <div>
                    <label for="nghe_nghiep" class="block text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-300 mb-2">
                        Nghề nghiệp
                    </label>
                    <div class="relative">
                        <i class="ri-briefcase-line absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-base"></i>
                        <input type="text" name="nghe_nghiep" id="nghe_nghiep"
                            value="{{ old('nghe_nghiep', $nguoiThan['nghe_nghiep']) }}"
                            class="w-full pl-10 pr-4 py-2.5 text-sm bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white rounded-xl focus:ring-2 focus:ring-indigo-500/30 focus:border-indigo-500 outline-none transition">
                    </div>
                </div>

                {{-- SĐT --}}
                <div>
                    <label for="so_dien_thoai" class="block text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-300 mb-2">
                        Số điện thoại
                    </label>
                    <div class="relative">
                        <i class="ri-phone-line absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-base"></i>
                        <input type="text" name="so_dien_thoai" id="so_dien_thoai"
                            value="{{ old('so_dien_thoai', $nguoiThan['so_dien_thoai']) }}"
                            class="w-full pl-10 pr-4 py-2.5 text-sm bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white rounded-xl focus:ring-2 focus:ring-indigo-500/30 focus:border-indigo-500 outline-none transition">
                    </div>
                </div>
            </div>

            {{-- 🔹 Action Buttons --}}
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100 dark:border-slate-800">
                <a href="{{ route('chu-tro.nguoi-than.index', $khachThueId) }}"
                    class="px-5 py-2.5 text-sm font-semibold text-slate-600 dark:text-slate-400 hover:text-slate-800 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-xl transition">
                    Hủy bỏ
                </a>

                <button type="submit"
                    class="inline-flex items-center gap-2 px-6 py-2.5 bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-600 hover:to-amber-700 text-white text-sm font-semibold rounded-xl shadow-lg shadow-amber-500/20 hover:shadow-amber-500/30 transition-all">
                    <i class="ri-check-line"></i> Lưu thay đổi
                </button>
            </div>
        </form>
    </div>
</div>
@endsection