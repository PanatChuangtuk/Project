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

            <x-nav-profile />
            <!--sidebar-->

            <div class="content">
                <div class="card-info main px-5">
                    <div class="avatar-setting">
                        <img class="avatar" src="{{ asset('upload/images/' . $profile->avatar) }}" alt="" />

                    </div>

                    <form class="form pt-3" method="POST" action="{{ route('profile.submit') }}">
                        @csrf
                        <div class="row form-row">
                            {{-- <div class="col-md-6">
                                <div class="form-group">
                                    <label class="title">@lang('messages.username')</label>
                                    <input type="text" class="form-control"name="username" 4t
                                        value="{{ $profile->username ?? null }}" />
                                </div>
                            </div> --}}

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
                                        value="{{ $profile->info->mobile_phone ?? null }}" pattern="[0-9]*"
                                        maxlength="10" />
                                    @error('mobile_phone')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="title">Student Number</label>
                                    <input type="text" class="form-control"
                                        value="{{ $profile->info->student->student_number ?? null }}" />
                                </div>
                            </div>

                            {{-- <div class="col-md-6">
                                <div class="form-group">
                                    <label class="title">@lang('messages.company')</label>
                                    <input type="text" value="{{ $profile->company ?? null }}" name="company"
                                        class="form-control" />
                                </div>
                            </div> --}}

                            {{-- <div class="col-md-6">
                                <div class="form-group">
                                    <label class="title">Line ID</label>
                                    <input type="text" value="{{ $profile->line_id ?? null }}" name="line_id"
                                        class="form-control" />
                                </div>
                            </div> --}}

                            {{-- <div class="col-md-6">
                                <div class="form-group">
                                    <label class="title">@lang('messages.vat_register_number')</label>
                                    <input type="text" class="form-control" placeholder="VAT Register Number"
                                        name="vat_register_number" value="{{ $profile->vat_register_number ?? null }}"
                                        maxlength="13" />
                                </div>
                            </div> --}}

                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary" id="confirmSave">@lang('messages.save')</button>
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
