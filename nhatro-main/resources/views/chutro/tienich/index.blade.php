@extends('layouts.chu-tro')

@section('title', 'Quản lý Tiện ích - Hệ Thống Trọ')

@section('content')
<div class="max-w-7xl mx-auto space-y-8 animate-fade-in">
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
                <i class="ri-sparkling-line"></i> Tiện Nghi Phòng Trọ
            </div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 dark:text-white tracking-tight">
                Danh Sách Tiện Ích Phòng
            </h1>
            <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 mt-1">
                Khai báo danh mục tiện nghi cơ bản (máy lạnh, máy giặt, gác lửng, tủ lạnh...) để gán cho các phòng
            </p>
        </div>

        <div class="flex items-center gap-3">
            <span class="text-xs font-bold px-3 py-1.5 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 border border-slate-200/60 dark:border-slate-700">
                Tổng cộng: <span id="countTienIch" class="text-sky-600 font-black">0</span> tiện ích
            </span>
        </div>
    </div>

    {{-- Form thêm tiện ích nhanh --}}
    <div class="bg-white dark:bg-slate-800 rounded-3xl border border-slate-200/80 dark:border-slate-700 shadow-sm p-6 sm:p-7">
        <h2 class="text-sm font-bold text-slate-900 dark:text-white mb-3 flex items-center gap-2">
            <i class="ri-add-circle-line text-sky-500 text-lg"></i>
            Thêm tiện ích mới vào danh mục
        </h2>
        <form id="addForm" class="flex flex-col sm:flex-row items-center gap-3">
            <div class="relative flex-1 w-full">
                <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                    <i class="ri-sparkling-line text-lg"></i>
                </span>
                <input type="text" name="ten" id="tenTienIch" placeholder="Nhập tên tiện ích (VD: Máy giặt chung, Gác lửng cao, Ban công riêng...)"
                    class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-900 text-slate-900 dark:text-white placeholder-slate-400 text-xs sm:text-sm focus:bg-white dark:focus:bg-slate-900 focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 transition">
            </div>
            <button type="submit"
                class="w-full sm:w-auto inline-flex items-center justify-center gap-1.5 px-6 py-2.5 rounded-xl bg-gradient-to-r from-sky-600 to-sky-500 hover:from-sky-700 hover:to-sky-600 text-white font-bold text-xs sm:text-sm shadow-md shadow-sky-500/25 transition shrink-0">
                <i class="ri-add-line text-base"></i>
                <span>Thêm Tiện Ích</span>
            </button>
        </form>
    </div>

    {{-- Bảng tiện ích --}}
    <div class="bg-white dark:bg-slate-800 rounded-3xl border border-slate-200/80 dark:border-slate-700 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/80 dark:bg-slate-900/50 border-b border-slate-200/80 dark:border-slate-700 text-[11px] font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">
                        <th class="py-4 px-4 text-center w-12">#</th>
                        <th class="py-4 px-5">Tên tiện ích</th>
                        <th class="py-4 px-5">Phòng đang trang bị</th>
                        <th class="py-4 px-5 text-center">Thao tác</th>
                    </tr>
                </thead>
                <tbody id="tableTienIch" class="divide-y divide-slate-100 dark:divide-slate-700/60 text-xs sm:text-sm text-slate-700 dark:text-slate-300">
                    <tr>
                        <td colspan="4" class="py-12 text-center text-slate-400 italic">
                            Đang tải danh sách tiện ích...
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- JS --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    const apiUrl = 'http://127.0.0.1:8000/api/chu-tro';
    const token = localStorage.getItem('token');
    let tienIchData = [];

    // 🔄 Load danh sách tiện ích
    async function loadTienIch() {
        try {
            const res = await fetch(`${apiUrl}/tien-ich`, {
                headers: { 'Authorization': 'Bearer ' + token, 'Accept': 'application/json' }
            });

            if (res.status === 401) {
                // Try fallback session if authorized via Web Auth
                const table = document.getElementById('tableTienIch');
                table.innerHTML = `<tr><td colspan="4" class="py-8 text-center text-slate-400">Vui lòng đăng nhập lại để xem dữ liệu tiện ích.</td></tr>`;
                return;
            }

            tienIchData = await res.json();
            const table = document.getElementById('tableTienIch');
            document.getElementById('countTienIch').textContent = Array.isArray(tienIchData) ? tienIchData.length : 0;

            if (Array.isArray(tienIchData) && tienIchData.length > 0) {
                table.innerHTML = tienIchData.map((ti, i) => `
                    <tr class="hover:bg-slate-50/70 dark:hover:bg-slate-700/30 transition">
                        <td class="py-4 px-4 text-center font-bold text-slate-400 text-xs">${i + 1}</td>
                        <td class="py-4 px-5 font-bold text-slate-900 dark:text-white flex items-center gap-2">
                            <span class="w-8 h-8 rounded-xl bg-sky-50 dark:bg-sky-950/60 text-sky-600 flex items-center justify-center text-sm">
                                <i class="ri-checkbox-circle-fill"></i>
                            </span>
                            <span>${ti.ten}</span>
                        </td>
                        <td class="py-4 px-5 text-slate-600 dark:text-slate-300">
                            ${ti.phongs && ti.phongs.length
                        ? `<button class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold bg-sky-50 text-sky-600 dark:bg-sky-950/60 dark:text-sky-300 hover:bg-sky-100 transition" onclick="xemPhong(${ti.id})">
                                    <i class="ri-door-open-line"></i> ${ti.phongs.length} phòng
                                  </button>`
                        : '<span class="text-slate-400 italic text-xs">Chưa gán phòng</span>'}
                        </td>
                        <td class="py-4 px-5 text-center">
                            <div class="flex items-center justify-center gap-2">
                                <button class="p-2 rounded-xl bg-amber-50 dark:bg-amber-950/60 text-amber-600 dark:text-amber-400 hover:bg-amber-100 transition"
                                    onclick="suaTienIch(${ti.id}, '${ti.ten.replace(/'/g, "\\'")}')" title="Sửa tên">
                                    <i class="ri-edit-2-line text-base"></i>
                                </button>
                                <button class="p-2 rounded-xl bg-rose-50 dark:bg-rose-950/60 text-rose-600 dark:text-rose-400 hover:bg-rose-100 transition"
                                    onclick="xoaTienIch(${ti.id})" title="Xóa tiện ích">
                                    <i class="ri-delete-bin-6-line text-base"></i>
                                </button>
                            </div>
                        </td>
                    </tr>`).join('');
            } else {
                table.innerHTML = `<tr><td colspan="4" class="py-12 text-center text-slate-400 text-xs">Chưa có tiện ích nào được tạo trong danh mục.</td></tr>`;
            }
        } catch (error) {
            console.error(error);
            const table = document.getElementById('tableTienIch');
            table.innerHTML = `<tr><td colspan="4" class="py-8 text-center text-rose-500 text-xs">Lỗi tải dữ liệu tiện ích từ máy chủ.</td></tr>`;
        }
    }

    // 👀 Xem danh sách phòng đang dùng tiện ích
    function xemPhong(id) {
        const ti = tienIchData.find(t => t.id === id);
        const list = ti.phongs && ti.phongs.length
            ? ti.phongs.map(p => `<li class="py-1 flex items-center gap-2"><i class="ri-door-open-fill text-sky-500"></i> Phòng <b>${p.so_phong}</b></li>`).join('')
            : '<i>Chưa có phòng nào sử dụng</i>';

        Swal.fire({
            title: `Phòng trang bị "${ti.ten}"`,
            html: `<ul class="text-left text-xs sm:text-sm text-slate-700 dark:text-slate-300 divide-y divide-slate-100 dark:divide-slate-800">${list}</ul>`,
            icon: 'info',
            confirmButtonText: 'Đóng lại',
            confirmButtonColor: '#0284c7'
        });
    }

    // 🗑️ Xóa tiện ích
    async function xoaTienIch(id) {
        const confirm = await Swal.fire({
            title: "Xác nhận xóa?",
            text: "Bạn có chắc chắn muốn xóa tiện ích này khỏi danh mục?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#e11d48",
            cancelButtonColor: "#64748b",
            confirmButtonText: "Đồng ý xóa",
            cancelButtonText: "Hủy bỏ"
        });
        if (!confirm.isConfirmed) return;

        Swal.fire({ title: "Đang xóa...", didOpen: () => Swal.showLoading(), allowOutsideClick: false });

        const res = await fetch(`${apiUrl}/tien-ich/${id}`, {
            method: 'DELETE',
            headers: { 'Authorization': 'Bearer ' + token, 'Accept': 'application/json' }
        });

        Swal.close();

        if (res.ok) {
            Swal.fire({ icon: "success", title: "Đã xóa!", text: "Tiện ích đã được gỡ bỏ.", confirmButtonColor: "#0284c7" });
            loadTienIch();
        } else {
            Swal.fire({ icon: "error", title: "Lỗi!", text: "Không thể xóa tiện ích lúc này.", confirmButtonColor: "#e11d48" });
        }
    }

    // ✏️ Sửa tiện ích
    async function suaTienIch(id, tenHienTai) {
        const { value: newTen } = await Swal.fire({
            title: "Chỉnh sửa tên tiện ích",
            input: "text",
            inputLabel: "Tên tiện ích mới",
            inputValue: tenHienTai,
            showCancelButton: true,
            confirmButtonText: "Lưu thay đổi",
            cancelButtonText: "Hủy bỏ",
            confirmButtonColor: "#0284c7"
        });
        if (!newTen) return;

        Swal.fire({ title: "Đang cập nhật...", didOpen: () => Swal.showLoading(), allowOutsideClick: false });

        const res = await fetch(`${apiUrl}/tien-ich/${id}`, {
            method: 'PUT',
            headers: {
                'Authorization': 'Bearer ' + token,
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify({ ten: newTen })
        });

        Swal.close();

        if (res.ok) {
            Swal.fire({ icon: "success", title: "Thành công!", text: "Tên tiện ích đã được cập nhật!", confirmButtonColor: "#0284c7" });
            loadTienIch();
        } else {
            Swal.fire({ icon: "error", title: "Lỗi!", text: "Không thể cập nhật tiện ích!", confirmButtonColor: "#e11d48" });
        }
    }

    // ➕ Thêm tiện ích mới
    document.getElementById('addForm').addEventListener('submit', async (e) => {
        e.preventDefault();
        const ten = document.getElementById('tenTienIch').value.trim();
        if (!ten) return Swal.fire({ icon: "warning", title: "Thiếu dữ liệu!", text: "Vui lòng nhập tên tiện ích.", confirmButtonColor: "#0284c7" });

        Swal.fire({ title: "Đang lưu...", didOpen: () => Swal.showLoading(), allowOutsideClick: false });

        const res = await fetch(`${apiUrl}/tien-ich`, {
            method: 'POST',
            headers: {
                'Authorization': 'Bearer ' + token,
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify({ ten })
        });

        Swal.close();

        if (res.ok) {
            Swal.fire({ icon: "success", title: "Thành công!", text: "Đã thêm tiện ích mới vào danh mục!", confirmButtonColor: "#0284c7" });
            document.getElementById('tenTienIch').value = '';
            loadTienIch();
        } else {
            Swal.fire({ icon: "error", title: "Lỗi!", text: "Không thể thêm tiện ích lúc này!", confirmButtonColor: "#e11d48" });
        }
    });

    // 🚀 Tải dữ liệu khi mở trang
    loadTienIch();
</script>
@endsection