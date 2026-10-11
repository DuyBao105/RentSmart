@extends('layouts.chu-tro')

@section('title', 'Danh sách người thân')

@section('content')
<div class="max-w-7xl mx-auto space-y-6">

    {{-- 🔹 Header --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-indigo-50 dark:bg-indigo-950/60 text-indigo-600 dark:text-indigo-400 text-xs font-semibold uppercase tracking-wider mb-2 border border-indigo-100 dark:border-indigo-900/50">
                <i class="ri-parent-line"></i> Người ở cùng
            </div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 dark:text-white tracking-tight flex items-center gap-2.5">
                <span class="w-2.5 h-8 bg-gradient-to-b from-indigo-500 to-sky-500 rounded-full inline-block"></span>
                Danh sách người thân cư trú
            </h1>
            <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">
                Theo dõi và quản lý người thân sống cùng phòng của toàn bộ khách thuê trong hệ thống
            </p>
        </div>

        <div class="flex items-center gap-3">
            <a href="{{ route('chu-tro.khachthue.index') }}"
                class="inline-flex items-center gap-2 px-4 py-2.5 bg-white dark:bg-slate-800 text-slate-700 dark:text-slate-200 border border-slate-200 dark:border-slate-700 hover:border-indigo-300 rounded-xl text-sm font-semibold shadow-sm hover:bg-slate-50 transition-all">
                <i class="ri-user-star-line text-indigo-500"></i> Quản lý khách thuê
            </a>
            <a href="{{ route('chu-tro.dashboard') }}"
                class="inline-flex items-center gap-2 px-4 py-2.5 bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 rounded-xl text-sm font-semibold hover:bg-slate-200 transition">
                <i class="ri-dashboard-line"></i> Bảng điều khiển
            </a>
        </div>
    </div>

    {{-- 🔹 Filter Bar --}}
    @php
        $dsKhach = collect($nguoiThan)
            ->pluck('ten_khach_thue', 'khach_thue_id')
            ->filter()
            ->unique();
    @endphp
    <div class="bg-white/80 dark:bg-slate-900/80 backdrop-blur-xl border border-slate-200/80 dark:border-slate-800 rounded-2xl p-4 shadow-sm flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-3">
        <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 flex-1">
            {{-- Filter Khách thuê --}}
            <div class="relative min-w-[240px]">
                <i class="ri-user-line absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400"></i>
                <select id="filterKhachThue"
                    class="w-full appearance-none pl-10 pr-9 py-2 text-sm bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500/30 focus:border-indigo-500 outline-none transition">
                    <option value="">Tất cả khách thuê</option>
                    @foreach ($dsKhach as $id => $ten)
                        <option value="{{ $id }}">{{ $ten }}</option>
                    @endforeach
                </select>
                <i class="ri-arrow-down-s-line absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none"></i>
            </div>

            {{-- Search Input --}}
            <div class="relative flex-1 max-w-md">
                <i class="ri-search-line absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400"></i>
                <input type="text" id="searchInput"
                    class="w-full pl-10 pr-4 py-2 text-sm bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500/30 focus:border-indigo-500 outline-none transition placeholder-slate-400"
                    placeholder="Tìm theo tên, quan hệ, SĐT...">
            </div>
        </div>

        <div class="text-xs text-slate-500 dark:text-slate-400 flex items-center gap-1.5 font-medium">
            <i class="ri-team-line text-indigo-500"></i>
            <span>Tổng cộng: <strong class="text-indigo-600 dark:text-indigo-400 font-bold">{{ count($nguoiThan) }}</strong> người</span>
        </div>
    </div>

    {{-- 🔹 Flash Session Alerts --}}
    @if (session('success'))
        <div class="p-4 rounded-2xl bg-emerald-50 dark:bg-emerald-950/40 border border-emerald-200 dark:border-emerald-800 text-emerald-800 dark:text-emerald-300 text-sm flex items-center gap-3">
            <i class="ri-checkbox-circle-fill text-lg text-emerald-500"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif
    @if (session('error'))
        <div class="p-4 rounded-2xl bg-rose-50 dark:bg-rose-950/40 border border-rose-200 dark:border-rose-800 text-rose-800 dark:text-rose-300 text-sm flex items-center gap-3">
            <i class="ri-error-warning-fill text-lg text-rose-500"></i>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    {{-- 🔹 Grid Card Container --}}
    <div id="nguoiThanCards" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse ($nguoiThan as $nt)
            <div data-khach="{{ $nt['khach_thue_id'] ?? '' }}"
                class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200/80 dark:border-slate-800 hover:border-indigo-300/80 p-6 flex flex-col justify-between shadow-sm hover:shadow-md transition-all group">
                <div>
                    {{-- Header người thân --}}
                    <div class="flex items-start justify-between gap-3 mb-4">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 rounded-2xl bg-gradient-to-tr from-sky-500 to-indigo-600 text-white font-black text-lg flex items-center justify-center shadow-md shadow-indigo-500/20 flex-shrink-0">
                                {{ strtoupper(mb_substr($nt['ho_ten'] ?? 'N', 0, 1)) }}
                            </div>
                            <div>
                                <h3 class="font-bold text-base text-slate-900 dark:text-white group-hover:text-indigo-600 transition">
                                    {{ $nt['ho_ten'] }}
                                </h3>
                                <span class="inline-flex items-center gap-1 text-xs font-semibold px-2 py-0.5 mt-0.5 rounded-full bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300">
                                    <i class="ri-heart-2-line text-rose-500"></i> {{ $nt['moi_quan_he'] ?? 'Không rõ' }}
                                </span>
                            </div>
                        </div>
                    </div>

                    {{-- Chi tiết --}}
                    <div class="space-y-2 py-3 border-y border-slate-100 dark:border-slate-800/80 text-xs text-slate-600 dark:text-slate-300">
                        <div class="flex items-center justify-between">
                            <span class="text-slate-400 flex items-center gap-1.5"><i class="ri-phone-line text-emerald-500"></i> SĐT:</span>
                            <span class="font-medium text-slate-800 dark:text-slate-200">{{ $nt['so_dien_thoai'] ?? '—' }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-slate-400 flex items-center gap-1.5"><i class="ri-user-follow-line text-indigo-500"></i> Khách thuê chính:</span>
                            <span class="font-semibold text-indigo-600 dark:text-indigo-400 truncate max-w-[150px]">
                                {{ $nt['ten_khach_thue'] ?? ('#' . $nt['khach_thue_id']) }}
                            </span>
                        </div>
                        @if(!empty($nt['so_cccd']))
                        <div class="flex items-center justify-between">
                            <span class="text-slate-400 flex items-center gap-1.5"><i class="ri-fingerprint-line text-slate-400"></i> CCCD:</span>
                            <span class="font-mono text-slate-700 dark:text-slate-300">{{ $nt['so_cccd'] }}</span>
                        </div>
                        @endif
                    </div>
                </div>

                {{-- Action Delete --}}
                @if (!empty($nt['khach_thue_id']))
                    <form action="{{ route('chu-tro.nguoi-than.destroy', [$nt['id'], $nt['khach_thue_id']]) }}" method="POST"
                        onsubmit="return confirm('Bạn có chắc muốn xóa người thân này?')" class="mt-4 pt-2">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="w-full py-2 px-3 text-xs font-semibold text-rose-600 dark:text-rose-400 bg-rose-50 dark:bg-rose-950/40 hover:bg-rose-100 dark:hover:bg-rose-900/60 rounded-xl transition flex items-center justify-center gap-1.5">
                            <i class="ri-delete-bin-line"></i> Xóa người thân
                        </button>
                    </form>
                @endif
            </div>
        @empty
            <div class="col-span-full text-center py-16 bg-white dark:bg-slate-900 rounded-3xl border border-slate-200/80 dark:border-slate-800">
                <div class="w-16 h-16 mx-auto rounded-2xl bg-slate-100 dark:bg-slate-800 text-slate-400 flex items-center justify-center text-3xl mb-3">
                    <i class="ri-group-line"></i>
                </div>
                <h4 class="text-base font-bold text-slate-700 dark:text-slate-300">Không có người thân nào trong hệ thống</h4>
                <p class="text-xs text-slate-400 mt-1">Các người thân sống cùng sẽ hiển thị tại đây khi khách thuê khai báo.</p>
            </div>
        @endforelse
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const searchInput = document.getElementById('searchInput');
        const filterKhach = document.getElementById('filterKhachThue');
        const cards = document.querySelectorAll('#nguoiThanCards > div');

        function filterCards() {
            const text = searchInput.value.toLowerCase().trim();
            const selectedKhach = filterKhach.value;

            cards.forEach(card => {
                const content = card.textContent.toLowerCase();
                const khach = card.dataset.khach;
                const matchText = content.includes(text);
                const matchKhach = selectedKhach === '' || khach === selectedKhach;
                card.style.display = (matchText && matchKhach) ? '' : 'none';
            });
        }

        if (searchInput && filterKhach) {
            searchInput.addEventListener('input', filterCards);
            filterKhach.addEventListener('change', filterCards);
        }
    });
</script>
@endsection
