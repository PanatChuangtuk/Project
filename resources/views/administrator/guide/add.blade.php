@extends('administrator.layouts.main')

@section('title')
@endsection

@section('content')

    <ol class="breadcrumb bg-light p-3 rounded shadow-sm">

        <li class="breadcrumb-item">
            <a href="{{ route('administrator.dashboard') }}">
                หน้าหลัก
            </a>
        </li>

        <li class="breadcrumb-item">
            <a href="{{ route('administrator.guide') }}">
                คู่มือการใช้งาน
            </a>
        </li>

        <li class="breadcrumb-item active" aria-current="page">
            เพิ่มคู่มือการใช้งาน
        </li>

    </ol>


    <div class="card shadow-lg border-0 rounded-4">

        <div class="card-header text-white rounded-top-4">

            <h5 class="mb-0">
                <i class="fas fa-user-plus"></i>
                เพิ่มคู่มือการใช้งาน
            </h5>

        </div>


        <div class="card-body">

            <form
                id="form-create"
                method="POST"
                action="{{ route('administrator.guide.submit') }}"
                class="mx-1 mx-md-4"
                enctype="multipart/form-data"
            >

                @csrf


                <div class="row g-4">


                    {{-- =====================================================
                        ชื่อวิดีโอ
                    ====================================================== --}}

                    <div class="col-md-6">

                        <label
                            for="name"
                            class="form-label fw-semibold"
                        >
                            ชื่อวิดีโอ
                            <span class="text-danger">*</span>
                        </label>


                        <div class="input-group shadow-sm">

                            <span class="input-group-text bg-light">
                                <i class="bx bxs-rename"></i>
                            </span>


                            <input
                                type="text"
                                id="name"
                                name="name"
                                class="form-control border-0 shadow-sm"
                                placeholder="กรุณากรอกชื่อวิดีโอ"
                            >

                        </div>


                        @error('name')

                            <div class="text-danger small mt-1">
                                {{ $message }}
                            </div>

                        @enderror

                    </div>



                    {{-- =====================================================
                        วิดีโอ
                    ====================================================== --}}

                    <div class="col-md-12">

                        <div class="form-group">

                            <label class="fw-bold w-100 d-block">

                                วิดีโอ

                                <span class="text-danger">
                                    *
                                </span>

                            </label>


                            <div class="mb-3">

                                <label
                                    class="form-label fw-bold"
                                    for="video"
                                >
                                    อัปโหลดวิดีโอ
                                </label>


                                <input
                                    type="file"
                                    name="video"
                                    id="video"
                                    accept="video/mp4,video/webm,video/ogg"
                                >


                            </div>


                            @error('video')

                                <span class="text-danger w-100">
                                    {{ $message }}
                                </span>

                            @enderror


                        </div>

                    </div>



                    {{-- =====================================================
                        สถานะ
                    ====================================================== --}}

                    <div class="col-md-12 mt-3">

                        <div class="form-check form-switch">

                            <input
                                class="form-check-input"
                                type="checkbox"
                                id="status"
                                value="1"
                                name="status"
                                checked
                            >


                            <label
                                class="form-check-label fw-semibold"
                                for="status"
                            >
                                สถานะเปิดใช้งาน
                            </label>

                        </div>

                    </div>



                    {{-- =====================================================
                        ปุ่ม
                    ====================================================== --}}

                    <div class="col-md-12 mt-4 text-end">


                        <button
                            type="submit"
                            id="btn-submit"
                            class="btn btn-success px-4 shadow-sm"
                        >

                            <i class="fas fa-save"></i>

                            บันทึก

                        </button>


                        <a
                            href="{{ route('administrator.guide') }}"
                            class="btn btn-danger px-4 shadow-sm"
                        >

                            <i class="fas fa-times"></i>

                            ยกเลิก

                        </a>


                    </div>


                </div>

            </form>

        </div>

    </div>

@endsection



@section('script')


    {{-- =========================================================
        Session Success
    ========================================================== --}}

    @if (session('success'))

        <script>

            Swal.fire({

                title: 'สำเร็จ!',

                text: @json(session('success')),

                icon: 'success',

                confirmButtonText: 'ตกลง'

            }).then(function() {

                window.location.href =
                    "{{ route('administrator.guide') }}";

            });

        </script>

    @endif



    {{-- =========================================================
        Session Error
    ========================================================== --}}

    @if (session('error'))

        <script>

            Swal.fire({

                title: 'เกิดข้อผิดพลาด',

                text: @json(session('error')),

                icon: 'error',

                confirmButtonText: 'ตกลง'

            });

        </script>

    @endif



    <script>

      $(document).ready(function () {

    let uploading = false;

    $("#video").fileinput({

        theme: "fa5",

        uploadUrl: "{{ route('administrator.guide.submit') }}",

        uploadAsync: true,

        allowedFileExtensions: [
            "mp4",
            "webm",
            "ogg"
        ],

        maxFileSize: 512000,

        // สำคัญ
        maxFileCount: 1,

        showUpload: false,

        showRemove: true,

        showPreview: true,

        previewFileType: "video",

        browseClass: "btn btn-primary",

        uploadExtraData: function () {

            return {
                _token: "{{ csrf_token() }}",

                name: $("#name").val(),

                status: $("#status").is(":checked")
                    ? 1
                    : 0
            };

        },

        fileActionSettings: {

            showUpload: false,

            showRemove: true,

            showDownload: false,

            showZoom: true

        },

        msgPlaceholder:
            "เลือกวิดีโอ...",

        msgSelected:
            "{n} ไฟล์ถูกเลือก",

        msgFilesTooMany:
            "สามารถเลือกวิดีโอได้เพียง 1 ไฟล์เท่านั้น",

        msgInvalidFileExtension:
            "ไฟล์ประเภทนี้ไม่รองรับ กรุณาเลือก MP4, WEBM หรือ OGG",

        msgInvalidFileType:
            "ประเภทไฟล์ไม่ถูกต้อง",

        msgSizeTooLarge:
            "ไฟล์มีขนาดใหญ่เกินไป ขนาดสูงสุดคือ 500 MB",

        msgSizeTooSmall:
            "ไฟล์มีขนาดเล็กเกินไป",

        msgUploadBegin:
            "กำลังอัปโหลด...",

        msgUploadEnd:
            "อัปโหลดเสร็จสิ้น",

        msgUploadError:
            "เกิดข้อผิดพลาดในการอัปโหลด",

        msgValidationError:
            "ตรวจสอบไฟล์ไม่ผ่าน"

    });


    /*
    |--------------------------------------------------------------------------
    | ดักตอนเลือกไฟล์
    |--------------------------------------------------------------------------
    */

    $("#video").on(
        "filebatchselected",
        function (event, files) {

            console.log(
                "จำนวนไฟล์:",
                files.length
            );


            /*
            |--------------------------------------------------------------------------
            | เลือกเกิน 1 ไฟล์
            |--------------------------------------------------------------------------
            */

            if (files.length > 1) {

                // ล้างไฟล์ก่อน
                $("#video").fileinput("clear");


                // แสดงข้อความ
                Swal.fire({

                    icon: "warning",

                    title: "เลือกไฟล์ไม่ได้",

                    text:
                        "สามารถอัปโหลดวิดีโอได้เพียง 1 ไฟล์เท่านั้น",

                    confirmButtonText: "ตกลง"

                });


                return;
            }


            /*
            |--------------------------------------------------------------------------
            | ตรวจสอบขนาด
            |--------------------------------------------------------------------------
            */

            if (files.length === 1) {

                const file = files[0];


                const maxSize =
                    500 * 1024 * 1024;


                if (file.size > maxSize) {

                    $("#video").fileinput("clear");


                    Swal.fire({

                        icon: "error",

                        title: "ไฟล์ใหญ่เกินไป",

                        text:
                            "ขนาดวิดีโอต้องไม่เกิน 500 MB",

                        confirmButtonText: "ตกลง"

                    });


                    return;
                }

            }

        }
    );


    /*
    |--------------------------------------------------------------------------
    | Submit
    |--------------------------------------------------------------------------
    */

    $("#form-create").on(
        "submit",
        function (e) {

            e.preventDefault();


            if (uploading) {
                return;
            }


            /*
            |--------------------------------------------------------------------------
            | ตรวจสอบชื่อ
            |--------------------------------------------------------------------------
            */

            const name =
                $("#name").val().trim();


            if (!name) {

                Swal.fire({

                    icon: "warning",

                    title: "กรุณากรอกชื่อวิดีโอ",

                    confirmButtonText: "ตกลง"

                });

                $("#name").focus();

                return;
            }


            /*
            |--------------------------------------------------------------------------
            | ตรวจสอบไฟล์
            |--------------------------------------------------------------------------
            */

            const files =
                $("#video").fileinput(
                    "getFileList"
                );


            if (
                !files ||
                files.length === 0
            ) {

                Swal.fire({

                    icon: "warning",

                    title: "กรุณาเลือกวิดีโอ",

                    text:
                        "กรุณาเลือกวิดีโอที่ต้องการอัปโหลด",

                    confirmButtonText: "ตกลง"

                });

                return;
            }


            /*
            |--------------------------------------------------------------------------
            | ป้องกันกรณีมีมากกว่า 1 ไฟล์
            |--------------------------------------------------------------------------
            */

            if (files.length > 1) {

                Swal.fire({

                    icon: "warning",

                    title: "เลือกไฟล์ไม่ได้",

                    text:
                        "สามารถอัปโหลดวิดีโอได้เพียง 1 ไฟล์เท่านั้น",

                    confirmButtonText: "ตกลง"

                });

                return;
            }


            /*
            |--------------------------------------------------------------------------
            | เริ่ม Upload
            |--------------------------------------------------------------------------
            */

            uploading = true;


            $("#btn-submit")
                .prop("disabled", true)
                .html(
                    '<i class="fas fa-spinner fa-spin"></i> กำลังอัปโหลด...'
                );


            $("#video").fileinput("upload");

        }
    );


    /*
    |--------------------------------------------------------------------------
    | Upload Start
    |--------------------------------------------------------------------------
    */

    $("#video").on(
        "fileuploadstart",
        function () {

            console.log("เริ่ม Upload");

        }
    );


    /*
    |--------------------------------------------------------------------------
    | Upload Progress
    |--------------------------------------------------------------------------
    */

    $("#video").on(
        "fileuploadprogress",
        function (event, data) {

            if (
                data &&
                data.percentage !== undefined
            ) {

                const percent =
                    Math.round(
                        data.percentage
                    );


                $("#btn-submit").html(

                    '<i class="fas fa-spinner fa-spin"></i> ' +
                    'กำลังอัปโหลด ' +
                    percent +
                    '%'

                );

            }

        }
    );


    /*
    |--------------------------------------------------------------------------
    | Upload Success
    |--------------------------------------------------------------------------
    */

    $("#video").on(
        "fileuploaded",
        function (event, data) {

            console.log(
                "Upload สำเร็จ",
                data.response
            );


            uploading = false;


            if (
                data.response &&
                data.response.success
            ) {

                Swal.fire({

                    icon: "success",

                    title: "สำเร็จ!",

                    text:
                        "เพิ่มคู่มือการใช้งานเรียบร้อยแล้ว",

                    confirmButtonText: "ตกลง"

                }).then(function () {

                    window.location.href =
                        "{{ route('administrator.guide') }}";

                });

            } else {

                $("#btn-submit")
                    .prop("disabled", false)
                    .html(
                        '<i class="fas fa-save"></i> บันทึก'
                    );


                Swal.fire({

                    icon: "error",

                    title: "อัปโหลดไม่สำเร็จ",

                    text:
                        data.response?.message ||
                        "เกิดข้อผิดพลาดในการอัปโหลด",

                    confirmButtonText: "ตกลง"

                });

            }

        }
    );


    /*
    |--------------------------------------------------------------------------
    | Upload Error
    |--------------------------------------------------------------------------
    */

    $("#video").on(
        "fileuploaderror",
        function (event, data) {

            console.error(
                "Upload Error:",
                data
            );


            uploading = false;


            $("#btn-submit")
                .prop("disabled", false)
                .html(
                    '<i class="fas fa-save"></i> บันทึก'
                );


            let message =
                "เกิดข้อผิดพลาดในการอัปโหลดวิดีโอ";


            if (
                data &&
                data.jqXHR &&
                data.jqXHR.responseJSON
            ) {

                const response =
                    data.jqXHR.responseJSON;


                if (response.message) {

                    message =
                        response.message;

                }


                if (
                    response.errors &&
                    response.errors.video
                ) {

                    message =
                        response.errors.video[0];

                }

            }


            Swal.fire({

                icon: "error",

                title: "อัปโหลดไม่สำเร็จ",

                text: message,

                confirmButtonText: "ตกลง"

            });

        }
    );


    /*
    |--------------------------------------------------------------------------
    | Clear
    |--------------------------------------------------------------------------
    */

    $("#video").on(
        "filecleared",
        function () {

            uploading = false;


            $("#btn-submit")
                .prop("disabled", false)
                .html(
                    '<i class="fas fa-save"></i> บันทึก'
                );

        }
    );

});

    </script>

@endsection