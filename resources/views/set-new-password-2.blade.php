@extends('main')
@section('title')
    @lang('messages.change_password')
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
                            <li class="active">
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
                <div class="card-info main px-5">
                    <div class="boxed py-3">
                        <div class="article pb-3" style="--font-size: 14px; --color: #375b51">
                            <h2 class="title-xl text-secondary fw-600">
                                @lang('messages.setup_new_password')
                            </h2>

                            <p>@lang('messages.password_must_be_at_least_8_characters')</p>
                        </div>

                        <form class="form" method="POST"
                            action="{{ route('profile.reset.password.submit', ['lang' => app()->getLocale()]) }}">
                            @csrf
                            <div class="row g-4">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="title">@lang('messages.current_password')</label>
                                        <div class="group">
                                            <span class="icons icon-eye right"></span>
                                            <input type="password" class="form-control pw" name="password_old"
                                                id="password_old" placeholder="@lang('messages.enter_old_password')" />
                                        </div> @error('password_old')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="title">@lang('messages.new_password')</label>
                                        <div class="group">
                                            <span class="icons icon-eye right"></span>
                                            <input type="password" class="form-control pw" name="password" id="password"
                                                placeholder="@lang('messages.enter_your_password')" />

                                        </div> @error('new_password')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="title">@lang('messages.confirm_password')
                                        </label>
                                        <div class="group">
                                            <span class="icons icon-eye right"></span>
                                            <input type="password" class="form-control pw" name="password_confirmation"
                                                id="password_confirmation" placeholder="@lang('messages.enter_your_password')" />
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 d-flex pt-sm-4">
                                    <button class="btn px-5 ms-auto me-sm-0 me-auto" type="submit"
                                        data-bs-target="#successModal" data-bs-toggle="modal">
                                        <span class="px-3">@lang('messages.confirm')</span>
                                    </button>
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
    @endsection @section('script')
@endsection
