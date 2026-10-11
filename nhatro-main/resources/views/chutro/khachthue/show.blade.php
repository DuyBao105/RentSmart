@extends('layouts.chu-tro')
@section('title', 'Chi tiết khách thuê')

@section('content')
<div class="max-w-6xl mx-auto space-y-6">

    {{-- 🔹 Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-indigo-50 dark:bg-indigo-950/60 text-indigo-600 dark:text-indigo-400 text-xs font-semibold uppercase tracking-wider mb-2 border border-indigo-100 dark:border-indigo-900/50">
                <i class="ri-user-search-line"></i> Hồ sơ cư dân
            </div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 dark:text-white tracking-tight flex items-center gap-2.5">
                <span class="w-2.5 h-8 bg-gradient-to-b from-indigo-500 to-sky-500 rounded-full inline-block"></span>
                {{ $khach_thue['ho_ten'] }}
            </h1>
            <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">
                Xem toàn bộ hồ sơ cá nhân và lịch sử hợp đồng thuê trọ
            </p>
        </div>

        <div class="flex items-center gap-3">
            <a href="{{ route('chu-tro.khachthue.index') }}"
                class="inline-flex items-center gap-2 px-4 py-2 text-sm font-semibold text-slate-600 dark:text-slate-300 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl hover:bg-slate-50 dark:hover:bg-slate-700/60 shadow-sm transition">
                <i class="ri-arrow-left-line"></i> Quay lại
            </a>

            <a href="{{ route('chu-tro.khachthue.edit', $khach_thue['id']) }}"
                class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-600 hover:to-amber-700 text-white rounded-xl text-sm font-semibold shadow-md shadow-amber-500/20 transition">
                <i class="ri-pencil-line"></i> Chỉnh sửa
            </a>
        </div>
    </div>

    {{-- 🔹 2-Column Grid Layout --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Cột 1: Thẻ thông tin cá nhân --}}
        <div class="lg:col-span-1 bg-white dark:bg-slate-900 p-6 rounded-3xl border border-slate-200/80 dark:border-slate-800 shadow-sm space-y-6">
            <div class="flex flex-col items-center text-center pb-6 border-b border-slate-100 dark:border-slate-800">
                <div class="w-20 h-20 rounded-2xl bg-gradient-to-tr from-indigo-500 via-indigo-600 to-sky-400 text-white flex items-center justify-center font-black text-2xl shadow-lg shadow-indigo-500/25 mb-4">
                    {{ strtoupper(mb_substr($khach_thue['ho_ten'] ?? 'K', 0, 1)) }}
                </div>
                <h3 class="text-lg font-bold text-slate-900 dark:text-white">{{ $khach_thue['ho_ten'] }}</h3>
                <span class="inline-flex items-center gap-1.5 px-3 py-1 mt-2 text-xs font-semibold rounded-full bg-indigo-50 dark:bg-indigo-950/60 text-indigo-600 dark:text-indigo-400 border border-indigo-100 dark:border-indigo-900/50">
                    <i class="ri-user-smile-line"></i> Khách thuê trọ
                </span>
            </div>

            <div class="space-y-4">
                <div>
                    <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Số điện thoại</span>
                    <div class="flex items-center justify-between mt-1">
                        <span class="text-sm font-semibold text-slate-800 dark:text-slate-200">{{ $khach_thue['so_dien_thoai'] ?? '—' }}</span>
                        @if(!empty($khach_thue['so_dien_thoai']))
                            <a href="tel:{{ $khach_thue['so_dien_thoai'] }}" class="text-emerald-500 hover:text-emerald-600 text-sm" title="Gọi điện">
                                <i class="ri-phone-fill"></i>
                            </a>
                        @endif
                    </div>
                </div>

                <div>
                    <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Email</span>
                    <div class="mt-1 text-sm font-medium text-slate-700 dark:text-slate-300 break-all">
                        {{ $khach_thue['email'] ?? '—' }}
                    </div>
                </div>

                <div>
                    <span class="text-xs font-bold uppercase tracking-wider text-slate-400">CCCD / Định danh</span>
                    <div class="mt-1 text-sm font-mono font-medium text-slate-800 dark:text-slate-200">
                        {{ $khach_thue['cccd'] ?? '—' }}
                    </div>
                </div>

                <div>
                    <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Khả năng ngân sách</span>
                    <div class="mt-1 text-sm font-semibold text-indigo-600 dark:text-indigo-400">
                        {{ number_format($khach_thue['ngan_sach_min'] ?? 0, 0, ',', '.') }} ₫ – {{ number_format($khach_thue['ngan_sach_max'] ?? 0, 0, ',', '.') }} ₫
                    </div>
                </div>
            </div>

            <div class="pt-4 border-t border-slate-100 dark:border-slate-800">
                <a href="{{ route('chu-tro.nguoi-than.index', $khach_thue['id']) }}"
                    class="w-full inline-flex items-center justify-center gap-2 py-2.5 px-4 bg-slate-50 dark:bg-slate-800 hover:bg-slate-100 dark:hover:bg-slate-700/60 text-slate-700 dark:text-slate-200 rounded-xl text-xs font-bold border border-slate-200 dark:border-slate-700 transition">
                    <i class="ri-group-line text-indigo-500"></i> Quản lý người thân ở cùng
                </a>
            </div>
        </div>

        {{-- Cột 2: Bảng lịch sử hợp đồng thuê --}}
        <div class="lg:col-span-2 bg-white dark:bg-slate-900 p-6 rounded-3xl border border-slate-200/80 dark:border-slate-800 shadow-sm space-y-4">
            <div class="flex items-center justify-between pb-3 border-b border-slate-100 dark:border-slate-800">
                <h2 class="text-base font-bold text-slate-900 dark:text-white flex items-center gap-2">
                    <i class="ri-file-paper-2-line text-indigo-500"></i> Lịch sử hợp đồng thuê
                </h2>
                <span class="text-xs text-slate-400">{{ count($hop_dong) }} hợp đồng</span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-slate-700 dark:text-slate-300">
                    <thead class="bg-slate-50/80 dark:bg-slate-800/60 border-b border-slate-200/80 dark:border-slate-800 text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">
                        <tr>
                            <th class="py-3 px-4">Phòng / Dãy trọ</th>
                            <th class="py-3 px-4">Thời hạn</th>
                            <th class="py-3 px-4 text-right">Tiền cọc</th>
                            <th class="py-3 px-4 text-center">Trạng thái</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-800/80">
                        @forelse ($hop_dong as $hd)
                            <tr class="hover:bg-slate-50/70 dark:hover:bg-slate-800/40 transition">
                                <td class="py-3.5 px-4">
                                    <div class="font-bold text-slate-900 dark:text-white">
                                        Phòng {{ $hd['so_phong'] }}
                                    </div>
                                    <div class="text-xs text-slate-400">{{ $hd['ten_day_tro'] }}</div>
                                </td>
                                <td class="py-3.5 px-4 text-xs font-mono">
                                    <span class="text-slate-700 dark:text-slate-300">{{ \Carbon\Carbon::parse($hd['ngay_bat_dau'])->format('d/m/Y') }}</span>
                                    <span class="text-slate-400 mx-1">→</span>
                                    <span class="text-slate-700 dark:text-slate-300">{{ \Carbon\Carbon::parse($hd['ngay_ket_thuc'])->format('d/m/Y') }}</span>
                                </td>
                                <td class="py-3.5 px-4 text-right font-semibold text-slate-900 dark:text-white">
                                    {{ number_format($hd['tien_coc'], 0, ',', '.') }} ₫
                                </td>
                                <td class="py-3.5 px-4 text-center">
                                    @php
                                        $hieuLuc = $hd['trang_thai'] == 'hieu_luc';
                                    @endphp
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 text-xs font-semibold rounded-full border {{ $hieuLuc ? 'bg-emerald-50 dark:bg-emerald-950/60 text-emerald-700 dark:text-emerald-400 border-emerald-200 dark:border-emerald-800' : 'bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 border-slate-200 dark:border-slate-700' }}">
                                        <span class="w-1.5 h-1.5 rounded-full bg-current"></span>
                                        {{ ucfirst($hd['trang_thai']) }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-10 text-slate-400 text-xs">
                                    Chưa có hợp đồng thuê nào được ghi nhận.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>
@endsection