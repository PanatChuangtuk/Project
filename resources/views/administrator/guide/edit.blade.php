@extends('administrator.layouts.main')

@section('title')
    <link rel="stylesheet" href="https://cdn.plyr.io/3.8.4/plyr.css">
@endsection
@section('content')
    <ol class="breadcrumb bg-light p-3 rounded shadow-sm">
        <li class="breadcrumb-item"><a href="{{ route('administrator.dashboard') }}">หน้าหลัก</a></li>
        <li class="breadcrumb-item"><a href="{{ route('administrator.guide') }}">คู่มือการใช้งาน</a></li>
        <li class="breadcrumb-item active" aria-current="page">เพิ่มคู่มือการใช้งาน</li>
    </ol>

    <div class="card shadow-lg border-0 rounded-4">
        <div class="card-header text-white rounded-top-4">
            <h5 class="mb-0"><i class="fas fa-user-plus"></i> เพิ่มคู่มือการใช้งาน</h5>
        </div>
        <div class="card-body">
            <form id="form-create" method="POST" action="{{ route('administrator.guide.update', $guide->id) }}"
                class="mx-1 mx-md-4" enctype="multipart/form-data">
                @csrf
                <div class="row g-4">
                    <!-- Email -->
                    <div class="col-md-6">
                        <label for="name" class="form-label fw-semibold">ชื่อวิดีโอ<span
                                class="text-danger">*</span></label>
                        <div class="input-group shadow-sm">
                            <span class="input-group-text bg-light"><i class='bx bxs-rename'></i></i></span>
                            <input type="name" id="name" name="name" class="form-control border-0 shadow-sm"
                                value="{{ old('name', $guide->video_name) }}" />
                        </div>
                        @error('name')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="fw-bold w-100 d-block">ลิงค์วีดีโอ<span class="text-danger">*</span></label>
                            <input type="text" name="link_video" id="linkVideo" class="form-control"
                                value="{{ old('link_video', $guide->link_video) }}">
                            @error('link_video')
                                <span class="text-danger w-100">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <div id="player" data-plyr-provider="youtube"
                            data-plyr-embed-id="{{ old('link_video', $guide->link_video) }}"></div>

                    </div>
                </div>

                <!-- สถานะ -->
                <div class="col-md-12 mt-3">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="status" value="1" name="status"
                            checked />
                        <label class="form-check-label fw-semibold" for="status">สถานะเปิดใช้งาน</label>
                    </div>
                </div>

                <!-- ปุ่ม -->
                <div class="col-md-12 mt-4 text-end">
                    <button type="submit" class="btn btn-success px-4 shadow-sm">
                        <i class="fas fa-save"></i> บันทึก
                    </button>
                    <a href="{{ route('administrator.guide') }}" class="btn btn-danger px-4 shadow-sm">
                        <i class="fas fa-times"></i> ยกเลิก
                    </a>
                </div>
        </div>
        </form>
    </div>
    </div>
@endsection

@section('script')
    @if (session('success'))
        <script>
            Swal.fire({
                title: 'สำเร็จ!',
                text: "{{ session('success') }}",
                icon: 'success',
                confirmButtonText: 'ตกลง'
            }).then(function() {
                window.location.href = '{{ route('administrator.guide') }}';
            });
        </script>
    @elseif (session('error'))
        <script>
            Swal.fire({
                title: "{{ session('error') }}",
                text: "{{ session('error') }}",
                icon: 'error',
                confirmButtonText: 'ตกลง'
            }).then(() => {
                setTimeout(() => {
                    window.location.href = "{{ route('administrator.logout') }}";
                }, 1000);
            });
        </script>
    @endif
    <script src="https://cdn.plyr.io/3.8.4/plyr.js"></script>

    <script>
        const player = document.getElementById('player');

        const url = player.dataset.plyrEmbedId;

        const match = url.match(
            /(?:youtube\.com\/(?:watch\?v=|shorts\/|embed\/)|youtu\.be\/)([^?&\/]+)/
        );

        const videoId = match ? match[1] : '';

        player.dataset.plyrEmbedId = videoId;

        const players = new Plyr('#player');
    </script>
@endsection
