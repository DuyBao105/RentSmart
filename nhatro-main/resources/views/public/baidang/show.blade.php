@extends('layouts.public')
@section('title', $b->tieu_de . ' - Hệ Thống Trọ')

@section('content')
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        {{-- Breadcrumb --}}
        <div class="flex items-center gap-2 text-xs text-slate-400 mb-6">
            <a href="{{ route('public.bai-dang.index') }}" class="hover:text-sky-600 transition">Phòng trọ</a>
            <i class="ri-arrow-right-s-line"></i>
            <span class="text-slate-700 font-medium truncate max-w-sm">{{ $b->tieu_de }}</span>
        </div>

        <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight mb-6">
            {{ $b->tieu_de }}
        </h1>

        {{-- Ảnh Gallery --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
            @foreach ($b->anh as $a)
                <div class="overflow-hidden rounded-3xl border border-slate-200/80 aspect-[16/11] bg-slate-100 shadow-sm">
                    <img src="{{ asset('storage/' . $a) }}" class="w-full h-full object-cover hover:scale-105 transition-transform duration-500"
                        onerror="this.src='https://images.unsplash.com/photo-1522708323590-d24dbb6b0267?auto=format&fit=crop&w=800&q=80'">
                </div>
            @endforeach
        </div>

        {{-- Thông tin chi tiết Card --}}
        <div class="bg-white rounded-[2rem] border border-slate-200/80 shadow-sm p-6 sm:p-8 space-y-6">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 border-b border-slate-100">
                <div>
                    <span class="text-xs text-slate-400 uppercase tracking-wider font-semibold block mb-1">Mức giá niêm yết</span>
                    <span class="text-3xl font-extrabold text-sky-600">{{ $b->gia_hien_thi }}</span>
                </div>
                <div class="flex items-center gap-2 text-sm text-slate-600 bg-slate-50 px-4 py-2 rounded-xl border border-slate-200/60">
                    <i class="ri-map-pin-2-fill text-sky-600 text-base"></i>
                    <span class="font-medium">{{ $b->dia_chi }}</span>
                </div>
            </div>

            <div>
                <h3 class="text-sm font-bold uppercase tracking-wider text-slate-400 mb-2">Mô tả chi tiết</h3>
                <p class="text-slate-600 leading-relaxed text-sm whitespace-pre-line">{{ $b->mo_ta }}</p>
            </div>

            <div class="pt-4 border-t border-slate-100">
                <h3 class="text-sm font-bold uppercase tracking-wider text-slate-400 mb-3 flex items-center gap-1.5">
                    <i class="ri-sparkling-fill text-amber-500"></i> Tiện nghi phòng
                </h3>
                @if ($b->tien_ich)
                    <div class="flex flex-wrap gap-2">
                        @foreach (explode(',', $b->tien_ich) as $t)
                            <span class="bg-sky-50 text-sky-700 border border-sky-200/60 px-3.5 py-1.5 rounded-xl text-xs font-semibold flex items-center gap-1.5">
                                <i class="ri-check-line text-sky-600 font-bold"></i> {{ ucfirst(trim($t)) }}
                            </span>
                        @endforeach
                    </div>
                @else
                    <p class="text-slate-400 italic text-xs">Chưa có thông tin tiện ích đính kèm.</p>
                @endif
            </div>

            <div class="pt-6 border-t border-slate-100 flex items-center gap-4">
                <a href="tel:0909123456"
                    class="inline-flex items-center justify-center gap-2 bg-gradient-to-r from-sky-600 to-sky-500 text-white font-bold text-sm px-7 py-3 rounded-xl shadow-lg shadow-sky-500/25 hover:shadow-sky-500/40 hover:-translate-y-0.5 transition-all">
                    <i class="ri-phone-fill"></i> Liên hệ chủ trọ
                </a>
                <a href="{{ route('public.bai-dang.index') }}"
                    class="px-5 py-3 rounded-xl text-sm font-semibold text-slate-600 bg-slate-100 hover:bg-slate-200/70 transition">
                    &larr; Xem các phòng khác
                </a>
            </div>
        </div>
    </div>
@endsection