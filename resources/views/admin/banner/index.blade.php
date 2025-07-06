@extends('layouts.admin')

@section('content')
    <div class="container-fluid">
        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <a href="{{ route('banner.create') }}"
                        class="btn btn-sm btn-primary d-inline-flex align-items-center gap-2 py-2 px-3">
                        <i class="ti ti-plus fs-5"></i> Thêm banner
                    </a>
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
                        <tbody id="bannerTable">
                            @forelse($banners as $index => $banner)
                                <tr>
                                    <td class="text-center">{{ $index + 1 }}</td>
                                    <td>{{ \Illuminate\Support\Str::limit($banner->tieu_de, 50) }}</td>
                                    <td class="text-center">
                                        @if ($banner->hinh_anh)
                                            <img src="{{ asset('storage/' . $banner->hinh_anh) }}" alt=""
                                                style="width: 80px; border-radius: 6px;">
                                        @else
                                            <span class="text-muted">Chưa có</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        {{ \Carbon\Carbon::parse($banner->created_at)->format('d/m/Y') }}
                                    </td>
                                    <td class="text-center">
                                        @if ($banner->updated_at)
                                            {{ \Carbon\Carbon::parse($banner->updated_at)->format('d/m/Y') }}
                                        @else
                                            <span class="text-muted">Chưa cập nhật</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if ($banner->trang_thai == 1)
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
                                                    <a href="{{ route('banner.edit', $banner->id) }}"
                                                        class="dropdown-item d-flex align-items-center gap-2">
                                                        <i class="ti ti-edit fs-5"></i> Xem
                                                    </a>
                                                </li>
                                                <li>
                                                    <form action="{{ route('banner.destroy', $banner->id) }}" method="POST"
                                                        onsubmit="return confirm('Bạn có chắc chắn muốn xoá banner này?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="dropdown-item d-flex align-items-center gap-2">
                                                            <i class="ti ti-trash fs-5 text-danger"></i> Xoá
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
                        Hiển thị {{ $banners->count() }} trong tổng số {{ $banners->total() }} banner
                    </small>
                    <div>
                        {{ $banners->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

