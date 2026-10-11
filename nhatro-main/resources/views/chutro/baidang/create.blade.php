@extends('layouts.chu-tro')

@section('title', 'Đăng Bài Cho Thuê Phòng - Hệ Thống Trọ')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if (session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Thành công!',
            text: '{{ session('success') }}',
            confirmButtonColor: '#0D9488'
        });
    </script>
@endif

@if ($errors->any())
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Đã xảy ra lỗi!',
            html: `{!! implode('<br>', $errors->all()) !!}`,
            confirmButtonColor: '#0D9488'
        });
    </script>
@endif

<div class="max-w-4xl mx-auto space-y-8 animate-fade-in">
    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-sky-100 dark:bg-sky-950 text-sky-700 dark:text-sky-300 mb-2">
                <i class="ri-add-box-line"></i> Đăng Tin Cho Thuê
            </div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 dark:text-white tracking-tight">
                Tạo Bài Đăng Cho Thuê Phòng
            </h1>
            <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 mt-1">
                Quảng bá phòng trọ đến hàng ngàn khách thuê tiềm năng với hình ảnh và tiện nghi trực quan
            </p>
        </div>

        <a href="{{ route('chu-tro.bai-dang.index') }}"
            class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-white dark:bg-slate-800 border border-slate-200/80 dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-700/50 text-slate-700 dark:text-slate-200 text-xs sm:text-sm font-bold shadow-xs transition">
            <i class="ri-arrow-left-line"></i>
            <span>Quay lại danh sách</span>
        </a>
    </div>

    {{-- Main Form --}}
    <form action="{{ route('chu-tro.bai-dang.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        {{-- 1. Chọn phòng có sẵn --}}
        <div class="bg-white dark:bg-slate-800 rounded-3xl border border-slate-200/80 dark:border-slate-700 shadow-sm p-6 sm:p-8 space-y-5">
            <div class="flex items-center gap-2 pb-3 border-b border-slate-100 dark:border-slate-700/60">
                <div class="w-8 h-8 rounded-xl bg-sky-50 dark:bg-sky-950/60 text-sky-600 flex items-center justify-center font-bold text-sm">
                    1
                </div>
                <h2 class="text-base font-bold text-slate-900 dark:text-white">
                    Chọn phòng cần đăng tin
                </h2>
            </div>

            <div class="space-y-2">
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300">
                    Phòng trọ có sẵn <span class="text-rose-500">*</span>
                </label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                        <i class="ri-door-open-line text-lg"></i>
                    </span>
                    <select name="phong_id" id="phongSelect" required
                        class="w-full pl-10 pr-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-900 text-slate-900 dark:text-white text-sm focus:bg-white dark:focus:bg-slate-900 focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 transition">
                        <option value="">-- Chọn phòng để đăng bài --</option>
                        @foreach ($phongList as $phong)
                            <option value="{{ $phong->id }}" data-dien-tich="{{ $phong->dien_tich }}" data-tang="{{ $phong->tang }}"
                                data-suc-chua="{{ $phong->suc_chua }}" data-trang-thai="{{ $phong->trang_thai }}"
                                data-day-tro="{{ $phong->dayTro->ten_day_tro }}">
                                {{ $phong->dayTro->ten_day_tro }} - Phòng {{ $phong->so_phong }} ({{ $phong->dien_tich }} m²)
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- Thông tin phòng tự động hiển thị khi chọn --}}
            <div id="phongInfo" class="p-4 rounded-2xl bg-sky-50/60 dark:bg-sky-950/40 border border-sky-100 dark:border-sky-900/40" style="display:none;">
                <h4 class="text-xs font-bold uppercase tracking-wider text-sky-700 dark:text-sky-300 mb-2 flex items-center gap-1.5">
                    <i class="ri-information-line"></i> Thông số phòng chọn:
                </h4>
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 text-xs text-slate-600 dark:text-slate-300">
                    <div>Dãy trọ: <span id="phongDayTro" class="font-bold text-slate-900 dark:text-white"></span></div>
                    <div>Diện tích: <span id="phongDienTich" class="font-bold text-slate-900 dark:text-white"></span> m²</div>
                    <div>Vị trí: Tầng <span id="phongTang" class="font-bold text-slate-900 dark:text-white"></span></div>
                    <div>Sức chứa: <span id="phongSucChua" class="font-bold text-slate-900 dark:text-white"></span> người</div>
                </div>
                <div class="mt-2 text-xs">
                    Trạng thái hiện tại: <span id="phongTrangThai" class="px-2 py-0.5 rounded-full text-[11px] font-bold bg-slate-200 dark:bg-slate-700 text-slate-700 dark:text-slate-200"></span>
                </div>
            </div>
        </div>

        {{-- 2. Thông tin bài đăng --}}
        <div class="bg-white dark:bg-slate-800 rounded-3xl border border-slate-200/80 dark:border-slate-700 shadow-sm p-6 sm:p-8 space-y-5">
            <div class="flex items-center gap-2 pb-3 border-b border-slate-100 dark:border-slate-700/60">
                <div class="w-8 h-8 rounded-xl bg-sky-50 dark:bg-sky-950/60 text-sky-600 flex items-center justify-center font-bold text-sm">
                    2
                </div>
                <h2 class="text-base font-bold text-slate-900 dark:text-white">
                    Thông tin hiển thị bài đăng
                </h2>
            </div>

            <div class="space-y-4">
                {{-- Tiêu đề --}}
                <div class="space-y-2">
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300">
                        Tiêu đề bài đăng <span class="text-rose-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <i class="ri-t-box-line text-lg"></i>
                        </span>
                        <input type="text" name="tieu_de" required
                            placeholder="VD: Phòng cao cấp full nội thất, giờ giấc tự do, gần trường ĐH"
                            class="w-full pl-10 pr-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-900 text-slate-900 dark:text-white placeholder-slate-400 text-sm focus:bg-white dark:focus:bg-slate-900 focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 transition">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    {{-- Giá niêm yết --}}
                    <div class="space-y-2">
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300">
                            Giá thuê niêm yết (VNĐ/tháng) <span class="text-rose-500">*</span>
                        </label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                <i class="ri-money-dollar-circle-line text-lg"></i>
                            </span>
                            <input type="number" name="gia_niem_yet" required min="0" placeholder="VD: 3200000"
                                class="w-full pl-10 pr-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-900 text-slate-900 dark:text-white placeholder-slate-400 text-sm focus:bg-white dark:focus:bg-slate-900 focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 transition">
                        </div>
                    </div>

                    {{-- Địa chỉ khu vực --}}
                    <div class="space-y-2">
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300">
                            Khu vực vị trí
                        </label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                <i class="ri-map-pin-line text-lg"></i>
                            </span>
                            <select name="dia_chi"
                                class="w-full pl-10 pr-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-900 text-slate-900 dark:text-white text-sm focus:bg-white dark:focus:bg-slate-900 focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 transition">
                                <option value="">-- Mặc định theo dãy trọ --</option>
                                @foreach($regions as $region)
                                    <option value="{{ $region->ten_dia_chi }}" {{ old('dia_chi') == $region->ten_dia_chi ? 'selected' : '' }}>
                                        {{ $region->ten_dia_chi }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                {{-- Mô tả --}}
                <div class="space-y-2">
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300">
                        Nội dung mô tả chi tiết <span class="text-rose-500">*</span>
                    </label>
                    <textarea name="mo_ta" rows="4" required
                        placeholder="Mô tả các đặc điểm nổi bật của phòng: gác lửng, ban công thoáng mát, an ninh vân tay, gần chợ/trường..."
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-900 text-slate-900 dark:text-white placeholder-slate-400 text-sm focus:bg-white dark:focus:bg-slate-900 focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 transition"></textarea>
                </div>
            </div>
        </div>

        {{-- 3. Tiện ích đi kèm --}}
        <div class="bg-white dark:bg-slate-800 rounded-3xl border border-slate-200/80 dark:border-slate-700 shadow-sm p-6 sm:p-8 space-y-5">
            <div class="flex items-center gap-2 pb-3 border-b border-slate-100 dark:border-slate-700/60">
                <div class="w-8 h-8 rounded-xl bg-sky-50 dark:bg-sky-950/60 text-sky-600 flex items-center justify-center font-bold text-sm">
                    3
                </div>
                <h2 class="text-base font-bold text-slate-900 dark:text-white">
                    Tiện ích & Dịch vụ phòng
                </h2>
            </div>

            <p class="text-xs text-slate-400">Chọn các tiện ích đã có sẵn hoặc thêm tiện ích mới cho phòng này:</p>

            <div id="tienIchContainer" class="flex flex-wrap gap-2.5">
                @foreach ($tienIchList as $dv)
                    <label class="inline-flex items-center gap-2 px-3.5 py-2 rounded-2xl border border-slate-200 dark:border-slate-700 bg-slate-50/70 dark:bg-slate-900/60 hover:bg-sky-50 dark:hover:bg-sky-950/40 text-xs font-semibold text-slate-700 dark:text-slate-300 cursor-pointer transition has-[:checked]:bg-sky-500 has-[:checked]:border-sky-500 has-[:checked]:text-white">
                        <input type="checkbox" name="tien_ich[]" value="{{ $dv->id }}" class="accent-sky-600 rounded">
                        <span>{{ $dv->ten }} ({{ number_format($dv->don_gia, 0, ',', '.') }}/{{ $dv->don_vi }})</span>
                    </label>
                @endforeach
            </div>

            {{-- Thêm tiện ích mới --}}
            <div class="flex items-center gap-3 pt-2">
                <input type="text" id="newTienIch" placeholder="Nhập tên tiện ích mới khác..."
                    class="flex-1 px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-900 text-slate-900 dark:text-white placeholder-slate-400 text-xs focus:bg-white dark:focus:bg-slate-900 focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 transition">
                <button type="button" id="addTienIchBtn"
                    class="inline-flex items-center gap-1.5 px-4 py-2.5 rounded-xl bg-slate-900 dark:bg-sky-600 text-white text-xs font-bold hover:bg-slate-800 transition shadow-xs">
                    <i class="ri-add-line"></i> Thêm tiện ích
                </button>
            </div>
        </div>

        {{-- 4. Tải lên hình ảnh --}}
        <div class="bg-white dark:bg-slate-800 rounded-3xl border border-slate-200/80 dark:border-slate-700 shadow-sm p-6 sm:p-8 space-y-5">
            <div class="flex items-center gap-2 pb-3 border-b border-slate-100 dark:border-slate-700/60">
                <div class="w-8 h-8 rounded-xl bg-sky-50 dark:bg-sky-950/60 text-sky-600 flex items-center justify-center font-bold text-sm">
                    4
                </div>
                <h2 class="text-base font-bold text-slate-900 dark:text-white">
                    Hình ảnh thực tế của phòng
                </h2>
            </div>

            <div id="uploadZone" class="border-2 border-dashed border-sky-300 dark:border-sky-800 rounded-3xl bg-sky-50/40 dark:bg-sky-950/20 p-8 text-center cursor-pointer hover:bg-sky-50 dark:hover:bg-sky-950/40 transition">
                <div class="w-14 h-14 rounded-2xl bg-white dark:bg-slate-800 text-sky-600 flex items-center justify-center mx-auto text-2xl shadow-sm mb-3">
                    <i class="ri-upload-cloud-2-line"></i>
                </div>
                <p class="text-sm font-bold text-slate-800 dark:text-slate-200">Kéo & thả ảnh vào đây hoặc bấm để tải lên</p>
                <p class="text-xs text-slate-400 mt-1">Định dạng JPG, PNG, WEBP (Khuyến nghị ít nhất 2 ảnh thực tế)</p>
                <input type="file" name="anh[]" id="anhInput" multiple accept="image/*" class="hidden">
                <button type="button" id="chooseBtn" class="mt-4 px-4 py-2 rounded-xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-xs font-bold text-slate-700 dark:text-slate-200 shadow-xs hover:bg-slate-50 transition">
                    Chọn tệp từ máy
                </button>
            </div>

            <div id="previewGrid" class="flex flex-wrap gap-3"></div>
        </div>

        {{-- Action Buttons --}}
        <div class="pt-4 flex items-center justify-end gap-3 border-t border-slate-200 dark:border-slate-700">
            <a href="{{ route('chu-tro.bai-dang.index') }}"
                class="px-5 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-700 dark:text-slate-300 hover:bg-slate-50 text-xs sm:text-sm font-bold transition">
                Hủy bỏ
            </a>
            <button type="submit"
                class="inline-flex items-center gap-2 px-6 py-2.5 rounded-xl bg-gradient-to-r from-sky-600 to-sky-500 hover:from-sky-700 hover:to-sky-600 text-white text-xs sm:text-sm font-bold shadow-lg shadow-sky-500/25 transition">
                <i class="ri-check-line text-base"></i>
                <span>Xuất Bản Bài Đăng</span>
            </button>
        </div>
    </form>
</div>

<script>
    // 🔹 Thêm tiện ích mới
    document.getElementById('addTienIchBtn').addEventListener('click', () => {
        const input = document.getElementById('newTienIch');
        const val = input.value.trim();
        if (!val) return alert('Nhập tên tiện ích mới!');

        const div = document.createElement('label');
        div.className = 'inline-flex items-center gap-2 px-3.5 py-2 rounded-2xl border border-sky-500 bg-sky-500 text-white text-xs font-semibold cursor-pointer';
        const id = 'new_' + Date.now();
        div.innerHTML = `<input type="checkbox" name="tien_ich_moi[]" value="${val}" id="${id}" checked class="accent-sky-600 rounded"> <span>${val}</span>`;
        document.getElementById('tienIchContainer').appendChild(div);
        input.value = '';
    });

    // 🔹 Upload & preview ảnh
    const uploadZone = document.getElementById('uploadZone');
    const anhInput = document.getElementById('anhInput');
    const previewGrid = document.getElementById('previewGrid');
    const chooseBtn = document.getElementById('chooseBtn');

    chooseBtn.onclick = () => anhInput.click();
    uploadZone.onclick = (e) => {
        if (e.target !== chooseBtn) anhInput.click();
    };

    uploadZone.addEventListener('dragover', e => {
        e.preventDefault();
        uploadZone.classList.add('border-sky-500', 'bg-sky-100/50');
    });
    uploadZone.addEventListener('dragleave', () => {
        uploadZone.classList.remove('border-sky-500', 'bg-sky-100/50');
    });
    uploadZone.addEventListener('drop', e => {
        e.preventDefault();
        uploadZone.classList.remove('border-sky-500', 'bg-sky-100/50');
        handleFiles(e.dataTransfer.files);
    });

    anhInput.addEventListener('change', e => handleFiles(e.target.files));

    function handleFiles(files) {
        previewGrid.innerHTML = '';
        const maxFiles = 10;
        if (files.length > maxFiles) {
            alert(`Tối đa chỉ được chọn ${maxFiles} ảnh.`);
            return;
        }

        for (const file of files) {
            if (!file.type.startsWith('image/')) {
                alert(`Tập tin "${file.name}" không phải là ảnh hợp lệ.`);
                continue;
            }

            const reader = new FileReader();
            reader.onload = e => {
                const wrap = document.createElement('div');
                wrap.className = 'relative w-28 h-24 rounded-2xl overflow-hidden border border-slate-200 dark:border-slate-700 shadow-xs';
                wrap.innerHTML = `<img src="${e.target.result}" alt="preview" class="w-full h-full object-cover">`;
                previewGrid.appendChild(wrap);
            };
            reader.readAsDataURL(file);
        }
    }

    // Hiển thị thông tin phòng khi chọn
    const phongSelect = document.getElementById('phongSelect');
    const phongInfo = document.getElementById('phongInfo');
    const fields = {
        dayTro: document.getElementById('phongDayTro'),
        dienTich: document.getElementById('phongDienTich'),
        tang: document.getElementById('phongTang'),
        sucChua: document.getElementById('phongSucChua'),
        trangThai: document.getElementById('phongTrangThai'),
    };

    phongSelect.addEventListener('change', function () {
        const opt = this.selectedOptions[0];
        if (!opt || !opt.value) {
            phongInfo.style.display = 'none';
            return;
        }
        fields.dayTro.textContent = opt.dataset.dayTro;
        fields.dienTich.textContent = opt.dataset.dienTich;
        fields.tang.textContent = opt.dataset.tang;
        fields.sucChua.textContent = opt.dataset.sucChua;
        fields.trangThai.textContent = opt.dataset.trangThai;
        phongInfo.style.display = 'block';
    });

    // Validation trước khi gửi form
    document.querySelector('form').addEventListener('submit', function (e) {
        const hasChecked = document.querySelectorAll(
            'input[name="tien_ich[]"]:checked, input[name="tien_ich_moi[]"]:checked'
        ).length;

        if (hasChecked === 0) {
            e.preventDefault();
            alert('Vui lòng chọn ít nhất một tiện ích!');
            return;
        }

        const files = document.getElementById('anhInput').files;
        if (files.length === 0) {
            e.preventDefault();
            alert('Bạn chưa chọn ảnh nào để đăng bài!');
            return;
        }

        Swal.fire({
            title: 'Đang xuất bản bài đăng...',
            text: 'Vui lòng chờ trong giây lát.',
            allowOutsideClick: false,
            didOpen: () => Swal.showLoading()
        });
    });
</script>
@endsection