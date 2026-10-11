@extends('layouts.tenant-layout')

@section('title', 'Phòng trọ yêu thích — Khách thuê')
@section('page_title', 'Phòng trọ yêu thích')
@section('page_subtitle', 'Danh sách các căn phòng bạn đã lưu lại để theo dõi, so sánh và liên hệ khi cần')

@section('tenant_content')
    <div class="space-y-6">

        {{-- Error message --}}
        @if (isset($error))
            <div class="p-4 bg-rose-50 dark:bg-rose-950/40 border border-rose-200 dark:border-rose-800 text-rose-700 dark:text-rose-300 rounded-2xl text-center text-xs sm:text-sm font-semibold">
                {{ $error }}
            </div>
        @elseif (empty($baiDangList) || count($baiDangList) === 0)
            <div class="text-center py-16 bg-[#FAF9F6] dark:bg-[#1E2320] rounded-3xl border border-dashed border-[#E5E3DC] dark:border-[#2D332F] p-8">
                <div class="w-16 h-16 rounded-2xl bg-[#1B3D2F]/10 dark:bg-[#244B3B]/40 text-[#1B3D2F] dark:text-[#A3E635] flex items-center justify-center text-3xl mx-auto mb-4">
                    <i class="ri-heart-line"></i>
                </div>
                <h3 class="text-base font-serif font-bold text-[#171A19] dark:text-white mb-1">Chưa có phòng trọ nào được lưu</h3>
                <p class="text-xs text-[#5A605B] dark:text-[#9EA39E] max-w-sm mx-auto mb-6">
                    Bấm vào biểu tượng trái tim ở bất kỳ phòng trọ nào bạn ưng ý trong danh sách tìm kiếm để lưu lại theo dõi.
                </p>
                <a href="{{ route('listing') }}"
                    class="inline-flex items-center gap-2 px-5 py-2.5 bg-[#1B3D2F] hover:bg-[#244B3B] text-white text-xs font-semibold rounded-xl shadow-sm transition">
                    <i class="ri-search-line"></i> Khám phá phòng trọ ngay
                </a>
            </div>
        @else
            {{-- Property Cards Grid --}}
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($baiDangList as $baiDang)
                    <div class="group bg-white dark:bg-[#1E2320] rounded-2xl border border-[#E5E3DC] dark:border-[#2D332F] shadow-sm hover:border-[#1B3D2F]/30 hover:shadow-md transition-all duration-300 overflow-hidden flex flex-col justify-between">
                        <div>
                            {{-- Thumbnail --}}
                            <div class="relative aspect-16/10 overflow-hidden bg-[#FAF9F6] dark:bg-[#282D2A]">
                                <img src="{{ $baiDang['anh_dai_dien'] ?? asset('images/no-image.png') }}" alt="Ảnh phòng"
                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                                    onerror="this.src='https://images.unsplash.com/photo-1522708323590-d24dbb6b0267?auto=format&fit=crop&w=800&q=80'">

                                {{-- Unfavorite Button --}}
                                <button 
                                    class="absolute top-3 right-3 w-9 h-9 rounded-full bg-white/90 dark:bg-[#171A19]/90 backdrop-blur-xs text-rose-500 hover:bg-rose-500 hover:text-white flex items-center justify-center shadow-md transition-all"
                                    onclick="xoaYeuThich({{ $baiDang['id'] }})"
                                    title="Bỏ yêu thích">
                                    <i class="ri-heart-fill text-lg"></i>
                                </button>
                            </div>

                            <div class="p-5">
                                <h2 class="font-serif font-bold text-base text-[#171A19] dark:text-white group-hover:text-[#1B3D2F] dark:group-hover:text-[#A3E635] transition-colors truncate mb-1">
                                    {{ $baiDang['tieu_de'] ?? 'Không có tiêu đề' }}
                                </h2>

                                {{-- Address --}}
                                <p class="text-[#5A605B] dark:text-[#9EA39E] text-xs flex items-center gap-1.5 truncate mb-3">
                                    <i class="ri-map-pin-2-fill text-[#A6824D]"></i>
                                    <span>{{ $baiDang['dia_chi'] ?? 'Đang cập nhật địa chỉ' }}</span>
                                </p>

                                {{-- Rating --}}
                                @if(!empty($baiDang['rating']))
                                    <div class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-amber-50 dark:bg-amber-950/40 text-amber-700 dark:text-amber-400 text-xs font-semibold mb-3">
                                        <i class="ri-star-fill text-amber-500"></i>
                                        <span>{{ $baiDang['rating'] }} / 5</span>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="px-5 pb-5 pt-3 border-t border-[#E5E3DC] dark:border-[#282D2A] flex items-center justify-between">
                            <div>
                                <span class="text-[11px] text-[#5A605B] dark:text-[#9EA39E] block font-medium">Giá thuê</span>
                                <span class="text-base font-serif font-bold text-[#1B3D2F] dark:text-[#4ADE80]">
                                    {{ $baiDang['gia_hien_thi'] ?? 'Liên hệ' }}
                                </span>
                            </div>

                            <a href="{{ route('room.detail', $baiDang['id']) }}"
                                class="inline-flex items-center gap-1 px-3.5 py-1.5 rounded-xl bg-[#FAF9F6] dark:bg-[#282D2A] hover:bg-[#1B3D2F] hover:text-white dark:hover:bg-[#A3E635] dark:hover:text-[#171A19] text-[#171A19] dark:text-white text-xs font-semibold border border-[#E5E3DC] dark:border-[#343B36] transition">
                                Chi tiết <i class="ri-arrow-right-line"></i>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    {{-- SweetAlert & Ajax Scripts --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        const API_BASE_URL = "{{ env('API_BASE_URL', 'http://127.0.0.1:8000') }}/api";

        document.addEventListener('DOMContentLoaded', () => {
            capNhatSoLuongYeuThich();
        });

        async function xoaYeuThich(id) {
            const token = localStorage.getItem('token') || getCookie('api_token');
            if (!token) {
                Swal.fire({
                    icon: 'info',
                    title: 'Cần đăng nhập',
                    text: 'Vui lòng đăng nhập để sử dụng chức năng này.',
                    confirmButtonText: 'Đăng nhập ngay',
                    confirmButtonColor: '#1B3D2F'
                }).then(() => {
                    window.location.href = '/login';
                });
                return;
            }

            try {
                const res = await fetch(`${API_BASE_URL}/khach-thue/yeu-thich/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'Authorization': `Bearer ${token}`,
                        'Accept': 'application/json'
                    }
                });

                const data = await res.json();

                if (res.ok) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Đã xoá khỏi yêu thích',
                        text: data.message || 'Bài đăng đã được gỡ khỏi danh sách.',
                        confirmButtonColor: '#1B3D2F',
                        timer: 1500,
                        showConfirmButton: false
                    }).then(() => {
                        capNhatSoLuongYeuThich();
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Lỗi',
                        text: data.message || 'Không thể xoá yêu thích. Vui lòng thử lại.',
                        confirmButtonColor: '#e11d48'
                    });
                }
            } catch (error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Kết nối thất bại',
                    text: 'Không thể kết nối đến máy chủ.',
                    confirmButtonColor: '#e11d48'
                });
            }
        }

        async function capNhatSoLuongYeuThich() {
            const token = localStorage.getItem('token') || getCookie('api_token');
            if (!token) return;

            try {
                const res = await fetch(`${API_BASE_URL}/khach-thue/yeu-thich`, {
                    headers: { 'Authorization': `Bearer ${token}` }
                });

                if (!res.ok) return;

                const data = await res.json();
                const count = data.data?.length ?? 0;

                const badge = document.getElementById('favorite-count');
                if (!badge) return;

                if (count > 0) {
                    badge.textContent = count;
                    badge.classList.remove('hidden');
                } else {
                    badge.classList.add('hidden');
                }
            } catch (err) {
                console.warn('Không thể cập nhật số lượng yêu thích:', err);
            }
        }

        function getCookie(name) {
            const match = document.cookie.match(new RegExp('(^| )' + name + '=([^;]+)'));
            return match ? match[2] : null;
        }
    </script>
@endsection