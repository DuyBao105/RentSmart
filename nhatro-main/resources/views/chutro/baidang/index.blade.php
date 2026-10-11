@extends('layouts.chu-tro')

@section('title', 'Quản lý Tin Đăng Cho Thuê - Hệ Thống Trọ')
@section('header_title', 'Danh Sách Tin Đăng Thị Trường')
@section('header_subtitle', 'Theo dõi tình trạng hiển thị, lượt xem và quản lý tin đăng của bạn trên cổng công khai')

@section('content')
<div class="max-w-7xl mx-auto space-y-6 animate-fade-in">
    {{-- Header Actions --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white dark:bg-[#181B19] p-6 rounded-xl border border-[#E5E3DC] dark:border-[#282D2A] shadow-2xs">
        <div>
            <div class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded text-[10px] font-bold bg-[#E5EDE8] dark:bg-[#23352B] text-[#1B3D2F] dark:text-[#8BB39D] uppercase tracking-wider mb-1.5">
                <i class="ri-article-line"></i> Quản lý niêm yết
            </div>
            <h1 class="text-xl sm:text-2xl font-black text-[#171A19] dark:text-white tracking-tight">
                Tin Đăng Cho Thuê
            </h1>
            <p class="text-xs text-[#85877F] mt-0.5">
                Quản lý các phòng đang được phát hành trên mạng lưới tìm kiếm phòng toàn quốc
            </p>
        </div>

        <div class="flex items-center gap-2.5">
            <a href="{{ route('chu-tro.dashboard') }}"
                class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-lg bg-[#FAF9F6] dark:bg-[#222724] border border-[#E5E3DC] dark:border-[#282D2A] text-[#171A19] dark:text-[#EAE8E1] text-xs font-bold hover:border-[#1B3D2F] transition">
                <i class="ri-arrow-left-line"></i>
                <span>Bảng điều khiển</span>
            </a>

            <a href="{{ route('chu-tro.bai-dang.create') }}"
                class="inline-flex items-center gap-1.5 px-4 py-2 rounded-lg bg-[#1B3D2F] hover:bg-[#142E23] text-white font-bold text-xs shadow-2xs transition">
                <i class="ri-add-line text-sm"></i>
                <span>Tạo bài đăng mới</span>
            </a>
        </div>
    </div>

    {{-- Alert Messages --}}
    @if (session('success'))
        <div class="p-3.5 rounded-lg bg-[#E5EDE8] dark:bg-[#23352B] border border-[#C7D9CE] dark:border-[#2D4537] text-[#1B3D2F] dark:text-[#8BB39D] text-xs font-semibold flex items-center justify-between">
            <div class="flex items-center gap-2">
                <i class="ri-checkbox-circle-line text-base text-[#1B3D2F] dark:text-[#8BB39D]"></i>
                <span>{{ session('success') }}</span>
            </div>
        </div>
    @endif
    @if (session('error'))
        <div class="p-3.5 rounded-lg bg-rose-50 dark:bg-rose-950/40 border border-rose-200 dark:border-rose-900 text-rose-800 dark:text-rose-200 text-xs font-semibold flex items-center justify-between">
            <div class="flex items-center gap-2">
                <i class="ri-error-warning-line text-base text-rose-600"></i>
                <span>{{ session('error') }}</span>
            </div>
        </div>
    @endif

    {{-- Filter & Search Bar --}}
    <form method="GET" class="bg-white dark:bg-[#181B19] p-3.5 rounded-xl border border-[#E5E3DC] dark:border-[#282D2A] shadow-2xs flex flex-col md:flex-row gap-3 items-center justify-between">
        <div class="relative w-full md:w-84">
            <i class="ri-search-line absolute left-3 top-1/2 -translate-y-1/2 text-[#85877F] text-sm"></i>
            <input type="text" name="search" placeholder="Tìm theo tiêu đề, địa chỉ..."
                value="{{ request('search') }}"
                class="w-full pl-9 pr-3.5 py-2 bg-[#FAF9F6] dark:bg-[#202522] border border-[#E5E3DC] dark:border-[#282D2A] rounded-lg text-xs text-[#171A19] dark:text-white placeholder-[#85877F] focus:outline-none focus:border-[#1B3D2F]">
        </div>

        <div class="flex items-center gap-1.5 overflow-x-auto w-full md:w-auto pb-1 md:pb-0">
            @php
                $curStatus = request('status', '');
                $statuses = [
                    '' => 'Tất cả',
                    'dang' => 'Đang hiển thị',
                    'cho_duyet' => 'Chờ duyệt',
                    'an' => 'Đã ẩn',
                    'tu_choi' => 'Từ chối',
                ];
            @endphp
            @foreach ($statuses as $k => $lbl)
                <button type="submit" name="status" value="{{ $k }}"
                    class="px-3 py-1.5 rounded-lg text-xs font-bold whitespace-nowrap transition {{ $curStatus === $k ? 'bg-[#1B3D2F] text-white shadow-2xs' : 'bg-[#FAF9F6] dark:bg-[#202522] border border-[#E5E3DC] dark:border-[#282D2A] text-[#85877F] dark:text-[#A8ABA7] hover:text-[#171A19] dark:hover:text-white hover:border-[#1B3D2F]' }}">
                    {{ $lbl }}
                </button>
            @endforeach
        </div>
    </form>

    {{-- Cards Grid --}}
    @if ($posts->isEmpty())
        <div class="bg-white dark:bg-[#181B19] rounded-xl border border-[#E5E3DC] dark:border-[#282D2A] p-12 text-center shadow-2xs">
            <div class="max-w-sm mx-auto space-y-3">
                <div class="w-12 h-12 rounded-xl bg-[#E5EDE8] dark:bg-[#23352B] text-[#1B3D2F] dark:text-[#8BB39D] flex items-center justify-center text-2xl mx-auto">
                    <i class="ri-article-line"></i>
                </div>
                <h3 class="text-sm font-extrabold text-[#171A19] dark:text-white">Không tìm thấy bài đăng nào</h3>
                <p class="text-xs text-[#85877F]">
                    Bạn chưa có bài đăng nào phù hợp với bộ lọc hiện tại. Hãy tạo bài đăng mới để tiếp cận khách thuê.
                </p>
                <a href="{{ route('chu-tro.bai-dang.create') }}"
                    class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-lg bg-[#1B3D2F] hover:bg-[#142E23] text-white font-bold text-xs shadow-2xs transition">
                    <i class="ri-add-line"></i> Tạo bài đăng mới
                </a>
            </div>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
            @foreach ($posts as $post)
                @php
                    $imgUrl = $post->anh->first()?->url ?? asset('images/no-image.png');
                    $diaChi = $post->dia_chi ?? ($post->phong->dayTro->dia_chi ?? 'Đang cập nhật địa chỉ');

                    $statusBadge = match ($post->trang_thai) {
                        'dang' => ['bg' => 'bg-[#1B3D2F] text-white', 'label' => 'Đang hiển thị'],
                        'cho_duyet' => ['bg' => 'bg-amber-600 text-white', 'label' => 'Chờ duyệt'],
                        'an' => ['bg-slate-700 text-white', 'label' => 'Đã ẩn'],
                        'tu_choi' => ['bg' => 'bg-rose-700 text-white', 'label' => 'Từ chối'],
                        default => ['bg' => 'bg-slate-700 text-white', 'label' => $post->trang_thai],
                    };
                @endphp
                <div class="bg-white dark:bg-[#181B19] rounded-xl border border-[#E5E3DC] dark:border-[#282D2A] shadow-2xs overflow-hidden flex flex-col justify-between group hover:border-[#1B3D2F]/60 transition duration-200">
                    <div>
                        {{-- Picture Container --}}
                        <div class="relative aspect-[16/10] overflow-hidden bg-[#FAF9F6] dark:bg-[#202522]">
                            <img src="{{ $imgUrl }}" alt="{{ $post->tieu_de }}"
                                class="w-full h-full object-cover group-hover:scale-105 transition duration-500"
                                onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1522708323590-d24dbb6b0267?auto=format&fit=crop&w=600&q=80'">
                            
                            {{-- Trạng thái Badge --}}
                            <span class="absolute top-2.5 left-2.5 px-2.5 py-0.5 rounded text-[10px] font-bold shadow-2xs {{ $statusBadge['bg'] }}">
                                {{ $statusBadge['label'] }}
                            </span>

                            {{-- Lượt xem --}}
                            <span class="absolute top-2.5 right-2.5 px-2 py-0.5 rounded text-[10px] font-bold bg-[#171A19]/80 text-white backdrop-blur-xs flex items-center gap-1 shadow-2xs">
                                <i class="ri-eye-line"></i> {{ $post->luot_xem ?? 0 }}
                            </span>

                            {{-- Diện tích --}}
                            <span class="absolute bottom-2.5 left-2.5 px-2 py-0.5 rounded text-[10px] font-bold bg-white/95 dark:bg-[#171A19]/95 text-[#171A19] dark:text-white shadow-2xs flex items-center gap-1">
                                <i class="ri-ruler-line text-[#1B3D2F] dark:text-[#8BB39D]"></i> {{ $post->phong->dien_tich ?? 20 }} m²
                            </span>
                        </div>

                        {{-- Body Info --}}
                        <div class="p-4 space-y-2.5">
                            <h3 class="font-bold text-sm text-[#171A19] dark:text-white line-clamp-1 group-hover:text-[#1B3D2F] transition-colors" title="{{ $post->tieu_de }}">
                                {{ $post->tieu_de }}
                            </h3>

                            <p class="text-xs text-[#85877F] flex items-center gap-1 line-clamp-1" title="{{ $diaChi }}">
                                <i class="ri-map-pin-2-line text-[#1B3D2F] dark:text-[#8BB39D] shrink-0"></i>
                                <span>{{ $diaChi }}</span>
                            </p>

                            {{-- Dịch vụ chips --}}
                            <div class="flex flex-wrap gap-1 pt-1">
                                @forelse ($post->phong->dichVuDinhKy->take(2) as $dv)
                                    <span class="px-2 py-0.5 rounded bg-[#FAF9F6] dark:bg-[#202522] border border-[#E5E3DC] dark:border-[#282D2A] text-[#85877F] dark:text-[#A8ABA7] text-[10px] font-semibold">
                                        {{ $dv->dichVu->ten }} ({{ number_format($dv->dichVu->don_gia, 0, ',', '.') }}đ)
                                    </span>
                                @empty
                                    <span class="text-[10px] text-[#85877F] italic">Chưa gắn dịch vụ kèm</span>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    {{-- Bottom Footer: Price & CTA --}}
                    <div class="p-4 pt-3 border-t border-[#E5E3DC] dark:border-[#282D2A] flex items-center justify-between">
                        <div>
                            <span class="text-[9px] uppercase font-bold text-[#85877F] block">Giá thuê</span>
                            <span class="text-sm font-black text-[#1B3D2F] dark:text-[#8BB39D]">
                                {{ number_format($post->gia_niem_yet, 0, ',', '.') }} <span class="text-[10px] font-semibold text-[#85877F]">đ/tháng</span>
                            </span>
                        </div>

                        <div class="flex items-center gap-1.5">
                            <a href="{{ route('chu-tro.bai-dang.edit', $post->id) }}"
                                class="w-8 h-8 rounded-lg flex items-center justify-center bg-[#FAF9F6] dark:bg-[#202522] border border-[#E5E3DC] dark:border-[#282D2A] text-[#85877F] hover:text-[#1B3D2F] hover:border-[#1B3D2F] transition"
                                title="Chỉnh sửa bài đăng">
                                <i class="ri-edit-line text-sm"></i>
                            </a>

                            <a href="{{ route('chu-tro.bai-dang.show', $post->id) }}"
                                class="px-3 py-1.5 rounded-lg bg-[#1B3D2F] hover:bg-[#142E23] text-white font-bold text-xs transition flex items-center gap-1 shadow-2xs">
                                <i class="ri-eye-line"></i>
                                <span>Xem</span>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        <div class="pt-4 flex justify-center">
            {{ $posts->links() }}
        </div>
    @endif
</div>
@endsection