@extends('layouts.admin')

@section('content')
    <div class="container-fluid">
        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <div class="row mb-3">
                    <div class="col-md-3">
                        <input type="text" id="searchInput" class="form-control" placeholder="Tìm theo tên...">
                    </div>

                    <div class="col-md-3">
                        <select id="roleFilter" class="form-select">
                            <option value="">-- Tất cả vai trò --</option>
                            <option value="1">Admin</option>
                            <option value="2">Nhân viên</option>
                            <option value="3">Khách hàng</option>
                        </select>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table text-nowrap align-middle mb-0">
                        <thead class="bg-gradient-dark text-white">
                            <tr>
                                <th class="text-center" style="width: 5%">#</th>
                                <th>Ảnh</th>
                                <th>Tên</th>
                                <th>Email</th>
                                <th class="text-center">Vai trò</th>
                                <th class="text-center">Ngày tạo</th>
                                <th class="text-center">Trạng thái</th>
                                <th class="text-center">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody id="nguoiDungTable">
                            @forelse($users as $index => $user)
                                <tr data-role="{{ $user->vai_tro_id }}">
                                    <td class="text-center">{{ $index + 1 }}</td>
                                    <td class="text-center">
                                        @if ($user->hinh_anh)
                                            <img src="{{ asset('storage/' . $user->hinh_anh) }}" alt="Ảnh người dùng"
                                                class="rounded-circle" width="40" height="40">
                                        @else
                                            <img src="https://bootstrapdemos.wrappixel.com/spike/dist/assets/images/profile/user-1.jpg"
                                                alt="Mặc định" class="rounded-circle" width="40" height="40">
                                        @endif
                                    </td>
                                    <td>{{ $user->ten }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td class="text-center">
                                        @switch($user->vai_tro_id)
                                            @case(0)
                                                <span class="badge bg-primary">Admin</span>
                                            @break

                                            @case(2)
                                                <span class="badge bg-info">Nhân viên</span>
                                            @break

                                            @case(1)
                                                <span class="badge bg-success">Khách hàng</span>
                                            @break

                                            @default
                                                <span class="badge bg-secondary">Khác</span>
                                        @endswitch
                                    </td>
                                    <td class="text-center">
                                        {{ \Carbon\Carbon::parse($user->created_at)->format('d/m/Y') }}
                                    </td>
                                    <td class="text-center">
                                        @if ($user->trang_thai == 1)
                                            <span class="badge bg-success">Hoạt động</span>
                                        @else
                                            <span class="badge bg-warning text-dark">Khóa</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <div class="dropdown dropstart">
                                            <a href="#" class="text-muted" data-bs-toggle="dropdown">
                                                <i class="ti ti-dots-vertical fs-6"></i>
                                            </a>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <a href="{{ route('nguoi_dung.edit', $user->id) }}"
                                                        class="dropdown-item d-flex align-items-center gap-2">
                                                        <i class="ti ti-eye fs-5 text-primary"></i> Xem chi tiết
                                                    </a>
                                                </li>

                                                <li>
                                                    <form action="{{ route('nguoi_dung.toggleTrangThai', $user->id) }}"
                                                        method="POST"
                                                        onsubmit="return confirm('Bạn có chắc chắn muốn {{ $user->trang_thai ? 'khóa' : 'mở khóa' }} tài khoản này?')">
                                                        @csrf
                                                        <button type="submit"
                                                            class="dropdown-item d-flex align-items-center gap-2">
                                                            <i
                                                                class="ti ti-lock fs-5 {{ $user->trang_thai ? 'text-warning' : 'text-success' }}"></i>
                                                            {{ $user->trang_thai ? 'Khóa tài khoản' : 'Mở khóa tài khoản' }}
                                                        </button>
                                                    </form>
                                                </li>
                                            </ul>


                                        </div>
                                    </td>
                                </tr>
                                @empty
                                    <tr id="emptyRow">
                                        <td colspan="6" class="text-center text-muted py-3">
                                            <i class="ti ti-folder-open me-1"></i> Không có người dùng nào
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <small class="text-muted" id="infoText">
                            Hiển thị {{ $users->count() }} trong tổng số {{ $users->total() }} người dùng
                        </small>
                        <div>
                            {{ $users->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection

    @section('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const searchInput = document.getElementById('searchInput');
                const roleFilter = document.getElementById('roleFilter');

                function filterTable() {
                    const rows = document.querySelectorAll('#nguoiDungTable tr');
                    const searchText = searchInput.value.toLowerCase();
                    const selectedRole = roleFilter.value;
                    let visibleCount = 0;

                    rows.forEach((row) => {
                        if (row.id === 'emptyRow') return;

                        const nameCell = row.querySelector('td:nth-child(2)');
                        const userRole = row.getAttribute('data-role');

                        if (!nameCell) return;

                        const name = nameCell.textContent.toLowerCase();
                        const matchesName = name.includes(searchText);
                        const matchesRole = selectedRole === '' || selectedRole === userRole;

                        if (matchesName && matchesRole) {
                            row.style.display = '';
                            visibleCount++;
                            const indexCell = row.querySelector('td:first-child');
                            if (indexCell) indexCell.textContent = visibleCount;
                        } else {
                            row.style.display = 'none';
                        }
                    });

                    const emptyRow = document.getElementById('emptyRow');
                    if (visibleCount === 0) {
                        if (!emptyRow) {
                            const tr = document.createElement('tr');
                            tr.id = 'emptyRow';
                            tr.innerHTML = `<td colspan="6" class="text-center text-muted py-4">
                        <i class="ti ti-search fs-3 mb-3"></i>
                        <p class="mb-0">Không tìm thấy người dùng phù hợp</p>
                    </td>`;
                            document.getElementById('nguoiDungTable').appendChild(tr);
                        }
                    } else if (emptyRow) {
                        emptyRow.remove();
                    }

                    const infoText = document.getElementById('infoText');
                    if (infoText) {
                        infoText.textContent = `Hiển thị ${visibleCount} người dùng được lọc`;
                    }
                }

                searchInput.addEventListener('input', filterTable);
                roleFilter.addEventListener('change', filterTable);
            });
        </script>
    @endsection
