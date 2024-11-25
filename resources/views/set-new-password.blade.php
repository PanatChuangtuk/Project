@extends('main') @section('title')
    @lang('messages.setup_new_password')
    @endsection @section('stylesheet')
    @endsection @section('content')
    <div class="section section-column">
        <div class="container">
            <div class="row row-main">
                <div class="cols col-photo" data-aos="fade-in">
                    <img src="{{ asset('img/thumb/photo-1000x965--1.jpg') }}" alt="" />
                </div>
                <!--cols-->
                <div class="cols col-form" data-aos="fade-in">
                    <div class="boxed me-lg-0">
                        <div class="article pb-3" style="--font-size: 14px; --color: #375b51">
                            <h2>@lang('messages.setup_new_password')</h2>

                            <p>@lang('messages.password_must_be_at_least_8_characters')</p>
                        </div>
                        <form action="{{ route('login.reset.password.submit', ['lang' => app()->getLocale()]) }}"
                            method="POST">
                            @csrf

                            <div class="row g-4">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="title">@lang('messages.new_password')</label>
                                        <div class="group mb-3">
                                            <span class="icons icon-eye right"></span>
                                            <input type="password" class="form-control pw" name="password" id="password"
                                                placeholder="@lang('messages.password_field_required')" />
                                        </div>
                                        @error('password')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="title">@lang('messages.confirm_password')
                                        </label>
                                        <div class="group mb-3">
                                            <span class="icons icon-eye right"></span>
                                            <input type="password" class="form-control pw" name="password_confirmation"
                                                id="password_confirmation" placeholder="@lang('messages.password_field_required')" />
                                        </div>
                                        @error('password')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-12 d-flex pt-sm-4">
                                    <button class="btn px-5 ms-auto me-sm-0 me-auto" type="submit"
                                        data-bs-target="#successModal" data-bs-toggle="modal">
                                        <span class="px-3">@lang('messages.confirm')</span>
                                    </button>
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
    @endsection @section('script')
    <script>
        // var myModal = new bootstrap.Modal(document.getElementById('successModal'))
        // myModal.show();
        $("#successModal").on("hidden.bs.modal", function(e) {
            window.location.href = "login.html";
        });
    </script>
@endsection
