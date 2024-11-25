@extends('main') @section('title') @endsection @section('stylesheet')
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
            <a href="#" target="_blank"
                ><img
                    class="svg-js icons"
                    src="img/icons/icon-facebook.svg"
                    alt=""
            /></a>
            <a href="#" target="_blank"
                ><img class="svg-js icons" src="img/icons/icon-line.svg" alt=""
            /></a>
            <a href="#" target="_blank"
                ><img
                    class="svg-js icons"
                    src="img/icons/icon-letter.svg"
                    alt=""
            /></a>
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
            <div
                id="product-sub"
                class="accordion-collapse collapse"
                data-bs-parent=".nav-accordion"
            >
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
            <div
                id="service-sub"
                class="accordion-collapse collapse"
                data-bs-parent=".nav-accordion"
            >
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

<div class="section section-cart bg-light pt-0">
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="cart.html">Cart</a></li>
            <li class="breadcrumb-item active">Check Out</li>
        </ol>

        <div class="hgroup d-flex pb-4 mb-1">
            <a href="my-purchase-topay.html" class="btn btn-outline back">
                <img
                    class="svg-js icons"
                    src="img/icons/icon-arrow-back.svg"
                    alt=""
                />
                Back
            </a>
        </div>

        <form class="card-info">
            <div class="card-body px-md-4 py-2">
                <h2 class="text-secondary mb-3">Payment Information</h2>

                <div class="payment-info-boxed boxed">
                    <div class="info-row">
                        <p><strong>Total Payment</strong></p>
                        <p class="text-secondary">
                            <strong>฿ 31,135.56</strong>
                        </p>
                    </div>

                    <hr class="m-0" />

                    <div class="info-row">
                        <img
                            class="icons w-34 my-2"
                            src="img/icons/icon-megaphone.svg"
                            alt=""
                        />
                        <p class="text-orange">
                            <strong>Pay within 14:29 min</strong>
                        </p>
                    </div>

                    <div class="thai-qr-payment">
                        <div class="card-header">
                            <img src="img/thumb/thai-qr-payment.jpg" alt="" />
                        </div>

                        <div class="card-body">
                            <img
                                class="qrcode"
                                src="img/thumb/qrcode.jpg"
                                alt=""
                            />

                            <div
                                class="py-sm-4 py-2 text-center"
                                style="color: #7d848d"
                            >
                                <p class="fs-20" style="color: #3772e9">
                                    <strong>฿ 31,135.56</strong>
                                </p>
                                <p class="fs-14">
                                    <strong>U&V HOLDING THAILAND</strong><br />
                                    Reference no. <strong>SHPK7WV6VRK5</strong>
                                </p>
                            </div>

                            <div
                                class="article fs-14"
                                style="--title-color: #5d6a85; --color: #7d848d"
                            >
                                <h5>Please follow these instruction</h5>

                                <ol>
                                    <li>
                                        TClick on “Save QR Code” button or
                                        screenshot this page.
                                    </li>

                                    <li>
                                        Open Mobile Banking App (or Authorized
                                        3PP APP) on your device.
                                    </li>

                                    <li>
                                        Choose “Scan” or “QR code” icon on app
                                        to scan or upload picture.
                                    </li>

                                    <li>
                                        Attach your QR screenshot and then make
                                        payment, please make sure the recipient
                                        is “U&V HOLDING THAILAND”
                                    </li>

                                    <li>
                                        When successfully making payment, please
                                        manually go back to U&V HOLDING THAILAND
                                        Website and will see payment status
                                        updated. (If payment status is still not
                                        updated, please contact Shopee Customer
                                        Service 02-017-8399)
                                    </li>

                                    <li>
                                        You can scan QR code only once per
                                        transaction. If you need to scan again,
                                        please refresh the QR code.
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                    <!--thai-qr-payment-->

                    <div class="buttons button-confirm my-4">
                        <button
                            class="btn btn-secondary"
                            type="button"
                            data-bs-target="#successPaymentModal"
                            data-bs-toggle="modal"
                        >
                            OK
                        </button>
                    </div>
                </div>
            </div>
            <!--card-body-->
        </form>
        <!--card-info-->
    </div>
    <!--container-->
</div>
<!--section-->

@endsection @section('script')
<script>
    // var myModal = new bootstrap.Modal(document.getElementById('successPaymentModal'))
    // myModal.show();

    $("input[id=personalCheck]").click(function () {
        window.location.href = "cart-request-full-tax-invoice.html";
    });
    // $("input[id=companyCheck]").click(function() {
    //      window.location.href = 'cart-request-full-tax-invoice-2.html';
    // });
</script>
@endsection
