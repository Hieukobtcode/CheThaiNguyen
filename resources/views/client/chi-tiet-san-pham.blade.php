@extends('layouts.client')

@section('content')
    <div class="container-pre product-page">

        <div class="bread-product">
            <ul class="nav&#x20;justify-content-center&#x20;justify-content-lg-start">
                <li>
                    <a href="{{ route('home') }}">Trang chủ</a>
                </li>
                <li>
                    <a class="571352" href="">Chi tiết sản phẩm</a>
                </li>
            </ul>
        </div>

        <div class="row detail-product">

            <div class="col-lg-6 detail-product__left position-relative">
                <div class="detail-product_big-Slide">
                    <div class="">
                        <div class="">
                            @php
                                $hinhAnh = $sanPham->hinh_anh
                                    ? asset('storage/' . $sanPham->hinh_anh)
                                    : asset('storage/icon/icon_sp.png');
                            @endphp

                            <a href="{{ $hinhAnh }}" data-fancybox="gallery" class="d-block position-relative"
                                data-pos="1">
                                <img loading="lazy" alt="img_sp" width="100%" src="{{ $hinhAnh }}" />
                                <button class="openZoom position-absolute p-0 rounded-circle text-center">
                                    <i class="fas fa-expand-alt"></i>
                                </button>
                            </a>
                        </div>
                    </div>
                </div>

            </div>


            <div class="col-lg-6 detail-product__right">

                <div class="right-content">

                    <div class="product-infomation">
                        <h1 class="font-weight-bold">{{ $sanPham->ten }}</h1>

                        <div class="price-box" itemprop="offers" itemscope itemtype="http://schema.org/Offer">
                            <meta itemprop="availability" content="http://schema.org/InStock">
                            <meta itemprop="priceCurrency" content="VND">
                            <p class="pro-price font-weight-bold d-inline-block mb-0 "><span
                                    class="number">{{ number_format($sanPham->gia, 0, ',', '.') }}
                                </span><span class="curent">₫</span>
                            </p>
                        </div>

                    </div>

                    <div class="status-product py-3">
                        @if ($sanPham->so_luong > 0)
                            <span class="font-weight-bold text-success">Còn hàng: {{ $sanPham->so_luong }}</span>
                        @else
                            <span class="font-weight-bold text-danger">Hết hàng</span>
                        @endif
                    </div>

                    <div class="d-flex align-items-center py-2 mb-3 group-buy" style="gap: 15px; flex-wrap: wrap;">
                        <form action="{{ route('gio-hang.them') }}" method="post">
                            @csrf
                            <div class="product-quantity d-flex rounded overflow-hidden">
                                <input type="hidden" name="san_pham_id" value="{{ $sanPham->id }}">
                                <span
                                    class="number-minus px-3 bg-light text-center font-weight-bold d-flex align-items-center justify-content-center">-</span>
                                <input type="number" id="quantity" class="text-center border-0 px-2" name="so_luong"
                                    value="1" min="1" max="5000" style="width: 60px;" />
                                <span
                                    class="number-plus px-3 bg-light text-center font-weight-bold d-flex align-items-center justify-content-center">+</span>
                            </div>

                            <div class="purchase-product d-flex gap-2 mt-3">
                                <button type="submit" class="btn btn-outline-primary font-weight-bold text-uppercase mr-2">
                                    Thêm vào giỏ hàng
                                </button>
                            </div>
                        </form>

                    </div>


                    <div class="product_meta">
                        <p class="m-0">Danh mục: <span>{{ $sanPham->DanhMuc->ten }}</span></p>
                    </div>
                </div>
            </div>
        </div>

        <div class="product-tabs">
            <div class="tab-item ">
                <a href="javascript:" class="d-flex align-items-center open-tabs">
                    <i class="far fa-chevron-down d-inline-block text-center"></i>
                    <span class="d-inline-block">Thông tin bổ sung</span>
                </a>
                <div class="content-tab">
                    <p>Hàng chính hãng 100%</p>

                    <p>{{ $sanPham->mo_ta }}</p>

                </div>
            </div>
        </div>

        <div class="product-tabs">
            <div class="tab-item">
                <a href="javascript:" class="d-flex align-items-center open-tabs">
                    <i class="far fa-chevron-down d-inline-block text-center"></i>
                    <span class="d-inline-block">Đánh giá sản phẩm</span>
                </a>
                <div class="content-tab">
                    @forelse ($binhLuans as $binhLuan)
                        <div class="border-bottom pb-3 mb-3">
                            <div class="d-flex align-items-start mb-2">
                                <img src="{{ asset('storage/' . ($binhLuan->nguoiDung->anh_dai_dien ?? 'icon/user.png')) }}"
                                    class="rounded-circle me-3" width="50" height="50" alt="avatar">
                                <div>
                                    <strong>{{ $binhLuan->nguoiDung->ten }}</strong>
                                    <p class="mb-1 text-muted small">
                                        {{ $binhLuan->created_at->format('d/m/Y H:i') }}
                                    </p>
                                    <p class="mb-1">
                                        @for ($i = 1; $i <= 5; $i++)
                                            @if ($i <= $binhLuan->danh_gia)
                                                <i class="fas fa-star text-warning"></i>
                                            @else
                                                <i class="far fa-star text-muted"></i>
                                            @endif
                                        @endfor
                                    </p>
                                    <p>{{ $binhLuan->noi_dung }}</p>
                                </div>
                            </div>

                            @if ($binhLuan->phanHoi)
                                <div class="ms-5 ps-3 border-start border-success">
                                    <strong class="text-success">Phản hồi từ quản trị viên:</strong>
                                    <p class="fst-italic text-secondary mt-1 mb-1">{{ $binhLuan->phanHoi->noi_dung }}</p>
                                    <p class="text-muted small mb-0">
                                        <i class="fas fa-clock me-1"></i>
                                        {{ $binhLuan->phanHoi->created_at->format('d/m/Y H:i') }}
                                    </p>
                                </div>
                            @endif
                        </div>
                    @empty
                        <p class="text-muted">Chưa có đánh giá nào cho sản phẩm này.</p>
                    @endforelse
                </div>
            </div>
        </div>


        <div class="product-related">
            <h2 class="font-weight-bold title text-uppercase">Sản phẩm tương tự</h2>
            <div class="content">

                @foreach ($sanPhamLienQuan as $item)
                    <div class="product-item product-item-owl  position-relative">

                        <div class="product-item__image position-relative">
                            <a href="{{ route('san-pham.show', $item->slug) }}" class="d-block image-ab position-absolute">
                                @if ($item->hinh_anh)
                                    <img loading="lazy" class="productHover productHover37960467"
                                        src="{{ asset('storage/' . $item->hinh_anh) }}" alt="img_sp">
                                @else
                                    <img loading="lazy" class="productHover productHover37960467"
                                        src="{{ asset('storage/icon/icon_sp.png') }}" alt="icon_sp">
                                @endif

                            </a>
                            <a href="{{ route('san-pham.show', $item->slug) }}"
                                class="cart-icon position-absolute d-inline-block text-center">
                                +
                            </a>
                        </div>

                        <div class="product-item__infor text-center">
                            <span class="d-block text-uppercase product-item_cate mt-2">{{ $item->DanhMuc->ten }}</span>
                            <a href="{{ route('san-pham.show', $item->slug) }}"
                                class="d-inline-block product-item__name tp_product_name">
                                {{ $item->ten }}</a>
                            <p class="m-0">
                                <span class="d-inline-block price font-weight-bold tp_product_detail_price">
                                    {{ number_format($item->gia, 0, ',', '.') }} ₫
                                </span>
                            </p>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>

    </div>
@endsection
