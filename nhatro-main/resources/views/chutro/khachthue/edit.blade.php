@extends('layouts.chu-tro')
@section('title', 'Cập nhật khách thuê')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    {{-- 🔹 Header --}}
    <div class="flex items-center justify-between">
        <div>
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-amber-50 dark:bg-amber-950/60 text-amber-600 dark:text-amber-400 text-xs font-semibold uppercase tracking-wider mb-2 border border-amber-100 dark:border-amber-900/50">
                <i class="ri-user-settings-line"></i> Điều chỉnh thông tin
            </div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 dark:text-white tracking-tight flex items-center gap-2.5">
                <span class="w-2.5 h-8 bg-gradient-to-b from-amber-500 to-indigo-500 rounded-full inline-block"></span>
                Cập nhật thông tin khách thuê
            </h1>
            <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">
                Thay đổi thông tin liên lạc và giấy tờ tùy thân của cư dân
            </p>
        </div>

        <a href="{{ route('chu-tro.khachthue.index') }}"
            class="inline-flex items-center gap-2 px-4 py-2 text-sm font-semibold text-slate-600 dark:text-slate-300 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl hover:bg-slate-50 dark:hover:bg-slate-700/60 shadow-sm transition">
            <i class="ri-arrow-left-line"></i> Quay lại
        </a>
    </div>

    {{-- 🔹 Form Card --}}
    <div class="bg-white dark:bg-slate-900 p-6 sm:p-8 rounded-3xl border border-slate-200/80 dark:border-slate-800 shadow-sm">
        <form method="POST" action="{{ route('chu-tro.khachthue.update', $khach_thue['id']) }}" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Họ tên --}}
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-300 mb-2">
                        Họ và tên <span class="text-rose-500">*</span>
                    </label>
                    <div class="relative">
                        <i class="ri-user-3-line absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-base"></i>
                        <input type="text" name="ho_ten" value="{{ old('ho_ten', $khach_thue['ho_ten'] ?? '') }}" required
                            class="w-full pl-10 pr-4 py-2.5 text-sm bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white rounded-xl focus:ring-2 focus:ring-indigo-500/30 focus:border-indigo-500 outline-none transition">
                    </div>
                </div>

                {{-- Email --}}
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-300 mb-2">
                        Email
                    </label>
                    <div class="relative">
                        <i class="ri-mail-line absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-base"></i>
                        <input type="email" name="email" value="{{ old('email', $khach_thue['email'] ?? '') }}"
                            class="w-full pl-10 pr-4 py-2.5 text-sm bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white rounded-xl focus:ring-2 focus:ring-indigo-500/30 focus:border-indigo-500 outline-none transition">
                    </div>
                </div>

                {{-- SĐT --}}
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-300 mb-2">
                        Số điện thoại
                    </label>
                    <div class="relative">
                        <i class="ri-phone-line absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-base"></i>
                        <input type="text" name="sdt" value="{{ old('sdt', $khach_thue['sdt'] ?? '') }}"
                            class="w-full pl-10 pr-4 py-2.5 text-sm bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white rounded-xl focus:ring-2 focus:ring-indigo-500/30 focus:border-indigo-500 outline-none transition">
                    </div>
                </div>

                {{-- CCCD --}}
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-300 mb-2">
                        CCCD / Định danh cá nhân
                    </label>
                    <div class="relative">
                        <i class="ri-id-card-line absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-base"></i>
                        <input type="text" name="cccd" value="{{ old('cccd', $khach_thue['cccd'] ?? '') }}"
                            class="w-full pl-10 pr-4 py-2.5 text-sm bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white rounded-xl focus:ring-2 focus:ring-indigo-500/30 focus:border-indigo-500 outline-none transition">
                    </div>
                </div>

                {{-- Ghi chú --}}
                <div class="md:col-span-2">
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-300 mb-2">
                        Ghi chú
                    </label>
                    <textarea name="ghi_chu" rows="3"
                        class="w-full p-3 text-sm bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white rounded-xl focus:ring-2 focus:ring-indigo-500/30 focus:border-indigo-500 outline-none transition">{{ old('ghi_chu', $khach_thue['ghi_chu'] ?? '') }}</textarea>
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
                    <i class="ri-check-line"></i> Lưu thay đổi
                </button>
            </div>
        </form>
    </div>
</div>
@endsection