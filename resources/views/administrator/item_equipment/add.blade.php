@extends('administrator.layouts.main')

@section('title')
@endsection
@section('content')
    <ol class="breadcrumb bg-light p-3 rounded shadow-sm">
        <li class="breadcrumb-item"><a href="{{ route('administrator.dashboard') }}">หน้าหลัก</a></li>
        <li class="breadcrumb-item"><a href="{{ route('administrator.item-equipment') }}">ประเภทอุปกรณ์</a></li>
        <li class="breadcrumb-item active" aria-current="page">เพิ่มประเภทอุปกรณ์</li>
    </ol>

    <div class="card shadow-lg border-0 rounded-4">
        <div class="card-header text-white rounded-top-4">
            <h5 class="mb-0"><i class="fas fa-user-plus"></i> เพิ่มประเภทอุปกรณ์</h5>
        </div>
        <div class="card-body">
            <form id="form-create" method="POST" action="{{ route('administrator.item-equipment.submit') }}"
                class="mx-1 mx-md-4" enctype="multipart/form-data">
                @csrf
                <div class="row g-4">
                    <!-- Email -->
                    <div class="col-md-6">
                        <label for="name" class="form-label fw-semibold">ชื่อประเภทอุปกรณ์</label>
                        <div class="input-group shadow-sm">
                            <span class="input-group-text bg-light"><i class='bx bxs-rename'></i></i></span>
                            <input type="name" id="name" name="name" class="form-control border-0 shadow-sm" />
                        </div>
                        @error('name')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="fw-bold w-100 d-block">หมวดหมู่อุปกรณ์<span class="text-danger">*</span></label>
                            <select name="category_id" id="typeSelect" class="form-control">
                                <option value="">หมวดหมู่อุปกรณ์</option>
                            </select>
                            @error('category_id')
                                <span class="text-danger w-100">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-12">
                        <label for="image" class="col-md-2 col-form-label">Image</label>
                        <div class="col-md-12">
                            <input id="image" name="image" type="file" data-browse-on-zone-click="true" />
                            @error('image')
                                <div class="text-danger col-form-label">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <!-- สถานะ -->
                    <div class="col-md-12 mt-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="status" value="1" name="status" />
                            <label class="form-check-label fw-semibold" for="status">สถานะเปิดใช้งาน</label>
                        </div>
                    </div>

                    <!-- ปุ่ม -->
                    <div class="col-md-12 mt-4 text-end">
                        <button type="submit" class="btn btn-success px-4 shadow-sm">
                            <i class="fas fa-save"></i> บันทึก
                        </button>
                        <a href="{{ route('administrator.item-equipment') }}" class="btn btn-danger px-4 shadow-sm">
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
                window.location.href = '{{ route('administrator.item-equipment') }}';
            });
        </script>
    @endif
    <script>
        $('#typeSelect').select2({
            placeholder: 'เลือกหมวดหมู่อุปกรณ์',
            ajax: {
                url: '{{ url('api/get-type') }}',
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        query: params.term,
                    };
                },
                processResults: function(data) {
                    return {
                        results: data.results.map(function(item) {
                            return {
                                id: item.id,
                                text: item.name
                            };
                        })
                    };
                },
                cache: true
            }
        });
    </script>
    <script>
        $(document).ready(function() {
            $("#image").fileinput({
                showRemove: false,
                enableResumableUpload: true,
                initialPreviewAsData: true,
                showCancel: true,
                showUpload: false,
                elErrorContainer: '#kartik-file-errors',
                allowedFileExtensions: ["jpg", "png", "jpeg", "svg", "raw", "gif", "tif", "webp"],
                resumableUploadOptions: {
                    chunkSize: 5,
                },
                maxFileCount: 1,
                theme: "bs5",
                fileActionSettings: {
                    showZoom: function(config) {
                        if (config.type === 'pdf' || config.type === 'image') {
                            return true;
                        }
                        return false;
                    }
                }
            });
        });
    </script>
@endsection
