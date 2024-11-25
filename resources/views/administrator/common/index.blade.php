@extends('administrator.layouts.main')

@section('title')
@endsection
@section('stylesheet')
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12">
            <x-bread-crumb  />

            {{-- Content --}}
            <div class="card">
                <div class="card-body">
                    {{-- Head --}}
                    <div class="d-flex justify-content-between align-items-center p-3">
                        <form action="{{ route('administrator.common') }}" method="GET"
                            class="d-flex justify-content-between align-items-center w-100">
                            <x-search />
                            <div style="width: 100px;"></div>

                            <div class="d-flex align-items-center ms-2">
                                <a href="{{ route('administrator.common.add') }}"
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
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Content</th>
                                    <th class="text-center">Create Date</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>

                            <tbody class="table-border-bottom-0" id="commonTableBody">
                                @foreach ($common as $item)
                                    <tr>
                                        <td>
                                            <div class="form-check" style="font-size: 1rem;">
                                                <input type="checkbox" class="form-check-input check-item"
                                                    value="{{ $item->id }}">
                                            </div>
                                        </td>
                                        <td>{{ $item->id }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ Str::limit(strip_tags(str_replace(['<ul>', '</ul>', '<li>', '</li>'], '', $item->content->content ?? 'No content')), 30, '...') }}</td>
                                        <td class="text-center">{{ $item->created_at }}</td>
                                        <td>
                                            <div class="d-flex justify-content-center">
                                                <div class="d-inline-block text-nowrap">
                                                    <a class="btn btn-icon btn-outline-primary border-0" href="{{ route('administrator.common.edit',['id' => $item->id]) }}">
                                                        <i class="bx bx-edit bx"></i>
                                                    </a>

                                                    <form id="deleteForm{{ $item->id }}"
                                                        action="{{ route('administrator.common.destroy', ['id' => $item->id, 'page' => request()->get('page')]) }}"
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
                            {!! $common->links() !!}
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
