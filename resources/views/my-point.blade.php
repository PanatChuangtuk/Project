@extends('main')
@section('title')
    @lang('messages.my_point')
@endsection
@section('stylesheet')
@endsection
@section('content')
    <div class="section section-profile bg-light pt-0">
        <div class="container has-sidebar">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">Profile</li>
            </ol>

            <div class="sidebar">
                <div class="card-info main">
                    <div class="title-bar d-flex" data-bs-toggle="collapse" data-bs-target="#navProfile">
                        <h1 class="h2 text-capitalize text-underline">Profile</h1>

                        <button class="btn btn-menu" type="button">
                            <img class="icons svg-js" src="img/icons/icon-add-plus.svg" alt="">
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
                                    <img class="icons" src="{{ asset('img/icons/icon-favorite-2.svg') }}" alt="" />
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

                </div><!--card-info-->

            </div><!--sidebar-->

            <div class="content">
                <ul class="nav nav-buttons ">
                    <li class="w-185">
                        <a class="btn" href="{{ url(app()->getLocale() . '/my-coupon') }}">@lang('messages.my_coupon')</a>
                    </li>
                    <li class="w-185">
                        <a class="btn active" href="{{ url(app()->getLocale() . '/my-point') }}">@lang('messages.my_point')</a>
                    </li>
                </ul>

                <ul class="nav nav-buttons point">
                    <li>
                        <div class="btn points">
                            <img class="icons" src="img/icons/icon-point.png" alt="">
                            <span class="text-orange">599.50</span>
                            <small>Point</small>
                        </div>
                    </li>
                    <li>
                        <button class="btn active" type="button" data-bs-toggle="tab">ประวัติทั้งหมด</button>
                    </li>
                    <li>
                        <button class="btn" type="button" data-bs-toggle="tab">ที่ได้รับ</button>
                    </li>
                    <li>
                        <button class="btn" type="button" data-bs-toggle="tab">ที่ถูกใช้</button>
                    </li>
                </ul>

                <div class="card-point plus">
                    <div class="card-icon">
                        <img class="icons" src="img/icons/icon-point.png" alt="">
                    </div>
                    <div class="card-body">
                        <div>
                            <p>เลขที่สั่งซื้อ : 89275241</p>
                            <p><small>09/02/2023 13:50</small></p>
                        </div>

                        <p class="point">+35</p>
                    </div>
                </div>

                <div class="card-point">
                    <div class="card-icon">
                        <img class="icons" src="img/icons/icon-point.png" alt="">
                    </div>
                    <div class="card-body">
                        <div>
                            <p>เลขที่สั่งซื้อ : 89275241</p>
                            <p><small>09/02/2023 13:50</small></p>
                        </div>

                        <p class="point">-45</p>
                    </div>
                </div>

                <div class="card-point plus">
                    <div class="card-icon">
                        <img class="icons" src="img/icons/icon-point.png" alt="">
                    </div>
                    <div class="card-body">
                        <div>
                            <p>เลขที่สั่งซื้อ : 89275241</p>
                            <p><small>09/02/2023 13:50</small></p>
                        </div>

                        <p class="point">+35</p>
                    </div>
                </div>

                <div class="card-point">
                    <div class="card-icon">
                        <img class="icons" src="img/icons/icon-point.png" alt="">
                    </div>
                    <div class="card-body">
                        <div>
                            <p>เลขที่สั่งซื้อ : 89275241</p>
                            <p><small>09/02/2023 13:50</small></p>
                        </div>

                        <p class="point">-45</p>
                    </div>
                </div>

                <div class="card-point">
                    <div class="card-icon">
                        <img class="icons" src="img/icons/icon-point.png" alt="">
                    </div>
                    <div class="card-body">
                        <div>
                            <p>เลขที่สั่งซื้อ : 89275241</p>
                            <p><small>09/02/2023 13:50</small></p>
                        </div>

                        <p class="point">-45</p>
                    </div>
                </div>

                <div class="card-point">
                    <div class="card-icon">
                        <img class="icons" src="img/icons/icon-point.png" alt="">
                    </div>
                    <div class="card-body">
                        <div>
                            <p>เลขที่สั่งซื้อ : 89275241</p>
                            <p><small>09/02/2023 13:50</small></p>
                        </div>

                        <p class="point">-45</p>
                    </div>
                </div>

                <ul class="pagination pb-0">
                    <li class="page-item">
                        <a class="page-link arrow prev" href="#">
                            <img class="icons svg-js" src="img/icons/icon-next.svg" alt="">
                        </a>
                    </li>
                    <li class="page-item active"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item"><a class="page-link" href="#">4</a></li>
                    <li class="page-item"><a class="page-link" href="#">5</a></li>
                    <li class="page-item">
                        <a class="page-link arrow next" href="#">
                            <img class="icons svg-js" src="img/icons/icon-next.svg" alt="">
                        </a>
                    </li>
                </ul>

            </div><!--content-->

        </div><!--container-->
    </div><!--section-->
@endsection
@section('script')
@endsection
