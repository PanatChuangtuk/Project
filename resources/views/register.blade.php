<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale = 1.0, 
maximum-scale=1.0, user-scalable=no" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <title>@yield('title', 'REGISTER') - KMUTNB</title>
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

</head>

<body>
    <div class="page logo-hidden">
        <div class="section">
            <div class="container">
                <div class="hgroup pb-4">
                    <h2>@lang('messages.register')</h2>
                    <p class="fs-14 text-secondary m-0">@lang('messages.create_new_profile')</p>
                </div>

                <form class="form" method="post"
                    action="{{ route('register.submit', ['lang' => app()->getLocale()]) }}">
                    @csrf
                    <div class="row form-row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="title">@lang('messages.username')<span class="star">*</span></label>
                                <input type="text" name="username" class="form-control"
                                    placeholder="@lang('messages.input_username')" value="{{ old('username') }}" />
                                @error('username')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="title">@lang('messages.email')<span class="star">*</span></label>
                                <input type="email" name="email" class="form-control"
                                    placeholder="@lang('messages.input_email')" value="{{ old('email') }}" />
                                @error('email')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="title">@lang('messages.password')<span class="star">*</span></label>
                                <div class="group">
                                    <span class="icons icon-eye right"></span>
                                    <input type="password" class="form-control pw" name="password" id="password"
                                        placeholder="@lang('messages.input_password')" />
                                    @error('password')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="title">@lang('messages.confirm_password')<span class="star">*</span></label>
                                <div class="group">
                                    <span class="icons icon-eye right"></span>
                                    <input type="password" class="form-control pw" name="password_confirmation"
                                        placeholder="@lang('messages.confirm_password')" />
                                    @error('password_confirmation')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="title">@lang('messages.firstname')<span class="star">*</span></label>
                                <input type="text" name="first_name" class="form-control"
                                    placeholder="@lang('messages.input_firstname')" value="{{ old('first_name') }}" />
                                @error('first_name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="title">@lang('messages.lastname')<span class="star">*</span></label>
                                <input type="text" name="last_name" class="form-control"
                                    placeholder="@lang('messages.input_lastname')" value="{{ old('last_name') }}" />
                                @error('last_name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="title">StudentID</label>
                                <input type="text" class="form-control" placeholder="Enter StudentID"
                                    name="student_id" maxlength="10" value="{{ old('student_id') }}" />
                                @error('student_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="title">Adviser</label>
                                <input type="text" class="form-control" placeholder="Enter Adviser"
                                    name="adviser_id" value="{{ old('adviser_id') }}" />
                                @error('adviser_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        {{-- <div class="col-md-6">
                            <div class="form-group">
                                <label class="title">Line ID</label>
                                <input type="text" class="form-control" placeholder="Line ID" name="line_id"
                                    value="{{ old('line_id') }}" />
                                @error('line_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div> --}}

                        {{-- <div class="col-md-6">
                            <div class="form-group">
                                <label class="title">@lang('messages.vat_register_number')</label>
                                <input type="text" class="form-control" placeholder="@lang('messages.input_vat_number')"
                                    name="vat_register_number" maxlength="13"
                                    value="{{ old('vat_register_number') }}" />
                                @error('vat_register_number')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div> --}}

                        {{-- <div class="col-12">
                            <div class="form-group my-4">
                                <label class="title pb-3">@lang('messages.account_type')<span class="star">*</span></label>

                                <div class="form-check mb-2">
                                    <input class="form-check-input xs" type="radio" name="account_type"
                                        value="government" id="check1"
                                        {{ old('account_type') == 'government' ? 'checked' : '' }} />
                                    <label class="form-check-label text-black fs-14" for="check1">
                                        <strong>@lang('messages.government')</strong>
                                    </label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input xs" type="radio" name="account_type"
                                        value="private" id="check2"
                                        {{ old('account_type') == 'private' ? 'checked' : '' }} />
                                    <label class="form-check-label text-black fs-14" for="check2">
                                        <strong>@lang('messages.private')</strong>
                                    </label>
                                </div>
                                @error('account_type')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        {!! NoCaptcha::display() !!}
                        @error('g-recaptcha-response')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                        <div class="col-12">
                            <div class="form-check mt-3">
                                <input class="form-check-input" type="radio" value="1" id="check3"
                                    name="newsletter" {{ old('newsletter') == '1' ? 'checked' : '' }} required />
                                <label class="form-check-label fs-14" for="check3">
                                    @lang('messages.newsletter_consent')
                                </label>
                            </div>
                            @error('newsletter')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div> --}}

                        {{-- <div class="alert alert-danger" id="error-message" style="display: none;">
                            @lang('messages.select_yes_newsletter')
                        </div> --}}

                        <div class="col-12 d-flex py-3">
                            <button class="btn mx-auto" type="submit" onclick="return validateForm();">
                                <span class="px-5">@lang('messages.register')</span>
                            </button>
                        </div>
                    </div>
                    <!--row-->
                </form>
            </div>
            <!--container-->
        </div>
        <!--section-->
        <!--section-->
        {{-- <footer class="footer">
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
                </div><!--cols--> --}}
        {{-- <div class="cols footer-contact">
                    <div class="group">

                        <div class="followus"> --}}
        {{-- @foreach ($social as $socialItem)
                                <a href="{{ strip_tags($socialItem->html) }}" target="_blank"><img
                                        class="svg-js icons"
                                        src="{{ asset('upload/file/social/' . $socialItem->image) }}"
                                        alt=""></a>
                            @endforeach --}}
        {{-- </div>

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

    {{-- </div><!--group-->
    </div><!--cols-->
    </div><!--container--> --}}

        {{-- <div class="totop">
                <a class="icons" href="#">
                    <img class="svg-js" src="{{ asset('img/icons/icon-totop.svg') }}" alt="">
                </a>
            </div>
        </footer> --}}

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
