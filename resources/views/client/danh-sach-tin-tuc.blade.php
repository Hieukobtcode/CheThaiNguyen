@extends('layouts.client')
@section('content')
    <style>
        .news-item__image {
            width: 100%;
            height: 430px;
            overflow: hidden;
            border-radius: 8px;
        }

        .news-item__image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
    </style>

    <div class="container-pre newsPage">
        <div class="content-page row justify-content-center">

            <div class="left-content col-12 col-lg-9 mx-auto">
                @foreach ($baiViets as $item)
                    <div class="news-item  ">
                        <div class="news-item__head text-center">
                            <h4 class="news-item__cate"><a href="" class="text-uppercase font-weight-bold">Tin
                                    tức</a></h4>
                            <h3 class="news-item__title font-weight-bold beforPre position-relative">
                                <a href="{{ route('bai_viet_client.show', $item->id) }}">{{ $item->tieu_de }}
                                </a>
                            </h3>
                        </div>
                        <div class="news-item__image position-relative">
                            <a href="{{ route('bai_viet_client.show', $item->id) }}" class="d-block">
                                @if ($item->hinh_anh)
                                    <img loading="lazy" src="{{ asset('storage/' . $item->hinh_anh) }}"
                                        alt="img_news">
                                @else
                                    <img loading="lazy" src="{{ asset('storage/icon/icon_new.jpg') }}" alt="icon_news">
                                @endif
                            </a>
                        </div>

                        <div class="news-item__infor">
                            <p class="news-item__intro m-0">
                                {{ \Illuminate\Support\Str::limit($item->noi_dung, 300, '...') }}
                            </p>
                            <p class="text-center view-more m-0">
                                <a href="{{ route('bai_viet_client.show', $item->id) }}"
                                    class="d-inline-block font-weight-bold text-uppercase mt-3">Tiếp tục đọc <i
                                        class="fal fa-long-arrow-right"></i>
                                </a>
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
