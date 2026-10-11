@extends('layouts.tenant-layout')

@section('title', 'Thông báo từ chủ nhà — Khách thuê')
@section('page_title', 'Trung tâm thông báo từ chủ nhà')
@section('page_subtitle', 'Cập nhật kịp thời tin tức khu trọ, nhắc nhở hóa đơn, thông báo bảo trì và nội quy sinh hoạt')

@section('tenant_content')
@php
    $collection = collect($thongBao ?? []);
    $totalCount = $collection->count();
    $soChuaDoc = $collection->where('da_xem', 0)->count();
    $soDaDoc   = $collection->where('da_xem', 1)->count();
@endphp

<div x-data="{ activeTab: 'all' }" class="space-y-6">

    {{-- TOP ACTION & KPI SUMMARY --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-2 border-b border-[#E5E3DC] dark:border-[#282D2A]">
        <div>
            <h2 class="text-xl sm:text-2xl font-serif font-bold text-[#171A19] dark:text-white tracking-tight">
                Hộp Thư Thông Báo Cư Dân
            </h2>
            <p class="text-xs sm:text-sm text-[#5A605B] dark:text-[#9EA39E] mt-1 font-sans">
                Bạn có <span class="font-bold text-[#1B3D2F] dark:text-[#A3E635]">{{ $soChuaDoc }}</span> thông báo mới chưa xem
            </p>
        </div>

        <div class="flex items-center gap-2">
            @if ($soChuaDoc > 0)
                <button type="button" id="mark-all-read" onclick="markAllAsRead()"
                    class="px-4 py-2 rounded-xl bg-[#1B3D2F] hover:bg-[#244B3B] text-white text-xs font-semibold transition flex items-center gap-1.5 shadow-xs">
                    <i class="ri-check-double-line"></i> Đánh dấu đã đọc
                </button>
            @endif

            @if ($soDaDoc > 0)
                <button type="button" id="delete-read"
                    class="px-4 py-2 rounded-xl border border-[#E5E3DC] dark:border-[#2D332F] bg-white dark:bg-[#1E2320] hover:bg-[#FAF9F6] text-[#5A605B] dark:text-[#9EA39E] text-xs font-medium transition flex items-center gap-1.5">
                    <i class="ri-delete-bin-line"></i> Dọn thông báo cũ
                </button>
            @endif
        </div>
    </div>

    {{-- STATS GRID --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
        <div class="bg-white dark:bg-[#1E2320] rounded-2xl p-5 border border-[#E5E3DC] dark:border-[#2D332F] shadow-sm flex items-center justify-between">
            <div>
                <span class="text-[11px] font-bold uppercase tracking-wider text-[#5A605B] dark:text-[#9EA39E] block mb-1">Tổng thông báo</span>
                <p class="text-2xl sm:text-3xl font-serif font-bold text-[#171A19] dark:text-white">{{ $totalCount }}</p>
            </div>
            <div class="w-11 h-11 rounded-xl bg-[#FAF9F6] dark:bg-[#282D2A] border border-[#E5E3DC] dark:border-[#343B36] text-[#171A19] dark:text-white flex items-center justify-center text-xl">
                <i class="ri-notification-3-line"></i>
            </div>
        </div>

        <div class="bg-white dark:bg-[#1E2320] rounded-2xl p-5 border border-amber-200/80 dark:border-amber-900/40 shadow-sm flex items-center justify-between">
            <div>
                <span class="text-[11px] font-bold uppercase tracking-wider text-amber-700 dark:text-amber-400 block mb-1">Chưa đọc</span>
                <p class="text-2xl sm:text-3xl font-serif font-bold text-amber-600 dark:text-amber-400">{{ $soChuaDoc }}</p>
            </div>
            <div class="w-11 h-11 rounded-xl bg-amber-50 dark:bg-amber-950/60 text-amber-600 flex items-center justify-center text-xl">
                <i class="ri-mail-unread-line"></i>
            </div>
        </div>

        <div class="bg-white dark:bg-[#1E2320] rounded-2xl p-5 border border-[#E5E3DC] dark:border-[#2D332F] shadow-sm flex items-center justify-between">
            <div>
                <span class="text-[11px] font-bold uppercase tracking-wider text-[#5A605B] dark:text-[#9EA39E] block mb-1">Đã xem</span>
                <p class="text-2xl sm:text-3xl font-serif font-bold text-[#5A605B] dark:text-[#9EA39E]">{{ $soDaDoc }}</p>
            </div>
            <div class="w-11 h-11 rounded-xl bg-[#FAF9F6] dark:bg-[#282D2A] text-gray-400 flex items-center justify-center text-xl">
                <i class="ri-mail-open-line"></i>
            </div>
        </div>
    </div>

    {{-- FILTER TABS --}}
    <div class="flex items-center gap-2 overflow-x-auto pb-1 sm:pb-0 scrollbar-none">
        <button type="button" @click="activeTab = 'all'"
            :class="activeTab === 'all' ? 'bg-[#1B3D2F] text-white font-semibold' : 'bg-white dark:bg-[#1E2320] text-[#5A605B] dark:text-[#9EA39E] border border-[#E5E3DC] dark:border-[#2D332F] hover:bg-[#FAF9F6]'"
            class="px-4 py-2 rounded-xl text-xs whitespace-nowrap transition shadow-xs">
            Tất cả thông báo ({{ $totalCount }})
        </button>
        <button type="button" @click="activeTab = 'unread'"
            :class="activeTab === 'unread' ? 'bg-amber-600 text-white font-semibold' : 'bg-white dark:bg-[#1E2320] text-[#5A605B] dark:text-[#9EA39E] border border-[#E5E3DC] dark:border-[#2D332F] hover:bg-[#FAF9F6]'"
            class="px-4 py-2 rounded-xl text-xs whitespace-nowrap transition">
            Chưa đọc ({{ $soChuaDoc }})
        </button>
        <button type="button" @click="activeTab = 'read'"
            :class="activeTab === 'read' ? 'bg-[#282D2A] text-white font-semibold' : 'bg-white dark:bg-[#1E2320] text-[#5A605B] dark:text-[#9EA39E] border border-[#E5E3DC] dark:border-[#2D332F] hover:bg-[#FAF9F6]'"
            class="px-4 py-2 rounded-xl text-xs whitespace-nowrap transition">
            Đã xem ({{ $soDaDoc }})
        </button>
    </div>

    {{-- NOTIFICATIONS FEED --}}
    @if(empty($thongBao) || count($thongBao) === 0)
        <div class="bg-white dark:bg-[#1E2320] rounded-3xl p-12 border border-dashed border-[#E5E3DC] dark:border-[#2D332F] text-center space-y-4">
            <div class="w-16 h-16 rounded-2xl bg-[#1B3D2F]/10 dark:bg-[#244B3B]/40 text-[#1B3D2F] dark:text-[#A3E635] flex items-center justify-center text-3xl mx-auto">
                <i class="ri-notification-off-line"></i>
            </div>
            <div class="space-y-1">
                <h3 class="text-base font-serif font-bold text-[#171A19] dark:text-white">Bạn chưa có thông báo nào</h3>
                <p class="text-xs sm:text-sm text-[#5A605B] dark:text-[#9EA39E] max-w-md mx-auto">
                    Mọi tin tức cập nhật từ chủ nhà trọ, lịch bảo trì điện nước hoặc thông báo tiền phòng sẽ hiển thị tại đây.
                </p>
            </div>
        </div>
    @else
        <div class="space-y-3.5">
            @foreach ($thongBao as $tb)
                @php
                    $isUnread = ($tb['da_xem'] ?? 0) == 0;
                    $content = $tb['noi_dung'] ?? '';
                    $lowerContent = mb_strtolower($content);

                    $iconClass = 'ri-notification-3-line text-[#1B3D2F] bg-[#1B3D2F]/10 dark:text-[#A3E635] dark:bg-[#244B3B]/40';
                    if (str_contains($lowerContent, 'tiền') || str_contains($lowerContent, 'hóa đơn') || str_contains($lowerContent, 'thanh toán')) {
                        $iconClass = 'ri-bill-line text-amber-600 bg-amber-50 dark:bg-amber-950/60';
                    } elseif (str_contains($lowerContent, 'hợp đồng') || str_contains($lowerContent, 'yêu cầu')) {
                        $iconClass = 'ri-file-shield-line text-emerald-600 bg-emerald-50 dark:bg-emerald-950/60';
                    } elseif (str_contains($lowerContent, 'điện') || str_contains($lowerContent, 'nước') || str_contains($lowerContent, 'sửa') || str_contains($lowerContent, 'bảo trì')) {
                        $iconClass = 'ri-tools-line text-[#A6824D] bg-[#A6824D]/10';
                    }
                @endphp

                <div x-show="activeTab === 'all' || (activeTab === 'unread' && {{ $isUnread ? 'true' : 'false' }}) || (activeTab === 'read' && {{ !$isUnread ? 'true' : 'false' }})"
                    onclick="markAsRead({{ $tb['id'] }}, '{{ $tb['lien_ket'] ?? '#' }}')"
                    class="group bg-white dark:bg-[#1E2320] rounded-2xl p-4 sm:p-5 border {{ $isUnread ? 'border-[#1B3D2F]/40 dark:border-[#A3E635]/40 ring-1 ring-[#1B3D2F]/10' : 'border-[#E5E3DC] dark:border-[#2D332F]' }} shadow-2xs hover:shadow-sm transition cursor-pointer flex items-start gap-3.5">

                    {{-- Icon avatar --}}
                    <div class="w-11 h-11 rounded-xl flex items-center justify-center text-xl shrink-0 {{ $iconClass }}">
                        <i class="{{ explode(' ', $iconClass)[0] }}"></i>
                    </div>

                    {{-- Text content --}}
                    <div class="min-w-0 flex-1 space-y-1">
                        <div class="flex items-center justify-between gap-2">
                            <h4 class="text-sm font-serif font-bold text-[#171A19] dark:text-white">
                                {{ $tb['tieu_de'] ?? 'Thông báo từ chủ nhà' }}
                            </h4>

                            <div class="flex items-center gap-2 shrink-0">
                                @if($isUnread)
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-[#1B3D2F] text-white dark:bg-[#A3E635] dark:text-[#171A19] uppercase tracking-wider">
                                        MỚI
                                    </span>
                                @else
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-medium bg-[#FAF9F6] dark:bg-[#282D2A] text-[#5A605B] dark:text-[#9EA39E]">
                                        Đã đọc
                                    </span>
                                @endif
                            </div>
                        </div>

                        <p class="text-xs sm:text-sm text-[#5A605B] dark:text-[#9EA39E] leading-relaxed">
                            {{ $tb['noi_dung'] ?? '(Không có nội dung)' }}
                        </p>

                        <div class="flex items-center justify-between text-xs text-[#5A605B] dark:text-[#9EA39E] pt-2 border-t border-[#E5E3DC] dark:border-[#282D2A]">
                            <span class="flex items-center gap-1.5 text-[11px]">
                                <i class="ri-time-line"></i>
                                {{ \Carbon\Carbon::parse($tb['ngay_tao'])->diffForHumans() }}
                            </span>

                            @if(!empty($tb['lien_ket']))
                                <span class="text-[#1B3D2F] dark:text-[#A3E635] font-semibold group-hover:underline flex items-center gap-1 text-[11px]">
                                    <span>Xem chi tiết liên kết</span> &rarr;
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

</div>
@endsection

@push('scripts')
<script>
    function setBellCount(newCount) {
        const badge = document.getElementById('tenant-bell-badge');
        const icon  = document.getElementById('tenant-bell-icon');

        if (newCount <= 0) {
            if (badge) badge.remove();
            if (icon) icon.classList.remove('tenant-bell-ring');
            return;
        }

        let b = badge;
        if (!b) {
            const btn = document.getElementById('tenant-bell-btn');
            if (!btn) return;
            b = document.createElement('span');
            b.id = "tenant-bell-badge";
            b.className = "absolute -top-1 -right-1 bg-[#1B3D2F] text-white text-[10px] font-bold w-5 h-5 rounded-full flex items-center justify-center shadow-md";
            btn.appendChild(b);
        }

        b.dataset.count = newCount;
        b.textContent = newCount > 99 ? "99+" : newCount;
        if (icon && !icon.classList.contains('tenant-bell-ring')) {
            icon.classList.add('tenant-bell-ring');
        }
    }

    function decreaseBellCount(delta = 1) {
        const badge = document.getElementById('tenant-bell-badge');
        if (!badge) return;
        let current = parseInt(badge.dataset.count || badge.textContent || "0", 10);
        setBellCount(current - delta);
    }

    function markAsRead(id, link) {
        fetch(`/khach-thue/thong-bao/${id}/mark-as-read`, {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
                "Accept": "application/json"
            }
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                decreaseBellCount(1);
            }
            if (link && link !== '#') {
                setTimeout(() => { window.location.href = link; }, 120);
            } else {
                window.location.reload();
            }
        })
        .catch(() => {
            if (link && link !== '#') window.location.href = link;
        });
    }

    function markAllAsRead() {
        fetch(`/khach-thue/thong-bao/mark-all-read`, {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
                "Accept": "application/json"
            }
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                setBellCount(0);
                Swal.fire({
                    icon: 'success',
                    title: 'Đã hoàn tất!',
                    text: 'Tất cả thông báo đã được đánh dấu là đã đọc.',
                    timer: 1500,
                    showConfirmButton: false
                }).then(() => window.location.reload());
            }
        });
    }

    document.addEventListener('DOMContentLoaded', () => {
        const deleteBtn = document.getElementById('delete-read');
        if (deleteBtn) {
            deleteBtn.addEventListener('click', () => {
                Swal.fire({
                    icon: 'warning',
                    title: 'Dọn dẹp thông báo cũ?',
                    text: 'Hành động này sẽ xóa các thông báo bạn đã xem.',
                    showCancelButton: true,
                    confirmButtonText: 'Đồng ý xóa',
                    cancelButtonText: 'Hủy',
                    confirmButtonColor: '#e11d48'
                }).then(res => {
                    if (!res.isConfirmed) return;
                    fetch(`{{ route('khach-thue.thong-bao.xoa-da-doc') }}`, {
                        method: "DELETE",
                        headers: {
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
                            "Accept": "application/json"
                        }
                    })
                    .then(r => r.json())
                    .then(d => {
                        if (d.success) {
                            Swal.fire('Thành công', d.message, 'success')
                                .then(() => window.location.reload());
                        }
                    });
                });
            });
        }
    });
</script>
@endpush
