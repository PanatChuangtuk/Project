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
                            <li class="active">
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
                <div class="card-info main px-5">
                    <div class="boxed py-3">
                        <form class="form form-otp" method="post" action="#">
                            <div class="article pb-3" style="--font-size: 14px; --color: #375b51">
                                <h2 class="title-xl text-secondary fw-600">
                                    OTP VERIFICATION
                                </h2>

                                <p>
                                    Please check your Phone number to see the
                                    verification code
                                </p>
                            </div>

                            <div class="row g-3">
                                <div class="col-12">
                                    <h5 class="fs-14 text-black">OTP Code</h5>
                                </div>

                                <div class="col-12">
                                    <div class="form-otp-group">
                                        <input type="text" class="form-control digit numbersOnly" maxlength="1"
                                            pattern="[0-9]*" inputmode="numeric" name="" />
                                        <input type="text" class="form-control digit numbersOnly" maxlength="1"
                                            pattern="[0-9]*" inputmode="numeric" name="" />
                                        <input type="text" class="form-control digit numbersOnly" maxlength="1"
                                            pattern="[0-9]*" inputmode="numeric" name="" />
                                        <input type="text" class="form-control digit numbersOnly" maxlength="1"
                                            pattern="[0-9]*" inputmode="numeric" name="" />
                                        <input type="text" class="form-control digit numbersOnly" maxlength="1"
                                            pattern="[0-9]*" inputmode="numeric" name="" />
                                        <input type="text" class="form-control digit numbersOnly last" maxlength="1"
                                            pattern="[0-9]*" inputmode="numeric" name="" />
                                    </div>
                                    <!--form-otp-->
                                </div>

                                <div class="col-12 d-flex fs-14 text-gray font-inter">
                                    <p class="m-0">
                                        <span class="resend">Resend Code</span>
                                    </p>
                                    <p class="m-0 ms-auto">02:59</p>
                                </div>

                                <div class="col-12 d-flex pt-4">
                                    <a class="btn px-4 ms-auto" href="set-new-password-2.html">
                                        <span class="px-2">Chang Password</span>
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!--boxed-->
                </div>
                <!--card-info-->
            </div>
            <!--content-->
        </div>
        <!--container-->
    </div>
    <!--section-->
@endsection
@section('script')
@endsection
