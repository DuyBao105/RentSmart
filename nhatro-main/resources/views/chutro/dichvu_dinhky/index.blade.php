@extends('layouts.chu-tro')

@section('title', 'Dịch vụ định kỳ')

@section('content')
<div class="max-w-7xl mx-auto space-y-6">

    {{-- 🔹 Tabs chuyển đổi --}}
    <div class="flex items-center gap-2 p-1 bg-slate-100 dark:bg-slate-800/80 rounded-2xl w-fit border border-slate-200/80 dark:border-slate-700/80">
        <a href="{{ route('chu-tro.dich-vu.index') }}"
            class="px-4 py-2 rounded-xl text-xs font-bold transition flex items-center gap-2
               {{ request()->is('chu-tro/dich-vu') ? 'bg-white dark:bg-slate-900 text-indigo-600 dark:text-indigo-400 shadow-sm' : 'text-slate-500 hover:text-slate-900 dark:hover:text-white' }}">
            <i class="ri-list-settings-line"></i> Bảng giá dịch vụ
        </a>
        <a href="{{ route('chu-tro.dichvu-dinhky.index') }}"
            class="px-4 py-2 rounded-xl text-xs font-bold transition flex items-center gap-2
               {{ request()->is('chu-tro/dich-vu-dinh-ky*') ? 'bg-white dark:bg-slate-900 text-indigo-600 dark:text-indigo-400 shadow-sm' : 'text-slate-500 hover:text-slate-900 dark:hover:text-white' }}">
            <i class="ri-repeat-2-line"></i> Dịch vụ định kỳ theo phòng
        </a>
    </div>

    {{-- 🔹 Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-indigo-50 dark:bg-indigo-950/60 text-indigo-600 dark:text-indigo-400 text-xs font-semibold uppercase tracking-wider mb-2 border border-indigo-100 dark:border-indigo-900/50">
                <i class="ri-repeat-line"></i> Cấu hình hàng tháng
            </div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 dark:text-white tracking-tight flex items-center gap-2.5">
                <span class="w-2.5 h-8 bg-gradient-to-b from-indigo-500 to-sky-500 rounded-full inline-block"></span>
                Dịch vụ định kỳ từng phòng
            </h1>
            <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">
                Xem và thiết lập các khoản phí định kỳ (rác, wifi, thang máy, giữ xe) tự động cộng vào hóa đơn mỗi tháng
            </p>
        </div>

        <a href="{{ route('chu-tro.dashboard') }}"
            class="inline-flex items-center gap-2 px-4 py-2 text-sm font-semibold text-slate-600 dark:text-slate-300 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl hover:bg-slate-50 shadow-sm transition">
            <i class="ri-dashboard-line"></i> Trang tổng quan
        </a>
    </div>

    {{-- 🔹 Bảng danh sách phòng --}}
    <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200/80 dark:border-slate-800 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-700 dark:text-slate-300">
                <thead class="bg-slate-50/80 dark:bg-slate-800/60 border-b border-slate-200/80 dark:border-slate-800 text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">
                    <tr>
                        <th class="py-3.5 px-6">Dãy trọ</th>
                        <th class="py-3.5 px-6">Số phòng</th>
                        <th class="py-3.5 px-6 text-right">Thao tác</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800/80">
                    @forelse ($phongs as $p)
                        <tr class="hover:bg-slate-50/70 dark:hover:bg-slate-800/40 transition">
                            <td class="py-4 px-6 font-bold text-slate-900 dark:text-white">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-8 h-8 rounded-lg bg-sky-50 dark:bg-sky-950/60 text-sky-600 dark:text-sky-400 flex items-center justify-center font-bold text-xs">
                                        <i class="ri-building-line text-sm"></i>
                                    </div>
                                    <span>{{ $p->ten_day_tro }}</span>
                                </div>
                            </td>
                            <td class="py-4 px-6">
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-xl bg-indigo-50 dark:bg-indigo-950/60 text-indigo-700 dark:text-indigo-300 font-bold text-xs border border-indigo-100 dark:border-indigo-900/40">
                                    <i class="ri-door-open-line"></i> Phòng {{ $p->so_phong }}
                                </span>
                            </td>
                            <td class="py-4 px-6 text-right">
                                <a href="{{ route('chu-tro.dichvu-dinhky.show', $p->id) }}"
                                    class="inline-flex items-center gap-1.5 px-4 py-2 bg-indigo-50 dark:bg-indigo-950/50 hover:bg-indigo-600 text-indigo-600 dark:text-indigo-300 hover:text-white rounded-xl text-xs font-bold transition-all shadow-sm">
                                    <i class="ri-settings-3-line"></i> Cấu hình dịch vụ
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center py-12 text-slate-400 text-xs">
                                Không tìm thấy phòng trọ nào thuộc tài khoản của bạn.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection