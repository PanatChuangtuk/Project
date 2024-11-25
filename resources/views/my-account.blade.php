@extends('main')

@section('title')
    @lang('messages.profile')
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
                <div class="card-info main px-5">
                    <div class="avatar-setting">
                        <img class="avatar" src="{{ asset('img/thumb/avatar-2.png') }}" alt="" />
                        <button class="btn" type="button">
                            <img class="icons svg-js" src="{{ asset('img/icons/icon-plus.svg') }}" alt="" />
                        </button>
                    </div>

                    <form class="form pt-3" method="POST"
                        action="{{ route('profile.submit', ['lang' => app()->getLocale()]) }}">
                        @csrf
                        <div class="row form-row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="title">@lang('messages.username')</label>
                                    <input type="text" class="form-control"name="username"
                                        value="{{ $profile->username ?? null }}" />
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="title">@lang('messages.email')<span class="star">*</span></label>
                                    <input type="email" class="form-control" name ="email"
                                        value="{{ $profile->email ?? null }}"readonly />
                                    @error('email')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="title">@lang('messages.firstname')</label>
                                    <input type="text" class="form-control"name="first_name"
                                        value="{{ $profile->first_name ?? null }}" />
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="title">@lang('messages.lastname')</label>
                                    <input type="text" class="form-control" name="last_name"
                                        value="{{ $profile->last_name ?? null }}" />
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="title">@lang('messages.mobile_phone')</label>
                                    <input type="text" class="form-control"name="mobile_phone"
                                        value="{{ $profile->mobile_phone ?? null }}" pattern="[0-9]*" maxlength="10"
                                        readonly />
                                    @error('mobile_phone')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="title">@lang('messages.company')</label>
                                    <input type="text" value="{{ $profile->company ?? null }}" name="company"
                                        class="form-control" />
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="title">Line ID</label>
                                    <input type="text" value="{{ $profile->line_id ?? null }}" name="line_id"
                                        class="form-control" />
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="title">@lang('messages.vat_register_number')</label>
                                    <input type="text" class="form-control" placeholder="VAT Register Number"
                                        name="vat_register_number" value="{{ $profile->vat_register_number ?? null }}"
                                        maxlength="13" />
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary"
                                    id="confirmSave">@lang('messages.save')</button>
                            </div>
                        </div>
                        <!--row-->
                    </form>
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
