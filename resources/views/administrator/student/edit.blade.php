@extends('administrator.layouts.main')

@section('title')

@section('content')
    <ol class="breadcrumb bg-light p-3 rounded shadow-sm">
        <li class="breadcrumb-item"><a href="{{ route('administrator.dashboard') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('administrator.student') }}">Student</a></li>
        <li class="breadcrumb-item active" aria-current="page">Edit</li>
    </ol>

    <div class="card shadow-lg border-0 rounded-4">
        <div class="card-header text-white rounded-top-4">
            <h5 class="mb-0"><i class="fas fa-user-edit"></i> Edit Student</h5>
        </div>
        <div class="card-body">
            <form id="form-edit" method="POST" action="{{ route('administrator.student.update', $student->id) }}"
                enctype="multipart/form-data">
                @csrf

                <div class="row g-4">
                    <div class="col-md-6">
                        <label for="first_name" class="form-label fw-semibold">First Name</label>
                        <div class="input-group shadow-sm">
                            <span class="input-group-text bg-light"><i class="fas fa-user"></i></span>
                            <input type="text" id="first_name" name="first_name" class="form-control border-0 shadow-sm"
                                value="{{ $student->first_name }}" required>
                        </div>
                        @error('first_name')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="last_name" class="form-label fw-semibold">Last Name</label>
                        <div class="input-group shadow-sm">
                            <span class="input-group-text bg-light"><i class="fas fa-user"></i></span>
                            <input type="text" id="last_name" name="last_name" class="form-control border-0 shadow-sm"
                                value="{{ $student->last_name }}" required>
                        </div>
                        @error('last_name')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="student_number" class="form-label fw-semibold">Student Number</label>
                        <div class="input-group shadow-sm">
                            <span class="input-group-text bg-light"><i class="fas fa-id-card"></i></span>
                            <input type="text" id="student_number" name="student_number"
                                class="form-control border-0 shadow-sm" value="{{ $student->student_number }}" required>
                        </div>
                        @error('student_number')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="mobile_phone" class="form-label fw-semibold">Mobile Phone</label>
                        <div class="input-group shadow-sm">
                            <span class="input-group-text bg-light"><i class="fas fa-phone"></i></span>
                            <input type="text" id="mobile_phone" name="mobile_phone"
                                class="form-control border-0 shadow-sm" value="{{ $student->mobile_phone }}" required>
                        </div>
                        @error('mobile_phone')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-12">
                        <label for="email" class="form-label fw-semibold">Email</label>
                        <div class="input-group shadow-sm">
                            <span class="input-group-text bg-light"><i class="fas fa-envelope"></i></span>
                            <input type="email" id="email" name="email" class="form-control border-0 shadow-sm"
                                value="{{ $student->email }}" required>
                        </div>
                        @error('email')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-12 mt-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="status" value="1" name="status"
                                {{ $student->status ? 'checked' : '' }}>
                            <label class="form-check-label fw-semibold" for="status">Active Status</label>
                        </div>
                    </div>
                </div>

                <div class="text-end mt-4">
                    <button type="submit" class="btn btn-success px-4 shadow-sm">
                        <i class="fas fa-save"></i> Update
                    </button>
                    <a href="{{ route('administrator.student') }}" class="btn btn-danger px-4 shadow-sm">
                        <i class="fas fa-times"></i> Cancel
                    </a>
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
                window.location.href = '{{ route('administrator.student') }}';
            });
        </script>
    @endif
@endsection
