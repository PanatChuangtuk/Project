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
    <div class="container has-sidebar">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="my-account.html">Profile</a>
            </li>
        </ol>

        <div class="hgroup w-100 d-flex pb-4 mb-1">
            <a href="my-purchase.html" class="btn btn-outline back">
                <img
                    class="svg-js icons"
                    src="img/icons/icon-arrow-back.svg"
                    alt=""
                />
                Back
            </a>
        </div>
        <div class="content">
            <div class="card-info">
                <h3 class="fs-18 mb-2 d-flex">
                    Address
                    <label class="purchase-status topay ms-auto">To Pay</label>
                </h3>

                <div class="d-flex gap-3">
                    <img
                        class="icons mt-1"
                        src="img/icons/icon-map-point.svg"
                        alt=""
                    />
                    <div>
                        <p class="m-0"><strong>ธนดล ดวงมีชัย</strong></p>
                        <p>
                            11 Soi Tansamrit 6/3 Thasai Muang Nonthaburi
                            11000<br />
                            +(66)8-950-7733
                        </p>
                    </div>
                </div>
            </div>
            <!--card-info-->

            <div class="card-info">
                <h3 class="fs-18 mb-2">Products</h3>

                <div class="table-boxed">
                    <ul class="ul-table ul-table-body infos">
                        <li class="photo">
                            <img src="img/thumb/photo-400x455--1.jpg" alt="" />
                        </li>
                        <li class="info">
                            <div class="product-info">
                                <h3>
                                    (+)-1,2-Bis[(2R,5R)-2,5-diethyl
                                    -1-phospholanyl]ethane, 97+%
                                </h3>
                                <label class="label"
                                    >Size : 5G (Code: ALF-J63245.06 )</label
                                >
                                <p><small>Model : DAE-1217-2304</small></p>
                            </div>
                        </li>
                        <li class="qty">
                            <strong class="fs-16 text-black">x2</strong>
                        </li>
                        <li class="total"><strong>14,338.00฿</strong></li>
                    </ul>

                    <ul class="ul-table ul-table-body infos">
                        <li class="photo">
                            <img src="img/thumb/photo-400x455--2.jpg" alt="" />
                        </li>
                        <li class="info">
                            <div class="product-info">
                                <h3>
                                    (+)-1,2-Bis[(2R,5R)-2,5-diethyl
                                    -1-phospholanyl]ethane, 97+%
                                </h3>
                                <label class="label"
                                    >Size : 5G (Code: ALF-J63245.06 )</label
                                >
                                <p><small>Model : DAE-1217-2304</small></p>
                            </div>
                        </li>
                        <li class="qty">
                            <strong class="fs-16 text-black">x1</strong>
                        </li>
                        <li class="total"><strong>7,169.00฿</strong></li>
                    </ul>

                    <ul class="ul-table ul-table-body infos">
                        <li class="photo">
                            <img src="img/thumb/photo-400x455--1.jpg" alt="" />
                        </li>
                        <li class="info">
                            <div class="product-info">
                                <h3>
                                    (+)-1,2-Bis[(2R,5R)-2,5-diethyl
                                    -1-phospholanyl]ethane, 97+%
                                </h3>
                                <label class="label"
                                    >Size : 5G (Code: ALF-J63245.06 )</label
                                >
                                <p><small>Model : DAE-1217-2304</small></p>
                            </div>
                        </li>
                        <li class="qty">
                            <strong class="fs-16 text-black">x1</strong>
                        </li>
                        <li class="total"><strong>7,169.00฿</strong></li>
                    </ul>
                </div>
                <!--table-boxed-->
            </div>
            <!--card-info-->

            <div class="card-info">
                <h3 class="fs-18 mb-3">Shipping</h3>

                <div class="d-flex gap-3">
                    <img
                        class="icons"
                        src="img/icons/icon-delivery-truck.svg"
                        alt=""
                    />
                    <div>
                        <p class="fs-15 text-black m-0">
                            <strong>Shipping Official</strong>
                        </p>
                        <p class="fs-13 text-highlight">
                            Estimated Delivery in 3 - 5 Days
                        </p>
                    </div>

                    <p class="text-secondary ms-auto me-md-4">
                        <strong>50.00฿</strong>
                    </p>
                </div>
            </div>
            <!--card-info-->

            <div class="card-info">
                <h3 class="fs-18 mb-2">
                    Tax Invoice <small class="my-auto ms-2">(Optional)</small>
                </h3>

                <div class="d-flex gap-3">
                    <img
                        class="icons mt-1"
                        src="img/icons/icon-map-point.svg"
                        alt=""
                    />
                    <div>
                        <p class="m-0"><strong>ธนดล ดวงมีชัย</strong></p>
                        <p>
                            11 Soi Tansamrit 6/3 Thasai Muang Nonthaburi
                            11000<br />
                            +(66)8-950-7733
                        </p>
                    </div>
                </div>
            </div>
            <!--card-info-->

            <div class="card-info">
                <h3 class="fs-18 mb-2">Payment</h3>

                <div class="form-check payment">
                    <input
                        class="form-check-input"
                        type="radio"
                        id="credit"
                        name="payment"
                        checked
                    />
                    <label class="form-check-label" for="credit">
                        Credit/Debit
                        <img
                            class="icon"
                            src="img/icons/icon-creditcard.png"
                            alt=""
                        />
                    </label>
                </div>

                <div class="form-check payment">
                    <input
                        class="form-check-input"
                        type="radio"
                        id="promptpay"
                        name="payment"
                    />
                    <label class="form-check-label" for="promptpay">
                        QR Promptpay
                        <img
                            class="icon"
                            src="img/icons/icon-promptpay.png"
                            alt=""
                        />
                    </label>
                </div>

                <div class="form-check payment">
                    <input
                        class="form-check-input"
                        type="radio"
                        id="po"
                        name="payment"
                    />
                    <label class="form-check-label d-block" for="po">
                        Purchase Order (PO Number)<br />
                        <input
                            type="text"
                            class="form-control bg-white mt-2"
                            placeholder="Enter"
                        />
                    </label>
                </div>
            </div>
            <!--card-info-->
        </div>
        <!--content-->
        <div class="sidebar">
            <div class="card-info">
                <h3 class="fs-18 mb-2">Summary</h3>

                <table class="table-summary">
                    <tr>
                        <td>Subtotal</td>
                        <td class="number">28,676.00 ฿</td>
                    </tr>
                    <tr>
                        <td>VAT 7%</td>
                        <td class="number">2459.56 ฿</td>
                    </tr>
                    <tr>
                        <td>Shipping Free</td>
                        <td class="number">50 ฿</td>
                    </tr>
                    <tr>
                        <td>Discount</td>
                        <td class="number text-danger">-50 ฿</td>
                    </tr>
                    <tr>
                        <td>Point Discount</td>
                        <td class="number text-danger">-50 ฿</td>
                    </tr>

                    <tr>
                        <td colspan="2">
                            <hr />
                        </td>
                    </tr>
                    <tr class="total">
                        <td>Total</td>
                        <td class="number">31,135.56 ฿</td>
                    </tr>
                </table>

                <div class="buttons flex-column pb-0 pt-4">
                    <a class="btn btn-48" href="payment-information.html">
                        <span class="fs-13">Proceed to Check Out</span>
                    </a>
                </div>
            </div>
            <!--card-info-->

            <div class="card-info d-flex">
                <h3 class="fs-15">Point</h3>
                <span class="fs-15 ms-auto" style="color: #ffca38"
                    >+ 17 Point</span
                >
            </div>
            <!--card-info-->

            <div class="card-info">
                <div class="info-row border-bottom-1">
                    <h3 class="fs-15">Status Order :</h3>
                    <p class="fs-14 ms-auto">SH20240000101</p>
                </div>
                <div class="info-row border-0">
                    <p class="fs-13">Place Order :</p>
                    <p class="fs-13 ms-auto">22/09/2023 13:45</p>
                </div>
            </div>
            <!--card-info-->

            <div class="card-info text-center py-4">
                <button
                    class="btn btn-outline-red btn-34 w-100"
                    type="button"
                    style="--bs-btn-bg: #fbfbfb"
                    data-bs-target="#cancelOrderModal"
                    data-bs-toggle="modal"
                >
                    Cancel
                </button>

                <p class="fs-12 fw-300 px-sm-4 mt-3 mb-0">
                    You can request to cancel your order. But it must be within
                    the company's conditions.
                </p>
            </div>
            <!--card-info-->
        </div>
        <!--sidebar-->
    </div>
    <!--container-->
</div>
<!--section-->

@endsection @section('script')
<script>
    // var myModal = new bootstrap.Modal(document.getElementById('cancelOrderModal'))
    // myModal.show();
    $("#successModal").on("hidden.bs.modal", function (e) {
        window.location.href = "my-purchase-cancel.html";
    });
</script>
@endsection
