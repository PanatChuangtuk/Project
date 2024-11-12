@extends('administrator.layouts.main')

@section('title')
    Manage Role Permissions
@endsection

@section('stylesheet')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <x-bread-crumb />
        <div class="card">
            <div class="card-body">
                <h1>Set Access Control for Roles</h1>
                
                <form action="{{ route('administrator.permissions.update') }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Permission</th>
                                @foreach($roles as $role)
                                    <th class="text-center">{{ $role->name }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($permissions as $permission)
                                <tr>
                                    <td>{{ $permission->name }}</td>
                                    @foreach($roles as $role)
                                        <td class="text-center align-middle">
                                            <div class="form-check d-flex justify-content-center align-items-center" style="font-size: 1rem;"> <!-- ใช้ Flexbox -->
                                                <input type="checkbox" class="form-check-input" name="permissions[{{ $permission->id }}][]" value="{{ $role->id }}"
                                                {{ $role->permissions->contains($permission->id) ? 'checked' : '' }}>
                                                <label class="form-check-label"></label>
                                            </div>
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>                                          
                    </table>
                    
                    <button type="submit" class="btn btn-primary mt-3">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
