@extends('administrator.layouts.main')

@section('title', 'Create User')

@section('content')

    <form method="POST" action="{{ route('administrator.users.create.post') }}" class="mx-1 mx-md-4">
        @csrf
        <div class="demo-inline-spacing">
            <div class="text-end">
            <button type="submit" class="btn btn-primary">CREATE</button>
    </div>
    
        <div class="card">    
            <div class="card-body"> 
                <h5 class="card-title"></h5>

                <div class="mb-4">
                    <label for="name" class="form-label">Your Name</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                        <input type="text" id="name" name="name" class="form-control" required />
                    </div>
                    @error('name')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="email" class="form-label">Your Email</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                        <input type="email" id="email" name="email" class="form-control" required />
                    </div>
                    @error('email')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="password" class="form-label">Password</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                        <input type="password" id="password" name="password" class="form-control" required />
                    </div>
                    @error('password')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="password_confirmation" class="form-label">Repeat your password</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-key"></i></span>
                        <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" required />
                    </div>
                </div>
            </div>
               
            </div>
        </div>
    </form>

@endsection
