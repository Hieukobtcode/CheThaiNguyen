@extends('layouts.admin')

@section('content')
    <div class="container-fluid">
        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <a href="{{ route('bai_viet.create') }}"
                        class="btn btn-sm btn-primary d-inline-flex align-items-center gap-2 py-2 px-3">
                        <i class="ti ti-plus fs-5"></i> Thêm bài viết
                    </a>
                </div>

                <div class="row mb-3">
                    <div class="col-md-3">
                        <input type="text" id="searchInput" class="form-control" name="search"
                            placeholder="Tìm theo tiêu đề...">
                    </div>

                    <div class="col-md-3">
                        <select id="statusFilter" class="form-select" name="status">
                            <option value="">-- Tất cả trạng thái --</option>
                            <option value="published">Xuất bản</option>
                            <option value="draft">Bản nháp</option>
                        </select>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table text-nowrap align-middle mb-0">
                        <thead class="bg-gradient-dark text-white">
                            <tr>
                                <th class="text-center" style="width: 5%">#</th>
                                <th>Tiêu đề</th>
                                <th class="text-center" style="width: 15%">Hình ảnh</th>
                                <th class="text-center" style="width: 15%">Ngày tạo</th>
                                <th class="text-center" style="width: 15%">Cập nhật</th>
                                <th class="text-center" style="width: 15%">Trạng thái</th>
                                <th class="text-center" style="width: 10%">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody id="baiVietTable">
                            @forelse($baiViets as $index => $baiViet)
                                <tr>
                                    <td class="text-center">{{ $index + 1 }}</td>
                                    <td>{{ \Illuminate\Support\Str::limit($baiViet->tieu_de, 50) }}</td>
                                    <td class="text-center">
                                        @if ($baiViet->hinh_anh)
                                            <img src="{{ asset('storage/' . $baiViet->hinh_anh) }}" alt=""
                                                style="width: 80px; border-radius: 6px;">
                                        @else
                                            <span class="text-muted">Chưa có</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        {{ \Carbon\Carbon::parse($baiViet->created_at)->format('d/m/Y') }}
                                    </td>
                                    <td class="text-center">
                                        @if ($baiViet->updated_at)
                                            {{ \Carbon\Carbon::parse($baiViet->updated_at)->format('d/m/Y') }}
                                        @else
                                            <span class="text-muted">Chưa cập nhật</span>
                                        @endif
                                    </td>
                                    @php
                                        $trangThaiValue = $baiViet->trang_thai === 'Xuất bản' ? 'published' : 'draft';
                                    @endphp
                                    <td class="text-center" data-status="{{ $trangThaiValue }}">
                                        @if ($trangThaiValue === 'published')
                                            <span class="badge bg-success">Xuất bản</span>
                                        @else
                                            <span class="badge bg-secondary">Bản nháp</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <div class="dropdown dropstart">
                                            <a href="#" class="text-muted" data-bs-toggle="dropdown"
                                                aria-expanded="false">
                                                <i class="ti ti-dots-vertical fs-6"></i>
                                            </a>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <a href="{{ route('bai_viet.edit', $baiViet->id) }}"
                                                        class="dropdown-item d-flex align-items-center gap-2">
                                                        <i class="ti ti-edit fs-5"></i>Xem
                                                    </a>
                                                </li>
                                                <li>
                                                    <form action="{{ route('bai_viet.destroy', $baiViet->id) }}"
                                                        method="POST"
                                                        onsubmit="return confirm('Bạn có chắc chắn muốn xóa bài viết này?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="dropdown-item d-flex align-items-center gap-2">
                                                            <i class="ti ti-trash fs-5 text-danger"></i> Xóa
                                                        </button>
                                                    </form>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr id="emptyRow">
                                    <td colspan="7" class="text-center text-muted py-3">
                                        <i class="ti ti-folder-open me-1"></i> Không có dữ liệu
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-between align-items-center mt-4">
                    <small class="text-muted" id="infoText">
                        Hiển thị {{ $baiViets->count() }} trong tổng số {{ $baiViets->total() }} bài viết
                    </small>
                    <div>
                        {{ $baiViets->links('pagination::bootstrap-5') }}
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
            const statusFilter = document.getElementById('statusFilter');

            function filterTable() {
                const rows = document.querySelectorAll('#baiVietTable tr');
                const searchText = searchInput.value.toLowerCase();
                const selectedStatus = statusFilter.value;
                let visibleCount = 0;

                rows.forEach((row) => {
                    // Bỏ qua dòng "Không có dữ liệu" nếu có
                    if (row.id === 'emptyRow') return;

                    const titleCell = row.querySelector('td:nth-child(2)');
                    const statusCell = row.querySelector('td[data-status]');

                    if (!titleCell || !statusCell) return;

                    const title = titleCell.textContent.toLowerCase();
                    const status = statusCell.getAttribute('data-status');

                    const matchesTitle = title.includes(searchText);
                    const matchesStatus = selectedStatus === '' || status === selectedStatus;

                    if (matchesTitle && matchesStatus) {
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
                        tr.innerHTML = `
                            <td colspan="7" class="text-center text-muted py-4">
                                <div class="py-3">
                                    <i class="ti ti-search fs-3 mb-3"></i>
                                    <p class="mb-0">Không tìm thấy kết quả phù hợp</p>
                                </div>
                            </td>`;
                        document.getElementById('baiVietTable').appendChild(tr);
                    }
                } else if (emptyRow) {
                    emptyRow.remove();
                }

                const infoText = document.getElementById('infoText');
                if (infoText) {
                    infoText.textContent = `Hiển thị ${visibleCount} bài viết được lọc`;
                }
            }

            searchInput.addEventListener('input', filterTable);
            statusFilter.addEventListener('change', filterTable);
        });
    </script>
@endsection
