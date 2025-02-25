<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale = 1.0, 
maximum-scale=1.0, user-scalable=no" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <title>@yield('title', 'Default') - KMUTNB</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Prompt:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">

    <link href="{{ asset('css/bootstrap/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/aos.css') }}" rel="stylesheet">
    <link href="{{ asset('css/jquery.fancybox.css') }}" rel="stylesheet">
    <link href="{{ asset('css/swiper.css') }}" rel="stylesheet">
    <link href="{{ asset('css/jquery.scrollbar.css') }}" rel="stylesheet">
    <link href="{{ asset('css/global.css') }}" rel="stylesheet">
    <style>
        .empty-cart-message {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 200px;
            text-align: center;
        }
    </style>
    @yield('stylesheet')
</head>

<body>

    <div class="preload">
        <span class="loader"></span>
    </div>

    <div class="page logo-hidden">
        <header class="header">
            <div class="navbar-toppage">
                <div class="container">
                    <button class="btn btn-icon navbar-toggle" type="button">
                        <span class="group">
                            <span></span>
                            <span></span>
                            <span></span>
                        </span>
                    </button>
                    <ul class="nav nav-general right member">
                        {{-- @foreach ($social as $socialItem)
                            <li>
                                <div class="followus">
                                    <a href="{{ strip_tags($socialItem->html) }}" target="_blank"><img
                                            class="svg-js icons"
                                            src="{{ asset('upload/file/social/' . $socialItem->image) }}"
                                            alt=""></a>
                                </div>
                            </li>
                        @endforeach --}}


                        @guest('member')
                            <div class="member-links">
                                @if (Route::has('login'))
                                    <li>
                                        <a href="{{ url('/login') }}" class="link">
                                            @lang('messages.login')
                                        </a>
                                    </li>
                                @endif

                                /

                                @if (Route::has('register'))
                                    <li>
                                        <a href="{{ url('/register') }}" class="link">
                                            @lang('messages.register')
                                        </a>
                                    </li>
                                @endif
                            </div>
                        @endguest

                        @auth('member')
                            <div class="member-links member dropdown">
                                <li>
                                    <a href="#" data-bs-toggle="dropdown" data-bs-display="static" class="link">
                                        <img class="icons avatar" src="{{ asset('img/thumb/avatar-1.png') }}"
                                            alt="">
                                        {{-- <span
                                            class="username">{{ $profileUser->first_name . ' ' . $profileUser->last_name }}</span> --}}
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a href="{{ url('/profile') }}"> @lang('messages.my_account')</a>
                                        </li>
                                        <li><a href="{{ url('/my-purchase') }}">@lang('messages.my_purchase')</a>
                                        </li>
                                        <li>
                                            <form id="logout-form" action="{{ url('/logout') }}" method="POST"
                                                style="display: none;">
                                                @csrf
                                            </form>
                                            <a href="#" class="logout" onclick="confirmLogout(event)">
                                                @lang('messages.sign_out')
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            </div>
                        @endauth

                        {{-- <li>
                            <a class="cart-mini" href="{{ route('cart.index') }}">
                                <div class="btn btn-outline">
                                    <img class="svg-js icons" src="{{ asset('img/icons/icon-cart.svg') }}"
                                        alt="">
                                </div>
                                {{ sizeof($cart) }} @lang('messages.item') (s) --}}
                        {{-- @foreach ($cart as $item)
                                    - {{ number_format($item['price'] * $item['quantity'], 2) }} ฿
                                @endforeach --}}
                        {{-- </a>
                    </li>
                    @endif
                    </ul> 
                    <ul class="nav nav-general right">
                        {{-- <li class="nav-search">
                            <a href="#" class="btn btn-outline d-desktop-none" data-bs-toggle="dropdown"
                                data-bs-display="static">
                                <img class="svg-js icons icon-bell" src="{{ asset('img/icons/icon-search.svg') }}"
                                    alt="">
                            </a> --}}
                        {{-- <div class="dropdown-menu">
                                <div class="form-group search">
                                    <span class="icons icon-search left"></span>
                                    <input type="text" class="form-control" placeholder="@lang('messages.search')">
                                </div>
                            </div> --}}

                        {{-- </li> --}}

                        {{-- <li class="d-desktop-none">
                            <a class="btn btn-outline" href="{{ route('cart.index') }}">
                                <img class="icons cart svg-js" src="{{ asset('img/icons/icon-cart.svg') }}"
                                    alt="">
                            </a>
                        </li> --}}
                        @guest('member')
                            <li class="dropdown d-desktop-none">
                                <a class="btn btn-outline" href="#" data-bs-toggle="dropdown"
                                    data-bs-display="static">
                                    <img class="icons avatar svg-js" src="{{ asset('img/icons/icon-user.svg') }}"
                                        alt="">
                                </a>
                                <ul class="dropdown-menu right" style="--width:96px">
                                    @if (Route::has('login'))
                                        <li><a href="{{ route('login') }}">@lang('messages.login')</a>
                                        </li>
                                    @endif
                                    @if (Route::has('register'))
                                        <li><a href="{{ route('register') }}">@lang('messages.register')</a>
                                        </li>
                                    @endif
                                </ul>
                            </li>
                        @endguest

                        @auth('member')
                            <li class="dropdown d-desktop-none">
                                <a class="btn btn-outline" href="#" data-bs-toggle="dropdown"
                                    data-bs-display="static">
                                    <img class="icons avatar svg-js" src="{{ asset('img/icons/icon-user.svg') }}"
                                        alt="">
                                </a>
                                <ul class="dropdown-menu right" style="--width:96px">
                                    <li>
                                        <a href="{{ url('/profile') }}"> @lang('messages.my_account')</a>
                                    </li>
                                    {{-- <li><a href="{{ url('/my-purchase') }}">@lang('messages.my_purchase')</a>
                                    </li> --}}
                                    <li>
                                        <form id="logout-form" action="{{ url('/logout') }}" method="POST"
                                            style="display: none;">
                                            @csrf
                                        </form>
                                        <a href="#" class="logout" onclick="confirmLogout(event)">
                                            @lang('messages.sign_out')
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        @endauth










                        {{-- <li class="dropdown notify">
                            <a href="#" data-bs-toggle="dropdown" data-bs-display="static">
                                <img class="svg-js icons icon-bell" src="{{ asset('img/icons/icon-bell.svg') }}"
                                    alt="">
                                <span class="badge">1</span>
                            </a>

                            <ul class="dropdown-menu">
                                <li>
                                    <h5 class="title"><a href="notification">@lang('messages.notification')</a></h5>
                                </li>
                                <li>
                                    <div class="card-notify">
                                        <a href="promotion-details" class="card-link"></a>
                                        <img class="card-photo" src="{{ asset('img/thumb/photo-200x200--1.jpg') }}"
                                            alt="">
                                        <div class="card-body">
                                            <h3>9.9 SepSale Discount9%</h3>
                                            <p>page.Once the payment method is confirmed and the order is placed on
                                                the
                                                “Checkout” page, it cannot be modified thereafter. To mak...</p>
                                        </div>
                                    </div>
                                </li>

                                <li>
                                    <div class="card-notify">
                                        <a href="my-purchase-to-receive" class="card-link"></a>
                                        <img class="card-photo" src="{{ asset('img/thumb/photo-200x200--2.jpg') }}"
                                            alt="">
                                        <div class="card-body">
                                            <h3>Parcel Delivered</h3>
                                            <p>Parcel for your order SH20240000101 has been delivered.</p>
                                        </div>
                                    </div>
                                </li>

                                <li class="viewall">
                                    <a href="notification">@lang('messages.view_all')</a>
                                </li>
                            </ul>
                        </li> --}}

                        {{-- <li class="dropdown lang">
                            <a class="btn btn-outline" href="#" data-bs-toggle="dropdown"
                                data-bs-display="static">
                                {{ strtoupper(app()->getLocale()) }}
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a href="{{ url('lang/en/') }}"
                                        class="{{ app()->getLocale() == 'en' ? 'active' : '' }}">EN</a>
                                </li>
                                <li>
                                    <a
                                        href="{{ url('lang/th/') }}"class="{{ app()->getLocale() == 'th' ? 'active' : '' }}">TH</a>
                                </li>
                            </ul>
                        </li> --}}

                    </ul>
                </div>
            </div>

            <div class="navbar-main">
                <div class="container">
                    <div class="navbar-brand">
                        <a href="{{ url('/ ') }}">
                            <img src="{{ asset('img/logo.png') }}" alt="">
                        </a>
                    </div>

                    <ul class="nav nav-main">
                        <li class="{{ request()->path() === app()->getLocale() ? 'active' : '' }}">
                            <a href="{{ url('/ ') }}" style="text-transform: uppercase;">@lang('messages.home')</a>
                        </li>
                        {{-- <li class="{{ request()->is('/about') ? 'active' : '' }}">
                            <a href="{{ url('/about') }}" style="text-transform: uppercase;">@lang('messages.about')</a>
                        </li> --}}
                        {{-- <li
                            class="dropdown {{ request()->is('/product') || request()->is('/download') || request()->is('/track-trace') ? 'active' : '' }}">
                            <a href="#" data-bs-toggle="dropdown" data-bs-display="static"
                                style="text-transform: uppercase;">@lang('messages.products')</a>
                            <ul class="dropdown-menu">
                                <li><a href="{{ url('/product') }}"
                                        style="text-transform: uppercase;">@lang('messages.products')</a></li>
                                <li><a href="{{ url('/download') }}"
                                        style="text-transform: uppercase;">@lang('messages.download')</a></li>
                                <li><a href="{{ url('/track-trace') }}"
                                        style="text-transform: uppercase;">@lang('messages.track_and_trace')</a></li>
                            </ul>
                        </li> --}}
                        {{-- <li class="dropdown {{ request()->is('/service') || request()->is('/faq') ? 'active' : '' }}">
                            <a href="{{ url('/service') }}" data-bs-toggle="dropdown"
                                data-bs-display="static">@lang('messages.service')</a>
                            <ul class="dropdown-menu">
                                <li><a href="{{ url('/service') }}"
                                        style="text-transform: uppercase;">@lang('messages.service')</a></li>
                                <li><a href="{{ url('/faq') }}"
                                        style="text-transform: uppercase;">@lang('messages.qa')</a></li>
                            </ul>
                        </li> --}}
                        {{-- <li class="{{ request()->is('/promotion') ? 'active' : '' }}">
                            <a href="{{ url('/promotion') }}"
                                style="text-transform: uppercase;">@lang('messages.promotion')</a>
                        </li> --}}
                        {{-- <li class="{{ request()->is('/news') ? 'active' : '' }}">
                            <a href="{{ url('/news') }}" style="text-transform: uppercase;">@lang('messages.news')</a>
                        </li> --}}
                        {{-- <li class="{{ request()->is('/contact') ? 'active' : '' }}">
                            <a href="{{ url('/contact') }}" style="text-transform: uppercase;">@lang('messages.contact')</a>
                        </li> --}}
                    </ul>
                </div>
            </div>
        </header>

        <div class="navbar-slider">
            <div class="hgroup">
                <button class="btn btn-icon navbar-toggle" type="button">
                    <span class="group">
                        <span></span>
                        <span></span>
                        <span></span>
                    </span>
                </button>

                <ul class="nav nav-general left">
                    <li>
                        {{-- <div class="followus">
                            <a href="{{ $socialItem->url }}" target="_blank"><img class="svg-js icons"
                                    src="{{ asset('upload/file/social/' . $socialItem->image) }}" alt=""></a>
                        </div> --}}
                    </li>

                    <div class="followus">
                        <a href="#" target="_blank"><img class="svg-js icons"
                                src="{{ asset('img/icons/icon-facebook.svg') }}" alt=""></a>
                        <a href="#" target="_blank"><img class="svg-js icons"
                                src="{{ asset('img/icons/icon-line.svg') }}" alt=""></a>
                        <a href="#" target="_blank"><img class="svg-js icons"
                                src="{{ asset('img/icons/icon-letter.svg') }}" alt=""></a>
                    </div>
            </div>

            <ul class="nav nav-accordion">
                <li>
                    <h5><a href="{{ url('/ ') }}">@lang('messages.home')</a></h5>
                </li>
                <li>
                    <h5><a href="{{ url('/about') }}">@lang('messages.about')</a></h5>
                </li>
                <li>
                    <h5 data-bs-toggle="collapse" data-bs-target="#product-sub"><a
                            href="#">@lang('messages.products')</a>
                    </h5>
                    <div id="product-sub" class="accordion-collapse collapse" data-bs-parent=".nav-accordion">
                        <ul class="nav">
                            <li><a href="product">@lang('messages.products')</a></li>
                            <li><a href="{{ url('/download') }}">@lang('messages.download')</a>
                            </li>
                            <li><a href="track-trace">@lang('messages.track_and_trace')</a></li>
                        </ul>
                    </div>
                </li>
                <li>
                    <h5 data-bs-toggle="collapse" data-bs-target="#service-sub"><a
                            href="{{ url('/service') }}">@lang('messages.service')</a></h5>
                    <div id="service-sub" class="accordion-collapse collapse" data-bs-parent=".nav-accordion">
                        <ul class="nav">
                            <li><a href="{{ url('/service') }}">@lang('messages.service')</a>
                            </li>
                            <li><a href="{{ url('/faq') }}">@lang('messages.qa')</a></li>
                        </ul>
                    </div>
                </li>
                <li>
                    <h5><a href="{{ url('/promotion') }}">@lang('messages.promotion')</a></h5>
                </li>
                <li>
                    <h5><a href="{{ url('/news') }}">@lang('messages.news')</a></h5>
                </li>
                <li>
                    <h5><a href="{{ url('/contact') }}">@lang('messages.contact')</a></h5>
                </li>
            </ul>
        </div>

        @yield('content')

        <footer class="footer">
            <div class="container">
                <div class="cols footer-info">
                    <div class="group">
                        <p>
                            <span class="fs-24">©</span><br class="d-none d-lg-block">
                            2024<br>
                            ALL RIGHTS RESERVED
                        </p>
                        <hr>
                        <p>
                            KMUTNB<br class="d-none d-lg-block">
                            THAILAND
                        </p>
                    </div>
                </div><!--cols-->
                <div class="cols footer-links">
                    <div class="group">
                        <ul class="nav">
                            <li><a href="{{ url('/about') }}">@lang('messages.about')</a></li>
                            <li><a href="{{ url('/products') }}">@lang('messages.products')</a>
                            </li>
                            <li><a href="{{ url('/service') }}">@lang('messages.service')</a>
                            </li>
                        </ul>

                        <ul class="nav">
                            <li><a href="{{ url('/promotion') }}">@lang('messages.promotion')</a>
                            </li>
                            <li><a href="{{ url('/news') }}">@lang('messages.news')</a></li>
                            <li><a href="{{ url('/contact') }}">@lang('messages.contact')</a>
                            </li>
                        </ul>

                        <ul class="nav">
                            <li><a href="{{ url('/term-condition') }}">@lang('messages.term_and_condition')</a>
                            </li>
                            <li><a href="{{ url('/privacy-policy') }}">@lang('messages.privacy_policy')</a>
                            </li>
                        </ul>
                    </div>
                </div><!--cols-->
                <div class="cols footer-contact">
                    <div class="group">

                        <div class="followus">
                            {{-- @foreach ($social as $socialItem)
                                <a href="{{ strip_tags($socialItem->html) }}" target="_blank"><img
                                        class="svg-js icons"
                                        src="{{ asset('upload/file/social/' . $socialItem->image) }}"
                                        alt=""></a>
                            @endforeach --}}
                        </div>

                        <ul class="nav nav-contact in-content" style="margin-top: -30px;">
                            <li>
                                <img class="icons" src="{{ asset('img/icons/icon-map.svg') }}" alt="">
                                <span>{{ $contact->address ?? null }}</span>
                            </li>

                            <li>
                                <img class="icons" src="{{ asset('img/icons/icon-call.svg') }}" alt="">
                                <a href="tel:{{ $contact->phone ?? null }}">{{ $contact->phone ?? null }}</a>

                            </li>

                            <li>
                                <img class="icons" src="{{ asset('img/icons/icon-notebook.svg') }}" alt="">
                                <a href="tel:{{ $contact->fax ?? null }}">{{ $contact->fax ?? null }}</a>
                            </li>

                            <li>
                                <img class="icons" src="{{ asset('img/icons/icon-sms.svg') }}" alt="">
                                <a href="mailto:{{ $contact->email ?? null }}">{{ $contact->email ?? null }}</a>
                            </li>
                        </ul>

                    </div><!--group-->
                </div><!--cols-->
            </div><!--container-->

            <div class="totop">
                <a class="icons" href="#">
                    <img class="svg-js" src="{{ asset('img/icons/icon-totop.svg') }}" alt="">
                </a>
            </div>
        </footer>

        <div id="cookiePolicyPopup" class="cookie-policy">
            <div class="container-fluid">
                <div class="cols">
                    <h6>@lang('messages.website_privacy_policy')</h6>
                    <p>@lang('messages.website_experience_improvement')<br class="d-none d-lg-block">
                        @lang('messages.confirm_permission')<a href="#">@lang('messages.privacy_policy')</a></p>
                </div>

                <div class="cols">
                    <div class="buttons">
                        <button class="btn btn-secondary accept" type="button">@lang('messages.accept')</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/jquery-3.4.1.min.js') }}" defer></script>
    <script src="{{ asset('js/bootstrap/popper.min.js') }}" defer></script>
    <script src="{{ asset('js/bootstrap/bootstrap.min.js') }}" defer></script>
    <script src="{{ asset('js/jquery.fancybox.js') }}" defer></script>
    <script src="{{ asset('js/swiper.js') }}" defer></script>
    <script src="{{ asset('js/aos.js') }}" defer></script>
    <script src="{{ asset('js/jquery.scrollbar.js') }}" defer></script>
    <script src="{{ asset('js/custom.js') }}" defer></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <script>
        function setCookie(name, value, days) {
            var expires = "";
            if (days) {
                var date = new Date();
                date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
                expires = "; expires=" + date.toUTCString();
            }
            document.cookie = name + "=" + (value || "") + expires + "; path=/";
        }

        function getCookie(name) {
            var nameEQ = name + "=";
            var ca = document.cookie.split(';');
            for (var i = 0; i < ca.length; i++) {
                var c = ca[i];
                while (c.charAt(0) == ' ') c = c.substring(1, c.length);
                if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);
            }
            return null;
        }

        function eraseCookie(name) {
            document.cookie = name + '=; Max-Age=-86400';
        }

        $(document).ready(function() {
            if (getCookie('cookieAccepted')) {
                $('#cookiePolicyPopup').hide();
            }
            $('.accept').on('click', function() {
                setCookie('cookieAccepted', 'true', 1);
                $('#cookiePolicyPopup').hide();
            });
        });
    </script>
    <script>
        function confirmLogout(event) {
            event.preventDefault();
            Swal.fire({
                title: '@lang('messages.are_you_sure')',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: '@lang('messages.ok')',
                cancelButtonText: '@lang('messages.cancel')',
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('logout-form').submit();
                }
            });
        }
    </script>
</body>

</html>
@yield('script')
