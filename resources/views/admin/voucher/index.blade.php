@extends('layouts.admin')

@section('content')
    <div class="container-fluid">
        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <a href="{{ route('voucher.create') }}"
                        class="btn btn-sm btn-primary d-inline-flex align-items-center gap-2 py-2 px-3">
                        <i class="ti ti-plus fs-5"></i> Thêm khuyến mãi
                    </a>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <input type="text" id="searchInput" class="form-control" name="search"
                            placeholder="Tìm theo mã khuyến mãi...">
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table text-nowrap align-middle mb-0">
                        <thead class="bg-gradient-dark text-white">
                            <tr>
                                <th class="text-center" style="width: 5%">#</th>
                                <th>Tên khuyến mãi</th>
                                <th>Mã KM</th>
                                <th>Giá trị</th>
                                <th>Số lượng</th>
                                <th>Bắt đầu</th>
                                <th>Kết thúc</th>
                                <th class="text-center" style="width: 10%">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody id="voucherTable">
                            @forelse($vouchers as $index => $voucher)
                                <tr>
                                    <td class="text-center">{{ $index + 1 }}</td>
                                    <td>{{ $voucher->ten_khuyen_mai }}</td>
                                    <td>{{ $voucher->ma }}</td>
                                    <td>{{ rtrim(rtrim(number_format($voucher->gia_tri, 2, '.', ''), '0'), '.') }}</td>
                                    <td>{{ $voucher->so_luong }}</td>
                                    <td>{{ $voucher->bat_dau ? \Carbon\Carbon::parse($voucher->bat_dau)->format('d/m/Y H:i') : 'Không rõ' }}
                                    </td>
                                    <td>{{ $voucher->ket_thuc ? \Carbon\Carbon::parse($voucher->ket_thuc)->format('d/m/Y H:i') : 'Không rõ' }}
                                    </td>
                                    <td class="text-center">
                                        <div class="dropdown dropstart">
                                            <a href="#" class="text-muted" data-bs-toggle="dropdown"
                                                aria-expanded="false">
                                                <i class="ti ti-dots-vertical fs-6"></i>
                                            </a>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <a href="{{ route('voucher.edit', $voucher->id) }}"
                                                        class="dropdown-item d-flex align-items-center gap-2">
                                                        <i class="ti ti-edit fs-5"></i>Xem
                                                    </a>
                                                </li>
                                                <li>
                                                    <form action="{{ route('voucher.destroy', $voucher->id) }}"
                                                        method="POST"
                                                        onsubmit="return confirm('Bạn có chắc chắn muốn xóa khuyến mãi này?')">
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
                        Hiển thị {{ $vouchers->count() }} trong tổng số {{ $vouchers->total() }} khuyến mãi
                    </small>
                    <div>
                        {{ $vouchers->links('pagination::bootstrap-5') }}
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
                const rows = document.querySelectorAll('#voucherTable tr');
                const searchText = searchInput.value.toLowerCase();
                let visibleCount = 0;

                rows.forEach((row) => {
                    if (row.id === 'emptyRow') return;

                    const maCell = row.querySelector('td:nth-child(2)');
                    if (!maCell) return;

                    const maText = maCell.textContent.toLowerCase();
                    const matches = maText.includes(searchText);

                    if (matches) {
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
                        document.getElementById('voucherTable').appendChild(tr);
                    }
                } else if (emptyRow) {
                    emptyRow.remove();
                }

                const infoText = document.getElementById('infoText');
                if (infoText) {
                    infoText.textContent = `Hiển thị ${visibleCount} khuyến mãi được lọc`;
                }
            }

            searchInput.addEventListener('input', filterTable);
        });
    </script>
@endsection
