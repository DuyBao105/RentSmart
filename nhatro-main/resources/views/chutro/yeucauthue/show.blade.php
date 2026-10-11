@extends('layouts.chu-tro')

@section('title', 'Chi tiết yêu cầu thuê')

@section('content')
<div class="max-w-5xl mx-auto space-y-6">

    {{-- 🔹 Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-indigo-50 dark:bg-indigo-950/60 text-indigo-600 dark:text-indigo-400 text-xs font-semibold uppercase tracking-wider mb-2 border border-indigo-100 dark:border-indigo-900/50">
                <i class="ri-file-user-line"></i> Đơn đăng ký thuê
            </div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 dark:text-white tracking-tight flex items-center gap-2.5">
                <span class="w-2.5 h-8 bg-gradient-to-b from-indigo-500 to-sky-500 rounded-full inline-block"></span>
                Yêu cầu thuê phòng {{ $yeu_cau['so_phong'] ?? '' }}
            </h1>
            <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">
                Dãy trọ: <strong class="text-slate-700 dark:text-slate-200">{{ $yeu_cau['ten_day_tro'] ?? '' }}</strong> • Gửi lúc {{ !empty($yeu_cau['ngay_tao']) ? \Carbon\Carbon::parse($yeu_cau['ngay_tao'])->format('d/m/Y H:i') : '--' }}
            </p>
        </div>

        <a href="{{ route('chu-tro.yeu-cau-thue.index') }}"
            class="inline-flex items-center gap-2 px-4 py-2 text-sm font-semibold text-slate-600 dark:text-slate-300 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl hover:bg-slate-50 shadow-sm transition">
            <i class="ri-arrow-left-line"></i> Danh sách yêu cầu
        </a>
    </div>

    {{-- 🔹 2-Column Grid Layout --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        {{-- Cột 1: Thông tin khách đăng ký --}}
        <div class="md:col-span-1 bg-white dark:bg-slate-900 p-6 rounded-3xl border border-slate-200/80 dark:border-slate-800 shadow-sm space-y-5">
            <div class="flex flex-col items-center text-center pb-5 border-b border-slate-100 dark:border-slate-800">
                <div class="w-16 h-16 rounded-2xl bg-gradient-to-tr from-indigo-500 to-sky-400 text-white flex items-center justify-center font-black text-xl shadow-md shadow-indigo-500/20 mb-3">
                    {{ strtoupper(mb_substr($yeu_cau['khach_thue'] ?? 'K', 0, 1)) }}
                </div>
                <h3 class="font-bold text-base text-slate-900 dark:text-white">{{ $yeu_cau['khach_thue'] ?? '' }}</h3>
                <span class="text-xs text-slate-400 mt-0.5">Khách đăng ký thuê</span>
            </div>

            <div class="space-y-3.5 text-xs">
                <div>
                    <span class="font-bold uppercase tracking-wider text-slate-400">Email liên hệ</span>
                    <p class="font-medium text-slate-700 dark:text-slate-300 mt-0.5 break-all">{{ $yeu_cau['email'] ?? 'Không có' }}</p>
                </div>
                <div>
                    <span class="font-bold uppercase tracking-wider text-slate-400">Số CCCD / CMND</span>
                    <p class="font-mono font-medium text-slate-800 dark:text-slate-200 mt-0.5">{{ $yeu_cau['cccd'] ?? 'Chưa cung cấp' }}</p>
                </div>
                <div>
                    <span class="font-bold uppercase tracking-wider text-slate-400">Trạng thái xử lý</span>
                    <div class="mt-1">
                        @php
                            $st = $yeu_cau['trang_thai'] ?? 'cho_duyet';
                            $badge = match ($st) {
                                'cho_duyet' => 'bg-amber-50 dark:bg-amber-950/60 text-amber-700 dark:text-amber-400 border-amber-200 dark:border-amber-800',
                                'chap_nhan' => 'bg-sky-50 dark:bg-sky-950/60 text-sky-700 dark:text-sky-400 border-sky-200 dark:border-sky-800',
                                'da_tao_hop_dong' => 'bg-emerald-50 dark:bg-emerald-950/60 text-emerald-700 dark:text-emerald-400 border-emerald-200 dark:border-emerald-800',
                                'tu_choi' => 'bg-rose-50 dark:bg-rose-950/60 text-rose-700 dark:text-rose-400 border-rose-200 dark:border-rose-800',
                                default => 'bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 border-slate-200 dark:border-slate-700',
                            };
                            $label = match ($st) {
                                'cho_duyet' => 'Chờ duyệt',
                                'chap_nhan' => 'Đã duyệt',
                                'da_tao_hop_dong' => 'Đã tạo hợp đồng',
                                'tu_choi' => 'Đã từ chối',
                                default => ucfirst($st),
                            };
                        @endphp
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold border {{ $badge }}">
                            <span class="w-1.5 h-1.5 rounded-full bg-current"></span>
                            {{ $label }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Cột 2: Chi tiết đăng ký thuê & Tệp đính kèm --}}
        <div class="md:col-span-2 bg-white dark:bg-slate-900 p-6 rounded-3xl border border-slate-200/80 dark:border-slate-800 shadow-sm space-y-6 flex flex-col justify-between">
            <div class="space-y-4">
                <h3 class="text-base font-bold text-slate-900 dark:text-white flex items-center gap-2 pb-3 border-b border-slate-100 dark:border-slate-800">
                    <i class="ri-home-wifi-line text-indigo-500"></i> Thông tin thời hạn & Tiền cọc
                </h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="p-4 rounded-2xl bg-slate-50 dark:bg-slate-800/50 border border-slate-100 dark:border-slate-800">
                        <span class="text-xs text-slate-400 font-semibold block">Thời gian thuê dự kiến</span>
                        <div class="text-sm font-bold text-slate-800 dark:text-slate-200 mt-1 flex items-center gap-1.5">
                            <i class="ri-calendar-event-line text-indigo-500"></i>
                            <span>{{ !empty($yeu_cau['ngay_bat_dau']) ? \Carbon\Carbon::parse($yeu_cau['ngay_bat_dau'])->format('d/m/Y') : '--' }}</span>
                            <span class="text-slate-400">→</span>
                            <span>{{ !empty($yeu_cau['ngay_ket_thuc']) ? \Carbon\Carbon::parse($yeu_cau['ngay_ket_thuc'])->format('d/m/Y') : '--' }}</span>
                        </div>
                    </div>

                    <div class="p-4 rounded-2xl bg-slate-50 dark:bg-slate-800/50 border border-slate-100 dark:border-slate-800">
                        <span class="text-xs text-slate-400 font-semibold block">Tiền cọc cam kết</span>
                        <div class="text-lg font-black text-indigo-600 dark:text-indigo-400 mt-0.5">
                            {{ number_format($yeu_cau['tien_coc'] ?? 0, 0, ',', '.') }} ₫
                        </div>
                    </div>
                </div>

                {{-- Ghi chú --}}
                <div class="p-4 rounded-2xl bg-slate-50 dark:bg-slate-800/50 border border-slate-100 dark:border-slate-800">
                    <span class="text-xs text-slate-400 font-semibold block">Ghi chú của khách thuê</span>
                    <p class="text-sm text-slate-700 dark:text-slate-300 mt-1 italic">
                        "{{ $yeu_cau['ghi_chu'] ?? 'Không có ghi chú thêm' }}"
                    </p>
                </div>

                {{-- File đính kèm --}}
                @if(!empty($yeu_cau['file_hop_dong']))
                    <div class="p-4 rounded-2xl bg-indigo-50/50 dark:bg-indigo-950/30 border border-indigo-100 dark:border-indigo-900/50 flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <i class="ri-file-pdf-fill text-2xl text-rose-500"></i>
                            <div>
                                <span class="text-xs font-bold text-slate-800 dark:text-slate-200 block">Tệp tài liệu đính kèm</span>
                                <span class="text-xs text-slate-400">Nhấn xem để duyệt trước tài liệu</span>
                            </div>
                        </div>

                        <button id="btn-open-pdf" data-url="{{ asset('storage/' . $yeu_cau['file_hop_dong']) }}"
                            class="px-3.5 py-1.5 text-xs font-bold text-indigo-600 bg-white dark:bg-slate-800 rounded-xl border border-indigo-200 dark:border-indigo-800 hover:bg-indigo-50 shadow-xs transition">
                            <i class="ri-eye-line"></i> Xem PDF
                        </button>
                    </div>

                    {{-- Modal xem PDF --}}
                    <div id="pdf-modal" class="fixed inset-0 z-50 bg-black/60 backdrop-blur-sm hidden items-center justify-center p-4">
                        <div class="bg-white dark:bg-slate-900 w-full max-w-4xl h-[85vh] rounded-3xl overflow-hidden shadow-2xl flex flex-col">
                            <div class="p-4 border-b border-slate-100 dark:border-slate-800 flex items-center justify-between bg-slate-50 dark:bg-slate-800/50">
                                <h4 class="font-bold text-sm text-slate-900 dark:text-white flex items-center gap-2">
                                    <i class="ri-file-pdf-line text-rose-500"></i> Xem tệp đính kèm
                                </h4>
                                <button id="btn-close-pdf" class="w-8 h-8 rounded-full hover:bg-slate-200 dark:hover:bg-slate-700 text-slate-500 flex items-center justify-center transition">
                                    <i class="ri-close-line text-lg"></i>
                                </button>
                            </div>
                            <iframe id="pdf-frame" src="" class="w-full flex-1"></iframe>
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
            </div>

            {{-- Thao tác duyệt --}}
            <div class="pt-4 border-t border-slate-100 dark:border-slate-800 flex items-center justify-end gap-3">
                @if(($yeu_cau['trang_thai'] ?? '') === 'cho_duyet')
                    <form action="{{ route('chu-tro.yeu-cau-thue.tu-choi', $yeu_cau['id']) }}" method="POST" class="inline">
                        @csrf
                        <button type="submit"
                            class="px-5 py-2.5 rounded-xl border border-rose-200 dark:border-rose-800 text-rose-600 dark:text-rose-400 hover:bg-rose-50 dark:hover:bg-rose-950/40 text-xs font-bold transition"
                            onclick="return confirm('Bạn có chắc chắn muốn từ chối yêu cầu thuê này?')">
                            <i class="ri-close-line"></i> Từ chối yêu cầu
                        </button>
                    </form>

                    <form action="{{ route('chu-tro.yeu-cau-thue.chap-nhan', $yeu_cau['id']) }}" method="POST" class="inline">
                        @csrf
                        <button type="submit"
                            class="px-6 py-2.5 rounded-xl bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 text-white text-xs font-bold shadow-lg shadow-emerald-500/20 transition flex items-center gap-2"
                            onclick="return confirm('Bạn có chắc chắn muốn chấp nhận và khởi tạo hợp đồng cho khách thuê này?')">
                            <i class="ri-check-line text-sm"></i> Chấp nhận & Tạo hợp đồng
                        </button>
                    </form>
                @elseif(($yeu_cau['trang_thai'] ?? '') === 'chap_nhan')
                    <span class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-sky-50 dark:bg-sky-950/40 text-sky-600 dark:text-sky-400 text-xs font-bold border border-sky-200 dark:border-sky-800">
                        <i class="ri-check-double-line"></i> Đã chấp nhận — Đang chờ lập hợp đồng
                    </span>
                @elseif(($yeu_cau['trang_thai'] ?? '') === 'da_tao_hop_dong')
                    <span class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-emerald-50 dark:bg-emerald-950/40 text-emerald-600 dark:text-emerald-400 text-xs font-bold border border-emerald-200 dark:border-emerald-800">
                        <i class="ri-checkbox-circle-line"></i> Đã hoàn tất tạo hợp đồng
                    </span>
                @elseif(($yeu_cau['trang_thai'] ?? '') === 'tu_choi')
                    <span class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-rose-50 dark:bg-rose-950/40 text-rose-600 dark:text-rose-400 text-xs font-bold border border-rose-200 dark:border-rose-800">
                        <i class="ri-close-circle-line"></i> Yêu cầu đã bị từ chối
                    </span>
                @endif
            </div>
        </div>

    </div>
</div>
@endsection