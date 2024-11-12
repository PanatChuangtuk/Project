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
            <li class="breadcrumb-item">
                <a href="my-account.html">Profile</a>
            </li>
        </ol>

        <div class="hgroup w-100 d-flex pb-4 mb-1">
            <a href="my-purchase-cancel.html" class="btn btn-outline back">
                <img
                    class="svg-js icons"
                    src="img/icons/icon-arrow-back.svg"
                    alt=""
                />
                Back
            </a>
        </div>
        <div class="card-info py-4 text-center">
            <h3 class="fs-18">Return&Refund</h3>
            <p class="m-0">Please Select Product For Return/Refund</p>
        </div>
        <!--card-info-->

        <div class="card-info">
            <h3 class="fs-18 mb-2">Select Products</h3>

            <div class="table-boxed">
                <ul class="ul-table ul-table-body infos">
                    <li class="checker">
                        <input type="checkbox" class="form-check-input" />
                    </li>
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
                    <li class="checker">
                        <input
                            type="checkbox"
                            class="form-check-input"
                            checked
                        />
                    </li>
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
                    <li class="checker">
                        <input type="checkbox" class="form-check-input" />
                    </li>
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

            <div class="buttons pb-4">
                <a href="return-refund-reason.html" class="btn ms-auto">
                    <span class="px-4">Continue</span>
                </a>
            </div>
        </div>
        <!--card-info-->
    </div>
    <!--container-->
</div>
<!--section-->

@endsection @section('script') @endsection
