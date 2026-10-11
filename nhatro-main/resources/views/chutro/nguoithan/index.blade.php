@extends('layouts.chu-tro')

@section('title', 'Quản lý người thân')

@section('content')
<div class="max-w-6xl mx-auto space-y-6">

    {{-- 🔹 Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-indigo-50 dark:bg-indigo-950/60 text-indigo-600 dark:text-indigo-400 text-xs font-semibold uppercase tracking-wider mb-2 border border-indigo-100 dark:border-indigo-900/50">
                <i class="ri-parent-line"></i> Quản lý cư dân ở cùng
            </div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 dark:text-white tracking-tight flex items-center gap-2.5">
                <span class="w-2.5 h-8 bg-gradient-to-b from-indigo-500 to-sky-500 rounded-full inline-block"></span>
                Danh sách người thân sống cùng
            </h1>
            <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">
                Khai báo tạm trú và thông tin liên hệ khẩn cấp của những người cùng thuê phòng
            </p>
        </div>

        <div class="flex items-center gap-3">
            <a href="{{ route('chu-tro.khachthue.show', $khachThueId) }}"
                class="inline-flex items-center gap-2 px-4 py-2 text-sm font-semibold text-slate-600 dark:text-slate-300 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl hover:bg-slate-50 dark:hover:bg-slate-700/60 shadow-sm transition">
                <i class="ri-arrow-left-line"></i> Quay lại khách thuê
            </a>

            <a href="{{ route('chu-tro.nguoi-than.create', $khachThueId) }}"
                class="inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-indigo-600 via-indigo-500 to-sky-500 hover:from-indigo-700 hover:to-sky-600 text-white rounded-xl text-sm font-semibold shadow-lg shadow-indigo-500/20 hover:shadow-indigo-500/30 transition-all">
                <i class="ri-user-add-line text-base"></i> Thêm người thân
            </a>
        </div>
    </div>

    {{-- 🔹 Thông báo --}}
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

    {{-- 🔹 Bảng hiển thị danh sách --}}
    <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200/80 dark:border-slate-800 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-700 dark:text-slate-300">
                <thead class="bg-slate-50/80 dark:bg-slate-800/60 border-b border-slate-200/80 dark:border-slate-800 text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">
                    <tr>
                        <th class="py-3.5 px-4">Họ và tên</th>
                        <th class="py-3.5 px-4">Mối quan hệ</th>
                        <th class="py-3.5 px-4">CCCD / CMND</th>
                        <th class="py-3.5 px-4">Số điện thoại</th>
                        <th class="py-3.5 px-4">Ngày sinh</th>
                        <th class="py-3.5 px-4 text-right">Thao tác</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800/80">
                    @forelse ($nguoiThan as $nt)
                        <tr class="hover:bg-slate-50/70 dark:hover:bg-slate-800/40 transition">
                            <td class="py-4 px-4 font-bold text-slate-900 dark:text-white">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-8 h-8 rounded-lg bg-indigo-50 dark:bg-indigo-950/60 text-indigo-600 dark:text-indigo-400 flex items-center justify-center font-bold text-xs">
                                        {{ strtoupper(mb_substr($nt['ho_ten'] ?? 'N', 0, 1)) }}
                                    </div>
                                    <span>{{ $nt['ho_ten'] }}</span>
                                </div>
                            </td>
                            <td class="py-4 px-4">
                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 text-xs font-medium">
                                    <i class="ri-heart-line text-rose-500"></i> {{ $nt['moi_quan_he'] }}
                                </span>
                            </td>
                            <td class="py-4 px-4 font-mono text-xs text-slate-600 dark:text-slate-400">
                                {{ $nt['so_cccd'] ?? '—' }}
                            </td>
                            <td class="py-4 px-4 text-xs font-medium text-slate-700 dark:text-slate-300">
                                {{ $nt['so_dien_thoai'] ?? '—' }}
                            </td>
                            <td class="py-4 px-4 text-xs text-slate-500">
                                @if (!empty($nt['ngay_sinh']))
                                    {{ \Carbon\Carbon::parse($nt['ngay_sinh'])->format('d/m/Y') }}
                                @else
                                    —
                                @endif
                            </td>
                            <td class="py-4 px-4 text-right">
                                <form action="{{ route('chu-tro.nguoi-than.destroy', [$nt['id'], $khachThueId]) }}"
                                    method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="p-2 text-rose-500 hover:bg-rose-50 dark:hover:bg-rose-950/60 rounded-lg transition"
                                        title="Xóa người thân"
                                        onclick="return confirm('Bạn chắc chắn muốn xóa người này?')">
                                        <i class="ri-delete-bin-line text-lg"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-12 text-slate-400 text-xs">
                                Chưa có người thân nào được thêm cho khách thuê này.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection