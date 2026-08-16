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
            แก้ไขคู่มือการใช้งาน
        </li>

    </ol>


    <div class="card shadow-lg border-0 rounded-4">

        <div class="card-header text-white rounded-top-4">

            <h5 class="mb-0">
                <i class="fas fa-edit"></i>
                แก้ไขคู่มือการใช้งาน
            </h5>

        </div>


        <div class="card-body">

            <form
                id="form-edit"
                method="POST"
                action="{{ route('administrator.guide.update', $guide->id) }}"
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

                            <span class="text-danger">
                                *
                            </span>

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
                                value="{{ old('name', $guide->video_name) }}"
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

                            <label
                                class="fw-bold w-100 d-block"
                                for="video"
                            >

                                วิดีโอ

                                <span class="text-danger">
                                    *
                                </span>

                            </label>


                            <div class="mb-3">

                                <label class="form-label fw-bold">
                                    วิดีโอปัจจุบัน / เปลี่ยนวิดีโอ
                                </label>


                                <input
                                    type="file"
                                    name="video"
                                    id="video"
                                    accept="video/mp4,video/webm,video/ogg,video/quicktime,video/x-ms-wmv"
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
                                {{ old('status', $guide->status) ? 'checked' : '' }}
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

                            บันทึกการแก้ไข

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

<script>

$(document).ready(function () {

    /*
    |--------------------------------------------------------------------------
    | ตัวแปร
    |--------------------------------------------------------------------------
    */

    let uploading = false;

    let videoReady = true;


    /*
    |--------------------------------------------------------------------------
    | วิดีโอเดิม
    |--------------------------------------------------------------------------
    */

    let oldVideoUrl = @json(
        $guide->link_video
            ? asset('upload/' . $guide->link_video)
            : null
    );


    /*
    |--------------------------------------------------------------------------
    | ชื่อไฟล์เดิม
    |--------------------------------------------------------------------------
    */

    let oldVideoName = @json(
        $guide->link_video
            ? basename($guide->link_video)
            : null
    );


    /*
    |--------------------------------------------------------------------------
    | MIME Type
    |--------------------------------------------------------------------------
    */

    function getVideoMimeType(url) {

        if (!url) {

            return "video/mp4";

        }


        let extension =
            url
                .split("?")[0]
                .split(".")
                .pop()
                .toLowerCase();


        switch (extension) {

            case "mp4":

                return "video/mp4";


            case "webm":

                return "video/webm";


            case "ogg":

                return "video/ogg";


            case "mov":

                return "video/quicktime";


            case "wmv":

                return "video/x-ms-wmv";


            default:

                return "video/mp4";

        }

    }



    /*
    |--------------------------------------------------------------------------
    | Krajee
    |--------------------------------------------------------------------------
    */

    $("#video").fileinput({

        theme: "fa5",


        /*
        |--------------------------------------------------------------------------
        | Upload URL
        |--------------------------------------------------------------------------
        */

        uploadUrl:
            "{{ route('administrator.guide.update', $guide->id) }}",


        uploadAsync: true,


        /*
        |--------------------------------------------------------------------------
        | File Extensions
        |--------------------------------------------------------------------------
        */

        allowedFileExtensions: [

            "mp4",

            "webm",

            "ogg",

            "mov",

            "wmv"

        ],


        /*
        |--------------------------------------------------------------------------
        | 500 MB
        |--------------------------------------------------------------------------
        */

        maxFileSize: 512000,


        /*
        |--------------------------------------------------------------------------
        | เลือกได้ 1 ไฟล์
        |--------------------------------------------------------------------------
        */

        maxFileCount: 1,


        /*
        |--------------------------------------------------------------------------
        | Preview
        |--------------------------------------------------------------------------
        */

        showUpload: false,

        showRemove: true,

        showPreview: true,

        previewFileType: "video",


        /*
        |--------------------------------------------------------------------------
        | Browse
        |--------------------------------------------------------------------------
        */

        browseClass:
            "btn btn-primary",


        /*
        |--------------------------------------------------------------------------
        | แสดงวิดีโอเดิมใน Krajee
        |--------------------------------------------------------------------------
        */

        initialPreview:
            oldVideoUrl
                ? [
                    oldVideoUrl
                ]
                : [],


        initialPreviewAsData:
            true,


        initialPreviewFileType:
            "video",


        initialPreviewConfig:
            oldVideoUrl
                ? [
                    {

                        type:
                            "video",

                        filetype:
                            getVideoMimeType(
                                oldVideoUrl
                            ),

                        caption:
                            oldVideoName,

                        key:
                            1

                    }
                ]
                : [],


        /*
        |--------------------------------------------------------------------------
        | ข้อมูลเพิ่มเติม
        |--------------------------------------------------------------------------
        */

        uploadExtraData: function () {

            return {

                _token:
                    "{{ csrf_token() }}",

                name:
                    $("#name").val(),

                status:
                    $("#status").is(":checked")
                        ? 1
                        : 0

            };

        },


        /*
        |--------------------------------------------------------------------------
        | Preview Action
        |--------------------------------------------------------------------------
        */

        fileActionSettings: {

            showUpload: false,

            showRemove: true

        },


        /*
        |--------------------------------------------------------------------------
        | ภาษาไทย
        |--------------------------------------------------------------------------
        */

        msgPlaceholder:
            "เลือกวิดีโอใหม่...",


        msgUploadBegin:
            "กำลังอัปโหลด...",


        msgUploadEnd:
            "อัปโหลดเสร็จสิ้น",


        msgInvalidFileExtension:
            "ไฟล์ไม่ถูกต้อง รองรับเฉพาะไฟล์ MP4, WEBM, OGG, MOV และ WMV",


        msgInvalidFileSize:
            "ไฟล์มีขนาดใหญ่เกินไป รองรับขนาดไม่เกิน 500 MB",


        msgFilesTooMany:
            "สามารถเลือกวิดีโอได้เพียง 1 ไฟล์เท่านั้น",


        msgFileNotFound:
            "ไม่พบไฟล์",


        msgFileNotReadable:
            "ไม่สามารถอ่านไฟล์ได้",


        msgFilePreviewError:
            "ไม่สามารถแสดงตัวอย่างวิดีโอได้",


        msgUploadError:
            "เกิดข้อผิดพลาดในการอัปโหลดไฟล์",


        msgUploadRetry:
            "ลองอัปโหลดใหม่",


        msgUploadAborted:
            "ยกเลิกการอัปโหลด",


        msgUploadEmpty:
            "ไม่มีไฟล์สำหรับอัปโหลด",


        msgValidationError:
            "ไฟล์ไม่ผ่านการตรวจสอบ"

    });



    /*
    |--------------------------------------------------------------------------
    | เลือกไฟล์ใหม่
    |--------------------------------------------------------------------------
    */

    $("#video").on(
        "fileloaded",
        function (
            event,
            file
        ) {

            console.log(
                "เลือกวิดีโอใหม่แล้ว:",
                file.name
            );


            videoReady = false;


            $("#btn-submit")
                .prop(
                    "disabled",
                    true
                )
                .html(
                    '<i class="fas fa-spinner fa-spin"></i> กรุณารอการเตรียมวิดีโอ...'
                );

        }
    );



    /*
    |--------------------------------------------------------------------------
    | Preview ใหม่พร้อม
    |--------------------------------------------------------------------------
    */

    $("#video").on(
        "filepreviewloaded",
        function (
            event,
            previewId,
            index
        ) {

            console.log(
                "Preview วิดีโอพร้อมแล้ว"
            );


            videoReady = true;


            $("#btn-submit")
                .prop(
                    "disabled",
                    false
                )
                .html(
                    '<i class="fas fa-save"></i> บันทึกการแก้ไข'
                );

        }
    );



    /*
    |--------------------------------------------------------------------------
    | เลือกไฟล์
    |--------------------------------------------------------------------------
    */

    $("#video").on(
        "filebatchselected",
        function () {

            let files =
                $("#video")
                    .fileinput(
                        "getFileList"
                    );


            console.log(
                "จำนวนไฟล์:",
                files.length
            );


            if (
                files.length > 1
            ) {

                $("#video")
                    .fileinput(
                        "clear"
                    );


                videoReady = true;


                $("#btn-submit")
                    .prop(
                        "disabled",
                        false
                    )
                    .html(
                        '<i class="fas fa-save"></i> บันทึกการแก้ไข'
                    );


                Swal.fire({

                    icon:
                        "warning",

                    title:
                        "เลือกไฟล์ไม่ได้",

                    text:
                        "สามารถเลือกวิดีโอได้เพียง 1 ไฟล์เท่านั้น",

                    confirmButtonText:
                        "ตกลง"

                });

            }

        }
    );



    /*
    |--------------------------------------------------------------------------
    | ลบไฟล์ใหม่
    |--------------------------------------------------------------------------
    */

    $("#video").on(
        "filecleared",
        function () {

            console.log(
                "ลบวิดีโอที่เลือก"
            );


            videoReady = true;


            /*
            |--------------------------------------------------------------------------
            | กลับมาใช้วิดีโอเดิม
            |--------------------------------------------------------------------------
            */

            if (oldVideoUrl) {

                setTimeout(
                    function () {

                        $("#video").fileinput(
                            "refresh",
                            {

                                initialPreview: [

                                    oldVideoUrl

                                ],

                                initialPreviewAsData:
                                    true,

                                initialPreviewFileType:
                                    "video",

                                initialPreviewConfig: [

                                    {

                                        type:
                                            "video",

                                        filetype:
                                            getVideoMimeType(
                                                oldVideoUrl
                                            ),

                                        caption:
                                            oldVideoName,

                                        key:
                                            1

                                    }

                                ]

                            }
                        );

                    },
                    100
                );

            }


            $("#btn-submit")
                .prop(
                    "disabled",
                    false
                )
                .html(
                    '<i class="fas fa-save"></i> บันทึกการแก้ไข'
                );

        }
    );



    /*
    |--------------------------------------------------------------------------
    | Submit
    |--------------------------------------------------------------------------
    */

    $("#form-edit").on(
        "submit",
        function (e) {

            e.preventDefault();


            /*
            |--------------------------------------------------------------------------
            | ป้องกันกดซ้ำ
            |--------------------------------------------------------------------------
            */

            if (uploading) {

                return;

            }


            /*
            |--------------------------------------------------------------------------
            | ตรวจสอบชื่อ
            |--------------------------------------------------------------------------
            */

            let name =
                $("#name")
                    .val()
                    .trim();


            if (!name) {

                Swal.fire({

                    icon:
                        "warning",

                    title:
                        "กรุณากรอกชื่อวิดีโอ",

                    confirmButtonText:
                        "ตกลง"

                });

                return;

            }


            /*
            |--------------------------------------------------------------------------
            | ตรวจสอบว่ามีไฟล์ใหม่หรือไม่
            |--------------------------------------------------------------------------
            */

            let files =
                $("#video")
                    .fileinput(
                        "getFileList"
                    );


            /*
            |--------------------------------------------------------------------------
            | มีไฟล์ใหม่ แต่ Preview ยังไม่พร้อม
            |--------------------------------------------------------------------------
            */

            if (
                files &&
                files.length > 0 &&
                !videoReady
            ) {

                Swal.fire({

                    icon:
                        "info",

                    title:
                        "กรุณารอ",

                    text:
                        "กรุณารอการเตรียมวิดีโอให้เสร็จก่อนบันทึก",

                    confirmButtonText:
                        "ตกลง"

                });

                return;

            }


            /*
            |--------------------------------------------------------------------------
            | ไม่มีวิดีโอใหม่
            |--------------------------------------------------------------------------
            */

            if (
                !files ||
                files.length === 0
            ) {

                uploading = true;


                $("#btn-submit")
                    .prop(
                        "disabled",
                        true
                    )
                    .html(
                        '<i class="fas fa-spinner fa-spin"></i> กำลังบันทึก...'
                    );


                /*
                | สำคัญ
                |
                | Submit Form ปกติ
                */

                this.submit();


                return;

            }


            /*
            |--------------------------------------------------------------------------
            | มีวิดีโอใหม่
            |--------------------------------------------------------------------------
            */

            uploading = true;


            $("#btn-submit")
                .prop(
                    "disabled",
                    true
                )
                .html(
                    '<i class="fas fa-spinner fa-spin"></i> กำลังอัปโหลด...'
                );


            /*
            |--------------------------------------------------------------------------
            | Upload Krajee
            |--------------------------------------------------------------------------
            */

            $("#video")
                .fileinput(
                    "upload"
                );

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

            console.log(
                "เริ่ม Upload"
            );


            $("#btn-submit")
                .prop(
                    "disabled",
                    true
                )
                .html(
                    '<i class="fas fa-spinner fa-spin"></i> กำลังอัปโหลด...'
                );

        }
    );



    /*
    |--------------------------------------------------------------------------
    | Upload Progress
    |--------------------------------------------------------------------------
    */

    $("#video").on(
        "fileuploadprogress",
        function (
            event,
            data
        ) {

            if (
                data &&
                data.percentage !== undefined
            ) {

                let percent =
                    Math.round(
                        data.percentage
                    );


                $("#btn-submit")
                    .html(

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
        function (
            event,
            data
        ) {

            console.log(
                "Upload สำเร็จ"
            );


            console.log(
                data.response
            );


            uploading = false;


            /*
            |--------------------------------------------------------------------------
            | สำเร็จ
            |--------------------------------------------------------------------------
            */

            if (
                data.response &&
                data.response.success === true
            ) {

                Swal.fire({

                    icon:
                        "success",

                    title:
                        "สำเร็จ!",

                    text:
                        data.response.message ||
                        "แก้ไขคู่มือการใช้งานเรียบร้อยแล้ว",

                    confirmButtonText:
                        "ตกลง"

                }).then(
                    function () {

                        window.location.href =
                            "{{ route('administrator.guide') }}";

                    }
                );


                return;

            }


            /*
            |--------------------------------------------------------------------------
            | success false
            |--------------------------------------------------------------------------
            */

            $("#btn-submit")
                .prop(
                    "disabled",
                    false
                )
                .html(
                    '<i class="fas fa-save"></i> บันทึกการแก้ไข'
                );


            Swal.fire({

                icon:
                    "error",

                title:
                    "ไม่สามารถบันทึกได้",

                text:

                    data.response &&
                    data.response.message

                        ? data.response.message

                        : "เกิดข้อผิดพลาดในการบันทึก",

                confirmButtonText:
                    "ตกลง"

            });

        }
    );



    /*
    |--------------------------------------------------------------------------
    | Upload Error
    |--------------------------------------------------------------------------
    */

    $("#video").on(
        "fileuploaderror",
        function (
            event,
            data
        ) {

            console.log(
                "Upload Error"
            );


            console.log(
                data
            );


            uploading = false;


            $("#btn-submit")
                .prop(
                    "disabled",
                    false
                )
                .html(
                    '<i class="fas fa-save"></i> บันทึกการแก้ไข'
                );


            let message =
                "เกิดข้อผิดพลาดในการอัปโหลดวิดีโอ";


            /*
            |--------------------------------------------------------------------------
            | Laravel JSON Error
            |--------------------------------------------------------------------------
            */

            if (
                data.jqXHR &&
                data.jqXHR.responseJSON
            ) {

                let response =
                    data.jqXHR.responseJSON;


                /*
                |--------------------------------------------------------------------------
                | Validation Error
                |--------------------------------------------------------------------------
                */

                if (
                    response.errors &&
                    response.errors.video &&
                    response.errors.video.length > 0
                ) {

                    message =
                        response.errors.video[0];

                }


                /*
                |--------------------------------------------------------------------------
                | Message
                |--------------------------------------------------------------------------
                */

                else if (
                    response.message
                ) {

                    message =
                        response.message;

                }

            }


            Swal.fire({

                icon:
                    "error",

                title:
                    "อัปโหลดไม่สำเร็จ",

                text:
                    message,

                confirmButtonText:
                    "ตกลง"

            });

        }
    );



    /*
    |--------------------------------------------------------------------------
    | Krajee File Error
    |--------------------------------------------------------------------------
    */

    $("#video").on(
        "fileerror",
        function (
            event,
            data,
            msg
        ) {

            console.log(
                "Krajee Error:",
                msg
            );


            videoReady = false;


            $("#btn-submit")
                .prop(
                    "disabled",
                    true
                );


            Swal.fire({

                icon:
                    "error",

                title:
                    "ไฟล์ไม่ถูกต้อง",

                text:
                    msg ||
                    "ไม่สามารถเลือกไฟล์นี้ได้",

                confirmButtonText:
                    "ตกลง"

            });

        }
    );

});

</script>

@endsection