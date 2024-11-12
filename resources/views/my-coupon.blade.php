@extends('main')
@section('title')
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
                            <li>
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
                            <li class="active">
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
                                <a href="#"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <img class="icons" src="{{ asset('img/icons/icon-logout.svg') }}" alt="" />
                                    @lang('messages.sign_out')
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <!--card-info-->
            </div>
            <!--sidebar-->

            <div class="content">
                <ul class="nav nav-buttons ">
                    <li class="w-185">
                        <a class="btn active" href="my-coupon.html">My Coupon</a>
                    </li>
                    <li class="w-185">
                        <a class="btn" href="my-point.html">My Point</a>
                    </li>
                </ul>

                <div class="boxed voucher-lists">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card-voucher">
                                <div class="card-photo">
                                    <img class="icons" src="img/icons/icon-free-shipping.png" alt="">
                                </div>
                                <div class="card-body">
                                    <div class="my-sm-auto">
                                        <h3>ส่งฟรี</h3>
                                        <p>ขั้นต่ำ ฿0 ลดสูงสุด ฿50</p>
                                    </div>

                                    <div class="rows">
                                        <label class="btn btn-32 btn-orange w-110 claimed">Claimed</label>

                                        <a href="#voucherConditionModal" data-bs-toggle="modal">เงื่อนไข</a>
                                    </div>
                                </div>
                            </div><!--card-voucher-->
                        </div>

                        <div class="col-md-6">
                            <div class="card-voucher discount">
                                <div class="card-photo">
                                    <img class="icons" src="img/icons/icon-discount.png" alt="">
                                </div>
                                <div class="card-body">
                                    <div class="my-auto">
                                        <h3>Discount 10% </h3>
                                        <p>ขั้นต่ำ ฿0 ลดสูงสุด ฿50</p>
                                    </div>

                                    <div class="rows">
                                        <label class="btn btn-32 btn-orange w-110 claimed">Claimed</label>

                                        <a href="#voucherConditionModal" data-bs-toggle="modal">เงื่อนไข</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card-voucher discount">
                                <div class="card-photo">
                                    <img class="icons" src="img/icons/icon-discount.png" alt="">
                                </div>
                                <div class="card-body">
                                    <div class="my-auto">
                                        <h3>Discount ฿100 </h3>
                                        <p>ขั้นต่ำ ฿0 ลดสูงสุด ฿50</p>
                                    </div>

                                    <div class="rows">
                                        <label class="btn btn-32 btn-orange w-110 claimed">Claimed</label>

                                        <a href="#voucherConditionModal" data-bs-toggle="modal">เงื่อนไข</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!--row-->
                </div>

            </div><!--content-->

        </div><!--container-->
    </div><!--section-->
@endsection
@section('script')
@endsection
