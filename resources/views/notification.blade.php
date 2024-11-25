@extends('main') @section('title')
    @lang('messages.notification')
    @endsection @section('stylesheet')
    @endsection @section('content')
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
                            <li class="active">
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
            <!--sidebar-->

            <div class="content">
                <div class="card-info px-md-5">
                    <h3 class="text-secondary fs-20 mb-3">All Notification</h3>

                    <div class="card-notify-lists">
                        <div class="card-notify md">
                            <a href="promotion-details.html" class="card-link"></a>
                            <img class="card-photo" src="img/thumb/photo-200x200--1.jpg" alt="" />
                            <div class="card-body">
                                <div class="group">
                                    <h3>9.9 SepSale Discount9%</h3>
                                    <p>
                                        page.Once the payment method is confirmed
                                        and the order is placed on the “Checkout”
                                        page, it cannot be modified thereafter. To
                                        mak...
                                    </p>
                                </div>
                                <div class="link-blue">See Detail</div>
                            </div>
                        </div>

                        <div class="card-notify md">
                            <a href="promotion-details.html" class="card-link"></a>
                            <img class="card-photo" src="img/thumb/photo-200x200--2.jpg" alt="" />
                            <div class="card-body">
                                <div class="group">
                                    <h3>Parcel Delivered</h3>
                                    <p>
                                        Parcel for your order SH20240000101 has been
                                        delivered.
                                    </p>
                                </div>
                                <div class="link-blue">See Detail</div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--card-info-->
            </div>
            <!--content-->
        </div>
        <!--container-->
    </div>
    <!--section-->
    @endsection @section('script')
@endsection
