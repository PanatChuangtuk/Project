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
            <div class="card-info py-4 text-center">
                <h3 class="fs-18">Return&Refund</h3>
                <p class="m-0">Please Select Product For Return/Refund</p>
            </div>
            <!--card-info-->

            <div class="card-info">
                <h3 class="fs-18 mb-2">Products Detail</h3>

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
                </div>
                <!--table-boxed-->
            </div>
            <!--card-info-->

            <div class="card-info px-lg-5">
                <h3 class="fs-16 fw-bold my-3">
                    <span class="text-blue">Reason</span>
                </h3>

                <p class="text-black">
                    Ipsum dolor sit amet consectetur. Bibendum tellus imperdiet
                    faucibus felis amet fames ac. Tortor quis pharetra sed
                    faucibus libero pulvinar vestibulum auctor. Lacinia laoreet
                    feugiat ipsum in dignissim etiam. Pharetra laoreet pretium
                    hac aenean ridiculus pellentesque vitae euismod odio.
                </p>

                <h3 class="fs-16 fw-bold pt-4">
                    <span class="text-blue">Details</span>
                </h3>

                <ul class="nav photo-upload-lists">
                    <li>
                        <div
                            class="photo"
                            style="
                                background-image: url(img/thumb/photo-150x150--1.jpg);
                            "
                        ></div>
                    </li>
                    <li>
                        <button class="btn btn-upload" type="button">
                            <span class="icons"></span>
                        </button>
                    </li>
                </ul>

                <p class="fs-14">
                    Image file PNG, JPEG, JPEG size not exceeding 5mb or video
                    size not exceeding 20 mb.
                </p>
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
            </div>
            <!--card-info-->

            <div class="card-info d-flex">
                <h3 class="fs-15">Point</h3>
                <span class="fs-15 ms-auto" style="color: #ffca38"
                    >+ 17 Point</span
                >
            </div>
            <!--card-info-->

            <div class="card-info py-2">
                <div class="info-row border-bottom-1">
                    <div class="d-flex w-100">
                        <h3 class="fs-15">Status Order :</h3>
                        <p class="fs-14 ms-auto">
                            <strong>SH20240000101</strong>
                        </p>
                    </div>
                    <div class="d-flex w-100">
                        <h3 class="fs-15">Tacking Number :</h3>
                        <p class="fs-14 ms-auto">
                            <strong>TH102E4C00101</strong>
                            <a class="text-highlight" href="#">Copy</a>
                        </p>
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
                        <p>
                            บริษัทขนส่งเข้ารับพัสดุแล้ว<br />
                            สมุทรปราการ,บางพลี,บางปลา
                        </p>
                        <p class="ms-auto nowrap">23/09/2023 14:01</p>
                    </div>
                    <div class="d-flex fs-13 w-100">
                        <p>
                            ถูกส่งมอบให้บริษัทขนส่งแล้ว<br />
                            สมุทรปราการ,บางพลี,บางปลา
                        </p>
                        <p class="ms-auto nowrap">23/09/2023 14:01</p>
                    </div>
                    <div class="d-flex fs-13 w-100">
                        <p>
                            พัสดุถึงสาขาปลายทาง<br />
                            กรุงเทพ,บึงกุ่ม,นวมินทร์
                        </p>
                        <p class="ms-auto nowrap">23/09/2023 14:01</p>
                    </div>
                    <div class="d-flex fs-13 w-100">
                        <p>พัสดุอยู่ระหว่างการนำจัดส่ง</p>
                        <p class="ms-auto nowrap">23/09/2023 14:01</p>
                    </div>
                </div>
            </div>
            <!--card-info-->

            <div class="card-info py-2">
                <div class="info-row border-bottom-1">
                    <h3 class="fs-15">Return/Refund</h3>
                </div>
                <div class="info-row border-0">
                    <div class="d-flex fs-13 w-100">
                        <p>Request Return/Refund :</p>
                        <p class="ms-auto nowrap">25/09/2023 13:45</p>
                    </div>

                    <div class="d-flex fs-13 w-100">
                        <p>Wait for Approve :</p>
                        <p class="ms-auto nowrap">-</p>
                    </div>
                </div>
            </div>
            <!--card-info-->
        </div>
        <!--sidebar-->
    </div>
    <!--container-->
</div>
<!--section-->

@endsection @section('script') @endsection
