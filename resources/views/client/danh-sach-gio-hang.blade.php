@extends('layouts.client')

@section('content')
    <div id="cart">
        <div class="container-pre">
            <div class="row">
                <div id="layout-page" class="col-12 py-4">
                    <div class="main-title mt-2 mb-5">
                        <h1 class="text-center">Giỏ hàng</h1>
                    </div>
                    <div id="cartformpage" class="pb30">
                        <table class="cart cart-hidden">
                            <thead>
                                <tr>
                                    <th class="image">Hình ảnh</th>
                                    <th class="item">Tên sản phẩm</th>
                                    <th class="qty">Số lượng</th>
                                    <th class="price">Giá tiền</th>
                                    <th class="remove">Xoá</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse ($chiTietGioHangs as $item)
                                    <tr class="item">
                                        <td class="image">
                                            <div class="product_image">
                                                <a href="#">
                                                    <img width="100px" loading="lazy"
                                                        src="{{ $item->sanPham->hinh_anh ? asset('storage/' . $item->sanPham->hinh_anh) : asset('storage/icon/icon_sp.png') }}"
                                                        alt="{{ $item->sanPham->ten }}" />
                                                </a>
                                            </div>
                                        </td>
                                        <td class="item">
                                            <a href="#">
                                                <strong>{{ $item->sanPham->ten }}</strong>
                                            </a>
                                        </td>
                                        <td class="qty">
                                            <input type="number" min="1" max="5000"
                                                value="{{ $item->so_luong }}" class="item-quantity"
                                                data-id="{{ $item->id }}" />
                                        </td>
                                        <td class="price" id="price-{{ $item->id }}">
                                            {{ number_format($item->sanPham->gia * $item->so_luong) }} ₫
                                        </td>
                                        <td>
                                            <form action="{{ route('gio_hang.xoa', $item->id) }}" method="POST"
                                                onsubmit="return confirm('Xóa sản phẩm này khỏi giỏ hàng?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-link p-0 m-0 text-danger">
                                                    <i class="far fa-times"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">Giỏ hàng trống</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                        @if (!$chiTietGioHangs->isEmpty())
                            <div class="box-totalMoney text-center text-sm-right my-4">
                                <span>Tổng tiền : </span>
                                <span class="font-weight-bold" id="tong-tien">{{ number_format($tongTien) }}₫</span>
                            </div>

                            <div
                                class="cart-buttons buttons d-flex justify-content-between justify-content-sm-end text-center">
                                <button type="button" id="update-cart"
                                    class="button-default font-weight-bold text-uppercase" onclick="location.href = '/'">
                                    <i class="fal fa-long-arrow-left mr-1"></i>Tiếp tục mua sắm
                                </button>
                                <button type="button" id="checkout" class="button-default font-weight-bold text-uppercase"
                                    onclick="location.href = '{{ route('gio_hang.thanh_toan') }}'">
                                    Thanh toán
                                </button>
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.querySelectorAll('.item-quantity').forEach(input => {
            input.addEventListener('change', function() {
                const id = this.dataset.id;
                const soLuong = this.value;

                if (soLuong < 1 || soLuong > 5000) {
                    alert('Số lượng không hợp lệ!');
                    return;
                }

                fetch(`/cart/${id}`, {
                        method: 'PATCH',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            so_luong: soLuong
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === 'success') {
                            document.querySelector(`#price-${id}`).textContent = data.don_gia + ' ₫';

                            document.querySelector('#tong-tien').textContent = data.tong_tien + ' ₫';

                            Swal.fire({
                                icon: 'success',
                                title: 'Thành công',
                                text: 'Đã cập nhật số lượng sản phẩm!',
                                confirmButtonText: 'Đóng'
                            }).then(() => {
                                location.reload();
                            });

                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Thất bại',
                                text: data.message || 'Lỗi khi cập nhật số lượng!',
                                confirmButtonText: 'Đóng'
                            });
                        }

                    })
                    .catch(error => {
                        console.error('Lỗi:', error);
                        alert('Có lỗi xảy ra!');
                    });
            });
        });
    </script>
@endsection
