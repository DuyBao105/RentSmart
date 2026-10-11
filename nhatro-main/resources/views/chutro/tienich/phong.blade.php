@extends('layouts.chu-tro')

@section('title', 'Cấu hình tiện ích phòng')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    {{-- 🔹 Header --}}
    <div class="flex items-center justify-between">
        <div>
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-indigo-50 dark:bg-indigo-950/60 text-indigo-600 dark:text-indigo-400 text-xs font-semibold uppercase tracking-wider mb-2 border border-indigo-100 dark:border-indigo-900/50">
                <i class="ri-sparkling-line"></i> Trang thiết bị & Tiện ích
            </div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 dark:text-white tracking-tight flex items-center gap-2.5">
                <span class="w-2.5 h-8 bg-gradient-to-b from-indigo-500 to-sky-500 rounded-full inline-block"></span>
                Tiện ích phòng {{ $phong->so_phong }}
            </h1>
            <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">
                Dãy trọ: <strong class="text-slate-700 dark:text-slate-200">{{ $phong->dayTro->ten_day_tro ?? '' }}</strong> • Tích chọn các tiện nghi có sẵn trong phòng
            </p>
        </div>

        <a href="{{ route('chu-tro.phong.index') }}"
            class="inline-flex items-center gap-2 px-4 py-2 text-sm font-semibold text-slate-600 dark:text-slate-300 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl hover:bg-slate-50 shadow-sm transition">
            <i class="ri-arrow-left-line"></i> Danh sách phòng
        </a>
    </div>

    {{-- 🔹 Form Card --}}
    <div class="bg-white dark:bg-slate-900 p-6 sm:p-8 rounded-3xl border border-slate-200/80 dark:border-slate-800 shadow-sm">
        <form action="{{ route('chu-tro.tien-ich.gan', $phong->id) }}" method="POST" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3">
                @foreach ($tatCaTienIch as $ti)
                    @php
                        $has = $phong->tienIch->contains($ti->id);
                    @endphp
                    <label class="group relative flex items-center gap-3 p-3.5 rounded-2xl border transition-all cursor-pointer select-none
                        {{ $has ? 'bg-indigo-50/60 dark:bg-indigo-950/40 border-indigo-200 dark:border-indigo-800 shadow-sm' : 'bg-slate-50/50 dark:bg-slate-800/40 border-slate-200 dark:border-slate-700/80 hover:bg-slate-100/60 dark:hover:bg-slate-800' }}">
                        <input type="checkbox" name="tien_ich_ids[]" value="{{ $ti->id }}"
                            @if ($has) checked @endif
                            class="w-5 h-5 rounded-lg text-indigo-600 focus:ring-indigo-500/30 border-slate-300 dark:border-slate-600 dark:bg-slate-800 transition">
                        <div class="flex-1 min-w-0">
                            <span class="block text-sm font-bold text-slate-800 dark:text-slate-200 group-hover:text-indigo-600 transition truncate">
                                {{ $ti->ten }}
                            </span>
                            @if(!empty($ti->mo_ta))
                                <span class="block text-xs text-slate-400 truncate">{{ $ti->mo_ta }}</span>
                            @endif
                        </div>
                    </label>
                @endforeach
            </div>

            <div class="flex items-center justify-between pt-6 border-t border-slate-100 dark:border-slate-800">
                <a href="{{ route('chu-tro.phong.index') }}"
                   class="px-5 py-2.5 text-sm font-semibold text-slate-600 dark:text-slate-400 hover:text-slate-800 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-xl transition">
                    Hủy bỏ
                </a>

                <button type="submit"
                    class="inline-flex items-center gap-2 px-6 py-2.5 bg-gradient-to-r from-indigo-600 via-indigo-500 to-sky-500 hover:from-indigo-700 hover:to-sky-600 text-white text-sm font-semibold rounded-xl shadow-lg shadow-indigo-500/20 hover:shadow-indigo-500/30 transition-all">
                    <i class="ri-check-line"></i> Lưu tiện ích phòng
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
