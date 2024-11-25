@extends('main')
@section('title')
    @lang('messages.otp_verification')
@endsection
@section('stylesheet')
    <style>
        .uppercase {
            text-transform: uppercase;
        }
    </style>
@endsection
@section('content')
    <div class="section section-column">
        <div class="container">
            <div class="row row-main">
                <div class="cols col-photo" data-aos="fade-in">
                    <img src="{{ asset('img/thumb/photo-1000x965--1.jpg') }}" alt="" />
                </div>
                <!--cols-->
                <div class="cols col-form" data-aos="fade-in">
                    <div class="boxed me-lg-0">
                        <form class="form form-otp" method="post" action="#">
                            <div class="article pb-3" style="--font-size: 14px; --color: #375b51">
                                <h2 class="uppercase">@lang('messages.otp_verification')</h2>

                                <p>
                                    @lang('messages.check_phone_verification')
                                </p>
                            </div>

                            <div class="row g-3">
                                <div class="col-12">
                                    <h5 class="fs-14 text-black">@lang('messages.otp_code')</h5>
                                </div>

                                <div class="col-12">
                                    <div class="form-otp-group">
                                        <input type="text" class="form-control digit numbersOnly" maxlength="1"
                                            pattern="[0-9]*" inputmode="numeric" name="" />
                                        <input type="text" class="form-control digit numbersOnly" maxlength="1"
                                            pattern="[0-9]*" inputmode="numeric" name="" />
                                        <input type="text" class="form-control digit numbersOnly" maxlength="1"
                                            pattern="[0-9]*" inputmode="numeric" name="" />
                                        <input type="text" class="form-control digit numbersOnly" maxlength="1"
                                            pattern="[0-9]*" inputmode="numeric" name="" />
                                        <input type="text" class="form-control digit numbersOnly" maxlength="1"
                                            pattern="[0-9]*" inputmode="numeric" name="" />
                                        <input type="text" class="form-control digit numbersOnly last" maxlength="1"
                                            pattern="[0-9]*" inputmode="numeric" name="" />
                                    </div>
                                    <!--form-otp-->
                                </div>

                                <div class="col-12 d-flex fs-14 text-gray font-inter">
                                    <p class="m-0">
                                        <span class="resend">@lang('messages.resend_code')</span>
                                    </p>
                                    <p class="m-0 ms-auto">02:59</p>
                                </div>

                                <div class="col-12 pt-4">
                                    <button class="btn px-4 ms-auto" type="button" data-bs-target="#successModal"
                                        data-bs-toggle="modal">
                                        <span class="px-4">@lang('messages.login')</span>
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
            window.location.href = "index.html";
        });

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
