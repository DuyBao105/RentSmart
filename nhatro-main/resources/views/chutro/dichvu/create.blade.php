@extends('layouts.chu-tro')

@section('title', 'Thêm Dịch Vụ Mới - Hệ Thống Trọ')

@section('content')
<div class="max-w-3xl mx-auto space-y-8 animate-fade-in">
    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-sky-100 dark:bg-sky-950 text-sky-700 dark:text-sky-300 mb-2">
                <i class="ri-add-circle-line"></i> Khởi Tạo Dịch Vụ
            </div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 dark:text-white tracking-tight">
                Thêm Dịch Vụ Mới
            </h1>
            <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 mt-1">
                Khai báo danh mục chi phí sinh hoạt áp dụng cho các phòng trong hệ thống
            </p>
        </div>

        <a href="{{ route('chu-tro.dich-vu.index') }}"
            class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-white dark:bg-slate-800 border border-slate-200/80 dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-700/50 text-slate-700 dark:text-slate-200 text-xs sm:text-sm font-bold shadow-xs transition">
            <i class="ri-arrow-left-line"></i>
            <span>Quay lại danh sách</span>
        </a>
    </div>

    {{-- Form Container --}}
    <div class="bg-white dark:bg-slate-800 rounded-3xl border border-slate-200/80 dark:border-slate-700 shadow-sm p-6 sm:p-8">
        <form id="formDichVu" action="{{ route('chu-tro.dich-vu.store') }}" method="POST" class="space-y-6">
            @csrf

            {{-- Thông báo mã tự động sinh --}}
            <div class="p-4 rounded-2xl bg-sky-50 dark:bg-sky-950/60 border border-sky-200 dark:border-sky-800/60 text-sky-800 dark:text-sky-300 text-xs sm:text-sm flex items-center gap-3">
                <i class="ri-information-line text-lg text-sky-600"></i>
                <span>Mã dịch vụ sẽ được <strong>tự động sinh theo hệ thống</strong> (ví dụ: DV001, DV002...).</span>
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
                    <input type="text" name="ten" required
                        placeholder="Ví dụ: Điện sinh hoạt, Nước máy, Internet cáp quang, Phí rác..."
                        class="w-full pl-10 pr-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-900 text-slate-900 dark:text-white placeholder-slate-400 text-sm focus:bg-white dark:focus:bg-slate-900 focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 transition">
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
                    <input type="text" name="don_vi" id="don_vi_input" required
                        placeholder="Ví dụ: kWh, m³, tháng, người..."
                        class="w-full pl-10 pr-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-900 text-slate-900 dark:text-white placeholder-slate-400 text-sm focus:bg-white dark:focus:bg-slate-900 focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 transition">
                </div>
                <p id="ghi_chu_don_vi" class="text-xs text-slate-400 italic"></p>
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
                    <input type="number" name="don_gia" min="0" required
                        placeholder="Ví dụ: 3500 (cho điện), 20000 (cho nước)..."
                        class="w-full pl-10 pr-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-900 text-slate-900 dark:text-white placeholder-slate-400 text-sm focus:bg-white dark:focus:bg-slate-900 focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 transition">
                </div>
            </div>

            {{-- Có đồng hồ đo --}}
            <div class="p-4 rounded-2xl bg-slate-50/70 dark:bg-slate-900/60 border border-slate-100 dark:border-slate-700/60">
                <label class="flex items-center gap-3 cursor-pointer">
                    <input type="checkbox" name="co_dong_ho" value="1" id="co_dong_ho"
                        class="w-4 h-4 text-sky-600 border-slate-300 rounded focus:ring-sky-500 accent-sky-600">
                    <div>
                        <span class="text-xs sm:text-sm font-bold text-slate-800 dark:text-slate-200">Dịch vụ có đồng hồ đo lường riêng</span>
                        <p class="text-[11px] text-slate-400">Chọn mục này nếu dịch vụ được tính toán theo chỉ số chốt hàng tháng (ví dụ: Điện, Nước)</p>
                    </div>
                </label>
            </div>

            {{-- Action Buttons --}}
            <div class="pt-4 flex items-center justify-end gap-3 border-t border-slate-100 dark:border-slate-700/60">
                <a href="{{ route('chu-tro.dich-vu.index') }}"
                    class="px-5 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-700 dark:text-slate-300 hover:bg-slate-50 text-xs sm:text-sm font-bold transition">
                    Hủy bỏ
                </a>
                <button type="submit"
                    class="inline-flex items-center gap-2 px-6 py-2.5 rounded-xl bg-gradient-to-r from-sky-600 to-sky-500 hover:from-sky-700 hover:to-sky-600 text-white text-xs sm:text-sm font-bold shadow-lg shadow-sky-500/25 transition">
                    <i class="ri-check-line text-base"></i>
                    <span>Lưu Dịch Vụ</span>
                </button>
            </div>
        </form>
    </div>
</div>

{{-- SweetAlert2 --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const input = document.getElementById('don_vi_input');
        const note = document.getElementById('ghi_chu_don_vi');
        const hints = {
            'm3': 'Mét khối (m³) — chuẩn cho chỉ số nước sinh hoạt',
            'kwh': 'Kilowatt giờ (kWh) — chuẩn cho công tơ điện',
            'tháng': 'Phí tính theo chu kỳ tháng cố định',
            'người': 'Phí chia đều theo đầu người ở trong phòng'
        };

        function updateHint() {
            const val = input.value.trim().toLowerCase();
            if (hints[val]) {
                note.textContent = hints[val];
                note.className = "text-xs text-sky-600 mt-1 italic font-medium";
            } else if (val) {
                note.textContent = 'Đơn vị tùy chỉnh (gợi ý: m³, kWh, tháng, người, bình, xe...)';
                note.className = "text-xs text-slate-400 mt-1 italic";
            } else {
                note.textContent = '';
            }
        }

        input.addEventListener('input', updateHint);

        // SweetAlert sau khi submit
        const form = document.getElementById('formDichVu');
        form.addEventListener('submit', async function (e) {
            e.preventDefault();

            const formData = new FormData(this);

            try {
                const response = await fetch(this.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                });

                if (response.ok) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Thành công!',
                        text: 'Dịch vụ mới đã được thêm vào hệ thống.',
                        confirmButtonText: 'OK',
                        confirmButtonColor: '#0284c7'
                    }).then(() => {
                        window.location.href = "{{ route('chu-tro.dich-vu.index') }}";
                    });
                } else {
                    const err = await response.text();
                    Swal.fire({
                        icon: 'error',
                        title: 'Lỗi!',
                        text: 'Không thể thêm dịch vụ. Vui lòng kiểm tra dữ liệu hoặc thử lại.',
                        confirmButtonColor: '#e11d48'
                    });
                }
            } catch (error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Lỗi kết nối!',
                    text: 'Vui lòng thử lại sau.',
                    confirmButtonColor: '#e11d48'
                });
            }
        });
    });
</script>
@endsection