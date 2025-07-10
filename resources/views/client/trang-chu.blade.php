@extends('layouts.client')
@section('content')
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

                            <a href="#" class="cart-icon position-absolute d-inline-block text-center">
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
                                                <img style="width: 120px; height:150px" loading="lazy" src="{{ asset('storage/' . $item->hinh_anh) }}"
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
@endsection
