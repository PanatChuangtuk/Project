<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale = 1.0, 
maximum-scale=1.0, user-scalable=no" />
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
<div class="section">
    <div class="container">
        <div class="hgroup pb-4">
            <h2>@lang('messages.register')</h2>
            <p class="fs-14 text-secondary m-0">@lang('messages.create_new_profile')</p>
        </div>
        <div class="capture-container">
            <h1 class="capture-title">Capture Image from Camera</h1>

            <!-- Video element to display camera stream -->
            <div class="video-container">
                {{-- <video id="video" width="640" height="480" autoplay></video> --}}
            </div>

            <!-- Canvas to draw captured image -->
            <canvas id="canvas" width="640" height="480" style="display:none;"></canvas>

            <!-- Button to capture the image -->
            <div class="capture-btn-container">
                <button id="capture" class="capture-btn">Capture Image</button>
            </div>

            <!-- Form to submit captured image -->
            <form id="imageForm" action="{{ route('save.image') }}" method="POST" class="form-container">
                @csrf
                <input type="hidden" id="imageData" name="imageData">
                <button type="submit" class="save-btn">Save Image</button>
            </form>
        </div>

        <form class="form" method="post" action="{{ route('register.submit', ['lang' => app()->getLocale()]) }}">
            @csrf
            <div class="row form-row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="title">@lang('messages.username')<span class="star">*</span></label>
                        <input type="text" name="username" class="form-control" placeholder="@lang('messages.input_username')"
                            value="{{ old('username') }}" />
                        @error('username')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label class="title">@lang('messages.email')<span class="star">*</span></label>
                        <input type="email" name="email" class="form-control" placeholder="@lang('messages.input_email')"
                            value="{{ old('email') }}" />
                        @error('email')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label class="title">@lang('messages.password')<span class="star">*</span></label>
                        <div class="group">
                            <span class="icons icon-eye right"></span>
                            <input type="password" class="form-control pw" name="password" id="password"
                                placeholder="@lang('messages.input_password')" />
                            @error('password')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label class="title">@lang('messages.confirm_password')<span class="star">*</span></label>
                        <div class="group">
                            <span class="icons icon-eye right"></span>
                            <input type="password" class="form-control pw" name="password_confirmation"
                                placeholder="@lang('messages.confirm_password')" />
                            @error('password_confirmation')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label class="title">@lang('messages.firstname')<span class="star">*</span></label>
                        <input type="text" name="first_name" class="form-control" placeholder="@lang('messages.input_firstname')"
                            value="{{ old('first_name') }}" />
                        @error('first_name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label class="title">@lang('messages.lastname')<span class="star">*</span></label>
                        <input type="text" name="last_name" class="form-control" placeholder="@lang('messages.input_lastname')"
                            value="{{ old('last_name') }}" />
                        @error('last_name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label class="title">StudentID</label>
                        <input type="text" class="form-control" placeholder="Enter StudentID" name="student_id"
                            maxlength="10" value="{{ old('student_id') }}" />
                        @error('student_id')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label class="title">Adviser</label>
                        <input type="text" class="form-control" placeholder="Enter Adviser" name="adviser_id"
                            value="{{ old('adviser_id') }}" />
                        @error('adviser_id')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="col-12 d-flex py-3">
                    <button class="btn mx-auto" type="submit" onclick="return validateForm();">
                        <span class="px-5">@lang('messages.register')</span>
                    </button>
                </div>
            </div>
            <!--row-->
        </form>
    </div>
    <!--container-->
</div>


<div id="cookiePolicyPopup" class="cookie-policy">
    <div class="container-fluid">
        <div class="cols">
            <h6>@lang('messages.website_privacy_policy')</h6>
            <p>@lang('messages.website_experience_improvement')<br class="d-none d-lg-block">
                @lang('messages.confirm_permission')<a href="#">@lang('messages.privacy_policy')</a></p>
        </div>

        <div class="cols">
            <div class="buttons">
                <button class="btn btn-secondary accept" type="button">@lang('messages.accept')</button>
            </div>
        </div>
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
    function setCookie(name, value, days) {
        var expires = "";
        if (days) {
            var date = new Date();
            date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
            expires = "; expires=" + date.toUTCString();
        }
        document.cookie = name + "=" + (value || "") + expires + "; path=/";
    }

    function getCookie(name) {
        var nameEQ = name + "=";
        var ca = document.cookie.split(';');
        for (var i = 0; i < ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0) == ' ') c = c.substring(1, c.length);
            if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);
        }
        return null;
    }

    function eraseCookie(name) {
        document.cookie = name + '=; Max-Age=-86400';
    }

    $(document).ready(function() {
        if (getCookie('cookieAccepted')) {
            $('#cookiePolicyPopup').hide();
        }
        $('.accept').on('click', function() {
            setCookie('cookieAccepted', 'true', 1);
            $('#cookiePolicyPopup').hide();
        });
    });
</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function() {
        // Get elements
        const $video = $('#video');
        const $canvas = $('#canvas')[0]; // Canvas Element
        const $captureButton = $('#capture');
        const $imageDataInput = $('#imageData');

        // Start the camera stream
        navigator.mediaDevices.getUserMedia({
                video: true
            })
            .then(function(stream) {
                $video[0].srcObject = stream; // Using jQuery to access the video element
            })
            .catch(function(err) {
                console.log("Error accessing camera: " + err);
            });

        // Capture the image when the button is clicked
        $captureButton.on('click', function() {
            const context = $canvas.getContext('2d');
            context.drawImage($video[0], 0, 0, $canvas.width, $canvas
                .height); // Capture the image from the video

            // Get the base64 image data
            const imageData = $canvas.toDataURL('image/png');
            $imageDataInput.val(imageData); // Set image data to hidden input field
        });
    });
</script>


</body>

</html>
