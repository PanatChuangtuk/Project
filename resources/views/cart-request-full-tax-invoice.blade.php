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

    <div class="section section-cart bg-light pt-0">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="cart.html">Cart</a></li>
                <li class="breadcrumb-item active">Check Out</li>
            </ol>

            <div class="hgroup py-3 w-100">
                <h1 class="h2 text-underline">Check Out</h1>
            </div>

            <form class="card-info">
                <div class="card-body px-md-4 py-2">
                    <h2 class="text-secondary mb-3">Request Full Tax Invoice</h2>

                    <h3 class="fs-18">Personal Info</h3>

                    <div class="d-flex gap-5 py-4">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" value="" id="personalCheck"
                                name="personalInfoCheck" checked />
                            <label class="form-check-label fs-15 text-black" for="personalCheck">
                                Personal
                            </label>
                        </div>

                        <div class="form-check">
                            <input class="form-check-input" type="radio" value="" id="companyCheck"
                                name="personalInfoCheck" />
                            <label class="form-check-label fs-15 text-black" for="companyCheck">
                                Company
                            </label>
                        </div>
                    </div>

                    <div class="row form-row g-4">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="title">Firstname</label>
                                <input type="text" class="form-control" placeholder="Firstname" />
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="title">Name and Last name</label>
                                <input type="text" class="form-control" placeholder="Name and Last name" />
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="title">Mobile Phone</label>
                                <input type="text" class="form-control" placeholder="Mobile Phone" value="0987654321"
                                    pattern="[0-9]*" />
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="title">Email</label>
                                <input type="email" class="form-control" placeholder="Email" />
                            </div>
                        </div>
                    </div>

                    <h3 class="fs-18 mb-3 mt-5">Tax Info</h3>

                    <div class="row form-row g-4">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="title">Tax ID</label>
                                <input type="text" class="form-control" placeholder="Tax ID" />
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="title">Province</label>
                                <select class="form-select">
                                    <option value="">Province</option>
                                    <option value="1">Text1....</option>
                                    <option value="2">Text2....</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="title">Dristrict</label>
                                <select class="form-select">
                                    <option value="">Dristrict</option>
                                    <option value="1">Text1....</option>
                                    <option value="2">Text2....</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="title">Sub - District</label>
                                <select class="form-select">
                                    <option value="">Sub - District</option>
                                    <option value="1">Text1....</option>
                                    <option value="2">Text2....</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="title">Postal Code</label>
                                <input type="text" class="form-control" placeholder="Postal Code" value="10302" />
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="title">Detailed address (house number, building name,
                                    etc)</label>
                                <textarea class="form-control h-145" placeholder="Detailed address"></textarea>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-check mt-3">
                                <input class="form-check-input" type="checkbox" value="" id="check1"
                                    name="" />
                                <label class="form-check-label" for="check1">
                                    <strong>Set as default full tax invoice
                                        information</strong><br />
                                    <span class="fs-14">Turn on to automatically apply the current
                                        information setting in the future. You can
                                        make changes at any time.</span>
                                </label>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="buttons button-confirm justify-content-lg-end mb-4">
                                <a class="btn btn-outline-red" href="cart-check-out.html">Cancel</a>
                                <a class="btn btn-secondary" href="cart-check-out.html">Submit Request</a>
                            </div>
                        </div>
                    </div>
                    <!--row-->
                </div>
                <!--card-body-->
            </form>
            <!--card-info-->
        </div>
        <!--container-->
    </div>
    <!--section-->
@endsection
@section('script')
@endsection
