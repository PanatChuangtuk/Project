@extends('main') @section('title')
    @lang('messages.my_purchase')
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
                            <li class="active">
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
            </div>

            <div class="content">
                <ul class="nav nav-buttons">
                    <li><button class="btn active" type="button">@lang('messages.all')</button></li>
                    <li><button class="btn" type="button">@lang('messages.to_pay')</button></li>
                    <li><button class="btn" type="button">@lang('messages.to_delivery')</button></li>
                    <li><button class="btn" type="button">@lang('messages.to_receive')</button></li>
                    <li><button class="btn" type="button">@lang('messages.completed')</button></li>
                    <li><button class="btn" type="button">@lang('messages.cancelled')</button></li>
                </ul>
                @if (empty($allOrderProducts))
                    <div class="empty-cart-message">
                        <h3>@lang('messages.item_is_empty')</h3>
                    </div>
                @endif
                @foreach ($allOrderProducts as $order_id => $products)
                    @php
                        $order = App\Models\Order::find($order_id);
                    @endphp
                    <div class="card-info purchase pt-2 px-5">
                        @foreach ($products as $index => $item)
                            <a href="{{ url(app()->getLocale() . '/cart-check-out', $item->order_id) }}"
                                class="card-link"></a>
                        @endforeach
                        <div class="info-row border-bottom-1">
                            @if ($order)
                                <p><strong>@lang('messages.purchase_order_no') :</strong> {{ $order->order_number }}</p>
                            @endif
                            <label class="purchase-status toplay">@lang('messages.to_pay')</label>
                        </div>
                        <ul class="ul-table ul-table-body infos">
                            <li class="photo">
                                <img src="{{ asset('img/thumb/photo-400x455--1.jpg') }}" alt="" />
                            </li>
                            @foreach ($products as $index => $item)
                                @if ($index == 0)
                                    <li class="info">
                                        <div class="product-info">
                                            <h3>
                                                {{ $item->name }}
                                            </h3>
                                            <label class="label">Size : {{ $item->size }}</label>
                                            <p><small>Model : {{ $item->model }}</small></p>
                                        </div>
                                    </li>
                                    <li class="qty">
                                        <strong class="fs-16 text-black">x{{ $item->quantity }}</strong>
                                    </li>
                                    <li class="total">
                                        <strong>{{ number_format($item->price * $item->quantity, 2) }}
                                            ฿</strong>
                                    </li>
                        </ul>

                        <div class="info-row">
                            <p>@lang('messages.total') : {{ $products->count() }} @lang('messages.item')</p>
                            <p class="price">{{ number_format($item->price * $item->quantity, 2) }} ฿</p>
                        </div>
                @endif
                @endforeach
                <div class="info-row">
                    <div class="d-flex gap-2">
                        <img class="icons w-34" src="{{ asset('img/icons/icon-34x34--1.svg') }}" alt="" />

                        <label class="purchase-status">
                            <span class="px-sm-2">@lang('messages.waiting_seller_confirm')</span>
                        </label>
                    </div>
                    @foreach ($products as $index => $item)
                        <p><a class="link link-primary"
                                href="{{ url(app()->getLocale() . '/cart-check-out', $item->order_id) }}">@lang('messages.see_more')</a>
                        </p>
                    @endforeach
                </div>
            </div>
            @endforeach
        </div>
    </div>
    </div>
    </div>
@endsection
@section('script')
@endsection
