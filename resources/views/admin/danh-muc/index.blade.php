@extends('layouts.admin')

@section('content')
    <div class="container-fluid">
        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <a href="{{ route('danh_muc.create') }}"
                        class="btn btn-sm btn-primary d-inline-flex align-items-center gap-2 py-2 px-3">
                        <i class="ti ti-plus fs-5"></i> Thêm danh mục
                    </a>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <input type="text" id="searchInput" class="form-control" placeholder="Tìm theo tên danh mục...">
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table text-nowrap align-middle mb-0">
                        <thead class="bg-gradient-dark text-white">
                            <tr>
                                <th class="text-center" style="width: 10%">#</th>
                                <th>Tên danh mục</th>
                                <th class="text-center" style="width: 20%">Ngày tạo</th>
                                <th class="text-center" style="width: 20%">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody id="danhMucTable">
                            @forelse($danhMucs as $index => $danhMuc)
                                <tr>
                                    <td class="text-center">{{ $index + 1 }}</td>
                                    <td class="ten-danh-muc">{{ $danhMuc->ten }}</td>
                                    <td class="text-center">{{ $danhMuc->created_at->format('d/m/Y') }}</td>
                                    <td class="text-center">
                                        <div class="dropdown dropstart">
                                            <a href="#" class="text-muted" data-bs-toggle="dropdown"
                                                aria-expanded="false">
                                                <i class="ti ti-dots-vertical fs-6"></i>
                                            </a>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <a href="{{ route('danh_muc.edit', $danhMuc->id) }}"
                                                        class="dropdown-item d-flex align-items-center gap-2">
                                                        <i class="ti ti-edit fs-5"></i>Sửa
                                                    </a>
                                                </li>
                                                <li>
                                                    <form action="{{ route('danh_muc.destroy', $danhMuc->id) }}"
                                                        method="POST"
                                                        onsubmit="return confirm('Bạn có chắc chắn muốn xóa danh mục này?')">
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
                                    <td colspan="4" class="text-center text-muted py-3">
                                        <i class="ti ti-folder-open me-1"></i> Không có danh mục nào
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-between align-items-center mt-4">
                    <small class="text-muted">
                        Hiển thị {{ $danhMucs->count() }} / {{ $danhMucs->total() }} danh mục
                    </small>
                    <div>
                        {{ $danhMucs->links('pagination::bootstrap-5') }}
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

            function filterTable() {
                const searchText = searchInput.value.toLowerCase();
                const rows = document.querySelectorAll('#danhMucTable tr');
                let visibleCount = 0;

                rows.forEach((row) => {
                    const nameCell = row.querySelector('.ten-danh-muc');

                    if (!nameCell) return;

                    const name = nameCell.textContent.toLowerCase();
                    const matches = name.includes(searchText);

                    if (matches) {
                        row.style.display = '';
                        visibleCount++;
                        const indexCell = row.querySelector('td:first-child');
                        if (indexCell) indexCell.textContent = visibleCount;
                    } else {
                        row.style.display = 'none';
                    }
                });

                let emptyRow = document.getElementById('emptyRow');
                if (visibleCount === 0) {
                    if (!emptyRow) {
                        emptyRow = document.createElement('tr');
                        emptyRow.id = 'emptyRow';
                        emptyRow.innerHTML = `
                            <td colspan="4" class="text-center text-muted py-3">
                                <i class="ti ti-search me-1"></i> Không tìm thấy kết quả phù hợp
                            </td>`;
                        document.getElementById('danhMucTable').appendChild(emptyRow);
                    }
                } else {
                    if (emptyRow) emptyRow.remove();
                }
            }

            searchInput.addEventListener('input', filterTable);
        });
    </script>
@endsection
