@extends('main')
@section('title')
@endsection
@section('stylesheet')
@endsection
@section('content')
    <div class="section p-0">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url(app()->getLocale() . '/ ') }}">@lang('messages.home')</a></li>
                <li class="breadcrumb-item active">@lang('messages.contact')</li>
            </ol>

            <h1 class="title-xl text-underline">@lang('messages.contact')</h1>

            <div class="p-3"></div>

            <div class="row g-4 align-items-xl-center">
                <div class="col-lg-6">
                    <img class="w-100 rounded-16" src="{{ asset('img/thumb/photo-w1200.jpg') }}" alt="" />
                </div>
                <!--col-lg-6-->
                <div class="col-lg-6">
                    <div class="boxed contact me-0" style="--width: 440px">
                        <img class="logo-contact" src="{{ asset('img/logo.png') }}" alt="" />

                        <ul class="nav nav-contact in-content">
                            <li>
                                <img class="icons" src="{{ asset('img/icons/icon-map-2.svg') }}" alt="" />
                                <div>
                                    <h4>@lang('messages.address')</h4>
                                    {{ $contact->address ?? null }}
                                </div>
                            </li>

                            <li>
                                <img class="icons" src="{{ asset('img/icons/icon-call-2.svg') }}" alt="" />
                                <div>
                                    <h4>@lang('messages.phone')</h4>
                                    <a href="tel:{{ $contact->phone ?? null }}">{{ $contact->phone ?? null }}</a>
                                </div>
                            </li>

                            <li>
                                <img class="icons" src="{{ asset('img/icons/icon-notebook-2.svg') }}" alt="" />
                                <div>
                                    <h4>@lang('messages.fax')</h4>
                                    <a href="tel:{{ $contact->fax ?? null }}">{{ $contact->fax ?? null }}</a>
                                </div>
                            </li>

                            <li>
                                <img class="icons" src="{{ asset('img/icons/icon-sms-2.svg') }}" alt="" />
                                <div>
                                    <h4>@lang('messages.email')</h4>
                                    <a href="mailto:info@uandvholding.com">{{ $contact->email ?? null }}</a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <!--col-lg-6-->
            </div>
            <!--row-->

            <div class="p-4"></div>

            <h2 class="title-xl text-center mb-4">@lang('messages.contact_us')</h2>

            <form class="row g-4 gx-xl-5">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="title">@lang('messages.name')</label>
                        <input type="text" class="form-control" placeholder="@lang('messages.input_name')" />
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label class="title">@lang('messages.subject')</label>
                        <input type="text" class="form-control" placeholder="@lang('messages.input_subject')" />
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label class="title">@lang('messages.email')</label>
                        <input type="text" class="form-control" placeholder="@lang('messages.input_email')" />
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label class="title">@lang('messages.phone_number')</label>
                        <input type="text" class="form-control" placeholder="@lang('messages.input_phone')" pattern="[0-9]*" />
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label class="title">@lang('messages.attachment')</label>
                        <div class="file-upload-group mt-2">
                            <input type="file" name="file" id="file" class="input-file" />
                            <label for="file" class="btn js-labelFile">
                                <i class="icons icon-upload"></i>
                                <span class="js-fileName">@lang('messages.upload_file')</span>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label class="title">@lang('messages.message')</label>
                        <textarea class="form-control" placeholder="@lang('messages.input_message')"></textarea>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="recaptcha">
                        <img class="w-100" src="{{ asset('img/thumb/recaptcha.png') }}" alt="" />
                    </div>
                </div>

                <div class="col-md-6 d-flex">
                    <button class="btn ms-md-auto mt-auto w-170">@lang('messages.send')</button>
                </div>
            </form>

            <div class="p-5"></div>
        </div>
        <!--container-->
    </div>
    <!--section-->
@endsection
@section('script')
@endsection
