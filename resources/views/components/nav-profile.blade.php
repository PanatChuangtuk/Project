<div class="sidebar">
    <div class="card-info main">
        <div class="title-bar d-flex" data-bs-toggle="collapse" data-bs-target="#navProfile">
            <h1 class="h2 text-capitalize text-underline">@lang('messages.profile')</h1>

            <button class="btn btn-menu" type="button">
                <img class="icons svg-js" src="{{ asset('img/icons/icon-add-plus.svg') }}" alt="" />
            </button>
        </div>

        <ul class="nav nav-profile">
            <li class="{{ Request::is('/profile') ? 'active' : '' }}">
                <a href="{{ url('/profile') }}">
                    <img class="icons" src="{{ asset('img/icons/icon-user.svg') }}" alt="" />
                    @lang('messages.my_account')
                </a>
            </li>

            <li class="{{ Request::is('/equipment') ? 'active' : '' }}">
                <a href="{{ url('/equipment') }}">
                    <img class="icons" src="{{ asset('img/icons/icon-document.svg') }}" alt="" />
                    Equipment
                </a>
            </li>

            <li>
                <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
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
{{-- <li class="{{ Request::is(app()->getLocale() . '/address') ? 'active' : '' }}">
                <a href="{{ url(app()->getLocale() . '/address') }}">
                    <img class="icons" src="{{ asset('img/icons/icon-map-2.svg') }}" alt="" />
                    @lang('messages.address')
                </a>
            </li> --}}
{{-- <li class="{{ Request::is(app()->getLocale() . '/tax-invoice') ? 'active' : '' }}">
                <a href="{{ url(app()->getLocale() . '/tax-invoice') }}">
                    <img class="icons" src="{{ asset('img/icons/icon-map-2.svg') }}" alt="" />
                    @lang('messages.tax_invoice')
                </a>
            </li> --}}
{{-- <li class="{{ Request::is(app()->getLocale() . '/my-purchase') ? 'active' : '' }}">
                <a href="{{ url(app()->getLocale() . '/my-purchase') }}">
                    <img class="icons" src="{{ asset('img/icons/icon-document.svg') }}" alt="" />
                    @lang('messages.my_purchase')
                </a>
            </li> --}}
{{-- <li class="{{ Request::is(app()->getLocale() . '/my-favourite') ? 'active' : '' }}">
                <a href="{{ url(app()->getLocale() . '/my-favourite') }}">
                    <img class="icons" src="{{ asset('img/icons/icon-favorite-2.svg') }}" alt="" />
                    @lang('messages.my_favourite')
                </a>
            </li> --}}
{{-- <li
                class="{{ (Request::is(app()->getLocale() . '/reviews') ? 'active' : '' || Request::is(app()->getLocale() . '/my-reviews')) ? 'active' : '' }}">
                <a href="{{ url(app()->getLocale() . '/reviews') }}">
                    <img class="icons" src="{{ asset('img/icons/icon-star-sharp.svg') }}" alt="" />
                    @lang('messages.my_reviews')
                </a>
            </li> --}}

{{-- <li class="{{ Request::is(app()->getLocale() . '/my-coupon') ? 'active' : '' }}">
                <a href="{{ url(app()->getLocale() . '/my-coupon') }}">
                    <img class="icons" src="{{ asset('img/icons/icon-ticket-discount.svg') }}" alt="" />
                    @lang('messages.my_coupon_point')
                </a>
            </li> --}}
{{-- <li class="{{ Request::is(app()->getLocale() . '/notification') ? 'active' : '' }}">
                <a href="{{ url(app()->getLocale() . '/notification') }}">
                    <img class="icons" src="{{ asset('img/icons/icon-bell-2.svg') }}" alt="" />
                    @lang('messages.notification')
                </a>
            </li> --}}
{{-- <li
                class="{{ Request::is(app()->getLocale() . '/change-password') || Request::is(app()->getLocale() . '/set-new-password-2') ? 'active' : '' }}">
                <a href="{{ url(app()->getLocale() . '/change-password') }}">
                    <img class="icons" src="{{ asset('img/icons/icon-user.svg') }}" alt="" />
                    @lang('messages.change_password')
                </a>
            </li> --}}
{{-- <li class="{{ Request::is(app()->getLocale() . '/term-condition') ? 'active' : '' }}">
                <a href="{{ url(app()->getLocale() . '/term-condition') }}">
                    <img class="icons" src="{{ asset('img/icons/icon-note.svg') }}" alt="" />
                    @lang('messages.term_and_condition')
                </a>
            </li> --}}
{{-- <li class="{{ Request::is(app()->getLocale() . '/privacy-policy') ? 'active' : '' }}">
                <a href="{{ url(app()->getLocale() . '/privacy-policy') }}">
                    <img class="icons" src="{{ asset('img/icons/icon-shield-tick.svg') }}" alt="" />
                    @lang('messages.privacy_policy')
                </a>
            </li> --}}
