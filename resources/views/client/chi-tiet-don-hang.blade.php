@extends('layouts.client')

@section('content')
    <style>
        .rating-stars .star {
            cursor: pointer;
            transition: color 0.2s;
        }

        .rating-stars .star:hover,
        .rating-stars .star.hovered,
        .rating-stars .star.selected {
            color: #ffc107 !important;
        }
    </style>
    <div class="container my-5">
        <h2 class="text-center mb-4">Chi tiết đơn hàng</h2>

        <div class="row">
            {{-- Cột trái: Thông tin đơn hàng --}}
            <div class="col-md-5">
                <div class="card mb-4 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Thông tin đơn hàng</h5>
                        <p><strong>Mã đơn:</strong> {{ $donHang->ma_van_don ?? 'Không có' }}</p>
                        <p><strong>Ngày đặt:</strong> {{ $donHang->created_at->format('d/m/Y H:i') }}</p>
                        <p><strong>Trạng thái:</strong> {{ hienThiTrangThaiDonHang($donHang->trang_thai) }}</p>
                        <p><strong>Phí vận chuyển:</strong> 30.000 VND</p>
                        <p><strong>Tổng tiền:</strong> {{ number_format($donHang->tong_tien, 0, ',', '.') }} VND</p>

                        @if ($donHang->voucher)
                            <p><strong>Giảm từ voucher:</strong>
                                {{ number_format($donHang->voucher->gia_tri, 0, ',', '.') }} VND</p>
                        @else
                            <p><strong>Voucher:</strong> Không áp dụng</p>
                        @endif

                        @if ($diemDaSuDung > 0)
                            <p><strong>Điểm đã sử dụng:</strong> {{ $diemDaSuDung }} điểm
                                ({{ number_format($diemDaSuDung * 1, 0, ',', '.') }} VND)</p>
                        @endif

                        <hr>
                        <p><strong>Thành tiền sau giảm:</strong> <span
                                class="text-danger">{{ number_format($donHang->tong_tien, 0, ',', '.') }} VND</span></p>
                    </div>
                </div>

                <a href="{{ route('don-hang.danh-sach') }}" class="btn btn-secondary w-100">← Quay lại danh sách</a>
            </div>

            {{-- Cột phải: Danh sách sản phẩm --}}
            <div class="col-md-7">
                <div class="row">
                    @foreach ($donHang->chiTietDonHangs as $chiTiet)
                        @php
                            $binhLuanDaDanhGia = \App\Models\BinhLuan::with('phanHoi')
                                ->where('nguoi_dung_id', auth()->id())
                                ->where('san_pham_id', $chiTiet->san_pham_id)
                                ->first();

                        @endphp
                        <div class="col-md-6 mb-4">
                            <div class="card h-100 shadow-sm">
                                <img src="{{ $chiTiet->sanPham->hinh_anh ? asset('storage/' . $chiTiet->sanPham->hinh_anh) : asset('storage/icon/icon_sp.png') }}"
                                    class="card-img-top img-fluid" alt="{{ $chiTiet->sanPham->ten }}"
                                    style="object-fit: contain; height: 180px; width: 100%; background-color: #f9f9f9; padding: 10px;" />

                                <div class="card-body">
                                    <h6 class="card-title">{{ $chiTiet->sanPham->ten ?? 'Không tìm thấy' }}</h6>
                                    <p class="card-text mb-1">Đơn giá: {{ number_format($chiTiet->don_gia, 0, ',', '.') }}
                                        VND</p>
                                    <p class="card-text mb-1">Số lượng: {{ $chiTiet->so_luong }}</p>
                                    <p class="card-text fw-bold text-primary">
                                        Thành tiền:
                                        {{ number_format($chiTiet->don_gia * $chiTiet->so_luong, 0, ',', '.') }} VND
                                    </p>

                                    @php
                                        $daDanhGia = \App\Models\BinhLuan::where('nguoi_dung_id', auth()->id())
                                            ->where('san_pham_id', $chiTiet->san_pham_id)
                                            ->exists();
                                    @endphp

                                    @if ($donHang->trang_thai === 'da_hoan_thanh')
                                        @if ($binhLuanDaDanhGia)
                                            <button class="btn btn-warning" data-bs-toggle="modal"
                                                data-bs-target="#modalXemDanhGia{{ $chiTiet->id }}">
                                                Đã đánh giá
                                            </button>
                                        @else
                                            <button class="btn btn-primary" data-bs-toggle="modal"
                                                data-bs-target="#modalDanhGia{{ $chiTiet->id }}">
                                                Đánh giá sản phẩm
                                            </button>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Modal đánh giá -->
                        <div class="modal fade" id="modalDanhGia{{ $chiTiet->id }}" tabindex="-1"
                            aria-labelledby="danhGiaLabel{{ $chiTiet->id }}" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content border-0 shadow-lg rounded-4">
                                    <form action="{{ route('binh-luan.luu') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="san_pham_id" value="{{ $chiTiet->san_pham_id }}">
                                        <div class="modal-header bg-primary text-white rounded-top-4">
                                            <h5 class="modal-title" id="danhGiaLabel{{ $chiTiet->id }}">
                                                <i class="fas fa-pen"></i> Đánh giá sản phẩm: {{ $chiTiet->sanPham->ten }}
                                            </h5>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3 text-center">
                                                <label class="form-label fw-bold">Đánh giá của bạn:</label>
                                                <div class="rating-stars fs-3">
                                                    @for ($i = 1; $i <= 5; $i++)
                                                        <i class="fas fa-star star text-secondary"
                                                            data-value="{{ $i }}"></i>
                                                    @endfor
                                                </div>
                                                <input type="hidden" name="danh_gia" id="danhGiaInput{{ $chiTiet->id }}"
                                                    required>
                                            </div>

                                            <div class="mb-3">
                                                <label for="noi_dung" class="form-label fw-bold">Nội dung đánh giá:</label>
                                                <textarea name="noi_dung" class="form-control" rows="3" placeholder="Nhập nội dung đánh giá..." required></textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer justify-content-between px-4 pb-4">
                                            <button type="submit" class="btn btn-success px-4">
                                                <i class="fas fa-paper-plane"></i> Gửi
                                            </button>
                                            <button type="button" class="btn btn-outline-secondary"
                                                data-bs-dismiss="modal">Hủy</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        @if ($binhLuanDaDanhGia)
                            <!-- Modal xem đánh giá -->
                            <div class="modal fade" id="modalXemDanhGia{{ $chiTiet->id }}" tabindex="-1"
                                aria-labelledby="xemDanhGiaLabel{{ $chiTiet->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
                                        <div class="modal-header bg-warning text-dark py-3">
                                            <h5 class="modal-title d-flex align-items-center m-0"
                                                id="xemDanhGiaLabel{{ $chiTiet->id }}">
                                                <i class="fas fa-star me-2 text-white bg-dark p-2 rounded-circle"></i>
                                                Đánh giá đã gửi
                                            </h5>
                                        </div>

                                        <div class="modal-body px-4 py-3">
                                            <div class="mb-3">
                                                <p class="mb-1">
                                                    <strong>Sản phẩm:</strong>
                                                    {{ $chiTiet->sanPham->ten ?? '[Đã xóa]' }}
                                                </p>
                                                <p class="mb-1">
                                                    <strong>Ngày đánh giá:</strong>
                                                    {{ \Carbon\Carbon::parse($binhLuanDaDanhGia->created_at)->format('d/m/Y H:i') }}
                                                </p>
                                            </div>

                                            <div class="mb-3">
                                                <strong>Số sao:</strong>
                                                <div class="fs-4 mt-2">
                                                    @for ($i = 1; $i <= 5; $i++)
                                                        @if ($i <= $binhLuanDaDanhGia->danh_gia)
                                                            <i class="fas fa-star text-warning"></i>
                                                        @else
                                                            <i class="far fa-star text-muted"></i>
                                                        @endif
                                                    @endfor
                                                </div>
                                            </div>

                                            <div class="mb-3">
                                                <strong>Nội dung đánh giá:</strong>
                                                <blockquote
                                                    class="border-start border-4 border-warning ps-3 mt-2 fst-italic text-secondary">
                                                    <i class="fas fa-quote-left me-2 text-warning"></i>
                                                    {{ $binhLuanDaDanhGia->noi_dung }}
                                                </blockquote>
                                            </div>

                                            @if ($binhLuanDaDanhGia->phanHoi)
                                                <hr>
                                                <div class="mb-2">
                                                    <strong class="text-success">Phản hồi từ quản trị viên:</strong>
                                                    <blockquote
                                                        class="border-start border-4 border-success ps-3 mt-2 fst-italic text-secondary">
                                                        <i class="fas fa-reply me-2 text-success"></i>
                                                        {{ $binhLuanDaDanhGia->phanHoi->noi_dung }}
                                                    </blockquote>
                                                    <p class="text-muted small text-end mb-0">
                                                        <i class="fas fa-clock me-1"></i>
                                                        {{ \Carbon\Carbon::parse($binhLuanDaDanhGia->phanHoi->created_at)->format('d/m/Y H:i') }}
                                                    </p>
                                                </div>
                                            @endif
                                        </div>

                                        <div class="modal-footer justify-content-end px-4 pb-4">
                                            <button type="button" class="btn btn-outline-secondary"
                                                data-bs-dismiss="modal">
                                                <i class="fas fa-times me-1"></i> Đóng
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>


    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.modal').forEach(function(modal) {
                const stars = modal.querySelectorAll('.star');
                const input = modal.querySelector('input[name="danh_gia"]');

                stars.forEach((star, index) => {
                    star.addEventListener('mouseenter', () => {
                        stars.forEach((s, i) => {
                            s.classList.toggle('hovered', i <= index);
                        });
                    });

                    star.addEventListener('mouseleave', () => {
                        stars.forEach((s) => s.classList.remove('hovered'));
                    });

                    star.addEventListener('click', () => {
                        const value = star.dataset.value;
                        input.value = value;

                        stars.forEach((s, i) => {
                            s.classList.remove('selected');
                            if (i < value) s.classList.add('selected');
                        });
                    });
                });
            });
        });
    </script>
@endsection
