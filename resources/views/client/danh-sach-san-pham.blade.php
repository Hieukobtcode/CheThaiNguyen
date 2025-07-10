@extends('layouts.client')

@section('content')
    <div class="container-pre product-page tp_product_category">

        <div class="row productPage-content">
            <div class="col-lg-3 left-page">
                <div class="left-page__content">
                    <div class="tp_product_category_filter_category">
                        <h4 class="title-cate text-uppercase font-weight-bold position-relative beforPre">Danh mục
                        </h4>

                        <ul class="cate-list p-0 m-0">
                            <li>
                                <a href="javascript:"
                                    class="d-flex align-items-center justify-content-between font-weight-bold">
                                    Danh mục <i class="fas fa-plus"></i>
                                </a>

                                <ul class="m-0 p-0 px-2" style="display: none">
                                    @foreach ($danhMucs as $item)
                                        <li style="position: relative">
                                            <a href="{{ route('san-pham.loc-theo-danh-muc' ,$item->id) }}" class="d-block">
                                                {{ $item->ten }}
                                            </a>
                                        </li>
                                    @endforeach
                            </li>
                        </ul>
                    </div>

                </div>
                <i class="fal fa-times position-absolute d-lg-none"></i>
            </div>

            <div class="col-lg-9">
                <div class="row-pre">

                    @foreach ($sanPhams as $item)
                        <div class="product-item position-relative col-6 col-sm-4">

                            <div class="product-item__image position-relative">
                                <a href="{{ route('san-pham.show', $item->slug) }}"
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
                                <a href="{{ route('san-pham.show', $item->slug) }}"
                                    class="cart-icon position-absolute d-inline-block text-center">
                                    +
                                </a>
                            </div>

                            <div class="product-item__infor text-center">
                                <span class="d-block text-uppercase product-item_cate mt-2"></span>
                                <a href="/ba-lo-herschel-dawson-light-navy-p37960561.html"
                                    class="d-inline-block product-item__name tp_product_name">
                                    {{ $item->ten }}</a>

                                <p class="m-0">
                                    <span class="d-inline-block price font-weight-bold tp_product_detail_priceprice-sale">
                                        {{ number_format($item->gia, 0, ',', '.') }}₫
                                    </span>
                                </p>

                            </div>
                        </div>
                    @endforeach
                    <div class="mt-4 d-flex justify-content-center">
                        {{ $sanPhams->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
