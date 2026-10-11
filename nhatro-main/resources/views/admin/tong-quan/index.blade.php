@extends('admin.layout')

@section('title', 'Admin — Bảng điều khiển Tổng quan')

@section('content')
<div class="space-y-8">
    {{-- Page Header --}}
    <div class="motion-reveal flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-2 border-b border-[#E5E3DC] dark:border-[#282D2A]">
        <div>
            <div class="inline-flex items-center gap-2 px-2.5 py-1 rounded-full bg-[#1B3D2F]/10 dark:bg-[#244B3B]/30 text-[#1B3D2F] dark:text-[#A3E635] text-xs font-semibold mb-2">
                <i class="ri-shield-star-line"></i> Trung tâm điều hành Hệ thống
            </div>
            <h1 class="text-2xl sm:text-3xl font-serif font-bold text-[#171A19] dark:text-[#FAF9F6] tracking-tight">
                Tổng Quan Nền Tảng
            </h1>
            <p class="text-xs sm:text-sm text-[#5A605B] dark:text-[#9EA39E] mt-1 font-sans">
                Giám sát tình trạng kiểm duyệt tin đăng, hoạt động tài khoản và quy mô thị trường theo thời gian thực.
            </p>
        </div>
        <div class="flex items-center gap-3">
            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-white dark:bg-[#1E2320] border border-[#E5E3DC] dark:border-[#2D332F] text-xs font-medium text-[#5A605B] dark:text-[#9EA39E]">
                <i class="ri-calendar-line text-[#1B3D2F] dark:text-[#A3E635]"></i>
                {{ date('d/m/Y') }}
            </span>
            <a href="{{ route('admin.approvals') }}" class="micro-press inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-[#1B3D2F] hover:bg-[#244B3B] text-white text-xs font-medium transition shadow-sm">
                <i class="ri-checkbox-circle-line"></i>
                <span>Kiểm duyệt ngay</span>
            </a>
        </div>
    </div>

    {{-- 4 Core KPI Metrics --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        {{-- Metric 1: Monthly posts --}}
        <div class="motion-reveal motion-stagger-1 card-lift-hover p-5 bg-white dark:bg-[#1E2320] rounded-2xl border border-[#E5E3DC] dark:border-[#2D332F] shadow-sm hover:border-[#1B3D2F]/30 transition">
            <div class="flex items-center justify-between">
                <div>
                    <span class="text-xs font-medium uppercase tracking-wider text-[#5A605B] dark:text-[#9EA39E]">Bài viết trong tháng</span>
                    <p class="text-3xl font-serif font-bold text-[#171A19] dark:text-white mt-1.5">
                        <span class="count-up" data-counter="{{ (int)($stats['posts_this_month'] ?? $stats['bai_viet_trong_thang'] ?? 0) }}">{{ number_format($stats['posts_this_month'] ?? $stats['bai_viet_trong_thang'] ?? 0) }}</span>
                    </p>
                    <div class="flex items-center gap-1.5 mt-2 text-xs text-[#1B3D2F] dark:text-[#4ADE80] font-medium">
                        <i class="ri-arrow-up-line"></i>
                        <span>Đang tăng trưởng</span>
                    </div>
                </div>
                <div class="w-12 h-12 rounded-xl bg-[#FAF9F6] dark:bg-[#282D2A] border border-[#E5E3DC] dark:border-[#343B36] grid place-items-center text-[#1B3D2F] dark:text-[#A3E635]">
                    <i class="ri-file-list-3-line text-2xl"></i>
                </div>
            </div>
        </div>

        {{-- Metric 2: Pending approval --}}
        <div class="motion-reveal motion-stagger-2 card-lift-hover p-5 bg-white dark:bg-[#1E2320] rounded-2xl border border-[#E5E3DC] dark:border-[#2D332F] shadow-sm hover:border-amber-300 transition">
            <div class="flex items-center justify-between">
                <div>
                    <span class="text-xs font-medium uppercase tracking-wider text-[#5A605B] dark:text-[#9EA39E]">Tin chờ kiểm duyệt</span>
                    <p class="text-3xl font-serif font-bold text-amber-700 dark:text-amber-400 mt-1.5">
                        <span class="count-up" data-counter="{{ (int)($stats['dang_cho_duyet'] ?? $stats['pending'] ?? 0) }}">{{ number_format($stats['dang_cho_duyet'] ?? $stats['pending'] ?? 0) }}</span>
                    </p>
                    <div class="flex items-center gap-1.5 mt-2 text-xs text-amber-700 dark:text-amber-400 font-medium">
                        <i class="ri-time-line"></i>
                        <span>Cần xử lý phê duyệt</span>
                    </div>
                </div>
                <div class="w-12 h-12 rounded-xl bg-amber-50/80 dark:bg-amber-950/40 border border-amber-200/60 dark:border-amber-900/50 grid place-items-center text-amber-700 dark:text-amber-400">
                    <i class="ri-hourglass-2-line text-2xl"></i>
                </div>
            </div>
        </div>

        {{-- Metric 3: Users --}}
        <div class="motion-reveal motion-stagger-3 card-lift-hover p-5 bg-white dark:bg-[#1E2320] rounded-2xl border border-[#E5E3DC] dark:border-[#2D332F] shadow-sm hover:border-[#1B3D2F]/30 transition">
            <div class="flex items-center justify-between">
                <div>
                    <span class="text-xs font-medium uppercase tracking-wider text-[#5A605B] dark:text-[#9EA39E]">Người dùng hệ thống</span>
                    <p class="text-3xl font-serif font-bold text-[#171A19] dark:text-white mt-1.5">
                        <span class="count-up" data-counter="{{ (int)($stats['nguoi_dung'] ?? $stats['users'] ?? 0) }}">{{ number_format($stats['nguoi_dung'] ?? $stats['users'] ?? 0) }}</span>
                    </p>
                    <div class="flex items-center gap-1.5 mt-2 text-xs text-[#5A605B] dark:text-[#9EA39E] font-medium">
                        <i class="ri-user-follow-line text-[#1B3D2F] dark:text-[#A3E635]"></i>
                        <span>Chủ trọ & Khách thuê</span>
                    </div>
                </div>
                <div class="w-12 h-12 rounded-xl bg-[#FAF9F6] dark:bg-[#282D2A] border border-[#E5E3DC] dark:border-[#343B36] grid place-items-center text-[#1B3D2F] dark:text-[#A3E635]">
                    <i class="ri-team-line text-2xl"></i>
                </div>
            </div>
        </div>

        {{-- Metric 4: Regions --}}
        <div class="motion-reveal motion-stagger-4 card-lift-hover p-5 bg-white dark:bg-[#1E2320] rounded-2xl border border-[#E5E3DC] dark:border-[#2D332F] shadow-sm hover:border-[#1B3D2F]/30 transition">
            <div class="flex items-center justify-between">
                <div>
                    <span class="text-xs font-medium uppercase tracking-wider text-[#5A605B] dark:text-[#9EA39E]">Khu vực quản lý</span>
                    <p class="text-3xl font-serif font-bold text-[#171A19] dark:text-white mt-1.5">
                        <span class="count-up" data-counter="{{ (int)($stats['khu_vuc'] ?? $stats['regions'] ?? 0) }}">{{ number_format($stats['khu_vuc'] ?? $stats['regions'] ?? 0) }}</span>
                    </p>
                    <div class="flex items-center gap-1.5 mt-2 text-xs text-[#5A605B] dark:text-[#9EA39E] font-medium">
                        <i class="ri-map-pin-2-line text-[#A6824D]"></i>
                        <span>Quận / Huyện TP.HCM</span>
                    </div>
                </div>
                <div class="w-12 h-12 rounded-xl bg-[#FAF9F6] dark:bg-[#282D2A] border border-[#E5E3DC] dark:border-[#343B36] grid place-items-center text-[#A6824D]">
                    <i class="ri-map-pin-line text-2xl"></i>
                </div>
            </div>
        </div>
    </div>

    {{-- Main 2-column layout --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Left col (2-spans): Recent Posts Table --}}
        <div class="motion-reveal bg-white dark:bg-[#1E2320] rounded-2xl border border-[#E5E3DC] dark:border-[#2D332F] p-6 lg:col-span-2 shadow-sm">
            <div class="flex items-center justify-between pb-4 mb-4 border-b border-[#E5E3DC] dark:border-[#2D332F]">
                <div>
                    <h2 class="font-serif font-bold text-lg text-[#171A19] dark:text-white">Bài viết mới cập nhật</h2>
                    <p class="text-xs text-[#5A605B] dark:text-[#9EA39E] mt-0.5">Danh sách các tin đăng mới nhất từ đối tác chủ trọ</p>
                </div>
                <a href="{{ route('admin.posts') }}" class="micro-press text-xs font-medium text-[#1B3D2F] dark:text-[#A3E635] hover:underline flex items-center gap-1">
                    Xem toàn bộ <i class="ri-arrow-right-line"></i>
                </a>
            </div>

            <div class="divide-y divide-[#E5E3DC] dark:divide-[#282D2A]">
                @php
                    $items = $recentPosts['data'] ?? [];
                @endphp
                @if(count($items) === 0)
                    <div class="py-12 text-center text-sm text-[#5A605B] dark:text-[#9EA39E]">
                        <i class="ri-inbox-line text-3xl block mb-2 opacity-50"></i>
                        Không có bài viết mới nào trong tháng này.
                    </div>
                @else
                    @foreach ($items as $post)
                        @php
                            $trangThai = $post['trang_thai'] ?? '';
                            $badgeClass = match($trangThai) {
                                'dang' => 'bg-emerald-50 text-emerald-800 border-emerald-200 dark:bg-emerald-950/40 dark:text-emerald-400 dark:border-emerald-800',
                                'cho_duyet' => 'bg-amber-50 text-amber-800 border-amber-200 dark:bg-amber-950/40 dark:text-amber-400 dark:border-amber-800',
                                'tu_choi' => 'bg-rose-50 text-rose-800 border-rose-200 dark:bg-rose-950/40 dark:text-rose-400 dark:border-rose-800',
                                'an' => 'bg-gray-100 text-gray-700 border-gray-200 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-700',
                                default => 'bg-[#FAF9F6] text-[#5A605B] border-[#E5E3DC] dark:bg-[#282D2A] dark:text-[#9EA39E] dark:border-[#343B36]'
                            };
                            $label = $post['trang_thai_label'] ?? (match($trangThai) {
                                'dang' => 'Đang hiển thị',
                                'cho_duyet' => 'Chờ duyệt',
                                'tu_choi' => 'Từ chối',
                                'an' => 'Đang ẩn',
                                'nhap' => 'Bản nháp',
                                default => ucfirst($trangThai ?: '—')
                            });
                        @endphp
                        <div class="table-row-hover py-3.5 flex flex-col sm:flex-row sm:items-center justify-between gap-3 -mx-2 px-2 rounded-xl transition">
                            <div class="min-w-0 flex-1">
                                <a href="{{ route('admin.posts.show', $post['id'] ?? 0) }}" class="font-medium text-sm text-[#171A19] dark:text-white hover:text-[#1B3D2F] dark:hover:text-[#A3E635] truncate block">
                                    {{ $post['tieu_de'] ?? 'Không tiêu đề' }}
                                </a>
                                <div class="flex items-center gap-3 text-xs text-[#5A605B] dark:text-[#9EA39E] mt-1">
                                    <span class="inline-flex items-center gap-1">
                                        <i class="ri-user-line text-[#A6824D]"></i>
                                        {{ $post['tac_gia'] ?? ($post['nguoi_dung_id'] ?? 'Đối tác') }}
                                    </span>
                                    <span>•</span>
                                    <span class="inline-flex items-center gap-1">
                                        <i class="ri-time-line"></i>
                                        {{ isset($post['ngay_tao']) ? date('d/m/Y', strtotime($post['ngay_tao'])) : (isset($post['ngay_duyet']) ? date('d/m/Y', strtotime($post['ngay_duyet'])) : '') }}
                                    </span>
                                </div>
                            </div>
                            <div class="flex items-center gap-2 self-start sm:self-auto shrink-0">
                                <span class="px-2.5 py-1 rounded-full text-xs font-medium border {{ $badgeClass }}">
                                    {{ $label }}
                                </span>
                                <a href="{{ route('admin.posts.show', $post['id'] ?? 0) }}" class="micro-press p-1.5 rounded-lg border border-[#E5E3DC] dark:border-[#2D332F] text-[#5A605B] hover:text-[#171A19] dark:text-[#9EA39E] dark:hover:text-white transition">
                                    <i class="ri-arrow-right-s-line text-base"></i>
                                </a>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>

        {{-- Right col (1-span): Operational Breakdown & Quick Tools --}}
        <div class="space-y-6">
            {{-- Fast Status Breakdown --}}
            <div class="motion-reveal card-lift-hover bg-white dark:bg-[#1E2320] rounded-2xl border border-[#E5E3DC] dark:border-[#2D332F] p-6 shadow-sm">
                <h2 class="font-serif font-bold text-lg text-[#171A19] dark:text-white mb-1">Kiểm soát ấn phẩm</h2>
                <p class="text-xs text-[#5A605B] dark:text-[#9EA39E] mb-5">Thống kê phân loại trạng thái toàn hệ thống</p>
                
                <ul class="space-y-3.5 text-xs sm:text-sm">
                    <li class="flex items-center justify-between pb-3 border-b border-[#E5E3DC] dark:border-[#282D2A]">
                        <span class="text-[#5A605B] dark:text-[#9EA39E] flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-[#171A19] dark:bg-white"></span>
                            Tổng bài viết
                        </span>
                        <strong class="font-bold text-[#171A19] dark:text-white text-base">
                            <span class="count-up" data-counter="{{ (int)($stats['total_posts'] ?? 0) }}">{{ number_format($stats['total_posts'] ?? 0) }}</span>
                        </strong>
                    </li>
                    <li class="flex items-center justify-between pb-3 border-b border-[#E5E3DC] dark:border-[#282D2A]">
                        <span class="text-[#5A605B] dark:text-[#9EA39E] flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                            Đã phê duyệt
                        </span>
                        <strong class="font-bold text-emerald-700 dark:text-emerald-400 text-base">
                            <span class="count-up" data-counter="{{ (int)($stats['approved'] ?? 0) }}">{{ number_format($stats['approved'] ?? 0) }}</span>
                        </strong>
                    </li>
                    <li class="flex items-center justify-between pb-3 border-b border-[#E5E3DC] dark:border-[#282D2A]">
                        <span class="text-[#5A605B] dark:text-[#9EA39E] flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                            Chờ xét duyệt
                        </span>
                        <strong class="font-bold text-amber-700 dark:text-amber-400 text-base">
                            <span class="count-up" data-counter="{{ (int)($stats['dang_cho_duyet'] ?? $stats['pending'] ?? 0) }}">{{ number_format($stats['dang_cho_duyet'] ?? $stats['pending'] ?? 0) }}</span>
                        </strong>
                    </li>
                    <li class="flex items-center justify-between">
                        <span class="text-[#5A605B] dark:text-[#9EA39E] flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-gray-400"></span>
                            Đang tạm ẩn
                        </span>
                        <strong class="font-bold text-[#5A605B] dark:text-[#9EA39E] text-base">
                            <span class="count-up" data-counter="{{ (int)($stats['hidden'] ?? 0) }}">{{ number_format($stats['hidden'] ?? 0) }}</span>
                        </strong>
                    </li>
                </ul>
            </div>

            {{-- Quick Moderation Shortcuts --}}
            <div class="motion-reveal card-lift-hover bg-white dark:bg-[#1E2320] rounded-2xl border border-[#E5E3DC] dark:border-[#2D332F] p-6 shadow-sm">
                <h3 class="font-serif font-bold text-base text-[#171A19] dark:text-white mb-3">Lối tắt tác vụ</h3>
                <div class="space-y-2.5">
                    <a href="{{ route('admin.approvals') }}" class="micro-press flex items-center justify-between p-3 rounded-xl bg-[#FAF9F6] dark:bg-[#282D2A] border border-[#E5E3DC] dark:border-[#343B36] hover:border-[#1B3D2F] dark:hover:border-[#A3E635] text-xs font-medium text-[#171A19] dark:text-white transition">
                        <span class="flex items-center gap-2.5">
                            <i class="ri-checkbox-circle-line text-[#1B3D2F] dark:text-[#A3E635] text-base"></i>
                            Xét duyệt tin chờ đăng
                        </span>
                        <i class="ri-arrow-right-line text-[#5A605B]"></i>
                    </a>
                    <a href="{{ route('admin.accounts') }}" class="micro-press flex items-center justify-between p-3 rounded-xl bg-[#FAF9F6] dark:bg-[#282D2A] border border-[#E5E3DC] dark:border-[#343B36] hover:border-[#1B3D2F] dark:hover:border-[#A3E635] text-xs font-medium text-[#171A19] dark:text-white transition">
                        <span class="flex items-center gap-2.5">
                            <i class="ri-user-settings-line text-[#A6824D] text-base"></i>
                            Quản lý tài khoản người dùng
                        </span>
                        <i class="ri-arrow-right-line text-[#5A605B]"></i>
                    </a>
                    <a href="{{ route('admin.regions') }}" class="micro-press flex items-center justify-between p-3 rounded-xl bg-[#FAF9F6] dark:bg-[#282D2A] border border-[#E5E3DC] dark:border-[#343B36] hover:border-[#1B3D2F] dark:hover:border-[#A3E635] text-xs font-medium text-[#171A19] dark:text-white transition">
                        <span class="flex items-center gap-2.5">
                            <i class="ri-map-2-line text-[#1B3D2F] dark:text-[#A3E635] text-base"></i>
                            Danh mục Khu vực & Địa chỉ
                        </span>
                        <i class="ri-arrow-right-line text-[#5A605B]"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
