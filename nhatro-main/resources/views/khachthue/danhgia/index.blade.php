@extends('layouts.tenant-layout')

@section('title', 'Đánh giá & Review - Nền Tảng Trọ Thông Minh')
@section('page_title', 'Đánh giá & Nhận xét trải nghiệm')
@section('page_subtitle', 'Chia sẻ cảm nhận thực tế về chất lượng phòng và độ thân thiện của chủ nhà để đóng góp cho cộng đồng')

@section('tenant_content')
@php
    $hopDongList = collect($hopDong ?? []);
    $danhGiaList = collect($danhGia ?? []);
@endphp

<div x-data="{
    rating: 5,
    hoverRating: 0,
    tags: ['An ninh tốt', 'Chủ nhà nhiệt tình', 'Vệ sinh sạch sẽ', 'Giờ giấc tự do'],
    selectedTags: [],

    toggleTag(t) {
        if (this.selectedTags.includes(t)) {
            this.selectedTags = this.selectedTags.filter(x => x !== t);
        } else {
            this.selectedTags.push(t);
        }
    },

    get ratingLabel() {
        const val = this.hoverRating || this.rating;
        const labels = {
            1: '1 sao - Rất thất vọng, nhiều bất cập',
            2: '2 sao - Chưa hài lòng, cần cải thiện',
            3: '3 sao - Tạm ổn, chất lượng bình thường',
            4: '4 sao - Rất hài lòng, phòng ốc tiện nghi',
            5: '5 sao - Tuyệt vời! Rất đáng để ở lâu dài'
        };
        return labels[val] || '';
    }
}" class="space-y-8">

    {{-- TOP ACTION & KPI SUMMARY --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-xl sm:text-2xl font-black text-slate-900 dark:text-white tracking-tight">
                Cộng Đồng Đánh Giá Cư Dân
            </h2>
            <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 mt-1">
                Các đánh giá của bạn là nguồn thông tin chân thực nhất bảo vệ quyền lợi người thuê
            </p>
        </div>

        <div class="flex items-center gap-2">
            <span class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full text-xs font-black bg-amber-50 dark:bg-amber-950/60 text-amber-700 dark:text-amber-300 border border-amber-200/60 shadow-xs">
                <i class="ri-star-smile-fill text-amber-500"></i>
                <span>Bạn đã gửi {{ $danhGiaList->count() }} đánh giá</span>
            </span>
        </div>
    </div>

    {{-- FLASH MESSAGES --}}
    @if(session('success'))
        <div class="p-4 rounded-2xl bg-emerald-50 dark:bg-emerald-950/60 border border-emerald-200 dark:border-emerald-800 text-emerald-800 dark:text-emerald-200 flex items-center gap-3">
            <i class="ri-checkbox-circle-fill text-xl text-emerald-600"></i>
            <span class="text-sm font-semibold">{{ session('success') }}</span>
        </div>
    @endif
    @if(session('error'))
        <div class="p-4 rounded-2xl bg-rose-50 dark:bg-rose-950/60 border border-rose-200 dark:border-rose-800 text-rose-800 dark:text-rose-200 flex items-center gap-3">
            <i class="ri-error-warning-fill text-xl text-rose-600"></i>
            <span class="text-sm font-semibold">{{ session('error') }}</span>
        </div>
    @endif

    {{-- FORM ĐÁNH GIÁ MỚI --}}
    <div class="bg-white dark:bg-slate-800/90 rounded-3xl p-6 sm:p-8 border border-slate-200/80 dark:border-slate-700 shadow-sm space-y-6">
        <div class="flex items-center gap-3 border-b border-slate-100 dark:border-slate-700/60 pb-4">
            <div class="w-10 h-10 rounded-2xl bg-amber-50 dark:bg-amber-950 text-amber-500 flex items-center justify-center text-xl font-bold">
                <i class="ri-edit-2-line"></i>
            </div>
            <div>
                <h3 class="text-base font-black text-slate-900 dark:text-white">Viết Đánh Giá Căn Hộ Của Bạn</h3>
                <p class="text-xs text-slate-400">Chọn hợp đồng thuê phòng và xếp hạng mức độ hài lòng</p>
            </div>
        </div>

        <form action="{{ route('khach-thue.danh-gia.store') }}" method="POST" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Chọn hợp đồng phòng --}}
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-300 mb-2">
                        Chọn hợp đồng phòng đang thuê <span class="text-rose-500">*</span>
                    </label>
                    <div class="relative">
                        <select name="hop_dong_id" required
                            class="w-full px-4 py-3 text-sm rounded-2xl border border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-900 focus:bg-white focus:ring-2 focus:ring-sky-500 font-medium">
                            <option value="">-- Chọn phòng cần đánh giá --</option>
                            @foreach ($hopDongList as $hd)
                                @php
                                    $phong = $hd['phong'] ?? [];
                                    $dayTro = $phong['day_tro'] ?? [];
                                    $daDanhGia = $danhGiaList->contains('hop_dong_id', $hd['id']);
                                @endphp
                                <option value="{{ $hd['id'] }}" {{ $daDanhGia ? 'disabled' : '' }}>
                                    Phòng {{ $phong['so_phong'] ?? 'Phòng' }} - {{ $dayTro['ten_day_tro'] ?? 'Khu trọ' }}
                                    {{ $daDanhGia ? ' (Đã gửi đánh giá)' : '' }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- Interactive 5-Star Rating Picker --}}
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-300 mb-2">
                        Chấm điểm mức độ hài lòng <span class="text-rose-500">*</span>
                    </label>

                    <div class="flex items-center gap-2">
                        <div class="flex items-center gap-1.5">
                            @for ($s = 1; $s <= 5; $s++)
                                <button type="button"
                                    @mouseenter="hoverRating = {{ $s }}"
                                    @mouseleave="hoverRating = 0"
                                    @click="rating = {{ $s }}"
                                    class="text-3xl star-hover focus:outline-none">
                                    <i :class="(hoverRating || rating) >= {{ $s }} ? 'ri-star-fill text-amber-400' : 'ri-star-line text-slate-300'"></i>
                                </button>
                            @endfor
                        </div>
                        <input type="hidden" name="diem_so" :value="rating">
                    </div>

                    <p class="text-xs font-bold text-amber-600 mt-2" x-text="ratingLabel"></p>
                </div>
            </div>

            {{-- Quick Tag Pills --}}
            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-300 mb-2">
                    Điểm nổi bật của phòng trọ (Bấm để thêm vào nội dung)
                </label>
                <div class="flex flex-wrap gap-2">
                    <template x-for="t in tags" :key="t">
                        <button type="button" @click="toggleTag(t)"
                            :class="selectedTags.includes(t) ? 'bg-sky-600 text-white font-bold border-sky-600 shadow-xs' : 'bg-slate-50 dark:bg-slate-900 text-slate-600 dark:text-slate-300 border-slate-200 dark:border-slate-700'"
                            class="px-3 py-1.5 rounded-xl border text-xs transition flex items-center gap-1 micro-press">
                            <span x-text="t"></span>
                            <i x-show="selectedTags.includes(t)" class="ri-check-line text-xs font-bold"></i>
                        </button>
                    </template>
                </div>
            </div>

            {{-- Comment Textarea --}}
            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-300 mb-2">
                    Cảm nhận & Nhận xét chi tiết
                </label>
                <textarea name="binh_luan" rows="4" required
                    class="w-full px-4 py-3 text-sm rounded-2xl border border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-900 focus:bg-white focus:ring-2 focus:ring-sky-500 font-medium input-focus-smooth"
                    placeholder="Hãy chia sẻ trải nghiệm về không gian sống, an ninh, tiện ích và thái độ hỗ trợ của chủ nhà..."></textarea>
            </div>

            <div class="flex justify-end">
                <button type="submit"
                    class="px-6 py-3 rounded-2xl bg-gradient-to-r from-sky-600 to-indigo-600 hover:from-sky-700 hover:to-indigo-700 text-white font-extrabold text-xs sm:text-sm shadow-lg shadow-sky-600/25 transition flex items-center gap-2 micro-press">
                    <i class="ri-send-plane-fill text-lg"></i>
                    <span>Đăng Đánh Giá Trải Nghiệm</span>
                </button>
            </div>
        </form>
    </div>

    {{-- DANH SÁCH REVIEW ĐÃ GỬI --}}
    <div class="space-y-4">
        <h3 class="text-base font-black text-slate-900 dark:text-white flex items-center gap-2">
            <i class="ri-chat-smile-2-fill text-sky-500"></i> Các Nhận Xét Bạn Đã Đóng Góp
        </h3>

        @if($danhGiaList->isEmpty())
            <div class="bg-white dark:bg-slate-800/90 rounded-3xl p-8 border border-dashed border-slate-200 dark:border-slate-700 text-center text-xs text-slate-400">
                Bạn chưa gửi đánh giá nào. Hãy viết đánh giá đầu tiên cho căn phòng bạn đang thuê phía trên!
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                @foreach ($danhGiaList as $dg)
                    @php
                        $stars = (int)($dg['diem_so'] ?? 5);
                        $hopDong = $dg['hop_dong'] ?? [];
                        $phong = $hopDong['phong'] ?? [];
                        $dayTro = $phong['day_tro'] ?? [];
                    @endphp
                    <div class="bg-white dark:bg-slate-800/90 rounded-3xl p-5 border border-slate-200/80 dark:border-slate-700 shadow-sm space-y-3">
                        <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-800 pb-3">
                            <div class="flex items-center gap-1 text-amber-400 text-base">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="{{ $i <= $stars ? 'ri-star-fill' : 'ri-star-line text-slate-200 dark:text-slate-700' }}"></i>
                                @endfor
                                <span class="text-xs font-black text-slate-700 dark:text-slate-200 ml-1.5">{{ $stars }}.0</span>
                            </div>

                            <span class="text-[11px] text-slate-400 flex items-center gap-1">
                                <i class="ri-time-line"></i>
                                {{ \Carbon\Carbon::parse($dg['ngay_tao'])->format('d/m/Y') }}
                            </span>
                        </div>

                        <p class="text-xs sm:text-sm text-slate-700 dark:text-slate-300 leading-relaxed italic">
                            "{{ $dg['binh_luan'] ?? 'Không có nhận xét chi tiết.' }}"
                        </p>

                        <div class="flex items-center justify-between text-[11px] text-slate-400 pt-2 border-t border-slate-100 dark:border-slate-800">
                            <span class="font-bold text-slate-600 dark:text-slate-300">
                                Phòng {{ $phong['so_phong'] ?? '—' }} • {{ $dayTro['ten_day_tro'] ?? 'Khu trọ' }}
                            </span>

                            <span class="text-emerald-600 font-bold flex items-center gap-1">
                                <i class="ri-shield-check-fill"></i> Đã xác thực cư dân
                            </span>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

</div>
@endsection
