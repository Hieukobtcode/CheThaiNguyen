@extends('layouts.admin')

@section('content')
    <div class="container py-4">
        <h2 class="mb-4">Chi tiết đơn hàng #{{ $donHang->ma_van_don ?? 'Không có mã' }}</h2>

        <div class="row">
            {{-- Cột trái: Thông tin người dùng, đơn hàng, địa chỉ --}}
            <div class="col-lg-5">
                {{-- Thông tin người đặt --}}
                <div class="mb-4 p-3 border rounded bg-light">
                    <h5>Người đặt hàng</h5>
                    <p><strong>Họ tên:</strong> {{ $donHang->diaChi->ho_va_ten ?? 'Không có' }}</p>
                    <p><strong>Email:</strong> {{ $donHang->nguoiDung->email ?? 'Không có' }}</p>
                    <p><strong>SĐT:</strong> {{ $donHang->diaChi->so_dien_thoai ?? 'Không có' }}</p>
                </div>

                {{-- Thông tin đơn hàng --}}
                <div class="mb-4 p-3 border rounded bg-light">
                    <h5>Thông tin đơn hàng</h5>
                    <p><strong>Ngày đặt:</strong> {{ $donHang->created_at->format('d/m/Y H:i') }}</p>
                    <p><strong>Trạng thái:</strong> {{ hienThiTrangThaiDonHang($donHang->trang_thai) }}</p>
                    <p><strong>Phương thức thanh toán:</strong> {{ strtoupper($donHang->phuong_thuc_thanh_toan) }}</p>
                    <p><strong>Ghi chú:</strong> {{ $donHang->ghi_chu ?? 'Không có' }}</p>
                </div>

                {{-- Voucher & điểm --}}
                <div class="mb-4 p-3 border rounded bg-light">
                    <h5>Voucher & Điểm</h5>
                    <p><strong>Voucher:</strong>
                        @if ($donHang->voucher)
                            {{ $donHang->voucher->ma }} – Giảm:
                            {{ number_format($donHang->voucher->gia_tri, 0, ',', '.') }}₫
                        @else
                            Không áp dụng
                        @endif
                    </p>
                    @php
                        $lichSu = \App\Models\LichSuDiem::where('nguoi_dung_id', $donHang->nguoi_dung_id)
                            ->where('loai', 'Sử dụng điểm')
                            ->where('mo_ta', 'like', '%#' . $donHang->ma_van_don . '%')
                            ->first();
                    @endphp
                    <p><strong>Điểm sử dụng:</strong>
                        @if ($lichSu)
                            {{ $lichSu->diem }} điểm ({{ number_format($lichSu->diem, 0, ',', '.') }}₫)
                        @else
                            0 điểm
                        @endif
                    </p>
                    <p><strong>Tổng tiền:</strong> <span
                            class="text-danger fw-bold">{{ number_format($donHang->tong_tien, 0, ',', '.') }}₫</span></p>
                </div>

                {{-- Địa chỉ nhận hàng --}}
                <div class="mb-4 p-3 border rounded bg-light">
                    <h5>Địa chỉ nhận hàng</h5>
                    <p>{{ $donHang->diaChi->ho_ten }} – {{ $donHang->diaChi->so_dien_thoai }}</p>
                    <p>{{ $donHang->diaChi->dia_chi }}, {{ $donHang->diaChi->phuong_xa }},
                        {{ $donHang->diaChi->quan_huyen }}, {{ $donHang->diaChi->tinh_thanh }}</p>
                </div>
            </div>

            {{-- Cột phải: Danh sách sản phẩm --}}
            <div class="col-lg-7">
                <div class="mb-4">
                    <div class="row">
                        @foreach ($donHang->chiTietDonHangs as $chiTiet)
                            <div class="col-md-12 mb-3">
                                <div class="card h-100">
                                    <div class="row g-0 align-items-center">
                                        <div class="col-3">
                                            <img src="{{ $chiTiet->sanPham->hinh_anh ? asset('storage/' . $chiTiet->sanPham->hinh_anh) : asset('storage/icon/icon_sp.png') }}"
                                                class="img-fluid rounded-start" alt="{{ $chiTiet->sanPham->ten }}">
                                        </div>
                                        <div class="col-9">
                                            <div class="card-body p-2">
                                                <h6 class="card-title mb-1">{{ $chiTiet->sanPham->ten }}</h6>
                                                <p class="mb-1">Đơn giá:
                                                    {{ number_format($chiTiet->don_gia, 0, ',', '.') }}₫</p>
                                                <p class="mb-1">Số lượng: {{ $chiTiet->so_luong }}</p>
                                                <p class="mb-0">Thành tiền:
                                                    <strong>{{ number_format($chiTiet->don_gia * $chiTiet->so_luong, 0, ',', '.') }}₫</strong>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <a href="{{ route('don_hang.index') }}" class="btn btn-secondary mt-3">← Quay lại danh sách</a>
    </div>
@endsection
