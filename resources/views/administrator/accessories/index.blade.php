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
                        <form action="{{ route('administrator.admin') }}" method="GET"
                            class="d-flex justify-content-between align-items-center w-100">
                            <x-search />

                            <div class="d-flex align-items-center ms-2">
                                {{-- <x-status-filter /> --}}
                                <a href="{{ route('administrator.admin.add') }}"
                                    class="btn btn-primary d-flex align-items-center" style="white-space: nowrap;">Add
                                </a>
                            </div>
                        </form>
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
                                                        {{ $item->info->first_name ?? null }} |
                                                        {{ $item->info->last_name ?? null }}
                                                    </strong>
                                                    <span class="text-muted small">
                                                        {{ $item->info->mobile_phone ?? null }}
                                                    </span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center">{{ $item->email }}</td>
                                        {{-- <td class="text-center">
                                            @if (Auth::user()->role->name == 'Super Admin')
                                                @if (Auth::user()->id != $item->id)
                                                    <form method="POST"
                                                        action="{{ route('administrator.admin.change-role', ['id' => $item->id]) }}"
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
                                                        href="{{ route('administrator.admin.edit', ['id' => $item->id]) }}">
                                                        <i class="bx bx-edit bx"></i>
                                                    </a>

                                                    <form id="deleteForm{{ $item->id }}"
                                                        action="{{ route('administrator.admin.destroy', ['id' => $item->id, 'page' => request()->get('page')]) }}"
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
