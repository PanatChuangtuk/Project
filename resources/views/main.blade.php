<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <title>@yield('title', 'Default') - KMUTNB</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Prompt:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="{{ asset('css/bootstrap/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/aos.css') }}" rel="stylesheet">
    <link href="{{ asset('css/jquery.fancybox.css') }}" rel="stylesheet">
    <link href="{{ asset('css/swiper.css') }}" rel="stylesheet">
    <link href="{{ asset('css/jquery.scrollbar.css') }}" rel="stylesheet">
    <link href="{{ asset('css/global.css') }}" rel="stylesheet">
    <style>
        .nav-link,
        .nav-main li a {
            position: relative;
            display: inline-block;
            text-transform: uppercase;
            text-decoration: none;
            padding: 8px 15px;
            font-weight: bold;
            transition: color 0.3s ease-in-out;
            color: white;
        }

        .nav-link::after,
        .nav-main li a::after {
            content: "";
            position: absolute;
            left: 50%;
            bottom: 0;
            width: 0;
            height: 2px;
            background-color: var(--color-primary);
            transition: all 0.3s ease-in-out;
            transform: translateX(-50%);
        }

        .nav-link:hover,
        .nav-main li a:hover {
            color: var(--color-primary);
        }

        .nav-link:hover::after,
        .nav-main li a:hover::after {
            width: 100%;
        }

        .active .nav-link,
        .nav-main li.active a {
            color: white;
            font-weight: bold;
        }

        .active .nav-link::after,
        .nav-main li.active a::after {
            width: 100%;
        }

        .navbar-toppage,
        .footer {
            background-color: var(--color-secondary);
            color: white;
        }

        .footer-links ul,
        .navbar-slider .nav-accordion {
            list-style-type: none;
            padding-left: 0;
        }

        .footer-links ul li a,
        .navbar-slider .nav-accordion li h5 {
            font-size: 16px;
            color: white;
            text-decoration: none;
        }

        .footer-links ul li a:hover {
            color: var(--color-primary);
        }
    </style>
    @yield('stylesheet')
</head>

<body>

    <div class="preload">
        <span class="loader"></span>
    </div>

    <div class="page logo-hidden">
        <header class="header">
            <div class="navbar-toppage">
                <div class="container">
                    <button class="btn btn-icon navbar-toggle" type="button">
                        <span class="group">
                            <span></span>
                            <span></span>
                            <span></span>
                        </span>
                    </button>
                    <ul class="nav nav-general right member">
                        <li class="{{ request()->is('profile') ? 'active' : '' }}">
                            <a href="{{ url('/') }}" class="nav-link">หน้าหลัก</a>
                        </li>
                        <li class="{{ request()->is('equipment') ? 'active' : '' }}">
                            <a href="{{ url('/equipment') }}" class="nav-link">หน้าอุปกรณ์</a>
                        </li>
                        <div class="text-center my-4">
                            <a href="{{ route('borrow.summary') }}" class="btn btn-lg btn-primary px-5">
                                ไปหน้ายืมอุปกรณ์
                            </a>
                        </div>
                        @auth('member')
                            <div class="member-links member dropdown">
                                <li>
                                    <a href="#" data-bs-toggle="dropdown" data-bs-display="static" class="link">
                                        <img class="icons avatar"
                                            src="{{ asset('upload/images/' . $profileUser->avatar) ?? null }}"
                                            alt="">
                                        <span class="username"
                                            style="color: aliceblue">{{ $profileUser->first_name . ' ' . $profileUser->last_name }}</span>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a href="{{ url('/profile') }}">บัญชีของฉัน</a>
                                        </li>
                                        <li>
                                            <form id="logout-form" action="{{ url('/logout') }}" method="POST"
                                                style="display: none;">
                                                @csrf
                                            </form>
                                            <a href="#" class="logout" onclick="confirmLogout(event)">
                                                ออกจากระบบ
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            </div>
                        @endauth

                    </ul>
                </div>
            </div>
        </header>

        <div class="navbar-slider">
            <div class="hgroup">
                <button class="btn btn-icon navbar-toggle" type="button">
                    <span class="group">
                        <span></span>
                        <span></span>
                        <span></span>
                    </span>
                </button>
                <ul class="nav nav-general left">
                </ul>
            </div>

            <ul class="nav nav-accordion">
                <li>
                    <h5><a href="{{ url('/') }}">หน้าหลัก</a></h5>
                </li>
                <li>
                    <h5><a href="{{ url('/equipment') }}">หน้าอุปกรณ์</a></h5>
                </li>
            </ul>
        </div>

        @yield('content')

        <footer class="footer">
            <div class="container">
                <div class="cols footer-info">
                    <div class="group">
                        <p>
                            <span class="fs-14">©</span><br class="d-none d-lg-block">
                            2024<br>
                            ALL RIGHTS RESERVED
                        </p>
                        <hr>
                        <p>
                            KMUTNB<br class="d-none d-lg-block">
                            THAILAND
                        </p>
                    </div>
                </div>
                <div class="cols footer-links">
                    <div class="group">
                        <ul class="nav">
                            <li><a href="{{ url('/profile') }}">โปรไฟล์</a></li>
                            <li><a href="{{ url('/equipment') }}">หน้าอุปกรณ์</a></li>
                        </ul>
                    </div>
                </div>
                <div class="cols footer-contact">
                    <div class="group">
                        <div class="followus"></div>
                    </div>
                </div>
            </div>

            <div class="totop">
                <a class="icons" href="#">
                    <img class="svg-js" src="{{ asset('img/icons/icon-totop.svg') }}" alt="">
                </a>
            </div>
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
                title: 'คุณต้องการออกจากระบบหรือไม่?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'โอเค',
                cancelButtonText: 'ยกเลิก',
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
@yield('script')
