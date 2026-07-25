@extends('administrator.layouts.main')

@section('title')
@endsection

@section('stylesheet')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="https://cdn.plyr.io/3.8.4/plyr.css" />
@endsection

@section('content')
    <div id="customVideoModal"
        style="display:none;position:fixed;top:0;left:0;width:100%;height:100%;
    background:rgba(0,0,0,.8);z-index:9999;justify-content:center;align-items:center;">

        <div style="width:90%;max-width:900px;background:#111;padding:20px;border-radius:10px;position:relative;">

            <button onclick="closeVideoModal()"
                style="position:absolute;right:15px;top:10px;background:none;border:none;color:#fff;font-size:30px;">
                ×
            </button>

            <div id="plyr-player-target" class="plyr__video-embed"></div>

        </div>

    </div>

    <div class="row">
        <div class="col-md-12">
            <ol class="breadcrumb bg-light p-3 rounded shadow-sm">
                <li class="breadcrumb-item"><a href="{{ route('administrator.dashboard') }}">หน้าหลัก</a></li>
                <li class="breadcrumb-item"><a href="{{ route('administrator.guide') }}">วิดีโอแนะนำการใช้งานระบบ</a></li>
            </ol>

            {{-- เนื้อหา --}}
            <div class="card">
                <div class="card-body">
                    {{-- หัว --}}
                    <div class="d-flex justify-content-between align-items-center p-3">
                        <form action="{{ route('administrator.guide') }}" method="GET"
                            class="d-flex justify-content-between align-items-center w-100">
                            <x-search />

                            <div class="d-flex align-items-center ms-2">
                                {{-- <x-status-filter /> --}}
                                <a href="{{ route('administrator.guide.add') }}"
                                    class="btn btn-primary d-flex align-items-center"
                                    style="white-space: nowrap;">เพิ่มข้อมูล
                                </a>
                            </div>
                        </form>
                    </div>

                    {{-- ตาราง --}}
                    <div class="table-responsive text-nowrap">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th style="font-size: 1rem;">
                                        <div class="form-check">
                                            <input class="form-check-input check-item" type="checkbox" id="checkAll" />
                                        </div>
                                    </th>
                                    <th>ลำดับ</th>
                                    <th class="text-center">ชื่อวีดีโอ</th>
                                    <th class="text-center">ผู้อัปโหลด</th>
                                    <th class="text-center">วันที่สร้าง</th>
                                    <th class="text-center">วีดีโอ</th>
                                    <th class="text-center">การจัดการ</th>

                                </tr>
                            </thead>

                            <tbody class="table-border-bottom-0" id="userTableBody">
                                @foreach ($users as $item)
                                    <tr>
                                        <td>
                                            <div class="form-check" style="font-size: 1rem;">
                                                <input type="checkbox" class="form-check-input check-item"
                                                    value="{{ $item->id }}">
                                            </div>
                                        </td>
                                        <td>{{ $users->firstItem() + $loop->index }}</td>
                                        <td>
                                            <div class="text-center">
                                                {{ $item->video_name }}
                                            </div>
                                        </td>
                                        <td class="text-center">{{ $item->creator->email }} </td>

                                        <td class="text-center">{{ $item->created_at->format('d/m/Y') }} </td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-primary"
                                                onclick='playVideoInModal(@json($item->link_video))'>
                                                🎥 ดูวิดีโอ
                                            </button>
                                        </td>
                                        <td>
                                            <div class="d-flex justify-content-center">
                                                <div class="d-inline-block text-nowrap">
                                                    <a class="btn btn-icon btn-outline-primary border-0 custom-tooltip"
                                                        data-tooltip="แก้ไข"
                                                        href="{{ route('administrator.guide.edit', ['id' => $item->id]) }}">
                                                        <i class="bx bx-edit bx"></i>
                                                    </a>

                                                    <form id="deleteForm{{ $item->id }}"
                                                        action="{{ route('administrator.guide.destroy', ['id' => $item->id, 'page' => request()->get('page')]) }}"
                                                        method="POST" style="display:inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button"
                                                            class="btn btn-icon btn-outline-danger border-0 btn-delete custom-tooltip"
                                                            data-tooltip="ลบ" data-id="{{ $item->id }}">
                                                            <i class="bx bx-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        {{-- การแบ่งหน้า --}}
                        <div>
                            {!! $users->links() !!}
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script>
        const currentPath = window.location.pathname;
        const bulkDeleteUrl = currentPath.endsWith('/') ? currentPath + 'bulk-delete' : currentPath + '/bulk-delete';
    </script>
@endsection

@section('script')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('js/delete.js') }}"></script>
    <script src="https://cdn.plyr.io/3.8.4/plyr.js"></script>

    <script>
        let plyrInstance = null;

        function playVideoInModal(videoUrl) {

            if (!videoUrl) {
                Swal.fire({
                    title: 'ข้อผิดพลาด',
                    text: 'ไม่พบลิงก์วิดีโอ',
                    icon: 'error'
                });
                return;
            }

            const videoId = extractYouTubeId(videoUrl);

            if (!videoId) {
                Swal.fire({
                    title: 'ลิงก์ไม่ถูกต้อง',
                    text: 'ไม่สามารถอ่าน YouTube ID ได้',
                    icon: 'warning'
                });
                return;
            }

            const modal = document.getElementById('customVideoModal');
            modal.style.display = 'flex';

            // ลบ Player เดิม
            if (plyrInstance) {
                plyrInstance.destroy();
                plyrInstance = null;
            }

            // สร้าง iframe ใหม่ทุกครั้ง
            document.getElementById('plyr-player-target').innerHTML = `
            <iframe
                src="https://www.youtube.com/embed/${videoId}?autoplay=1&rel=0"
                allowfullscreen
                allowtransparency
                allow="autoplay"
            ></iframe>
        `;

            // สร้าง Plyr
            plyrInstance = new Plyr('#plyr-player-target', {
                controls: [
                    'play-large',
                    'play',
                    'progress',
                    'current-time',
                    'mute',
                    'volume',
                    'fullscreen'
                ]
            });
        }

        function closeVideoModal() {

            document.getElementById('customVideoModal').style.display = 'none';

            if (plyrInstance) {
                plyrInstance.destroy();
                plyrInstance = null;
            }

            document.getElementById('plyr-player-target').innerHTML = '';
        }

        function extractYouTubeId(url) {

            const regExp =
                /(?:youtube\.com\/(?:watch\?v=|embed\/|shorts\/)|youtu\.be\/)([^?&\/]{11})/;

            const match = url.match(regExp);

            return match ? match[1] : null;
        }

        window.addEventListener('click', function(e) {

            const modal = document.getElementById('customVideoModal');

            if (e.target === modal) {
                closeVideoModal();
            }

        });

        document.addEventListener('keydown', function(e) {

            if (e.key === 'Escape') {
                closeVideoModal();
            }

        });
    </script>
@endsection
