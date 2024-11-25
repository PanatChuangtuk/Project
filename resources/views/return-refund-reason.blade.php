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
            <a href="return-refund.html" class="btn btn-outline back">
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
            <p class="m-0">Information</p>
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
            <h3 class="fs-16 my-3">
                <span class="text-blue fw-bold">Step 1 :</span>
                <span class="fw-light"
                    >Please specify the reason for returning the product.</span
                >
            </h3>

            <div class="form-group pb-4">
                <label class="title">Reason</label>
                <textarea
                    class="form-control h-170"
                    placeholder="Detailed Reason"
                ></textarea>
            </div>

            <h3 class="fs-16 mt-3">
                <span class="text-blue fw-bold">Step 2 :</span>
                <span class="fw-light"
                    >Please provide additional pictures.</span
                >
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
                Image file PNG, JPEG, JPEG size not exceeding 5mb or video size
                not exceeding 20 mb.
            </p>

            <div class="buttons button-confirm justify-content-lg-end mb-4">
                <a class="btn btn-outline-red" href="addresses.html">Cancel</a>
                <button
                    class="btn btn-secondary"
                    type="button"
                    data-bs-target="#confirmModal"
                    data-bs-toggle="modal"
                >
                    Submit
                </button>
            </div>
        </div>
        <!--card-info-->
    </div>
    <!--container-->
</div>
<!--section-->

@endsection @section('script')
<script>
    // var myModal = new bootstrap.Modal(document.getElementById('cancelOrderModal'))
    // myModal.show();

    $("#successModal").on("hidden.bs.modal", function (e) {
        window.location.href = "return-refund-reason-detail.html";
    });
</script>
@endsection
