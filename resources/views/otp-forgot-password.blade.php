@extends('main') @section('title')
    @endsection @section('stylesheet')
    @endsection @section('content')
    <div class="navbar-slider">
        <div class="hgroup">
            <button class="btn btn-icon navbar-toggle" type="button">
                <span class="group">
                    <span></span>
                    <span></span>
                    <span></span>
                </span>
            </button>

            <div class="followus">
                <a href="#" target="_blank"><img class="svg-js icons" src="img/icons/icon-facebook.svg"
                        alt="" /></a>
                <a href="#" target="_blank"><img class="svg-js icons" src="img/icons/icon-line.svg"
                        alt="" /></a>
                <a href="#" target="_blank"><img class="svg-js icons" src="img/icons/icon-letter.svg"
                        alt="" /></a>
            </div>
        </div>

        <ul class="nav nav-accordion">
            <li>
                <h5><a href="index.html">HOME</a></h5>
            </li>
            <li>
                <h5><a href="about.html">ABOUT</a></h5>
            </li>
            <li>
                <h5 data-bs-toggle="collapse" data-bs-target="#product-sub">
                    <a href="#">PRODUCTS</a>
                </h5>
                <div id="product-sub" class="accordion-collapse collapse" data-bs-parent=".nav-accordion">
                    <ul class="nav">
                        <li><a href="product.html">PRODUCTS</a></li>
                        <li><a href="download.html">DOWNLOAD</a></li>
                        <li><a href="track-trace.html">Track & Trace</a></li>
                    </ul>
                </div>
            </li>
            <li>
                <h5 data-bs-toggle="collapse" data-bs-target="#service-sub">
                    <a href="#">SERVICE</a>
                </h5>
                <div id="service-sub" class="accordion-collapse collapse" data-bs-parent=".nav-accordion">
                    <ul class="nav">
                        <li><a href="service.html">SERVICE</a></li>
                        <li><a href="faq.html">Q&A</a></li>
                    </ul>
                </div>
            </li>
            <li>
                <h5><a href="promotion.html">PROMOTION</a></h5>
            </li>
            <li>
                <h5><a href="news.html">NEWS</a></h5>
            </li>
            <li>
                <h5><a href="contact.html">CONTACT</a></h5>
            </li>
        </ul>
    </div>

    <div class="section section-column">
        <div class="container">
            <div class="row row-main">
                <div class="cols col-photo" data-aos="fade-in">
                    <img src="img/thumb/photo-1000x965--1.jpg" alt="" />
                </div>
                <!--cols-->
                <div class="cols col-form" data-aos="fade-in">
                    <div class="boxed me-lg-0">
                        <form class="form form-otp" method="post" action="#">
                            <div class="article pb-3" style="--font-size: 14px; --color: #375b51">
                                <h2>OTP VERIFICATION</h2>

                                <p>
                                    Please check your Phone number to see the
                                    verification code
                                </p>
                            </div>

                            <div class="row g-3">
                                <div class="col-12">
                                    <h5 class="fs-14 text-black">OTP Code</h5>
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
                                        <span class="resend">Resend Code</span>
                                    </p>
                                    <p class="m-0 ms-auto">02:59</p>
                                </div>

                                <div class="col-12 pt-4">
                                    <button class="btn px-4 ms-auto" type="button" data-bs-target="#successModal"
                                        data-bs-toggle="modal">
                                        <span class="px-4">Login</span>
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
