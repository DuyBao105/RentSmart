@extends('layouts.tenant-layout')

@section('title', 'Hồ sơ cá nhân - Nền Tảng Trọ Thông Minh')
@section('page_title', 'Hồ sơ cá nhân cư dân')
@section('page_subtitle', 'Quản lý thông tin định danh, tài khoản bảo mật và thông tin liên hệ khẩn cấp')

@section('tenant_content')
@php
    $curUser = $user ?? session('user') ?? auth()->user();
    $hoTen = $curUser['ho_ten'] ?? $curUser->ho_ten ?? '';
    $sdt = $curUser['so_dien_thoai'] ?? $curUser->so_dien_thoai ?? '';
    $email = $curUser['email'] ?? $curUser->email ?? '';
    $cccd = $curUser['cccd'] ?? $curUser->cccd ?? '';

    $avatar = $curUser['anh_dai_dien'] ?? $curUser->anh_dai_dien ?? null;
    if ($avatar) {
        if (!str_starts_with($avatar, 'http')) {
            $avatar = rtrim(env('API_URL', 'http://127.0.0.1:8000'), '/') . '/' . ltrim($avatar, '/');
        }
        $avatar .= '?v=' . time();
    } else {
        $avatar = 'https://ui-avatars.com/api/?name=' . urlencode($hoTen ?: 'Khach Thue') . '&background=0284c7&color=fff&size=200';
    }
@endphp

<div x-data="{
    avatarPreview: '{{ $avatar }}',
    previewAvatar(e) {
        const file = e.target.files[0];
        if (file) {
            this.avatarPreview = URL.createObjectURL(file);
        }
    }
}" class="space-y-8">

    {{-- FLASH MESSAGES --}}
    @if(session('success'))
        <div class="p-4 rounded-2xl bg-emerald-50 dark:bg-emerald-950/60 border border-emerald-200 dark:border-emerald-800 text-emerald-800 dark:text-emerald-200 flex items-center gap-3">
            <i class="ri-checkbox-circle-fill text-xl text-emerald-600"></i>
            <span class="text-sm font-semibold">{{ session('success') }}</span>
        </div>
    @endif
    @if(session('error'))
        <div class="p-4 rounded-2xl bg-rose-50 dark:bg-rose-950/60 border border-rose-200 dark:border-rose-800 text-rose-800 dark:text-rose-200 flex items-center gap-3">
            <i class="ri-error-warning-fill text-xl text-rose-600"></i>
            <span class="text-sm font-semibold">{{ session('error') }}</span>
        </div>
    @endif

    {{-- MAIN 2-COLUMN PROFILE LAYOUT --}}
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">

        {{-- LEFT COLUMN: TENANT DIGITAL PASSPORT CARD --}}
        <div class="lg:col-span-4 space-y-6">
            <div class="bg-white dark:bg-slate-800/90 rounded-3xl p-6 sm:p-7 border border-slate-200/80 dark:border-slate-700 shadow-sm text-center space-y-5">
                <div class="relative w-28 h-28 mx-auto">
                    <img :src="avatarPreview" alt="Avatar"
                        class="w-full h-full rounded-3xl object-cover border-4 border-white dark:border-slate-700 shadow-lg shadow-slate-200/50 dark:shadow-none">
                    <span class="absolute -bottom-1.5 -right-1.5 w-7 h-7 rounded-full bg-emerald-500 border-2 border-white dark:border-slate-800 flex items-center justify-center text-white text-xs shadow-xs" title="Đang hoạt động">
                        <i class="ri-check-line font-bold"></i>
                    </span>
                </div>

                <div class="space-y-1">
                    <h3 class="text-lg font-black text-slate-900 dark:text-white">{{ $hoTen ?: 'Khách Thuê' }}</h3>
                    <p class="text-xs text-slate-400">{{ $email }}</p>
                    <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-[11px] font-extrabold bg-sky-50 dark:bg-sky-950 text-sky-600 dark:text-sky-300 border border-sky-200/60 mt-2">
                        <i class="ri-shield-check-fill text-sky-500"></i> Cư Dân Đã Xác Thực
                    </span>
                </div>

                {{-- Trust Score & Passport Metrics --}}
                <div class="p-4 rounded-2xl bg-slate-50 dark:bg-slate-900/60 border border-slate-100 dark:border-slate-800 text-left space-y-2.5 text-xs">
                    <div class="flex justify-between items-center">
                        <span class="text-slate-400">Điểm tín nhiệm:</span>
                        <span class="font-black text-emerald-600 flex items-center gap-1">
                            <i class="ri-heart-pulse-fill"></i> 98 / 100
                        </span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-slate-400">Hạng cư dân:</span>
                        <span class="font-extrabold text-amber-500">Thành viên Vàng</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-slate-400">Tham gia:</span>
                        <span class="font-bold text-slate-700 dark:text-slate-200">Từ năm 2025</span>
                    </div>
                </div>

                <div class="text-[11px] text-slate-400 leading-relaxed">
                    Hồ sơ định danh giúp tự động áp dụng thông tin vào các hợp đồng thuê nhà điện tử.
                </div>
            </div>
        </div>

        {{-- RIGHT COLUMN: EDIT PROFILE FORM --}}
        <div class="lg:col-span-8">
            <div class="bg-white dark:bg-slate-800/90 rounded-3xl p-6 sm:p-8 border border-slate-200/80 dark:border-slate-700 shadow-sm space-y-6">
                <div class="border-b border-slate-100 dark:border-slate-700/60 pb-4">
                    <h3 class="text-base font-black text-slate-900 dark:text-white">Cập Nhật Thông Tin Cá Nhân</h3>
                    <p class="text-xs text-slate-400">Các thông tin sẽ được bảo mật và dùng cho giao dịch thuê phòng</p>
                </div>

                <form action="{{ route('khach-thue.profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('PUT')

                    {{-- Upload ảnh đại diện mới --}}
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-300 mb-2">
                            Thay đổi ảnh đại diện
                        </label>
                        <input type="file" name="anh_dai_dien" accept="image/*" @change="previewAvatar($event)"
                            class="w-full text-xs text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-extrabold file:bg-sky-50 file:text-sky-700 hover:file:bg-sky-100 dark:file:bg-sky-950 dark:file:text-sky-300 cursor-pointer">
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        {{-- Họ tên --}}
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-300 mb-2">
                                Họ và tên đầy đủ <span class="text-rose-500">*</span>
                            </label>
                            <div class="relative">
                                <i class="ri-user-line absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-base"></i>
                                <input type="text" name="ho_ten" value="{{ old('ho_ten', $hoTen) }}" required
                                    class="w-full pl-10 pr-4 py-3 text-sm rounded-2xl border border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-900 focus:bg-white focus:ring-2 focus:ring-sky-500 font-medium">
                            </div>
                        </div>

                        {{-- Số điện thoại --}}
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-300 mb-2">
                                Số điện thoại liên hệ <span class="text-rose-500">*</span>
                            </label>
                            <div class="relative">
                                <i class="ri-phone-line absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-base"></i>
                                <input type="tel" name="so_dien_thoai" value="{{ old('so_dien_thoai', $sdt) }}" required
                                    class="w-full pl-10 pr-4 py-3 text-sm rounded-2xl border border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-900 focus:bg-white focus:ring-2 focus:ring-sky-500 font-medium">
                            </div>
                        </div>

                        {{-- Email readonly --}}
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-300 mb-2">
                                Địa chỉ Email đăng nhập (Cố định)
                            </label>
                            <div class="relative">
                                <i class="ri-mail-line absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-base"></i>
                                <input type="email" value="{{ $email }}" readonly
                                    class="w-full pl-10 pr-4 py-3 text-sm rounded-2xl border border-slate-200 dark:border-slate-700 bg-slate-100 dark:bg-slate-800 text-slate-500 dark:text-slate-400 cursor-not-allowed font-medium">
                            </div>
                        </div>

                        {{-- CCCD --}}
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-300 mb-2">
                                Số CCCD / Hộ chiếu
                            </label>
                            <div class="relative">
                                <i class="ri-id-card-line absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-base"></i>
                                <input type="text" name="cccd" value="{{ old('cccd', $cccd) }}" placeholder="VD: 079201001234"
                                    class="w-full pl-10 pr-4 py-3 text-sm rounded-2xl border border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-900 focus:bg-white focus:ring-2 focus:ring-sky-500 font-medium">
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end pt-2">
                        <button type="submit"
                            class="px-6 py-3 rounded-2xl bg-gradient-to-r from-sky-600 to-indigo-600 hover:from-sky-700 hover:to-indigo-700 text-white font-extrabold text-xs sm:text-sm shadow-lg shadow-sky-600/25 transition flex items-center gap-2">
                            <i class="ri-save-line text-lg"></i>
                            <span>Lưu Thay Đổi Hồ Sơ</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>

</div>
@endsection
