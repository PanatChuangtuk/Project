@extends('administrator.layouts.main')

@section('title')
@endsection

@section('stylesheet')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
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
                        <form action="{{ route('administrator.product') }}" method="GET" class="d-flex justify-content-between align-items-center w-100">
                            <x-search />
                    
                            <div class="d-flex align-items-center flex-wrap gap-1 p-2">
                                {{-- <x-status-filter /> --}}
                                <a href="{{ route('administrator.product.add') }}" class="btn btn-primary d-flex align-items-center" style="white-space: nowrap;">Add</a>
                                <a href="{{ route('administrator.product.import') }}" class="btn btn-info d-flex align-items-center" style="white-space: nowrap;">Import</a>
                                <a href="{{ route('administrator.product.export') }}" class="btn btn-info d-flex align-items-center" style="white-space: nowrap;">Export</a>
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
                                    <th class="text-center">Size</th>
                                    <th class="text-center">Model</th>
                                    <th class="text-center">Price</th>
                                    <th class="text-center">Quantity</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>

                            <tbody class="table-border-bottom-0" id="productTableBody">
                                @foreach ($product as $item)
                                    <tr>
                                        <td>
                                            <div class="form-check" style="font-size: 1rem;">
                                                <input type="checkbox" class="form-check-input check-item"
                                                    value="{{ $item->id }}">
                                            </div>
                                        </td>
                                        <td>{{ $item->id }}</td>
                                        <td>{{ Str::limit($item->name ?? 'No name', 30, '...') }}</td>
                                        <td class="text-center">{{ $item->size }}</td>
                                        <td class="text-center">{{ $item->model }}</td>
                                        <td class="text-center">{{ $item->price }}</td>
                                        <td class="text-center">{{ $item->quantity }}</td>
                                        <td>
                                            <div class="d-flex justify-content-center">
                                                <div class="d-inline-block text-nowrap">
                                                    <a class="btn btn-icon btn-outline-primary border-0" href="{{ route('administrator.product.edit',['id' => $item->id]) }}">
                                                        <i class="bx bx-edit bx"></i>
                                                    </a>

                                                    <form id="deleteForm{{ $item->id }}"
                                                        action="{{ route('administrator.product.destroy', ['id' => $item->id, 'page' => request()->get('page')]) }}"
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

                        @if (session('success'))
                            <div>{{ session('success') }}</div>
                        @endif

                        @if ($errors->any())
                            <div>
                                <ul>
                                    @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif    
                        {{-- Pagination --}}
                        <div>
                            {!! $product->links() !!}
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
