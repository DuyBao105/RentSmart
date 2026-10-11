@extends('admin.layout')

@section('title', 'Admin — Quản lý Tài khoản')

@section('content')
<div class="space-y-6">
  {{-- Header --}}
  <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-2 border-b border-[#E5E3DC] dark:border-[#282D2A]">
    <div>
      <div class="inline-flex items-center gap-2 px-2.5 py-1 rounded-full bg-[#1B3D2F]/10 dark:bg-[#244B3B]/30 text-[#1B3D2F] dark:text-[#A3E635] text-xs font-semibold mb-2">
        <i class="ri-user-settings-line"></i> Phân quyền & Định danh Người dùng
      </div>
      <h1 class="text-2xl sm:text-3xl font-serif font-bold text-[#171A19] dark:text-[#FAF9F6] tracking-tight">
        Quản Lý Tài Khoản
      </h1>
      <p class="text-xs sm:text-sm text-[#5A605B] dark:text-[#9EA39E] mt-1 font-sans">
        Giám sát trạng thái hoạt động, vai trò thành viên và bảo mật tài khoản người dùng trên nền tảng.
      </p>
    </div>
  </div>

  {{-- Flash Notices --}}
  @if(isset($error))
    <div class="p-4 bg-rose-50 dark:bg-rose-950/40 border border-rose-200 dark:border-rose-800 rounded-xl text-rose-800 dark:text-rose-300 text-xs sm:text-sm font-medium flex items-center gap-2">
      <i class="ri-error-warning-fill text-rose-600 text-base"></i>
      <strong>Lỗi:</strong> {{ $error }}
    </div>
  @endif

  @if(session('success'))
    <div class="p-4 bg-emerald-50 dark:bg-emerald-950/40 border border-emerald-200 dark:border-emerald-800 rounded-xl text-emerald-800 dark:text-emerald-300 text-xs sm:text-sm font-medium flex items-center gap-2">
      <i class="ri-checkbox-circle-fill text-emerald-600 text-base"></i>
      {{ session('success') }}
    </div>
  @endif

  {{-- Statistics Strip --}}
  @if(isset($stats))
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
      <div class="bg-white dark:bg-[#1E2320] p-5 rounded-2xl border border-[#E5E3DC] dark:border-[#2D332F] shadow-sm">
        <div class="text-xs font-medium text-[#5A605B] dark:text-[#9EA39E] uppercase tracking-wider">Tổng tài khoản</div>
        <div class="text-2xl sm:text-3xl font-serif font-bold text-[#171A19] dark:text-white mt-1.5">
          {{ number_format($stats['tong_tai_khoan'] ?? 0) }}
        </div>
      </div>
      <div class="bg-white dark:bg-[#1E2320] p-5 rounded-2xl border border-[#E5E3DC] dark:border-[#2D332F] shadow-sm">
        <div class="text-xs font-medium text-[#5A605B] dark:text-[#9EA39E] uppercase tracking-wider">Chủ trọ / Đối tác</div>
        <div class="text-2xl sm:text-3xl font-serif font-bold text-[#1B3D2F] dark:text-[#A3E635] mt-1.5">
          {{ number_format($stats['theo_vai_tro']['chu_tro'] ?? 0) }}
        </div>
      </div>
      <div class="bg-white dark:bg-[#1E2320] p-5 rounded-2xl border border-[#E5E3DC] dark:border-[#2D332F] shadow-sm">
        <div class="text-xs font-medium text-[#5A605B] dark:text-[#9EA39E] uppercase tracking-wider">Khách thuê</div>
        <div class="text-2xl sm:text-3xl font-serif font-bold text-[#A6824D] mt-1.5">
          {{ number_format($stats['theo_vai_tro']['khach_thue'] ?? 0) }}
        </div>
      </div>
      <div class="bg-white dark:bg-[#1E2320] p-5 rounded-2xl border border-[#E5E3DC] dark:border-[#2D332F] shadow-sm">
        <div class="text-xs font-medium text-[#5A605B] dark:text-[#9EA39E] uppercase tracking-wider">Đăng ký tháng này</div>
        <div class="text-2xl sm:text-3xl font-serif font-bold text-emerald-700 dark:text-emerald-400 mt-1.5">
          +{{ number_format($stats['moi_trong_thang'] ?? 0) }}
        </div>
      </div>
    </div>
  @endif

  {{-- Accounts Master Table --}}
  <div class="bg-white dark:bg-[#1E2320] rounded-2xl shadow-sm border border-[#E5E3DC] dark:border-[#2D332F] overflow-hidden">
    <div class="overflow-x-auto">
      <table class="min-w-full divide-y divide-[#E5E3DC] dark:divide-[#282D2A]">
        <thead class="bg-[#FAF9F6] dark:bg-[#282D2A]/60">
          <tr>
            <th class="px-5 py-3.5 text-left text-xs font-semibold uppercase tracking-wider text-[#5A605B] dark:text-[#9EA39E]">Họ và tên</th>
            <th class="px-5 py-3.5 text-left text-xs font-semibold uppercase tracking-wider text-[#5A605B] dark:text-[#9EA39E]">Địa chỉ Email</th>
            <th class="px-5 py-3.5 text-left text-xs font-semibold uppercase tracking-wider text-[#5A605B] dark:text-[#9EA39E]">Vai trò hệ thống</th>
            <th class="px-5 py-3.5 text-left text-xs font-semibold uppercase tracking-wider text-[#5A605B] dark:text-[#9EA39E]">Trạng thái</th>
            <th class="px-5 py-3.5 text-right text-xs font-semibold uppercase tracking-wider text-[#5A605B] dark:text-[#9EA39E]">Thao tác</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-[#E5E3DC] dark:divide-[#282D2A] text-xs sm:text-sm">
          @if(isset($accounts) && isset($accounts['data']) && count($accounts['data']) > 0)
            @foreach ($accounts['data'] as $acc)
            <tr class="hover:bg-[#FAF9F6]/60 dark:hover:bg-[#282D2A]/40 transition">
              <td class="px-5 py-4">
                <div class="font-medium text-[#171A19] dark:text-white">{{ $acc['ho_ten'] ?? 'N/A' }}</div>
                <span class="text-[11px] text-[#5A605B] dark:text-[#9EA39E] block">ID: #{{ $acc['id'] ?? '—' }}</span>
              </td>
              <td class="px-5 py-4 text-[#5A605B] dark:text-[#9EA39E]">
                {{ $acc['email'] ?? 'N/A' }}
              </td>
              <td class="px-5 py-4">
                @php
                  $role = $acc['vai_tro'] ?? '';
                  $roleClass = match($role) {
                    'quan_tri' => 'bg-purple-50 text-purple-800 border-purple-200 dark:bg-purple-950/40 dark:text-purple-300 dark:border-purple-800',
                    'chu_tro' => 'bg-[#1B3D2F]/10 text-[#1B3D2F] border-[#1B3D2F]/30 dark:bg-[#244B3B]/40 dark:text-[#A3E635] dark:border-[#244B3B]',
                    'khach_thue' => 'bg-blue-50 text-blue-800 border-blue-200 dark:bg-blue-950/40 dark:text-blue-300 dark:border-blue-800',
                    default => 'bg-gray-100 text-gray-700 border-gray-200 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-700'
                  };
                  $roleText = match($role) {
                    'quan_tri' => 'Quản trị viên',
                    'chu_tro' => 'Chủ trọ',
                    'khach_thue' => 'Khách thuê',
                    default => 'N/A'
                  };
                @endphp
                <span class="inline-block px-2.5 py-1 rounded-full text-xs font-medium border {{ $roleClass }}">
                  {{ $roleText }}
                </span>
              </td>
              <td class="px-5 py-4">
                @php
                  $tt = $acc['trang_thai'] ?? '';
                  if($tt === 'hoat_dong') {
                    $statusClass = 'bg-emerald-50 text-emerald-800 border-emerald-200 dark:bg-emerald-950/40 dark:text-emerald-400 dark:border-emerald-800';
                    $statusText = 'Hoạt động';
                  } elseif(in_array($tt, ['da_khoa','khoa','da-khoa'])) {
                    $statusClass = 'bg-rose-50 text-rose-800 border-rose-200 dark:bg-rose-950/40 dark:text-rose-400 dark:border-rose-800';
                    $statusText = 'Đã khóa';
                  } elseif($tt === 'chua_xac_thuc') {
                    $statusClass = 'bg-amber-50 text-amber-800 border-amber-200 dark:bg-amber-950/40 dark:text-amber-400 dark:border-amber-800';
                    $statusText = 'Chưa xác thực';
                  } else {
                    $statusClass = 'bg-gray-100 text-slate-600 border-gray-200 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-700';
                    $statusText = ucfirst($tt ?: 'N/A');
                  }
                @endphp
                <span class="inline-block px-2.5 py-1 rounded-full text-xs font-medium border {{ $statusClass }}">
                  {{ $statusText }}
                </span>
              </td>
              <td class="px-5 py-4 text-right whitespace-nowrap">
                <div class="inline-flex items-center gap-1.5">
                  <button type="button"
                          data-acc-id="{{ $acc['id'] }}"
                          data-acc-name="{{ $acc['ho_ten'] }}"
                          data-acc-role="{{ $acc['vai_tro'] }}"
                          class="edit-btn px-2.5 py-1.5 rounded-lg border border-[#E5E3DC] dark:border-[#2D332F] text-xs font-medium text-[#5A605B] dark:text-[#9EA39E] hover:text-[#171A19] dark:hover:text-white hover:bg-[#FAF9F6] dark:hover:bg-[#282D2A] transition">
                    Sửa vai trò
                  </button>

                  <form method="POST" action="{{ route('admin.accounts.status', $acc['id']) }}" class="inline status-form">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="acc_name" value="{{ $acc['ho_ten'] }}">
                    <select name="trang_thai" class="status-select bg-[#FAF9F6] dark:bg-[#282D2A] border border-[#E5E3DC] dark:border-[#343B36] rounded-lg px-2 py-1 text-xs text-[#171A19] dark:text-white focus:outline-none focus:ring-1 focus:ring-[#1B3D2F]" onchange="this.form.submit()">
                      <option value="hoat_dong" {{ ($acc['trang_thai'] ?? '') === 'hoat_dong' ? 'selected' : '' }}>Mở hoạt động</option>
                      <option value="da_khoa" {{ in_array($acc['trang_thai'] ?? '', ['da_khoa','khoa','da-khoa']) ? 'selected' : '' }}>Khóa tài khoản</option>
                      <option value="chua_xac_thuc" {{ ($acc['trang_thai'] ?? '') === 'chua_xac_thuc' ? 'selected' : '' }}>Chưa xác thực</option>
                    </select>
                  </form>

                  <form method="POST" action="{{ route('admin.accounts.delete', $acc['id']) }}" class="inline delete-form">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" name="acc_name" value="{{ $acc['ho_ten'] }}">
                    <button type="submit" 
                            class="px-2.5 py-1.5 rounded-lg border border-rose-200 dark:border-rose-900 bg-rose-50 hover:bg-rose-100 text-rose-700 dark:bg-rose-950/40 dark:hover:bg-rose-900/50 dark:text-rose-300 text-xs font-medium transition">
                      Xóa
                    </button>
                  </form>
                </div>
              </td>
            </tr>
            @endforeach
          @else
            <tr>
              <td colspan="5" class="px-5 py-12 text-center text-[#5A605B] dark:text-[#9EA39E]">
                Không có dữ liệu tài khoản người dùng
              </td>
            </tr>
          @endif
        </tbody>
      </table>
    </div>

    {{-- Pagination --}}
    @if(isset($accounts) && isset($accounts['total']) && $accounts['total'] > 0)
      <div class="px-5 py-3.5 border-t border-[#E5E3DC] dark:border-[#282D2A] bg-[#FAF9F6]/50 dark:bg-[#282D2A]/30">
        <div class="flex flex-col sm:flex-row items-center justify-between gap-3 text-xs">
          <div class="text-[#5A605B] dark:text-[#9EA39E]">
            Hiển thị <strong class="text-[#171A19] dark:text-white">{{ count($accounts['data']) }}</strong> / <strong class="text-[#171A19] dark:text-white">{{ $accounts['total'] }}</strong> tài khoản
          </div>
          @if(isset($accounts['current_page']) && isset($accounts['last_page']))
            <div class="flex items-center gap-2">
              @if($accounts['current_page'] > 1)
                <a href="{{ request()->fullUrlWithQuery(['page' => $accounts['current_page'] - 1]) }}" class="px-3 py-1.5 border border-[#E5E3DC] dark:border-[#2D332F] rounded-lg text-xs font-medium text-[#171A19] dark:text-white bg-white dark:bg-[#1E2320] hover:bg-[#FAF9F6] transition">« Trước</a>
              @else
                <button class="px-3 py-1.5 border border-[#E5E3DC] dark:border-[#2D332F] rounded-lg text-xs font-medium text-gray-300 dark:text-gray-600 bg-gray-50 dark:bg-gray-800/50 cursor-not-allowed" disabled>« Trước</button>
              @endif

              <span class="text-xs text-[#5A605B] dark:text-[#9EA39E] px-2 font-medium">Trang {{ $accounts['current_page'] }} / {{ $accounts['last_page'] }}</span>

              @if($accounts['current_page'] < $accounts['last_page'])
                <a href="{{ request()->fullUrlWithQuery(['page' => $accounts['current_page'] + 1]) }}" class="px-3 py-1.5 border border-[#E5E3DC] dark:border-[#2D332F] rounded-lg text-xs font-medium text-[#171A19] dark:text-white bg-white dark:bg-[#1E2320] hover:bg-[#FAF9F6] transition">Sau »</a>
              @else
                <button class="px-3 py-1.5 border border-[#E5E3DC] dark:border-[#2D332F] rounded-lg text-xs font-medium text-gray-300 dark:text-gray-600 bg-gray-50 dark:bg-gray-800/50 cursor-not-allowed" disabled>Sau »</button>
              @endif
            </div>
          @endif
        </div>
      </div>
    @endif
  </div>

  {{-- Modal Sửa Vai Trò --}}
  <div id="editRoleModal" class="hidden fixed inset-0 bg-black/60 backdrop-blur-xs flex items-center justify-center z-50 p-4">
    <div class="bg-white dark:bg-[#1E2320] rounded-2xl p-6 max-w-md w-full border border-[#E5E3DC] dark:border-[#2D332F] shadow-2xl pointer-events-auto" id="editRoleModalContent">
      <h3 class="text-lg font-serif font-bold text-[#171A19] dark:text-white mb-2">Chỉnh sửa vai trò thành viên</h3>
      <p class="text-xs text-[#5A605B] dark:text-[#9EA39E] mb-4">Gán lại quyền hạn truy cập cho tài khoản trong hệ thống quản trị.</p>

      <form id="editRoleForm" method="POST" action="" data-no-ajax="true">
        @csrf
        @method('PATCH')
        <input type="hidden" name="account_id" id="edit_account_id">
        
        <div class="mb-4 p-3 rounded-xl bg-[#FAF9F6] dark:bg-[#282D2A] border border-[#E5E3DC] dark:border-[#343B36] text-xs">
          <span class="text-[#5A605B] dark:text-[#9EA39E]">Thành viên:</span>
          <span id="edit_account_name" class="font-bold text-[#171A19] dark:text-white ml-1"></span>
        </div>

        <div class="mb-4">
          <label class="block text-xs font-semibold uppercase tracking-wider text-[#5A605B] dark:text-[#9EA39E] mb-2">Vai trò mới:</label>
          <select name="vai_tro" required class="w-full bg-[#FAF9F6] dark:bg-[#282D2A] border border-[#E5E3DC] dark:border-[#343B36] rounded-xl px-3.5 py-2.5 text-xs sm:text-sm text-[#171A19] dark:text-white focus:outline-none focus:ring-1 focus:ring-[#1B3D2F]">
            <option value="khach_thue">Khách thuê phòng</option>
            <option value="chu_tro">Chủ trọ / Cho thuê</option>
            <option value="quan_tri">Quản trị viên (Admin)</option>
          </select>
        </div>

        <div class="flex items-center justify-end gap-2.5 pt-2 border-t border-[#E5E3DC] dark:border-[#282D2A]">
          <button type="button" 
                  id="editRoleCancelBtn"
                  class="px-4 py-2 border border-[#E5E3DC] dark:border-[#2D332F] text-xs font-medium rounded-xl text-[#5A605B] dark:text-[#9EA39E] hover:text-[#171A19] dark:hover:text-white transition">
            Hủy
          </button>
          <button type="submit" data-no-ajax="true"
                  class="px-4 py-2 bg-[#1B3D2F] hover:bg-[#244B3B] text-white text-xs font-medium rounded-xl transition shadow-xs">
            Cập nhật vai trò
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
  // Xử lý form Xóa tài khoản
  document.querySelectorAll('.delete-form').forEach(form => {
    form.addEventListener('submit', function(e) {
      e.preventDefault();
      const accName = this.querySelector('input[name="acc_name"]').value;
      const action = this.action;
      if (!confirm(`Xác nhận xóa tài khoản "${accName}"? Hành động không thể hoàn tác.`)) {
        return;
      }

      const token = this.querySelector('input[name="_token"]').value;
      const formData = new URLSearchParams();
      formData.append('_token', token);
      formData.append('_method', 'DELETE');

      const accNameInput = this.querySelector('input[name="acc_name"]');
      if (accNameInput) formData.append('acc_name', accNameInput.value);

      fetch(action, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8',
          'X-Requested-With': 'XMLHttpRequest',
          'X-CSRF-TOKEN': token
        },
        body: formData.toString(),
        credentials: 'same-origin'
      }).then(r => r.json().catch(() => ({}))).then(json => {
        if (json && json.success) {
          const row = form.closest('tr');
          if (row) row.remove();
          alert('Đã xóa tài khoản thành công');
        } else if (json && json.error) {
          alert('Lỗi xóa: ' + json.error);
        } else {
          window.location.reload();
        }
      }).catch(err => {
        console.error('Delete error', err);
        this.submit();
      });
    });
  });

  // Xử lý nút sửa vai trò
  document.querySelectorAll('.edit-btn').forEach(btn => {
    btn.addEventListener('click', function() {
      const accId = this.dataset.accId;
      const accName = this.dataset.accName;
      const accRole = this.dataset.accRole;
      
      document.getElementById('edit_account_id').value = accId;
      document.getElementById('edit_account_name').textContent = accName;
      document.getElementById('editRoleForm').action = `/admin/accounts/${accId}/role`;
      document.querySelector('select[name="vai_tro"]').value = accRole;
      
      document.getElementById('editRoleModal').classList.remove('hidden');
    });
  });

  window.hideEditRoleModal = function() {
    const modal = document.getElementById('editRoleModal');
    if (!modal) return;
    modal.classList.add('hidden');
  }

  document.addEventListener('click', function (e) {
    const cancel = e.target.closest && e.target.closest('#editRoleCancelBtn');
    if (cancel) {
      e.preventDefault();
      window.hideEditRoleModal();
    }
  }, true);

  document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape' || e.key === 'Esc') {
      window.hideEditRoleModal();
    }
  });

  document.getElementById('editRoleModal').addEventListener('click', function(e) {
    if (e.target === this) {
      hideEditRoleModal();
    }
  });
</script>
@endsection
