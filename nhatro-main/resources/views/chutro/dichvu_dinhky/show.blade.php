@extends('layouts.chu-tro')

@section('title', 'Cấu hình dịch vụ định kỳ')

@section('content')
<div class="max-w-6xl mx-auto space-y-6">

    {{-- 🔹 Tabs --}}
    <div class="flex items-center gap-2 p-1 bg-slate-100 dark:bg-slate-800/80 rounded-2xl w-fit border border-slate-200/80 dark:border-slate-700/80">
        <a href="{{ route('chu-tro.dich-vu.index') }}"
            class="px-4 py-2 rounded-xl text-xs font-bold transition flex items-center gap-2
               {{ request()->is('chu-tro/dich-vu') ? 'bg-white dark:bg-slate-900 text-indigo-600 dark:text-indigo-400 shadow-sm' : 'text-slate-500 hover:text-slate-900 dark:hover:text-white' }}">
            <i class="ri-list-settings-line"></i> Bảng giá dịch vụ
        </a>
        <a href="{{ route('chu-tro.dichvu-dinhky.index') }}"
            class="px-4 py-2 rounded-xl text-xs font-bold transition flex items-center gap-2 bg-white dark:bg-slate-900 text-indigo-600 dark:text-indigo-400 shadow-sm">
            <i class="ri-repeat-2-line"></i> Dịch vụ định kỳ theo phòng
        </a>
    </div>

    {{-- 🔹 Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-indigo-50 dark:bg-indigo-950/60 text-indigo-600 dark:text-indigo-400 text-xs font-semibold uppercase tracking-wider mb-2 border border-indigo-100 dark:border-indigo-900/50">
                <i class="ri-door-open-line"></i> Phòng #{{ $phong_id }}
            </div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 dark:text-white tracking-tight flex items-center gap-2.5">
                <span class="w-2.5 h-8 bg-gradient-to-b from-indigo-500 to-sky-500 rounded-full inline-block"></span>
                Dịch vụ định kỳ phòng #{{ $phong_id }}
            </h1>
            <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">
                Các khoản phí này sẽ được tự động kết xuất vào hóa đơn hàng tháng cho người thuê
            </p>
        </div>

        <a href="{{ route('chu-tro.dichvu-dinhky.index') }}"
            class="inline-flex items-center gap-2 px-4 py-2 text-sm font-semibold text-slate-600 dark:text-slate-300 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl hover:bg-slate-50 shadow-sm transition">
            <i class="ri-arrow-left-line"></i> Trở về danh sách phòng
        </a>
    </div>

    {{-- 🔹 Bảng danh sách dịch vụ đang áp dụng --}}
    <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200/80 dark:border-slate-800 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-slate-100 dark:border-slate-800 flex items-center justify-between">
            <h2 class="text-base font-bold text-slate-900 dark:text-white flex items-center gap-2">
                <i class="ri-checkbox-circle-line text-emerald-500"></i> Dịch vụ đang hoạt động
            </h2>
            <span class="text-xs text-slate-400 font-medium">Tổng cộng {{ count($dich_vus) }} dịch vụ</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-700 dark:text-slate-300">
                <thead class="bg-slate-50/80 dark:bg-slate-800/60 border-b border-slate-200/80 dark:border-slate-800 text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">
                    <tr>
                        <th class="py-3.5 px-6">Tên dịch vụ</th>
                        <th class="py-3.5 px-6 text-center">Đơn vị</th>
                        <th class="py-3.5 px-6 text-right">Đơn giá</th>
                        <th class="py-3.5 px-6 text-center">Số lượng</th>
                        <th class="py-3.5 px-6 text-right">Thành tiền / Tháng</th>
                        <th class="py-3.5 px-6 text-center">Thao tác</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800/80">
                    @forelse ($dich_vus as $dv)
                        <tr class="hover:bg-slate-50/70 dark:hover:bg-slate-800/40 transition">
                            <td class="py-4 px-6 font-bold text-slate-900 dark:text-white">
                                {{ $dv->ten }}
                            </td>
                            <td class="py-4 px-6 text-center">
                                <span class="px-2.5 py-0.5 rounded-full bg-slate-100 dark:bg-slate-800 text-xs text-slate-600 dark:text-slate-300 font-medium">
                                    {{ $dv->don_vi }}
                                </span>
                            </td>
                            <td class="py-4 px-6 text-right font-medium text-slate-700 dark:text-slate-300">
                                {{ number_format($dv->don_gia, 0, ',', '.') }} ₫
                            </td>
                            <td class="py-4 px-6 text-center font-bold text-slate-800 dark:text-slate-200">
                                {{ $dv->so_luong }}
                            </td>
                            <td class="py-4 px-6 text-right font-black text-indigo-600 dark:text-indigo-400">
                                {{ number_format($dv->don_gia * $dv->so_luong, 0, ',', '.') }} ₫
                            </td>
                            <td class="py-4 px-6 text-center">
                                <button data-id="{{ $dv->id }}"
                                    class="btn-delete p-2 text-rose-500 hover:bg-rose-50 dark:hover:bg-rose-950/60 rounded-xl transition inline-flex items-center gap-1 text-xs font-bold"
                                    title="Xóa khỏi phòng">
                                    <i class="ri-delete-bin-line text-base"></i>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-12 text-slate-400 text-xs">
                                Chưa có dịch vụ định kỳ nào được gán cho phòng này.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- ➕ Thêm dịch vụ mới card --}}
    <div class="bg-white dark:bg-slate-900 p-6 sm:p-8 rounded-3xl border border-slate-200/80 dark:border-slate-800 shadow-sm space-y-4">
        <div>
            <h3 class="text-base font-bold text-slate-900 dark:text-white flex items-center gap-2">
                <i class="ri-add-circle-line text-indigo-500"></i> Gán thêm dịch vụ định kỳ
            </h3>
            <p class="text-xs text-slate-400 mt-0.5">Chọn dịch vụ, xác nhận đơn giá và số lượng mặc định</p>
        </div>

        <form id="addForm" action="{{ route('chu-tro.dichvu-dinhky.store', $phong_id) }}" method="POST"
            class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
            @csrf
            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-300 mb-2">Dịch vụ</label>
                <div class="relative">
                    <select name="dich_vu_id" required
                        class="w-full appearance-none pl-3.5 pr-8 py-2.5 text-sm bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white rounded-xl focus:ring-2 focus:ring-indigo-500/30 focus:border-indigo-500 outline-none transition">
                        <option value="">-- Chọn dịch vụ --</option>
                        @foreach ($tatCaDv as $dv)
                            <option value="{{ $dv->id }}">{{ $dv->ten }} ({{ $dv->don_vi }})</option>
                        @endforeach
                    </select>
                    <i class="ri-arrow-down-s-line absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none"></i>
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-300 mb-2">Đơn giá (VNĐ)</label>
                <input type="number" step="100" min="0" name="don_gia" placeholder="VD: 50000"
                    class="w-full px-3.5 py-2.5 text-sm bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white rounded-xl focus:ring-2 focus:ring-indigo-500/30 focus:border-indigo-500 outline-none transition" required>
            </div>

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-300 mb-2">Số lượng</label>
                <input type="number" step="0.1" min="0.1" name="so_luong" value="1" placeholder="1"
                    class="w-full px-3.5 py-2.5 text-sm bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white rounded-xl focus:ring-2 focus:ring-indigo-500/30 focus:border-indigo-500 outline-none transition" required>
            </div>

            <div>
                <button type="submit"
                    class="w-full py-2.5 bg-gradient-to-r from-indigo-600 via-indigo-500 to-sky-500 hover:from-indigo-700 hover:to-sky-600 text-white rounded-xl text-sm font-semibold shadow-lg shadow-indigo-500/20 transition flex items-center justify-center gap-2">
                    <i class="ri-save-3-line"></i> Lưu dịch vụ
                </button>
            </div>
        </form>
    </div>
</div>

{{-- ✅ SCRIPT --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener("DOMContentLoaded", () => {
        // 🗑️ Xóa dịch vụ
        document.querySelectorAll(".btn-delete").forEach(btn => {
            btn.addEventListener("click", async (e) => {
                const targetBtn = e.currentTarget || e.target.closest('.btn-delete');
                const id = targetBtn.getAttribute("data-id");
                Swal.fire({
                    title: "Xác nhận xóa?",
                    text: "Dịch vụ định kỳ này sẽ bị hủy khỏi phòng!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#ef4444",
                    cancelButtonColor: "#64748b",
                    confirmButtonText: "Xóa ngay",
                    cancelButtonText: "Hủy bỏ"
                }).then(async (result) => {
                    if (result.isConfirmed) {
                        const tokenMeta = document.querySelector('meta[name="csrf-token"]');
                        const token = tokenMeta ? tokenMeta.content : '{{ csrf_token() }}';
                        const res = await fetch(`/chu-tro/dich-vu-dinh-ky/${id}`, {
                            method: "DELETE",
                            headers: {
                                "X-CSRF-TOKEN": token,
                                "Accept": "application/json"
                            }
                        });
                        if (res.ok) {
                            Swal.fire("Đã xóa!", "Dịch vụ định kỳ đã được xóa.", "success")
                                .then(() => location.reload());
                        } else {
                            Swal.fire("Lỗi!", "Không thể xóa dịch vụ này.", "error");
                        }
                    }
                });
            });
        });

        // 💾 Thêm mới
        const addForm = document.getElementById("addForm");
        if (addForm) {
            addForm.addEventListener("submit", async function (e) {
                e.preventDefault();
                const form = this;
                const formData = new FormData(form);

                Swal.fire({
                    title: "Đang lưu...",
                    allowOutsideClick: false,
                    didOpen: () => Swal.showLoading()
                });

                const res = await fetch(form.action, {
                    method: "POST",
                    headers: { "X-CSRF-TOKEN": "{{ csrf_token() }}" },
                    body: formData
                });

                if (res.ok) {
                    Swal.fire("Thành công!", "Đã thêm dịch vụ định kỳ cho phòng!", "success")
                        .then(() => location.reload());
                } else {
                    Swal.fire("Lỗi!", "Không thể thêm dịch vụ. Vui lòng kiểm tra lại.", "error");
                }
            });
        }
    });
</script>
@endsection