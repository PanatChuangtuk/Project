@extends('administrator.layouts.main')

@section('title', 'Update Admin')

@section('content')
    <ol class="breadcrumb bg-light p-3 rounded shadow-sm">
        <li class="breadcrumb-item"><a href="{{ route('administrator.dashboard') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('administrator.admin') }}">Admin</a></li>
        <li class="breadcrumb-item active" aria-current="page">Update</li>
    </ol>

    <div class="card shadow-lg border-0 rounded-4">
        <div class="card-header text-white rounded-top-4">
            <h5 class="mb-0"><i class="fas fa-user-edit"></i> Update Admin</h5>
        </div>
        <div class="card-body">
            <form id="form-update" method="POST" action="{{ route('administrator.admin.update', $admin->id) }}"
                class="mx-1 mx-md-4" enctype="multipart/form-data">
                @csrf

                <div class="row g-4">
                    <!-- Username Field -->
                    {{-- <div class="col-md-6">
                        <label for="username" class="form-label fw-semibold">Username</label>
                        <div class="input-group shadow-sm">
                            <span class="input-group-text bg-light"><i class="fas fa-user"></i></span>
                            <input type="text" id="username" name="username" class="form-control border-0 shadow-sm"
                                value="{{ old('username', $admin->username) }}" required />
                        </div>
                        @error('username')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div> --}}

                    <!-- Email Field -->
                    <div class="col-md-6">
                        <label for="email" class="form-label fw-semibold">Email</label>
                        <div class="input-group shadow-sm">
                            <span class="input-group-text bg-light"><i class="fas fa-envelope"></i></span>
                            <input type="email" id="email" name="email" class="form-control border-0 shadow-sm"
                                value="{{ old('email', $admin->email) }}" required />
                        </div>
                        @error('email')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="mobile_phone" class="form-label fw-semibold">Mobile Phone</label>
                        <div class="input-group shadow-sm">
                            <span class="input-group-text bg-light"><i class="fas fa-phone"></i></span>
                            <input type="text" id="mobile_phone" name="mobile_phone"
                                class="form-control border-0 shadow-sm"
                                value="{{ old('mobile_phone', $admin->info->mobile_phone) }}" required />
                        </div>
                        @error('mobile_phone')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="first_name" class="form-label fw-semibold">First Name</label>
                        <div class="input-group shadow-sm">
                            <span class="input-group-text bg-light"><i class="fas fa-user"></i></span>
                            <input type="text" id="first_name" name="first_name" class="form-control border-0 shadow-sm"
                                value="{{ old('first_name', $admin->info->first_name) }}" required />
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
                                value="{{ old('last_name', $admin->info->last_name) }}" required />
                        </div>
                        @error('last_name')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Password Field (Optional) -->
                    <div class="col-md-6">
                        <label for="password" class="form-label fw-semibold">Password</label>
                        <div class="input-group shadow-sm">
                            <span class="input-group-text bg-light"><i class="fas fa-lock"></i></span>
                            <input type="password" id="password" name="password" class="form-control border-0 shadow-sm" />
                        </div>
                        @error('password')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Password Confirmation Field (Optional) -->
                    <div class="col-md-6">
                        <label for="password_confirmation" class="form-label fw-semibold">Confirm Password</label>
                        <div class="input-group shadow-sm">
                            <span class="input-group-text bg-light"><i class="fas fa-key"></i></span>
                            <input type="password" id="password_confirmation" name="password_confirmation"
                                class="form-control border-0 shadow-sm" />
                        </div>
                        @error('password_confirmation')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Image Field (Optional) -->
                    <div class="col-md-6">
                        <label for="image" class="form-label fw-semibold">Upload Image</label>
                        <div class="input-group shadow-sm">
                            <span class="input-group-text bg-light"><i class="fas fa-image"></i></span>
                            <input type="file" id="image" name="image" class="form-control border-0 shadow-sm" />
                        </div>

                        @error('image')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Status Toggle -->
                    <div class="col-md-12 mt-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="status" value="1"
                                name="status" {{ $admin->status ? 'checked' : '' }} />
                            <label class="form-check-label fw-semibold" for="status">Active Status</label>
                        </div>
                    </div>

                    <div class="col-md-12 mt-4 text-end">
                        <button type="submit" class="btn btn-success px-4 shadow-sm">
                            <i class="fas fa-save"></i> Save
                        </button>
                        <a href="{{ route('administrator.admin') }}" class="btn btn-danger px-4 shadow-sm">
                            <i class="fas fa-times"></i> Cancel
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
                window.location.href = '{{ route('administrator.admin') }}';
            });
        </script>
    @endif
@endsection
