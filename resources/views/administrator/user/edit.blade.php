@extends('administrator.layouts.main')

@section('title')

@section('content')
    <ol class="breadcrumb bg-light p-3 rounded shadow-sm">
        <li class="breadcrumb-item"><a href="{{ route('administrator.dashboard') }}">หน้าแรก</a></li>
        <li class="breadcrumb-item"><a href="{{ route('administrator.user') }}">ผู้ใช้</a></li>
        <li class="breadcrumb-item active" aria-current="page">แก้ไข</li>
    </ol>

    <div class="card shadow-lg border-0 rounded-4">
        <div class="card-header text-white rounded-top-4">
            <h5 class="mb-0"><i class="fas fa-user-edit"></i> แก้ไขผู้ใช้</h5>
        </div>
        <div class="card-body">
            <form id="form-update" method="POST" action="{{ route('administrator.user.update', $admin->id) }}"
                class="mx-1 mx-md-4" enctype="multipart/form-data">
                @csrf

                <div class="row g-4">
                    <div class="col-md-6">
                        <label for="email" class="form-label fw-semibold">อีเมล์</label>
                        <div class="input-group shadow-sm">
                            <span class="input-group-text bg-light"><i class="fas fa-envelope"></i></span>
                            <input type="email" id="email" name="email" class="form-control border-0 shadow-sm"
                                value="{{ old('email', $admin->email) }}" />
                        </div>
                        @error('email')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="mobile_phone" class="form-label fw-semibold">หมายเลขโทรศัพท์มือถือ</label>
                        <div class="input-group shadow-sm">
                            <span class="input-group-text bg-light"><i class="fas fa-phone"></i></span>
                            <input type="text" id="mobile_phone" name="mobile_phone"
                                class="form-control border-0 shadow-sm"
                                value="{{ old('mobile_phone', $admin->info->mobile_phone) }}" />
                        </div>
                        @error('mobile_phone')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="first_name" class="form-label fw-semibold">ชื่อ</label>
                        <div class="input-group shadow-sm">
                            <span class="input-group-text bg-light"><i class="fas fa-user"></i></span>
                            <input type="text" id="first_name" name="first_name" class="form-control border-0 shadow-sm"
                                value="{{ old('first_name', $admin->info->first_name) }}" />
                        </div>
                        @error('first_name')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="last_name" class="form-label fw-semibold">นามสกุล</label>
                        <div class="input-group shadow-sm">
                            <span class="input-group-text bg-light"><i class="fas fa-user"></i></span>
                            <input type="text" id="last_name" name="last_name" class="form-control border-0 shadow-sm"
                                value="{{ old('last_name', $admin->info->last_name) }}" />
                        </div>
                        @error('last_name')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- ฟิลด์รหัสผ่าน (เลือกได้) -->
                    <div class="col-md-6">
                        <label for="password" class="form-label fw-semibold">รหัสผ่าน</label>
                        <div class="input-group shadow-sm">
                            <span class="input-group-text bg-light"><i class="fas fa-lock"></i></span>
                            <input type="password" id="password" name="password" class="form-control border-0 shadow-sm" />
                        </div>
                        @error('password')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- ฟิลด์ยืนยันรหัสผ่าน (เลือกได้) -->
                    <div class="col-md-6">
                        <label for="password_confirmation" class="form-label fw-semibold">ยืนยันรหัสผ่าน</label>
                        <div class="input-group shadow-sm">
                            <span class="input-group-text bg-light"><i class="fas fa-key"></i></span>
                            <input type="password" id="password_confirmation" name="password_confirmation"
                                class="form-control border-0 shadow-sm" />
                        </div>
                        @error('password_confirmation')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="fw-bold w-100 d-block">รหัสนักศึกษา <span class="text-danger">*</span></label>
                            <select name="student_id" id="studentSelect" class="form-control select2">
                                <option value="">{{ $admin->info?->student?->student_number ?? 'รหัสนักศึกษา' }}
                                </option>
                            </select>
                            @error('student_id')
                                <span class="text-danger  w-100">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="fw-bold w-100 d-block">อาจารย์ที่ปรึกษา <span
                                    class="text-danger">*</span></label>
                            <select name="adviser_id" id="adviserSelect" class="form-control select2">
                                <option value="">
                                    {{ $admin->info?->student?->adviser->first_name . ' ' . $admin->info?->student?->adviser->last_name }}
                                </option>
                                </option>
                            </select>
                            @error('adviser_id')
                                <span class="text-danger  w-100">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label for="image" class="form-label fw-semibold">อัพโหลดรูปภาพ</label>
                        <div class="input-group shadow-sm">
                            <span class="input-group-text bg-light"><i class="fas fa-image"></i></span>
                            <input type="file" id="image" name="image"
                                class="form-control border-0 shadow-sm" />
                        </div>

                        @error('image')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <!-- สถานะการเปิดใช้งาน -->
                    <div class="col-md-12 mt-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="status" value="1"
                                name="status" {{ $admin->status ? 'checked' : '' }} />
                            <label class="form-check-label fw-semibold" for="status">สถานะเปิดใช้งาน</label>
                        </div>
                    </div>

                    <div class="col-md-12 mt-4 text-end">
                        <button type="submit" class="btn btn-success px-4 shadow-sm">
                            <i class="fas fa-save"></i> บันทึก
                        </button>
                        <a href="{{ route('administrator.user') }}" class="btn btn-danger px-4 shadow-sm">
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
                window.location.href = '{{ route('administrator.user') }}';
            });
        </script>
    @endif
    <script>
        $('#studentSelect').select2({
            ajax: {
                url: '{{ url('api/get-user') }}',
                type: "GET",
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
                                text: item.student_number
                            };
                        })
                    };
                },
                cache: true
            }
        });
    </script>
    <script>
        $('#adviserSelect').select2({
            ajax: {
                url: '{{ url('api/get-adviser') }}',
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
                                text: item.first_name + ' ' + item.last_name,
                            };
                        })
                    };
                },
                cache: true
            }
        });
    </script>
@endsection
