@extends('layouts.app')

@section('title', 'Đăng nhập - Hệ Thống Trọ Bất Động Sản')

@section('content')
<div class="min-h-[85vh] flex items-center justify-center py-10 px-4 sm:px-6 lg:px-8">

    {{-- Main Container --}}
    <div class="w-full max-w-4xl bg-white dark:bg-[#181B19] rounded-2xl border border-[#E5E3DC] dark:border-[#282D2A] shadow-lg overflow-hidden grid grid-cols-1 lg:grid-cols-12 motion-reveal is-revealed">

        {{-- Left: Login Form (7 cols) --}}
        <div class="lg:col-span-7 p-8 sm:p-12 flex flex-col justify-between">
            <div>
                {{-- Header --}}
                <div class="mb-8">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-md bg-[#FAF9F6] dark:bg-[#202522] border border-[#E5E3DC] dark:border-[#303632] text-[#1B3D2F] dark:text-[#A3B899] text-xs font-semibold mb-3">
                        <span class="w-1.5 h-1.5 rounded-full bg-[#1B3D2F] dark:bg-[#A3B899]"></span> Cổng Xác Thực Người Dùng
                    </div>
                    <h1 class="text-2xl sm:text-3xl font-extrabold text-[#171A19] dark:text-white tracking-tight">
                        Đăng nhập tài khoản
                    </h1>
                    <p class="text-[#70746F] dark:text-[#A6AAA7] text-xs sm:text-sm mt-1.5">
                        Truy cập bảng điều khiển khách thuê hoặc hệ thống quản lý bất động sản
                    </p>
                </div>

                {{-- Session Alerts --}}
                @if (session('ok'))
                    <div class="mb-5 bg-emerald-50 dark:bg-emerald-950/40 border border-emerald-200 dark:border-emerald-800 text-emerald-800 dark:text-emerald-300 text-xs sm:text-sm rounded-lg p-3.5 flex items-center gap-2">
                        <i class="ri-checkbox-circle-fill text-emerald-600 dark:text-emerald-400 text-base"></i>
                        <span>{{ session('ok') }}</span>
                    </div>
                @endif
                @if (session('error'))
                    <div class="mb-5 bg-rose-50 dark:bg-rose-950/40 border border-rose-200 dark:border-rose-800 text-rose-800 dark:text-rose-300 text-xs sm:text-sm rounded-lg p-3.5 flex items-center gap-2">
                        <i class="ri-error-warning-fill text-rose-600 dark:text-rose-400 text-base"></i>
                        <span>{{ session('error') }}</span>
                    </div>
                @endif
                @if ($errors->any())
                    <div class="mb-5 bg-rose-50 dark:bg-rose-950/40 border border-rose-200 dark:border-rose-800 text-rose-800 dark:text-rose-300 rounded-lg p-3.5">
                        <ul class="list-disc list-inside text-xs space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- Form --}}
                <form method="POST" action="{{ route('login') }}" class="space-y-4">
                    @csrf

                    {{-- Email --}}
                    <div>
                        <label for="email" class="block text-xs font-semibold text-[#171A19] dark:text-[#E8EAE9] uppercase tracking-wider mb-1.5">
                            Địa chỉ Email
                        </label>
                        <div class="relative">
                            <i class="ri-mail-line absolute left-3.5 top-1/2 -translate-y-1/2 text-[#85877F] text-sm"></i>
                            <input
                                type="email"
                                id="email"
                                name="email"
                                value="{{ old('email') }}"
                                required
                                autofocus
                                class="w-full pl-9 pr-4 py-2.5 bg-[#FAF9F6] dark:bg-[#1F2321] border border-[#E5E3DC] dark:border-[#303632] rounded-lg focus:bg-white dark:focus:bg-[#181B19] focus:outline-none focus:border-[#1B3D2F] dark:focus:border-[#7EA089] text-[#171A19] dark:text-white text-xs sm:text-sm placeholder-[#9EA09B] transition input-focus-smooth"
                                placeholder="name@domain.com"
                            />
                        </div>
                        @error('email')
                            <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Password --}}
                    <div>
                        <div class="flex items-center justify-between mb-1.5">
                            <label for="mat_khau" class="block text-xs font-semibold text-[#171A19] dark:text-[#E8EAE9] uppercase tracking-wider">
                                Mật khẩu
                            </label>
                            <a href="#" class="text-xs text-[#1B3D2F] dark:text-[#A3B899] hover:underline font-medium">
                                Quên mật khẩu?
                            </a>
                        </div>
                        <div class="relative" x-data="{ showPass: false }">
                            <i class="ri-lock-2-line absolute left-3.5 top-1/2 -translate-y-1/2 text-[#85877F] text-sm"></i>
                            <input
                                :type="showPass ? 'text' : 'password'"
                                id="mat_khau"
                                name="mat_khau"
                                required
                                autocomplete="current-password"
                                class="w-full pl-9 pr-10 py-2.5 bg-[#FAF9F6] dark:bg-[#1F2321] border border-[#E5E3DC] dark:border-[#303632] rounded-lg focus:bg-white dark:focus:bg-[#181B19] focus:outline-none focus:border-[#1B3D2F] dark:focus:border-[#7EA089] text-[#171A19] dark:text-white text-xs sm:text-sm placeholder-[#9EA09B] transition input-focus-smooth"
                                placeholder="••••••••"
                            />
                            <button type="button" @click="showPass = !showPass" class="absolute right-3 top-1/2 -translate-y-1/2 text-[#85877F] hover:text-[#171A19] dark:hover:text-white text-sm">
                                <i :class="showPass ? 'ri-eye-off-line' : 'ri-eye-line'"></i>
                            </button>
                        </div>
                        @error('mat_khau')
                            <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Remember me --}}
                    <div class="flex items-center pt-1">
                        <label class="flex items-center cursor-pointer select-none text-xs text-[#70746F] dark:text-[#A6AAA7]">
                            <input
                                type="checkbox"
                                id="remember"
                                name="remember"
                                class="w-4 h-4 text-[#1B3D2F] rounded border-[#D8D4CA] focus:ring-0 transition cursor-pointer"
                                {{ old('remember') ? 'checked' : '' }}
                            />
                            <span class="ml-2">Duy trì trạng thái đăng nhập trên thiết bị này</span>
                        </label>
                    </div>

                    {{-- Submit CTA --}}
                    <button
                        type="submit"
                        class="w-full mt-2 bg-[#1B3D2F] hover:bg-[#142F24] text-white font-semibold py-3 rounded-lg shadow-2xs transition-all text-xs sm:text-sm flex items-center justify-center gap-2 cursor-pointer micro-press btn-glow-teal"
                    >
                        <i class="ri-login-box-line"></i>
                        <span>Đăng nhập hệ thống</span>
                    </button>
                </form>

                {{-- Divider --}}
                <div class="relative my-6 text-center">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-[#E5E3DC] dark:border-[#282D2A]"></div>
                    </div>
                    <span class="relative px-3 bg-white dark:bg-[#181B19] text-[#85877F] text-xs uppercase tracking-wider font-medium">
                        Hoặc kết nối qua
                    </span>
                </div>

                {{-- Google Auth --}}
                <div>
                    <a
                        href="{{ env('API_BASE_URL', 'http://127.0.0.1:8000') }}/api/auth/google/redirect"
                        class="w-full flex items-center justify-center gap-2.5 py-2.5 px-4 rounded-lg bg-[#FAF9F6] dark:bg-[#202522] border border-[#E5E3DC] dark:border-[#303632] hover:bg-[#EAE8E1] dark:hover:bg-[#29302B] text-xs sm:text-sm font-semibold text-[#171A19] dark:text-white transition micro-press"
                    >
                        <svg class="w-4 h-4" viewBox="0 0 24 24">
                            <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                            <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                            <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22.81-.63z"/>
                            <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.52 6.16-4.52z"/>
                        </svg>
                        <span>Tài khoản Google</span>
                    </a>
                </div>
            </div>

            {{-- Footer link --}}
            <div class="mt-8 pt-4 border-t border-[#E5E3DC] dark:border-[#282D2A] text-center text-xs text-[#70746F] dark:text-[#A6AAA7]">
                Chưa có tài khoản?
                <a href="{{ route('register') }}" class="text-[#1B3D2F] dark:text-[#A3B899] font-bold hover:underline ml-1">
                    Đăng ký tài khoản mới
                </a>
            </div>
        </div>

        {{-- Right: Editorial Real Estate Showcase (5 cols) --}}
        <div class="hidden lg:flex lg:col-span-5 relative bg-[#171A19] text-white flex-col justify-between p-10 overflow-hidden">
            <img
                src="{{ asset('upload/room_real_1.jpg') }}"
                alt="Phòng thực tế"
                class="absolute inset-0 w-full h-full object-cover opacity-45 scale-102"
            />
            <div class="absolute inset-0 bg-gradient-to-t from-[#141716] via-[#141716]/60 to-transparent"></div>

            <div class="relative z-10 flex items-center justify-between">
                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md bg-[#1B3D2F]/90 backdrop-blur-md text-[11px] font-semibold text-white border border-white/10">
                    <i class="ri-shield-check-fill text-emerald-300"></i>
                    Bảo chứng thực địa
                </span>
                <span class="text-xs text-[#A6AAA7] font-mono">1.660+ Phòng</span>
            </div>

            <div class="relative z-10 space-y-3">
                <div class="text-[11px] font-semibold uppercase tracking-wider text-[#A6824D]">
                    Chuẩn Mực Khám Phá & Thuê Phòng
                </div>
                <h3 class="text-xl font-bold leading-snug">
                    Minh bạch giá niêm yết, hợp đồng điện tử bảo vệ quyền lợi người thuê.
                </h3>
                <p class="text-xs text-[#C5C8C4] leading-relaxed">
                    100% hình ảnh căn phòng được chụp thực địa, biểu phí điện nước dịch vụ công khai trực tiếp trước khi đặt lịch xem phòng.
                </p>
                <div class="pt-2 flex items-center gap-4 text-[11px] text-[#A6AAA7]">
                    <span class="inline-flex items-center gap-1.5"><i class="ri-checkbox-circle-fill text-teal-400"></i> Không phí trung gian</span>
                    <span class="inline-flex items-center gap-1.5"><i class="ri-checkbox-circle-fill text-teal-400"></i> Hỗ trợ 24/7</span>
                    <span class="inline-flex items-center gap-1.5"><i class="ri-checkbox-circle-fill text-teal-400"></i> Hợp đồng an toàn</span>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection