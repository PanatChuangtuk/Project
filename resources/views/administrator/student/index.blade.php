@extends('administrator.layouts.main')

@section('title')
@endsection

@section('stylesheet')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
@endsection

@section('content')
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div class="row">
        <div class="col-md-12">
            <x-bread-crumb />

            {{-- Content --}}
            <div class="card">
                <div class="card-body">
                    {{-- Head --}}
                    <div class="d-flex justify-content-between align-items-center p-3">
                        <form action="{{ route('administrator.student') }}" method="GET" class="w-100">
                            <div class="d-flex justify-content-between align-items-center">
                                <!-- Search Component -->
                                <x-search />

                                <div class="d-flex align-items-center">
                                    <!-- Open Modal Button -->
                                    <button type="button" class="btn btn-primary btn-lg me-2" data-bs-toggle="modal"
                                        data-bs-target="#registerModal">
                                        กดเพื่อเพิ่มนักศึกษา
                                    </button>

                                    <!-- Add User Button -->
                                    <a href="{{ route('administrator.student.add') }}"
                                        class="btn btn-outline-primary btn-lg" style="white-space: nowrap;">
                                        Add
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="registerModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="registerModalLabel">Studnet Infomation</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('administrator.user.import') }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="file" class="form-label">เลือกไฟล์ Excel เพื่ออัปโหลด</label>
                                            <input type="file" name="file" id="file" class="form-control"
                                                accept=".xlsx, .xls, .csv">
                                            <i class="fas fa-exclamation-circle"> <span
                                                    class="text-danger">กรุณาใช้รูปแบบที่ให้ในการบันทึกข้อมูล</span></i>
                                        </div>

                                        <div class="d-flex justify-content-between align-items-center">
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fas fa-upload"></i> นำเข้าข้อมูล
                                            </button>

                                        </div>
                                    </form>
                                    <button class="btn btn-outline-primary mt-3" data-bs-dismiss="modal">
                                        <i class="fas fa-upload"></i> รูปแบบข้อมูลที่ใช้นำเข้า
                                    </button>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Table --}}
                    <div class="table-responsive text-nowrap">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th style="font-size: 1rem;">
                                        <div class="form-check">
                                            <input class="form-check-input check-item" type="checkbox" id="checkAll" />
                                        </div>
                                    </th>
                                    {{-- <th>ID</th> --}}
                                    <th class="text-center">UserName</th>
                                    <th class="text-center">Student Number</th>
                                    <th class="text-center">Email</th>
                                    <th class="text-center">Created Date</th>
                                    <th class="text-center">Actions</th>
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
                                        {{-- <td>{{ $item->id }}</td> --}}
                                        <td>
                                            <div class="text-center">
                                                <div class="flex-grow-1">
                                                    <strong class="d-block">
                                                        {{ $item->first_name ?? null }} |
                                                        {{ $item->last_name ?? null }}
                                                    </strong>
                                                    <span class="text-muted small">
                                                        {{ $item->mobile_phone ?? null }}
                                                    </span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center">{{ $item->student_number }}</td>
                                        <td class="text-center">{{ $item->email }}</td>
                                        {{-- <td class="text-center">
                                            @if (Auth::user()->role->name == 'Super Admin')
                                                @if (Auth::user()->id != $item->id)
                                                    <form method="POST"
                                                        action="{{ route('administrator.student.change-role', ['id' => $item->id]) }}"
                                                        id="roleForm-{{ $item->id }}">
                                                        @csrf
                                                        <select name="role_id" class="form-control"
                                                            onchange="this.form.submit()">
                                                            @foreach ($roles as $role)
                                                                <option value="{{ $role->id }}"
                                                                    {{ $item->role_id == $role->id ? 'selected' : '' }}>
                                                                    {{ $role->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </form>
                                                @else
                                                    <span style="font-weight: bold;">{{ $item->role->name }} (You)</span>
                                                @endif
                                            @else
                                                {{ $item->role->name }}
                                            @endif
                                        </td> --}}
                                        <td class="text-center">{{ $item->created_at }}</td>
                                        <td>
                                            <div class="d-flex justify-content-center">
                                                <div class="d-inline-block text-nowrap">
                                                    <a class="btn btn-icon btn-outline-primary border-0"
                                                        href="{{ route('administrator.student.edit', ['id' => $item->id]) }}">
                                                        <i class="bx bx-edit bx"></i>
                                                    </a>

                                                    <form id="deleteForm{{ $item->id }}"
                                                        action="{{ route('administrator.student.destroy', ['id' => $item->id, 'page' => request()->get('page')]) }}"
                                                        method="POST" style="display:inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button"
                                                            class="btn btn-icon btn-outline-danger border-0 btn-delete"
                                                            data-id="{{ $item->id }}">
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

                        {{-- Pagination --}}
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
@endsection
