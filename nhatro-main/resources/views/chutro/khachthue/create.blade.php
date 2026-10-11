@extends('layouts.chu-tro')
@section('title', 'Thêm khách thuê')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    {{-- 🔹 Header & Breadcrumb --}}
    <div class="flex items-center justify-between">
        <div>
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-indigo-50 dark:bg-indigo-950/60 text-indigo-600 dark:text-indigo-400 text-xs font-semibold uppercase tracking-wider mb-2 border border-indigo-100 dark:border-indigo-900/50">
                <i class="ri-user-add-line"></i> Đăng ký cư dân
            </div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 dark:text-white tracking-tight flex items-center gap-2.5">
                <span class="w-2.5 h-8 bg-gradient-to-b from-indigo-500 to-sky-500 rounded-full inline-block"></span>
                Thêm khách thuê mới
            </h1>
            <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">
                Nhập thông tin cá nhân và định danh để tạo tài khoản cư dân trong hệ thống
            </p>
        </div>

        <a href="{{ route('chu-tro.khachthue.index') }}"
            class="inline-flex items-center gap-2 px-4 py-2 text-sm font-semibold text-slate-600 dark:text-slate-300 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl hover:bg-slate-50 dark:hover:bg-slate-700/60 shadow-sm transition">
            <i class="ri-arrow-left-line"></i> Quay lại
        </a>
    </div>

    {{-- 🔹 Main Form Card --}}
    <div class="bg-white dark:bg-slate-900 p-6 sm:p-8 rounded-3xl border border-slate-200/80 dark:border-slate-800 shadow-sm">
        <form method="POST" action="{{ route('chu-tro.khachthue.store') }}" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Họ tên --}}
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-300 mb-2">
                        Họ và tên <span class="text-rose-500">*</span>
                    </label>
                    <div class="relative">
                        <i class="ri-user-3-line absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-base"></i>
                        <input type="text" name="ho_ten" value="{{ old('ho_ten') }}" required placeholder="Ví dụ: Nguyễn Văn A"
                            class="w-full pl-10 pr-4 py-2.5 text-sm bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white rounded-xl focus:ring-2 focus:ring-indigo-500/30 focus:border-indigo-500 outline-none transition">
                    </div>
                    @error('ho_ten') <p class="text-xs text-rose-500 font-medium mt-1.5">{{ $message }}</p> @enderror
                </div>

                {{-- Email --}}
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-300 mb-2">
                        Địa chỉ Email <span class="text-rose-500">*</span>
                    </label>
                    <div class="relative">
                        <i class="ri-mail-line absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-base"></i>
                        <input type="email" name="email" value="{{ old('email') }}" placeholder="khachthue@gmail.com"
                            class="w-full pl-10 pr-4 py-2.5 text-sm bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white rounded-xl focus:ring-2 focus:ring-indigo-500/30 focus:border-indigo-500 outline-none transition">
                    </div>
                    @error('email') <p class="text-xs text-rose-500 font-medium mt-1.5">{{ $message }}</p> @enderror
                </div>

                {{-- SĐT --}}
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-300 mb-2">
                        Số điện thoại <span class="text-rose-500">*</span>
                    </label>
                    <div class="relative">
                        <i class="ri-phone-line absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-base"></i>
                        <input type="text" name="sdt" value="{{ old('sdt') }}" placeholder="09xxxxxxxx"
                            class="w-full pl-10 pr-4 py-2.5 text-sm bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white rounded-xl focus:ring-2 focus:ring-indigo-500/30 focus:border-indigo-500 outline-none transition">
                    </div>
                    @error('sdt') <p class="text-xs text-rose-500 font-medium mt-1.5">{{ $message }}</p> @enderror
                </div>

                {{-- CCCD --}}
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-300 mb-2">
                        Số CCCD / Định danh <span class="text-rose-500">*</span>
                    </label>
                    <div class="relative">
                        <i class="ri-id-card-line absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-base"></i>
                        <input type="text" name="cccd" value="{{ old('cccd') }}" placeholder="12 chữ số"
                            class="w-full pl-10 pr-4 py-2.5 text-sm bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white rounded-xl focus:ring-2 focus:ring-indigo-500/30 focus:border-indigo-500 outline-none transition">
                    </div>
                    @error('cccd') <p class="text-xs text-rose-500 font-medium mt-1.5">{{ $message }}</p> @enderror
                </div>

                {{-- Ghi chú --}}
                <div class="md:col-span-2">
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-300 mb-2">
                        Ghi chú bổ sung
                    </label>
                    <textarea name="ghi_chu" rows="3" placeholder="Nơi làm việc, ghi chú xe cộ, yêu cầu thêm..."
                        class="w-full p-3 text-sm bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white rounded-xl focus:ring-2 focus:ring-indigo-500/30 focus:border-indigo-500 outline-none transition">{{ old('ghi_chu') }}</textarea>
                    @error('ghi_chu') <p class="text-xs text-rose-500 font-medium mt-1.5">{{ $message }}</p> @enderror
                </div>
            </div>

            {{-- 🔹 Action Buttons --}}
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100 dark:border-slate-800">
                <a href="{{ route('chu-tro.khachthue.index') }}"
                    class="px-5 py-2.5 text-sm font-semibold text-slate-600 dark:text-slate-400 hover:text-slate-800 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-xl transition">
                    Hủy bỏ
                </a>

                <button type="submit"
                    class="inline-flex items-center gap-2 px-6 py-2.5 bg-gradient-to-r from-indigo-600 via-indigo-500 to-sky-500 hover:from-indigo-700 hover:to-sky-600 text-white text-sm font-semibold rounded-xl shadow-lg shadow-indigo-500/20 hover:shadow-indigo-500/30 transition-all">
                    <i class="ri-save-3-line"></i> Lưu khách thuê
                </button>
            </div>
        </form>
    </div>
</div>
@endsection