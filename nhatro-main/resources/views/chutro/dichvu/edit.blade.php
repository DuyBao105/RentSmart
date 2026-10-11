@extends('layouts.chu-tro')

@section('title', 'Cập Nhật Dịch Vụ - Hệ Thống Trọ')

@section('content')
<div class="max-w-3xl mx-auto space-y-8 animate-fade-in">
    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-amber-100 dark:bg-amber-950 text-amber-700 dark:text-amber-300 mb-2">
                <i class="ri-edit-box-line"></i> Điều Chỉnh Dịch Vụ
            </div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 dark:text-white tracking-tight">
                Cập Nhật Dịch Vụ: {{ $dich_vu->ten }}
            </h1>
            <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 mt-1">
                Điều chỉnh mã định danh, đơn vị tính hoặc đơn giá của dịch vụ
            </p>
        </div>

        <a href="{{ route('chu-tro.dich-vu.index') }}"
            class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-white dark:bg-slate-800 border border-slate-200/80 dark:border-slate-700 hover:bg-slate-50 text-slate-700 dark:text-slate-200 text-xs sm:text-sm font-bold shadow-xs transition">
            <i class="ri-arrow-left-line"></i>
            <span>Quay lại danh sách</span>
        </a>
    </div>

    {{-- Form Container --}}
    <div class="bg-white dark:bg-slate-800 rounded-3xl border border-slate-200/80 dark:border-slate-700 shadow-sm p-6 sm:p-8">
        <form id="updateForm" action="{{ route('chu-tro.dich-vu.update', $dich_vu->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            {{-- Mã dịch vụ --}}
            <div class="space-y-2">
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300">
                    Mã dịch vụ <span class="text-rose-500">*</span>
                </label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                        <i class="ri-hashtag text-lg"></i>
                    </span>
                    <input type="text" name="ma" value="{{ $dich_vu->ma }}" required
                        class="w-full pl-10 pr-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-900 text-slate-900 dark:text-white text-sm focus:bg-white dark:focus:bg-slate-900 focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 transition font-mono">
                </div>
            </div>

            {{-- Tên dịch vụ --}}
            <div class="space-y-2">
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300">
                    Tên dịch vụ <span class="text-rose-500">*</span>
                </label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                        <i class="ri-service-line text-lg"></i>
                    </span>
                    <input type="text" name="ten" value="{{ $dich_vu->ten }}" required
                        class="w-full pl-10 pr-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-900 text-slate-900 dark:text-white text-sm focus:bg-white dark:focus:bg-slate-900 focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 transition">
                </div>
            </div>

            {{-- Đơn vị --}}
            <div class="space-y-2">
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300">
                    Đơn vị tính <span class="text-rose-500">*</span>
                </label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                        <i class="ri-scales-line text-lg"></i>
                    </span>
                    <input type="text" name="don_vi" value="{{ $dich_vu->don_vi }}" required
                        class="w-full pl-10 pr-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-900 text-slate-900 dark:text-white text-sm focus:bg-white dark:focus:bg-slate-900 focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 transition">
                </div>
            </div>

            {{-- Đơn giá --}}
            <div class="space-y-2">
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300">
                    Đơn giá (VNĐ) <span class="text-rose-500">*</span>
                </label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                        <i class="ri-money-dollar-circle-line text-lg"></i>
                    </span>
                    <input type="number" name="don_gia" value="{{ $dich_vu->don_gia }}" required min="0"
                        class="w-full pl-10 pr-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-900 text-slate-900 dark:text-white text-sm focus:bg-white dark:focus:bg-slate-900 focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 transition">
                </div>
            </div>

            {{-- Có đồng hồ đo --}}
            <div class="p-4 rounded-2xl bg-slate-50/70 dark:bg-slate-900/60 border border-slate-100 dark:border-slate-700/60">
                <label class="flex items-center gap-3 cursor-pointer">
                    <input type="checkbox" name="co_dong_ho" value="1" id="co_dong_ho" {{ $dich_vu->co_dong_ho ? 'checked' : '' }}
                        class="w-4 h-4 text-sky-600 border-slate-300 rounded focus:ring-sky-500 accent-sky-600">
                    <div>
                        <span class="text-xs sm:text-sm font-bold text-slate-800 dark:text-slate-200">Dịch vụ có đồng hồ đo lường riêng</span>
                        <p class="text-[11px] text-slate-400">Chỉ số tiêu thụ sẽ được nhập hàng tháng theo công tơ</p>
                    </div>
                </label>
            </div>

            {{-- Action Buttons --}}
            <div class="pt-4 flex items-center justify-end gap-3 border-t border-slate-100 dark:border-slate-700/60">
                <a href="{{ route('chu-tro.dich-vu.index') }}"
                    class="px-5 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-700 dark:text-slate-300 hover:bg-slate-50 text-xs sm:text-sm font-bold transition">
                    Hủy bỏ
                </a>
                <button id="submitBtn" type="submit"
                    class="inline-flex items-center gap-2 px-6 py-2.5 rounded-xl bg-gradient-to-r from-sky-600 to-sky-500 hover:from-sky-700 hover:to-sky-600 text-white text-xs sm:text-sm font-bold shadow-lg shadow-sky-500/25 transition">
                    <i class="ri-save-3-line text-base"></i>
                    <span>Lưu Cập Nhật</span>
                </button>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.getElementById('updateForm').addEventListener('submit', async function (e) {
        e.preventDefault();

        const form = this;
        const btn = document.getElementById('submitBtn');
        btn.disabled = true;
        btn.innerHTML = `<i class="ri-loader-4-line animate-spin"></i> <span>Đang lưu...</span>`;

        const formData = new FormData(form);
        formData.append('_method', 'PUT');

        Swal.fire({
            title: 'Đang cập nhật...',
            text: 'Vui lòng chờ trong giây lát',
            allowOutsideClick: false,
            didOpen: () => Swal.showLoading()
        });

        try {
            const response = await fetch(form.action, {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                body: formData
            });

            const result = await response.json();

            if (result.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Thành công!',
                    text: result.message,
                    confirmButtonColor: '#0284c7'
                }).then(() => window.location.href = "{{ route('chu-tro.dich-vu.index') }}");
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Lỗi!',
                    text: result.message || 'Không thể cập nhật dịch vụ. Vui lòng kiểm tra lại dữ liệu.',
                    confirmButtonColor: '#e11d48'
                });
            }
        } catch (error) {
            Swal.fire({
                icon: 'error',
                title: 'Lỗi mạng!',
                text: 'Không thể kết nối tới máy chủ. Vui lòng thử lại sau.',
                confirmButtonColor: '#e11d48'
            });
        } finally {
            btn.disabled = false;
            btn.innerHTML = `<i class="ri-save-3-line text-base"></i> <span>Lưu Cập Nhật</span>`;
        }
    });
</script>
@endsection