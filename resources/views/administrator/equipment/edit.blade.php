@extends('administrator.layouts.main')

@section('title')
@endsection
@section('content')
    <ol class="breadcrumb bg-light p-3 rounded shadow-sm">
        <li class="breadcrumb-item"><a href="{{ route('administrator.dashboard') }}">หน้าหลัก</a></li>
        <li class="breadcrumb-item"><a href="{{ route('administrator.equipment') }}">อุปกรณ์</a></li>
        <li class="breadcrumb-item active" aria-current="page">เพิ่ม</li>
    </ol>

    <div class="card shadow-lg border-0 rounded-4">
        <div class="card-header text-white rounded-top-4">
            <h5 class="mb-0"><i class="fas fa-user-plus"></i> เพิ่มอุปกรณ์</h5>
        </div>
        <div class="card-body">
            <form id="form-create" method="POST" action="{{ route('administrator.equipment.update', $equipment->id) }}"
                class="mx-1 mx-md-4" enctype="multipart/form-data">
                @csrf
                <div class="row g-4">
                    <!-- Email -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="fw-bold w-100 d-block">ประเภทอุปกรณ์<span class="text-danger">*</span></label>
                            <select name="item_id" id="typeSelect" class="form-control">
                                <option value="">{{ $equipment->item->name }}</option>
                            </select>
                            @error('item_id')
                                <span class="text-danger w-100">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label for="equipment_number" class="form-label fw-semibold">เลขครุภัณฑ์</label>
                        <div class="input-group shadow-sm">
                            <span class="input-group-text bg-light"><i class='bx bx-barcode'></i></i></span>
                            <input type="text" id="equipment_number" name="equipment_number"
                                class="form-control border-0 shadow-sm" value="{{ $equipment->equipment_number }}" />
                        </div>
                        @error('equipment_number')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="number" class="form-label fw-semibold">เลขอุปกรณ์</label>
                        <div class="input-group shadow-sm">
                            <span class="input-group-text bg-light">
                                <<i class='bx bx-tag-alt'></i>
                            </span>
                            <input type="text" id="number" value=" {{ $equipment->number }}"
                                class="form-control border-0 shadow-sm" readonly />
                        </div>
                        @error('number')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
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
                            <input class="form-check-input" type="checkbox" id="status" value="1" name="status"
                                {{ $equipment->status ? 'checked' : '' }} />
                            <label class="form-check-label fw-semibold" for="status">สถานะเปิดใช้งาน</label>
                        </div>
                    </div>

                    <!-- ปุ่ม -->
                    <div class="col-md-12 mt-4 text-end">
                        <button type="submit" class="btn btn-success px-4 shadow-sm">
                            <i class="fas fa-save"></i> อัปเดต
                        </button>
                        <a href="{{ route('administrator.equipment') }}" class="btn btn-danger px-4 shadow-sm">
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
                window.location.href = '{{ route('administrator.equipment') }}';
            });
        </script>
    @endif
    <script>
        $('#typeSelect').select2({
            ajax: {
                url: '{{ url('api/get-item') }}',
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
                deleteUrl: "{{ route('administrator.equipment.delete.image', $equipment->id) . '?_token=' . csrf_token() }}",
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
                    @if ($equipment->image)
                        src =
                            "{{ asset('upload/file/qr_code/' . basename($equipment->image)) }}"
                    @else
                        null
                    @endif
                ],
                initialPreviewConfig: [
                    @if ($equipment)
                        {
                            caption: "{{ basename($equipment->image) }}",
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
