@extends('layouts.admin')

@section('content')
    <div class="container-fluid">
        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <a href="{{ route('san_pham.create') }}"
                        class="btn btn-sm btn-primary d-inline-flex align-items-center gap-2 py-2 px-3">
                        <i class="ti ti-plus fs-5"></i> Thêm sản phẩm
                    </a>
                </div>

                <div class="row mb-3">

                    <div class="col-md-4">
                        <input type="text" id="searchInput" class="form-control" placeholder="Tìm theo tên sản phẩm...">
                    </div>

                    <div class="col-md-4">
                        <select id="categoryFilter" class="form-select">
                            <option value="">-- Tất cả danh mục --</option>
                            @foreach ($danhMucs as $danhMuc)
                                <option value="{{ $danhMuc->id }}">{{ $danhMuc->ten }}</option>
                            @endforeach
                        </select>
                    </div>

                </div>

                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead class="bg-gradient-dark text-white">
                            <tr>
                                <th class="text-center" style="width: 5%">#</th>
                                <th>Tên sản phẩm</th>
                                <th>Hình ảnh</th>
                                <th>Giá</th>
                                <th>Số lượng</th>
                                <th>Danh mục</th>
                                <th>Trạng thái</th>
                                <th class="text-center" style="width: 10%">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody id="sanPhamTable">
                            @forelse ($sanPhams as $index => $sanPham)
                                <tr data-category="{{ $sanPham->danh_muc_id }}">
                                    <td class="text-center">{{ $index + 1 }}</td>
                                    <td class="ten">{{ $sanPham->ten }}</td>
                                    <td>
                                        <img width="150px" src="{{ asset('storage/' . $sanPham->hinh_anh) }}"
                                            alt="">
                                    </td>
                                    <td>{{ number_format($sanPham->gia, 0, ',', '.') }}₫</td>
                                    <td>{{ $sanPham->so_luong }}</td>
                                    <td>{{ $sanPham->danhMuc->ten }}</td>
                                    <td>
                                        @if ($sanPham->trang_thai)
                                            <span class="badge bg-success">Hiển thị</span>
                                        @else
                                            <span class="badge bg-warning">Ẩn</span>
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
                                                    <a href="{{ route('san_pham.edit', $sanPham->id) }}"
                                                        class="dropdown-item d-flex align-items-center gap-2">
                                                        <i class="ti ti-edit fs-5"></i> Sửa
                                                    </a>
                                                </li>
                                                <li>
                                                    <form action="{{ route('san_pham.destroy', $sanPham->id) }}"
                                                        method="POST"
                                                        onsubmit="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?')">
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
                                    <td colspan="6" class="text-center text-muted py-3">
                                        <i class="ti ti-folder-open me-1"></i> Không có dữ liệu
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-between align-items-center mt-4">
                    <small class="text-muted" id="infoText">
                        Hiển thị {{ $sanPhams->count() }} trong tổng số {{ $sanPhams->total() }} sản phẩm
                    </small>
                    <div>
                        {{ $sanPhams->links('pagination::bootstrap-5') }}
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
            const categoryFilter = document.getElementById('categoryFilter');

            function filterTable() {
                const rows = document.querySelectorAll('#sanPhamTable tr');
                const searchText = searchInput.value.toLowerCase();
                const selectedCategory = categoryFilter.value;
                let visibleCount = 0;

                rows.forEach((row) => {
                    if (row.id === 'emptyRow') return;

                    const nameCell = row.querySelector('.ten');
                    const categoryId = row.getAttribute('data-category');

                    if (!nameCell) return;

                    const name = nameCell.textContent.toLowerCase();
                    const matchesName = name.includes(searchText);
                    const matchesCategory = selectedCategory === '' || categoryId === selectedCategory;

                    if (matchesName && matchesCategory) {
                        row.style.display = '';
                        row.querySelector('td:first-child').textContent = ++visibleCount;
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
                        <td colspan="6" class="text-center text-muted py-4">
                            <div class="py-3">
                                <i class="ti ti-search fs-3 mb-3"></i>
                                <p class="mb-0">Không tìm thấy sản phẩm phù hợp</p>
                            </div>
                        </td>`;
                        document.getElementById('sanPhamTable').appendChild(tr);
                    }
                } else if (emptyRow) {
                    emptyRow.remove();
                }

                document.getElementById('infoText').textContent = `Hiển thị ${visibleCount} sản phẩm được lọc`;
            }

            searchInput.addEventListener('input', filterTable);
            categoryFilter.addEventListener('change', filterTable);
        });
    </script>
@endsection
