@extends('layouts.client')

@section('content')
    <style>
        table td,
        table th {
            vertical-align: middle !important;
            padding: 12px 16px !important;
        }

        .nav-pills .nav-link.active {
            background-color: #007bff !important;
        }
    </style>

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

                {{-- Nội dung bên phải --}}
                <div class="right-content col-md-8">
                    <div class="container my-4">

                        {{-- Tabs trạng thái --}}
                        <ul class="nav nav-pills mb-4" role="tablist">
                            @foreach ($trangThais as $key => $label)
                                <li class="nav-item me-2">
                                    <a class="nav-link {{ $activeTab === $key ? 'active' : '' }}"
                                        href="{{ route('don-hang.danh-sach', ['tab' => $key]) }}">
                                        {{ $label }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>

                        {{-- Bảng đơn hàng --}}
                        @if ($donHangs->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped align-middle text-center">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>#</th>
                                            <th>Mã đơn</th>
                                            <th>Ngày tạo</th>
                                            <th>Tổng tiền</th>
                                            <th>Trạng thái</th>
                                            <th>Thanh toán</th>
                                            <th>Hành động</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($donHangs as $index => $donHang)
                                            <tr>
                                                <td>{{ ($donHangs->currentPage() - 1) * $donHangs->perPage() + $index + 1 }}
                                                </td>
                                                <td>{{ $donHang->ma_van_don ?? 'Không có' }}</td>
                                                <td>{{ $donHang->created_at->format('d/m/Y H:i:s') }}</td>
                                                <td>{{ number_format($donHang->tong_tien, 0, ',', '.') }} VND</td>
                                                <td>{{ hienThiTrangThaiDonHang($donHang->trang_thai) }}</td>
                                                <td>{{ hienThiTrangThaiThanhToan($donHang->trang_thai_thanh_toan) }}</td>
                                                <td>
                                                    <div class="d-flex justify-content-center gap-2 flex-wrap">
                                                        <a href="{{ route('don-hang.chi-tiet', $donHang->id) }}"
                                                            class="btn btn-sm btn-primary">Xem chi tiết</a>

                                                        @if ($donHang->trang_thai === 'cho_xac_nhan')
                                                            <form action="{{ route('don-hang.huy', $donHang->id) }}"
                                                                method="POST"
                                                                onsubmit="return confirm('Bạn có chắc muốn hủy đơn hàng này không?');">
                                                                @csrf
                                                                @method('PUT')
                                                                <button type="submit" class="btn btn-sm btn-danger">Hủy
                                                                    đơn</button>
                                                            </form>
                                                        @endif

                                                        @if ($donHang->trang_thai === 'da_giao')
                                                            <form
                                                                action="{{ route('don-hang.xac-nhan-da-giao', $donHang->id) }}"
                                                                method="POST"
                                                                onsubmit="return confirm('Xác nhận đã nhận hàng?');">
                                                                @csrf
                                                                @method('PUT')
                                                                <button type="submit" class="btn btn-sm btn-danger">Xác
                                                                    nhận đã giao</button>
                                                            </form>
                                                        @endif

                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            {{-- Phân trang --}}
                            <div class="d-flex justify-content-center mt-4">
                                {{ $donHangs->links() }}
                            </div>
                        @else
                            <p class="text-center mt-5">Không có đơn hàng nào thuộc trạng thái này.</p>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
