@extends('main')

@section('title')
    @lang('messages.tax_invoice')
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
                            <li class="active">
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
            <!-- sidebar -->

            <div class="content">
                <div class="card-info main px-5">
                    <h3 class="title-md pb-2">@lang('messages.tax_invoice')</h3>
                    @foreach ($tax as $itemTax)
                        <div class="{{ $itemTax->is_default ? 'card-address default border-0' : 'card-address' }}">
                            <a href="{{ route('tax.edit', ['lang' => app()->getLocale(), 'id' => $itemTax->id]) }}"
                                class="link-edit">@lang('messages.edit')</a>
                            <img class="icons" src="{{ asset('img/icons/icon-map-point.svg') }}" alt="">
                            <div class="card-body">
                                <p class="m-0">
                                    <strong>{{ $itemTax->first_name . ' ' . $itemTax->last_name . '   TaxID : ' . $itemTax->tax_id }}</strong>
                                </p>
                                <p>{{ $itemTax->detail . ' ' . $itemTax->district_id . ' ' . $itemTax->subdistrict_id . ' ' . $itemTax->province_id . ' ' . $itemTax->postal_code }}<br>
                                    {{ $itemTax->mobile_phone }}</p>
                                @if ($itemTax->is_default)
                                    <button class="btn btn-default" type="button">@lang('messages.default')</button>
                                @endif
                            </div>
                        </div>
                    @endforeach

                    <div class="d-flex py-2 mt-2">
                        <a class="btn btn-address-add btn-light-2"
                            href="{{ url(app()->getLocale() . '/request-full-tax-invoice') }}">
                            <img class="icons svg-js" src="{{ asset('img/icons/icon-add-plus.svg') }}" alt="" />
                            @lang('messages.add_tax_invoice')
                        </a>
                    </div>
                </div>
                <!-- card-info -->
            </div>
            <!-- content -->
        </div>
        <!-- container -->
    </div>
    <!-- section -->
@endsection

@section('script')
    <!-- สคริปต์ที่ต้องการ -->
@endsection
