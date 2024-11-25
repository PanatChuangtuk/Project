@extends('main')
@section('title')
    @lang('messages.term_and_condition')
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
                            <li class="active">
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
                    <article class="boxed fs-18" style="--width: 880px">
                        <div class="hgroup py-4 text-center">
                            <h2 class="title-xl fw-600 text-secondary">
                                @lang('messages.term_and_conditions')
                            </h2>
                            <p class="fs-14 text-secondary mb-0">
                                @lang('messages.terms_and_conditions')
                            </p>
                        </div>

                        <p>
                            Lorem ipsum dolor sit amet consectetur. Quis suscipit ac
                            cras ultrices massa rutrum consectetur. Nisl proin amet
                            nec et urna venenatis dictum. A posuere egestas dolor
                            enim adipiscing vitae sed. Cursus donec aliquam etiam
                            ullamcorper sit elit cras leo sagittis. Orci diam
                            viverra ut ultricies adipiscing netus nunc rhoncus
                            blandit. Phasellus dui enim hendrerit arcu. Quam non
                            fusce sociis facilisi nec egestas. Nulla quis senectus
                            nibh rutrum sit et imperdiet ut. In habitant elit
                            blandit lorem. Ac fermentum tempor at aliquam amet
                            rhoncus mauris. Consectetur iaculis tristique aliquet
                            elementum diam. Sed elit varius pulvinar interdum ac.
                            Interdum facilisis lectus orci vestibulum. Tellus
                            adipiscing dapibus sit velit integer. Ac sollicitudin
                            eleifend sit quisque ultrices. Nulla leo ultrices mauris
                            bibendum libero morbi. Ipsum lacus tellus lacus arcu
                            tortor. Arcu amet at aliquam tincidunt aliquet in
                            fringilla viverra. Eget mi urna ut scelerisque massa
                            enim convallis id. Id amet urna sed molestie elementum.
                            Nisl at libero consequat dictum libero. Dui mauris
                            luctus ut ullamcorper tellus quis tincidunt aliquet
                            viverra. Semper adipiscing consectetur et interdum.
                            Interdum risus sed convallis elementum auctor ut
                            elementum non. Porttitor vitae venenatis nisi sed quis
                            eleifend venenatis lacus duis. Gravida felis urna
                            ultricies erat. A pellentesque eget vel faucibus enim
                            elementum sed dui amet. Vulputate egestas quis diam
                            odio. Duis eget rutrum consequat erat egestas vitae
                            egestas. Dictum velit varius molestie ligula eu volutpat
                            enim leo.
                        </p>

                        <p>
                            Iaculis elit tellus arcu lacus erat in nunc. Tellus
                            aliquet commodo imperdiet sed diam. Mauris dictum urna
                            imperdiet tristique egestas. Ultrices id in nec sit. Id
                            nulla sit nisl lobortis sed nisl mauris et. Nunc platea
                            maecenas hendrerit odio. Euismod ac tempor iaculis id
                            etiam volutpat nisl. Consectetur scelerisque feugiat vel
                            elit tellus quam mattis in. Quisque nunc justo mi magna
                            fringilla nunc accumsan lacus dui. Rhoncus pellentesque
                            blandit id imperdiet ac. Posuere tempor convallis neque
                            commodo et auctor etiam dapibus. Leo ullamcorper varius
                            neque quis iaculis. Pharetra odio diam vel tincidunt
                            morbi.
                        </p>
                    </article>
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
    <script>
        // var myModal = new bootstrap.Modal(document.getElementById('choseCouponModal'))
        // myModal.show();

        $(".form-control.digit").val("");
        $(".form-control.digit").keyup(function() {
            if ($(this).val()) {
                $(this).addClass("active");
            } else {
                $(this).removeClass("active");
            }

            if (this.value.length == this.maxLength) {
                $(this).next(".digit").focus();
            }
        });

        $(".numbersOnly").keypress(function(e) {
            if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                return false;
            }
        });
    </script>
@endsection
