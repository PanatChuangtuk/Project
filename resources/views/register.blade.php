@extends('main')
@section('title')
    @lang('messages.register')
@endsection
@section('stylesheet')
@endsection
@section('content')
    <div class="section">
        <div class="container">
            <div class="hgroup pb-4">
                <h2>@lang('messages.register')</h2>
                <p class="fs-14 text-secondary m-0">@lang('messages.create_new_profile')</p>
            </div>

            <form class="form" method="post" action="{{ route('register.submit', ['lang' => app()->getLocale()]) }}">
                @csrf
                <div class="row form-row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="title">@lang('messages.username')<span class="star">*</span></label>
                            <input type="text" name="username" class="form-control" placeholder="@lang('messages.input_username')"
                                value="{{ old('username') }}" />
                            @error('username')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="title">@lang('messages.email')<span class="star">*</span></label>
                            <input type="email" name="email" class="form-control" placeholder="@lang('messages.input_email')"
                                value="{{ old('email') }}" />
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
                            <input type="text" name="first_name" class="form-control" placeholder="@lang('messages.input_firstname')"
                                value="{{ old('first_name') }}" />
                            @error('first_name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="title">@lang('messages.lastname')<span class="star">*</span></label>
                            <input type="text" name="last_name" class="form-control" placeholder="@lang('messages.input_lastname')"
                                value="{{ old('last_name') }}" />
                            @error('last_name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="title">@lang('messages.mobile_phone')</label>
                            <input type="text" class="form-control" placeholder="@lang('messages.input_phone')" name="mobile_phone"
                                maxlength="10" value="{{ old('mobile_phone') }}" />
                            @error('mobile_phone')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="title">@lang('messages.company')</label>
                            <input type="text" class="form-control" placeholder="@lang('messages.input_company')" name="company"
                                value="{{ old('company') }}" />
                            @error('company')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="title">Line ID</label>
                            <input type="text" class="form-control" placeholder="Line ID" name="line_id"
                                value="{{ old('line_id') }}" />
                            @error('line_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="title">@lang('messages.vat_register_number')</label>
                            <input type="text" class="form-control" placeholder="@lang('messages.input_vat_number')"
                                name="vat_register_number" maxlength="13" value="{{ old('vat_register_number') }}" />
                            @error('vat_register_number')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="form-group my-4">
                            <label class="title pb-3">@lang('messages.account_type')<span class="star">*</span></label>

                            <div class="form-check mb-2">
                                <input class="form-check-input xs" type="radio" name="account_type" value="government"
                                    id="check1" {{ old('account_type') == 'government' ? 'checked' : '' }} />
                                <label class="form-check-label text-black fs-14" for="check1">
                                    <strong>@lang('messages.government')</strong>
                                </label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input xs" type="radio" name="account_type" value="private"
                                    id="check2" {{ old('account_type') == 'private' ? 'checked' : '' }} />
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
                    </div>

                    <div class="alert alert-danger" id="error-message" style="display: none;">
                        @lang('messages.select_yes_newsletter')
                    </div>

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
@endsection
@section('script')
    <script>
        function validateForm() {
            const newsletterChecked = document.querySelector('input[name="newsletter"]:checked');
            const errorMessage = document.getElementById('error-message');

            if (!newsletterChecked) {
                errorMessage.style.display = 'block';
                return false;
            } else {
                errorMessage.style.display = 'none';
            }

            return true;
        }
    </script>
    <script src="https://www.google.com/recaptcha/api.js?hl={{ app()->getLocale() }}" async defer></script>
@endsection
