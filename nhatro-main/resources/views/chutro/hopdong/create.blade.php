@extends('layouts.chu-tro')

@section('title', 'Tạo Hợp Đồng Thuê - Hệ Thống Trọ')

@section('content')
@php
    $selected_phong_id = request()->query('phong_id') ?? ($yeu_cau->phong_id ?? null);
    $selected_khach_thue_id = request()->query('khach_thue_id') ?? ($yeu_cau->khach_thue_id ?? null);
@endphp

<div class="max-w-4xl mx-auto space-y-8 animate-fade-in">
    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-sky-100 dark:bg-sky-950 text-sky-700 dark:text-sky-300 mb-2">
                <i class="ri-file-add-line"></i> Khởi Tạo Hợp Đồng
            </div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 dark:text-white tracking-tight">
                Tạo Hợp Đồng Thuê Phòng
            </h1>
            <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 mt-1">
                Thiết lập văn bản ràng buộc pháp lý, thời hạn thuê, tiền cọc và thông tin cư dân
            </p>
        </div>

        <a href="{{ route('chu-tro.hop-dong.index') }}"
            class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-white dark:bg-slate-800 border border-slate-200/80 dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-700/50 text-slate-700 dark:text-slate-200 text-xs sm:text-sm font-bold shadow-xs transition">
            <i class="ri-arrow-left-line"></i>
            <span>Quay lại danh sách</span>
        </a>
    </div>

    {{-- Flash messages --}}
    @if(session('error'))
        <div class="p-4 rounded-2xl bg-rose-50 dark:bg-rose-950/50 border border-rose-200 dark:border-rose-800 text-rose-700 dark:text-rose-300 text-xs sm:text-sm flex items-center gap-2">
            <i class="ri-error-warning-fill text-lg"></i>
            <span>{{ session('error') }}</span>
        </div>
    @endif
    @if(session('ok'))
        <div class="p-4 rounded-2xl bg-emerald-50 dark:bg-emerald-950/50 border border-emerald-200 dark:border-emerald-800 text-emerald-700 dark:text-emerald-300 text-xs sm:text-sm flex items-center gap-2">
            <i class="ri-checkbox-circle-fill text-lg"></i>
            <span>{{ session('ok') }}</span>
        </div>
    @endif

    {{-- Main Form Container --}}
    <div class="bg-white dark:bg-slate-800 rounded-3xl border border-slate-200/80 dark:border-slate-700 shadow-sm p-6 sm:p-8">
        <form action="{{ route('chu-tro.hop-dong.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            @if(isset($yeu_cau))
                <input type="hidden" name="yeu_cau_thue_id" value="{{ $yeu_cau->id }}">
            @endif

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
                            <option value="">-- Chọn phòng --</option>
                            @foreach ($phongs as $phong)
                                <option value="{{ $phong->id }}"
                                    @if(
                                        old('phong_id') == $phong->id ||
                                        $selected_phong_id == $phong->id ||
                                        (isset($yeu_cau) && $yeu_cau->phong_id == $phong->id)
                                    ) selected @endif
                                    @if($phong->trang_thai !== 'trong') disabled @endif>
                                    {{ $phong->so_phong }} — {{ $phong->ten_day_tro ?? '' }}
                                    @if($phong->trang_thai !== 'trong')
                                        ({{ strtoupper(str_replace('_', ' ', $phong->trang_thai)) }})
                                    @endif
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
                            <option value="">-- Chọn khách thuê --</option>
                            @foreach ($khach_thues as $kt)
                                <option value="{{ $kt->id }}"
                                    @if(
                                        old('khach_thue_id') == $kt->id ||
                                        $selected_khach_thue_id == $kt->id ||
                                        (isset($yeu_cau) && $yeu_cau->khach_thue_id == $kt->id)
                                    ) selected @endif>
                                    {{ $kt->ho_ten }} ({{ $kt->so_dien_thoai ?? $kt->email }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    @error('khach_thue_id')
                        <p class="text-rose-500 text-xs mt-1 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                {{-- CCCD khách thuê --}}
                <div id="cccdFieldContainer" class="hidden md:col-span-2 space-y-2">
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300">
                        CCCD / Mã Định Danh <span class="text-rose-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <i class="ri-id-card-line text-lg"></i>
                        </span>
                        <input type="text" id="cccdInput" name="cccd" placeholder="Nhập số CCCD/CMND"
                            class="w-full pl-10 pr-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-900 text-slate-900 dark:text-white text-sm focus:bg-white dark:focus:bg-slate-900 focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 transition">
                    </div>
                    <p id="cccdStatus" class="text-xs text-slate-400 italic"></p>
                </div>

                {{-- Ngày bắt đầu --}}
                <div class="space-y-2">
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300">
                        Ngày bắt đầu hợp đồng <span class="text-rose-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <i class="ri-calendar-line text-lg"></i>
                        </span>
                        <input type="date" name="ngay_bat_dau" value="{{ old('ngay_bat_dau', now()->format('Y-m-d')) }}" required
                            class="w-full pl-10 pr-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-900 text-slate-900 dark:text-white text-sm focus:bg-white dark:focus:bg-slate-900 focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 transition">
                    </div>
                </div>

                {{-- Ngày kết thúc --}}
                <div class="space-y-2">
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300">
                        Ngày kết thúc dự kiến <span class="text-rose-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <i class="ri-calendar-check-line text-lg"></i>
                        </span>
                        <input type="date" name="ngay_ket_thuc" value="{{ old('ngay_ket_thuc', now()->addYear()->format('Y-m-d')) }}" required
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
                        <input type="number" name="tien_coc" min="0" step="1000" placeholder="Nhập số tiền cọc" value="{{ old('tien_coc') }}" required
                            class="w-full pl-10 pr-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-900 text-slate-900 dark:text-white text-sm focus:bg-white dark:focus:bg-slate-900 focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 transition">
                    </div>
                </div>

                {{-- File hợp đồng đính kèm --}}
                <div class="space-y-2">
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300">
                        Văn bản PDF ký kết <span class="text-slate-400 font-normal lowercase">(tùy chọn)</span>
                    </label>
                    <input type="file" name="file_hop_dong" accept=".pdf"
                        class="w-full py-2.5 px-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-900 text-xs text-slate-600 dark:text-slate-400 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:bg-sky-600 file:text-white file:text-xs file:font-bold hover:file:bg-sky-700 transition">
                </div>
            </div>

            {{-- Người thân / Người sống cùng --}}
            <div id="nguoiThanContainer" class="pt-6 border-t border-slate-100 dark:border-slate-700/60 space-y-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-sm font-bold text-slate-900 dark:text-white flex items-center gap-1.5">
                            <i class="ri-group-line text-sky-500"></i> Người thân / Cư dân sống cùng
                        </h3>
                        <p class="text-[11px] text-slate-400">Danh sách người thân lưu trú cùng phòng để quản lý an ninh</p>
                    </div>
                    <button type="button" id="addNguoiThan"
                        class="inline-flex items-center gap-1 px-3 py-1.5 rounded-xl bg-sky-50 dark:bg-sky-950/60 text-sky-700 dark:text-sky-300 text-xs font-bold hover:bg-sky-100 transition border border-sky-200/60 dark:border-sky-900/40">
                        <i class="ri-add-line"></i> Thêm người
                    </button>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                    <input type="text" name="nguoi_than[0][ho_ten]"
                        placeholder="Họ tên người thân"
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-900 text-slate-900 dark:text-white text-xs focus:bg-white dark:focus:bg-slate-900 focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 transition">
                    <input type="text" name="nguoi_than[0][so_dien_thoai]"
                        placeholder="Số điện thoại"
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-900 text-slate-900 dark:text-white text-xs focus:bg-white dark:focus:bg-slate-900 focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 transition">
                    <input type="text" name="nguoi_than[0][moi_quan_he]"
                        placeholder="Quan hệ (VD: Vợ/Chồng, Bạn, Con...)"
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-900 text-slate-900 dark:text-white text-xs focus:bg-white dark:focus:bg-slate-900 focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 transition">
                </div>
            </div>

            {{-- Action Buttons --}}
            <div class="pt-6 flex items-center justify-end gap-3 border-t border-slate-100 dark:border-slate-700/60">
                <a href="{{ route('chu-tro.hop-dong.index') }}"
                    class="px-5 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-700 dark:text-slate-300 hover:bg-slate-50 text-xs sm:text-sm font-bold transition">
                    Hủy bỏ
                </a>
                <button type="submit"
                    class="inline-flex items-center gap-2 px-6 py-2.5 rounded-xl bg-gradient-to-r from-sky-600 to-sky-500 hover:from-sky-700 hover:to-sky-600 text-white text-xs sm:text-sm font-bold shadow-lg shadow-sky-500/25 transition">
                    <i class="ri-check-line text-base"></i>
                    <span>Tạo Hợp Đồng</span>
                </button>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const khachThueSelect = document.querySelector('select[name="khach_thue_id"]');
        const submitBtn = document.querySelector('button[type="submit"]');
        const cccdContainer = document.getElementById('cccdFieldContainer');
        const cccdInput = document.getElementById('cccdInput');
        const cccdStatus = document.getElementById('cccdStatus');

        async function loadCCCD(khachId) {
            const token = localStorage.getItem('token');
            if (!token) {
                // If web auth session is present, fallback gracefully
                cccdContainer.classList.remove('hidden');
                return;
            }

            try {
                const response = await fetch(`http://127.0.0.1:8000/api/chu-tro/khach-thue/${khachId}`, {
                    headers: { 'Authorization': `Bearer ${token}`, 'Accept': 'application/json' }
                });
                const data = await response.json();
                cccdContainer.classList.remove('hidden');

                if (!response.ok) {
                    cccdStatus.textContent = 'Không thể tải thông tin khách thuê.';
                    cccdStatus.className = 'text-xs text-rose-500 italic';
                    return;
                }

                if (data.khach_thue?.cccd?.trim()) {
                    cccdInput.value = data.khach_thue.cccd;
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
            } catch (err) {
                cccdContainer.classList.remove('hidden');
            }
        }

        khachThueSelect.addEventListener('change', function () {
            if (this.value) loadCCCD(this.value);
        });

        if (khachThueSelect.value) khachThueSelect.dispatchEvent(new Event('change'));
    });

    // Thêm người thân động
    document.getElementById('addNguoiThan').addEventListener('click', function () {
        const container = document.getElementById('nguoiThanContainer');
        const index = container.querySelectorAll('.grid').length;
        const html = `
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                <input type="text" name="nguoi_than[${index}][ho_ten]" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-900 text-slate-900 dark:text-white text-xs focus:bg-white dark:focus:bg-slate-900 focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 transition" placeholder="Họ tên người thân" required>
                <input type="text" name="nguoi_than[${index}][so_dien_thoai]" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-900 text-slate-900 dark:text-white text-xs focus:bg-white dark:focus:bg-slate-900 focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 transition" placeholder="Số điện thoại">
                <input type="text" name="nguoi_than[${index}][moi_quan_he]" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-900 text-slate-900 dark:text-white text-xs focus:bg-white dark:focus:bg-slate-900 focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 transition" placeholder="Quan hệ (VD: Anh, Em, Bạn...)">
            </div>`;
        container.insertAdjacentHTML('beforeend', html);
    });

    // Tự chọn phòng & khách khi mở bằng query
    document.addEventListener('DOMContentLoaded', () => {
        const phongSelect = document.querySelector('select[name="phong_id"]');
        const khachSelect = document.querySelector('select[name="khach_thue_id"]');
        const phongId = "{{ request()->query('phong_id') }}";
        const khachId = "{{ request()->query('khach_thue_id') }}";

        if (phongId && phongSelect) {
            for (let opt of phongSelect.options) {
                if (opt.value == phongId) opt.selected = true;
            }
        }

        if (khachId && khachSelect) {
            for (let opt of khachSelect.options) {
                if (opt.value == khachId) {
                    opt.selected = true;
                    khachSelect.dispatchEvent(new Event('change'));
                }
            }
        }
    });
</script>
@endsection
