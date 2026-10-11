@extends('layouts.tenant-layout')

@section('title', 'Chi tiết hóa đơn - Nền Tảng Trọ Thông Minh')
@section('page_title', 'Chi tiết hóa đơn tiền phòng')
@section('page_subtitle', 'Biên lai điện tử bóc tách chi tiết từng hạng mục chi phí và hướng dẫn thanh toán')

@section('tenant_content')
@php
    $hd = $chiTiet ?? [];
    $isPaid = ($hd['trang_thai'] ?? '') === 'da_thanh_toan';
    $chuTro = $hd['chu_tro'] ?? [];
    $phong = $hd['phong'] ?? [];
    $dayTro = $hd['day_tro'] ?? [];

    $dichVuList = $hd['chi_tiet_dich_vu'] ?? [];
    $dienNuocList = $hd['chi_tiet_dien_nuoc'] ?? [];

    $bank = [
        'bank_code' => $chuTro['bank_code'] ?? 'MB',
        'account_no' => $chuTro['account_no'] ?? '0888999888',
        'account_name' => strtoupper($chuTro['account_name'] ?? $chuTro['ho_ten'] ?? 'CHU NHA TRO'),
        'amount' => $hd['tong_tien'] ?? 0,
        'description' => "Thanh toan hoa don thang " . ($hd['thang'] ?? '1')
    ];

    $qrUrl = "https://img.vietqr.io/image/{$bank['bank_code']}-{$bank['account_no']}-compact2.png?amount={$bank['amount']}&addInfo=" . urlencode($bank['description']) . "&accountName=" . urlencode($bank['account_name']);
@endphp

<div class="space-y-8">

    {{-- TOP BAR --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div class="flex items-center gap-2 text-xs font-semibold text-slate-400">
            <a href="{{ route('khach-thue.dashboard') }}" class="hover:text-sky-600 transition">Dashboard</a>
            <i class="ri-arrow-right-s-line"></i>
            <a href="{{ route('khach-thue.hoa-don.index') }}" class="hover:text-sky-600 transition">Hóa đơn</a>
            <i class="ri-arrow-right-s-line"></i>
            <span class="text-slate-700 dark:text-slate-200">Tháng {{ $hd['thang'] ?? '--' }}</span>
        </div>

        <div class="flex items-center gap-3">
            <a href="{{ route('khach-thue.hoa-don.index') }}"
                class="px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 text-slate-700 dark:text-slate-200 text-xs font-bold transition flex items-center gap-1.5">
                <i class="ri-arrow-left-line"></i> Danh sách hóa đơn
            </a>
            <button type="button" onclick="window.print()"
                class="px-4 py-2 rounded-xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-700 dark:text-slate-200 text-xs font-bold shadow-xs hover:bg-slate-50 transition flex items-center gap-1.5">
                <i class="ri-printer-line"></i> In biên lai
            </button>
        </div>
    </div>

    {{-- MAIN BILLING CARD --}}
    <div class="bg-white dark:bg-slate-800/90 rounded-3xl p-6 sm:p-10 border border-slate-200/80 dark:border-slate-700 shadow-xl space-y-8">

        {{-- Voucher Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-slate-100 dark:border-slate-700 pb-6">
            <div class="space-y-1">
                <span class="text-xs font-bold uppercase tracking-wider text-slate-400">PHIẾU THU TIỀN PHÒNG ĐIỆN TỬ</span>
                <h2 class="text-2xl sm:text-3xl font-black text-slate-900 dark:text-white tracking-tight">
                    Hóa Đơn Tháng {{ $hd['thang'] ?? '--' }}
                </h2>
                <p class="text-xs text-sky-600 font-bold">
                    Mã tra cứu: #HĐ-{{ $hd['id'] ?? '0' }} • Phòng {{ $phong['so_phong'] ?? '—' }} ({{ $dayTro['ten_day_tro'] ?? 'Khu trọ' }})
                </p>
            </div>

                <span class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full text-xs font-extrabold shadow-xs {{ $isPaid ? 'bg-emerald-100 text-emerald-800 dark:bg-emerald-950/40 dark:text-emerald-300' : 'bg-amber-100 text-amber-800 dark:bg-amber-950/40 dark:text-amber-300' }}">
                    <i class="{{ $isPaid ? 'ri-checkbox-circle-fill text-sm' : 'ri-time-line text-sm' }}"></i>
                    {{ $isPaid ? 'ĐÃ THANH TOÁN' : 'CHƯA THANH TOÁN' }}
                </span>
                <p class="text-xs text-slate-400 mt-1.5">
                    Hạn nộp: <strong class="text-slate-700 dark:text-slate-200">{{ !empty($hd['han_thanh_toan']) ? \Carbon\Carbon::parse($hd['han_thanh_toan'])->format('d/m/Y') : '--' }}</strong>
                </p>
            </div>
        </div>

        {{-- Parties Specs Info --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 p-5 rounded-2xl bg-slate-50 dark:bg-slate-900/60 border border-slate-100 dark:border-slate-800 text-xs">
            <div class="space-y-1.5">
                <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400 block mb-1">Căn hộ & Dãy trọ:</span>
                <p><strong>Số phòng:</strong> Phòng {{ $phong['so_phong'] ?? '—' }}</p>
                <p><strong>Dãy trọ:</strong> {{ $dayTro['ten_day_tro'] ?? 'Khu trọ' }}</p>
                <p><strong>Địa chỉ:</strong> {{ $dayTro['dia_chi'] ?? 'TP. Hồ Chí Minh' }}</p>
                <p><strong>Tiền phòng cơ bản:</strong> <span class="font-extrabold text-slate-800 dark:text-white">{{ number_format($hd['tien_phong'] ?? 0) }}₫</span></p>
            </div>

            <div class="space-y-1.5">
                <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400 block mb-1">Thông tin chủ nhà thu tiền:</span>
                <p><strong>Họ tên chủ nhà:</strong> {{ $chuTro['ho_ten'] ?? 'Chủ nhà' }}</p>
                <p><strong>Số điện thoại:</strong> {{ $chuTro['so_dien_thoai'] ?? 'Chưa cập nhật' }}</p>
                <p><strong>Ngân hàng nhận:</strong> {{ $bank['bank_code'] }} - {{ $bank['account_no'] }}</p>
                <p><strong>Tên tài khoản:</strong> {{ $bank['account_name'] }}</p>
            </div>
        </div>

        {{-- 1. BẢNG ĐIỆN NƯỚC THEO CÔNG TƠ --}}
        @if(!empty($dienNuocList))
            <div class="space-y-3">
                <h3 class="text-xs font-black uppercase tracking-wider text-slate-700 dark:text-slate-300 flex items-center gap-2">
                    <i class="ri-flashlight-line text-amber-500 text-base"></i> Chỉ số Điện & Nước theo công tơ
                </h3>

                <div class="overflow-x-auto rounded-2xl border border-slate-200 dark:border-slate-700">
                    <table class="min-w-full text-xs text-left">
                        <thead class="bg-slate-50 dark:bg-slate-900 text-slate-600 dark:text-slate-300 uppercase text-[11px] border-b border-slate-200 dark:border-slate-700">
                            <tr>
                                <th class="p-3.5">Hạng mục</th>
                                <th class="p-3.5 text-center">Chỉ số cũ</th>
                                <th class="p-3.5 text-center">Chỉ số mới</th>
                                <th class="p-3.5 text-center">Tiêu thụ</th>
                                <th class="p-3.5 text-right">Đơn giá</th>
                                <th class="p-3.5 text-right">Thành tiền</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                            @foreach ($dienNuocList as $ct)
                                <tr>
                                    <td class="p-3.5 font-bold text-slate-800 dark:text-slate-200">
                                        {{ $ct['ten_dich_vu'] ?? 'Điện / Nước' }}
                                    </td>
                                    <td class="p-3.5 text-center">{{ $ct['chi_so_cu'] ?? '--' }}</td>
                                    <td class="p-3.5 text-center">{{ $ct['chi_so_moi'] ?? '--' }}</td>
                                    <td class="p-3.5 text-center font-bold text-sky-600">{{ $ct['san_luong'] ?? '--' }}</td>
                                    <td class="p-3.5 text-right">{{ number_format($ct['don_gia'] ?? 0) }}₫</td>
                                    <td class="p-3.5 text-right font-extrabold text-slate-900 dark:text-white">
                                        {{ number_format($ct['thanh_tien'] ?? 0) }}₫
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="bg-slate-50/70 dark:bg-slate-900/50 font-bold border-t border-slate-200 dark:border-slate-700">
                            <tr>
                                <td colspan="5" class="p-3 text-right">Tổng điện nước:</td>
                                <td class="p-3 text-right text-slate-900 dark:text-white font-black">
                                    {{ number_format(collect($dienNuocList)->sum('thanh_tien')) }}₫
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        @endif

        {{-- 2. BẢNG DỊCH VỤ ĐĂNG KÝ --}}
        @if(!empty($dichVuList))
            <div class="space-y-3">
                <h3 class="text-xs font-black uppercase tracking-wider text-slate-700 dark:text-slate-300 flex items-center gap-2">
                    <i class="ri-service-line text-sky-500 text-base"></i> Phí dịch vụ cố định (Wifi, Rác, Vệ sinh...)
                </h3>

                <div class="overflow-x-auto rounded-2xl border border-slate-200 dark:border-slate-700">
                    <table class="min-w-full text-xs text-left">
                        <thead class="bg-slate-50 dark:bg-slate-900 text-slate-600 dark:text-slate-300 uppercase text-[11px] border-b border-slate-200 dark:border-slate-700">
                            <tr>
                                <th class="p-3.5">Tên dịch vụ</th>
                                <th class="p-3.5 text-center">Số lượng</th>
                                <th class="p-3.5 text-right">Đơn giá</th>
                                <th class="p-3.5 text-right">Thành tiền</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                            @foreach ($dichVuList as $dv)
                                <tr>
                                    <td class="p-3.5 font-bold text-slate-800 dark:text-slate-200">{{ $dv['ten_dich_vu'] ?? '--' }}</td>
                                    <td class="p-3.5 text-center">{{ $dv['so_luong'] ?? '1' }}</td>
                                    <td class="p-3.5 text-right">{{ number_format($dv['don_gia'] ?? 0) }}₫</td>
                                    <td class="p-3.5 text-right font-extrabold text-slate-900 dark:text-white">
                                        {{ number_format($dv['thanh_tien'] ?? 0) }}₫
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="bg-slate-50/70 dark:bg-slate-900/50 font-bold border-t border-slate-200 dark:border-slate-700">
                            <tr>
                                <td colspan="3" class="p-3 text-right">Tổng dịch vụ:</td>
                                <td class="p-3 text-right text-slate-900 dark:text-white font-black">
                                    {{ number_format(collect($dichVuList)->sum('thanh_tien')) }}₫
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        @endif

        {{-- SUMMARY & PAYMENT CONTAINER --}}
        <div class="bg-slate-50 dark:bg-slate-900/60 rounded-3xl p-6 sm:p-8 border border-slate-200/80 dark:border-slate-800 flex flex-col md:flex-row items-center justify-between gap-6">
            <div class="space-y-1 text-center md:text-left">
                <span class="text-xs font-bold uppercase tracking-wider text-slate-400">TỔNG CỘNG TIỀN PHẢI THANH TOÁN:</span>
                <p class="text-3xl sm:text-4xl font-black text-rose-600">
                    {{ number_format($hd['tong_tien'] ?? 0) }}₫
                </p>
                <p class="text-xs text-slate-400">Đã bao gồm tiền phòng + điện nước + dịch vụ tháng {{ $hd['thang'] ?? '--' }}</p>
            </div>

            @if(!$isPaid)
                <div class="flex items-center gap-3 w-full md:w-auto">
                    <button type="button" id="btnOpenQR"
                        class="w-full sm:w-auto px-6 py-3.5 rounded-2xl bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 text-white font-black text-xs sm:text-sm shadow-xl shadow-emerald-600/25 transition flex items-center justify-center gap-2 cursor-pointer">
                        <i class="ri-qr-code-line text-lg"></i>
                        <span>Thanh Toán Bằng VietQR</span>
                    </button>
                </div>
            @else
                <div class="flex items-center gap-2 text-emerald-600 font-extrabold text-sm">
                    <i class="ri-checkbox-circle-fill text-2xl"></i>
                    <span>Hóa đơn này đã được xác nhận thanh toán thành công!</span>
                </div>
            @endif
        </div>

    </div>

    {{-- VIETQR MODAL --}}
    <div id="qrModal" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/70 backdrop-blur-sm">
        <div class="bg-white dark:bg-slate-900 rounded-3xl max-w-md w-full p-6 sm:p-7 border border-slate-200 dark:border-slate-800 shadow-2xl relative text-center space-y-4">
            <button type="button" id="btnCloseQR"
                class="absolute top-4 right-4 w-9 h-9 rounded-full bg-slate-100 dark:bg-slate-800 text-slate-500 hover:text-slate-900 dark:hover:text-white flex items-center justify-center transition">
                <i class="ri-close-line text-lg"></i>
            </button>

            <div>
                <span class="inline-block px-3 py-1 rounded-full text-xs font-black bg-emerald-100 text-emerald-800 uppercase tracking-wider mb-2">
                    Thanh Toán Tự Động 24/7
                </span>
                <h3 class="text-lg font-black text-slate-900 dark:text-white">
                    Quét Mã VietQR Chuyển Khoản
                </h3>
                <p class="text-xs text-slate-400 mt-1">
                    Hóa đơn Tháng {{ $hd['thang'] ?? '--' }} • {{ number_format($hd['tong_tien'] ?? 0) }}₫
                </p>
            </div>

            {{-- QR Code Image --}}
            <div class="p-3 bg-white rounded-2xl border border-slate-200 shadow-inner max-w-[260px] mx-auto">
                <img id="qrImage" src="{{ $qrUrl }}" alt="VietQR" class="w-full h-auto rounded-xl">
            </div>

            <div class="text-xs text-slate-500 dark:text-slate-400 space-y-1 text-left bg-slate-50 dark:bg-slate-800 p-3.5 rounded-2xl">
                <p>Ngân hàng: <strong class="text-slate-800 dark:text-slate-200">{{ $bank['bank_code'] }}</strong></p>
                <p>Số tài khoản: <strong class="text-slate-800 dark:text-slate-200">{{ $bank['account_no'] }}</strong></p>
                <p>Chủ tài khoản: <strong class="text-slate-800 dark:text-slate-200">{{ $bank['account_name'] }}</strong></p>
                <p>Nội dung: <strong class="text-sky-600">{{ $bank['description'] }}</strong></p>
            </div>

            <div class="pt-2 flex flex-col sm:flex-row items-center justify-center gap-3">
                <button type="button" id="btnDownloadQR"
                    class="w-full sm:w-auto px-4 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 text-slate-700 dark:text-slate-200 font-bold text-xs transition flex items-center justify-center gap-1.5">
                    <i class="ri-download-2-line"></i> Tải ảnh QR
                </button>
                <button type="button" id="btnConfirmTransferred"
                    class="w-full sm:w-auto px-5 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold text-xs shadow-md shadow-emerald-600/20 transition flex items-center justify-center gap-1.5">
                    <i class="ri-check-line"></i> Tôi đã chuyển khoản xong
                </button>
            </div>
        </div>
    </div>

</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const modal = document.getElementById('qrModal');
    const openBtn = document.getElementById('btnOpenQR');
    const closeBtn = document.getElementById('btnCloseQR');
    const confirmBtn = document.getElementById('btnConfirmTransferred');
    const downloadBtn = document.getElementById('btnDownloadQR');
    const qrImg = document.getElementById('qrImage');

    if (openBtn && modal) {
        openBtn.addEventListener('click', () => modal.classList.remove('hidden'));
    }
    if (closeBtn && modal) {
        closeBtn.addEventListener('click', () => modal.classList.add('hidden'));
    }
    if (modal) {
        modal.addEventListener('click', (e) => {
            if (e.target === modal) modal.classList.add('hidden');
        });
    }

    if (downloadBtn && qrImg) {
        downloadBtn.addEventListener('click', () => {
            const a = document.createElement('a');
            a.href = qrImg.src;
            a.download = 'vietqr-hoadon-{{ $hd['id'] ?? 0 }}.png';
            a.target = '_blank';
            a.click();
        });
    }

    if (confirmBtn) {
        confirmBtn.addEventListener('click', async () => {
            const result = await Swal.fire({
                title: 'Xác nhận chuyển khoản?',
                text: 'Bạn đã hoàn tất chuyển khoản thành công số tiền {{ number_format($hd['tong_tien'] ?? 0) }}₫ cho chủ nhà?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Đúng, tôi đã chuyển khoản',
                cancelButtonText: 'Chưa, tôi kiểm tra lại',
                confirmButtonColor: '#16a34a',
                cancelButtonColor: '#64748b'
            });

            if (!result.isConfirmed) return;

            const token = localStorage.getItem('token') || localStorage.getItem('api_token') || '{{ session('api_token') }}' || (document.cookie.match(/(^|;)\s*api_token\s*=\s*([^;]+)/)?.[2] || '');
            const apiBase = '{{ rtrim(env('API_URL', 'http://127.0.0.1:8000/api'), '/') }}';
            const hdId = {{ $hd['id'] ?? 0 }};

            try {
                Swal.fire({
                    title: 'Đang gửi xác nhận...',
                    text: 'Hệ thống đang đối soát và tạo biên lai giao dịch',
                    allowOutsideClick: false,
                    didOpen: () => Swal.showLoading()
                });

                const res = await fetch(`${apiBase}/khach-thue/hoa-don/${hdId}/xac-nhan-thanh-toan`, {
                    method: 'POST',
                    headers: {
                        'Authorization': 'Bearer ' + token,
                        'Accept': 'application/json'
                    }
                });

                const data = await res.json();
                modal.classList.add('hidden');

                if (res.ok && data.success) {
                    const d = data.data || {};
                    const maGD = d.ma_giao_dich || ('GD' + Math.random().toString(36).substr(2, 8).toUpperCase());
                    const soTien = Number(d.so_tien || {{ $hd['tong_tien'] ?? 0 }}).toLocaleString('vi-VN') + ' ₫';
                    const ngayTT = d.ngay_thanh_toan || new Date().toLocaleString('vi-VN');
                    const thang = d.thang || '{{ $hd['thang'] ?? '' }}';
                    const phuongThuc = d.phuong_thuc || 'Chuyển khoản VietQR';

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
                                    <span style="font-weight: 600;">${phuongThuc}</span>
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
                        confirmButtonText: 'Hoàn tất & Cập nhật trang',
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
                modal.classList.add('hidden');
                Swal.fire({
                    icon: 'error',
                    title: 'Lỗi',
                    text: 'Không thể kết nối đến máy chủ: ' + err.message
                });
            }
        });
    }
});
</script>
@endpush
@endsection
