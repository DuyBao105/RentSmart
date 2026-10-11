@extends('layouts.app')
@section('title', $item['tieu_de'] . ' - Hệ Thống Trọ')

@section('content')
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <article class="bg-white rounded-[2.5rem] border border-slate-200/80 shadow-sm overflow-hidden">
            <div class="relative aspect-[16/9] w-full bg-slate-100 overflow-hidden">
                <img src="{{ $item['anh'][0]['url'] ?? '/room.jpg' }}" alt="{{ $item['tieu_de'] }}" 
                    class="w-full h-full object-cover"
                    onerror="this.src='https://images.unsplash.com/photo-1522708323590-d24dbb6b0267?auto=format&fit=crop&w=1200&q=80'">
                <div class="absolute inset-0 bg-gradient-to-t from-slate-900/60 via-transparent to-transparent"></div>
                <div class="absolute bottom-6 left-6 right-6 text-white">
                    <span class="inline-block px-3 py-1 rounded-full text-xs font-bold bg-sky-500/90 backdrop-blur-md mb-2">
                        Phòng đang mở thuê
                    </span>
                    <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight drop-shadow-sm">
                        {{ $item['tieu_de'] }}
                    </h1>
                </div>
            </div>

            <div class="p-6 sm:p-8 space-y-6">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 border-b border-slate-100">
                    <div>
                        <span class="text-xs text-slate-400 uppercase tracking-wider font-semibold block mb-1">Giá thuê niêm yết</span>
                        <div class="flex items-baseline gap-1">
                            <span class="text-3xl font-extrabold text-sky-600">
                                {{ number_format($item['gia_niem_yet'], 0, ',', '.') }}₫
                            </span>
                            <span class="text-sm font-medium text-slate-400">/tháng</span>
                        </div>
                    </div>

                    @if(!empty($item['phong']['day_tro']['dia_chi']))
                        <div class="flex items-center gap-2 text-sm text-slate-600 bg-slate-50 px-4 py-2.5 rounded-xl border border-slate-200/60">
                            <i class="ri-map-pin-2-fill text-sky-600 text-lg shrink-0"></i>
                            <span class="font-medium">{{ $item['phong']['day_tro']['dia_chi'] }}</span>
                        </div>
                    @endif
                </div>

                @if(!empty($item['phong']['tien_ich']))
                    <div>
                        <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-3 flex items-center gap-1.5">
                            <i class="ri-sparkling-fill text-amber-500"></i> Tiện nghi phòng
                        </h3>
                        <div class="flex flex-wrap gap-2">
                            @foreach($item['phong']['tien_ich'] as $ti)
                                <span class="bg-sky-50 text-sky-700 border border-sky-200/60 px-3.5 py-1.5 rounded-xl text-xs font-semibold flex items-center gap-1.5">
                                    <i class="ri-check-line text-sky-600 font-bold"></i> {{ $ti['ten'] }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                @endif

                <div class="pt-4 border-t border-slate-100">
                    <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-2">Mô tả phòng</h3>
                    <p class="text-slate-600 leading-relaxed text-sm whitespace-pre-line">
                        {{ $item['mo_ta'] }}
                    </p>
                </div>
            </div>
        </article>
    </div>
@endsection