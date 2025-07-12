@extends('layouts.admin')

@section('content')
    <div class="container-fluid">
        <div class="position-relative overflow-hidden">

            <div class="position-relative overflow-hidden rounded-3">
                <img src="https://bootstrapdemos.wrappixel.com/spike/dist/assets/images/backgrounds/profilebg-2.jpg"
                    alt="spike-img" class="w-100">
            </div>

            <div class="card mx-9 mt-n5">
                <div class="card-body pb-0">

                    <div class="d-md-flex align-items-center justify-content-between text-center text-md-start">
                        <div class="d-md-flex align-items-center">
                            <div class="rounded-circle position-relative mb-9 mb-md-0 d-inline-block">
                                <img style="width:100px; height:90px;"
                                    src="{{ $user->avatar ? asset('storage/' . $user->avatar) : 'https://bootstrapdemos.wrappixel.com/spike/dist/assets/images/profile/user-1.jpg' }}"
                                    alt="avatar" class="img-fluid rounded-circle">
                            </div>
                            <div class="ms-0 ms-md-3 mb-9 mb-md-0">
                                <div class="d-flex align-items-center justify-content-center justify-content-md-start mb-1">
                                    <h4 class="me-7 mb-0 fs-7">{{ $user->name }}</h4>
                                    <span
                                        class="badge fs-2 fw-bold rounded-pill bg-primary-subtle text-primary border-primary border">
                                        @if ($user->vai_tro_id == 0)
                                            Admin
                                        @elseif ($user->vai_tro_id == 1)
                                            Khách hàng
                                        @else
                                            Vai trò khác
                                        @endif
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <ul class="nav nav-pills user-profile-tab mt-4 justify-content-center justify-content-md-start"
                        id="pills-tab" role="tablist">
                        <li class="nav-item me-2 me-md-3" role="presentation">
                            <button
                                class="nav-link position-relative rounded-0 active d-flex align-items-center justify-content-center bg-transparent py-6"
                                id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button"
                                role="tab" aria-controls="pills-profile" aria-selected="true">
                                <i class="ti ti-user-circle me-0 me-md-6  fs-6"></i>
                                <span class="d-none d-md-block">Thông tin người dùng</span>
                            </button>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="tab-content mx-10" id="pills-tabContent">
            <div class="tab-pane fade show active" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab"
                tabindex="0">
                <div class="row">

                    <div class="col-lg-4">
                        <div class="card ">
                            <div class="card-body p-4">
                                <div class="py-4">
                                    <h5 class="mb-4 fw-semibold">Thông tin cá nhân</h5>

                                    <div class="d-flex align-items-center mb-4">
                                        <div
                                            class="bg-danger-subtle text-danger fs-14 round-40 rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="ti ti-phone"></i>
                                        </div>
                                        <div class="ms-3">
                                            <h6 class="mb-1">Số điện thoại</h6>
                                            <p class="mb-0">{{ $user->so_dien_thoai ?? 'Không có' }}</p>
                                        </div>
                                    </div>

                                    <div class="d-flex align-items-center mb-4">
                                        <div
                                            class="bg-success-subtle text-success fs-14 round-40 rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="ti ti-mail"></i>
                                        </div>
                                        <div class="ms-3">
                                            <h6 class="mb-1">Email</h6>
                                            <p class="mb-0">{{ $user->email ?? 'Không có' }}</p>
                                        </div>
                                    </div>

                                    <div class="d-flex align-items-center">
                                        <div
                                            class="bg-primary-subtle text-primary fs-14 round-40 rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="ti ti-user-check"></i>
                                        </div>
                                        <div class="ms-3">
                                            <h6 class="mb-1">Trạng thái</h6>
                                            <p class="mb-0">
                                                {{ $user->trang_thai === 1 ? 'Hoạt động' : 'Tạm khóa' }}
                                            </p>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="col-lg-8">
                        <div class="row">

                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-body p-4">
                                        <div class="d-flex align-items-center">
                                            <div
                                                class="bg-primary-subtle text-primary p-6 fs-7 rounded-circle d-flex align-items-center justify-content-center">
                                                <i class="ti ti-credit-card"></i>
                                            </div>
                                            <div class="ms-6">
                                                <h6 class="mb-1 fs-6">{{ $tongChiTieu }}</h6>
                                                <p class="mb-0">Tổng chi tiêu</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-body p-4">
                                        <div class="d-flex align-items-center">
                                            <div
                                                class="bg-success-subtle text-success p-6 fs-7 rounded-circle d-flex align-items-center justify-content-center">
                                                <i class="ti ti-award"></i>
                                            </div>
                                            <div class="ms-6">
                                                <h6 class="mb-1 fs-6">{{ $user->capBac->ten }}</h6>
                                                <p class="mb-0">Hạng</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="card">
                            <div class="card-body p-4">
                                <ul class="nav nav-tabs mb-3" id="historyTabs" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" id="orders-tab" data-bs-toggle="tab"
                                            data-bs-target="#orders" type="button" role="tab">
                                            Lịch sử đặt hàng
                                        </button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="points-tab" data-bs-toggle="tab"
                                            data-bs-target="#points" type="button" role="tab">
                                            Lịch sử tích điểm
                                        </button>
                                    </li>

                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="rate-tab" data-bs-toggle="tab"
                                            data-bs-target="#rate" type="button" role="tab">
                                            Bình luận
                                        </button>
                                    </li>
                                </ul>

                                <div class="tab-content" id="historyTabsContent">
                                    <div class="tab-pane fade show active" id="orders" role="tabpanel">
                                        @if ($donHangsHoanThanh->isEmpty())
                                            <p class="text-muted">Chưa có đơn hàng nào.</p>
                                        @else
                                            <div class="table-responsive">
                                                <table class="table table-bordered align-middle">
                                                    <thead>
                                                        <tr>
                                                            <th>Mã đơn hàng</th>
                                                            <th>Ngày đặt</th>
                                                            <th>Trạng thái</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($donHangsHoanThanh as $donHang)
                                                            <tr>
                                                                <td>{{ $donHang->ma_van_don }}</td>
                                                                <td>{{ $donHang->created_at->format('d/m/Y H:i') }}</td>
                                                                <td>
                                                                    @if ($donHang->trang_thai === 'hoan_thanh')
                                                                        <span class="badge bg-success">Hoàn thành</span>
                                                                    @elseif ($donHang->trang_thai === 'dang_xu_ly')
                                                                        <span class="badge bg-warning text-dark">Đang xử
                                                                            lý</span>
                                                                    @elseif ($donHang->trang_thai === 'da_huy')
                                                                        <span class="badge bg-danger">Đã huỷ</span>
                                                                    @else
                                                                        <span
                                                                            class="badge bg-secondary">{{ ucfirst($donHang->trang_thai) }}</span>
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="tab-pane fade" id="points" role="tabpanel">
                                        @if ($lichSuDiem->isEmpty())
                                            <p class="text-muted">Chưa có lịch sử tích điểm.</p>
                                        @else
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Ngày</th>
                                                        <th>Loại</th>
                                                        <th>Điểm</th>
                                                        <th>Mô tả</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($lichSuDiem as $index => $diem)
                                                        <tr>
                                                            <td>{{ $index + 1 }}</td>
                                                            <td>{{ \Carbon\Carbon::parse($diem->created_at)->format('d/m/Y H:i') }}
                                                            </td>
                                                            <td>
                                                                @if ($diem->loai === 'Tích điểm')
                                                                    <span class="badge bg-success">Tích điểm</span>
                                                                @else
                                                                    <span class="badge bg-danger">Sử dụng điểm</span>
                                                                @endif
                                                            </td>
                                                            <td>{{ number_format($diem->diem) }}</td>
                                                            <td>{{ $diem->mo_ta }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        @endif
                                    </div>

                                    <div class="tab-pane fade" id="rate" role="tabpanel">
                                        @if ($binhLuans->isEmpty())
                                            <p class="text-muted">Chưa có bình luận.</p>
                                        @else
                                            @foreach ($binhLuans as $binhLuan)
                                                <div class="card mb-4 shadow-sm border-0">
                                                    <div class="row g-0 p-3">
                                                        <div
                                                            class="col-md-2 d-flex align-items-center justify-content-center">
                                                            <img src="{{ asset('storage/' . ($binhLuan->sanPham->hinh_anh ?? 'icon/icon_sp.png')) }}"
                                                                alt="Sản phẩm" class="img-fluid rounded"
                                                                style="max-height: 80px;">
                                                        </div>

                                                        <div class="col-md-10">
                                                            <div class="card-body p-0 ps-3">
                                                                <h6 class="mb-1">
                                                                    {{ $binhLuan->sanPham->ten ?? '[Đã xóa]' }}
                                                                </h6>

                                                                <div class="mb-2">
                                                                    @for ($i = 1; $i <= 5; $i++)
                                                                        @if ($i <= $binhLuan->danh_gia)
                                                                            <i class="fas fa-star text-warning"></i>
                                                                        @else
                                                                            <i class="far fa-star text-muted"></i>
                                                                        @endif
                                                                    @endfor
                                                                </div>

                                                                <div class="mb-2">
                                                                    <p class="mb-1">{{ $binhLuan->noi_dung }}</p>
                                                                </div>

                                                                <div class="text-muted small text-end">
                                                                    {{ $binhLuan->created_at->format('d/m/Y H:i') }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>


                                </div>
                            </div>
                        </div>


                    </div>
                </div>
            </div>

        </div>

    </div>
@endsection
