@extends('layouts.client')

@section('content')
    <div id="PageContainer" class="margin-page user-page">

        <div class="head-page">
            <div class="container">
                <h1 class="text-uppercase font-weight-bold mb-0 text-center">Tài khoản của tôi</h1>
            </div>
        </div>

        <div class="container">
            <div class="row">
                <div class="left-menu col-md-4">
                    <p class="fullname-user font-weight-bold title pb-2">
                        <span>{{ auth()->user()->ho_va_ten ?? 'Người dùng' }}</span>
                    </p>
                    <ul class="py-3 py-md-0 pl-0 mb-0">
                        <li>
                            <a class="d-inline-block" href="{{ route('profile') }}">
                                <span class="d-inline-block">
                                    <img loading="lazy" src="https://web.nvnstatic.net/tp/T0239/img/userProfile.png?v=9"
                                        alt="profile">
                                </span>
                                <span class="active">Hồ sơ của tôi</span>
                            </a>
                        </li>

                        <li>
                            <a class="d-inline-block" href="{{ route('dia-chi') }}">
                                <span class="d-inline-block">
                                    <i class="fa fa-map-marker fa-2x" aria-hidden="true"></i>
                                </span>
                                <span>Địa chỉ nhận hàng</span>
                            </a>
                        </li>

                        <li>
                            <a class="d-inline-block" href="{{ route('don-hang.danh-sach') }}">
                                <span class="d-inline-block">
                                    <img loading="lazy" src="https://web.nvnstatic.net/tp/T0239/img/orderfile.png?v=9"
                                        alt="orders">
                                </span>
                                <span>Đơn hàng của tôi</span>
                            </a>
                        </li>

                        <li>
                            <a class="d-inline-block" href="{{ route('lich-su-diem') }}">
                                <span class="d-inline-block">
                                    <i class="fas fa-hand-point-right"></i>
                                </span>
                                <span>Lịch sử điểm</span>
                            </a>
                        </li>

                        <li class="signout-action">
                            <form action="/logout" method="POST" style="display: inline;">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                                <button type="submit" class="btn btn-link d-flex align-items-center p-0">
                                    <i class="fa fa-sign-out me-2" aria-hidden="true"></i>
                                    <span>Đăng xuất</span>
                                </button>
                            </form>
                        </li>

                    </ul>
                </div>

                <div class="right-content col-md-8">
                    <p class="font-weight-bold title m-0 text-center text-md-left">
                        <span>Thông tin tài khoản</span>

                        @php
                            $capBac = $nguoiDung->capBac->ten ?? null;
                            $class = match ($capBac) {
                                'Đồng' => 'badge badge-warning',
                                'Bạc' => 'badge badge-info',
                                'Vàng' => 'badge badge-success',
                                default => 'badge badge-secondary',
                            };
                        @endphp

                        <span class="{{ $class }} ml-2" style="font-size: 14px">
                            Cấp bậc: {{ $capBac ?? 'Chưa có' }}
                        </span>
                    </p>


                    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <ul class="d-flex align-items-center flex-wrap pl-0 mb-0">
                            <li class='val'>
                                @php
                                    $hinhAnh = auth()->user()->hinh_anh
                                        ? asset('storage/' . auth()->user()->hinh_anh)
                                        : 'https://bootstrapdemos.wrappixel.com/spike/dist/assets/images/profile/user-1.jpg';
                                @endphp

                                <img width="100px" src="{{ $hinhAnh }}" alt="img_user">
                                <input type="file" name="hinh_anh">
                            </li>
                            <li class='val'>
                                <input name="ten" placeholder="Họ và tên" type="text"
                                    value="{{ old('ten', auth()->user()->ten) }}">
                            </li>
                            <li class='val'>
                                <input name="email" placeholder="Email" type="text"
                                    value="{{ old('email', auth()->user()->email) }}">
                            </li>
                            <li class='val'>
                                <input name="so_dien_thoai" placeholder="Số điện thoại" type="text"
                                    value="{{ old('so_dien_thoai', auth()->user()->so_dien_thoai) }}">
                            </li>
                            <li class='val'>
                                <input name="ngay_sinh" placeholder="Ngày sinh" type="date"
                                    value="{{ old('ngay_sinh', auth()->user()->ngay_sinh ? \Carbon\Carbon::parse(auth()->user()->ngay_sinh)->format('Y-m-d') : '') }}">
                            </li>
                            <li class="text-right">
                                <button type="submit" class="btn btn-insert">Lưu thay đổi</button>
                            </li>
                        </ul>
                    </form>


                    <hr class="my-4">
                    <p class="font-weight-bold title m-0 text-center text-md-left"><span>Cập nhật mật khẩu</span></p>
                    <form action="{{ route('profile.change-password') }}" method="post" class="mt-3">
                        @csrf
                        <div class="form-group">
                            <label for="current_password">Mật khẩu hiện tại</label>
                            <input type="password" class="form-control" id="current_password" name="current_password"
                                required>
                        </div>

                        <div class="form-group">
                            <label for="new_password">Mật khẩu mới</label>
                            <input type="password" class="form-control" id="new_password" name="new_password" required>
                        </div>

                        <div class="form-group">
                            <label for="new_password_confirmation">Xác nhận mật khẩu mới</label>
                            <input type="password" class="form-control" id="new_password_confirmation"
                                name="new_password_confirmation" required>
                        </div>

                        <div class="text-right">
                            <button type="submit" class="btn btn-primary">Cập nhật mật khẩu</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <style>
        @media (min-width: 992px) {
            .container {
                max-width: 992px !important;
            }
        }
    </style>
@endsection
