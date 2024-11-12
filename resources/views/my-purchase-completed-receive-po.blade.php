@extends('main')
@section('title')
@endsection
@section('stylesheet')
@endsection
@section('content')
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
                        alt=""></a>
                <a href="#" target="_blank"><img class="svg-js icons" src="img/icons/icon-line.svg"
                        alt=""></a>
                <a href="#" target="_blank"><img class="svg-js icons" src="img/icons/icon-letter.svg"
                        alt=""></a>
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
                <h5 data-bs-toggle="collapse" data-bs-target="#product-sub"><a href="#">PRODUCTS</a></h5>
                <div id="product-sub" class="accordion-collapse collapse" data-bs-parent=".nav-accordion">
                    <ul class="nav">
                        <li><a href="product.html">PRODUCTS</a></li>
                        <li><a href="download.html">DOWNLOAD</a></li>
                        <li><a href="track-trace.html">Track & Trace</a></li>
                    </ul>
                </div>
            </li>
            <li>
                <h5 data-bs-toggle="collapse" data-bs-target="#service-sub"><a href="#">SERVICE</a></h5>
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

    <div class="section section-cart bg-light pt-0">
        <div class="container has-sidebar">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="my-account.html">Profile</a></li>
            </ol>

            <div class="hgroup w-100 d-flex pb-4 mb-1">
                <a href="my-purchase.html" class="btn btn-outline back">
                    <img class="svg-js icons" src="img/icons/icon-arrow-back.svg" alt="">
                    Back
                </a>
            </div>
            <div class="content">
                <div class="card-info">
                    <h3 class="fs-18 mb-2 d-flex">
                        Address
                        <label class="purchase-status completed ms-auto">Completed</label>
                    </h3>

                    <div class="d-flex gap-3">
                        <img class="icons mt-1" src="img/icons/icon-map-point.svg" alt="">
                        <div>
                            <p class="m-0"><strong>ธนดล ดวงมีชัย</strong></p>
                            <p>11 Soi Tansamrit 6/3 Thasai Muang Nonthaburi 11000<br>
                                +(66)8-950-7733</p>

                        </div>
                    </div>
                </div><!--card-info-->

                <div class="card-info">
                    <h3 class="fs-18 mb-2">
                        Products
                    </h3>

                    <div class="table-boxed">
                        <ul class="ul-table ul-table-body infos">
                            <li class="photo">
                                <img src="img/thumb/photo-400x455--1.jpg" alt="">
                            </li>
                            <li class="info">
                                <div class="product-info">
                                    <h3>(+)-1,2-Bis[(2R,5R)-2,5-diethyl -1-phospholanyl]ethane, 97+%</h3>
                                    <label class="label">Size : 5G (Code: ALF-J63245.06 )</label>
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
                                <img src="img/thumb/photo-400x455--2.jpg" alt="">
                            </li>
                            <li class="info">
                                <div class="product-info">
                                    <h3>(+)-1,2-Bis[(2R,5R)-2,5-diethyl -1-phospholanyl]ethane, 97+%</h3>
                                    <label class="label">Size : 5G (Code: ALF-J63245.06 )</label>
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
                                <img src="img/thumb/photo-400x455--1.jpg" alt="">
                            </li>
                            <li class="info">
                                <div class="product-info">
                                    <h3>(+)-1,2-Bis[(2R,5R)-2,5-diethyl -1-phospholanyl]ethane, 97+%</h3>
                                    <label class="label">Size : 5G (Code: ALF-J63245.06 )</label>
                                    <p><small>Model : DAE-1217-2304</small></p>
                                </div>
                            </li>
                            <li class="qty">
                                <strong class="fs-16 text-black">x1</strong>
                            </li>
                            <li class="total"><strong>7,169.00฿</strong></li>
                        </ul>
                    </div><!--table-boxed-->
                </div><!--card-info-->

                <div class="card-info">
                    <h3 class="fs-18 mb-3">
                        Shipping
                    </h3>

                    <div class="d-flex gap-3">
                        <img class="icons" src="img/icons/icon-delivery-truck.svg" alt="">
                        <div>
                            <p class="fs-15 text-black m-0"><strong>Shipping Official</strong></p>
                            <p class="fs-13 text-highlight">Estimated Delivery in 3 - 5 Days</p>
                        </div>

                        <p class="text-secondary ms-auto me-md-4">
                            <strong>50.00฿</strong>
                        </p>
                    </div>
                </div><!--card-info-->

                <div class="card-info">
                    <h3 class="fs-18 mb-2">
                        Tax Invoice <small class="my-auto ms-2">(Optional)</small>

                    </h3>

                    <div class="d-flex gap-3">
                        <img class="icons mt-1" src="img/icons/icon-map-point.svg" alt="">
                        <div>
                            <p class="m-0"><strong>ธนดล ดวงมีชัย</strong></p>
                            <p>11 Soi Tansamrit 6/3 Thasai Muang Nonthaburi 11000<br>
                                +(66)8-950-7733</p>
                        </div>
                    </div>
                </div><!--card-info-->

                <div class="card-info">
                    <h3 class="fs-18 mb-2">
                        Payment
                    </h3>

                    <div class="form-check payment">
                        <input class="form-check-input" type="radio" id="po" name="payment" checked>
                        <label class="form-check-label d-block" for="po">
                            Purchase Order (PO Number)<br>
                            <div class="po-code">PO1288335434</div>
                        </label>
                    </div>
                </div><!--card-info-->
            </div><!--content-->
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
                                <hr>
                            </td>
                        </tr>
                        <tr class="total">
                            <td>Total </td>
                            <td class="number">31,135.56 ฿</td>
                        </tr>
                    </table>

                    <div class="po-status-block">
                        <img class="icons" src="img/icons/icon-po-status-confirm.svg" alt="">

                        <label class="purchase-status confirmed">
                            Confirmed
                        </label>
                    </div>
                </div><!--card-info-->

                <div class="card-info d-flex">
                    <h3 class="fs-15">Point</h3>
                    <span class="fs-15 ms-auto" style="color:#FFCA38;">+ 17 Point</span>
                </div><!--card-info-->

                <div class="card-info py-2">
                    <div class="info-row border-bottom-1">
                        <div class="d-flex w-100">
                            <h3 class="fs-15">Status Order :</h3>
                            <p class="fs-14 ms-auto"><strong>SH20240000101</strong></p>
                        </div>
                        <div class="d-flex w-100">
                            <h3 class="fs-15">Tacking Number :</h3>
                            <p class="fs-14 ms-auto">
                                <strong>TH102E4C00101</strong>
                                <a class="text-highlight" href="#">Copy</a>
                            </p>
                        </div>
                        <div class="d-flex fs-13 w-100">
                            <p>Shipped with :</p>
                            <p class="ms-auto nowrap">EMS Thai Post</p>
                        </div>
                    </div>
                    <div class="info-row border-0">
                        <div class="d-flex fs-13 w-100">
                            <p>Place Order :</p>
                            <p class="ms-auto nowrap">22/09/2023 13:45</p>
                        </div>

                        <div class="d-flex fs-13 w-100">
                            <p>Paid :</p>
                            <p class="ms-auto nowrap">21/09/2023 14:00</p>
                        </div>

                        <div class="d-flex fs-13 w-100">
                            <p>Wait for shipping :</p>
                            <p class="ms-auto nowrap">21/09/2023 14:01</p>
                        </div>
                        <div class="d-flex fs-13 w-100">
                            <p>บริษัทขนส่งเข้ารับพัสดุแล้ว<br>
                                สมุทรปราการ,บางพลี,บางปลา</p>
                            <p class="ms-auto nowrap">23/09/2023 14:01</p>
                        </div>
                        <div class="d-flex fs-13 w-100">
                            <p>ถูกส่งมอบให้บริษัทขนส่งแล้ว<br>
                                สมุทรปราการ,บางพลี,บางปลา</p>
                            <p class="ms-auto nowrap">23/09/2023 14:01</p>
                        </div>
                        <div class="d-flex fs-13 w-100">
                            <p>พัสดุถึงสาขาปลายทาง<br>
                                กรุงเทพ,บึงกุ่ม,นวมินทร์</p>
                            <p class="ms-auto nowrap">23/09/2023 14:01</p>
                        </div>
                        <div class="d-flex fs-13 w-100">
                            <p>พัสดุอยู่ระหว่างการนำจัดส่ง</p>
                            <p class="ms-auto nowrap">23/09/2023 14:01</p>
                        </div>
                        <div class="d-flex fs-13 w-100 text-success">
                            <p>พัสดุจัดส่งสำเร็จแล้ว</p>
                            <p class="ms-auto nowrap">25/09/2023 17:01</p>
                        </div>
                    </div>
                </div><!--card-info-->

                <div class="card-info text-center py-4">
                    <div class="buttons p-0 flex-column">
                        <button class="btn btn-green btn-34" type="button" data-bs-target="#receiveModal"
                            data-bs-toggle="modal">Receive</button>

                        <a class="btn btn-outline-orange btn-34" href="return-refund.html">Return&Refund</a>
                    </div>


                    <p class="fs-12 fw-300 mt-3 mb-0 text-success">The product has been shipped.<br>
                        Please press to receive the product.</p>
                </div><!--card-info-->

            </div><!--sidebar-->

        </div><!--container-->
    </div><!--section-->
@endsection
@section('script')
@endsection
