@extends('layouts.chu-tro')

@section('title', 'Quản lý Chỉ số Điện Nước - Hệ Thống Trọ')

@section('content')
<div class="max-w-7xl mx-auto space-y-8 animate-fade-in">
    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-amber-100 dark:bg-amber-950 text-amber-700 dark:text-amber-300 mb-2">
                <i class="ri-flashlight-line"></i> Dịch vụ & Tiện ích
            </div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 dark:text-white tracking-tight">
                Chỉ số Điện & Nước
            </h1>
            <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 mt-1">
                Ghi nhận chỉ số công tơ điện nước định kỳ để tự động tính tiền vào hóa đơn hàng tháng
            </p>
        </div>

        <a href="{{ route('chu-tro.dashboard') }}"
            class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-white dark:bg-slate-800 border border-slate-200/80 dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-700/50 text-slate-700 dark:text-slate-200 text-xs sm:text-sm font-bold shadow-xs transition">
            <i class="ri-arrow-left-line"></i>
            <span>Bảng điều khiển</span>
        </a>
    </div>

    {{-- Form nhập chỉ số mới --}}
    <div class="bg-white dark:bg-slate-800 shadow-sm rounded-3xl p-6 border border-slate-200/80 dark:border-slate-700 space-y-5">
        <div class="flex items-center gap-2 border-b border-slate-100 dark:border-slate-700/60 pb-3">
            <div class="w-8 h-8 rounded-xl bg-sky-50 dark:bg-sky-950/60 text-sky-600 dark:text-sky-400 flex items-center justify-center text-base">
                <i class="ri-pencil-fill"></i>
            </div>
            <h2 class="text-base font-extrabold text-slate-900 dark:text-white">Nhập chỉ số công tơ mới</h2>
        </div>

        <form id="formAddChiSo" class="grid grid-cols-1 md:grid-cols-5 gap-4">
            {{-- Phòng --}}
            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400 mb-1.5">Phòng</label>
                <select id="phong_id" name="phong_id"
                    class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-xs sm:text-sm font-semibold text-slate-800 dark:text-slate-100 focus:outline-none focus:ring-2 focus:ring-sky-500">
                    <option value="">-- Chọn phòng --</option>
                </select>
            </div>

            {{-- Đồng hồ --}}
            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400 mb-1.5">Đồng hồ</label>
                <select id="dong_ho_id" name="dong_ho_id"
                    class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-xs sm:text-sm font-semibold text-slate-800 dark:text-slate-100 focus:outline-none focus:ring-2 focus:ring-sky-500">
                    <option value="">-- Chọn đồng hồ --</option>
                </select>
            </div>

            {{-- Chỉ số mới --}}
            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400 mb-1.5">Chỉ số mới</label>
                <input type="number" id="gia_tri" name="gia_tri"
                    class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-xs sm:text-sm font-semibold text-slate-800 dark:text-slate-100 focus:outline-none focus:ring-2 focus:ring-sky-500"
                    placeholder="VD: 150">
            </div>

            {{-- Ngày cập nhật --}}
            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400 mb-1.5">Ngày ghi</label>
                <input type="date" id="thoi_gian" name="thoi_gian"
                    class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-xs sm:text-sm font-semibold text-slate-800 dark:text-slate-100 focus:outline-none focus:ring-2 focus:ring-sky-500">
            </div>

            {{-- Ghi chú --}}
            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400 mb-1.5">Ghi chú</label>
                <input type="text" id="ghi_chu" name="ghi_chu"
                    class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-xs sm:text-sm font-semibold text-slate-800 dark:text-slate-100 focus:outline-none focus:ring-2 focus:ring-sky-500"
                    placeholder="VD: Tháng 10">
            </div>

            <div class="col-span-1 md:col-span-5 flex justify-end pt-2">
                <button type="submit"
                    class="px-6 py-2.5 bg-gradient-to-r from-sky-600 to-sky-500 hover:from-sky-700 text-white rounded-xl text-xs sm:text-sm font-bold flex items-center justify-center gap-1.5 shadow-lg shadow-sky-500/25 transition">
                    <i class="ri-save-3-line text-base"></i> Lưu chỉ số
                </button>
            </div>
        </form>
    </div>

    {{-- Bộ lọc & Lịch sử chỉ số --}}
    <div class="bg-white dark:bg-slate-800 shadow-sm rounded-3xl border border-slate-200/80 dark:border-slate-700 overflow-hidden">
        {{-- Toolbar lọc --}}
        <div class="p-5 border-b border-slate-100 dark:border-slate-700/60 flex flex-col sm:flex-row items-center justify-between gap-4">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 rounded-xl bg-amber-50 dark:bg-amber-950/60 text-amber-600 dark:text-amber-400 flex items-center justify-center text-base">
                    <i class="ri-history-line"></i>
                </div>
                <h3 class="text-base font-extrabold text-slate-900 dark:text-white">Lịch sử ghi chỉ số</h3>
            </div>

            <div class="flex items-center gap-3 w-full sm:w-auto">
                <select id="filterPhong" class="px-3.5 py-2 rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-xs sm:text-sm font-semibold text-slate-800 dark:text-slate-100 focus:outline-none focus:ring-2 focus:ring-sky-500">
                    <option value="">Tất cả phòng</option>
                </select>

                <button id="btnRefresh"
                    class="px-4 py-2 bg-slate-100 hover:bg-slate-200 dark:bg-slate-700 dark:hover:bg-slate-600 rounded-xl text-xs sm:text-sm font-bold text-slate-700 dark:text-slate-200 flex items-center gap-1.5 transition">
                    <i class="ri-refresh-line"></i> Làm mới
                </button>
            </div>
        </div>

        {{-- Table --}}
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/80 dark:bg-slate-900/50 border-b border-slate-200/80 dark:border-slate-700 text-[11px] font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">
                        <th class="py-4 px-4">Phòng</th>
                        <th class="py-4 px-4">Loại đồng hồ</th>
                        <th class="py-4 px-4 text-center">Chỉ số cũ</th>
                        <th class="py-4 px-4 text-center">Chỉ số mới</th>
                        <th class="py-4 px-4 text-center">Ngày ghi</th>
                        <th class="py-4 px-4">Ghi chú</th>
                        <th class="py-4 px-5 text-center">Hành động</th>
                    </tr>
                </thead>
                <tbody id="tableChiSo" class="divide-y divide-slate-100 dark:divide-slate-700/60 text-xs sm:text-sm text-slate-700 dark:text-slate-300"></tbody>
            </table>
        </div>
    </div>
</div>

    {{-- Modal sửa chỉ số --}}
    <div id="editModal" class="hidden fixed inset-0 bg-black/40 flex items-center justify-center z-50">
        <div class="bg-white w-full max-w-md rounded-2xl shadow-lg p-6 space-y-4">
            <h3 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
                <i class="ri-edit-2-line text-yellow-500"></i> Sửa chỉ số
            </h3>

            <form id="formEditChiSo" class="space-y-3">
                <input type="hidden" id="edit_id">
                <div>
                    <label class="text-sm text-gray-500">Phòng</label>
                    <input type="text" id="edit_phong" disabled
                        class="w-full border-gray-200 rounded-xl bg-gray-100 text-gray-600 px-3 py-2">
                </div>

                <div>
                    <label class="text-sm text-gray-500">Chỉ số mới</label>
                    <input type="number" id="edit_gia_tri"
                        class="w-full border-gray-200 rounded-xl px-3 py-2 focus:ring-2 focus:ring-indigo-400">
                </div>

                <div>
                    <label class="text-sm text-gray-500">Ghi chú</label>
                    <input type="text" id="edit_ghi_chu"
                        class="w-full border-gray-200 rounded-xl px-3 py-2 focus:ring-2 focus:ring-indigo-400">
                </div>

                <div class="flex justify-end gap-3 mt-4">
                    <button type="button" id="btnCancelEdit"
                        class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-xl transition">
                        Hủy
                    </button>
                    <button type="submit"
                        class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl transition flex items-center gap-1">
                        <i class="ri-check-line"></i> Lưu thay đổi
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const apiUrl = 'http://127.0.0.1:8000/api/chu-tro';
            const token = localStorage.getItem("token");
            if (!token) {
                alert("Bạn chưa đăng nhập! Vui lòng đăng nhập lại.");
                window.location.href = "http://127.0.0.1:8001/login";
                return;
            }

            const form = document.querySelector('#formAddChiSo');
            const phongSelect = document.querySelector('#phong_id');
            const dongHoSelect = document.querySelector('#dong_ho_id');
            const tableBody = document.querySelector('#tableChiSo');
            const filterPhong = document.querySelector('#filterPhong');
            const btnRefresh = document.querySelector('#btnRefresh');
            const modal = document.querySelector('#editModal');
            const btnCancel = document.querySelector('#btnCancelEdit');
            const formEdit = document.querySelector('#formEditChiSo');

            fetch(apiUrl + '/danh-sach-phong-dang-su-dung', {
                headers: { "Authorization": "Bearer " + token, "Accept": "application/json" }
            })
                .then(res => res.json())
                .then(phongs => {
                    phongSelect.innerHTML = '<option value="">-- Chọn phòng --</option>';
                    filterPhong.innerHTML = '<option value="">Tất cả phòng</option>';
                    phongs.forEach(p => {
                        const tenDay = p.day_tro?.ten_day_tro ?? 'Không rõ dãy';
                        phongSelect.innerHTML += `<option value="${p.id}">${tenDay} - ${p.so_phong}</option>`;
                        filterPhong.innerHTML += `<option value="${p.so_phong}">${p.so_phong}</option>`;
                    });
                });

            phongSelect.addEventListener('change', async e => {
                const phongId = e.target.value;
                dongHoSelect.innerHTML = '<option value="">-- Chọn đồng hồ --</option>';
                if (!phongId) return;
                const res = await fetch(`${apiUrl}/dong-ho?phong_id=${phongId}`, {
                    headers: { "Authorization": "Bearer " + token, "Accept": "application/json" }
                });
                const data = await res.json();
                data.forEach(dh => {
                    const opt = document.createElement('option');
                    opt.value = dh.id;
                    opt.textContent = `${dh.ma_dong_ho} (${dh.dich_vu?.ten ?? 'Chưa rõ'})`;
                    dongHoSelect.appendChild(opt);
                });
            });

            function loadChiSo(phongFilter = '') {
                fetch(apiUrl + '/chi-so', {
                    headers: { "Authorization": "Bearer " + token, "Accept": "application/json" }
                })
                    .then(res => res.json())
                    .then(data => {
                        const filtered = phongFilter ? data.filter(cs => cs.phong === phongFilter) : data;
                        tableBody.innerHTML = filtered.map(cs => `
                                                                            <tr class="hover:bg-gray-50 transition">
                                                                                <td class="px-4 py-2 font-medium">${cs.phong}</td>
                                                                                <td class="px-4 py-2">${cs.dich_vu}</td>
                                                                                <td class="px-4 py-2 text-gray-400">${cs.chi_so_cu ?? '0'}</td>
                                                                                <td class="px-4 py-2 text-indigo-600 font-semibold">${cs.chi_so_moi ?? '0'}</td>
                                                                                <td class="px-4 py-2">${cs.thoi_gian ?? '-'}</td>
                                                                                <td class="px-4 py-2 text-gray-500">${cs.ghi_chu ?? ''}</td>
                                                                                <td class="px-4 py-2 text-center">
                ${cs.trang_thai_hoa_don === 'da_thanh_toan'
                                ? `<span class="text-gray-400 text-xs italic">Đã thanh toán</span>`
                                : `<button onclick="editChiSo(${cs.id}, ${cs.chi_so_moi ?? 0}, '${cs.ghi_chu ?? ''}', '${cs.phong}')"
                        class="px-3 py-1 text-xs bg-yellow-100 hover:bg-yellow-200 text-yellow-700 rounded-lg">
                        <i class="ri-edit-2-line"></i> Sửa
                       </button>`
                            }
            </td>

                                                                            </tr>
                                                                        `).join('');
                    });
            }

            loadChiSo();
            filterPhong.addEventListener('change', e => loadChiSo(e.target.value));
            btnRefresh.addEventListener('click', () => { filterPhong.value = ''; loadChiSo(); });

            window.editChiSo = function (id, giaTri, ghiChu, phong) {
                modal.classList.remove('hidden');
                document.querySelector('#edit_id').value = id;
                document.querySelector('#edit_phong').value = phong;
                document.querySelector('#edit_gia_tri').value = giaTri;
                document.querySelector('#edit_ghi_chu').value = ghiChu || '';
            };

            btnCancel.addEventListener('click', () => modal.classList.add('hidden'));

            formEdit.addEventListener('submit', e => {
                e.preventDefault();
                const id = document.querySelector('#edit_id').value;
                const giaTri = document.querySelector('#edit_gia_tri').value;
                const ghiChu = document.querySelector('#edit_ghi_chu').value;
                fetch(`${apiUrl}/chi-so/${id}`, {
                    method: "PUT",
                    headers: {
                        "Authorization": "Bearer " + token,
                        "Accept": "application/json",
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify({ gia_tri: giaTri, ghi_chu: ghiChu })
                })
                    .then(res => res.json())
                    .then(res => {
                        alert(res.message || 'Cập nhật thành công!');
                        modal.classList.add('hidden');
                        loadChiSo();
                    })
                    .catch(err => {
                        console.error("Lỗi khi cập nhật:", err);
                        alert("❌ Không thể cập nhật chỉ số!");
                    });
            });

            form.addEventListener('submit', e => {
                e.preventDefault();
                const formData = new FormData(form);
                fetch(apiUrl + '/chi-so', {
                    method: 'POST',
                    headers: { "Authorization": "Bearer " + token, "Accept": "application/json" },
                    body: formData
                })
                    .then(res => res.json())
                    .then(res => {
                        alert(res.message || 'Lưu thành công!');
                        form.reset();
                        loadChiSo();
                    });
            });
        });
    </script>
@endsection