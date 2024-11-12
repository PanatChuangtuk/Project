@extends('main')
@section('title')
@endsection
@section('stylesheet')
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
                        <div class="col-4">
                            <div class="card-category active" data-bs-toggle="tab" data-bs-target="#tab-category-1">
                                <div class="card-photo">
                                    <div class="photo"
                                        style="background-image: url('{{ asset('img/thumb/photo-800x650--1.jpg') }}');">
                                        <img src="{{ asset('img/thumb/frame-100x60.png') }}" alt="">
                                    </div>
                                </div>
                                <div class="card-body">
                                    <h3>@lang('messages.chemical')</h3>
                                    <p class="d-flex"><a class="viewmore">@lang('messages.view_more')</a></p>
                                </div>
                            </div><!--card-category-->
                        </div>

                        <div class="col-4">
                            <div class="card-category" data-bs-toggle="tab" data-bs-target="#tab-category-2">
                                <div class="card-photo">
                                    <div class="photo"
                                        style="background-image: url('{{ asset('img/thumb/photo-800x650--2.jpg') }}');">
                                        <img src="{{ asset('img/thumb/frame-100x60.png') }}" alt="">
                                    </div>
                                </div>
                                <div class="card-body">
                                    <h3>@lang('messages.lab_equipment')</h3>
                                    <p class="d-flex"><a class="viewmore">@lang('messages.view_more')</a></p>
                                </div>
                            </div><!--card-category-->
                        </div>

                        <div class="col-4">
                            <div class="card-category" data-bs-toggle="tab" data-bs-target="#tab-category-3">
                                <div class="card-photo">
                                    <div class="photo"
                                        style="background-image: url('{{ asset('img/thumb/photo-800x650--3.jpg') }}');">
                                        <img src="{{ asset('img/thumb/frame-100x60.png') }}" alt="">
                                    </div>
                                </div>
                                <div class="card-body">
                                    <h3>@lang('messages.test_kit')</h3>
                                    <p class="d-flex"><a class="viewmore">@lang('messages.view_more')</a></p>
                                </div>
                            </div><!--card-category-->
                        </div>
                    </div><!--row-->
                </div>
            </div><!--category-block-->

            <div class="tab-content tab-category-content" data-aos="fade-in">
                <div id="tab-category-1" class="tab-pane show active">
                    <div class="hgroup">
                        <h2 class="title-line text-uppercase">
                            <span>@lang('messages.chemical')</span>
                        </h2>
                    </div>

                    <div class="row logo-brand-lists">
                        <div class="col-2">
                            <a href="product-list.html"><img class="logo-brand"
                                    src="{{ asset('img/thumb/photo-300x156--1.jpg') }}" alt=""></a>
                        </div>
                        <div class="col-2">
                            <a href="product-list.html"><img class="logo-brand"
                                    src="{{ asset('img/thumb/photo-300x156--2.jpg') }}" alt=""></a>
                        </div>
                        <div class="col-2">
                            <a href="product-list.html"><img class="logo-brand"
                                    src="{{ asset('img/thumb/photo-300x156--3.jpg') }}" alt=""></a>
                        </div>
                        <div class="col-2">
                            <a href="product-list.html"><img class="logo-brand"
                                    src="{{ asset('img/thumb/photo-300x156--4.jpg') }}" alt=""></a>
                        </div>
                        <div class="col-2">
                            <a href="product-list.html"><img class="logo-brand"
                                    src="{{ asset('img/thumb/photo-300x156--5.jpg') }}" alt=""></a>
                        </div>
                        <div class="col-2">
                            <a href="product-list.html"><img class="logo-brand"
                                    src="{{ asset('img/thumb/photo-300x156--6.jpg') }}" alt=""></a>
                        </div>
                        <div class="col-2">
                            <a href="product-list.html"><img class="logo-brand"
                                    src="{{ asset('img/thumb/photo-300x156--7.jpg') }}" alt=""></a>
                        </div>
                    </div>
                </div><!--tab-pane-->

                <div id="tab-category-2" class="tab-pane">
                    <div class="hgroup">
                        <h2 class="title-line">
                            <span>@lang('messages.lab_equipment')</span>
                        </h2>
                    </div>

                    <div class="row logo-brand-lists">
                        <div class="col-2">
                            <a href="product-list.html"><img class="logo-brand"
                                    src="{{ asset('img/thumb/photo-300x156--3.jpg') }}" alt=""></a>
                        </div>
                        <div class="col-2">
                            <a href="product-list.html"><img class="logo-brand"
                                    src="{{ asset('img/thumb/photo-300x156--4.jpg') }}" alt=""></a>
                        </div>
                        <div class="col-2">
                            <a href="product-list.html"><img class="logo-brand"
                                    src="{{ asset('img/thumb/photo-300x156--5.jpg') }}" alt=""></a>
                        </div>

                    </div>
                </div><!--tab-pane-->

                <div id="tab-category-3" class="tab-pane">
                    <div class="hgroup">
                        <h2 class="title-line">
                            <span>@lang('messages.test_kit')</span>
                        </h2>
                    </div>

                    <div class="row logo-brand-lists">

                        <div class="col-2">
                            <a href="product-list.html"><img class="logo-brand"
                                    src="{{ asset('img/thumb/photo-300x156--2.jpg') }}" alt=""></a>
                        </div>
                        <div class="col-2">
                            <a href="product-list.html"><img class="logo-brand"
                                    src="{{ asset('img/thumb/photo-300x156--3.jpg') }}" alt=""></a>
                        </div>
                        <div class="col-2">
                            <a href="product-list.html"><img class="logo-brand"
                                    src="{{ asset('img/thumb/photo-300x156--4.jpg') }}" alt=""></a>
                        </div>

                        <div class="col-2">
                            <a href="product-list.html"><img class="logo-brand"
                                    src="{{ asset('img/thumb/photo-300x156--6.jpg') }}" alt=""></a>
                        </div>
                        <div class="col-2">
                            <a href="product-list.html"><img class="logo-brand"
                                    src="{{ asset('img/thumb/photo-300x156--7.jpg') }}" alt=""></a>
                        </div>
                    </div>
                </div><!--tab-pane-->

            </div><!--tab-content-->
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
                            <div class="swiper-slide">
                                <div class="card-news">
                                    <a class="card-link" href="news-detail.html"></a>
                                    <div class="card-body">
                                        <h3>#WHAT ARE BIOACTIVE INGREDIENTS ANYWAY?</h3>

                                        <h4 class="title-icon">
                                            <img class="icons"
                                                src="{{ asset('img/icons/icon-circle-right-arrow.svg') }}"
                                                alt="">
                                            Admin
                                        </h4>

                                        <p><small>Update 2021-02-19 14:32:15</small></p>
                                    </div><!--card-body-->
                                    <div class="card-photo">
                                        <div class="photo"
                                            style="background-image: url('{{ asset('img/thumb/photo-800x535--1.jpg') }}');">
                                            <img src="{{ asset('img/thumb/frame-100x67.png') }}" alt="">
                                        </div>
                                    </div>
                                </div>
                            </div><!--swiper-slide-->

                            <div class="swiper-slide">
                                <div class="card-news">
                                    <a class="card-link" href="news-detail.html"></a>
                                    <div class="card-body">
                                        <h3>Let me introduce you a brand new Lab glassware KIMA</h3>

                                        <h4 class="title-icon">
                                            <img class="icons"
                                                src="{{ asset('img/icons/icon-circle-right-arrow.svg') }}"
                                                alt="">
                                            Admin
                                        </h4>

                                        <p><small>Update 2021-02-19 14:32:15</small></p>
                                    </div><!--card-body-->
                                    <div class="card-photo">
                                        <div class="photo"
                                            style="background-image: url('{{ asset('img/thumb/photo-800x535--2.jpg') }}');">
                                            <img src="{{ asset('img/thumb/frame-100x67.png') }}" alt="">
                                        </div>
                                    </div>
                                </div>
                            </div><!--swiper-slide-->

                            <div class="swiper-slide">
                                <div class="card-news">
                                    <a class="card-link" href="news-detail.html"></a>
                                    <div class="card-body">
                                        <h3>50 Interesting, fun, and weird real-life Chemistry Facts.</h3>

                                        <h4 class="title-icon">
                                            <img class="icons"
                                                src="{{ asset('img/icons/icon-circle-right-arrow.svg') }}"
                                                alt="">
                                            Admin
                                        </h4>

                                        <p><small>Update 2021-02-19 14:32:15</small></p>
                                    </div><!--card-body-->
                                    <div class="card-photo">
                                        <div class="photo"
                                            style="background-image: url('{{ asset('img/thumb/photo-800x535--3.jpg') }}');">
                                            <img src="{{ asset('img/thumb/frame-100x67.png') }}" alt="">
                                        </div>
                                    </div>
                                </div>
                            </div><!--swiper-slide-->

                            <div class="swiper-slide">
                                <div class="card-news">
                                    <a class="card-link" href="news-detail.html"></a>
                                    <div class="card-body">
                                        <h3>50 Interesting, fun, and weird real-life Chemistry Facts.</h3>

                                        <h4 class="title-icon">
                                            <img class="icons"
                                                src="{{ asset('img/icons/icon-circle-right-arrow.svg') }}"
                                                alt="">
                                            Admin
                                        </h4>

                                        <p><small>Update 2021-02-19 14:32:15</small></p>
                                    </div><!--card-body-->
                                    <div class="card-photo">
                                        <div class="photo"
                                            style="background-image:url('{{ asset('img/thumb/photo-800x535--3.jpg') }}');">
                                            <img src="{{ asset('img/thumb/frame-100x67.png') }}" alt="">
                                        </div>
                                    </div>
                                </div>
                            </div><!--swiper-slide-->
                        </div>
                    </div><!--swiper-container-->
                </div>


                <div class="swiper-pagination-group">
                    <div class="swiper-pagination d-flex d-xl-none"></div>
                </div>
                <div class="swiper-button swiper-button-prev"><span class="icons"></span></div>
                <div class="swiper-button swiper-button-next"><span class="icons"></span></div>
            </div><!--swiper-overflow-->
        </div><!--container-->
    </div><!--section-->
@endsection
@section('script')
@endsection
