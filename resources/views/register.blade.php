<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale = 1.0, maximum-scale=1.0, user-scalable=no" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <title>@yield('title', 'REGISTER') - KMUTNB</title>
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
        body {
            background: linear-gradient(135deg, #f8f9fa, #e9ecef);
        }

        .container {
            max-width: 800px;
            background: white;
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }

        .nav-pills .nav-link {
            color: #495057;
        }

        .nav-pills .nav-link.active {
            background-color: #007bff;
        }

        .video-container {
            border: 5px solid #007bff;
            border-radius: 10px;
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .empty-cart-message {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 200px;
            text-align: center;
        }

        .capture-container {
            max-width: 720px;
            margin: 0 auto;
            text-align: center;
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .capture-title {
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 20px;
            color: #333;
        }

        .video-container {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
        }

        .capture-btn-container {
            margin: 20px 0;
        }

        .capture-btn {
            background-color: #28a745;
            color: white;
            padding: 10px 20px;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .capture-btn:hover {
            background-color: #218838;
        }

        .form-container {
            display: inline-block;
            margin-top: 30px;
        }

        .save-btn {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .save-btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <div class="section">
        <div class="container">
            <div class="hgroup pb-4 text-center">
                <h2 class="fw-bold">ลงทะเบียน</h2>
                <p class="fs-14 text-secondary m-0">สร้างบัญชีใหม่ของคุณ</p>
            </div>

            <!-- Navigation Tabs -->
            <ul class="nav nav-pills justify-content-center mb-4" id="registerTabs">
                <li class="nav-item">
                    <a class="nav-link active px-4 py-2 " id="camera-tab" data-bs-toggle="tab" href="#camera-section">
                        📸 ถ่ายภาพ
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link px-4 py-2 " id="form-tab" data-bs-toggle="tab" href="#form-section">
                        📝 กรอกข้อมูล
                    </a>
                </li>
            </ul>

            <div class="tab-content">
                <!-- Tab 1: ถ่ายภาพ -->
                <div class="tab-pane fade show active" id="camera-section">
                    <div class="capture-container">
                        <div class="video-container mb-4" style="border-radius: 10px; overflow: hidden;">
                            <video id="video" width="100%" height="100%" autoplay class="shadow-lg"></video>
                        </div>
                        <canvas id="canvas" width="640" height="480" style="display:none;"></canvas>
                        <img id="capturedImage" class="mt-4 rounded shadow-lg" width="100%" style="display:none;" />

                        <div class="capture-btn-container mt-4">
                            <button id="capture" class="capture-btn">Capture Image</button>
                        </div>
                    </div>
                </div>

                <!-- Tab 2: กรอกข้อมูล -->
                <div class="tab-pane fade" id="form-section">
                    <div class=" shadow-lg p-4 ">
                        <form class="form" method="post" action="{{ route('register.submit') }}">
                            @csrf
                            <div class="row form-row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="fw-bold">ชื่อผู้ใช้ <span class="text-danger">*</span></label>
                                        <input type="text" name="username" class="form-control"
                                            placeholder="กรอกชื่อผู้ใช้" value="{{ old('username') }}" />
                                        @error('username')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="fw-bold">อีเมล <span class="text-danger">*</span></label>
                                        <input type="email" name="email" class="form-control"
                                            placeholder="กรอกอีเมล" value="{{ old('email') }}" />
                                        @error('email')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="fw-bold">รหัสผ่าน <span class="text-danger">*</span></label>
                                        <input type="password" class="form-control" name="password"
                                            placeholder="กรอกรหัสผ่าน" />
                                        @error('password')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="fw-bold">ยืนยันรหัสผ่าน <span
                                                class="text-danger">*</span></label>
                                        <input type="password" class="form-control" name="password_confirmation"
                                            placeholder="ยืนยันรหัสผ่าน" />
                                        @error('password_confirmation')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="fw-bold">ชื่อ <span class="text-danger">*</span></label>
                                        <input type="text" name="first_name" class="form-control"
                                            placeholder="กรอกชื่อ" value="{{ old('first_name') }}" />
                                        @error('first_name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="fw-bold">นามสกุล <span class="text-danger">*</span></label>
                                        <input type="text" name="last_name" class="form-control"
                                            placeholder="กรอกนามสกุล" value="{{ old('last_name') }}" />
                                        @error('last_name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <input type="hidden" id="imageData" name="imageData">
                                <div class="col-12 d-flex py-3">
                                    <button class="btn btn-success mx-auto px-5 py-2 shadow-lg fw-bold">
                                        ✅ ลงทะเบียน
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div> <!-- End Form Section -->
            </div> <!-- End Tab Content -->
        </div>
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
        $(document).ready(function() {
            const $video = $('#video');
            const $canvas = $('#canvas')[0];
            const $captureButton = $('#capture');
            const $imageDataInput = $('#imageData');
            const $capturedImage = $('#capturedImage');

            let stream;
            navigator.mediaDevices.getUserMedia({
                    video: true
                })
                .then(function(cameraStream) {
                    stream = cameraStream;
                    $video[0].srcObject = stream;
                })
                .catch(function(err) {
                    console.log("Error accessing camera: " + err);
                });

            $captureButton.on('click', function() {
                const context = $canvas.getContext('2d');
                context.drawImage($video[0], 0, 0, $canvas.width, $canvas.height);
                const imageData = $canvas.toDataURL('image/png');
                $imageDataInput.val(imageData);
                $capturedImage.attr('src', imageData).show();
                $video.hide();

                if (stream) {
                    stream.getTracks().forEach(track => track.stop());
                }
            });
        });
    </script>
































</body>

</html>
