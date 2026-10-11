@extends('layouts.chu-tro')

@section('title', 'Chi tiết Hợp Đồng Thuê - Hệ Thống Trọ')

@section('content')
@php
    $yc = $hop_dong['yeu_cau'] ?? null;
    $st = $hop_dong['trang_thai'] ?? 'hieu_luc';
    $fileHopDong = $yc['file_hop_dong'] ?? $hop_dong['url_file_hop_dong'] ?? null;
    $pdfUrl = !empty($fileHopDong) ? (rtrim(env('API_BASE_URL', 'http://127.0.0.1:8000'), '/') . '/storage/' . ltrim($fileHopDong, '/')) : null;

    $nguoiThanList = $yc['nguoi_than'] ?? $hop_dong['nguoi_than'] ?? [];
    if (is_string($nguoiThanList)) {
        $decoded = json_decode($nguoiThanList, true);
        if (json_last_error() === JSON_ERROR_NONE) {
            $nguoiThanList = $decoded;
        } else {
            $nguoiThanList = $nguoiThanList ? [['ho_ten' => $nguoiThanList]] : [];
        }
    }
@endphp

<div class="max-w-5xl mx-auto space-y-8 animate-fade-in">
    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-sky-100 dark:bg-sky-950 text-sky-700 dark:text-sky-300 mb-2">
                <i class="ri-file-text-line"></i> Hồ Sơ Hợp Đồng #HĐ-{{ $hop_dong['id'] ?? '01' }}
            </div>
            <div class="flex items-center gap-3">
                <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 dark:text-white tracking-tight">
                    Hợp Đồng Phòng {{ $hop_dong['so_phong'] ?? '' }}
                </h1>
                @if($st === 'hieu_luc')
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-700 dark:bg-emerald-950/60 dark:text-emerald-400">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span> Đang có hiệu lực
                    </span>
                @elseif($st === 'het_han')
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-slate-200 text-slate-700 dark:bg-slate-700 dark:text-slate-300">
                        <span class="w-2 h-2 rounded-full bg-slate-400"></span> Đã hết hạn
                    </span>
                @else
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-rose-100 text-rose-700 dark:bg-rose-950/60 dark:text-rose-400">
                        <span class="w-2 h-2 rounded-full bg-rose-500"></span> Đã hủy
                    </span>
                @endif
            </div>
            <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 mt-1 flex items-center gap-1">
                <i class="ri-community-line text-sky-500"></i>
                <span>{{ $hop_dong['ten_day_tro'] ?? 'Cơ sở trọ' }}</span>
                <span class="text-slate-300 dark:text-slate-600">•</span>
                <i class="ri-calendar-line text-sky-500"></i>
                <span>Tạo lúc {{ \Carbon\Carbon::parse($hop_dong['ngay_tao'])->format('d/m/Y H:i') }}</span>
            </p>
        </div>

        <div class="flex items-center gap-3">
            <a href="{{ route('chu-tro.hop-dong.edit', $hop_dong['id']) }}"
                class="inline-flex items-center gap-1.5 px-4 py-2.5 rounded-xl bg-gradient-to-r from-sky-600 to-sky-500 hover:from-sky-700 hover:to-sky-600 text-white text-xs sm:text-sm font-bold shadow-md shadow-sky-500/25 transition">
                <i class="ri-edit-2-line"></i>
                <span>Sửa hợp đồng</span>
            </a>
            <a href="{{ route('chu-tro.hop-dong.index') }}"
                class="inline-flex items-center gap-1.5 px-4 py-2.5 rounded-xl bg-white dark:bg-slate-800 border border-slate-200/80 dark:border-slate-700 hover:bg-slate-50 text-slate-700 dark:text-slate-200 text-xs sm:text-sm font-bold shadow-xs transition">
                <i class="ri-arrow-left-line"></i>
                <span>Quay lại</span>
            </a>
        </div>
    </div>

    {{-- KPI Cards --}}
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
        <div class="bg-white dark:bg-slate-800 rounded-3xl p-5 border border-slate-200/80 dark:border-slate-700 shadow-sm">
            <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400 block mb-1">Tiền cọc</span>
            <div class="flex items-baseline gap-1">
                <span class="text-2xl font-black text-emerald-600 dark:text-emerald-400">
                    {{ number_format($yc['tien_coc'] ?? $hop_dong['tien_coc'] ?? 0, 0, ',', '.') }}
                </span>
                <span class="text-xs text-slate-400 font-semibold">đ</span>
            </div>
        </div>

        <div class="bg-white dark:bg-slate-800 rounded-3xl p-5 border border-slate-200/80 dark:border-slate-700 shadow-sm">
            <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400 block mb-1">Ngày bắt đầu</span>
            <span class="text-base font-bold text-slate-800 dark:text-slate-200 block mt-1">
                {{ \Carbon\Carbon::parse($yc['ngay_bat_dau'] ?? $hop_dong['ngay_bat_dau'])->format('d/m/Y') }}
            </span>
        </div>

        <div class="bg-white dark:bg-slate-800 rounded-3xl p-5 border border-slate-200/80 dark:border-slate-700 shadow-sm">
            <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400 block mb-1">Ngày kết thúc</span>
            <span class="text-base font-bold text-slate-800 dark:text-slate-200 block mt-1">
                {{ \Carbon\Carbon::parse($yc['ngay_ket_thuc'] ?? $hop_dong['ngay_ket_thuc'])->format('d/m/Y') }}
            </span>
        </div>

        <div class="bg-white dark:bg-slate-800 rounded-3xl p-5 border border-slate-200/80 dark:border-slate-700 shadow-sm">
            <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400 block mb-1">Đại diện thuê</span>
            <span class="text-sm font-bold text-slate-800 dark:text-slate-200 block mt-1 truncate">
                {{ $hop_dong['khach_thue'] ?? 'Khách thuê' }}
            </span>
        </div>
    </div>

    {{-- Main Document Card --}}
    <div class="bg-white dark:bg-slate-800 rounded-3xl border border-slate-200/80 dark:border-slate-700 shadow-sm p-6 sm:p-10 space-y-8 relative overflow-hidden">
        {{-- Digital Certified Stamp --}}
        <div class="absolute right-6 top-6 sm:right-10 sm:top-10 opacity-90 pointer-events-none">
            <div class="border-4 border-dashed border-emerald-600 rounded-3xl p-3 sm:p-4 text-emerald-600 rotate-[-12deg] text-center uppercase font-black text-xs sm:text-sm tracking-wider shadow-sm">
                <i class="ri-verified-badge-fill text-xl sm:text-2xl block mb-0.5"></i>
                HỢP ĐỒNG ĐÃ KÝ<br>
                <span class="text-[9px] font-bold tracking-normal opacity-80">Hệ Thống Trọ Certified</span>
            </div>
        </div>

        {{-- Section 1: Thông tin khách thuê --}}
        <div>
            <h2 class="text-xs font-bold uppercase tracking-wider text-sky-600 dark:text-sky-400 mb-4 flex items-center gap-1.5">
                <i class="ri-user-star-line text-base"></i> Bên B - Bên Thuê Phòng
            </h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 p-5 rounded-2xl bg-slate-50/70 dark:bg-slate-900/60 border border-slate-100 dark:border-slate-700/60 text-xs">
                <div>
                    <span class="text-slate-400 block mb-0.5">Họ và tên:</span>
                    <span class="font-bold text-sm text-slate-900 dark:text-white">{{ $hop_dong['khach_thue'] ?? '—' }}</span>
                </div>
                <div>
                    <span class="text-slate-400 block mb-0.5">Số điện thoại:</span>
                    <span class="font-bold text-slate-800 dark:text-slate-200">{{ $hop_dong['so_dien_thoai'] ?? 'Chưa có' }}</span>
                </div>
                <div>
                    <span class="text-slate-400 block mb-0.5">Email liên hệ:</span>
                    <span class="font-bold text-slate-800 dark:text-slate-200 truncate block">{{ $hop_dong['email'] ?? 'Chưa có' }}</span>
                </div>
                <div>
                    <span class="text-slate-400 block mb-0.5">Số CCCD / CMND:</span>
                    <span class="font-bold text-slate-800 dark:text-slate-200">{{ $hop_dong['cccd'] ?? 'Chưa cung cấp' }}</span>
                </div>
            </div>
        </div>

        {{-- Section 2: Người thân đi cùng --}}
        <div>
            <h2 class="text-xs font-bold uppercase tracking-wider text-sky-600 dark:text-sky-400 mb-4 flex items-center gap-1.5">
                <i class="ri-group-line text-base"></i> Người Thân / Cư Dân Lưu Trú Cùng
            </h2>
            @if (!empty($nguoiThanList))
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3">
                    @foreach ($nguoiThanList as $nt)
                        <div class="p-4 rounded-2xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800/80 shadow-xs space-y-1">
                            <p class="font-bold text-slate-900 dark:text-white text-xs">{{ $nt['ho_ten'] ?? ($nt['ten'] ?? 'Ẩn danh') }}</p>
                            <p class="text-[11px] text-slate-500">Mối quan hệ: <span class="font-semibold text-slate-700 dark:text-slate-300">{{ $nt['moi_quan_he'] ?? 'Chưa rõ' }}</span></p>
                            <p class="text-[11px] text-slate-500">SĐT: <span class="font-semibold text-slate-700 dark:text-slate-300">{{ $nt['so_dien_thoai'] ?? 'Chưa có' }}</span></p>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-xs text-slate-400 italic">Không có người thân đăng ký ở cùng.</p>
            @endif
        </div>

        {{-- Section 3: Điều khoản & Ghi chú --}}
        <div>
            <h2 class="text-xs font-bold uppercase tracking-wider text-sky-600 dark:text-sky-400 mb-3 flex items-center gap-1.5">
                <i class="ri-file-list-3-line text-base"></i> Ghi Chú & Điều Khoản Bổ Sung
            </h2>
            <div class="p-4 rounded-2xl bg-slate-50/70 dark:bg-slate-900/60 text-slate-700 dark:text-slate-300 text-xs sm:text-sm leading-relaxed whitespace-pre-line">
                {{ $yc['ghi_chu'] ?? $hop_dong['ghi_chu'] ?? 'Không có ghi chú thêm.' }}
            </div>
        </div>

        {{-- Section 4: File văn bản đính kèm --}}
        <div>
            <h2 class="text-xs font-bold uppercase tracking-wider text-sky-600 dark:text-sky-400 mb-3 flex items-center gap-1.5">
                <i class="ri-attachment-line text-base"></i> Văn Bản Hợp Đồng Ký Số (PDF)
            </h2>
            @if (!empty($pdfUrl))
                <div class="flex items-center gap-3">
                    <button type="button" id="btn-open-pdf" data-url="{{ $pdfUrl }}"
                        class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-sky-600 hover:bg-sky-700 text-white text-xs font-bold shadow-md shadow-sky-600/25 transition">
                        <i class="ri-eye-line text-base"></i>
                        <span>Xem trực tiếp văn bản</span>
                    </button>
                    <a href="{{ $pdfUrl }}" target="_blank"
                        class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 hover:bg-slate-50 text-slate-700 dark:text-slate-200 text-xs font-bold shadow-xs transition">
                        <i class="ri-external-link-line"></i>
                        <span>Mở tab mới</span>
                    </a>
                </div>
            @else
                <p class="text-xs text-slate-400 italic">Chưa có văn bản PDF nào được tải lên cho hợp đồng này.</p>
            @endif
        </div>
    </div>

    {{-- Bottom Delete Action --}}
    <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100 dark:border-slate-700/60">
        <form action="{{ route('chu-tro.hop-dong.destroy', $hop_dong['id']) }}" method="POST"
            onsubmit="return confirm('Bạn có chắc chắn muốn xóa hợp đồng này không? Thao tác này không thể hoàn tác.')">
            @csrf
            @method('DELETE')
            <button type="submit"
                class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl border border-rose-200 dark:border-rose-900/60 bg-rose-50 dark:bg-rose-950/40 text-rose-600 dark:text-rose-400 hover:bg-rose-100 text-xs font-bold transition">
                <i class="ri-delete-bin-6-line"></i>
                <span>Xóa hợp đồng</span>
            </button>
        </form>
    </div>
</div>

{{-- Modal xem PDF --}}
@if (!empty($pdfUrl))
<div id="pdf-modal" class="hidden fixed inset-0 bg-slate-950/70 backdrop-blur-xs z-50 items-center justify-center p-4">
    <div class="bg-white dark:bg-slate-900 rounded-3xl w-full max-w-5xl h-[85vh] relative flex flex-col overflow-hidden shadow-2xl border border-slate-200 dark:border-slate-700">
        <div class="flex items-center justify-between p-4 border-b border-slate-100 dark:border-slate-800">
            <h3 class="text-sm font-bold text-slate-900 dark:text-white flex items-center gap-1.5">
                <i class="ri-file-pdf-line text-rose-500 text-lg"></i>
                <span>Văn bản hợp đồng thuê #HĐ-{{ $hop_dong['id'] ?? '01' }}</span>
            </h3>
            <button id="btn-close-pdf"
                class="w-8 h-8 rounded-full bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 flex items-center justify-center font-bold text-sm hover:bg-slate-200 transition">
                ✕
            </button>
        </div>
        <iframe id="pdf-frame" src="" class="w-full h-full"></iframe>
    </div>
</div>

<script>
    const btnOpen = document.getElementById('btn-open-pdf');
    const modal = document.getElementById('pdf-modal');
    const iframe = document.getElementById('pdf-frame');
    const btnClose = document.getElementById('btn-close-pdf');

    btnOpen?.addEventListener('click', () => {
        iframe.src = btnOpen.dataset.url;
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    });

    function closePdf() {
        iframe.src = '';
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }

    btnClose?.addEventListener('click', closePdf);
    modal?.addEventListener('click', (e) => {
        if (e.target === modal) closePdf();
    });
</script>
@endif
@endsection