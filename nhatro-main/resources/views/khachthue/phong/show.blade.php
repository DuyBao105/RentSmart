@extends('layouts.tenant-layout')

@section('title', 'Chi tiết phòng đang thuê - Nền Tảng Trọ Thông Minh')
@section('page_title', 'Hồ sơ phòng trọ đang thuê')
@section('page_subtitle', 'Thông số kỹ thuật căn phòng, thiết bị bàn giao và thông tin liên hệ ban quản lý')

@section('tenant_content')
@php
    $baiDangList = collect($phong['bai_dang'] ?? []);
    $baiDangHienTai = $baiDangList->where('trang_thai', 'dang')->sortByDesc('ngay_cap_nhat')->first() ?? $baiDangList->first();

    $anhList = collect($baiDangHienTai['anh'] ?? [])->map(function($a) {
        $u = is_array($a) ? ($a['url'] ?? '') : (string)$a;
        if (!str_starts_with($u, 'http') && !str_starts_with($u, '/')) {
            return asset($u);
        }
        return $u;
    })->filter()->values()->toArray();

    if (empty($anhList)) {
        $anhList = [asset('upload/room1.jpg'), asset('upload/room2.jpg')];
    }

    $dayTro = $phong['day_tro'] ?? [];
    $chuTro = $dayTro['chu_tro'] ?? [];
    $chuTroTen = $chuTro['ho_ten'] ?? 'Chủ nhà thân thiện';
    $chuTroSdt = $chuTro['so_dien_thoai'] ?? '0909000000';
    $tieuDe = $baiDangHienTai['tieu_de'] ?? ('Phòng ' . ($phong['so_phong'] ?? ''));
    $moTa = $baiDangHienTai['mo_ta'] ?? 'Phòng trọ sạch sẽ, thoáng mát, an ninh đảm bảo 24/7.';
    $tienIch = $dayTro['tien_ich'] ?? 'Wifi tốc độ cao, Khóa vân tay, Camera an ninh, Chỗ để xe, Giờ giấc tự do';
    $tienIchArr = array_filter(array_map('trim', explode(',', $tienIch)));
@endphp

<div x-data="{
    activeImg: '{{ $anhList[0] }}',
    reportIssue() {
        Swal.fire({
            title: '🛠️ Báo hỏng thiết bị & Sự cố',
            html: `
                <div class='text-left space-y-3 text-xs'>
                    <p class='text-slate-500'>Vui lòng mô tả chi tiết sự cố tại phòng <strong>{{ $phong['so_phong'] ?? '' }}</strong> để ban quản lý xử lý kịp thời.</p>
                    <div>
                        <label class='font-bold block mb-1'>Loại sự cố:</label>
                        <select id='issueType' class='swal2-input' style='width:100%;margin:0;font-size:13px;'>
                            <option value='dien'>Hệ thống điện / Đèn / Ổ cắm</option>
                            <option value='nuoc'>Hệ thống nước / Rò rỉ / Vòi sen</option>
                            <option value='dieu_hoa'>Máy lạnh / Máy giặt / Nóng lạnh</option>
                            <option value='khoa_cua'>Khóa cửa / Khóa vân tay</option>
                            <option value='khac'>Khác</option>
                        </select>
                    </div>
                    <div>
                        <label class='font-bold block mb-1'>Mô tả chi tiết:</label>
                        <textarea id='issueDesc' class='swal2-textarea' style='width:100%;margin:0;font-size:13px;' rows='3' placeholder='Ví dụ: Máy lạnh bị chảy nước từ chiều hôm qua...'></textarea>
                    </div>
                </div>
            `,
            showCancelButton: true,
            confirmButtonText: 'Gửi yêu cầu sửa chữa',
            cancelButtonText: 'Hủy bỏ',
            confirmButtonColor: '#0284c7',
            preConfirm: () => {
                const desc = document.getElementById('issueDesc').value.trim();
                if (!desc) {
                    Swal.showValidationMessage('Vui lòng nhập mô tả sự cố.');
                    return false;
                }
                return desc;
            }
        }).then(result => {
            if (result.isConfirmed) {
                Swal.fire('Đã ghi nhận!', 'Yêu cầu bảo trì đã được chuyển tới chủ nhà. Kỹ thuật viên sẽ liên hệ trong 24h.', 'success');
            }
        });
    }
}" class="space-y-8">

    {{-- Breadcrumb & Back --}}
    <div class="flex items-center justify-between text-xs font-semibold">
        <div class="flex items-center gap-2 text-slate-400">
            <a href="{{ route('khach-thue.dashboard') }}" class="hover:text-sky-600 transition">Dashboard</a>
            <i class="ri-arrow-right-s-line"></i>
            <a href="{{ route('khach-thue.phong.index') }}" class="hover:text-sky-600 transition">Phòng trọ</a>
            <i class="ri-arrow-right-s-line"></i>
            <span class="text-slate-700 dark:text-slate-200">Phòng {{ $phong['so_phong'] ?? '' }}</span>
        </div>

        <a href="{{ route('khach-thue.phong.index') }}"
            class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-xl bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 text-slate-700 dark:text-slate-200 text-xs font-bold transition">
            <i class="ri-arrow-left-line"></i> Quay lại danh sách
        </a>
    </div>

    {{-- TOP BANNER CARD --}}
    <div class="bg-white dark:bg-slate-800/90 rounded-3xl p-6 sm:p-8 border border-slate-200/80 dark:border-slate-700 shadow-sm space-y-6">
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 border-b border-slate-100 dark:border-slate-700/60 pb-6">
            <div>
                <div class="flex items-center gap-2 mb-2">
                    <span class="px-3 py-1 rounded-full text-xs font-black bg-emerald-100 text-emerald-800">
                        Phòng đang thuê • Mã #P-{{ $phong['so_phong'] ?? $phong['id'] }}
                    </span>
                    <span class="px-3 py-1 rounded-full text-xs font-bold bg-sky-100 text-sky-800">
                        Dãy {{ $dayTro['ten_day_tro'] ?? 'Trọ' }}
                    </span>
                </div>
                <h2 class="text-2xl sm:text-3xl font-black text-slate-900 dark:text-white tracking-tight">
                    {{ $tieuDe }}
                </h2>
                <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 mt-1 flex items-center gap-1.5">
                    <i class="ri-map-pin-2-line text-sky-500"></i>
                    <span>{{ $dayTro['dia_chi'] ?? 'TP. Hồ Chí Minh' }}</span>
                </p>
            </div>

            <div class="flex flex-wrap items-center gap-3">
                <button type="button" @click="reportIssue()"
                    class="px-4 py-2.5 rounded-2xl bg-amber-500 hover:bg-amber-600 text-slate-950 font-extrabold text-xs shadow-md shadow-amber-500/20 transition flex items-center gap-2">
                    <i class="ri-tools-line text-base"></i> Báo hỏng thiết bị
                </button>
                <a href="{{ route('khach-thue.hoa-don.index') }}"
                    class="px-4 py-2.5 rounded-2xl bg-sky-600 hover:bg-sky-700 text-white font-extrabold text-xs shadow-md shadow-sky-600/20 transition flex items-center gap-2">
                    <i class="ri-bill-line text-base"></i> Xem hóa đơn phòng
                </a>
            </div>
        </div>

        {{-- PHOTO GALLERY --}}
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-4">
            <div class="lg:col-span-8 rounded-2xl overflow-hidden bg-slate-100 dark:bg-slate-900 h-72 sm:h-96 relative border border-slate-200 dark:border-slate-700">
                <img :src="activeImg" alt="Room preview" class="w-full h-full object-cover">
            </div>
            <div class="lg:col-span-4 flex lg:flex-col gap-3 overflow-x-auto lg:overflow-y-auto max-h-96 scrollbar-none">
                @foreach($anhList as $img)
                    <button type="button" @click="activeImg = '{{ $img }}'"
                        :class="activeImg === '{{ $img }}' ? 'ring-2 ring-sky-500' : 'opacity-70 hover:opacity-100'"
                        class="w-24 h-24 lg:w-full lg:h-28 rounded-2xl overflow-hidden shrink-0 border border-slate-200 dark:border-slate-700 transition">
                        <img src="{{ $img }}" alt="Gallery thumbnail" class="w-full h-full object-cover">
                    </button>
                @endforeach
            </div>
        </div>

        {{-- SPECS GRID --}}
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 p-5 rounded-2xl bg-slate-50 dark:bg-slate-900/60 border border-slate-100 dark:border-slate-800 text-xs">
            <div>
                <span class="text-slate-400 block mb-1">Giá thuê hàng tháng</span>
                <span class="text-base font-black text-sky-600">{{ number_format($phong['gia'] ?? 0) }}₫</span>
            </div>
            <div>
                <span class="text-slate-400 block mb-1">Diện tích sử dụng</span>
                <span class="text-base font-extrabold text-slate-800 dark:text-slate-100">{{ $phong['dien_tich'] ?? '--' }} m²</span>
            </div>
            <div>
                <span class="text-slate-400 block mb-1">Vị trí tầng</span>
                <span class="text-base font-extrabold text-slate-800 dark:text-slate-100">Tầng {{ $phong['tang'] ?? '1' }}</span>
            </div>
            <div>
                <span class="text-slate-400 block mb-1">Sức chứa tối đa</span>
                <span class="text-base font-extrabold text-slate-800 dark:text-slate-100">{{ $phong['suc_chua'] ?? '2' }} người</span>
            </div>
        </div>

        {{-- AMENITIES CHECKLIST --}}
        <div class="space-y-3 pt-2">
            <h3 class="text-sm font-black uppercase tracking-wider text-slate-400">Tiện nghi & Dịch vụ đi kèm</h3>
            <div class="flex flex-wrap gap-2.5">
                @forelse($tienIchArr as $ti)
                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-sky-50 dark:bg-sky-950 text-sky-700 dark:text-sky-300 border border-sky-200/50 text-xs font-bold">
                        <i class="ri-checkbox-circle-fill text-sky-500"></i> {{ $ti }}
                    </span>
                @empty
                    <span class="text-xs text-slate-400">Chưa có thông tin tiện ích chi tiết.</span>
                @endforelse
            </div>
        </div>

        {{-- DESCRIPTION --}}
        <div class="space-y-2 pt-2 border-t border-slate-100 dark:border-slate-700/60">
            <h3 class="text-sm font-black uppercase tracking-wider text-slate-400">Mô tả căn phòng</h3>
            <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-300 leading-relaxed whitespace-pre-line">
                {{ $moTa }}
            </p>
        </div>

        {{-- LANDLORD & MANAGEMENT CONTACT CARD --}}
        <div class="bg-gradient-to-r from-slate-50 to-sky-50/50 dark:from-slate-900 dark:to-slate-900/60 rounded-2xl p-5 border border-slate-200/80 dark:border-slate-800 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="flex items-center gap-3.5">
                <div class="w-12 h-12 rounded-2xl bg-sky-600 text-white font-extrabold text-lg flex items-center justify-center shadow-md shadow-sky-600/20 shrink-0">
                    {{ mb_substr($chuTroTen, 0, 1) }}
                </div>
                <div>
                    <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400">Chủ nhà & Ban quản lý</span>
                    <h4 class="text-sm font-black text-slate-900 dark:text-white">{{ $chuTroTen }}</h4>
                    <p class="text-xs text-slate-500 dark:text-slate-400">Hotline: {{ $chuTroSdt }}</p>
                </div>
            </div>

            <div class="flex items-center gap-2">
                <a href="tel:{{ $chuTroSdt }}"
                    class="px-4 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-extrabold shadow-sm transition flex items-center gap-1.5">
                    <i class="ri-phone-fill"></i> Gọi điện
                </a>
                <a href="https://zalo.me/{{ $chuTroSdt }}" target="_blank"
                    class="px-4 py-2 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-extrabold shadow-sm transition flex items-center gap-1.5">
                    <i class="ri-chat-smile-2-fill"></i> Nhắn Zalo
                </a>
            </div>
        </div>
    </div>

</div>
@endsection
