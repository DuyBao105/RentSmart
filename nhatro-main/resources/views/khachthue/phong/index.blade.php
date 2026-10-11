@extends('layouts.tenant-layout')

@section('title', 'Phòng trọ của tôi — Khách thuê')
@section('page_title', 'Phòng trọ của tôi')
@section('page_subtitle', 'Quản lý không gian cư trú, tiện nghi sinh hoạt và hóa đơn chi phí hàng tháng')

@section('tenant_content')
@php
    $phongList = collect($phong ?? []);
@endphp

<div class="space-y-8">

    {{-- TOP HEADER --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-2 border-b border-[#E5E3DC] dark:border-[#282D2A]">
        <div>
            <h2 class="text-xl sm:text-2xl font-serif font-bold text-[#171A19] dark:text-white tracking-tight">
                Không Gian Cư Trú Hiện Tại
            </h2>
            <p class="text-xs sm:text-sm text-[#5A605B] dark:text-[#9EA39E] mt-1 font-sans">
                Hiện bạn đang có <span class="font-bold text-[#1B3D2F] dark:text-[#A3E635]">{{ $phongList->count() }}</span> phòng trong danh mục hợp đồng đang hiệu lực
            </p>
        </div>

        <a href="{{ route('listing') }}"
            class="inline-flex items-center justify-center gap-2 px-4 py-2 rounded-xl bg-white dark:bg-[#1E2320] border border-[#E5E3DC] dark:border-[#2D332F] hover:bg-[#FAF9F6] text-[#171A19] dark:text-white text-xs sm:text-sm font-medium shadow-xs transition">
            <i class="ri-search-line text-[#1B3D2F] dark:text-[#A3E635]"></i>
            <span>Khám phá thêm phòng khác</span>
        </a>
    </div>

    @if($phongList->isEmpty())
        <div class="bg-white dark:bg-[#1E2320] rounded-3xl p-12 border border-dashed border-[#E5E3DC] dark:border-[#2D332F] text-center space-y-4">
            <div class="w-16 h-16 rounded-2xl bg-[#1B3D2F]/10 dark:bg-[#244B3B]/40 text-[#1B3D2F] dark:text-[#A3E635] flex items-center justify-center text-3xl mx-auto">
                <i class="ri-door-open-line"></i>
            </div>
            <div class="space-y-1">
                <h3 class="text-base font-serif font-bold text-[#171A19] dark:text-white">Bạn hiện chưa có phòng nào đang thuê</h3>
                <p class="text-xs sm:text-sm text-[#5A605B] dark:text-[#9EA39E] max-w-md mx-auto">
                    Sau khi chủ nhà duyệt hồ sơ yêu cầu thuê và kích hoạt hợp đồng điện tử, thông tin phòng trọ của bạn sẽ hiển thị đầy đủ tại đây.
                </p>
            </div>
            <div class="pt-2">
                <a href="{{ route('listing') }}"
                    class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-[#1B3D2F] hover:bg-[#244B3B] text-white text-xs sm:text-sm font-semibold transition shadow-sm">
                    <i class="ri-compass-3-line"></i> Khám phá danh sách phòng
                </a>
            </div>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($phongList as $p)
                @php
                    $baiDangList = collect($p['bai_dang'] ?? []);
                    $baiDangHienTai = $baiDangList->where('trang_thai', 'dang')->sortByDesc('ngay_cap_nhat')->first() ?? $baiDangList->first();

                    $anhRaw = $baiDangHienTai['anh'] ?? [];
                    $thumb = asset('upload/room1.jpg');
                    if (!empty($anhRaw)) {
                        if (is_array($anhRaw) && isset($anhRaw[0]['url'])) $thumb = asset($anhRaw[0]['url']);
                        elseif (is_array($anhRaw) && is_string($anhRaw[0])) $thumb = asset($anhRaw[0]);
                        elseif (is_string($anhRaw)) $thumb = asset($anhRaw);
                    }

                    $tieuDe = $baiDangHienTai['tieu_de'] ?? 'Phòng trọ tiện nghi cao cấp';
                    $dayTro = $p['day_tro'] ?? [];
                    $chuTro = $dayTro['chu_tro'] ?? [];
                    $isRented = ($p['trang_thai'] ?? '') === 'da_thue';
                @endphp

                <div class="group bg-white dark:bg-[#1E2320] rounded-2xl border border-[#E5E3DC] dark:border-[#2D332F] shadow-sm hover:border-[#1B3D2F]/30 hover:shadow-md transition-all duration-300 overflow-hidden flex flex-col justify-between">
                    <div>
                        {{-- Image Banner --}}
                        <div class="relative aspect-16/10 overflow-hidden bg-[#FAF9F6] dark:bg-[#282D2A]">
                            <img src="{{ $thumb }}" alt="Ảnh phòng {{ $p['so_phong'] ?? '' }}"
                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                                onerror="this.src='https://images.unsplash.com/photo-1522708323590-d24dbb6b0267?auto=format&fit=crop&w=800&q=80'">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-transparent"></div>

                            <span class="absolute top-3 left-3 px-2.5 py-1 rounded-lg bg-white/90 dark:bg-[#171A19]/90 backdrop-blur-xs text-xs font-serif font-bold text-[#171A19] dark:text-white shadow-xs">
                                Phòng {{ $p['so_phong'] ?? 'Phòng' }}
                            </span>

                            <span class="absolute top-3 right-3 px-2.5 py-1 rounded-lg text-[11px] font-semibold border shadow-xs {{ $isRented ? 'bg-emerald-500 text-white border-emerald-400' : 'bg-gray-100 text-gray-700 border-gray-200' }}">
                                {{ $isRented ? 'Đang thuê' : 'Trống' }}
                            </span>

                            <div class="absolute bottom-3 left-3 right-3 text-white">
                                <p class="text-xs font-bold truncate">
                                    {{ $dayTro['ten_day_tro'] ?? 'Khu trọ' }}
                                </p>
                                <p class="text-[11px] opacity-80 truncate">
                                    {{ $dayTro['dia_chi'] ?? 'TP. Hồ Chí Minh' }}
                                </p>
                            </div>
                        </div>

                        {{-- Details --}}
                        <div class="p-5 space-y-3">
                            <h3 class="text-base font-serif font-bold text-[#171A19] dark:text-white line-clamp-1 group-hover:text-[#1B3D2F] dark:group-hover:text-[#A3E635] transition-colors">
                                {{ $tieuDe }}
                            </h3>

                            <div class="grid grid-cols-3 gap-2 py-2.5 px-3 rounded-xl bg-[#FAF9F6] dark:bg-[#282D2A]/60 border border-[#E5E3DC] dark:border-[#343B36] text-[11px]">
                                <div>
                                    <span class="text-[#5A605B] dark:text-[#9EA39E] block">Diện tích</span>
                                    <span class="font-bold text-[#171A19] dark:text-white">{{ $p['dien_tich'] ?? '--' }} m²</span>
                                </div>
                                <div>
                                    <span class="text-[#5A605B] dark:text-[#9EA39E] block">Tầng</span>
                                    <span class="font-bold text-[#171A19] dark:text-white">Tầng {{ $p['tang'] ?? '1' }}</span>
                                </div>
                                <div>
                                    <span class="text-[#5A605B] dark:text-[#9EA39E] block">Sức chứa</span>
                                    <span class="font-bold text-[#171A19] dark:text-white">{{ $p['suc_chua'] ?? '2' }} người</span>
                                </div>
                            </div>

                            <div class="flex items-baseline justify-between pt-1">
                                <span class="text-xs text-[#5A605B] dark:text-[#9EA39E]">Giá thuê hàng tháng:</span>
                                <span class="text-base font-serif font-bold text-[#1B3D2F] dark:text-[#4ADE80]">
                                    {{ number_format($p['gia'] ?? 0) }} đ/tháng
                                </span>
                            </div>
                        </div>
                    </div>

                    {{-- Actions --}}
                    <div class="p-5 pt-0 flex items-center justify-between gap-2 border-t border-[#E5E3DC] dark:border-[#282D2A] mt-2">
                        <a href="{{ route('khach-thue.hoa-don.index') }}"
                            class="px-3 py-1.5 rounded-lg border border-[#E5E3DC] dark:border-[#2D332F] bg-[#FAF9F6] dark:bg-[#282D2A] text-[#171A19] dark:text-white text-xs font-medium hover:border-[#1B3D2F] transition flex items-center gap-1.5">
                            <i class="ri-bill-line text-[#A6824D]"></i>
                            <span>Hóa đơn</span>
                        </a>
                        <a href="{{ route('khach-thue.phong.show', $p['id']) }}"
                            class="px-3.5 py-1.5 rounded-lg bg-[#1B3D2F] hover:bg-[#244B3B] text-white text-xs font-medium transition flex items-center gap-1">
                            <span>Chi tiết phòng</span>
                            <i class="ri-arrow-right-line"></i>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

</div>
@endsection
