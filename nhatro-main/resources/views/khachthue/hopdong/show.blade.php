@extends('layouts.tenant-layout')

@section('title', 'Chi tiết hợp đồng điện tử - Nền Tảng Trọ Thông Minh')
@section('page_title', 'Văn bản hợp đồng thuê điện tử')
@section('page_subtitle', 'Bản hợp đồng số có giá trị pháp lý, được xác thực chữ ký điện tử qua hệ thống')

@section('tenant_content')
@php
    $hd = $hopDong ?? [];
    $phong = $hd['phong'] ?? [];
    $dayTro = $phong['day_tro'] ?? [];
    $chuTro = $dayTro['chu_tro'] ?? [];
    $user = session('user') ?? auth()->user();

    $st = $hd['trang_thai'] ?? 'hieu_luc';
    $isActive = in_array($st, ['hieu_luc', 'active', 'dang_hieu_luc']);

    $pdfUrl = $hd['url_file_hop_dong'] ?? asset('files/hopdong_mau.pdf');
    $hoaDonList = $hd['hoa_don'] ?? [];
@endphp

<div class="space-y-8">

    {{-- TOP BAR --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div class="flex items-center gap-2 text-xs font-semibold text-slate-400">
            <a href="{{ route('khach-thue.dashboard') }}" class="hover:text-sky-600 transition">Dashboard</a>
            <i class="ri-arrow-right-s-line"></i>
            <a href="{{ route('khach-thue.hop-dong.index') }}" class="hover:text-sky-600 transition">Hợp đồng điện tử</a>
            <i class="ri-arrow-right-s-line"></i>
            <span class="text-slate-700 dark:text-slate-200">#HĐ-{{ $hd['id'] ?? '01' }}</span>
        </div>

        <div class="flex items-center gap-3">
            <a href="{{ route('khach-thue.hop-dong.index') }}"
                class="px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 text-slate-700 dark:text-slate-200 text-xs font-bold transition flex items-center gap-1.5">
                <i class="ri-arrow-left-line"></i> Quay lại
            </a>
            <button type="button" onclick="window.print()"
                class="px-4 py-2 rounded-xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-700 dark:text-slate-200 text-xs font-bold shadow-xs hover:bg-slate-50 transition flex items-center gap-1.5">
                <i class="ri-printer-line"></i> In văn bản
            </button>
            <a href="{{ $pdfUrl }}" target="_blank"
                class="px-4 py-2 rounded-xl bg-sky-600 hover:bg-sky-700 text-white text-xs font-extrabold shadow-md shadow-sky-600/20 transition flex items-center gap-1.5">
                <i class="ri-file-pdf-line"></i> Tải PDF gốc
            </a>
        </div>
    </div>

    {{-- OFFICIAL CONTRACT PAPER CARD --}}
    <div class="bg-white dark:bg-slate-800/90 rounded-3xl p-6 sm:p-10 border border-slate-200/80 dark:border-slate-700 shadow-xl space-y-8 relative overflow-hidden">

        {{-- Digital Verified Watermark / Stamp --}}
        <div class="absolute right-6 top-6 sm:right-10 sm:top-10 opacity-90 pointer-events-none">
            <div class="border-4 border-dashed border-emerald-600 rounded-3xl p-3 sm:p-4 text-emerald-600 rotate-[-12deg] text-center uppercase font-black text-xs sm:text-sm tracking-wider shadow-sm">
                <i class="ri-verified-badge-fill text-xl sm:text-2xl block mb-0.5"></i>
                ĐÃ KÝ SỐ ĐIỆN TỬ<br>
                <span class="text-[9px] font-bold tracking-normal opacity-80">Smart Home Certified</span>
            </div>
        </div>

        {{-- Contract Header --}}
        <div class="text-center space-y-2 border-b border-slate-100 dark:border-slate-700 pb-6">
            <p class="text-xs font-bold uppercase tracking-widest text-slate-400">
                CỘNG HÒA XÃ HỘI CHỦ NGHĨA VIỆT NAM<br>
                <span class="text-[10px] tracking-normal">Độc lập - Tự do - Hạnh phúc</span>
            </p>
            <div class="pt-3">
                <h2 class="text-2xl sm:text-3xl font-black text-slate-900 dark:text-white uppercase tracking-tight">
                    HỢP ĐỒNG THUÊ PHÒNG TRỌ ĐIỆN TỬ
                </h2>
                <p class="text-xs text-sky-600 font-bold mt-1">
                    Mã định danh hợp đồng số: #HĐ-{{ $hd['id'] ?? '2026-PT' }} • Ngày tạo: {{ !empty($hd['ngay_tao']) ? \Carbon\Carbon::parse($hd['ngay_tao'])->format('d/m/Y') : date('d/m/Y') }}
                </p>
            </div>
        </div>

        {{-- Parties Grid: Bên A & Bên B --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            {{-- Bên A: Cho thuê --}}
            <div class="p-5 rounded-2xl bg-slate-50 dark:bg-slate-900/60 border border-slate-100 dark:border-slate-800 space-y-2 text-xs">
                <span class="inline-block px-2.5 py-0.5 rounded-full text-[10px] font-black bg-indigo-100 text-indigo-700 uppercase mb-1">
                    BÊN CHO THUÊ (BÊN A)
                </span>
                <p><strong>Họ và tên:</strong> {{ $chuTro['ho_ten'] ?? 'Chủ nhà trọ' }}</p>
                <p><strong>Số điện thoại:</strong> {{ $chuTro['so_dien_thoai'] ?? 'Chưa cập nhật' }}</p>
                <p><strong>Địa chỉ khu trọ:</strong> {{ $dayTro['dia_chi'] ?? 'TP. Hồ Chí Minh' }}</p>
                <p><strong>Tên dãy trọ:</strong> {{ $dayTro['ten_day_tro'] ?? 'Khu trọ' }}</p>
            </div>

            {{-- Bên B: Người thuê --}}
            <div class="p-5 rounded-2xl bg-slate-50 dark:bg-slate-900/60 border border-slate-100 dark:border-slate-800 space-y-2 text-xs">
                <span class="inline-block px-2.5 py-0.5 rounded-full text-[10px] font-black bg-sky-100 text-sky-700 uppercase mb-1">
                    BÊN THUÊ (BÊN B)
                </span>
                <p><strong>Họ và tên người thuê:</strong> {{ $user['ho_ten'] ?? 'Khách thuê' }}</p>
                <p><strong>Số điện thoại:</strong> {{ $user['so_dien_thoai'] ?? 'Chưa cập nhật' }}</p>
                <p><strong>Email:</strong> {{ $user['email'] ?? 'Chưa cập nhật' }}</p>
                <p><strong>Trạng thái xác thực:</strong> <span class="inline-flex items-center gap-1 text-emerald-600 font-bold"><i class="ri-shield-check-fill text-sm"></i> Đã định danh</span></p>
            </div>
        </div>

        {{-- Property & Terms Specs --}}
        <div class="space-y-4 text-xs sm:text-sm">
            <h3 class="text-sm font-black uppercase tracking-wider text-slate-800 dark:text-white border-b border-slate-100 dark:border-slate-700 pb-2">
                ĐIỀU 1. ĐỐI TƯỢNG VÀ THỜI HẠN THUÊ
            </h3>
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 p-4 rounded-2xl bg-sky-50/50 dark:bg-sky-950/30 border border-sky-100 dark:border-sky-900 text-xs">
                <div>
                    <span class="text-slate-400 block">Số phòng thuê:</span>
                    <span class="font-black text-slate-800 dark:text-white">Phòng {{ $phong['so_phong'] ?? '—' }}</span>
                </div>
                <div>
                    <span class="text-slate-400 block">Diện tích phòng:</span>
                    <span class="font-black text-slate-800 dark:text-white">{{ $phong['dien_tich'] ?? '--' }} m²</span>
                </div>
                <div>
                    <span class="text-slate-400 block">Ngày bắt đầu thuê:</span>
                    <span class="font-bold text-slate-800 dark:text-white">
                        {{ !empty($hd['ngay_bat_dau']) ? \Carbon\Carbon::parse($hd['ngay_bat_dau'])->format('d/m/Y') : '—' }}
                    </span>
                </div>
                <div>
                    <span class="text-slate-400 block">Ngày kết thúc thuê:</span>
                    <span class="font-bold text-slate-800 dark:text-white">
                        {{ !empty($hd['ngay_ket_thuc']) ? \Carbon\Carbon::parse($hd['ngay_ket_thuc'])->format('d/m/Y') : '—' }}
                    </span>
                </div>
            </div>

            <h3 class="text-sm font-black uppercase tracking-wider text-slate-800 dark:text-white border-b border-slate-100 dark:border-slate-700 pb-2 pt-2">
                ĐIỀU 2. GIÁ THUÊ & TIỀN ĐẶT CỌC
            </h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                <div class="p-4 rounded-2xl bg-slate-50 dark:bg-slate-900/60 border border-slate-100 dark:border-slate-800 space-y-1">
                    <span class="text-slate-400 block">Tiền thuê hàng tháng:</span>
                    <p class="text-lg font-black text-slate-900 dark:text-white">
                        {{ number_format($phong['gia'] ?? 0, 0, ',', '.') }}₫ / tháng
                    </p>
                    <p class="text-[11px] text-slate-500">Chưa bao gồm chi phí điện, nước và các dịch vụ đăng ký thêm.</p>
                </div>

                <div class="p-4 rounded-2xl bg-slate-50 dark:bg-slate-900/60 border border-slate-100 dark:border-slate-800 space-y-1">
                    <span class="text-slate-400 block">Tiền đặt cọc giữ chỗ:</span>
                    <p class="text-lg font-black text-sky-600">
                        {{ number_format($hd['tien_coc'] ?? 0, 0, ',', '.') }}₫
                    </p>
                    <p class="text-[11px] text-slate-500">Được hoàn trả 100% khi thanh lý hợp đồng đúng kỳ hạn.</p>
                </div>
            </div>

            <h3 class="text-sm font-black uppercase tracking-wider text-slate-800 dark:text-white border-b border-slate-100 dark:border-slate-700 pb-2 pt-2">
                ĐIỀU 3. QUYỀN VÀ NGHĨA VỤ CHUNG
            </h3>
            <ul class="list-disc list-inside space-y-1 text-slate-600 dark:text-slate-300 text-xs leading-relaxed">
                <li>Bên A cam kết bàn giao phòng đúng hiện trạng và các thiết bị tiện nghi đã thỏa thuận.</li>
                <li>Bên B có trách nhiệm thanh toán tiền phòng định kỳ đúng hạn trước ngày mùng 5 hàng tháng.</li>
                <li>Bảo vệ tài sản chung, giữ gìn vệ sinh khu trọ, không tụ tập gây rối mất trật tự an ninh.</li>
                <li>Thông báo trước tối thiểu 30 ngày cho Bên A nếu có nhu cầu chấm dứt hợp đồng trước hạn.</li>
            </ul>
        </div>

        {{-- ASSOCIATED INVOICES LIST --}}
        @if(!empty($hoaDonList))
            <div class="space-y-4 pt-4 border-t border-slate-100 dark:border-slate-700">
                <h3 class="text-sm font-black uppercase tracking-wider text-slate-800 dark:text-white">
                    CÁC KỲ HÓA ĐƠN ĐÍNH KÈM HỢP ĐỒNG NÀY
                </h3>
                <div class="overflow-x-auto rounded-2xl border border-slate-200 dark:border-slate-700">
                    <table class="min-w-full text-xs text-left">
                        <thead class="bg-slate-50 dark:bg-slate-900 text-slate-600 dark:text-slate-300 uppercase text-[11px] border-b border-slate-200 dark:border-slate-700">
                            <tr>
                                <th class="p-3">Mã hóa đơn</th>
                                <th class="p-3">Kỳ cước</th>
                                <th class="p-3">Tổng số tiền</th>
                                <th class="p-3 text-center">Trạng thái</th>
                                <th class="p-3 text-right">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                            @foreach ($hoaDonList as $hdItem)
                                @php
                                    $isPaid = ($hdItem['trang_thai'] ?? '') === 'da_thanh_toan';
                                @endphp
                                <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-900/40">
                                    <td class="p-3 font-bold text-slate-800 dark:text-slate-200">
                                        {{ $hdItem['ma_hoa_don'] ?? ('#HĐ-' . ($hdItem['id'] ?? '')) }}
                                    </td>
                                    <td class="p-3">Tháng {{ $hdItem['thang'] ?? '--' }}</td>
                                    <td class="p-3 font-extrabold text-slate-900 dark:text-white">
                                        {{ number_format($hdItem['tong_tien'] ?? 0) }}₫
                                    </td>
                                    <td class="p-3 text-center">
                                        <span class="px-2 py-0.5 rounded-full text-[10px] font-extrabold {{ $isPaid ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800' }}">
                                            {{ $isPaid ? 'Đã thanh toán' : 'Chưa thanh toán' }}
                                        </span>
                                    </td>
                                    <td class="p-3 text-right">
                                        <a href="{{ route('khach-thue.hoa-don.show', $hdItem['id']) }}" class="text-sky-600 font-bold hover:underline">
                                            Xem hóa đơn &rarr;
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif

    </div>

</div>
@endsection
