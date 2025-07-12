@extends('layouts.client')
@section('content')
    <style>
        .quantity-input input[type="number"] {
            max-width: 70px;
        }
    </style>
    <script defer type="text/javascript" src="https://web.nvnstatic.net/tp/T0239/js/index.js?v=3"></script>
    <div class="banner-main col-pre">
        <div class="banner-main__content">

            @foreach ($banners as $item)
                <div class="item">
                    <a href="javascript:void(0);" class="d-block">
                        <img loading="lazy" src="{{ asset('storage/' . $item->hinh_anh) }}" alt="2">
                    </a>
                </div>
            @endforeach

        </div>
    </div>
    @if (request('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Thành công',
                text: {!! json_encode(request('success')) !!},
                confirmButtonText: 'Đóng'
            });

            if (window.history.replaceState) {
                const url = new URL(window.location);
                url.searchParams.delete('success');
                window.history.replaceState({}, document.title, url.pathname + url.search);
            }
        </script>
    @endif

    <div class="container-pre news_home">

        <section class="tp_product_new">

            <div class="title-home clearfix">
                <h2 class="text-center position-relative m-0">
                    <span class="d-inline-block text-uppercase font-weight-bold position-relative">HÀNG MỚI</span>
                </h2>
            </div>

            <div class="row-pre new-product">
                @foreach ($sanPhams as $item)
                    <div class="col-6 col-sm-4 col-lg-3 product-item">

                        <div class="product-item__image position-relative">
                            <a itemprop="url" href="{{ route('san-pham.show', $item->slug) }}"
                                class="d-block image-ab position-absolute">
                                @if ($item && $item->hinh_anh)
                                    <img loading="lazy" itemprop="image" class="productHover productHover37960630"
                                        src="{{ asset('storage/' . $item->hinh_anh) }}"
                                        alt="{{ $item->ten ?? 'Sản phẩm' }}">
                                @else
                                    <img loading="lazy" itemprop="image" class="productHover productHover37960630"
                                        src="{{ asset('storage/icon/icon_sp.png') }}" alt="Icon">
                                @endif
                            </a>

                            <a href="javascript:void(0)" class="cart-icon position-absolute d-inline-block text-center"
                                data-bs-toggle="modal" data-bs-target="#themGioHangModal" data-id="{{ $item->id }}"
                                data-ten="{{ $item->ten }}" data-gia="{{ $item->gia }}"
                                data-hinh="{{ $item->hinh_anh ? asset('storage/' . $item->hinh_anh) : asset('storage/icon/icon_sp.png') }}">
                                +
                            </a>
                        </div>

                        <div class="product-item__infor text-center">
                            <span class="d-block text-uppercase product-item_cate mt-2">{{ $item->DanhMuc->ten }}</span>
                            <a href="{{ route('san-pham.show', $item->slug) }}"
                                class="d-inline-block product-item__name tp_product_name" itemprop="name">
                                {{ $item->ten }}
                            </a>
                            <p class="m-0" itemprop="offers" itemscope itemtype="https://schema.org/Offer">
                                <link itemprop="availability" href="http://schema.org/InStock">
                                <meta itemprop="priceCurrency" content="VND">
                                <span class="d-inline-block price font-weight-bold tp_product_detail_priceprice-sale">
                                    {{ number_format($item->gia, 0, ',', '.') }}₫
                                </span>
                            </p>
                        </div>

                    </div>
                @endforeach


            </div>

            <div class="text-center pt-4">
                <a href="/san-pham?show=new" class="d-inline-block font-weight-bold see-more">
                    Xem tất cả <i class="fal fa-angle-right"></i>
                </a>
            </div>

        </section>

        <section class="section section2">

            <div class="col-inner">
                <div class="section-title-container">

                    <div class="title-home clearfix">
                        <h2 class="text-center position-relative m-0">
                            <span class="d-inline-block text-uppercase font-weight-bold position-relative">
                                <a href="/news">Tin tức</a>
                            </span>
                        </h2>
                    </div>

                    <div class="large-columns-2">
                        <div class="list_large-columns-2">

                            @if ($news->isEmpty())
                                <div class="col-12 text-center">
                                    <p>Chưa có tin tức nào.</p>
                                </div>
                            @else
                                @foreach ($news as $item)
                                    <div class="list_large_item col-lg-3 col-6 mb-4">
                                        <div class="position-relative">
                                            @if (!empty($item->hinh_anh))
                                                <img style="width: 120px; height:150px" loading="lazy"
                                                    src="{{ asset('storage/' . $item->hinh_anh) }}"
                                                    alt="{{ $item->tieu_de }}" class="img-fluid w-100 rounded">
                                            @else
                                                <img loading="lazy" src="{{ asset('storage/icon/icon_new.jpg') }}"
                                                    alt="{{ $item->tieu_de }}" class="img-fluid w-100 rounded">
                                            @endif


                                        </div>


                                        <a class="news-title d-block mt-2 text-dark fw-bold" href="">
                                            {{ $item->tieu_de }}
                                        </a>
                                    </div>
                                @endforeach
                            @endif

                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center pt-4">
                <a href="{{ route('bai_viet') }}" class="d-inline-block font-weight-bold see-more">
                    Xem tất cả <i class="fal fa-angle-right"></i>
                </a>
            </div>
        </section>

        <div class="homeProductCategory tp_product_category_box" style="display: none;"></div>
    </div>


    <!-- Modal Thêm vào Giỏ Hàng -->
    <div class="modal fade" id="themGioHangModal" tabindex="-1" aria-labelledby="themGioHangModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <form action="{{ route('gio-hang.them') }}" method="POST" class="w-100">
                @csrf
                <div class="modal-content border-0 shadow rounded-4">
                    <div class="modal-header border-0 pb-0">
                        <h5 class="modal-title fw-bold text-uppercase" id="themGioHangModalLabel">Thêm vào giỏ hàng</h5>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="san_pham_id" id="modalSanPhamId">

                        <div class="row align-items-center">
                            <div class="col-md-4 text-center">
                                <img id="modalHinhAnh" src="" alt="Ảnh sản phẩm"
                                    class="img-fluid rounded shadow-sm" style="max-height: 200px;">
                            </div>
                            <div class="col-md-8">
                                <p class="mb-2"><strong>Tên sản phẩm:</strong> <span id="modalTenSanPham"></span></p>
                                <p class="mb-2"><strong>Giá:</strong> <span id="modalGiaSanPham"
                                        class="text-danger fw-bold fs-5"></span>₫</p>

                                <div class="mb-3">
                                    <label for="soLuong" class="form-label fw-bold">Số lượng</label>
                                    <div class="input-group quantity-input w-50">
                                        <button type="button" class="btn btn-outline-secondary btn-sm rounded-start"
                                            id="btnGiam">-</button>
                                        <input type="number" class="form-control text-center" id="soLuong"
                                            name="so_luong" value="1" min="1" required>
                                        <button type="button" class="btn btn-outline-secondary btn-sm rounded-end"
                                            id="btnTang">+</button>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-0 pt-0">
                        <button type="submit" class="btn btn-primary px-4 rounded-pill">Thêm vào giỏ hàng</button>
                        <button type="button" class="btn btn-secondary rounded-pill"
                            data-bs-dismiss="modal">Hủy</button>
                    </div>
                </div>
            </form>
        </div>
    </div>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const themGioHangModal = document.getElementById('themGioHangModal');
            themGioHangModal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                const id = button.getAttribute('data-id');
                const ten = button.getAttribute('data-ten');
                const gia = button.getAttribute('data-gia');
                const hinh = button.getAttribute('data-hinh');

                document.getElementById('modalSanPhamId').value = id;
                document.getElementById('modalTenSanPham').textContent = ten;
                document.getElementById('modalGiaSanPham').textContent = Number(gia).toLocaleString(
                    'vi-VN');
                document.getElementById('modalHinhAnh').src = hinh;
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
            const input = document.getElementById('soLuong');
            const btnTang = document.getElementById('btnTang');
            const btnGiam = document.getElementById('btnGiam');

            btnTang.addEventListener('click', function() {
                input.value = parseInt(input.value) + 1;
            });

            btnGiam.addEventListener('click', function() {
                if (parseInt(input.value) > 1) {
                    input.value = parseInt(input.value) - 1;
                }
            });
        });
    </script>

@endsection
