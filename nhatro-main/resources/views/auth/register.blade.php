@extends('layouts.app')

@section('title', 'Đăng ký tài khoản - Hệ Thống Trọ Bất Động Sản')

@section('content')
<div class="min-h-[85vh] flex items-center justify-center py-10 px-4 sm:px-6 lg:px-8">

    {{-- Main Container --}}
    <div class="w-full max-w-4xl bg-white dark:bg-[#181B19] rounded-2xl border border-[#E5E3DC] dark:border-[#282D2A] shadow-lg overflow-hidden grid grid-cols-1 lg:grid-cols-12 motion-reveal is-revealed">

        {{-- Left: Register Form (7 cols) --}}
        <div class="lg:col-span-7 p-8 sm:p-10 flex flex-col justify-between"
             x-data="{ selectedRole: '{{ old('role') ?? 'khach_thue' }}' }">
            <div>
                {{-- Header --}}
                <div class="mb-6">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-md bg-[#FAF9F6] dark:bg-[#202522] border border-[#E5E3DC] dark:border-[#303632] text-[#1B3D2F] dark:text-[#A3B899] text-xs font-semibold mb-2.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-[#1B3D2F] dark:bg-[#A3B899]"></span> Đăng Ký Tài Khoản Mới
                    </div>
                    <h1 class="text-2xl sm:text-3xl font-extrabold text-[#171A19] dark:text-white tracking-tight">
                        Gia nhập Hệ Thống Trọ
                    </h1>
                    <p class="text-[#70746F] dark:text-[#A6AAA7] text-xs sm:text-sm mt-1">
                        Dễ dàng tìm kiếm phòng trọ hoặc đăng ký quản trị vận hành dãy trọ
                    </p>
                </div>

                {{-- Validation errors --}}
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
                <form method="POST" action="{{ route('register.post') }}" class="space-y-4">
                    @csrf

                    {{-- Role Selection (Khách thuê vs Chủ trọ) --}}
                    <div>
                        <label class="block text-xs font-semibold text-[#171A19] dark:text-[#E8EAE9] uppercase tracking-wider mb-2">
                            Bạn tham gia hệ thống với tư cách:
                        </label>
                        <div class="grid grid-cols-2 gap-2.5">
                            <label @click="selectedRole = 'khach_thue'"
                                   :class="selectedRole === 'khach_thue' ? 'bg-[#FAF9F6] dark:bg-[#202522] border-[#1B3D2F] dark:border-[#7EA089] text-[#1B3D2F] dark:text-white shadow-2xs' : 'border-[#E5E3DC] dark:border-[#303632] text-[#70746F] dark:text-[#A6AAA7] hover:bg-[#FAF9F6]'"
                                   class="relative rounded-lg border p-3 cursor-pointer flex items-center justify-between transition micro-press">
                                <div class="flex items-center gap-2">
                                    <i class="ri-user-smile-line text-lg text-[#1B3D2F] dark:text-[#A3B899]"></i>
                                    <div>
                                        <div class="text-xs font-bold leading-tight">Khách Thuê</div>
                                        <div class="text-[10px] text-[#85877F] leading-none mt-0.5">Tìm & thuê phòng</div>
                                    </div>
                                </div>
                                <input type="radio" name="role" value="khach_thue" x-model="selectedRole" class="sr-only">
                                <span :class="selectedRole === 'khach_thue' ? 'bg-[#0D9488] border-[#0D9488] text-white' : 'bg-transparent border-[#CBD5E1] text-transparent'" class="w-4 h-4 rounded-full border flex items-center justify-center text-xs"><i class="ri-check-line"></i></span>
                            </label>

                            <label @click="selectedRole = 'chu_tro'"
                                   :class="selectedRole === 'chu_tro' ? 'bg-[#FAF9F6] dark:bg-[#202522] border-[#1B3D2F] dark:border-[#7EA089] text-[#1B3D2F] dark:text-white shadow-2xs' : 'border-[#E5E3DC] dark:border-[#303632] text-[#70746F] dark:text-[#A6AAA7] hover:bg-[#FAF9F6]'"
                                   class="relative rounded-lg border p-3 cursor-pointer flex items-center justify-between transition micro-press">
                                <div class="flex items-center gap-2">
                                    <i class="ri-building-2-line text-lg text-[#A6824D]"></i>
                                    <div>
                                        <div class="text-xs font-bold leading-tight">Chủ Nhà Trọ</div>
                                        <div class="text-[10px] text-[#85877F] leading-none mt-0.5">Quản lý dãy trọ</div>
                                    </div>
                                </div>
                                <input type="radio" name="role" value="chu_tro" x-model="selectedRole" class="sr-only">
                                <span :class="selectedRole === 'chu_tro' ? 'bg-[#0D9488] border-[#0D9488] text-white' : 'bg-transparent border-[#CBD5E1] text-transparent'" class="w-4 h-4 rounded-full border flex items-center justify-center text-xs"><i class="ri-check-line"></i></span>
                            </label>
                        </div>
                    </div>

                    {{-- Họ và tên & Số điện thoại --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                        <div>
                            <label for="full_name" class="block text-xs font-semibold text-[#171A19] dark:text-[#E8EAE9] uppercase tracking-wider mb-1">
                                Họ và tên
                            </label>
                            <input type="text" id="full_name" name="full_name" value="{{ old('full_name') }}" required
                                   class="w-full px-3.5 py-2 bg-[#FAF9F6] dark:bg-[#1F2321] border border-[#E5E3DC] dark:border-[#303632] rounded-lg focus:bg-white dark:focus:bg-[#181B19] focus:outline-none focus:border-[#1B3D2F] dark:focus:border-[#7EA089] text-[#171A19] dark:text-white text-xs sm:text-sm placeholder-[#9EA09B] transition input-focus-smooth"
                                   placeholder="Nguyễn Văn A" />
                        </div>
                        <div>
                            <label for="phone_number" class="block text-xs font-semibold text-[#171A19] dark:text-[#E8EAE9] uppercase tracking-wider mb-1">
                                Số điện thoại
                            </label>
                            <input type="tel" id="phone_number" name="phone_number" value="{{ old('phone_number') }}" required
                                   class="w-full px-3.5 py-2 bg-[#FAF9F6] dark:bg-[#1F2321] border border-[#E5E3DC] dark:border-[#303632] rounded-lg focus:bg-white dark:focus:bg-[#181B19] focus:outline-none focus:border-[#1B3D2F] dark:focus:border-[#7EA089] text-[#171A19] dark:text-white text-xs sm:text-sm placeholder-[#9EA09B] transition input-focus-smooth"
                                   placeholder="0912 345 678" />
                        </div>
                    </div>

                    {{-- Email --}}
                    <div>
                        <label for="email" class="block text-xs font-semibold text-[#171A19] dark:text-[#E8EAE9] uppercase tracking-wider mb-1">
                            Địa chỉ Email
                        </label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required
                               class="w-full px-3.5 py-2 bg-[#FAF9F6] dark:bg-[#1F2321] border border-[#E5E3DC] dark:border-[#303632] rounded-lg focus:bg-white dark:focus:bg-[#181B19] focus:outline-none focus:border-[#1B3D2F] dark:focus:border-[#7EA089] text-[#171A19] dark:text-white text-xs sm:text-sm placeholder-[#9EA09B] transition input-focus-smooth"
                               placeholder="example@gmail.com" />
                    </div>

                    {{-- Password & Confirm Password --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                        <div>
                            <label for="password" class="block text-xs font-semibold text-[#171A19] dark:text-[#E8EAE9] uppercase tracking-wider mb-1">
                                Mật khẩu
                            </label>
                            <input type="password" id="password" name="password" required
                                   class="w-full px-3.5 py-2 bg-[#FAF9F6] dark:bg-[#1F2321] border border-[#E5E3DC] dark:border-[#303632] rounded-lg focus:bg-white dark:focus:bg-[#181B19] focus:outline-none focus:border-[#1B3D2F] dark:focus:border-[#7EA089] text-[#171A19] dark:text-white text-xs sm:text-sm placeholder-[#9EA09B] transition input-focus-smooth"
                                   placeholder="Tối thiểu 6 ký tự" />
                        </div>
                        <div>
                            <label for="password_confirmation" class="block text-xs font-semibold text-[#171A19] dark:text-[#E8EAE9] uppercase tracking-wider mb-1">
                                Xác nhận mật khẩu
                            </label>
                            <input type="password" id="password_confirmation" name="password_confirmation" required
                                   class="w-full px-3.5 py-2 bg-[#FAF9F6] dark:bg-[#1F2321] border border-[#E5E3DC] dark:border-[#303632] rounded-lg focus:bg-white dark:focus:bg-[#181B19] focus:outline-none focus:border-[#1B3D2F] dark:focus:border-[#7EA089] text-[#171A19] dark:text-white text-xs sm:text-sm placeholder-[#9EA09B] transition input-focus-smooth"
                                   placeholder="Nhập lại mật khẩu" />
                        </div>
                    </div>

                    {{-- Submit CTA --}}
                    <button
                        type="submit"
                        class="w-full mt-3 bg-[#1B3D2F] hover:bg-[#142F24] text-white font-semibold py-3 rounded-lg shadow-2xs transition-all text-xs sm:text-sm flex items-center justify-center gap-2 cursor-pointer micro-press btn-glow-teal"
                    >
                        <i class="ri-user-add-line"></i>
                        <span>Hoàn tất đăng ký thành viên</span>
                    </button>
                </form>
            </div>

            {{-- Footer link --}}
            <div class="mt-6 pt-4 border-t border-[#E5E3DC] dark:border-[#282D2A] text-center text-xs text-[#70746F] dark:text-[#A6AAA7]">
                Đã có tài khoản trên hệ thống?
                <a href="{{ route('login') }}" class="text-[#1B3D2F] dark:text-[#A3B899] font-bold hover:underline ml-1">
                    Đăng nhập tại đây
                </a>
            </div>
        </div>

        {{-- Right: Editorial Real Estate Showcase (5 cols) --}}
        <div class="hidden lg:flex lg:col-span-5 relative bg-[#171A19] text-white flex-col justify-between p-10 overflow-hidden">
            <img
                src="{{ asset('upload/room_real_10.jpg') }}"
                alt="Phòng trọ cao cấp"
                class="absolute inset-0 w-full h-full object-cover opacity-45 scale-102"
            />
            <div class="absolute inset-0 bg-gradient-to-t from-[#141716] via-[#141716]/60 to-transparent"></div>

            <div class="relative z-10 flex items-center justify-between">
                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md bg-[#1B3D2F]/90 backdrop-blur-md text-[11px] font-semibold text-white border border-white/10">
                    <i class="ri-verified-badge-fill text-amber-300"></i>
                    Nền Tảng Kiểm Định
                </span>
                <span class="text-xs text-[#A6AAA7] font-mono">182+ Dãy trọ</span>
            </div>

            <div class="relative z-10 space-y-3">
                <div class="text-[11px] font-semibold uppercase tracking-wider text-[#A6824D]">
                    Kết Nối Trực Tiếp Chủ Trọ & Khách Thuê
                </div>
                <h3 class="text-xl font-bold leading-snug">
                    Giải pháp quản lý bất động sản thương mại và tìm kiếm phòng an toàn.
                </h3>
                <p class="text-xs text-[#C5C8C4] leading-relaxed">
                    Đồng bộ số liệu công tơ điện nước hàng tháng, thanh toán hóa đơn điện tử tự động và kết nối thông báo chủ nhà chỉ với 1 chạm.
                </p>
                <div class="pt-2 flex items-center gap-4 text-[11px] text-[#A6AAA7]">
                    <span class="inline-flex items-center gap-1.5"><i class="ri-checkbox-circle-fill text-teal-400"></i> Hồ sơ minh bạch</span>
                    <span class="inline-flex items-center gap-1.5"><i class="ri-checkbox-circle-fill text-teal-400"></i> Quản lý chỉ số</span>
                    <span class="inline-flex items-center gap-1.5"><i class="ri-checkbox-circle-fill text-teal-400"></i> Thông báo tức thì</span>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection