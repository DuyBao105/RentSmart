@extends('layouts.tenant-layout')

@section('title', 'Hóa đơn tiền phòng — Khách thuê')
@section('page_title', 'Hóa đơn tiền phòng & Dịch vụ')
@section('page_subtitle', 'Bóc tách chi tiết tiền phòng, chỉ số điện nước và thanh toán nhanh chóng qua mã chuẩn VietQR')

@section('tenant_content')
@php
    $hdCollection = collect($hoaDon ?? []);
    $unpaidList = $hdCollection->where('trang_thai', 'chua_thanh_toan');
    $unpaidTotal = $unpaidList->sum('tong_tien');
    $paidList = $hdCollection->where('trang_thai', 'da_thanh_toan');
    $paidTotal = $paidList->sum('tong_tien');
@endphp

<div x-data="{
    activeFilter: 'all',
    qrModalOpen: false,
    qrData: {
        id: '',
        thang: '',
        tong_tien: 0,
        chu_tro_ten: '',
        bank_code: 'MB',
        account_no: '0000000000',
        account_name: ''
    },

    openQR(id, thang, tongTien, chuTroTen, bankCode, accountNo) {
        this.qrData = {
            id: id || '',
            thang: thang || '',
            tong_tien: tongTien || 0,
            chu_tro_ten: chuTroTen || 'CHU NHA',
            bank_code: bankCode || 'MB',
            account_no: accountNo || '0888999888',
            account_name: (chuTroTen || 'CHU NHA').toUpperCase()
        };
        this.qrModalOpen = true;
    },

    async confirmPayment() {
        const id = this.qrData.id;
        const thang = this.qrData.thang;
        const tongTien = this.qrData.tong_tien;

        const confirmRes = await Swal.fire({
            title: 'Xác nhận chuyển khoản?',
            text: `Bạn đã chuyển khoản thành công số tiền ${Number(tongTien).toLocaleString('vi-VN')}₫ cho hóa đơn Tháng ${thang}?`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Đúng, tôi đã chuyển khoản',
            cancelButtonText: 'Kiểm tra lại',
            confirmButtonColor: '#16a34a',
            cancelButtonColor: '#64748b'
        });

        if (!confirmRes.isConfirmed) return;

        this.qrModalOpen = false;

        Swal.fire({
            title: 'Đang gửi xác nhận...',
            text: 'Hệ thống đang đối soát và tạo biên lai giao dịch',
            allowOutsideClick: false,
            didOpen: () => Swal.showLoading()
        });

        try {
            const token = localStorage.getItem('token') || localStorage.getItem('api_token') || '{{ session('api_token') }}' || (document.cookie.match(/(^|;)\s*api_token\s*=\s*([^;]+)/)?.[2] || '');
            const apiBase = '{{ rtrim(env('API_URL', 'http://127.0.0.1:8000/api'), '/') }}';

            const res = await fetch(`${apiBase}/khach-thue/hoa-don/${id}/xac-nhan-thanh-toan`, {
                method: 'POST',
                headers: {
                    'Authorization': 'Bearer ' + token,
                    'Accept': 'application/json'
                }
            });

            const data = await res.json();

            if (res.ok && data.success) {
                const d = data.data || {};
                const maGD = d.ma_giao_dich || ('GD' + Math.random().toString(36).substr(2, 8).toUpperCase());
                const soTien = Number(d.so_tien || tongTien).toLocaleString('vi-VN') + ' ₫';
                const ngayTT = d.ngay_thanh_toan || new Date().toLocaleString('vi-VN');

                await Swal.fire({
                    icon: 'success',
                    title: '<span style="color:#059669; font-weight:800; font-size: 1.25rem;">THANH TOÁN THÀNH CÔNG!</span>',
                    html: `
                        <p style="font-size: 0.875rem; color:#475569; margin-bottom: 12px;">
                            Giao dịch chuyển khoản của bạn đã được ghi nhận và xác nhận thành công!
                        </p>
                        <div style="text-align: left; background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 16px; padding: 14px 16px; font-size: 0.8125rem; line-height: 1.6; color: #1e293b;">
                            <div style="display: flex; justify-content: space-between; padding-bottom: 8px; border-bottom: 1px dashed #cbd5e1; margin-bottom: 8px;">
                                <span style="color: #64748b;">Trạng thái:</span>
                                <span style="background: #dcfce7; color: #15803d; font-weight: 700; padding: 2px 8px; border-radius: 9999px; font-size: 0.75rem;">ĐÃ THANH TOÁN</span>
                            </div>
                            <div style="display: flex; justify-content: space-between; margin-bottom: 6px;">
                                <span style="color: #64748b;">Mã giao dịch:</span>
                                <span style="font-family: monospace; font-weight: 700; color: #047857; background: #fff; padding: 2px 6px; border-radius: 4px; border: 1px solid #e2e8f0;">${maGD}</span>
                            </div>
                            <div style="display: flex; justify-content: space-between; margin-bottom: 6px;">
                                <span style="color: #64748b;">Số tiền:</span>
                                <span style="font-weight: 800; color: #e11d48; font-size: 0.95rem;">${soTien}</span>
                            </div>
                            <div style="display: flex; justify-content: space-between; margin-bottom: 6px;">
                                <span style="color: #64748b;">Phương thức:</span>
                                <span style="font-weight: 600;">Chuyển khoản VietQR</span>
                            </div>
                            <div style="display: flex; justify-content: space-between; margin-bottom: 6px;">
                                <span style="color: #64748b;">Kỳ hóa đơn:</span>
                                <span style="font-weight: 600;">Tháng ${thang}</span>
                            </div>
                            <div style="display: flex; justify-content: space-between;">
                                <span style="color: #64748b;">Thời gian:</span>
                                <span style="font-weight: 600;">${ngayTT}</span>
                            </div>
                        </div>
                        <p style="font-size: 0.75rem; color:#94a3b8; margin-top: 12px; margin-bottom: 0;">
                            Biên nhận đã được lưu vào hệ thống và gửi thông báo đến chủ trọ.
                        </p>
                    `,
                    confirmButtonText: 'Hoàn tất & Cập nhật danh sách',
                    confirmButtonColor: '#059669',
                    width: '440px'
                });
                window.location.reload();
            } else {
                Swal.fire({
                    icon: 'warning',
                    title: 'Lưu ý',
                    text: data?.message || 'Không thể xác nhận thanh toán lúc này.',
                    confirmButtonColor: '#f59e0b'
                });
            }
        } catch (err) {
            Swal.fire({
                icon: 'error',
                title: 'Lỗi',
                text: 'Không thể kết nối đến máy chủ: ' + err.message
            });
        }
    }
}" class="space-y-6">

    {{-- TOP ACTION & KPI SUMMARY --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-2 border-b border-[#E5E3DC] dark:border-[#282D2A]">
        <div>
            <h2 class="text-xl sm:text-2xl font-serif font-bold text-[#171A19] dark:text-white tracking-tight">
                Quản Lý Thu Chi Tiền Trọ
            </h2>
            <p class="text-xs sm:text-sm text-[#5A605B] dark:text-[#9EA39E] mt-1 font-sans">
                Theo dõi các khoản tiền phòng định kỳ, hạn chót thanh toán và lưu trữ biên lai điện tử.
            </p>
        </div>

        <button type="button" @click="activeFilter = 'chua_thanh_toan'"
            class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-amber-500 hover:bg-amber-600 text-slate-950 text-xs sm:text-sm font-semibold shadow-xs transition shrink-0">
            <i class="ri-alarm-warning-line text-base"></i>
            <span>Hóa đơn cần thanh toán ({{ $unpaidList->count() }})</span>
        </button>
    </div>

    {{-- STATS GRID --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
        <div class="bg-white dark:bg-[#1E2320] rounded-2xl p-5 border border-amber-200/80 dark:border-amber-900/40 shadow-sm flex items-center justify-between">
            <div>
                <span class="text-[11px] font-bold uppercase tracking-wider text-amber-700 dark:text-amber-400 block mb-1">Cần thanh toán</span>
                <p class="text-2xl sm:text-3xl font-serif font-bold text-amber-600 dark:text-amber-400">
                    {{ number_format($unpaidTotal) }} đ
                </p>
                <p class="text-[11px] text-[#5A605B] dark:text-[#9EA39E] mt-1">{{ $unpaidList->count() }} hóa đơn chưa hoàn tất</p>
            </div>
            <div class="w-11 h-11 rounded-xl bg-amber-50 dark:bg-amber-950/60 text-amber-600 dark:text-amber-400 flex items-center justify-center text-xl">
                <i class="ri-bill-line"></i>
            </div>
        </div>

        <div class="bg-white dark:bg-[#1E2320] rounded-2xl p-5 border border-emerald-200/80 dark:border-emerald-900/40 shadow-sm flex items-center justify-between">
            <div>
                <span class="text-[11px] font-bold uppercase tracking-wider text-emerald-700 dark:text-emerald-400 block mb-1">Đã thanh toán</span>
                <p class="text-2xl sm:text-3xl font-serif font-bold text-emerald-700 dark:text-emerald-400">
                    {{ number_format($paidTotal) }} đ
                </p>
                <p class="text-[11px] text-[#5A605B] dark:text-[#9EA39E] mt-1">{{ $paidList->count() }} hóa đơn hoàn tất</p>
            </div>
            <div class="w-11 h-11 rounded-xl bg-emerald-50 dark:bg-emerald-950/60 text-emerald-700 dark:text-emerald-400 flex items-center justify-center text-xl">
                <i class="ri-checkbox-circle-line"></i>
            </div>
        </div>

        <div class="bg-white dark:bg-[#1E2320] rounded-2xl p-5 border border-[#E5E3DC] dark:border-[#2D332F] shadow-sm flex items-center justify-between">
            <div>
                <span class="text-[11px] font-bold uppercase tracking-wider text-[#5A605B] dark:text-[#9EA39E] block mb-1">Tổng kỳ cước</span>
                <p class="text-2xl sm:text-3xl font-serif font-bold text-[#171A19] dark:text-white">{{ $hdCollection->count() }}</p>
                <p class="text-[11px] text-[#5A605B] dark:text-[#9EA39E] mt-1">Lịch sử thu phí từ khi vào ở</p>
            </div>
            <div class="w-11 h-11 rounded-xl bg-[#FAF9F6] dark:bg-[#282D2A] border border-[#E5E3DC] dark:border-[#343B36] text-[#171A19] dark:text-white flex items-center justify-center text-xl">
                <i class="ri-calendar-check-line"></i>
            </div>
        </div>
    </div>

    {{-- FILTER DROPDOWN --}}
    <div class="bg-white dark:bg-[#1E2320] rounded-2xl p-3 border border-[#E5E3DC] dark:border-[#2D332F] shadow-2xs flex items-center justify-between">
        <div class="flex items-center gap-2.5">
            <label class="text-xs font-semibold text-[#5A605B] dark:text-[#9EA39E] whitespace-nowrap flex items-center gap-1.5">
                <i class="ri-filter-3-line"></i> Lọc hóa đơn:
            </label>
            <div class="relative min-w-[210px]">
                <select x-model="activeFilter"
                    class="w-full appearance-none py-2 pl-3.5 pr-8 text-xs font-medium rounded-xl border border-[#E5E3DC] dark:border-[#343B36] bg-[#FAF9F6] dark:bg-[#282D2A] text-[#171A19] dark:text-white focus:outline-none focus:ring-1 focus:ring-[#1B3D2F] cursor-pointer transition">
                    <option value="all">Tất cả hóa đơn ({{ $hdCollection->count() }})</option>
                    <option value="chua_thanh_toan">Chưa thanh toán ({{ $unpaidList->count() }})</option>
                    <option value="da_thanh_toan">Đã thanh toán ({{ $paidList->count() }})</option>
                </select>
                <i class="ri-arrow-down-s-line absolute right-2.5 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none text-sm"></i>
            </div>
        </div>
    </div>

    {{-- INVOICES GRID --}}
    @if($hdCollection->isEmpty())
        <div class="bg-white dark:bg-[#1E2320] rounded-3xl p-12 border border-dashed border-[#E5E3DC] dark:border-[#2D332F] text-center space-y-4">
            <div class="w-16 h-16 rounded-2xl bg-[#1B3D2F]/10 dark:bg-[#244B3B]/40 text-[#1B3D2F] dark:text-[#A3E635] flex items-center justify-center text-3xl mx-auto">
                <i class="ri-bill-line"></i>
            </div>
            <div class="space-y-1">
                <h3 class="text-base font-serif font-bold text-[#171A19] dark:text-white">Hiện bạn chưa có hóa đơn nào</h3>
                <p class="text-xs sm:text-sm text-[#5A605B] dark:text-[#9EA39E] max-w-md mx-auto">
                    Hóa đơn tiền phòng và dịch vụ sẽ được chủ nhà phát hành tự động vào kỳ thu phí hàng tháng.
                </p>
            </div>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($hdCollection as $hd)
                @php
                    $isPaid = ($hd['trang_thai'] ?? '') === 'da_thanh_toan';
                    $hopDong = $hd['hop_dong'] ?? [];
                    $phong = $hopDong['phong'] ?? $hd['phong'] ?? [];
                    $dayTro = $phong['day_tro'] ?? $hd['day_tro'] ?? [];
                    $isOverdue = !empty($hd['qua_han']) && $hd['qua_han'] === true;

                    $thangRaw = (string)($hd['thang'] ?? '');
                    if (preg_match('/^(\d{4})-(\d{1,2})$/', $thangRaw, $m)) {
                        $thangDisplay = 'Tháng ' . (int)$m[2] . '/' . $m[1];
                    } elseif (preg_match('/^(\d{1,2})\/(\d{4})$/', $thangRaw)) {
                        $thangDisplay = 'Tháng ' . $thangRaw;
                    } elseif (!empty($thangRaw)) {
                        $thangDisplay = 'Tháng ' . $thangRaw;
                    } else {
                        $thangDisplay = 'Kỳ gần nhất';
                    }
                @endphp

                <div x-show="activeFilter === 'all' || activeFilter === '{{ $hd['trang_thai'] ?? '' }}'"
                    class="bg-white dark:bg-[#1E2320] rounded-2xl border border-[#E5E3DC] dark:border-[#2D332F] shadow-sm hover:border-[#1B3D2F]/30 transition p-5 flex flex-col justify-between gap-4 relative overflow-hidden">
                    @if($isOverdue && !$isPaid)
                        <div class="absolute top-0 right-0 bg-rose-600 text-white text-[9px] font-bold uppercase px-2.5 py-0.5 rounded-bl-xl tracking-wider shadow-xs">
                            Quá hạn
                        </div>
                    @endif

                    <div class="space-y-3.5">
                        {{-- Top Header: Icon, Month Title, Status Pill --}}
                        <div class="flex items-center justify-between gap-2 border-b border-[#E5E3DC] dark:border-[#282D2A] pb-3">
                            <div class="flex items-center gap-2.5">
                                <div class="w-10 h-10 rounded-xl {{ $isPaid ? 'bg-emerald-50 text-emerald-700 dark:bg-emerald-950/60' : 'bg-amber-50 text-amber-700 dark:bg-amber-950/60' }} flex items-center justify-center text-lg font-bold shrink-0">
                                    <i class="{{ $isPaid ? 'ri-checkbox-circle-fill' : 'ri-time-fill' }}"></i>
                                </div>
                                <div>
                                    <h3 class="text-sm font-serif font-bold text-[#171A19] dark:text-white leading-tight">
                                        {{ $thangDisplay }}
                                    </h3>
                                    <p class="text-[11px] font-mono font-bold text-[#A6824D] mt-0.5">#HĐ-{{ $hd['id'] ?? '0' }}</p>
                                </div>
                            </div>

                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-semibold shrink-0 whitespace-nowrap {{ $isPaid ? 'bg-emerald-50 text-emerald-800 dark:bg-emerald-950/70 dark:text-emerald-300 border border-emerald-200/60' : 'bg-amber-50 text-amber-800 dark:bg-amber-950/70 dark:text-amber-300 border border-amber-200/60' }}">
                                <span class="w-1.5 h-1.5 rounded-full {{ $isPaid ? 'bg-emerald-500' : 'bg-amber-500' }}"></span>
                                <span>{{ $isPaid ? 'Đã thanh toán' : 'Chưa thanh toán' }}</span>
                            </span>
                        </div>

                        {{-- Room & Location --}}
                        <div class="space-y-0.5">
                            <p class="text-xs font-serif font-bold text-[#171A19] dark:text-white truncate">
                                Phòng {{ $phong['so_phong'] ?? 'Phòng trọ' }} • {{ $dayTro['ten_day_tro'] ?? 'Khu trọ' }}
                            </p>
                            <p class="text-[11px] text-[#5A605B] dark:text-[#9EA39E] truncate flex items-center gap-1">
                                <i class="ri-map-pin-line text-[#A6824D] shrink-0"></i>
                                <span>{{ $dayTro['dia_chi'] ?? 'TP. Hồ Chí Minh' }}</span>
                            </p>
                        </div>

                        {{-- Dark/Slate Summary Box --}}
                        <div class="p-3.5 rounded-xl bg-[#FAF9F6] dark:bg-[#282D2A]/60 border border-[#E5E3DC] dark:border-[#343B36] space-y-2">
                            <div class="flex items-center justify-between">
                                <span class="text-xs text-[#5A605B] dark:text-[#9EA39E]">Tổng tiền thanh toán:</span>
                                <span class="text-lg font-serif font-bold text-[#171A19] dark:text-white tracking-tight">
                                    {{ number_format($hd['tong_tien'] ?? 0) }} đ
                                </span>
                            </div>

                            <div class="flex items-center justify-between text-[11px] pt-2 border-t border-[#E5E3DC] dark:border-[#343B36]">
                                <span class="text-[#5A605B] dark:text-[#9EA39E]">Hạn thanh toán:</span>
                                <span class="font-semibold {{ $isOverdue && !$isPaid ? 'text-rose-600' : 'text-[#171A19] dark:text-white' }}">
                                    {{ !empty($hd['han_thanh_toan']) ? \Carbon\Carbon::parse($hd['han_thanh_toan'])->format('d/m/Y') : '--' }}
                                </span>
                            </div>
                        </div>
                    </div>

                    {{-- Bottom Action Buttons --}}
                    <div class="pt-3 border-t border-[#E5E3DC] dark:border-[#282D2A] grid {{ $isPaid ? 'grid-cols-1' : 'grid-cols-2' }} gap-2">
                        @if(!$isPaid)
                            <button type="button"
                                @click="openQR({{ $hd['id'] ?? 0 }}, '{{ $thangDisplay }}', {{ $hd['tong_tien'] ?? 0 }}, '{{ addslashes($chuTro['ho_ten'] ?? 'Chủ nhà') }}', '{{ $chuTro['bank_code'] ?? 'MB' }}', '{{ $chuTro['account_no'] ?? '0888999888' }}')"
                                class="w-full py-2 px-3 rounded-xl bg-[#1B3D2F] hover:bg-[#244B3B] text-white font-medium text-xs transition flex items-center justify-center gap-1.5 shadow-xs">
                                <i class="ri-qr-code-line text-sm"></i>
                                <span>Quét VietQR</span>
                            </button>
                        @endif

                        <a href="{{ route('khach-thue.hoa-don.show', $hd['id']) }}"
                            class="w-full py-2 px-3 rounded-xl border border-[#E5E3DC] dark:border-[#2D332F] bg-[#FAF9F6] dark:bg-[#282D2A] hover:bg-white text-[#171A19] dark:text-white font-medium text-xs transition flex items-center justify-center gap-1">
                            <span>Chi tiết hóa đơn</span>
                            <i class="ri-arrow-right-line"></i>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    {{-- QUICK VIETQR POPUP MODAL --}}
    <div x-show="qrModalOpen" style="display: none;"
        class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-xs"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0">

        <div @click.away="qrModalOpen = false"
            class="bg-white dark:bg-[#1E2320] rounded-3xl max-w-md w-full p-6 border border-[#E5E3DC] dark:border-[#2D332F] shadow-2xl relative text-center space-y-4">

            <button type="button" @click="qrModalOpen = false"
                class="absolute top-4 right-4 w-8 h-8 rounded-full bg-[#FAF9F6] dark:bg-[#282D2A] border border-[#E5E3DC] dark:border-[#343B36] text-[#5A605B] hover:text-[#171A19] dark:hover:text-white flex items-center justify-center transition">
                <i class="ri-close-line text-base"></i>
            </button>

            <div>
                <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold bg-emerald-50 dark:bg-emerald-950/40 text-emerald-800 dark:text-emerald-300 uppercase tracking-wider mb-2">
                    Thanh Toán Tự Động 24/7
                </span>
                <h3 class="text-lg font-serif font-bold text-[#171A19] dark:text-white">
                    Quét Mã VietQR Chuyển Khoản
                </h3>
                <p class="text-xs text-[#5A605B] dark:text-[#9EA39E] mt-1" x-text="'Hóa đơn Tháng ' + qrData.thang + ' • ' + Number(qrData.tong_tien).toLocaleString('vi-VN') + ' đ'"></p>
            </div>

            {{-- QR Code Image Container --}}
            <div class="p-3 bg-white rounded-2xl border border-[#E5E3DC] shadow-inner max-w-[260px] mx-auto">
                <img :src="`https://img.vietqr.io/image/${qrData.bank_code}-${qrData.account_no}-compact2.png?amount=${qrData.tong_tien}&addInfo=Thanh+toan+hoa+don+thang+${qrData.thang}&accountName=${encodeURIComponent(qrData.account_name)}`"
                    alt="VietQR Code" class="w-full h-auto rounded-xl">
            </div>

            <div class="text-xs text-[#5A605B] dark:text-[#9EA39E] space-y-1">
                <p>Chủ tài khoản: <strong class="text-[#171A19] dark:text-white" x-text="qrData.account_name"></strong></p>
                <p>Nội dung chuyển: <strong class="text-[#1B3D2F] dark:text-[#A3E635]" x-text="'Thanh toan hoa don thang ' + qrData.thang"></strong></p>
            </div>

            <div class="pt-2 flex items-center justify-center gap-3">
                <button type="button" @click="confirmPayment()"
                    class="px-5 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold text-xs shadow-md shadow-emerald-600/20 transition flex items-center justify-center gap-1.5 cursor-pointer">
                    <i class="ri-check-line text-sm"></i>
                    <span>Tôi đã chuyển khoản xong</span>
                </button>
            </div>
        </div>
    </div>

</div>
@endsection
