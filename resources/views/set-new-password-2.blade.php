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

<div class="section section-profile bg-light pt-0">
    <div class="container has-sidebar">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">Profile</li>
        </ol>

        <div class="sidebar">
            <div class="card-info main">
                <div
                    class="title-bar d-flex"
                    data-bs-toggle="collapse"
                    data-bs-target="#navProfile"
                >
                    <h1 class="h2 text-capitalize text-underline">Profile</h1>

                    <button class="btn btn-menu" type="button">
                        <img
                            class="icons svg-js"
                            src="img/icons/icon-add-plus.svg"
                            alt=""
                        />
                    </button>
                </div>

                <div id="navProfile" class="collapse">
                    <ul class="nav nav-profile">
                        <li>
                            <a href="my-account.html">
                                <img
                                    class="icons"
                                    src="img/icons/icon-user.svg"
                                    alt=""
                                />
                                My Account
                            </a>
                        </li>
                        <li>
                            <a href="addresses.html">
                                <img
                                    class="icons"
                                    src="img/icons/icon-map-2.svg"
                                    alt=""
                                />
                                Addresses
                            </a>
                        </li>
                        <li>
                            <a href="tax-invoice.html">
                                <img
                                    class="icons"
                                    src="img/icons/icon-map-2.svg"
                                    alt=""
                                />
                                Tax Invoice
                            </a>
                        </li>
                        <li>
                            <a href="my-purchase.html">
                                <img
                                    class="icons"
                                    src="img/icons/icon-document.svg"
                                    alt=""
                                />
                                My Purchase
                            </a>
                        </li>
                        <li>
                            <a href="my-favourite.html">
                                <img
                                    class="icons"
                                    src="img/icons/icon-favorite-2.svg"
                                    alt=""
                                />
                                My Favourite
                            </a>
                        </li>
                        <li>
                            <a href="reviews.html">
                                <img
                                    class="icons"
                                    src="img/icons/icon-star-sharp.svg"
                                    alt=""
                                />
                                My Reviews
                            </a>
                        </li>
                        <li>
                            <a href="my-coupon.html">
                                <img
                                    class="icons"
                                    src="img/icons/icon-ticket-discount.svg"
                                    alt=""
                                />
                                My Coupon & Point
                            </a>
                        </li>
                        <li>
                            <a href="notification.html">
                                <img
                                    class="icons"
                                    src="img/icons/icon-bell-2.svg"
                                    alt=""
                                />
                                Notification
                            </a>
                        </li>
                        <li class="active">
                            <a href="change-password.html">
                                <img
                                    class="icons"
                                    src="img/icons/icon-user.svg"
                                    alt=""
                                />
                                Change Password
                            </a>
                        </li>
                        <li>
                            <a href="term-condition.html">
                                <img
                                    class="icons"
                                    src="img/icons/icon-note.svg"
                                    alt=""
                                />
                                Term and Condition
                            </a>
                        </li>
                        <li>
                            <a href="privacy-policy.html">
                                <img
                                    class="icons"
                                    src="img/icons/icon-shield-tick.svg"
                                    alt=""
                                />
                                Privacy Policy
                            </a>
                        </li>
                        <li>
                            <a href="#logoutModal" data-bs-toggle="modal">
                                <img
                                    class="icons"
                                    src="img/icons/icon-logout.svg"
                                    alt=""
                                />
                                Sign Out
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <!--card-info-->
        </div>
        <!--sidebar-->

        <div class="content">
            <div class="card-info main px-5">
                <div class="boxed py-3">
                    <div
                        class="article pb-3"
                        style="--font-size: 14px; --color: #375b51"
                    >
                        <h2 class="title-xl text-secondary fw-600">
                            SETUP NEWPASSWORD
                        </h2>

                        <p>Password must be 8 character.</p>
                    </div>

                    <form class="form">
                        <div class="row g-4">
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="title"
                                        >Current Password</label
                                    >
                                    <div class="group">
                                        <span
                                            class="icons icon-eye right"
                                        ></span>
                                        <input
                                            type="password"
                                            class="form-control pw"
                                            name="password"
                                            id="password1"
                                            value="0987654321"
                                            placeholder="กรอกรหัสผ่านของคุณ"
                                        />
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label class="title">NewPassword</label>
                                    <div class="group">
                                        <span
                                            class="icons icon-eye right"
                                        ></span>
                                        <input
                                            type="password"
                                            class="form-control pw"
                                            name="password"
                                            id="password2"
                                            value="0987654321"
                                            placeholder="กรอกรหัสผ่านของคุณ"
                                        />
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label class="title"
                                        >Confirm Password
                                    </label>
                                    <div class="group">
                                        <span
                                            class="icons icon-eye right"
                                        ></span>
                                        <input
                                            type="password"
                                            class="form-control pw"
                                            name="password"
                                            id="password2"
                                            value="0987654321"
                                            placeholder="กรอกรหัสผ่านของคุณ"
                                        />
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 d-flex pt-sm-4">
                                <button
                                    class="btn px-5 ms-auto me-sm-0 me-auto"
                                    type="button"
                                    data-bs-target="#successModal"
                                    data-bs-toggle="modal"
                                >
                                    <span class="px-3">Confirm</span>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                <!--boxed-->
            </div>
            <!--card-info-->
        </div>
        <!--content-->
    </div>
    <!--container-->
</div>
<!--section-->

@endsection @section('script') @endsection
