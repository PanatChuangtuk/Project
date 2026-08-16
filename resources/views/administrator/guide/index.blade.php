@extends('administrator.layouts.main')

@section('title')
@endsection


@section('stylesheet')

    {{-- ==========================================================
        SWEETALERT
    =========================================================== --}}

    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css"
    >


    {{-- ==========================================================
        PLYR
    =========================================================== --}}

    <link
        rel="stylesheet"
        href="https://cdn.plyr.io/3.8.4/plyr.css"
    >


    <style>

        /* ==========================================================
           VIDEO MODAL
        ========================================================== */

        #customVideoModal {

            display: none;

            position: fixed;

            top: 0;
            left: 0;

            width: 100%;
            height: 100%;

            background: rgba(0, 0, 0, 0.85);

            z-index: 9999;

            justify-content: center;

            align-items: center;

            padding: 20px;

        }


        /* ==========================================================
           VIDEO CONTAINER
        ========================================================== */

        .video-modal-container {

            width: 90%;

            max-width: 1000px;

            background: #111;

            padding: 20px;

            border-radius: 10px;

            position: relative;

            box-shadow:
                0 10px 40px rgba(0, 0, 0, 0.5);

        }


        /* ==========================================================
           CLOSE BUTTON
        ========================================================== */

        .video-modal-close {

            position: absolute;

            right: 10px;

            top: 5px;

            width: 40px;

            height: 40px;

            border: none;

            background: transparent;

            color: #fff;

            font-size: 32px;

            line-height: 40px;

            cursor: pointer;

            z-index: 20;

        }


        .video-modal-close:hover {

            color: #ff4444;

        }


        /* ==========================================================
           PLYR
        ========================================================== */

        #plyr-player-target {

            width: 100%;

        }


        #plyr-player-target video {

            width: 100%;

            display: block;

        }


        /* ==========================================================
           MOBILE
        ========================================================== */

        @media (max-width: 768px) {

            #customVideoModal {

                padding: 10px;

            }


            .video-modal-container {

                width: 100%;

                padding: 10px;

            }

        }

    </style>

@endsection



@section('content')


    {{-- ==========================================================
        VIDEO MODAL
    =========================================================== --}}

    <div id="customVideoModal">

        <div
            class="video-modal-container"
            id="videoModalContainer"
        >

            <button
                type="button"
                class="video-modal-close"
                id="closeVideoButton"
                aria-label="ปิด"
            >
                ×
            </button>


            {{-- ==================================================
                PLYR TARGET
            =================================================== --}}

            <div id="plyr-player-target"></div>

        </div>

    </div>



    {{-- ==========================================================
        MAIN CONTENT
    =========================================================== --}}

    <div class="row">

        <div class="col-md-12">


            {{-- ==================================================
                BREADCRUMB
            =================================================== --}}

            <ol class="breadcrumb bg-light p-3 rounded shadow-sm">

                <li class="breadcrumb-item">

                    <a
                        href="{{ route('administrator.dashboard') }}"
                    >
                        หน้าหลัก
                    </a>

                </li>


                <li class="breadcrumb-item">

                    <a
                        href="{{ route('administrator.guide') }}"
                    >
                        วิดีโอแนะนำการใช้งานระบบ
                    </a>

                </li>

            </ol>



            {{-- ==================================================
                CARD
            =================================================== --}}

            <div class="card">

                <div class="card-body">


                    {{-- ==================================================
                        SEARCH + ADD
                    =================================================== --}}

                    <div
                        class="d-flex justify-content-between align-items-center p-3"
                    >

                        <form
                            action="{{ route('administrator.guide') }}"
                            method="GET"
                            class="d-flex justify-content-between align-items-center w-100"
                        >


                            {{-- SEARCH --}}

                            <x-search />


                            {{-- ADD --}}

                            <div
                                class="d-flex align-items-center ms-2"
                            >

                                <a
                                    href="{{ route('administrator.guide.add') }}"
                                    class="btn btn-primary d-flex align-items-center"
                                    style="white-space: nowrap;"
                                >

                                    <i class="bx bx-plus me-1"></i>

                                    เพิ่มข้อมูล

                                </a>

                            </div>

                        </form>

                    </div>



                    {{-- ==================================================
                        TABLE
                    =================================================== --}}

                    <div class="table-responsive text-nowrap">

                        <table class="table table-hover">


                            {{-- ==================================================
                                TABLE HEADER
                            =================================================== --}}

                            <thead>

                                <tr>


                                    {{-- CHECK ALL --}}

                                    <th style="font-size: 1rem;">

                                        <div class="form-check">

                                            <input
                                                class="form-check-input check-item"
                                                type="checkbox"
                                                id="checkAll"
                                            />

                                        </div>

                                    </th>


                                    {{-- NUMBER --}}

                                    <th>
                                        ลำดับ
                                    </th>


                                    {{-- VIDEO NAME --}}

                                    <th class="text-center">
                                        ชื่อวีดีโอ
                                    </th>


                                    {{-- CREATOR --}}

                                    <th class="text-center">
                                        ผู้อัปโหลด
                                    </th>


                                    {{-- DATE --}}

                                    <th class="text-center">
                                        วันที่สร้าง
                                    </th>


                                    {{-- VIDEO --}}

                                    <th class="text-center">
                                        วีดีโอ
                                    </th>


                                    {{-- ACTION --}}

                                    <th class="text-center">
                                        การจัดการ
                                    </th>

                                </tr>

                            </thead>



                            {{-- ==================================================
                                TABLE BODY
                            =================================================== --}}

                            <tbody
                                class="table-border-bottom-0"
                                id="userTableBody"
                            >


                                @forelse ($users as $item)


                                    <tr>


                                        {{-- ==================================================
                                            CHECKBOX
                                        =================================================== --}}

                                        <td>

                                            <div
                                                class="form-check"
                                                style="font-size: 1rem;"
                                            >

                                                <input
                                                    type="checkbox"
                                                    class="form-check-input check-item"
                                                    value="{{ $item->id }}"
                                                >

                                            </div>

                                        </td>



                                        {{-- ==================================================
                                            NUMBER
                                        =================================================== --}}

                                        <td>

                                            {{ $users->firstItem() + $loop->index }}

                                        </td>



                                        {{-- ==================================================
                                            VIDEO NAME
                                        =================================================== --}}

                                        <td>

                                            <div class="text-center">

                                                {{ $item->video_name }}

                                            </div>

                                        </td>



                                        {{-- ==================================================
                                            CREATOR
                                        =================================================== --}}

                                        <td class="text-center">

                                            {{ $item->creator->email ?? '-' }}

                                        </td>



                                        {{-- ==================================================
                                            CREATED DATE
                                        =================================================== --}}

                                        <td class="text-center">

                                            {{ $item->created_at->format('d/m/Y') }}

                                        </td>



                                        {{-- ==================================================
                                            VIDEO
                                        =================================================== --}}

                                        <td class="text-center">


                                            @if ($item->link_video)


                                                @php

                                                    /*
                                                    |--------------------------------------------------------------------------
                                                    | สร้าง URL สำหรับ Video Stream
                                                    |--------------------------------------------------------------------------
                                                    |
                                                    | สำคัญ:
                                                    |
                                                    | ห้ามใช้:
                                                    |
                                                    | Storage::disk('public')->url(...)
                                                    |
                                                    | เพราะจะทำให้ Browser ไปโหลดไฟล์
                                                    | โดยตรง
                                                    |
                                                    | เราต้องผ่าน VideoStreamController
                                                    |
                                                    */

                                                    $videoUrl = route(
                                                        'video.stream',
                                                        [
                                                            'id' => $item->id
                                                        ]
                                                    );

                                                @endphp


                                                <button
                                                    type="button"
                                                    class="btn btn-primary btn-play-video"
                                                    data-video-url="{{ $videoUrl }}"
                                                >

                                                    <i class="bx bx-play-circle me-1"></i>

                                                    ดูวิดีโอ

                                                </button>


                                            @else


                                                <span class="text-muted">

                                                    ไม่มีวิดีโอ

                                                </span>


                                            @endif


                                        </td>



                                        {{-- ==================================================
                                            ACTIONS
                                        =================================================== --}}

                                        <td>

                                            <div
                                                class="d-flex justify-content-center"
                                            >

                                                <div
                                                    class="d-inline-block text-nowrap"
                                                >


                                                    {{-- ==================================================
                                                        EDIT
                                                    =================================================== --}}

                                                    <a
                                                        class="btn btn-icon btn-outline-primary border-0 custom-tooltip"
                                                        data-tooltip="แก้ไข"
                                                        href="{{ route(
                                                            'administrator.guide.edit',
                                                            [
                                                                'id' => $item->id
                                                            ]
                                                        ) }}"
                                                    >

                                                        <i class="bx bx-edit"></i>

                                                    </a>



                                                    {{-- ==================================================
                                                        DELETE
                                                    =================================================== --}}

                                                    <form
                                                        id="deleteForm{{ $item->id }}"
                                                        action="{{ route(
                                                            'administrator.guide.destroy',
                                                            [
                                                                'id' => $item->id,
                                                                'page' => request()->get('page')
                                                            ]
                                                        ) }}"
                                                        method="POST"
                                                        style="display:inline;"
                                                    >

                                                        @csrf

                                                        @method('DELETE')


                                                        <button
                                                            type="button"
                                                            class="btn btn-icon btn-outline-danger border-0 btn-delete custom-tooltip"
                                                            data-tooltip="ลบ"
                                                            data-id="{{ $item->id }}"
                                                        >

                                                            <i class="bx bx-trash"></i>

                                                        </button>

                                                    </form>


                                                </div>

                                            </div>

                                        </td>


                                    </tr>


                                @empty


                                    <tr>

                                        <td
                                            colspan="7"
                                            class="text-center text-muted py-4"
                                        >

                                            ไม่พบข้อมูล

                                        </td>

                                    </tr>


                                @endforelse


                            </tbody>

                        </table>



                        {{-- ==================================================
                            PAGINATION
                        =================================================== --}}

                        <div>

                            {!! $users->links() !!}

                        </div>


                    </div>

                </div>

            </div>

        </div>

    </div>


@endsection



@section('script')


    {{-- ==========================================================
        JQUERY
    =========================================================== --}}

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


    {{-- ==========================================================
        SWEETALERT
    =========================================================== --}}

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    {{-- ==========================================================
        DELETE JS
    =========================================================== --}}

    <script src="{{ asset('js/delete.js') }}"></script>


    {{-- ==========================================================
        PLYR
    =========================================================== --}}

    <script src="https://cdn.plyr.io/3.8.4/plyr.js"></script>



    <script>


        /*
        |--------------------------------------------------------------------------
        | GLOBAL PLYR INSTANCE
        |--------------------------------------------------------------------------
        */

        let plyrInstance = null;



        /*
        |--------------------------------------------------------------------------
        | DOM READY
        |--------------------------------------------------------------------------
        */

        document.addEventListener(
            'DOMContentLoaded',
            function () {


                /*
                |--------------------------------------------------------------------------
                | ปุ่มดูวิดีโอ
                |--------------------------------------------------------------------------
                */

                const playButtons =
                    document.querySelectorAll(
                        '.btn-play-video'
                    );


                playButtons.forEach(
                    function (button) {


                        button.addEventListener(
                            'click',
                            function () {


                                const videoUrl =
                                    this.getAttribute(
                                        'data-video-url'
                                    );


                                playVideoInModal(
                                    videoUrl
                                );

                            }
                        );

                    }
                );


                /*
                |--------------------------------------------------------------------------
                | ปุ่มปิด
                |--------------------------------------------------------------------------
                */

                const closeButton =
                    document.getElementById(
                        'closeVideoButton'
                    );


                if (closeButton) {

                    closeButton.addEventListener(
                        'click',
                        function () {

                            closeVideoModal();

                        }
                    );

                }


                /*
                |--------------------------------------------------------------------------
                | Click พื้นหลัง Modal
                |--------------------------------------------------------------------------
                */

                const modal =
                    document.getElementById(
                        'customVideoModal'
                    );


                if (modal) {

                    modal.addEventListener(
                        'click',
                        function (event) {


                            /*
                            |--------------------------------------------------------------------------
                            | ถ้าคลิกเฉพาะพื้นหลัง
                            |--------------------------------------------------------------------------
                            */

                            if (
                                event.target === modal
                            ) {

                                closeVideoModal();

                            }

                        }
                    );

                }


                /*
                |--------------------------------------------------------------------------
                | ESC
                |--------------------------------------------------------------------------
                */

                document.addEventListener(
                    'keydown',
                    function (event) {


                        if (
                            event.key === 'Escape'
                        ) {

                            closeVideoModal();

                        }

                    }
                );


            }
        );



        /*
        |--------------------------------------------------------------------------
        | PLAY VIDEO
        |--------------------------------------------------------------------------
        */

        function playVideoInModal(videoUrl)
        {


            /*
            |--------------------------------------------------------------------------
            | ตรวจสอบ URL
            |--------------------------------------------------------------------------
            */

            if (!videoUrl) {

                Swal.fire({

                    title: 'ข้อผิดพลาด',

                    text: 'ไม่พบ URL ของวิดีโอ',

                    icon: 'error'

                });

                return;
            }


            console.log(
                'Video Stream URL:',
                videoUrl
            );



            /*
            |--------------------------------------------------------------------------
            | หา Modal
            |--------------------------------------------------------------------------
            */

            const modal =
                document.getElementById(
                    'customVideoModal'
                );


            const playerTarget =
                document.getElementById(
                    'plyr-player-target'
                );


            if (
                !modal ||
                !playerTarget
            ) {

                console.error(
                    'ไม่พบ Video Modal'
                );

                return;
            }



            /*
            |--------------------------------------------------------------------------
            | เปิด Modal
            |--------------------------------------------------------------------------
            */

            modal.style.display = 'flex';



            /*
            |--------------------------------------------------------------------------
            | Destroy Plyr เดิม
            |--------------------------------------------------------------------------
            */

            if (plyrInstance) {

                try {

                    plyrInstance.stop();

                    plyrInstance.destroy();

                } catch (error) {

                    console.error(
                        'Destroy Plyr Error:',
                        error
                    );

                }

                plyrInstance = null;
            }



            /*
            |--------------------------------------------------------------------------
            | ล้าง Video เดิม
            |--------------------------------------------------------------------------
            */

            playerTarget.innerHTML = '';



            /*
            |--------------------------------------------------------------------------
            | สร้าง Video Element
            |--------------------------------------------------------------------------
            */

            const video =
                document.createElement(
                    'video'
                );


            video.id =
                'plyr-video';


            video.setAttribute(
                'playsinline',
                ''
            );


            video.setAttribute(
                'controls',
                ''
            );


            /*
            |--------------------------------------------------------------------------
            | สำคัญ
            |--------------------------------------------------------------------------
            |
            | metadata เท่านั้น
            |
            | Browser จะไม่พยายามโหลดไฟล์ทั้งหมด
            | ตั้งแต่เปิด Modal
            |
            */

            video.setAttribute(
                'preload',
                'metadata'
            );


            video.style.width =
                '100%';



            /*
            |--------------------------------------------------------------------------
            | Source
            |--------------------------------------------------------------------------
            */

            const source =
                document.createElement(
                    'source'
                );


            source.src =
                videoUrl;


            source.type =
                'video/mp4';


            video.appendChild(
                source
            );


            playerTarget.appendChild(
                video
            );



            /*
            |--------------------------------------------------------------------------
            | สร้าง Plyr
            |--------------------------------------------------------------------------
            */

            plyrInstance =
                new Plyr(
                    video,
                    {

                        controls: [

                            'play-large',

                            'play',

                            'progress',

                            'current-time',

                            'duration',

                            'mute',

                            'volume',

                            'settings',

                            'fullscreen'

                        ],

                        settings: [

                            'speed'

                        ],

                        invertTime: false,

                        resetOnEnd: false,

                        seekTime: 10

                    }
                );



            /*
            |--------------------------------------------------------------------------
            | LOAD START
            |--------------------------------------------------------------------------
            */

            video.addEventListener(
                'loadstart',
                function () {

                    console.log(
                        'เริ่มโหลดวิดีโอ'
                    );

                }
            );



            /*
            |--------------------------------------------------------------------------
            | LOADED METADATA
            |--------------------------------------------------------------------------
            */

            video.addEventListener(
                'loadedmetadata',
                function () {


                    console.log(
                        'Video metadata loaded'
                    );


                    console.log(
                        'Duration:',
                        video.duration
                    );


                    console.log(
                        'Video URL:',
                        videoUrl
                    );

                },
                {
                    once: true
                }
            );



            /*
            |--------------------------------------------------------------------------
            | PROGRESS
            |--------------------------------------------------------------------------
            */

            video.addEventListener(
                'progress',
                function () {

                    console.log(
                        'Browser กำลังโหลดข้อมูลวิดีโอ'
                    );

                }
            );



            /*
            |--------------------------------------------------------------------------
            | CAN PLAY
            |--------------------------------------------------------------------------
            */

            video.addEventListener(
                'canplay',
                function () {

                    console.log(
                        'Video พร้อมเล่น'
                    );

                },
                {
                    once: true
                }
            );



            /*
            |--------------------------------------------------------------------------
            | PLAYING
            |--------------------------------------------------------------------------
            */

            video.addEventListener(
                'playing',
                function () {

                    console.log(
                        'Video กำลังเล่น'
                    );

                }
            );



            /*
            |--------------------------------------------------------------------------
            | WAITING / BUFFER
            |--------------------------------------------------------------------------
            */

            video.addEventListener(
                'waiting',
                function () {

                    console.log(
                        'Video กำลัง Buffer'
                    );

                }
            );



            /*
            |--------------------------------------------------------------------------
            | SEEKING
            |--------------------------------------------------------------------------
            */

            video.addEventListener(
                'seeking',
                function () {

                    console.log(
                        'กำลัง Seek:',
                        video.currentTime
                    );

                }
            );



            /*
            |--------------------------------------------------------------------------
            | SEEKED
            |--------------------------------------------------------------------------
            */

            video.addEventListener(
                'seeked',
                function () {

                    console.log(
                        'Seek สำเร็จ:',
                        video.currentTime
                    );

                }
            );



            /*
            |--------------------------------------------------------------------------
            | ERROR
            |--------------------------------------------------------------------------
            */

            video.addEventListener(
                'error',
                function () {


                    console.error(
                        'Video Error:',
                        video.error
                    );


                    if (video.error) {

                        console.error(
                            'Error Code:',
                            video.error.code
                        );


                        console.error(
                            'Error Message:',
                            video.error.message
                        );

                    }


                    Swal.fire({

                        title:
                            'ไม่สามารถเล่นวิดีโอได้',

                        text:
                            'กรุณาตรวจสอบไฟล์วิดีโอหรือ Video Stream',

                        icon:
                            'error'

                    });

                }
            );



            /*
            |--------------------------------------------------------------------------
            | LOAD
            |--------------------------------------------------------------------------
            */

            video.load();

        }



        /*
        |--------------------------------------------------------------------------
        | CLOSE VIDEO MODAL
        |--------------------------------------------------------------------------
        */

        function closeVideoModal()
        {


            const modal =
                document.getElementById(
                    'customVideoModal'
                );


            const playerTarget =
                document.getElementById(
                    'plyr-player-target'
                );



            /*
            |--------------------------------------------------------------------------
            | Destroy Plyr
            |--------------------------------------------------------------------------
            */

            if (plyrInstance) {

                try {

                    plyrInstance.stop();

                    plyrInstance.destroy();

                } catch (error) {

                    console.error(
                        'Destroy Plyr Error:',
                        error
                    );

                }

                plyrInstance = null;
            }



            /*
            |--------------------------------------------------------------------------
            | ล้าง Video
            |--------------------------------------------------------------------------
            */

            if (playerTarget) {

                playerTarget.innerHTML = '';

            }



            /*
            |--------------------------------------------------------------------------
            | ปิด Modal
            |--------------------------------------------------------------------------
            */

            if (modal) {

                modal.style.display = 'none';

            }

        }



        /*
        |--------------------------------------------------------------------------
        | BULK DELETE URL
        |--------------------------------------------------------------------------
        */

        const currentPath =
            window.location.pathname;


        const bulkDeleteUrl =
            currentPath.endsWith('/')
                ? currentPath + 'bulk-delete'
                : currentPath + '/bulk-delete';


    </script>

@endsection