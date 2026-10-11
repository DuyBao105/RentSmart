@extends('layouts.chu-tro')

@section('title', 'Quản lý Dịch vụ - Hệ Thống Trọ')

@section('content')
<div x-data="{ search: '' }" class="max-w-7xl mx-auto space-y-8 animate-fade-in">
    {{-- Tabs chuyển đổi cấu hình dịch vụ & tiện ích --}}
    <div class="flex items-center gap-2 border-b border-slate-200/80 dark:border-slate-700/80 pb-4 overflow-x-auto">
        <a href="{{ route('chu-tro.dich-vu.index') }}"
            class="px-4 py-2 rounded-xl text-xs sm:text-sm font-bold transition flex items-center gap-1.5 {{ request()->is('chu-tro/dich-vu') ? 'bg-sky-600 text-white shadow-md shadow-sky-600/20' : 'bg-white dark:bg-slate-800 text-slate-600 dark:text-slate-300 hover:bg-slate-50 border border-slate-200/60 dark:border-slate-700' }}">
            <i class="ri-service-line text-base"></i>
            <span>Dịch vụ cơ sở</span>
        </a>
        <a href="{{ route('chu-tro.dichvu-dinhky.index') }}"
            class="px-4 py-2 rounded-xl text-xs sm:text-sm font-bold transition flex items-center gap-1.5 {{ request()->is('chu-tro/dich-vu-dinh-ky*') ? 'bg-sky-600 text-white shadow-md shadow-sky-600/20' : 'bg-white dark:bg-slate-800 text-slate-600 dark:text-slate-300 hover:bg-slate-50 border border-slate-200/60 dark:border-slate-700' }}">
            <i class="ri-repeat-line text-base"></i>
            <span>Dịch vụ định kỳ phòng</span>
        </a>
        <a href="{{ route('chu-tro.tien-ich.index') }}"
            class="px-4 py-2 rounded-xl text-xs sm:text-sm font-bold transition flex items-center gap-1.5 {{ request()->is('chu-tro/tien-ich*') ? 'bg-sky-600 text-white shadow-md shadow-sky-600/20' : 'bg-white dark:bg-slate-800 text-slate-600 dark:text-slate-300 hover:bg-slate-50 border border-slate-200/60 dark:border-slate-700' }}">
            <i class="ri-sparkling-line text-base"></i>
            <span>Tiện ích trang bị</span>
        </a>
    </div>

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-sky-100 dark:bg-sky-950 text-sky-700 dark:text-sky-300 mb-2">
                <i class="ri-settings-4-line"></i> Danh Mục Dịch Vụ
            </div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 dark:text-white tracking-tight">
                Quản Lý Dịch Vụ Cung Cấp
            </h1>
            <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 mt-1">
                Khai báo và điều chỉnh đơn giá điện, nước, internet, rác và các chi phí sinh hoạt định kỳ
            </p>
        </div>

        <div class="flex flex-col sm:flex-row gap-3 sm:items-center">
            <div class="relative">
                <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                    <i class="ri-search-line"></i>
                </span>
                <input type="text" x-model="search" placeholder="Tìm theo tên dịch vụ..."
                    class="pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-xs sm:text-sm text-slate-900 dark:text-white placeholder-slate-400 focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 transition w-full sm:w-64" />
            </div>

            <a href="{{ route('chu-tro.dich-vu.create') }}"
                class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl bg-gradient-to-r from-sky-600 to-sky-500 hover:from-sky-700 hover:to-sky-600 text-white font-bold text-xs sm:text-sm shadow-lg shadow-sky-500/25 transition shrink-0">
                <i class="ri-add-line text-base"></i>
                <span>Thêm dịch vụ</span>
            </a>
        </div>
    </div>

    {{-- Bảng dịch vụ --}}
    <div class="bg-white dark:bg-slate-800 rounded-3xl border border-slate-200/80 dark:border-slate-700 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/80 dark:bg-slate-900/50 border-b border-slate-200/80 dark:border-slate-700 text-[11px] font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">
                        <th class="py-4 px-4 text-center w-12">#</th>
                        <th class="py-4 px-5">Mã DV</th>
                        <th class="py-4 px-5">Tên dịch vụ</th>
                        <th class="py-4 px-4">Đơn vị tính</th>
                        <th class="py-4 px-5 text-right">Đơn giá</th>
                        <th class="py-4 px-4 text-center">Đo đồng hồ</th>
                        <th class="py-4 px-5 text-center">Thao tác</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-700/60 text-xs sm:text-sm text-slate-700 dark:text-slate-300">
                    @forelse($dich_vus as $index => $dv)
                        <tr x-show="!search || {{ json_encode(strtolower($dv->ten)) }}.includes(search.toLowerCase())"
                            class="hover:bg-slate-50/70 dark:hover:bg-slate-700/30 transition">
                            <td class="py-4 px-4 text-center font-bold text-slate-400 text-xs">{{ $index + 1 }}</td>
                            <td class="py-4 px-5 font-mono text-xs font-bold text-slate-600 dark:text-slate-400">
                                <span class="px-2 py-0.5 rounded-lg bg-slate-100 dark:bg-slate-700">{{ $dv->ma }}</span>
                            </td>
                            <td class="py-4 px-5 font-bold text-slate-900 dark:text-white">
                                {{ $dv->ten }}
                            </td>
                            <td class="py-4 px-4">
                                <span class="font-semibold text-slate-700 dark:text-slate-300">{{ $dv->don_vi }}</span>
                                @if(strtolower($dv->don_vi) == 'kwh')
                                    <span class="text-[11px] text-slate-400 block">(Điện)</span>
                                @elseif(strtolower($dv->don_vi) == 'm3' || strtolower($dv->don_vi) == 'm³')
                                    <span class="text-[11px] text-slate-400 block">(Nước sinh hoạt)</span>
                                @elseif(strtolower($dv->don_vi) == 'tháng')
                                    <span class="text-[11px] text-slate-400 block">(Định kỳ tháng)</span>
                                @endif
                            </td>
                            <td class="py-4 px-5 text-right font-black text-emerald-600 dark:text-emerald-400">
                                {{ number_format($dv->don_gia, 0, ',', '.') }} <span class="text-[11px] font-normal text-slate-400">đ</span>
                            </td>
                            <td class="py-4 px-4 text-center">
                                @if($dv->co_dong_ho)
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-700 dark:bg-emerald-950/60 dark:text-emerald-400">
                                        <i class="ri-speed-up-line"></i> Có đồng hồ
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold bg-slate-100 text-slate-600 dark:bg-slate-700/60 dark:text-slate-400">
                                        Cố định
                                    </span>
                                @endif
                            </td>
                            <td class="py-4 px-5 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('chu-tro.dich-vu.edit', $dv->id) }}"
                                        class="p-2 rounded-xl bg-amber-50 dark:bg-amber-950/60 text-amber-600 dark:text-amber-400 hover:bg-amber-100 transition"
                                        title="Chỉnh sửa dịch vụ">
                                        <i class="ri-edit-2-line text-base"></i>
                                    </a>

                                    <form action="{{ route('chu-tro.dich-vu.destroy', $dv->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button"
                                            class="delete-btn p-2 rounded-xl bg-rose-50 dark:bg-rose-950/60 text-rose-600 dark:text-rose-400 hover:bg-rose-100 transition"
                                            title="Xóa dịch vụ">
                                            <i class="ri-delete-bin-6-line text-base"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-12 text-slate-400 text-xs">
                                Chưa có dịch vụ nào được thêm vào hệ thống.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const deleteButtons = document.querySelectorAll('.delete-btn');
        deleteButtons.forEach(btn => {
            btn.addEventListener('click', async (e) => {
                e.preventDefault();
                const form = btn.closest('form');

                const result = await Swal.fire({
                    title: 'Xác nhận xóa dịch vụ?',
                    text: 'Bạn có chắc chắn muốn xóa dịch vụ này khỏi danh mục?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#e11d48',
                    cancelButtonColor: '#64748b',
                    confirmButtonText: 'Đồng ý xóa',
                    cancelButtonText: 'Hủy bỏ',
                });

                if (result.isConfirmed) form.submit();
            });
        });

        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Thành công!',
                text: '{{ session('success') }}',
                confirmButtonColor: '#0284c7',
            });
        @elseif(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Lỗi!',
                text: '{{ session('error') }}',
                confirmButtonColor: '#e11d48',
            });
        @endif
    });
</script>
@endsection