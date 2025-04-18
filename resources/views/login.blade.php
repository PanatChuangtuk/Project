<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale = 1.0, 
maximum-scale=1.0, user-scalable=no" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <title>@yield('title', 'Login') - KMUTNB</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Prompt:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">

    <link href="{{ asset('css/bootstrap/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/aos.css') }}" rel="stylesheet">
    <link href="{{ asset('css/jquery.fancybox.css') }}" rel="stylesheet">
    <link href="{{ asset('css/swiper.css') }}" rel="stylesheet">
    <link href="{{ asset('css/jquery.scrollbar.css') }}" rel="stylesheet">
    <link href="{{ asset('css/global.css') }}" rel="stylesheet">
    <style>
        .empty-cart-message {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 200px;
            text-align: center;
        }

        /* Preloader */
        .preload {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.8);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }

        .loader {
            border: 4px solid #f3f3f3;
            border-top: 4px solid #3498db;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 2s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        /* Navbar */
        .navbar-toppage {
            background-color: #333;
            padding: 10px 0;
        }

        .navbar-toggle {
            background: transparent;
            border: none;
            cursor: pointer;
        }

        .navbar-toggle .group span {
            display: block;
            width: 30px;
            height: 3px;
            background-color: #fff;
            margin: 5px 0;
        }

        .navbar-main {
            background-color: #fff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 10px 0;
        }

        .navbar-brand img {
            max-height: 40px;
        }

        .nav-main {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            justify-content: center;
        }

        .nav-main li {
            margin: 0 20px;
        }

        .nav-main li a {
            text-transform: uppercase;
            color: #333;
            text-decoration: none;
            font-weight: bold;
            font-size: 16px;
        }

        .nav-main li.active a {
            color: #3498db;
        }

        .navbar-slider .nav-accordion {
            list-style: none;
            padding: 0;
        }

        .navbar-slider .nav-accordion li {
            margin-bottom: 10px;
        }

        .navbar-slider .nav-accordion li h5 {
            font-size: 18px;
            color: #333;
            margin: 0;
        }

        .navbar-slider .followus {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }

        .navbar-slider .followus a {
            margin: 0 10px;
        }

        .navbar-slider .followus img {
            width: 24px;
            height: 24px;
        }

        /* Footer */
        .footer {
            background-color: #333;
            color: #fff;
            padding: 20px 0;
            font-size: 14px;
        }

        .footer-info,
        .footer-links,
        .footer-contact {
            padding: 10px;
        }

        .footer-info p {
            font-size: 16px;
            text-align: center;
            color: #ddd;
        }

        .footer-info hr {
            border-color: #444;
            width: 50%;
            margin: 10px auto;
        }

        .footer-links ul {
            list-style-type: none;
            padding-left: 0;
        }

        .footer-links ul li {
            margin: 10px 0;
        }

        .footer-links ul li a {
            color: #fff;
            text-decoration: none;
            font-size: 16px;
        }

        .footer-links ul li a:hover {
            color: #3498db;
        }

        .followus {
            text-align: center;
            margin-top: 10px;
        }

        .totop {
            text-align: center;
            margin-top: 20px;
        }

        .totop a {
            color: #fff;
            font-size: 18px;
        }

        .totop a:hover {
            color: #3498db;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .nav-main {
                flex-direction: column;
                text-align: center;
            }

            .nav-main li {
                margin: 10px 0;
            }

            .footer-info p,
            .footer-links ul,
            .footer-contact {
                text-align: center;
            }

            .footer-info hr {
                width: 80%;
            }

            .navbar-slider .nav-accordion li {
                margin-bottom: 15px;
            }

            .navbar-slider .followus a {
                margin: 0 15px;
            }
        }
    </style>

</head>

<body>

    <div class="preload">
        <span class="loader"></span>
    </div>

    <div class="page logo-hidden">
        <header class="header">
            <div class="navbar-toppage">
                <div class="container">

                </div>
            </div>
        </header>

        <div class="section section-column">
            <div class="container">
                <div class="row row-main">
                    <div class="cols col-photo" data-aos="fade-in">
                        <img src="{{ asset('img/thumb/images.jpg') }}" alt="" />
                    </div>
                    <!--cols-->
                    <div class="cols col-form" data-aos="fade-in">
                        <div class="boxed me-lg-0">
                            <div class="article pb-3" style="--font-size: 14px; --color: #375b51">
                                <h2>เข้าสู่ระบบ</h2>
                                <p> กรุณากรอกข้อมูลเพื่อเข้าสู่ระบบ
                                    ระบบนี้ช่วยให้คุณสามารถเข้าถึงบัญชีของคุณได้
                                    โปรดป้อนข้อมูลที่ถูกต้องเพื่อดำเนินการต่อ
                                </p>
                            </div>
                            <form class="form" method="POST" action="{{ route('login.submit') }}">
                                @csrf
                                <div class="row g-4">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label class="title">อีเมล</label>
                                            <input type="text" class="form-control" name="email_or_phone"
                                                value="{{ old('email_or_phone') }}" placeholder="กรุณากรอกอีเมล" />
                                            @error('email_or_phone')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-group">
                                            <label class="title">รหัสผ่าน</label>
                                            <div class="group mb-3">
                                                <span class="icons icon-eye right"></span>
                                                <input type="password" class="form-control pw" name="password"
                                                    id="password" placeholder="กรุณากรอกรหัสผ่านของคุณ" />
                                                @error('password')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            {{-- <label class="title mb-0">
                                                <a href="{{ url('/otp-forgot-password-login') }}">ลืมรหัสผ่าน?</a>
                                            </label> --}}
                                        </div>
                                    </div>

                                    <div class="col-12 d-flex pt-sm-4">
                                        <button class="btn px-5 ms-auto me-sm-0 " type="submit">
                                            <span class="px-3">เข้าสู่ระบบ</span>
                                        </button>
                                    </div>

                                    <div class="col-12 py-4">
                                        <div class="form-note">
                                            <h6>ยังไม่มีบัญชี?</h6>
                                            <a href="{{ url('/register') }}" class="btn btn-32 btn-light rounded-14">
                                                <span class="fs-14 px-2">สมัครสมาชิก</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!--boxed-->
                    </div>
                    <!--cols-->
                </div>
                <!--row-main-->
            </div>
            <!--container-->
        </div>
        <!--section-->
        <footer class="footer">

        </footer>
    </div>

    <script src="{{ asset('js/jquery-3.4.1.min.js') }}" defer></script>
    <script src="{{ asset('js/bootstrap/popper.min.js') }}" defer></script>
    <script src="{{ asset('js/bootstrap/bootstrap.min.js') }}" defer></script>
    <script src="{{ asset('js/jquery.fancybox.js') }}" defer></script>
    <script src="{{ asset('js/swiper.js') }}" defer></script>
    <script src="{{ asset('js/aos.js') }}" defer></script>
    <script src="{{ asset('js/jquery.scrollbar.js') }}" defer></script>
    <script src="{{ asset('js/custom.js') }}" defer></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>



    <script>
        function confirmLogout(event) {
            event.preventDefault();
            Swal.fire({
                title: '@lang('messages.are_you_sure')',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: '@lang('messages.ok')',
                cancelButtonText: '@lang('messages.cancel')',
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('logout-form').submit();
                }
            });
        }
    </script>
</body>

</html>
