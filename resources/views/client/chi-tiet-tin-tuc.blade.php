@extends('layouts.client')

@section('content')
    <div class="container-pre newsPage">
        <div class="content-page row justify-content-center"> 
            <div class="left-content col-12 col-lg-9">
                <div class="news-item m-0">
                    <div class="news-item__head text-center">
                        <h4 class="news-item__cate">
                            <a href="" class="text-uppercase font-weight-bold"> Tin tức</a>
                        </h4>
                        <h3 class="news-item__title font-weight-bold beforPre position-relative">
                            {{ $baiViet->tieu_de }}
                        </h3>
                    </div>

                    <div class="news-item__image position-relative text-center"> 
                        <a href="javascript:" class="d-block">
                            @if ($baiViet->hinh_anh)
                                <img loading="lazy" src="{{ asset('storage/' . $baiViet->hinh_anh) }}" alt="img_news">
                            @else
                                <img loading="lazy" src="{{ asset('storage/icon/icon_new.jpg') }}" alt="icon_news">
                            @endif
                        </a>
                    </div>
                </div>

                <div class="detail-news text-center py-3"> 
                    {!! $baiViet->noi_dung !!}
                </div>
            </div>
        </div>
    </div>
@endsection
