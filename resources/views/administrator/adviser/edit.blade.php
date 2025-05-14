@extends('administrator.layouts.main')

@section('title')

@section('content')
    <!-- Breadcrumb -->
    <ol class="breadcrumb bg-light p-3 rounded shadow-sm">
        <li class="breadcrumb-item"><a href="{{ route('administrator.dashboard') }}">หน้าแรก</a></li>
        <li class="breadcrumb-item"><a href="{{ route('administrator.adviser') }}">อาจารย์ที่ปรึกษา</a></li>
        <li class="breadcrumb-item active" aria-current="page">แก้ไขข้อมูล</li>
    </ol>

    <!-- Card Form -->
    <div class="card shadow-lg border-0 rounded-4">
        <div class="card-header text-white rounded-top-4">
            <h5 class="mb-0"><i class="fas fa-user-edit"></i> แก้ไขข้อมูลอาจารย์ที่ปรึกษา</h5>
        </div>
        <div class="card-body">
            <form id="form-update" method="POST" action="{{ route('administrator.adviser.update', $adviser->id) }}"
                class="mx-1 mx-md-4" enctype="multipart/form-data">
                @csrf

                <div class="row g-4">

                    <!-- ชื่อ -->
                    <div class="col-md-6">
                        <label for="first_name" class="form-label fw-semibold">ชื่อ</label>
                        <div class="input-group shadow-sm">
                            <span class="input-group-text bg-light"><i class="fas fa-user"></i></span>
                            <input type="text" id="first_name" name="first_name" class="form-control border-0 shadow-sm"
                                value="{{ old('first_name', $adviser->first_name) }}" />
                        </div>
                        @error('first_name')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- นามสกุล -->
                    <div class="col-md-6">
                        <label for="last_name" class="form-label fw-semibold">นามสกุล</label>
                        <div class="input-group shadow-sm">
                            <span class="input-group-text bg-light"><i class="fas fa-user"></i></span>
                            <input type="text" id="last_name" name="last_name" class="form-control border-0 shadow-sm"
                                value="{{ old('last_name', $adviser->last_name) }}" />
                        </div>
                        @error('last_name')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-12">
                        <label for="image" class="col-md-2 col-form-label">รูปภาพ</label>
                        <div class="col-md-12">
                            <input id="image" name="image" type="file" data-browse-on-zone-click="true" />
                            @error('image')
                                <div class="text-danger col-form-label">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <!-- สถานะการใช้งาน -->
                    <div class="col-md-12 mt-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="status" value="1" name="status"
                                {{ $adviser->status ? 'checked' : '' }} />
                            <label class="form-check-label fw-semibold" for="status">สถานะใช้งาน</label>
                        </div>
                    </div>

                    <!-- ปุ่มบันทึก -->
                    <div class="col-md-12 mt-4 text-end">
                        <button type="submit" class="btn btn-success px-4 shadow-sm">
                            <i class="fas fa-save"></i> บันทึก
                        </button>
                        <a href="{{ route('administrator.adviser') }}" class="btn btn-danger px-4 shadow-sm">
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
                window.location.href = '{{ route('administrator.adviser') }}';
            });
        </script>
    @endif
    <script>
        $(document).ready(function() {
            $("#image").fileinput({
                deleteUrl: "{{ route('administrator.adviser.delete.image', $adviser->id) . '?_token=' . csrf_token() }}",
                enableResumableUpload: true,
                showRemove: false,
                uploadAsync: false,
                initialPreviewAsData: true,
                showCancel: true,
                showUpload: false,
                elErrorContainer: '#kartik-file-errors',
                allowedFileExtensions: ["jpg", "png", "jpeg", "svg", "raw", "gif", "tif", "webp"],
                resumableUploadOptions: {
                    chunkSize: 5,
                },
                initialPreview: [
                    @if ($adviser->image)
                        src =
                            "{{ asset('upload/file/adviser/' . basename($adviser->image)) }}"
                    @else
                        null
                    @endif
                ],
                initialPreviewConfig: [
                    @if ($adviser)
                        {
                            caption: "{{ basename($adviser->image) }}",
                            key: 1
                        }
                    @else
                        {
                            caption: "ไม่มีรูปภาพ",
                            key: 0
                        }
                    @endif
                ],
                maxFileCount: 1,
                theme: "bs5",
                fileActionSettings: {
                    showZoom: function(config) {
                        if (config.type === 'pdf' || config.type === 'image') {
                            return true;
                        }
                        return false;
                    },
                }
            }).on('filebeforedelete', function() {
                return new Promise(function(resolve, reject) {
                    $.confirm({
                        title: 'ยืนยันการลบ!',
                        content: 'คุณแน่ใจหรือไม่ว่าต้องการลบไฟล์นี้?',
                        type: 'red',
                        buttons: {
                            ok: {
                                btnClass: 'btn-primary text-white',
                                keys: ['enter'],
                                action: function() {
                                    resolve();
                                }
                            },
                            cancel: function() {
                                reject();

                            }
                        }
                    });
                });
            }).on('filedeleted', function() {

            });
            $('#form-update').on('submit', function(e) {
                e.preventDefault();
                this.submit();
            });
        });
    </script>
@endsection
