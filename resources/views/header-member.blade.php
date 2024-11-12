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

<div class="section p-0">
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.html">Home</a></li>
            <li class="breadcrumb-item"><a href="#">All pRODUCTs</a></li>
            <li class="breadcrumb-item active">Alfa Aesar</li>
        </ol>

        <div class="section-header product-header">
            <h1 class="title-xl text-underline">All Products</h1>

            <div class="d-flex gap-gl-4 gap-sm-3 gap-2">
                <div class="select-pretty">
                    <img
                        class="icons ms-3"
                        src="img/icons/icon-row-vertical.svg"
                        alt=""
                    />
                    <div class="dropdown form-select">
                        <a
                            href="#"
                            class="fw-500 selected"
                            data-bs-toggle="dropdown"
                            data-bs-display="static"
                        >
                            15 Products
                        </a>
                        <ul class="dropdown-menu">
                            <li class="active">15 Products</li>
                            <li>30 Products</li>
                            <li>60 Products</li>
                        </ul>
                    </div>
                </div>

                <div class="select-pretty">
                    <h6 class="ms-3">Sort By :</h6>
                    <div class="dropdown form-select">
                        <a
                            href="#"
                            class="fw-500 selected"
                            data-bs-toggle="dropdown"
                            data-bs-display="static"
                        >
                            Newest
                        </a>
                        <ul class="dropdown-menu">
                            <li class="active">Newest</li>
                            <li>Texttttt</li>
                            <li>Textttttttt</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="row product-lists">
            <div class="col-12">
                <div class="card-product" data-aos="fade-in">
                    <a href="#" class="card-link"></a>
                    <div class="card-photo">
                        <div
                            class="photo"
                            style="
                                background-image: url(img/thumb/photo-600x600--1.jpg);
                            "
                        >
                            <img src="img/thumb/frame-100x100.png" alt="" />
                        </div>

                        <span class="status new">NEW</span>
                    </div>
                    <div class="card-body">
                        <h3>
                            (+)-1,2-Bis[(2R,5R)-2,5-diethyl-1-phospholanyl]ethane,
                            97+%
                        </h3>
                        <h6>Model : DAE-1217-2304</h6>

                        <p>
                            SCS – Special customer service
                            บริการผลิตสารเคมีตามคุณภาพสูงตามส่วนผสมและขนาดบรรจุ
                            ที่ผู้ใช้งานต้องการเพื่อตอบสนอง
                            ต่อความต้องการของธุรกิจ ต่างๆ เช่น
                            กระทรวงสาธารณสุขกระทรวงเกษตรและสหกรณ์และสำนักงานพัฒนาวิทยาศาสตร์และเทคโนโลยี...
                        </p>
                    </div>
                </div>
                <!--card-product-->
            </div>
            <!--col-12-->

            <div class="col-12">
                <div class="card-product" data-aos="fade-in">
                    <a href="#" class="card-link"></a>
                    <div class="card-photo">
                        <div
                            class="photo"
                            style="
                                background-image: url(img/thumb/photo-600x600--2.jpg);
                            "
                        >
                            <img src="img/thumb/frame-100x100.png" alt="" />
                        </div>

                        <span class="status promotion">PROMOTION</span>
                    </div>
                    <div class="card-body">
                        <h3>
                            (+)-1,2-Bis[(2R,5R)-2,5-diethyl-1-phospholanyl]ethane,
                            97+%
                        </h3>
                        <h6>Model : DAE-1217-2304</h6>

                        <p>
                            SCS – Special customer service
                            บริการผลิตสารเคมีตามคุณภาพสูงตามส่วนผสมและขนาดบรรจุ
                            ที่ผู้ใช้งานต้องการเพื่อตอบสนอง
                            ต่อความต้องการของธุรกิจ ต่างๆ เช่น
                            กระทรวงสาธารณสุขกระทรวงเกษตรและสหกรณ์และสำนักงานพัฒนาวิทยาศาสตร์และเทคโนโลยี...
                        </p>
                    </div>
                </div>
                <!--card-product-->
            </div>
            <!--col-12-->

            <div class="col-12">
                <div class="card-product" data-aos="fade-in">
                    <a href="#" class="card-link"></a>
                    <div class="card-photo">
                        <div
                            class="photo"
                            style="
                                background-image: url(img/thumb/photo-600x600--3.jpg);
                            "
                        >
                            <img src="img/thumb/frame-100x100.png" alt="" />
                        </div>
                    </div>
                    <div class="card-body">
                        <h3>
                            (+)-1,2-Bis[(2R,5R)-2,5-diethyl-1-phospholanyl]ethane,
                            97+%
                        </h3>
                        <h6>Model : DAE-1217-2304</h6>

                        <p>
                            SCS – Special customer service
                            บริการผลิตสารเคมีตามคุณภาพสูงตามส่วนผสมและขนาดบรรจุ
                            ที่ผู้ใช้งานต้องการเพื่อตอบสนอง
                            ต่อความต้องการของธุรกิจ ต่างๆ เช่น
                            กระทรวงสาธารณสุขกระทรวงเกษตรและสหกรณ์และสำนักงานพัฒนาวิทยาศาสตร์และเทคโนโลยี...
                        </p>
                    </div>
                </div>
                <!--card-product-->
            </div>
            <!--col-12-->

            <div class="col-12">
                <div class="card-product" data-aos="fade-in">
                    <a href="#" class="card-link"></a>
                    <div class="card-photo">
                        <div
                            class="photo"
                            style="
                                background-image: url(img/thumb/photo-600x600--4.jpg);
                            "
                        >
                            <img src="img/thumb/frame-100x100.png" alt="" />
                        </div>
                        <span class="status new">new</span>
                    </div>
                    <div class="card-body">
                        <h3>
                            (+)-1,2-Bis[(2R,5R)-2,5-diethyl-1-phospholanyl]ethane,
                            97+%
                        </h3>
                        <h6>Model : DAE-1217-2304</h6>

                        <p>
                            SCS – Special customer service
                            บริการผลิตสารเคมีตามคุณภาพสูงตามส่วนผสมและขนาดบรรจุ
                            ที่ผู้ใช้งานต้องการเพื่อตอบสนอง
                            ต่อความต้องการของธุรกิจ ต่างๆ เช่น
                            กระทรวงสาธารณสุขกระทรวงเกษตรและสหกรณ์และสำนักงานพัฒนาวิทยาศาสตร์และเทคโนโลยี...
                        </p>
                    </div>
                </div>
                <!--card-product-->
            </div>
            <!--col-12-->

            <div class="col-12">
                <div class="card-product" data-aos="fade-in">
                    <a href="#" class="card-link"></a>
                    <div class="card-photo">
                        <div
                            class="photo"
                            style="
                                background-image: url(img/thumb/photo-600x600--1.jpg);
                            "
                        >
                            <img src="img/thumb/frame-100x100.png" alt="" />
                        </div>
                        <span class="status promotion">promotion</span>
                    </div>
                    <div class="card-body">
                        <h3>
                            (+)-1,2-Bis[(2R,5R)-2,5-diethyl-1-phospholanyl]ethane,
                            97+%
                        </h3>
                        <h6>Model : DAE-1217-2304</h6>

                        <p>
                            SCS – Special customer service
                            บริการผลิตสารเคมีตามคุณภาพสูงตามส่วนผสมและขนาดบรรจุ
                            ที่ผู้ใช้งานต้องการเพื่อตอบสนอง
                            ต่อความต้องการของธุรกิจ ต่างๆ เช่น
                            กระทรวงสาธารณสุขกระทรวงเกษตรและสหกรณ์และสำนักงานพัฒนาวิทยาศาสตร์และเทคโนโลยี...
                        </p>
                    </div>
                </div>
                <!--card-product-->
            </div>
            <!--col-12-->

            <div class="col-12">
                <div class="card-product" data-aos="fade-in">
                    <a href="#" class="card-link"></a>
                    <div class="card-photo">
                        <div
                            class="photo"
                            style="
                                background-image: url(img/thumb/photo-600x600--3.jpg);
                            "
                        >
                            <img src="img/thumb/frame-100x100.png" alt="" />
                        </div>
                        <span class="status new">new</span>
                    </div>
                    <div class="card-body">
                        <h3>
                            (+)-1,2-Bis[(2R,5R)-2,5-diethyl-1-phospholanyl]ethane,
                            97+%
                        </h3>
                        <h6>Model : DAE-1217-2304</h6>

                        <p>
                            SCS – Special customer service
                            บริการผลิตสารเคมีตามคุณภาพสูงตามส่วนผสมและขนาดบรรจุ
                            ที่ผู้ใช้งานต้องการเพื่อตอบสนอง
                            ต่อความต้องการของธุรกิจ ต่างๆ เช่น
                            กระทรวงสาธารณสุขกระทรวงเกษตรและสหกรณ์และสำนักงานพัฒนาวิทยาศาสตร์และเทคโนโลยี...
                        </p>
                    </div>
                </div>
                <!--card-product-->
            </div>
            <!--col-12-->

            <div class="col-12">
                <div class="card-product" data-aos="fade-in">
                    <a href="#" class="card-link"></a>
                    <div class="card-photo">
                        <div
                            class="photo"
                            style="
                                background-image: url(img/thumb/photo-600x600--2.jpg);
                            "
                        >
                            <img src="img/thumb/frame-100x100.png" alt="" />
                        </div>
                    </div>
                    <div class="card-body">
                        <h3>
                            (+)-1,2-Bis[(2R,5R)-2,5-diethyl-1-phospholanyl]ethane,
                            97+%
                        </h3>
                        <h6>Model : DAE-1217-2304</h6>

                        <p>
                            SCS – Special customer service
                            บริการผลิตสารเคมีตามคุณภาพสูงตามส่วนผสมและขนาดบรรจุ
                            ที่ผู้ใช้งานต้องการเพื่อตอบสนอง
                            ต่อความต้องการของธุรกิจ ต่างๆ เช่น
                            กระทรวงสาธารณสุขกระทรวงเกษตรและสหกรณ์และสำนักงานพัฒนาวิทยาศาสตร์และเทคโนโลยี...
                        </p>
                    </div>
                </div>
                <!--card-product-->
            </div>
            <!--col-12-->

            <div class="col-12">
                <div class="card-product" data-aos="fade-in">
                    <a href="#" class="card-link"></a>
                    <div class="card-photo">
                        <div
                            class="photo"
                            style="
                                background-image: url(img/thumb/photo-600x600--4.jpg);
                            "
                        >
                            <img src="img/thumb/frame-100x100.png" alt="" />
                        </div>
                    </div>
                    <div class="card-body">
                        <h3>
                            (+)-1,2-Bis[(2R,5R)-2,5-diethyl-1-phospholanyl]ethane,
                            97+%
                        </h3>
                        <h6>Model : DAE-1217-2304</h6>

                        <p>
                            SCS – Special customer service
                            บริการผลิตสารเคมีตามคุณภาพสูงตามส่วนผสมและขนาดบรรจุ
                            ที่ผู้ใช้งานต้องการเพื่อตอบสนอง
                            ต่อความต้องการของธุรกิจ ต่างๆ เช่น
                            กระทรวงสาธารณสุขกระทรวงเกษตรและสหกรณ์และสำนักงานพัฒนาวิทยาศาสตร์และเทคโนโลยี...
                        </p>
                    </div>
                </div>
                <!--card-product-->
            </div>
            <!--col-12-->

            <div class="col-12">
                <div class="card-product" data-aos="fade-in">
                    <a href="#" class="card-link"></a>
                    <div class="card-photo">
                        <div
                            class="photo"
                            style="
                                background-image: url(img/thumb/photo-600x600--1.jpg);
                            "
                        >
                            <img src="img/thumb/frame-100x100.png" alt="" />
                        </div>
                        <span class="status promotion">PROMOTION</span>
                    </div>
                    <div class="card-body">
                        <h3>
                            (+)-1,2-Bis[(2R,5R)-2,5-diethyl-1-phospholanyl]ethane,
                            97+%
                        </h3>
                        <h6>Model : DAE-1217-2304</h6>

                        <p>
                            SCS – Special customer service
                            บริการผลิตสารเคมีตามคุณภาพสูงตามส่วนผสมและขนาดบรรจุ
                            ที่ผู้ใช้งานต้องการเพื่อตอบสนอง
                            ต่อความต้องการของธุรกิจ ต่างๆ เช่น
                            กระทรวงสาธารณสุขกระทรวงเกษตรและสหกรณ์และสำนักงานพัฒนาวิทยาศาสตร์และเทคโนโลยี...
                        </p>
                    </div>
                </div>
                <!--card-product-->
            </div>
            <!--col-12-->

            <div class="col-12">
                <div class="card-product" data-aos="fade-in">
                    <a href="#" class="card-link"></a>
                    <div class="card-photo">
                        <div
                            class="photo"
                            style="
                                background-image: url(img/thumb/photo-600x600--3.jpg);
                            "
                        >
                            <img src="img/thumb/frame-100x100.png" alt="" />
                        </div>
                    </div>
                    <div class="card-body">
                        <h3>
                            (+)-1,2-Bis[(2R,5R)-2,5-diethyl-1-phospholanyl]ethane,
                            97+%
                        </h3>
                        <h6>Model : DAE-1217-2304</h6>

                        <p>
                            SCS – Special customer service
                            บริการผลิตสารเคมีตามคุณภาพสูงตามส่วนผสมและขนาดบรรจุ
                            ที่ผู้ใช้งานต้องการเพื่อตอบสนอง
                            ต่อความต้องการของธุรกิจ ต่างๆ เช่น
                            กระทรวงสาธารณสุขกระทรวงเกษตรและสหกรณ์และสำนักงานพัฒนาวิทยาศาสตร์และเทคโนโลยี...
                        </p>
                    </div>
                </div>
                <!--card-product-->
            </div>
            <!--col-12-->
        </div>
        <!--row-->

        <ul class="pagination">
            <li class="page-item">
                <a class="page-link arrow prev" href="#">
                    <img
                        class="icons svg-js"
                        src="img/icons/icon-next.svg"
                        alt=""
                    />
                </a>
            </li>
            <li class="page-item active">
                <a class="page-link" href="#">1</a>
            </li>
            <li class="page-item"><a class="page-link" href="#">2</a></li>
            <li class="page-item"><a class="page-link" href="#">3</a></li>
            <li class="page-item"><a class="page-link" href="#">4</a></li>
            <li class="page-item"><a class="page-link" href="#">5</a></li>
            <li class="page-item">
                <a class="page-link arrow next" href="#">
                    <img
                        class="icons svg-js"
                        src="img/icons/icon-next.svg"
                        alt=""
                    />
                </a>
            </li>
        </ul>
    </div>
    <!--container-->
</div>
<!--section-->
@endsection
@section('script')
@endsection