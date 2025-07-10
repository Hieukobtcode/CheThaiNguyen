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

                        <li class="singout-action">
                            <a class="d-inline-block" href="/user/signout">
                                <span class="d-inline-block"><i class="fa fa-sign-out" aria-hidden="true"></i></span>
                                <span>Đăng xuất</span>
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="right-content col-md-8">
                    <div class="mb-4">
                        <h5 class="text-primary">
                            Điểm hiện có: <strong class="text-danger">{{ number_format($tongDiemHienTai) }}</strong> điểm
                        </h5>
                        <h6 class="text-muted">
                            Tương đương: {{ number_format($tongDiemHienTai) }} VND
                        </h6>
                    </div>

                    <div class="container my-4">
                        @if ($list->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>#</th>
                                            <th>Thời gian</th>
                                            <th>Loại</th>
                                            <th>Điểm</th>
                                            <th>Mô tả</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($list as $index => $item)
                                            <tr>
                                                <td>{{ ($list->currentPage() - 1) * $list->perPage() + $index + 1 }}</td>
                                                <td>{{ $item->created_at->format('d/m/Y H:i:s') }}</td>
                                                <td>{{ $item->loai }}</td>
                                                <td
                                                    class="{{ $item->loai === 'Tích điểm' ? 'text-success' : 'text-danger' }}">
                                                    {{ $item->loai === 'Tích điểm' ? '+' : '-' }}{{ number_format($item->diem) }}
                                                </td>
                                                <td>{{ $item->mo_ta }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="d-flex justify-content-center mt-4">
                                {{ $list->links() }}
                            </div>
                        @else
                            <p class="text-center mt-5">Bạn chưa có lịch sử điểm nào.</p>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection
