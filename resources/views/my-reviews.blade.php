@extends('main') @section('title')
    @lang('messages.my_reviews')
    @endsection @section('stylesheet')
    @endsection @section('content')
    < <div class="section section-profile bg-light pt-0">
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
                            <li class="active">
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
            <!--sidebar-->

            <div class="content">
                <ul class="nav nav-buttons">
                    <li class="w-185">
                        <a class="btn " href="{{ url(app()->getLocale() . '/reviews') }}">To Review</a>
                    </li>
                    <li class="w-185">
                        <a class="btn active" href="{{ url(app()->getLocale() . '/my-reviews') }}">My Review</a>
                    </li>
                </ul>


                <div class="card-info purchase pt-2 px-5">
                    <div class="info-row border-bottom-1 pe-0">
                        <p><strong>Order No :</strong> SH20240000101</p>

                        <label class="purchase-status completed">Completed</label>
                    </div>

                    <ul class="ul-table ul-table-body infos">
                        <li class="photo">
                            <img src="img/thumb/photo-400x455--1.jpg" alt="" />
                        </li>
                        <li class="info">
                            <div class="product-info">
                                <h3>
                                    (+)-1,2-Bis[(2R,5R)-2,5-diethyl
                                    -1-phospholanyl]ethane, 97+%
                                </h3>
                                <label class="label">Size : 5G (Code: ALF-J63245.06 )</label>
                                <p><small>Model : DAE-1217-2304</small></p>
                            </div>
                        </li>
                    </ul>

                    <div class="card-my-review">
                        <img class="avatar" src="img/thumb/avatar-2.png" alt="" />
                        <div class="card-body">
                            <div class="star-rating">
                                <span class="icons active"></span>
                                <span class="icons active"></span>
                                <span class="icons active"></span>
                                <span class="icons active"></span>
                                <span class="icons active"></span>
                            </div>

                            <p>
                                ขอบคุณทางบริษัทฯ ที่ส่งพี่เสน่ห์มา service ได้ดีมาก
                                ๆ ส่งใบเสนอราคาได้รวดเร็วและมีหลายระดับ
                                ราคาของเครื่องมืออุปกรณ์ให้เลือก
                                มีบริการหลังการขายที่ดีมาก ๆ
                                สินค้าที่มีในสต๊อกส่งได้รวดเร็วดีครับ
                            </p>
                        </div>
                    </div>

                    <hr class="m-0 light" />

                    <ul class="ul-table ul-table-body infos">
                        <li class="photo">
                            <img src="img/thumb/photo-400x455--2.jpg" alt="" />
                        </li>
                        <li class="info">
                            <div class="product-info">
                                <h3>
                                    (+)-1,2-Bis[(2R,5R)-2,5-diethyl
                                    -1-phospholanyl]ethane, 97+%
                                </h3>
                                <label class="label">Size : 5G (Code: ALF-J63245.06 )</label>
                                <p><small>Model : DAE-1217-2304</small></p>
                            </div>
                        </li>
                    </ul>

                    <div class="card-my-review">
                        <img class="avatar" src="img/thumb/avatar-2.png" alt="" />
                        <div class="card-body">
                            <div class="star-rating">
                                <span class="icons active"></span>
                                <span class="icons active"></span>
                                <span class="icons active"></span>
                                <span class="icons active"></span>
                                <span class="icons active"></span>
                            </div>

                            <p>
                                ขอบคุณทางบริษัทฯ ที่ส่งพี่เสน่ห์มา service ได้ดีมาก
                                ๆ ส่งใบเสนอราคาได้รวดเร็วและมีหลายระดับ
                                ราคาของเครื่องมืออุปกรณ์ให้เลือก
                                มีบริการหลังการขายที่ดีมาก ๆ
                                สินค้าที่มีในสต๊อกส่งได้รวดเร็วดีครับ
                            </p>
                        </div>
                    </div>

                    <div class="info-row">
                        <p>Total : 2 Item</p>
                        <p class="price">14,338.00฿</p>
                    </div>
                </div>
            </div>
            <!--content-->
        </div>
        <!--container-->
        </div>
        <!--section-->
        @endsection @section('script')
    @endsection
