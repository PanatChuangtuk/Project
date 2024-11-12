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

    <div class="section section-profile bg-light pt-0">
        <div class="container has-sidebar">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">Profile</li>
            </ol>

            <div class="sidebar">
                <div class="card-info main">
                    <div class="title-bar d-flex" data-bs-toggle="collapse" data-bs-target="#navProfile">
                        <h1 class="h2 text-capitalize text-underline">Profile</h1>

                        <button class="btn btn-menu" type="button">
                            <img class="icons svg-js" src="img/icons/icon-add-plus.svg" alt="">
                        </button>
                    </div>

                    <div id="navProfile" class="collapse">
                        <ul class="nav nav-profile">
                            <li>
                                <a href="my-account.html">
                                    <img class="icons" src="img/icons/icon-user.svg" alt="">
                                    My Account
                                </a>
                            </li>
                            <li>
                                <a href="addresses.html">
                                    <img class="icons" src="img/icons/icon-map-2.svg" alt="">
                                    Addresses
                                </a>
                            </li>
                            <li>
                                <a href="tax-invoice.html">
                                    <img class="icons" src="img/icons/icon-map-2.svg" alt="">
                                    Tax Invoice
                                </a>
                            </li>
                            <li>
                                <a href="my-purchase.html">
                                    <img class="icons" src="img/icons/icon-document.svg" alt="">
                                    My Purchase
                                </a>
                            </li>
                            <li>
                                <a href="my-favourite.html">
                                    <img class="icons" src="img/icons/icon-favorite-2.svg" alt="">
                                    My Favourite
                                </a>
                            </li>
                            <li>
                                <a href="reviews.html">
                                    <img class="icons" src="img/icons/icon-star-sharp.svg" alt="">
                                    My Reviews
                                </a>
                            </li>
                            <li class="active">
                                <a href="my-coupon.html">
                                    <img class="icons" src="img/icons/icon-ticket-discount.svg" alt="">
                                    My Coupon & Point
                                </a>
                            </li>
                            <li>
                                <a href="notification.html">
                                    <img class="icons" src="img/icons/icon-bell-2.svg" alt="">
                                    Notification
                                </a>
                            </li>
                            <li>
                                <a href="change-password.html">
                                    <img class="icons" src="img/icons/icon-user.svg" alt="">
                                    Change Password
                                </a>
                            </li>
                            <li>
                                <a href="term-condition.html">
                                    <img class="icons" src="img/icons/icon-note.svg" alt="">
                                    Term and Condition
                                </a>
                            </li>
                            <li>
                                <a href="privacy-policy.html">
                                    <img class="icons" src="img/icons/icon-shield-tick.svg" alt="">
                                    Privacy Policy
                                </a>
                            </li>
                            <li>
                                <a href="#logoutModal" data-bs-toggle="modal">
                                    <img class="icons" src="img/icons/icon-logout.svg" alt="">
                                    Sign Out
                                </a>
                            </li>
                        </ul>
                    </div>

                </div><!--card-info-->

            </div><!--sidebar-->

            <div class="content">
                <ul class="nav nav-buttons ">
                    <li class="w-185">
                        <a class="btn" href="my-coupon.html">My Coupon</a>
                    </li>
                    <li class="w-185">
                        <a class="btn active" href="my-point.html">My Point</a>
                    </li>
                </ul>

                <ul class="nav nav-buttons point">
                    <li>
                        <div class="btn points">
                            <img class="icons" src="img/icons/icon-point.png" alt="">
                            <span class="text-orange">599.50</span>
                            <small>Point</small>
                        </div>
                    </li>
                    <li>
                        <button class="btn active" type="button" data-bs-toggle="tab">ประวัติทั้งหมด</button>
                    </li>
                    <li>
                        <button class="btn" type="button" data-bs-toggle="tab">ที่ได้รับ</button>
                    </li>
                    <li>
                        <button class="btn" type="button" data-bs-toggle="tab">ที่ถูกใช้</button>
                    </li>
                </ul>

                <div class="card-point plus">
                    <div class="card-icon">
                        <img class="icons" src="img/icons/icon-point.png" alt="">
                    </div>
                    <div class="card-body">
                        <div>
                            <p>เลขที่สั่งซื้อ : 89275241</p>
                            <p><small>09/02/2023 13:50</small></p>
                        </div>

                        <p class="point">+35</p>
                    </div>
                </div>

                <div class="card-point">
                    <div class="card-icon">
                        <img class="icons" src="img/icons/icon-point.png" alt="">
                    </div>
                    <div class="card-body">
                        <div>
                            <p>เลขที่สั่งซื้อ : 89275241</p>
                            <p><small>09/02/2023 13:50</small></p>
                        </div>

                        <p class="point">-45</p>
                    </div>
                </div>

                <div class="card-point plus">
                    <div class="card-icon">
                        <img class="icons" src="img/icons/icon-point.png" alt="">
                    </div>
                    <div class="card-body">
                        <div>
                            <p>เลขที่สั่งซื้อ : 89275241</p>
                            <p><small>09/02/2023 13:50</small></p>
                        </div>

                        <p class="point">+35</p>
                    </div>
                </div>

                <div class="card-point">
                    <div class="card-icon">
                        <img class="icons" src="img/icons/icon-point.png" alt="">
                    </div>
                    <div class="card-body">
                        <div>
                            <p>เลขที่สั่งซื้อ : 89275241</p>
                            <p><small>09/02/2023 13:50</small></p>
                        </div>

                        <p class="point">-45</p>
                    </div>
                </div>

                <div class="card-point">
                    <div class="card-icon">
                        <img class="icons" src="img/icons/icon-point.png" alt="">
                    </div>
                    <div class="card-body">
                        <div>
                            <p>เลขที่สั่งซื้อ : 89275241</p>
                            <p><small>09/02/2023 13:50</small></p>
                        </div>

                        <p class="point">-45</p>
                    </div>
                </div>

                <div class="card-point">
                    <div class="card-icon">
                        <img class="icons" src="img/icons/icon-point.png" alt="">
                    </div>
                    <div class="card-body">
                        <div>
                            <p>เลขที่สั่งซื้อ : 89275241</p>
                            <p><small>09/02/2023 13:50</small></p>
                        </div>

                        <p class="point">-45</p>
                    </div>
                </div>

                <ul class="pagination pb-0">
                    <li class="page-item">
                        <a class="page-link arrow prev" href="#">
                            <img class="icons svg-js" src="img/icons/icon-next.svg" alt="">
                        </a>
                    </li>
                    <li class="page-item active"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item"><a class="page-link" href="#">4</a></li>
                    <li class="page-item"><a class="page-link" href="#">5</a></li>
                    <li class="page-item">
                        <a class="page-link arrow next" href="#">
                            <img class="icons svg-js" src="img/icons/icon-next.svg" alt="">
                        </a>
                    </li>
                </ul>

            </div><!--content-->

        </div><!--container-->
    </div><!--section-->
@endsection
@section('script')
@endsection
