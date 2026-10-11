@extends('layouts.chu-tro')

@section('title', 'Thông Báo Của Bạn - Hệ Thống Trọ')

@section('content')
<div class="max-w-4xl mx-auto space-y-8 animate-fade-in">
    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-sky-100 dark:bg-sky-950 text-sky-700 dark:text-sky-300 mb-2">
                <i class="ri-notification-3-line"></i> Trung Tâm Thông Báo
            </div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 dark:text-white tracking-tight">
                Thông Báo Hoạt Động
            </h1>
            <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 mt-1">
                Cập nhật thông tin yêu cầu thuê phòng, hóa đơn thanh toán và các sự kiện hệ thống
            </p>
        </div>

        <div class="flex flex-wrap items-center gap-2">
            @if ($thong_bao->where('da_xem', 0)->count() > 0)
                <button id="mark-all-read" onclick="markAllAsRead()"
                    class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-sky-50 dark:bg-sky-950/60 border border-sky-200 dark:border-sky-800 text-sky-700 dark:text-sky-300 hover:bg-sky-100 text-xs font-bold transition shadow-xs">
                    <i class="ri-check-double-line"></i>
                    <span>Đánh dấu đã đọc</span>
                </button>
            @endif

            @if ($thong_bao->where('da_xem', 1)->count() > 0)
                <button id="delete-read"
                    class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-rose-50 dark:bg-rose-950/60 border border-rose-200 dark:border-rose-800 text-rose-700 dark:text-rose-300 hover:bg-rose-100 text-xs font-bold transition shadow-xs">
                    <i class="ri-delete-bin-line"></i>
                    <span>Xóa tin đã đọc</span>
                </button>
            @endif

            <a href="{{ route('chu-tro.dashboard') }}"
                class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-white dark:bg-slate-800 border border-slate-200/80 dark:border-slate-700 hover:bg-slate-50 text-slate-700 dark:text-slate-200 text-xs font-bold shadow-xs transition">
                <i class="ri-arrow-left-line"></i>
                <span>Bảng điều khiển</span>
            </a>
        </div>
    </div>

    {{-- Danh sách thông báo --}}
    <div class="bg-white dark:bg-slate-800 rounded-3xl border border-slate-200/80 dark:border-slate-700 shadow-sm overflow-hidden">
        @if ($thong_bao->isEmpty())
            <div class="p-12 text-center text-slate-400 space-y-3">
                <div class="w-16 h-16 rounded-full bg-slate-100 dark:bg-slate-700/60 flex items-center justify-center text-2xl mx-auto text-slate-400">
                    <i class="ri-inbox-line"></i>
                </div>
                <h3 class="text-sm font-bold text-slate-700 dark:text-slate-300">Không có thông báo nào</h3>
                <p class="text-xs text-slate-400 max-w-sm mx-auto">Tất cả các thông báo mới về yêu cầu thuê, hợp đồng và hóa đơn sẽ hiển thị tại đây.</p>
            </div>
        @else
            <div class="divide-y divide-slate-100 dark:divide-slate-700/60">
                @foreach($thong_bao as $tb)
                    <div onclick="markAsRead({{ $tb->id }}, '{{ $tb->lien_ket ?? '#' }}')"
                        class="block p-4 sm:p-5 text-sm cursor-pointer transition relative group {{ $tb->da_xem ? 'bg-white dark:bg-slate-800 opacity-60 hover:opacity-100' : 'bg-sky-50/40 dark:bg-sky-950/20 font-semibold hover:bg-sky-50 dark:hover:bg-sky-950/40' }}">
                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 rounded-2xl flex items-center justify-center text-lg shrink-0 {{ $tb->da_xem ? 'bg-slate-100 dark:bg-slate-700 text-slate-400' : 'bg-sky-600 text-white shadow-md shadow-sky-600/25' }}">
                                <i class="ri-notification-3-line"></i>
                            </div>

                            <div class="flex-1 min-w-0 pr-12">
                                <p class="text-xs sm:text-sm text-slate-800 dark:text-slate-200 leading-snug">
                                    {{ $tb->noi_dung }}
                                </p>
                                <p class="text-[11px] text-slate-400 mt-1 flex items-center gap-1 font-normal">
                                    <i class="ri-time-line"></i>
                                    <span>{{ \Carbon\Carbon::parse($tb->ngay_tao)->diffForHumans() }}</span>
                                </p>
                            </div>
                        </div>

                        {{-- Tag Mới / Đã xem --}}
                        <div class="absolute top-4 right-4">
                            @if(!$tb->da_xem)
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-sky-600 text-white shadow-xs">
                                    Mới
                                </span>
                            @else
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-medium bg-slate-100 dark:bg-slate-700 text-slate-500">
                                    Đã xem
                                </span>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>

{{-- Script --}}
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function markAsRead(id, link) {
        fetch(`/chu-tro/thong-bao/${id}/mark-as-read`, {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
                "Accept": "application/json"
            }
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                const badge = document.querySelector(
                    '.absolute.-top-1.-right-1.bg-rose-500.text-white.text-xs.w-4.h-4.flex.items-center.justify-center.rounded-full:last-of-type'
                );
                if (badge) {
                    let current = parseInt(badge.textContent || "0");
                    if (current > 1) badge.textContent = current - 1;
                    else badge.remove();
                }

                setTimeout(() => {
                    if (link && link !== '#') window.location.href = link;
                }, 150);
            }
        })
        .catch(() => {
            if (link && link !== '#') window.location.href = link;
        });
    }

    function markAllAsRead() {
        fetch(`/chu-tro/thong-bao/mark-all-read`, {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
                "Accept": "application/json"
            }
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Đã đánh dấu tất cả!',
                    text: 'Tất cả thông báo đã được chuyển thành đã xem.',
                    timer: 1500,
                    showConfirmButton: false
                });

                document.querySelectorAll('.block.p-4').forEach(div => {
                    div.classList.remove('bg-sky-50/40', 'dark:bg-sky-950/20', 'font-semibold');
                    div.classList.add('bg-white', 'dark:bg-slate-800', 'opacity-60');
                });

                const btn = document.getElementById('mark-all-read');
                if (btn) btn.style.display = 'none';
            }
        })
        .catch(() => {
            Swal.fire('Lỗi!', 'Không thể đánh dấu tất cả đã xem.', 'error');
        });
    }

    function xoaThongBaoDaDoc() {
        Swal.fire({
            icon: 'warning',
            title: 'Xóa tất cả thông báo đã đọc?',
            text: 'Hành động này sẽ xóa các thông báo đã xem.',
            showCancelButton: true,
            confirmButtonText: 'Đồng ý xóa',
            cancelButtonText: 'Hủy bỏ',
            confirmButtonColor: '#e11d48'
        }).then(result => {
            if (!result.isConfirmed) return;

            fetch(`{{ route('chu-tro.thong-bao.xoa-da-doc') }}`, {
                method: "DELETE",
                headers: {
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
                    "Accept": "application/json"
                }
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Đã xóa!',
                        text: data.message,
                        timer: 1800,
                        showConfirmButton: false
                    });
                    setTimeout(() => window.location.reload(), 1000);
                } else {
                    Swal.fire('Lỗi!', data.message || 'Không thể xóa thông báo.', 'error');
                }
            })
            .catch(err => {
                Swal.fire('Lỗi!', 'Không thể kết nối máy chủ.', 'error');
            });
        });
    }

    document.addEventListener('DOMContentLoaded', () => {
        const btn = document.getElementById('delete-read');
        if (btn) btn.addEventListener('click', xoaThongBaoDaDoc);
    });
</script>
@endpush
@endsection