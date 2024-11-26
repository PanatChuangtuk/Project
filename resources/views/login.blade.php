@extends('main')
@section('title')
    @lang('messages.login')
@endsection
@section('stylesheet')
@endsection
@section('content')
    <div class="section section-column">
        <div class="container">
            <div class="row row-main">
                <div class="cols col-photo" data-aos="fade-in">
                    <img src="{{ asset('img/thumb/images.jpg') }}" alt="" />
                </div>
                <!--cols-->
                <div class="cols col-form" data-aos="fade-in">
                    <div class="boxed me-lg-0">
                        <div class="article pb-3" style="--font-size: 14px; --color: #375b51">
                            <h2>@lang('messages.login')</h2>

                            <p>
                                @lang('messages.login_area_info')
                            </p>
                        </div>
                        <form class="form" method="POST" action="{{ route('login.submit') }}">
                            @csrf
                            <div class="row g-4">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="title">@lang('messages.email')/@lang('messages.phone_number')</label>
                                        <input type="text" class="form-control" name="email_or_phone"
                                            value="{{ old('email_or_phone') }}" placeholder="@lang('messages.input_email_or_phone')" />
                                        @error('email_or_phone')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="title">@lang('messages.password')</label>
                                        <div class="group mb-3">
                                            <span class="icons icon-eye right"></span>
                                            <input type="password" class="form-control pw" name="password" id="password"
                                                placeholder="@lang('messages.enter_your_password')" />
                                            @error('password')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <label class="title mb-0"><a
                                                href="{{ url('/otp-forgot-password-login') }}">@lang('messages.forgot_password')</a></label>

                                    </div>
                                </div>

                                <div class="col-12 d-flex pt-sm-4">
                                    <button class="btn px-5 ms-auto me-sm-0 me-auto" type="submit">
                                        <span class="px-3">@lang('messages.login')</span>
                                    </button>
                                </div>

                                <div class="col-12 py-4">
                                    <div class="form-note">
                                        <h6>@lang('messages.dont_have_account')</h6>
                                        <a href="{{ url('/register') }}" class="btn btn-32 btn-light rounded-14">
                                            <span class="fs-14 px-2">@lang('messages.register')</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!--boxed-->
                </div>
                <!--cols-->
            </div>
            <!--row-main-->
        </div>
        <!--container-->
    </div>
    <!--section-->
@endsection
@section('script')
@endsection
