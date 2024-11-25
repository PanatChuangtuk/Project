@extends('main')
@section('title')
    @lang('messages.index')
@endsection
@section('stylesheet')
    <style>
        .border-left {
            border-left: 2px solid #375B51;

            padding-left: 15px;
        }

        .ul-collapse {
            list-style: none;
            padding: 0;
        }

        .ul-collapse li {
            margin-bottom: 10px;
        }

        .ul-collapse a {
            color: #375B51;
            text-decoration: none;
            -webkit-transition: color 0.15s ease-in-out;
            transition: color 0.15s ease-in-out;
            display: inline-block;
        }
    </style>
@endsection
@section('content')
    <div class="section p-0">
        <div class="container">
            <div class="banner">
                <div class="swiper-container swiper-banner">
                    <div class="swiper-wrapper">
                        @foreach ($banner as $item)
                            <div class="swiper-slide">
                                <a href="{{ $item->url }}" target="_blank">
                                    <img class="w-100" src="{{ asset('upload/file/banner/' . basename($item->image)) }}"
                                        alt="">
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div><!--swiper-container-->
                <div class="swiper-pagination-group">
                    <div class="swiper-pagination banner"></div>
                </div>
            </div>

        </div><!--container-->
    </div><!--section-->
    <div class="section p-0">
        <div class="container">
            <div class="category-block" data-aos="fade-in">
                <div class="cols left hgroup">
                    <h2 class="h1">@lang('messages.category')</h2>
                    <p>@lang('messages.products')</p>
                </div>

                <div class="cols right">
                    <div class="row nav">

                        @foreach ($product_type as $item)
                            <div class="col-4">
                                <div class="card-category" data-bs-toggle="tab"
                                    data-bs-target="#tab-category-{{ $loop->index }}">
                                    <div class="card-photo">
                                        <div class="photo"
                                            style="background-image: url('{{ asset('img/thumb/photo-800x650--3.jpg') }}');">
                                            <img src="{{ asset('img/thumb/frame-100x60.png') }}" alt="">
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <h3>{{ $item->name }}</h3>
                                        <p class="d-flex"><a class="viewmore">@lang('messages.view_more')</a></p>
                                    </div>
                                </div><!--card-category-->
                            </div>
                        @endforeach
                    </div><!--row-->
                </div>
            </div><!--category-block-->

            <div class="tab-content tab-category-content" data-aos="fade-in">
                @foreach ($product_type as $index => $item)
                    <div id="tab-category-{{ $loop->index }}" class="tab-pane">
                        <div class="hgroup">
                            <h2 class="title-line text-uppercase">
                                <span>{{ $item->name }}</span>
                            </h2>
                        </div>

                        <div class="row logo-brand-lists">
                            @foreach ($product_brand as $model)
                                @if ($index === 0)
                                    <div class="col-2">
                                        <a
                                            href="{{ url(app()->getLocale() . '/product-list/?type=brand&id=' . $model->id) }}">
                                            <img class="logo-brand" src="{{ asset('img/thumb/photo-300x156--1.jpg') }}"
                                                alt="">
                                        </a>
                                    </div>
                                @endif
                            @endforeach

                            @foreach ($product_category as $category)
                                @if ($category->product_type_id === $item->id)
                                    <div class="col-md-4 border-left">
                                        <ul class="ul-collapse">
                                            <li>
                                                <a
                                                    href="{{ url(app()->getLocale() . '/product-list/?type=category&id=' . $category->id) }}">
                                                    {{ $category->name }}
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div><!-- tab-pane -->
                @endforeach
            </div>




        </div><!--container-->
    </div><!--section-->

    <div class="section pt-0 bg-light">
        <div class="container">
            <div class="section-header">
                <div class="text-center mx-auto">
                    <h2 class="h1 textrow"><span data-aos="fade-up">@lang('messages.recommend')</span></h2>
                    <p data-aos="fade-in">@lang('messages.products')</p>
                </div>
            </div>
            <div class="swiper-overflow" data-aos="fade-in">
                <div class="swiper-container swiper-highlight product">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <div class="product-lists">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="card-product thumb">
                                            <a class="card-link" href="product-details.html"></a>
                                            <div class="card-photo">
                                                <div class="photo"
                                                    style="background-image:  url('{{ asset('img/thumb/photo-600x600--3.jpg') }}');">
                                                    <img src="{{ asset('img/thumb/frame-100x100.png') }}" alt="">
                                                </div>

                                                <span class="status new">@lang('messages.news')</span>
                                            </div>
                                            <div class="card-body">
                                                <h3>Bottle media wide mount GL80 5000ml ...</h3>
                                                <p class="code">รหัสสินค้า : DAE-1217-2304</p>

                                                <div class="price-block">
                                                    <p class="price">฿7,290.00</p>
                                                    <p class="price-old">฿10,760.00</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="card-product thumb">
                                            <a class="card-link" href="product-details.html"></a>
                                            <div class="card-photo">
                                                <div class="photo"
                                                    style="background-image:  url('{{ asset('img/thumb/photo-600x600--2.jpg') }}');">
                                                    <img src="{{ asset('img/thumb/frame-100x100.png') }}" alt="">
                                                </div>

                                                <span class="status promotion">@lang('messages.promotion')</span>
                                            </div>
                                            <div class="card-body">
                                                <h3>Nickel(II) carbonate
                                                    4H2O CP</h3>
                                                <p class="code">รหัสสินค้า : DAE-1217-2304</p>

                                                <div class="price-block">
                                                    <p class="price">฿7,290.00</p>
                                                    <p class="price-old">฿10,760.00</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="card-product thumb">
                                            <a class="card-link" href="product-details.html"></a>
                                            <div class="card-photo">
                                                <div class="photo"
                                                    style="background-image:  url('{{ asset('img/thumb/photo-600x600--1.jpg') }}');">
                                                    <img src="{{ asset('img/thumb/frame-100x100.png') }}" alt="">
                                                </div>

                                                <span class="status new">@lang('messages.news')</span>
                                            </div>
                                            <div class="card-body">
                                                <h3>Acetonitrile Gradient Grade</h3>
                                                <p class="code">รหัสสินค้า : DAE-1217-2304</p>

                                                <div class="price-block">
                                                    <p class="price">฿7,290.00</p>
                                                    <p class="price-old">฿10,760.00</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="card-product thumb">
                                            <a class="card-link" href="product-details.html"></a>
                                            <div class="card-photo">
                                                <div class="photo"
                                                    style="background-image: url('{{ asset('img/thumb/photo-600x600--4.jpg') }}');">
                                                    <img src="{{ asset('img/thumb/frame-100x100.png') }}" alt="">
                                                </div>

                                                <span class="status new">@lang('messages.news')</span>
                                            </div>
                                            <div class="card-body">
                                                <h3>Flask Volumetric, amber,
                                                    PE stopper, 5ml, Class...</h3>
                                                <p class="code">รหัสสินค้า : DAE-1217-2304</p>

                                                <div class="price-block">
                                                    <p class="price">฿7,290.00</p>
                                                    <p class="price-old">฿10,760.00</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div><!--row-->
                            </div><!--product-lists-->

                        </div><!--swiper-slide-->

                        <div class="swiper-slide">
                            <div class="product-lists">
                                <div class="row ">
                                    <div class="col-md-3">
                                        <div class="card-product thumb">
                                            <a class="card-link" href="product-details.html"></a>
                                            <div class="card-photo">
                                                <div class="photo"
                                                    style="background-image: url('{{ asset('img/thumb/photo-600x600--3.jpg') }}');">
                                                    <img src="{{ asset('img/thumb/frame-100x100.png') }}" alt="">
                                                </div>

                                                <span class="status new">@lang('messages.news')</span>
                                            </div>
                                            <div class="card-body">
                                                <h3>Bottle media wide mount GL80 5000ml ...</h3>
                                                <p class="code">รหัสสินค้า : DAE-1217-2304</p>

                                                <div class="price-block">
                                                    <p class="price">฿7,290.00</p>
                                                    <p class="price-old">฿10,760.00</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="card-product thumb">
                                            <a class="card-link" href="product-details.html"></a>
                                            <div class="card-photo">
                                                <div class="photo"
                                                    style="background-image: url('{{ asset('img/thumb/photo-600x600--2.jpg') }}');">
                                                    <img src="{{ asset('img/thumb/frame-100x100.png') }}" alt="">
                                                </div>

                                                <span class="status promotion">@lang('messages.promotion')</span>
                                            </div>
                                            <div class="card-body">
                                                <h3>Nickel(II) carbonate
                                                    4H2O CP</h3>
                                                <p class="code">รหัสสินค้า : DAE-1217-2304</p>

                                                <div class="price-block">
                                                    <p class="price">฿7,290.00</p>
                                                    <p class="price-old">฿10,760.00</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div><!--row-->
                            </div><!--product-lists-->

                        </div><!--swiper-slide-->
                    </div><!--swiper-wrapper-->
                </div><!--swiper-container-->

                <div class="swiper-pagination-group">
                    <div class="swiper-pagination d-flex d-xl-none"></div>
                </div>

                <div class="swiper-button swiper-button-prev"><span class="icons"></span></div>
                <div class="swiper-button swiper-button-next"><span class="icons"></span></div>
            </div>
        </div><!--container-->
    </div><!--section-->

    <div class="section pt-0">
        <div class="container">
            <div class="section-header">
                <div class="text-center mx-auto">
                    <h2 class="h1 textrow"><span data-aos="fade-up">@lang('messages.vouchers')</span></h2>
                    <p data-aos="fade-in">@lang('messages.discount')</p>
                </div>
            </div>

            <div class="swiper-overflow" data-aos="fade-in">
                <div class="swiper-container swiper-highlight voucher">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <div class="voucher-lists">
                                <div class="row ">
                                    <div class="col-sm-4">
                                        <div class="card-voucher">
                                            <div class="card-photo">
                                                <img class="icons" src="{{ asset('img/icons/icon-free-shipping.png') }}"
                                                    alt="">
                                            </div>
                                            <div class="card-body">
                                                <div class="my-sm-auto">
                                                    <h3>ส่งฟรี</h3>
                                                    <p>ขั้นต่ำ ฿0 ลดสูงสุด ฿50</p>
                                                </div>

                                                <div class="rows">
                                                    <label class="btn btn-32 btn-orange w-110">Claim</label>

                                                    <a href="#voucherConditionModal" data-bs-toggle="modal">เงื่อนไข</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="card-voucher discount">
                                            <div class="card-photo">
                                                <img class="icons" src="{{ asset('img/icons/icon-discount.png') }}"
                                                    alt="">
                                            </div>
                                            <div class="card-body">
                                                <div class="my-auto">
                                                    <h3>Discount 10% </h3>
                                                    <p>ขั้นต่ำ ฿0 ลดสูงสุด ฿50</p>
                                                </div>

                                                <div class="rows">
                                                    <label class="btn btn-32 btn-orange w-110">Claim</label>

                                                    <a href="#voucherConditionModal" data-bs-toggle="modal">เงื่อนไข</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="card-voucher discount">
                                            <div class="card-photo">
                                                <img class="icons" src="{{ asset('img/icons/icon-discount.png') }}"
                                                    alt="">
                                            </div>
                                            <div class="card-body">
                                                <div class="my-auto">
                                                    <h3>Discount 10% </h3>
                                                    <p>ขั้นต่ำ ฿0 ลดสูงสุด ฿50</p>
                                                </div>

                                                <div class="rows">
                                                    <label class="btn btn-32 btn-orange w-110">Claim</label>

                                                    <a href="#voucherConditionModal" data-bs-toggle="modal">เงื่อนไข</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div><!--row-->
                            </div><!--product-lists-->

                        </div><!--swiper-slide-->

                        <div class="swiper-slide">
                            <p>text....</p>
                        </div><!--swiper-slide-->
                    </div><!--swiper-wrapper-->
                </div><!--swiper-container-->

                <div class="swiper-pagination-group">
                    <div class="swiper-pagination d-flex d-xl-none"></div>
                </div>
                <div class="swiper-button swiper-button-prev"><span class="icons"></span></div>
                <div class="swiper-button swiper-button-next"><span class="icons"></span></div>
            </div>
        </div><!--container-->
    </div><!--section-->

    <div class="section pt-0 bg-light">
        <div class="container">
            <div class="section-header">
                <div class="text-center mx-auto">
                    <h2 class="h1 textrow"><span data-aos="fade-up">@lang('messages.best_seller')</span></h2>
                </div>
            </div>
            <div class="swiper-overflow" data-aos="fade-in">
                <div class="swiper-container swiper-highlight product">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <div class="product-lists">
                                <div class="row ">
                                    <div class="col-md-3">
                                        <div class="card-product thumb">
                                            <a class="card-link" href="product-details.html"></a>
                                            <div class="card-photo">
                                                <div class="photo"
                                                    style="background-image: url('{{ asset('img/thumb/photo-600x600--3.jpg') }}');">
                                                    <img src="{{ asset('img/thumb/frame-100x100.png') }}" alt="">
                                                </div>

                                                <span class="status best-seller">TOP 1</span>
                                            </div>
                                            <div class="card-body">
                                                <h3>Bottle media wide mount GL80 5000ml ...</h3>
                                                <p class="code">รหัสสินค้า : DAE-1217-2304</p>

                                                <div class="price-block">
                                                    <p class="price">฿7,290.00</p>
                                                    <p class="price-old">฿10,760.00</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="card-product thumb">
                                            <a class="card-link" href="product-details.html"></a>
                                            <div class="card-photo">
                                                <div class="photo"
                                                    style="background-image: url('{{ asset('img/thumb/photo-600x600--2.jpg') }}');">
                                                    <img src="{{ asset('img/thumb/frame-100x100.png') }}" alt="">
                                                </div>

                                                <span class="status best-seller">TOP 2</span>
                                            </div>
                                            <div class="card-body">
                                                <h3>Nickel(II) carbonate
                                                    4H2O CP</h3>
                                                <p class="code">รหัสสินค้า : DAE-1217-2304</p>

                                                <div class="price-block">
                                                    <p class="price">฿7,290.00</p>
                                                    <p class="price-old">฿10,760.00</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="card-product thumb">
                                            <a class="card-link" href="product-details.html"></a>
                                            <div class="card-photo">
                                                <div class="photo"
                                                    style="background-image: url('{{ asset('img/thumb/photo-600x600--1.jpg') }}');">
                                                    <img src="{{ asset('img/thumb/frame-100x100.png') }}" alt="">
                                                </div>

                                                <span class="status best-seller">TOP 3</span>
                                            </div>
                                            <div class="card-body">
                                                <h3>Acetonitrile Gradient Grade</h3>
                                                <p class="code">รหัสสินค้า : DAE-1217-2304</p>

                                                <div class="price-block">
                                                    <p class="price">฿7,290.00</p>
                                                    <p class="price-old">฿10,760.00</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="card-product thumb">
                                            <a class="card-link" href="product-details.html"></a>
                                            <div class="card-photo">
                                                <div class="photo"
                                                    style="background-image: url('{{ asset('img/thumb/photo-600x600--4.jpg') }}');">
                                                    <img src="{{ asset('img/thumb/frame-100x100.png') }}" alt="">
                                                </div>

                                                <span class="status best-seller">TOP 4</span>
                                            </div>
                                            <div class="card-body">
                                                <h3>Flask Volumetric, amber,
                                                    PE stopper, 5ml, Class...</h3>
                                                <p class="code">รหัสสินค้า : DAE-1217-2304</p>

                                                <div class="price-block">
                                                    <p class="price">฿7,290.00</p>
                                                    <p class="price-old">฿10,760.00</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div><!--row-->
                            </div><!--product-lists-->

                        </div><!--swiper-slide-->

                        <div class="swiper-slide">
                            <div class="product-lists">
                                <div class="row ">
                                    <div class="col-md-3">
                                        <div class="card-product thumb">
                                            <a class="card-link" href="product-details.html"></a>
                                            <div class="card-photo">
                                                <div class="photo"
                                                    style="background-image: url('{{ asset('img/thumb/photo-600x600--3.jpg') }}');">
                                                    <img src="{{ asset('img/thumb/frame-100x100.png') }}" alt="">
                                                </div>

                                                <span class="status best-seller">TOP 5</span>
                                            </div>
                                            <div class="card-body">
                                                <h3>Bottle media wide mount GL80 5000ml ...</h3>
                                                <p class="code">รหัสสินค้า : DAE-1217-2304</p>

                                                <div class="price-block">
                                                    <p class="price">฿7,290.00</p>
                                                    <p class="price-old">฿10,760.00</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="card-product thumb">
                                            <a class="card-link" href="product-details.html"></a>
                                            <div class="card-photo">
                                                <div class="photo"
                                                    style="background-image: url('{{ asset('img/thumb/photo-600x600--2.jpg') }}');">
                                                    <img src="{{ asset('img/thumb/frame-100x100.png') }}" alt="">
                                                </div>

                                                <span class="status best-seller">TOP 6</span>
                                            </div>
                                            <div class="card-body">
                                                <h3>Nickel(II) carbonate
                                                    4H2O CP</h3>
                                                <p class="code">รหัสสินค้า : DAE-1217-2304</p>

                                                <div class="price-block">
                                                    <p class="price">฿7,290.00</p>
                                                    <p class="price-old">฿10,760.00</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div><!--row-->
                            </div><!--product-lists-->

                        </div><!--swiper-slide-->
                    </div><!--swiper-wrapper-->
                </div><!--swiper-container-->

                <div class="swiper-pagination-group">
                    <div class="swiper-pagination d-flex d-xl-none"></div>
                </div>
                <div class="swiper-button swiper-button-prev"><span class="icons"></span></div>
                <div class="swiper-button swiper-button-next"><span class="icons"></span></div>
            </div>
        </div><!--container-->
    </div><!--section-->

    <div class="section">
        <div class="container">
            <div class="swiper-overflow news" data-aos="fade-in">
                <div class="swiper-overflow-inner">
                    <div class="swiper-container swiper-news">
                        <div class="swiper-wrapper">
                            @foreach ($news as $newsItem)
                                <div class="swiper-slide">
                                    <div class="card-news">
                                        <a class="card-link"
                                            href="{{ route('news.detail', ['lang' => app()->getLocale(), 'id' => $newsItem->slug ?: $newsItem->news_id]) }}"></a>
                                        <div class="card-body">
                                            <h3>{{ $newsItem->name }}</h3>
                                            <h4 class="title-icon">
                                                <img class="icons"
                                                    src="{{ asset('img/icons/icon-circle-right-arrow.svg') }}"
                                                    alt="" />
                                                @lang('messages.view')
                                            </h4>
                                            <p>
                                                <small>{{ $newsItem->updated_at }}</small>
                                            </p>
                                        </div>
                                        <!--card-body-->
                                        <div class="card-photo">
                                            <div class="photo">
                                                @if ($newsItem->image !== null)
                                                    <img src="{{ asset('upload/file/news/' . basename($newsItem->image)) }}"
                                                        alt="" class="custom-image">
                                                @else
                                                    <img src="{{ asset('upload/file/404.png') }}" alt="Default Icon"
                                                        class="custom-image">
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="swiper-pagination-group">
                    <div class="swiper-pagination d-flex d-xl-none"></div>
                </div>
                <div class="swiper-button swiper-button-prev">
                    <span class="icons"></span>
                </div>
                <div class="swiper-button swiper-button-next">
                    <span class="icons"></span>
                </div>
            </div>
        </div><!--section-->
    @endsection
    @section('script')
    @endsection
