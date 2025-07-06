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
                                                <h6 class="mb-1 fs-6">680</h6>
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
                                                <h6 class="mb-1 fs-6">42</h6>
                                                <p class="mb-0">Hạng</p>
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
                                                class="bg-danger-subtle text-danger p-6 fs-7 rounded-circle d-flex align-items-center justify-content-center">
                                                <i class="ti ti-ticket"></i>
                                            </div>
                                            <div class="ms-6">
                                                <h6 class="mb-1 fs-6">780</h6>
                                                <p class="mb-0">Số vé đã đặt</p>
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
                                </ul>

                                <div class="tab-content" id="historyTabsContent">
                                    <div class="tab-pane fade show active" id="orders" role="tabpanel">
                                        <p class="text-muted">Chưa có đơn hàng nào.</p>
                                    </div>

                                    <div class="tab-pane fade" id="points" role="tabpanel">
                                        <p class="text-muted">Chưa có lịch sử tích điểm.</p>
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
