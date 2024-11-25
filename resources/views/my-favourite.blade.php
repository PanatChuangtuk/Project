@extends('main')
@section('title')
    @lang('messages.my_favourite')
@endsection
@section('stylesheet')
@endsection
@section('content')
    <div class="section section-profile bg-light pt-0">
        <div class="container has-sidebar">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">@lang('messages.profile')</li>
            </ol>

            <div class="sidebar">
                <div class="card-info main">
                    <div class="title-bar d-flex" data-bs-toggle="collapse" data-bs-target="#navProfile">
                        <h1 class="h2 text-capitalize text-underline">@lang('messages.profile')</h1>

                        <button class="btn btn-menu" type="button">
                            <img class="icons svg-js" src="{{ asset('img/icons/icon-add-plus.svg') }}" alt="" />
                        </button>
                    </div>

                    <div id="navProfile" class="collapse">
                        <ul class="nav nav-profile">
                            <li>
                                <a href="{{ url(app()->getLocale() . '/profile') }}">
                                    <img class="icons" src="{{ asset('img/icons/icon-user.svg') }}" alt="" />
                                    @lang('messages.my_account')
                                </a>
                            </li>
                            <li>
                                <a href="{{ url(app()->getLocale() . '/address') }}">
                                    <img class="icons" src="{{ asset('img/icons/icon-map-2.svg') }}" alt="" />
                                    @lang('messages.address')
                                </a>
                            </li>
                            <li>
                                <a href="{{ url(app()->getLocale() . '/tax-invoice') }}">
                                    <img class="icons" src="{{ asset('img/icons/icon-map-2.svg') }}" alt="" />
                                    @lang('messages.tax_invoice')
                                </a>
                            </li>
                            <li>
                                <a href="{{ url(app()->getLocale() . '/my-purchase') }}">
                                    <img class="icons" src="{{ asset('img/icons/icon-document.svg') }}" alt="" />
                                    @lang('messages.my_purchase')
                                </a>
                            </li>
                            <li class="active">
                                <a href="{{ url(app()->getLocale() . '/my-favourite') }}">
                                    <img class="icons" src="{{ asset('img/icons/icon-favorite-2.svg') }}"
                                        alt="" />
                                    @lang('messages.my_favourite')
                                </a>
                            </li>
                            <li>
                                <a href="{{ url(app()->getLocale() . '/reviews') }}">
                                    <img class="icons" src="{{ asset('img/icons/icon-star-sharp.svg') }}"
                                        alt="" />
                                    @lang('messages.my_reviews')
                                </a>
                            </li>
                            <li>
                                <a href="{{ url(app()->getLocale() . '/my-coupon') }}">
                                    <img class="icons" src="{{ asset('img/icons/icon-ticket-discount.svg') }}"
                                        alt="" />
                                    @lang('messages.my_coupon_point')
                                </a>
                            </li>
                            <li>
                                <a href="{{ url(app()->getLocale() . '/notification') }}">
                                    <img class="icons" src="{{ asset('img/icons/icon-bell-2.svg') }}" alt="" />
                                    @lang('messages.notification')
                                </a>
                            </li>
                            <li>
                                <a href="{{ url(app()->getLocale() . '/change-password') }}">
                                    <img class="icons" src="{{ asset('img/icons/icon-user.svg') }}" alt="" />
                                    @lang('messages.change_password')
                                </a>
                            </li>
                            <li>
                                <a href="{{ url(app()->getLocale() . '/term-condition') }}">
                                    <img class="icons" src="{{ asset('img/icons/icon-note.svg') }}" alt="" />
                                    @lang('messages.term_and_condition')
                                </a>
                            </li>
                            <li>
                                <a href="{{ url(app()->getLocale() . '/privacy-policy') }}">
                                    <img class="icons" src="{{ asset('img/icons/icon-shield-tick.svg') }}"
                                        alt="" />
                                    @lang('messages.privacy_policy')
                                </a>
                            </li>
                            <li>
                                <form id="logout-form" action="{{ url(app()->getLocale() . '/logout') }}" method="POST"
                                    style="display: none;">
                                    @csrf
                                </form>
                                <a href="#" onclick="confirmLogout(event)">
                                    <img class="icons" src="{{ asset('img/icons/icon-logout.svg') }}" alt="" />
                                    @lang('messages.sign_out')
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <!--card-info-->
            </div>

            <div class="content">
                <div class="card-info main px-5">
                    <h2 class="title-md">My Favourite</h2>

                    <div class="row g-3 g-sm-4 gx-md-5 pt-4">
                        <div class="col-md-4 col-6">
                            <div class="card-product thumb">
                                <a class="card-link" href="product-details.html"></a>
                                <div class="card-photo">
                                    <div class="photo" style="background-image: url(img/thumb/photo-600x600--3.jpg);">
                                        <img src="img/thumb/frame-100x100.png" alt="">
                                    </div>
                                </div>
                                <div class="card-body px-0">
                                    <h3>Bottle media wide mount GL80 5000ml ...</h3>
                                    <p class="code">รหัสสินค้า : DAE-1217-2304</p>

                                    <div class="price-block">
                                        <p class="price">฿7,290.00</p>
                                        <p class="price-old">฿10,760.00</p>
                                    </div>
                                </div>

                                <div class="button-block">
                                    <div class="dropdown pd-delete">
                                        <button class="btn btn-action" type="button" data-bs-toggle="dropdown"
                                            data-bs-display="static">
                                            <span class="icons"></span>
                                        </button>
                                        <div class="dropdown-menu">
                                            <button class="btn" type="button">Delete Favourite</button>
                                        </div>
                                    </div>

                                    <a class="btn btn-cart" href="product-detail.html">
                                        <span class="icons"></span>
                                    </a>
                                </div>

                            </div><!--card-product-->
                        </div>

                        <div class="col-md-4 col-6">
                            <div class="card-product thumb">
                                <a class="card-link" href="product-details.html"></a>
                                <div class="card-photo">
                                    <div class="photo" style="background-image: url(img/thumb/photo-600x600--2.jpg);">
                                        <img src="img/thumb/frame-100x100.png" alt="">
                                    </div>
                                </div>
                                <div class="card-body px-0">
                                    <h3>Nickel(II) carbonate
                                        4H2O CP</h3>
                                    <p class="code">รหัสสินค้า : DAE-1217-2304</p>

                                    <div class="price-block">
                                        <p class="price">฿7,290.00</p>
                                        <p class="price-old">฿10,760.00</p>
                                    </div>
                                </div>

                                <div class="button-block">
                                    <div class="dropdown pd-delete">
                                        <button class="btn btn-action" type="button" data-bs-toggle="dropdown"
                                            data-bs-display="static">
                                            <span class="icons"></span>
                                        </button>
                                        <div class="dropdown-menu">
                                            <button class="btn" type="button">Delete Favourite</button>
                                        </div>
                                    </div>

                                    <a class="btn btn-cart" href="product-detail.html">
                                        <span class="icons"></span>
                                    </a>
                                </div>
                            </div><!--card-product-->
                        </div>

                        <div class="col-md-4 col-6">
                            <div class="card-product thumb">
                                <a class="card-link" href="product-details.html"></a>
                                <div class="card-photo">
                                    <div class="photo" style="background-image: url(img/thumb/photo-600x600--1.jpg);">
                                        <img src="img/thumb/frame-100x100.png" alt="">
                                    </div>
                                </div>
                                <div class="card-body px-0">
                                    <h3>Acetonitrile Gradient Grade</h3>
                                    <p class="code">รหัสสินค้า : DAE-1217-2304</p>

                                    <div class="price-block">
                                        <p class="price">฿7,290.00</p>
                                        <p class="price-old">฿10,760.00</p>
                                    </div>
                                </div>

                                <div class="button-block">
                                    <div class="dropdown pd-delete">
                                        <button class="btn btn-action" type="button" data-bs-toggle="dropdown"
                                            data-bs-display="static">
                                            <span class="icons"></span>
                                        </button>
                                        <div class="dropdown-menu">
                                            <button class="btn" type="button">Delete Favourite</button>
                                        </div>
                                    </div>

                                    <a class="btn btn-cart" href="product-detail.html">
                                        <span class="icons"></span>
                                    </a>
                                </div>
                            </div><!--card-product-->
                        </div>

                        <div class="col-md-4 col-6">
                            <div class="card-product thumb">
                                <a class="card-link" href="product-details.html"></a>
                                <div class="card-photo">
                                    <div class="photo" style="background-image: url(img/thumb/photo-600x600--4.jpg);">
                                        <img src="img/thumb/frame-100x100.png" alt="">
                                    </div>
                                </div>
                                <div class="card-body px-0">
                                    <h3>Flask Volumetric, amber,
                                        PE stopper, 5ml, Class...</h3>
                                    <p class="code">รหัสสินค้า : DAE-1217-2304</p>

                                    <div class="price-block">
                                        <p class="price">฿7,290.00</p>
                                        <p class="price-old">฿10,760.00</p>
                                    </div>
                                </div>

                                <div class="button-block">
                                    <div class="dropdown pd-delete">
                                        <button class="btn btn-action" type="button" data-bs-toggle="dropdown"
                                            data-bs-display="static">
                                            <span class="icons"></span>
                                        </button>
                                        <div class="dropdown-menu">
                                            <button class="btn" type="button">Delete Favourite</button>
                                        </div>
                                    </div>

                                    <a class="btn btn-cart" href="product-detail.html">
                                        <span class="icons"></span>
                                    </a>
                                </div>
                            </div><!--card-product-->
                        </div>
                    </div><!--row-->
                </div><!--card-info-->
            </div><!--content-->

        </div><!--container-->
    </div><!--section-->
@endsection
@section('script')
@endsection
