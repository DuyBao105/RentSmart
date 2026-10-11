@extends('layouts.chu-tro')

@section('title', 'Cập Nhật Hợp Đồng Thuê - Hệ Thống Trọ')

@section('content')
<div class="max-w-4xl mx-auto space-y-8 animate-fade-in">
    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-amber-100 dark:bg-amber-950 text-amber-700 dark:text-amber-300 mb-2">
                <i class="ri-edit-box-line"></i> Điều Chỉnh Hợp Đồng
            </div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 dark:text-white tracking-tight">
                Cập Nhật Hợp Đồng Thuê
            </h1>
            <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 mt-1">
                Điều chỉnh thời hạn hợp đồng, tiền cọc hoặc cập nhật văn bản đính kèm
            </p>
        </div>

        <div class="flex items-center gap-3">
            <a href="{{ route('chu-tro.hop-dong.show', data_get($hop_dong, 'id')) }}"
                class="inline-flex items-center gap-1.5 px-4 py-2.5 rounded-xl bg-white dark:bg-slate-800 border border-slate-200/80 dark:border-slate-700 hover:bg-slate-50 text-slate-700 dark:text-slate-200 text-xs sm:text-sm font-bold shadow-xs transition">
                <i class="ri-eye-line text-sky-500"></i>
                <span>Xem hợp đồng</span>
            </a>
            <a href="{{ route('chu-tro.hop-dong.index') }}"
                class="inline-flex items-center gap-1.5 px-4 py-2.5 rounded-xl bg-white dark:bg-slate-800 border border-slate-200/80 dark:border-slate-700 hover:bg-slate-50 text-slate-700 dark:text-slate-200 text-xs sm:text-sm font-bold shadow-xs transition">
                <i class="ri-arrow-left-line"></i>
                <span>Danh sách</span>
            </a>
        </div>
    </div>

    {{-- Flash messages --}}
    @if (session('error'))
        <div class="p-4 rounded-2xl bg-rose-50 dark:bg-rose-950/50 border border-rose-200 dark:border-rose-800 text-rose-700 dark:text-rose-300 text-xs sm:text-sm flex items-center gap-2">
            <i class="ri-error-warning-fill text-lg"></i>
            <span>{{ session('error') }}</span>
        </div>
    @elseif (session('ok'))
        <div class="p-4 rounded-2xl bg-emerald-50 dark:bg-emerald-950/50 border border-emerald-200 dark:border-emerald-800 text-emerald-700 dark:text-emerald-300 text-xs sm:text-sm flex items-center gap-2">
            <i class="ri-checkbox-circle-fill text-lg"></i>
            <span>{{ session('ok') }}</span>
        </div>
    @endif

    {{-- Main Form Container --}}
    <div class="bg-white dark:bg-slate-800 rounded-3xl border border-slate-200/80 dark:border-slate-700 shadow-sm p-6 sm:p-8">
        <form action="{{ route('chu-tro.hop-dong.update', data_get($hop_dong, 'id')) }}" method="POST"
            enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Phòng --}}
                <div class="space-y-2">
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300">
                        Căn phòng thuê <span class="text-rose-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <i class="ri-door-open-line text-lg"></i>
                        </span>
                        <select name="phong_id" required
                            class="w-full pl-10 pr-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-900 text-slate-900 dark:text-white text-sm focus:bg-white dark:focus:bg-slate-900 focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 transition">
                            @foreach ($phongs as $phong)
                                <option value="{{ $phong->id }}" @if ($phong->id == data_get($hop_dong, 'phong_id')) selected @endif>
                                    {{ $phong->so_phong }} — {{ $phong->ten_day_tro }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- Khách thuê --}}
                <div class="space-y-2">
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300">
                        Đại diện khách thuê <span class="text-rose-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <i class="ri-user-line text-lg"></i>
                        </span>
                        <select name="khach_thue_id" required
                            class="w-full pl-10 pr-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-900 text-slate-900 dark:text-white text-sm focus:bg-white dark:focus:bg-slate-900 focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 transition">
                            @foreach ($khach_thues as $kt)
                                <option value="{{ $kt->id }}" @if ($kt->id == data_get($hop_dong, 'khach_thue_id')) selected @endif>
                                    {{ $kt->ho_ten }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- CCCD khách thuê --}}
                <div id="cccdContainer" class="hidden md:col-span-2 space-y-2">
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300">
                        CCCD khách thuê <span class="text-rose-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <i class="ri-id-card-line text-lg"></i>
                        </span>
                        <input type="text" id="cccdInput" name="cccd" value="{{ data_get($hop_dong, 'cccd', '') }}"
                            placeholder="Nhập hoặc xem CCCD của khách thuê"
                            class="w-full pl-10 pr-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-900 text-slate-900 dark:text-white text-sm focus:bg-white dark:focus:bg-slate-900 focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 transition">
                    </div>
                    <p id="cccdStatus" class="text-xs text-slate-400 italic"></p>
                </div>

                {{-- Ngày bắt đầu --}}
                <div class="space-y-2">
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300">
                        Ngày bắt đầu <span class="text-rose-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <i class="ri-calendar-line text-lg"></i>
                        </span>
                        <input type="date" name="ngay_bat_dau" value="{{ data_get($hop_dong, 'ngay_bat_dau') }}" required
                            class="w-full pl-10 pr-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-900 text-slate-900 dark:text-white text-sm focus:bg-white dark:focus:bg-slate-900 focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 transition">
                    </div>
                </div>

                {{-- Ngày kết thúc --}}
                <div class="space-y-2">
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300">
                        Ngày kết thúc <span class="text-rose-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <i class="ri-calendar-check-line text-lg"></i>
                        </span>
                        <input type="date" name="ngay_ket_thuc" value="{{ data_get($hop_dong, 'ngay_ket_thuc') }}" required
                            class="w-full pl-10 pr-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-900 text-slate-900 dark:text-white text-sm focus:bg-white dark:focus:bg-slate-900 focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 transition">
                    </div>
                </div>

                {{-- Tiền cọc --}}
                <div class="space-y-2">
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300">
                        Tiền đặt cọc (VNĐ) <span class="text-rose-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <i class="ri-money-dollar-circle-line text-lg"></i>
                        </span>
                        <input type="number" name="tien_coc" step="1000" min="0" value="{{ data_get($hop_dong, 'tien_coc', 0) }}" required
                            class="w-full pl-10 pr-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-900 text-slate-900 dark:text-white text-sm focus:bg-white dark:focus:bg-slate-900 focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 transition">
                    </div>
                </div>

                {{-- Trạng thái --}}
                <div class="space-y-2">
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300">
                        Trạng thái hợp đồng
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <i class="ri-shield-check-line text-lg"></i>
                        </span>
                        <select name="trang_thai" disabled
                            class="w-full pl-10 pr-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-100 dark:bg-slate-800 text-slate-500 text-sm cursor-not-allowed">
                            <option value="hieu_luc" {{ data_get($hop_dong, 'trang_thai') === 'hieu_luc' ? 'selected' : '' }}>Đang có hiệu lực</option>
                            <option value="het_han" {{ data_get($hop_dong, 'trang_thai') === 'het_han' ? 'selected' : '' }}>Đã hết hạn</option>
                        </select>
                    </div>
                </div>

                {{-- Ghi chú --}}
                <div class="md:col-span-2 space-y-2">
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300">
                        Ghi chú hợp đồng
                    </label>
                    <textarea name="ghi_chu" rows="3" placeholder="Nhập ghi chú hoặc điều khoản bổ sung..."
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-900 text-slate-900 dark:text-white text-sm focus:bg-white dark:focus:bg-slate-900 focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 transition">{{ old('ghi_chu', data_get($hop_dong, 'ghi_chu', '')) }}</textarea>
                </div>

                {{-- File hiện tại --}}
                <div class="md:col-span-2 space-y-2">
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300">
                        File hợp đồng đã lưu
                    </label>
                    @if (data_get($hop_dong, 'url_file_hop_dong'))
                        <div class="flex items-center gap-3 p-3.5 rounded-2xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700">
                            <i class="ri-file-pdf-2-line text-rose-500 text-2xl"></i>
                            <div class="flex-1 truncate text-xs">
                                <span class="font-bold text-slate-800 dark:text-white">{{ basename(data_get($hop_dong, 'url_file_hop_dong')) }}</span>
                            </div>
                            <a href="{{ asset('storage/' . data_get($hop_dong, 'url_file_hop_dong')) }}" target="_blank"
                                class="inline-flex items-center gap-1 px-3 py-1.5 rounded-xl bg-sky-50 dark:bg-sky-950/60 text-sky-600 dark:text-sky-300 text-xs font-bold hover:underline">
                                <i class="ri-download-line"></i> Xem file
                            </a>
                        </div>
                    @else
                        <p class="text-xs text-slate-400 italic">Chưa có văn bản PDF nào được tải lên.</p>
                    @endif
                </div>

                {{-- Upload file mới --}}
                <div class="md:col-span-2 space-y-2">
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300">
                        Tải lên văn bản PDF mới thay thế
                    </label>
                    <input type="file" name="file_hop_dong" accept="application/pdf"
                        class="w-full py-2.5 px-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-900 text-xs text-slate-600 dark:text-slate-400 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:bg-sky-600 file:text-white file:text-xs file:font-bold hover:file:bg-sky-700 transition">
                </div>
            </div>

            {{-- Action Buttons --}}
            <div class="pt-6 flex items-center justify-end gap-3 border-t border-slate-100 dark:border-slate-700/60">
                <a href="{{ route('chu-tro.hop-dong.index') }}"
                    class="px-5 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-700 dark:text-slate-300 hover:bg-slate-50 text-xs sm:text-sm font-bold transition">
                    Hủy bỏ
                </a>
                <button type="submit" onclick="return confirm('Bạn có chắc muốn lưu thay đổi hợp đồng này không?')"
                    class="inline-flex items-center gap-2 px-6 py-2.5 rounded-xl bg-gradient-to-r from-sky-600 to-sky-500 hover:from-sky-700 hover:to-sky-600 text-white text-xs sm:text-sm font-bold shadow-lg shadow-sky-500/25 transition">
                    <i class="ri-save-3-line text-base"></i>
                    <span>Cập Nhật Hợp Đồng</span>
                </button>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const khachSelect = document.querySelector('select[name="khach_thue_id"]');
        const cccdContainer = document.getElementById('cccdContainer');
        const cccdInput = document.getElementById('cccdInput');
        const cccdStatus = document.getElementById('cccdStatus');
        const submitBtn = document.querySelector('button[type="submit"]');

        if (cccdInput.value.trim() !== '') {
            cccdContainer.classList.remove('hidden');
            cccdInput.readOnly = true;
            cccdInput.classList.add('bg-slate-100', 'dark:bg-slate-800');
            cccdStatus.innerHTML = '<i class="ri-checkbox-circle-fill mr-1"></i> Khách thuê đã có CCCD xác thực.';
            cccdStatus.className = 'text-xs text-emerald-600 font-semibold flex items-center';
            submitBtn.disabled = false;
            return;
        }

        if (khachSelect && khachSelect.value) {
            loadCCCD(khachSelect.value);
        }

        khachSelect?.addEventListener('change', function () {
            if (this.value) loadCCCD(this.value);
        });

        async function loadCCCD(khachId) {
            try {
                const response = await fetch(`/api/chu-tro/khach-thue/${khachId}`, {
                    headers: { 'Accept': 'application/json' },
                    credentials: 'include'
                });

                cccdContainer.classList.remove('hidden');
                cccdStatus.textContent = '';
                cccdStatus.className = '';
                submitBtn.disabled = false;

                const data = await response.json();

                if (!response.ok) {
                    if (!cccdInput.value.trim()) {
                        const msg = data?.error ?? 'Không thể lấy thông tin khách thuê.';
                        cccdStatus.textContent = msg;
                        cccdStatus.className = 'text-xs text-rose-500 italic';
                        submitBtn.disabled = true;
                    }
                    return;
                }

                const khach = data?.khach_thue ?? null;
                const cccdValue = khach?.cccd ?? '';

                if (cccdValue.trim() !== '') {
                    cccdInput.value = cccdValue;
                    cccdInput.readOnly = true;
                    cccdInput.classList.add('bg-slate-100', 'dark:bg-slate-800');
                    cccdStatus.innerHTML = '<i class="ri-checkbox-circle-fill mr-1"></i> Khách thuê đã có CCCD xác thực.';
                    cccdStatus.className = 'text-xs text-emerald-600 font-semibold flex items-center';
                } else {
                    cccdInput.value = '';
                    cccdInput.readOnly = false;
                    cccdInput.classList.remove('bg-slate-100', 'dark:bg-slate-800');
                    cccdStatus.textContent = 'Khách thuê chưa có CCCD — vui lòng bổ sung.';
                    cccdStatus.className = 'text-xs text-amber-500 italic';
                }
            } catch (error) {
                cccdContainer.classList.remove('hidden');
            }
        }
    });
</script>
@endsection