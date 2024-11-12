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
                <li class="breadcrumb-item">Cart</li>
            </ol>

            <div class="hgroup py-3 w-100">
                <h1 class="h2 text-capitalize text-underline">Cart</h1>
            </div>

            <div class="content">
                <div class="table-boxed">
                    <ul class="ul-table ul-table-header cart">
                        <li class="checker">
                            <input type="checkbox" class="form-check-input">
                        </li>

                        <h6 class="d-block d-sm-none">Product</h6>
                    </ul>

                    <ul class="ul-table ul-table-body cart">
                        <li class="checker">
                            <input type="checkbox" class="form-check-input">
                        </li>
                        <li class="photo">
                            <img src="img/thumb/photo-400x455--1.jpg" alt="">
                        </li>
                        <li class="info">
                            <a class="product-info" href="product-detail.html">
                                <h3>(+)-1,2-Bis[(2R,5R)-2,5-diethyl -1-phospholanyl]ethane, 97+%</h3>
                                <label class="label">Size : 5G (Code: ALF-J63245.06 )</label>
                                <p><small>Model : DAE-1217-2304</small></p>
                            </a>
                        </li>
                        <li class="qty">
                            <div class="qty-item">
                                <button type="button" class="btn sub"> </button>
                                <input class="form-control count" type="text" value="0" min="1"
                                    max="100" />
                                <button type="button" class="btn add"></button>
                            </div>
                        </li>
                        <li class="price"><strong>7,169.00฿</strong></li>
                        <li class="total"><strong>14,338.00฿</strong></li>
                        <li class="action">
                            <button class="btn btn-action btn-trans">
                                <img class="icons svg-js red" src="img/icons/icon-trash.svg" alt="">
                            </button>
                        </li>
                    </ul>

                    <ul class="ul-table ul-table-body cart">
                        <li class="checker">
                            <input type="checkbox" class="form-check-input">
                        </li>
                        <li class="photo">
                            <img src="img/thumb/photo-400x455--2.jpg" alt="">
                        </li>
                        <li class="info">
                            <a class="product-info" href="product-detail.html">
                                <h3>(+)-1,2-Bis[(2R,5R)-2,5-diethyl
                                    -1-phospholanyl]ethane, 97+%</h3>
                                <label class="label">Size : 5G (Code: ALF-J63245.06 )</label>
                                <p><small>Model : DAE-1217-2304</small></p>
                            </a>
                        </li>
                        <li class="qty">
                            <div class="qty-item">
                                <button type="button" class="btn sub"> </button>
                                <input class="form-control count" type="text" value="0" min="1"
                                    max="100" />
                                <button type="button" class="btn add"></button>
                            </div>
                        </li>
                        <li class="price"><strong>7,169.00฿</strong></li>
                        <li class="total"><strong>14,338.00฿</strong></li>
                        <li class="action">
                            <button class="btn btn-action btn-trans">
                                <img class="icons svg-js red" src="img/icons/icon-trash.svg" alt="">
                            </button>
                        </li>
                    </ul>

                    <ul class="ul-table ul-table-body cart">
                        <li class="checker">
                            <input type="checkbox" class="form-check-input">
                        </li>
                        <li class="photo">
                            <img src="img/thumb/photo-400x455--1.jpg" alt="">
                        </li>
                        <li class="info">
                            <a class="product-info" href="product-detail.html">
                                <h3>(+)-1,2-Bis[(2R,5R)-2,5-diethyl
                                    -1-phospholanyl]ethane, 97+%</h3>
                                <label class="label">Size : 5G (Code: ALF-J63245.06 )</label>
                                <p><small>Model : DAE-1217-2304</small></p>
                            </a>
                        </li>
                        <li class="qty">
                            <div class="qty-item">
                                <button type="button" class="btn sub"> </button>
                                <input class="form-control count" type="text" value="0" min="1"
                                    max="100" />
                                <button type="button" class="btn add"></button>
                            </div>
                        </li>
                        <li class="price"><strong>7,169.00฿</strong></li>
                        <li class="total"><strong>14,338.00฿</strong></li>
                        <li class="action">
                            <button class="btn btn-action btn-trans">
                                <img class="icons svg-js red" src="img/icons/icon-trash.svg" alt="">
                            </button>
                        </li>
                    </ul>

                    <ul class="ul-table ul-table-body cart">
                        <li class="checker">
                            <input type="checkbox" class="form-check-input">
                        </li>
                        <li class="photo">
                            <img src="img/thumb/photo-400x455--2.jpg" alt="">
                        </li>
                        <li class="info">
                            <a class="product-info" href="product-detail.html">
                                <h3>(+)-1,2-Bis[(2R,5R)-2,5-diethyl
                                    -1-phospholanyl]ethane, 97+%</h3>
                                <label class="label">Size : 5G (Code: ALF-J63245.06 )</label>
                                <p><small>Model : DAE-1217-2304</small></p>
                            </a>
                        </li>
                        <li class="qty">
                            <div class="qty-item">
                                <button type="button" class="btn sub"> </button>
                                <input class="form-control count" type="text" value="0" min="1"
                                    max="100" />
                                <button type="button" class="btn add"></button>
                            </div>
                        </li>
                        <li class="price"><strong>7,169.00฿</strong></li>
                        <li class="total"><strong>14,338.00฿</strong></li>
                        <li class="action">
                            <button class="btn btn-action btn-trans">
                                <img class="icons svg-js red" src="img/icons/icon-trash.svg" alt="">
                            </button>
                        </li>
                    </ul>
                </div><!--table-boxed"-->
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
                            <td colspan="2">
                                <hr>
                            </td>
                        </tr>
                        <tr class="total">
                            <td>Total </td>
                            <td class="number">31,135.56 ฿</td>
                        </tr>
                    </table>

                    <div class="buttons flex-column pb-0 pt-4">
                        <a class="btn btn-48" href="cart-check-out.html">
                            <span class="fs-13">Continue</span>
                        </a>
                        <a class="btn btn-48 btn-outline" href="product.html">
                            <span class="fs-13">Add Product</span>
                        </a>
                    </div>
                </div><!--card-info-->

                <div class="card-info d-flex">
                    <h3 class="fs-15">Point</h3>
                    <span class="fs-15 ms-auto" style="color:#FFCA38;">+ 17 Point</span>
                </div><!--card-info-->

                <div class="card-info">
                    <div class="card-header">
                        <h3 class="title-icon fs-18">
                            <img class="icons" src="img/icons/icon-ticket.svg" alt="">
                            Coupon Discout
                        </h3>
                    </div>

                    <div class="card-body">
                        <div class="form-group coupon" data-bs-toggle="modal" data-bs-target="#choseCouponModal">
                            <input class="form-control">

                            <button class="btn" type="button">
                                <span class="icons"></span>
                            </button>
                        </div>
                    </div>
                </div><!--card-info-->

                <div class="card-info">
                    <div class="card-header">
                        <h3 class="title-icon fs-18">
                            <img class="icons" src="img/icons/icon-crown.svg" alt="">
                            Point
                        </h3>

                        <div class="d-block ms-auto">
                            <span class="text-warning fs-15">599.50</span>
                            <span class="text-black fs-14">Point</span>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="form-group coupon has-value">
                            <input class="form-control" value="" placeholder="Enter">
                            <div class="label-lists">
                                <label class="label label-discount">-฿500</label>
                            </div>
                            <button class="btn" type="button">
                                <span class="icons"></span>
                            </button>
                        </div>

                        <p class="fs-12 pt-2">10 Point = 1 THB</p>
                    </div>
                </div><!--card-info-->
            </div><!--sidebar-->

        </div><!--container-->
    </div><!--section-->
@endsection

@section('script')
@endsection
