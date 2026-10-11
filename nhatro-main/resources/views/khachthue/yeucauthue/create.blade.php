@extends('layouts.tenant-layout')

@section('title', 'Gửi yêu cầu thuê phòng - Nền Tảng Trọ Thông Minh')
@section('page_title', 'Xác nhận & Gửi yêu cầu thuê phòng')
@section('page_subtitle', 'Quy trình đặt cọc giữ chỗ an toàn, trực tiếp ký kết hợp đồng số với chủ trọ')

@section('tenant_content')
@php
    $curUser = $user ?? session('user') ?? auth()->user();
    $hoTen = $curUser['ho_ten'] ?? $curUser->ho_ten ?? '';
    $sdt = $curUser['so_dien_thoai'] ?? $curUser->so_dien_thoai ?? '';
    $email = $curUser['email'] ?? $curUser->email ?? '';
    $cccd = $curUser['cccd'] ?? $curUser->cccd ?? '';

    $baiDangItem = $baiDang ?? [];
    $phongId = $baiDangItem['phong_id'] ?? $baiDangItem['phong']['id'] ?? null;
    $giaNiemYet = (float)($baiDangItem['gia_niem_yet'] ?? $baiDangItem['phong']['gia'] ?? 3000000);
    $tienCocDeXuat = (float)($baiDangItem['tien_coc'] ?? $giaNiemYet);
    $tieuDe = $baiDangItem['tieu_de'] ?? 'Phòng trọ tiện nghi cao cấp';
    $diaChi = $baiDangItem['dia_chi'] ?? $baiDangItem['phong']['day_tro']['dia_chi'] ?? 'Thành phố Hồ Chí Minh';
    $tenDayTro = $baiDangItem['ten_day_tro'] ?? $baiDangItem['phong']['day_tro']['ten_day_tro'] ?? 'Khu trọ an ninh';
    $chuTroTen = $baiDangItem['chu_tro'] ?? $baiDangItem['chu_tro']['ho_ten'] ?? 'Chủ nhà';
    $chuTroSdt = $baiDangItem['sdt_chu_tro'] ?? $baiDangItem['chu_tro']['so_dien_thoai'] ?? '0909000000';
    $anhList = $baiDangItem['anh'] ?? [];
    $anhThumb = !empty($anhList) ? (is_array($anhList) ? ($anhList[0]['url'] ?? $anhList[0]) : $anhList) : asset('upload/room1.jpg');
    if (is_string($anhThumb) && !str_starts_with($anhThumb, 'http') && !str_starts_with($anhThumb, '/')) {
        $anhThumb = asset($anhThumb);
    }
@endphp

<div x-data="{
    selectedRoomId: '{{ $baiDangItem['id'] ?? '' }}',
    thoiHanThang: 12,
    ngayBatDau: new Date(Date.now() + 86400000).toISOString().split('T')[0],
    ngayKetThuc: '',
    tienCoc: {{ $tienCocDeXuat }},
    giaThang: {{ $giaNiemYet }},
    agreeTerms: true,
    fileName: '',

    init() {
        this.updateNgayKetThuc();
    },

    setThoiHan(thang) {
        this.thoiHanThang = thang;
        this.updateNgayKetThuc();
    },

    updateNgayKetThuc() {
        if (!this.ngayBatDau) return;
        const d = new Date(this.ngayBatDau);
        d.setMonth(d.getMonth() + parseInt(this.thoiHanThang));
        this.ngayKetThuc = d.toISOString().split('T')[0];
    },

    handleFileChange(e) {
        const file = e.target.files[0];
        if (file) {
            this.fileName = file.name;
        } else {
            this.fileName = '';
        }
    }
}" class="space-y-8">

    {{-- Breadcrumb Navigation --}}
    <div class="flex items-center gap-2 text-xs font-semibold text-slate-400">
        <a href="{{ route('khach-thue.dashboard') }}" class="hover:text-sky-600 transition flex items-center gap-1">
            <i class="ri-home-4-line"></i> Dashboard
        </a>
        <i class="ri-arrow-right-s-line"></i>
        <a href="{{ route('khach-thue.yeu-cau-thue.index') }}" class="hover:text-sky-600 transition">Yêu cầu thuê</a>
        <i class="ri-arrow-right-s-line"></i>
        <span class="text-slate-700 dark:text-slate-200">Khởi tạo yêu cầu mới</span>
    </div>

    {{-- Banner Step Header (Clean SaaS Style) --}}
    <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 border border-slate-200/80 dark:border-slate-700 shadow-xs flex flex-col md:flex-row md:items-center justify-between gap-5">
        <div class="space-y-1.5">
            <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-md text-[11px] font-bold bg-emerald-50 dark:bg-emerald-950/60 text-emerald-700 dark:text-emerald-300 border border-emerald-200/60">
                <i class="ri-shield-check-fill text-emerald-500"></i> Bảo vệ tiền cọc 100% qua nền tảng
            </span>
            <h2 class="text-xl font-extrabold text-slate-900 dark:text-white tracking-tight">
                Hồ Sơ Yêu Cầu Thuê & Giữ Chỗ Phòng
            </h2>
            <p class="text-xs text-slate-500 dark:text-slate-400 max-w-xl">
                Điền thông tin và ký xác nhận đề xuất thuê. Chủ trọ sẽ duyệt hồ sơ trong 24h và hệ thống sẽ tự động phát hành hợp đồng điện tử có chữ ký số.
            </p>
        </div>

        {{-- 3-Step Indicator --}}
        <div class="flex items-center gap-2 bg-slate-50 dark:bg-slate-900 px-4 py-2.5 rounded-xl border border-slate-200/80 dark:border-slate-700 shrink-0 text-xs">
            <div class="flex items-center gap-1.5">
                <span class="w-5 h-5 rounded-full bg-slate-900 dark:bg-sky-600 text-white font-bold text-[10px] flex items-center justify-center">1</span>
                <span class="font-bold text-slate-800 dark:text-slate-200">Hồ sơ</span>
            </div>
            <span class="text-slate-300">/</span>
            <div class="flex items-center gap-1.5">
                <span class="w-5 h-5 rounded-full bg-slate-200 dark:bg-slate-700 text-slate-600 dark:text-slate-300 font-bold text-[10px] flex items-center justify-center">2</span>
                <span class="font-medium text-slate-500">Thời hạn</span>
            </div>
            <span class="text-slate-300">/</span>
            <div class="flex items-center gap-1.5">
                <span class="w-5 h-5 rounded-full bg-slate-200 dark:bg-slate-700 text-slate-600 dark:text-slate-300 font-bold text-[10px] flex items-center justify-center">3</span>
                <span class="font-medium text-slate-500">Hợp đồng</span>
            </div>
        </div>
    </div>
    {{-- Main Grid: Form (Left) vs Summary Card (Right) --}}
    <form action="{{ route('khach-thue.yeu-cau-thue.store') }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
        @csrf

        {{-- LEFT COLUMN: INPUTS --}}
        <div class="lg:col-span-8 space-y-6">

            {{-- 1. THÔNG TIN NGƯỜI THUÊ --}}
            <div class="bg-white dark:bg-slate-800/90 rounded-3xl p-6 sm:p-7 border border-slate-200/80 dark:border-slate-700 shadow-sm space-y-5">
                <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-700/60 pb-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-2xl bg-sky-50 dark:bg-sky-950 text-sky-600 dark:text-sky-400 flex items-center justify-center text-xl font-bold">
                            <i class="ri-user-smile-line"></i>
                        </div>
                        <div>
                            <h3 class="text-base font-extrabold text-slate-800 dark:text-white">1. Thông tin người thuê (Đại diện hợp đồng)</h3>
                            <p class="text-xs text-slate-400">Dùng để xác thực danh tính và cập nhật vào văn bản hợp đồng pháp lý</p>
                        </div>
                    </div>
                    <span class="text-xs font-semibold px-2.5 py-1 rounded-full bg-emerald-50 dark:bg-emerald-950 text-emerald-600 dark:text-emerald-300 border border-emerald-200/50">
                        <i class="ri-checkbox-circle-fill"></i> Đã đăng nhập
                    </span>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-300 mb-2">
                            Họ và tên người thuê <span class="text-rose-500">*</span>
                        </label>
                        <div class="relative">
                            <i class="ri-user-line absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-base"></i>
                            <input type="text" name="ho_ten" value="{{ old('ho_ten', $hoTen) }}" required
                                class="w-full pl-10 pr-4 py-3 text-sm rounded-2xl border border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-900 focus:bg-white dark:focus:bg-slate-950 focus:ring-2 focus:ring-sky-500 focus:border-sky-500 transition font-medium"
                                placeholder="VD: Nguyễn Văn An">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-300 mb-2">
                            Số điện thoại liên hệ <span class="text-rose-500">*</span>
                        </label>
                        <div class="relative">
                            <i class="ri-phone-line absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-base"></i>
                            <input type="tel" name="so_dien_thoai" value="{{ old('so_dien_thoai', $sdt) }}" required
                                class="w-full pl-10 pr-4 py-3 text-sm rounded-2xl border border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-900 focus:bg-white dark:focus:bg-slate-950 focus:ring-2 focus:ring-sky-500 focus:border-sky-500 transition font-medium"
                                placeholder="VD: 0912345678">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-300 mb-2">
                            Số CCCD / Định danh cá nhân <span class="text-rose-500">*</span>
                        </label>
                        <div class="relative">
                            <i class="ri-id-card-line absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-base"></i>
                            <input type="text" name="cccd" value="{{ old('cccd', $cccd) }}" required minlength="9" maxlength="12"
                                class="w-full pl-10 pr-4 py-3 text-sm rounded-2xl border border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-900 focus:bg-white dark:focus:bg-slate-950 focus:ring-2 focus:ring-sky-500 focus:border-sky-500 transition font-medium"
                                placeholder="VD: 079201001234">
                        </div>
                        <p class="text-[11px] text-slate-400 mt-1.5">Gồm 9 đến 12 chữ số dùng đăng ký tạm trú và hợp đồng thuê.</p>
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-300 mb-2">
                            Email nhận hợp đồng điện tử
                        </label>
                        <div class="relative">
                            <i class="ri-mail-line absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-base"></i>
                            <input type="email" name="email" value="{{ old('email', $email) }}" readonly
                                class="w-full pl-10 pr-4 py-3 text-sm rounded-2xl border border-slate-200 dark:border-slate-700 bg-slate-100 dark:bg-slate-800 text-slate-500 dark:text-slate-400 cursor-not-allowed font-medium">
                        </div>
                    </div>
                </div>

                {{-- CHỌN PHÒNG (NẾU CHƯA CÓ PHÒNG CỐ ĐỊNH) --}}
                @if(empty($baiDangItem['id']))
                    <div class="pt-2 border-t border-slate-100 dark:border-slate-700/60">
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-300 mb-2">
                            Chọn phòng trọ muốn thuê <span class="text-rose-500">*</span>
                        </label>
                        <select name="bai_dang_id" x-model="selectedRoomId" required
                            class="w-full px-4 py-3 text-sm rounded-2xl border border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-900 focus:bg-white dark:focus:bg-slate-950 focus:ring-2 focus:ring-sky-500 font-medium">
                            <option value="">-- Chọn bài đăng phòng trống --</option>
                            @foreach($availableRooms as $rm)
                                <option value="{{ $rm['id'] }}">
                                    #{{ $rm['id'] }} - {{ $rm['tieu_de'] }} ({{ number_format($rm['gia_niem_yet'] ?? 0) }}đ/tháng)
                                </option>
                            @endforeach
                        </select>
                    </div>
                @else
                    <input type="hidden" name="bai_dang_id" value="{{ $baiDangItem['id'] }}">
                @endif
            </div>

            {{-- 2. KẾ HOẠCH THUÊ & THỜI HẠN HỢP ĐỒNG --}}
            <div class="bg-white dark:bg-slate-800/90 rounded-3xl p-6 sm:p-7 border border-slate-200/80 dark:border-slate-700 shadow-sm space-y-5">
                <div class="flex items-center gap-3 border-b border-slate-100 dark:border-slate-700/60 pb-4">
                    <div class="w-10 h-10 rounded-2xl bg-indigo-50 dark:bg-indigo-950 text-indigo-600 dark:text-indigo-400 flex items-center justify-center text-xl font-bold">
                        <i class="ri-calendar-event-line"></i>
                    </div>
                    <div>
                        <h3 class="text-base font-extrabold text-slate-800 dark:text-white">2. Kế hoạch dọn vào & Thời hạn thuê</h3>
                        <p class="text-xs text-slate-400">Chọn mốc thời gian nhận phòng để giữ phòng trước khi khách khác đặt</p>
                    </div>
                </div>

                <div class="space-y-4">
                    {{-- Quick duration selector --}}
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-300 mb-2">
                            Thời hạn hợp đồng mong muốn
                        </label>
                        <div class="grid grid-cols-3 gap-3">
                            <button type="button" @click="setThoiHan(6)"
                                :class="thoiHanThang === 6 ? 'bg-sky-600 text-white font-bold border-sky-600 shadow-md shadow-sky-600/20' : 'bg-slate-50 dark:bg-slate-900 text-slate-600 dark:text-slate-300 border-slate-200 dark:border-slate-700 hover:border-sky-400'"
                                class="py-2.5 px-4 rounded-2xl border text-xs transition flex flex-col items-center justify-center gap-0.5">
                                <span class="text-sm font-extrabold">6 Tháng</span>
                                <span class="text-[10px] opacity-80">Ngắn hạn linh hoạt</span>
                            </button>
                            <button type="button" @click="setThoiHan(12)"
                                :class="thoiHanThang === 12 ? 'bg-sky-600 text-white font-bold border-sky-600 shadow-md shadow-sky-600/20' : 'bg-slate-50 dark:bg-slate-900 text-slate-600 dark:text-slate-300 border-slate-200 dark:border-slate-700 hover:border-sky-400'"
                                class="py-2.5 px-4 rounded-2xl border text-xs transition flex flex-col items-center justify-center gap-0.5 relative">
                                <span class="text-sm font-extrabold">12 Tháng (1 Năm)</span>
                                <span class="text-[10px] opacity-80">Được ưu tiên giá cọc</span>
                                <span class="absolute -top-2 right-2 bg-amber-400 text-slate-950 text-[9px] font-black px-1.5 py-0.2 rounded-full uppercase">Phổ biến</span>
                            </button>
                            <button type="button" @click="setThoiHan(24)"
                                :class="thoiHanThang === 24 ? 'bg-sky-600 text-white font-bold border-sky-600 shadow-md shadow-sky-600/20' : 'bg-slate-50 dark:bg-slate-900 text-slate-600 dark:text-slate-300 border-slate-200 dark:border-slate-700 hover:border-sky-400'"
                                class="py-2.5 px-4 rounded-2xl border text-xs transition flex flex-col items-center justify-center gap-0.5">
                                <span class="text-sm font-extrabold">24 Tháng (2 Năm)</span>
                                <span class="text-[10px] opacity-80">Cam kết ổn định giá</span>
                            </button>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-300 mb-2">
                                Ngày bắt đầu dọn vào <span class="text-rose-500">*</span>
                            </label>
                            <input type="date" name="ngay_bat_dau" x-model="ngayBatDau" @change="updateNgayKetThuc()" required
                                class="w-full px-4 py-3 text-sm rounded-2xl border border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-900 focus:bg-white dark:focus:bg-slate-950 focus:ring-2 focus:ring-sky-500 font-medium">
                        </div>

                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-300 mb-2">
                                Ngày kết thúc hợp đồng <span class="text-rose-500">*</span>
                            </label>
                            <input type="date" name="ngay_ket_thuc" x-model="ngayKetThuc" required
                                class="w-full px-4 py-3 text-sm rounded-2xl border border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-900 focus:bg-white dark:focus:bg-slate-950 focus:ring-2 focus:ring-sky-500 font-medium">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-300 mb-2">
                                Tiền đặt cọc đề xuất (VNĐ) <span class="text-rose-500">*</span>
                            </label>
                            <div class="relative">
                                <input type="number" name="tien_coc" x-model="tienCoc" min="0" required
                                    class="w-full pl-4 pr-12 py-3 text-sm rounded-2xl border border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-900 focus:bg-white dark:focus:bg-slate-950 focus:ring-2 focus:ring-sky-500 font-bold text-sky-600">
                                <span class="absolute right-4 top-1/2 -translate-y-1/2 text-xs font-bold text-slate-400">VNĐ</span>
                            </div>
                            <p class="text-[11px] text-slate-400 mt-1">Khuyên nghị: Đặt cọc 1 tháng tiền phòng để giữ chỗ ưu tiên.</p>
                        </div>

                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-300 mb-2">
                                Số lượng người ở cùng
                            </label>
                            <select name="so_nguoi_o" class="w-full px-4 py-3 text-sm rounded-2xl border border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-900 focus:bg-white dark:focus:bg-slate-950 focus:ring-2 focus:ring-sky-500 font-medium">
                                <option value="1">1 người (Ở một mình)</option>
                                <option value="2" selected>2 người (Bạn cùng phòng / Cặp đôi)</option>
                                <option value="3">3 người (Nhóm bạn / Gia đình nhỏ)</option>
                                <option value="4">4 người trở lên</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-300 mb-2">
                            Lời nhắn & Ghi chú cho chủ trọ
                        </label>
                        <textarea name="ghi_chu" rows="3"
                            class="w-full px-4 py-3 text-sm rounded-2xl border border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-900 focus:bg-white dark:focus:bg-slate-950 focus:ring-2 focus:ring-sky-500 font-medium"
                            placeholder="VD: Em dự kiến mang 1 xe máy Honda, muốn dọn vào buổi sáng thứ Bảy, cần hỗ trợ đăng ký tạm trú sớm..."></textarea>
                    </div>
                </div>
            </div>

            {{-- 3. HỢP ĐỒNG ĐIỆN TỬ & TÀI LIỆU ĐÍNH KÈM --}}
            <div class="bg-white dark:bg-slate-800/90 rounded-3xl p-6 sm:p-7 border border-slate-200/80 dark:border-slate-700 shadow-sm space-y-5">
                <div class="flex items-center gap-3 border-b border-slate-100 dark:border-slate-700/60 pb-4">
                    <div class="w-10 h-10 rounded-2xl bg-emerald-50 dark:bg-emerald-950 text-emerald-600 dark:text-emerald-400 flex items-center justify-center text-xl font-bold">
                        <i class="ri-file-shield-line"></i>
                    </div>
                    <div>
                        <h3 class="text-base font-extrabold text-slate-800 dark:text-white">3. Hợp đồng điện tử & Tài liệu xác thực</h3>
                        <p class="text-xs text-slate-400">Xem mẫu hợp đồng hoặc tải tài liệu chứng minh nhân thân</p>
                    </div>
                </div>

                {{-- Sample contract card --}}
                <div class="bg-sky-50/60 dark:bg-sky-950/30 rounded-2xl p-4 sm:p-5 border border-sky-100 dark:border-sky-900/50 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div class="flex items-center gap-3.5">
                        <div class="w-11 h-11 rounded-2xl bg-sky-600 text-white flex items-center justify-center text-xl shadow-md shadow-sky-600/20 shrink-0">
                            <i class="ri-file-pdf-2-line"></i>
                        </div>
                        <div>
                            <h4 class="text-sm font-extrabold text-slate-900 dark:text-white">Hợp đồng thuê nhà mẫu số 2026</h4>
                            <p class="text-xs text-slate-500 dark:text-slate-400">Đã cập nhật các điều khoản bảo vệ người thuê theo Bộ Luật Dân Sự</p>
                        </div>
                    </div>
                    <a href="{{ asset('files/hopdong_mau.pdf') }}" target="_blank"
                        class="inline-flex items-center justify-center gap-1.5 px-4 py-2.5 rounded-xl bg-white dark:bg-slate-800 text-sky-600 dark:text-sky-300 border border-slate-200 dark:border-slate-700 text-xs font-bold hover:bg-sky-50 transition shadow-xs shrink-0">
                        <i class="ri-eye-line"></i> Xem mẫu hợp đồng
                    </a>
                </div>

                {{-- File upload box --}}
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-300 mb-2">
                        Tải lên hợp đồng đã ký sẵn hoặc tài liệu đính kèm (Tùy chọn)
                    </label>
                    <div class="border-2 border-dashed border-slate-200 dark:border-slate-700 rounded-2xl p-5 text-center hover:border-sky-400 dark:hover:border-sky-500 transition cursor-pointer relative bg-slate-50/30 dark:bg-slate-900/40">
                        <input type="file" name="file_hop_dong" accept=".pdf,image/*" @change="handleFileChange($event)"
                            class="absolute inset-0 opacity-0 cursor-pointer w-full h-full">
                        <div class="space-y-2">
                            <i class="ri-upload-cloud-2-line text-3xl text-sky-500 block"></i>
                            <p class="text-xs font-bold text-slate-700 dark:text-slate-200">
                                Kéo thả hoặc <span class="text-sky-600 underline">chọn tệp PDF / Ảnh</span>
                            </p>
                            <p class="text-[11px] text-slate-400">
                                Nếu chưa có file ký sẵn, hệ thống sẽ tự động dùng văn bản Hợp Đồng Mẫu Tiêu Chuẩn.
                            </p>
                            <p x-show="fileName" x-text="'📎 Đã chọn: ' + fileName" class="text-xs font-bold text-emerald-600 mt-2"></p>
                        </div>
                    </div>
                </div>

                {{-- Terms Checkbox --}}
                <div class="pt-3 border-t border-slate-100 dark:border-slate-700/60">
                    <label class="flex items-start gap-3 cursor-pointer">
                        <input type="checkbox" name="dong_y" x-model="agreeTerms" required
                            class="w-4 h-4 rounded text-sky-600 focus:ring-sky-500 mt-0.5">
                        <span class="text-xs text-slate-600 dark:text-slate-300 leading-relaxed">
                            Tôi cam kết các thông tin khai báo trên là chính xác. Tôi đã đọc, hiểu và đồng ý tuân thủ
                            <span class="font-bold text-sky-600">Nội quy phòng trọ</span> và
                            <span class="font-bold text-sky-600">Chính sách bảo vệ giao dịch tiền cọc</span> của nền tảng Smart Home.
                        </span>
                    </label>
                </div>
            </div>

            {{-- Submit Button (Mobile bottom) --}}
            <div class="lg:hidden">
                <button type="submit" :disabled="!agreeTerms"
                    class="w-full py-4 rounded-2xl bg-gradient-to-r from-sky-600 to-indigo-600 hover:from-sky-700 hover:to-indigo-700 text-white font-black text-sm shadow-xl shadow-sky-600/25 transition flex items-center justify-center gap-2">
                    <i class="ri-send-plane-fill text-lg"></i> Gửi Yêu Cầu Thuê & Giữ Chỗ Ngay
                </button>
            </div>
        </div>

        {{-- RIGHT COLUMN: STICKY ROOM SUMMARY --}}
        <div class="lg:col-span-4 sticky top-28 space-y-6">
            <div class="bg-white dark:bg-slate-800/90 rounded-3xl p-6 border border-slate-200/80 dark:border-slate-700 shadow-sm space-y-5">
                <h3 class="text-xs font-extrabold uppercase tracking-wider text-slate-400 border-b border-slate-100 dark:border-slate-700 pb-3">
                    Tóm tắt phòng đặt giữ chỗ
                </h3>

                {{-- Room Preview Card --}}
                <div class="flex items-start gap-3.5">
                    <img src="{{ $anhThumb }}" alt="Room thumbnail"
                        class="w-20 h-20 rounded-2xl object-cover shrink-0 border border-slate-200 dark:border-slate-700 shadow-xs">
                    <div class="min-w-0 flex-1">
                        <span class="inline-block px-2 py-0.5 rounded-full text-[10px] font-extrabold bg-sky-50 dark:bg-sky-950 text-sky-600 dark:text-sky-300 mb-1">
                            #PT-{{ $baiDangItem['id'] ?? 'MỚI' }}
                        </span>
                        <h4 class="text-sm font-black text-slate-900 dark:text-white line-clamp-2 leading-snug">
                            {{ $tieuDe }}
                        </h4>
                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-1 truncate">
                            <i class="ri-map-pin-2-line text-sky-500"></i> {{ $tenDayTro }}
                        </p>
                    </div>
                </div>

                {{-- Landlord Card --}}
                <div class="bg-slate-50 dark:bg-slate-900/60 rounded-2xl p-4 border border-slate-100 dark:border-slate-800 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-full bg-indigo-100 text-indigo-700 font-bold text-xs flex items-center justify-center">
                            {{ mb_substr($chuTroTen, 0, 1) }}
                        </div>
                        <div>
                            <p class="text-[11px] text-slate-400">Chủ nhà cho thuê</p>
                            <p class="text-xs font-extrabold text-slate-800 dark:text-slate-100">{{ $chuTroTen }}</p>
                        </div>
                    </div>
                    <a href="tel:{{ $chuTroSdt }}" class="w-8 h-8 rounded-xl bg-sky-50 text-sky-600 flex items-center justify-center text-sm hover:bg-sky-100 transition">
                        <i class="ri-phone-fill"></i>
                    </a>
                </div>

                {{-- Cost Breakdown --}}
                <div class="space-y-3 pt-3 border-t border-slate-100 dark:border-slate-700">
                    <div class="flex justify-between items-center text-xs">
                        <span class="text-slate-500 dark:text-slate-400">Giá thuê phòng/tháng:</span>
                        <span class="font-bold text-slate-800 dark:text-slate-100">
                            {{ number_format($giaNiemYet) }}₫
                        </span>
                    </div>

                    <div class="flex justify-between items-center text-xs">
                        <span class="text-slate-500 dark:text-slate-400">Tiền đặt cọc giữ chỗ:</span>
                        <span class="font-bold text-sky-600" x-text="Number(tienCoc).toLocaleString('vi-VN') + '₫'">
                            {{ number_format($tienCocDeXuat) }}₫
                        </span>
                    </div>

                    <div class="flex justify-between items-center text-xs">
                        <span class="text-slate-500 dark:text-slate-400">Phí dịch vụ nền tảng:</span>
                        <span class="font-extrabold text-emerald-600">0₫ (Miễn phí 100%)</span>
                    </div>

                    <div class="pt-3 border-t border-dashed border-slate-200 dark:border-slate-700 flex justify-between items-baseline">
                        <span class="text-xs font-bold text-slate-800 dark:text-slate-200">Dự kiến đợt đầu:</span>
                        <span class="text-lg font-black text-rose-600" x-text="(Number(tienCoc) + Number(giaThang)).toLocaleString('vi-VN') + '₫'">
                            {{ number_format($tienCocDeXuat + $giaNiemYet) }}₫
                        </span>
                    </div>
                </div>

                {{-- Guarantee badges --}}
                <div class="space-y-2 pt-2">
                    <div class="flex items-center gap-2 text-[11px] text-slate-500 dark:text-slate-400">
                        <i class="ri-shield-check-fill text-emerald-500 text-sm"></i>
                        <span>Tiền cọc chỉ chuyển cho chủ trọ sau khi bạn nhận phòng.</span>
                    </div>
                    <div class="flex items-center gap-2 text-[11px] text-slate-500 dark:text-slate-400">
                        <i class="ri-refresh-line text-sky-500 text-sm"></i>
                        <span>Hủy yêu cầu miễn phí nếu chủ trọ chưa duyệt.</span>
                    </div>
                </div>

                {{-- CTA Desktop --}}
                <button type="submit" :disabled="!agreeTerms"
                    class="w-full py-4 rounded-2xl bg-gradient-to-r from-sky-600 via-indigo-600 to-sky-600 hover:from-sky-700 hover:to-indigo-700 text-white font-black text-sm shadow-xl shadow-sky-600/25 transition flex items-center justify-center gap-2 cursor-pointer disabled:opacity-50">
                    <i class="ri-send-plane-fill text-lg"></i>
                    <span>Xác Nhận & Gửi Yêu Cầu Thuê</span>
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
