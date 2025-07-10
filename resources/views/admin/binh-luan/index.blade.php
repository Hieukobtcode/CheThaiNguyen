    @extends('layouts.admin')

    @section('content')
        <div class="container-fluid">
            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
                    <div class="table-responsive">
                        <table class="table text-nowrap align-middle mb-0">
                            <thead class="bg-gradient-dark text-white">
                                <tr>
                                    <th class="text-center" style="width: 5%">#</th>
                                    <th>Người dùng</th>
                                    <th class="text-center" style="width: 15%">Sản phẩm</th>
                                    <th class="text-center" style="width: 15%">Hình ảnh</th>
                                    <th class="text-center" style="width: 15%">Ngày đánh giá</th>
                                    <th class="text-center" style="width: 15%">Trạng thái</th>
                                    <th class="text-center" style="width: 10%">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody id="binhLuanTable">
                                @forelse($BinhLuans as $index => $binhLuan)
                                    <tr>
                                        <td class="text-center">{{ $index + 1 }}</td>
                                        <td>{{ $binhLuan->nguoiDung->ten }}</td>
                                        <td class="text-center">{{ $binhLuan->sanPham->ten }}</td>
                                        <td class="text-center">
                                            <img src="{{ asset('storage/' . ($binhLuan->sanPham->hinh_anh ?? 'icon/icon_sp.png')) }}"
                                                alt="" style="width: 80px;">
                                        </td>
                                        <td class="text-center">{{ $binhLuan->created_at->format('d/m/Y H:i') }}</td>
                                        <td class="text-center">
                                            @if ($binhLuan->trang_thai === 'hien')
                                                <span class="badge bg-success">Hiển thị</span>
                                            @else
                                                <span class="badge bg-secondary">ẨN</span>
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
                                                        <a href="{{ route('binh_luan.edit', $binhLuan->id) }}"
                                                            class="dropdown-item d-flex align-items-center gap-2">
                                                            <i class="ti ti-edit fs-5"></i>Xem
                                                        </a>
                                                    </li>

                                                    <li>
                                                        <form action="{{ route('binh_luan.destroy', $binhLuan->id) }}"
                                                            method="POST"
                                                            onsubmit="return confirm('Bạn có chắc chắn muốn ẩn bình luận này?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit"
                                                                class="dropdown-item d-flex align-items-center gap-2">
                                                                <i class="ti ti-trash fs-5 text-danger"></i> Ẩn
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
                            Hiển thị {{ $BinhLuans->count() }} trong tổng số {{ $BinhLuans->total() }} bình luận
                        </small>
                        <div>
                            {{ $BinhLuans->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
