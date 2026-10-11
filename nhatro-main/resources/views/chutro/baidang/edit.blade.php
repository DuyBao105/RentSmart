@extends('layouts.chu-tro')

@section('title', 'Chỉnh sửa bài đăng - Hệ Thống Trọ')

@section('content')
<div class="max-w-4xl mx-auto space-y-8 animate-fade-in">
    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-amber-100 dark:bg-amber-950 text-amber-700 dark:text-amber-300 mb-2">
                <i class="ri-edit-box-line"></i> Cập Nhật Bài Đăng
            </div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 dark:text-white tracking-tight">
                Chỉnh Sửa Bài Đăng Cho Thuê
            </h1>
            <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 mt-1">
                Cập nhật tiêu đề, giá thuê, nội dung mô tả hoặc quản lý ảnh thực tế
            </p>
        </div>

        <div class="flex items-center gap-3">
            <a href="{{ route('chu-tro.bai-dang.show', $post->id) }}"
                class="inline-flex items-center gap-1.5 px-4 py-2.5 rounded-xl bg-white dark:bg-slate-800 border border-slate-200/80 dark:border-slate-700 hover:bg-slate-50 text-slate-700 dark:text-slate-200 text-xs sm:text-sm font-bold shadow-xs transition">
                <i class="ri-eye-line text-sky-500"></i>
                <span>Xem tin</span>
            </a>
            <a href="{{ route('chu-tro.bai-dang.index') }}"
                class="inline-flex items-center gap-1.5 px-4 py-2.5 rounded-xl bg-white dark:bg-slate-800 border border-slate-200/80 dark:border-slate-700 hover:bg-slate-50 text-slate-700 dark:text-slate-200 text-xs sm:text-sm font-bold shadow-xs transition">
                <i class="ri-arrow-left-line"></i>
                <span>Danh sách</span>
            </a>
        </div>
    </div>

    {{-- Main Form --}}
    <form action="{{ route('chu-tro.bai-dang.update', $post->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        {{-- 1. Thông tin bài đăng --}}
        <div class="bg-white dark:bg-slate-800 rounded-3xl border border-slate-200/80 dark:border-slate-700 shadow-sm p-6 sm:p-8 space-y-5">
            <div class="flex items-center gap-2 pb-3 border-b border-slate-100 dark:border-slate-700/60">
                <div class="w-8 h-8 rounded-xl bg-sky-50 dark:bg-sky-950/60 text-sky-600 flex items-center justify-center font-bold text-sm">
                    1
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
                        <input type="text" name="tieu_de" value="{{ old('tieu_de', $post->tieu_de) }}" required
                            class="w-full pl-10 pr-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-900 text-slate-900 dark:text-white text-sm focus:bg-white dark:focus:bg-slate-900 focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 transition">
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
                            <input type="number" name="gia_niem_yet" value="{{ old('gia_niem_yet', $post->gia_niem_yet) }}" required min="0"
                                class="w-full pl-10 pr-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-900 text-slate-900 dark:text-white text-sm focus:bg-white dark:focus:bg-slate-900 focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 transition">
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
                                    <option value="{{ $region->ten_dia_chi }}" {{ (old('dia_chi', $post->dia_chi) == $region->ten_dia_chi) ? 'selected' : '' }}>
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
                    <textarea name="mo_ta" rows="5" required
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-900 text-slate-900 dark:text-white text-sm focus:bg-white dark:focus:bg-slate-900 focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 transition">{{ old('mo_ta', $post->mo_ta) }}</textarea>
                </div>
            </div>
        </div>

        {{-- 2. Quản lý hình ảnh hiện tại --}}
        <div class="bg-white dark:bg-slate-800 rounded-3xl border border-slate-200/80 dark:border-slate-700 shadow-sm p-6 sm:p-8 space-y-5">
            <div class="flex items-center gap-2 pb-3 border-b border-slate-100 dark:border-slate-700/60">
                <div class="w-8 h-8 rounded-xl bg-sky-50 dark:bg-sky-950/60 text-sky-600 flex items-center justify-center font-bold text-sm">
                    2
                </div>
                <h2 class="text-base font-bold text-slate-900 dark:text-white">
                    Hình ảnh hiện tại của bài đăng
                </h2>
            </div>

            <p class="text-xs text-slate-400">Bấm nút xóa (✕) trên góc ảnh nếu bạn muốn gỡ bỏ ảnh đó:</p>

            <div class="flex flex-wrap gap-3" id="currentImages">
                @forelse ($post->anh as $img)
                    <div class="relative w-32 h-24 rounded-2xl overflow-hidden border border-slate-200 dark:border-slate-700 group shadow-xs">
                        <img src="{{ $img->url }}" alt="Ảnh bài đăng" class="w-full h-full object-cover">
                        <button type="button" class="remove-btn absolute top-1.5 right-1.5 w-6 h-6 rounded-full bg-rose-500 hover:bg-rose-600 text-white flex items-center justify-center text-xs font-bold shadow-md transition"
                            data-id="{{ $img->id }}" title="Xóa ảnh này">
                            ✕
                        </button>
                        <input type="hidden" name="keep_anh_cu[]" value="{{ $img->id }}">
                    </div>
                @empty
                    <p class="text-xs text-slate-400 italic">Chưa có ảnh nào.</p>
                @endforelse
            </div>
        </div>

        {{-- 3. Tải lên thêm ảnh mới --}}
        <div class="bg-white dark:bg-slate-800 rounded-3xl border border-slate-200/80 dark:border-slate-700 shadow-sm p-6 sm:p-8 space-y-5">
            <div class="flex items-center gap-2 pb-3 border-b border-slate-100 dark:border-slate-700/60">
                <div class="w-8 h-8 rounded-xl bg-sky-50 dark:bg-sky-950/60 text-sky-600 flex items-center justify-center font-bold text-sm">
                    3
                </div>
                <h2 class="text-base font-bold text-slate-900 dark:text-white">
                    Tải lên thêm ảnh mới
                </h2>
            </div>

            <div id="uploadZone" class="border-2 border-dashed border-sky-300 dark:border-sky-800 rounded-3xl bg-sky-50/40 dark:bg-sky-950/20 p-8 text-center cursor-pointer hover:bg-sky-50 dark:hover:bg-sky-950/40 transition">
                <div class="w-14 h-14 rounded-2xl bg-white dark:bg-slate-800 text-sky-600 flex items-center justify-center mx-auto text-2xl shadow-sm mb-3">
                    <i class="ri-upload-cloud-2-line"></i>
                </div>
                <p class="text-sm font-bold text-slate-800 dark:text-slate-200">Kéo & thả ảnh mới vào đây hoặc bấm để tải lên</p>
                <p class="text-xs text-slate-400 mt-1">Định dạng JPG, PNG, WEBP</p>
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
                <i class="ri-save-3-line text-base"></i>
                <span>Lưu Thay Đổi</span>
            </button>
        </div>
    </form>
</div>

<script>
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
        for (const file of files) {
            if (!file.type.startsWith('image/')) continue;
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

    // Xóa ảnh cũ
    document.querySelectorAll('.remove-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            const id = this.dataset.id;
            this.closest('.relative').remove();
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'xoa_anh_cu[]';
            input.value = id;
            document.querySelector('form').appendChild(input);
        });
    });
</script>
@endsection