@extends('layouts.chu-tro')

@section('title', 'Hồ sơ cá nhân - Hệ Thống Trọ')

@section('content')
<div class="max-w-5xl mx-auto space-y-8 animate-fade-in">
    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-sky-100 dark:bg-sky-950 text-sky-700 dark:text-sky-300 mb-2">
                <i class="ri-user-settings-line"></i> Thông tin tài khoản
            </div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 dark:text-white tracking-tight">
                Hồ sơ cá nhân & Thanh toán
            </h1>
            <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 mt-1">
                Cập nhật họ tên, ảnh đại diện, số điện thoại và số tài khoản ngân hàng nhận tiền thuê
            </p>
        </div>

        <a href="{{ route('chu-tro.dashboard') }}"
            class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-white dark:bg-slate-800 border border-slate-200/80 dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-700/50 text-slate-700 dark:text-slate-200 text-xs sm:text-sm font-bold shadow-xs transition">
            <i class="ri-arrow-left-line"></i>
            <span>Bảng điều khiển</span>
        </a>
    </div>

    @if(session('success'))
        <div class="p-4 rounded-2xl bg-emerald-50 dark:bg-emerald-950/40 border border-emerald-200 dark:border-emerald-800 text-emerald-800 dark:text-emerald-200 text-sm flex items-center justify-between">
            <div class="flex items-center gap-2">
                <i class="ri-checkbox-circle-line text-lg text-emerald-600"></i>
                <span>{{ session('success') }}</span>
            </div>
        </div>
        <script>
            setTimeout(() => location.reload(), 600);
        </script>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        {{-- Card 1: Thông tin cá nhân --}}
        <div class="lg:col-span-2 bg-white dark:bg-slate-800 p-6 sm:p-8 rounded-3xl border border-slate-200/80 dark:border-slate-700 shadow-sm space-y-6">
            <div class="flex items-center gap-2 border-b border-slate-100 dark:border-slate-700/60 pb-3">
                <div class="w-8 h-8 rounded-xl bg-sky-50 dark:bg-sky-950/60 text-sky-600 dark:text-sky-400 flex items-center justify-center text-base">
                    <i class="ri-user-line"></i>
                </div>
                <h2 class="text-base font-extrabold text-slate-900 dark:text-white">Thông tin cơ bản</h2>
            </div>

            <form action="{{ route('chu-tro.profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                @csrf

                {{-- Avatar --}}
                <div class="flex items-center gap-5 p-4 rounded-2xl bg-slate-50 dark:bg-slate-900 border border-slate-200/80 dark:border-slate-700">
                    <img src="{{ $profile['anh_dai_dien'] ?? '/images/default-avatar.png' }}"
                        class="w-20 h-20 rounded-2xl object-cover shadow-sm border-2 border-white dark:border-slate-800 shrink-0">
                    <div class="space-y-1.5 flex-1">
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-300">Đổi ảnh đại diện</label>
                        <input type="file" name="anh_dai_dien" accept="image/*"
                            class="text-xs text-slate-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-sky-50 file:text-sky-700 hover:file:bg-sky-100">
                    </div>
                </div>

                {{-- Họ tên & Số điện thoại --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-300 mb-1.5">Họ và tên</label>
                        <input type="text" name="ho_ten" value="{{ $profile['ho_ten'] ?? '' }}" required
                            class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-xs sm:text-sm font-semibold text-slate-800 dark:text-slate-100 focus:outline-none focus:ring-2 focus:ring-sky-500">
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-300 mb-1.5">Số điện thoại</label>
                        <input type="text" name="so_dien_thoai" value="{{ $profile['so_dien_thoai'] ?? '' }}" required
                            class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-xs sm:text-sm font-semibold text-slate-800 dark:text-slate-100 focus:outline-none focus:ring-2 focus:ring-sky-500">
                    </div>
                </div>

                {{-- Email & Vai trò (Readonly) --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-1.5">Email (không thể đổi)</label>
                        <input type="email" value="{{ $profile['email'] ?? '' }}" readonly
                            class="w-full px-3.5 py-2.5 rounded-xl bg-slate-100 dark:bg-slate-700/50 border border-slate-200 dark:border-slate-700 text-xs sm:text-sm font-medium text-slate-500 cursor-not-allowed">
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-1.5">Vai trò hệ thống</label>
                        <input type="text" value="{{ ucfirst(str_replace('_', ' ', $profile['vai_tro'] ?? '')) }}" readonly
                            class="w-full px-3.5 py-2.5 rounded-xl bg-slate-100 dark:bg-slate-700/50 border border-slate-200 dark:border-slate-700 text-xs sm:text-sm font-medium text-slate-500 cursor-not-allowed">
                    </div>
                </div>

                <div class="pt-2">
                    <button type="submit"
                        class="px-6 py-2.5 bg-gradient-to-r from-sky-600 to-sky-500 hover:from-sky-700 text-white rounded-xl text-xs sm:text-sm font-bold flex items-center justify-center gap-1.5 shadow-lg shadow-sky-500/25 transition">
                        <i class="ri-save-3-line text-base"></i> Lưu thay đổi
                    </button>
                </div>
            </form>
        </div>

        {{-- Card 2: Tài khoản nhận tiền ngân hàng --}}
        <div class="bg-white dark:bg-slate-800 p-6 sm:p-8 rounded-3xl border border-slate-200/80 dark:border-slate-700 shadow-sm space-y-6">
            <div class="flex items-center gap-2 border-b border-slate-100 dark:border-slate-700/60 pb-3">
                <div class="w-8 h-8 rounded-xl bg-emerald-50 dark:bg-emerald-950/60 text-emerald-600 dark:text-emerald-400 flex items-center justify-center text-base">
                    <i class="ri-bank-card-line"></i>
                </div>
                <h2 class="text-base font-extrabold text-slate-900 dark:text-white">Tài khoản nhận tiền</h2>
            </div>

            <div class="space-y-4 text-xs sm:text-sm">
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-300 mb-1.5">Mã ngân hàng (VD: MB, VCB, ACB)</label>
                    <input type="text" id="bank_code" class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-xs sm:text-sm font-semibold text-slate-800 dark:text-slate-100 focus:outline-none focus:ring-2 focus:ring-sky-500"
                        placeholder="VD: MB">
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-300 mb-1.5">Số tài khoản</label>
                    <input type="text" id="account_no" class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-xs sm:text-sm font-semibold text-slate-800 dark:text-slate-100 focus:outline-none focus:ring-2 focus:ring-sky-500"
                        placeholder="Nhập số tài khoản">
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-300 mb-1.5">Tên chủ tài khoản</label>
                    <input type="text" id="account_name" class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-xs sm:text-sm font-semibold text-slate-800 dark:text-slate-100 uppercase focus:outline-none focus:ring-2 focus:ring-sky-500"
                        placeholder="NGUYEN VAN A">
                </div>

                <div class="pt-3">
                    <button id="btnSaveBank"
                        class="w-full py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs sm:text-sm font-bold flex items-center justify-center gap-1.5 shadow-md shadow-emerald-600/20 transition">
                        <i class="ri-check-line text-base"></i> Lưu thông tin ngân hàng
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', async () => {
        const token = localStorage.getItem('token') || '{{ session('api_token') }}';
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const apiBase = '{{ url('chu-tro/profile') }}';

        const bankCodeInput = document.getElementById('bank_code');
        const accountNoInput = document.getElementById('account_no');
        const accountNameInput = document.getElementById('account_name');

        try {
            const res = await fetch(`${apiBase}/bank`, {
                headers: {
                    'Authorization': 'Bearer ' + token,
                    'Accept': 'application/json'
                }
            });
            const data = await res.json();
            if (res.ok && data.data) {
                bankCodeInput.value = data.data.bank_code ?? '';
                accountNoInput.value = data.data.account_no ?? '';
                accountNameInput.value = data.data.account_name ?? '';
            }
        } catch (err) {
            console.warn('Không thể tải thông tin ngân hàng:', err);
        }

        document.getElementById('btnSaveBank').addEventListener('click', async () => {
            const bank_code = bankCodeInput.value.trim();
            const account_no = accountNoInput.value.trim();
            const account_name = accountNameInput.value.trim();

            if (!bank_code || !account_no || !account_name) {
                Swal.fire('Thiếu thông tin!', 'Vui lòng nhập đầy đủ các trường.', 'warning');
                return;
            }

            try {
                const res = await fetch(`${apiBase}/bank`, {
                    method: 'POST',
                    headers: {
                        'Authorization': 'Bearer ' + token,
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({ bank_code, account_no, account_name })
                });

                const data = await res.json();
                if (res.ok && data.success) {
                    Swal.fire('Thành công', data.message, 'success');
                } else {
                    Swal.fire('Lỗi', data.message || 'Không thể lưu thông tin.', 'error');
                }
            } catch (err) {
                console.error(err);
                Swal.fire('Lỗi kết nối', 'Vui lòng thử lại sau.', 'error');
            }
        });
    });
</script>
@endsection