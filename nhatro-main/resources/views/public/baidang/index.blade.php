@extends('layouts.public')
@section('title', 'Danh sách phòng trọ - Hệ Thống Trọ')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="text-center max-w-2xl mx-auto mb-12">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-sky-100 text-sky-700 mb-3">
                <i class="ri-fire-line"></i> Phòng trọ mới nhất
            </span>
            <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight text-slate-900">
                Khám phá không gian sống lý tưởng
            </h1>
            <p class="text-slate-500 text-sm mt-2">
                Hàng trăm phòng trọ xác thực với giá cả minh bạch và đầy đủ tiện nghi
            </p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-7">
            @foreach ($bai_dang as $b)
                <a href="{{ route('public.bai-dang.show', $b->id) }}"
                    class="group block bg-white rounded-[2rem] border border-slate-200/80 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 overflow-hidden flex flex-col">
                    <div class="relative overflow-hidden aspect-[16/10] bg-slate-100">
                        <img src="{{ asset('storage/' . $b->anh) }}" alt="Ảnh phòng"
                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                            onerror="this.src='https://images.unsplash.com/photo-1522708323590-d24dbb6b0267?auto=format&fit=crop&w=800&q=80'">
                        <span
                            class="absolute top-3 left-3 bg-emerald-500/90 backdrop-blur-md text-white text-[11px] font-bold px-3 py-1 rounded-full shadow-sm">
                            <i class="ri-checkbox-circle-fill mr-1"></i> Còn phòng
                        </span>
                    </div>

                    <div class="p-6 flex-1 flex flex-col justify-between">
                        <div>
                            <div class="flex items-center gap-1.5 text-xs text-slate-400 mb-2">
                                <i class="ri-community-line text-sky-600"></i>
                                <span class="font-medium text-slate-600">{{ $b->ten_day_tro }}</span>
                            </div>

                            <h2 class="text-lg font-bold text-slate-900 group-hover:text-sky-600 transition-colors line-clamp-1 mb-1.5">
                                {{ $b->tieu_de }}
                            </h2>
                            <p class="text-slate-500 text-xs line-clamp-2 leading-relaxed">
                                {{ $b->mo_ta }}
                            </p>
                        </div>

                        <div class="pt-4 mt-4 border-t border-slate-100 flex items-center justify-between">
                            <div>
                                <span class="text-[11px] text-slate-400 block font-medium">Giá thuê</span>
                                <span class="text-lg font-extrabold text-sky-600">{{ $b->gia_hien_thi }}</span>
                            </div>

                            <span class="inline-flex items-center gap-1 text-xs font-bold text-slate-700 group-hover:text-sky-600 transition-colors">
                                Chi tiết <i class="ri-arrow-right-line"></i>
                            </span>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>

        <div class="mt-12 flex justify-center">
            {{ $bai_dang->links() }}
        </div>
    </div>
@endsection