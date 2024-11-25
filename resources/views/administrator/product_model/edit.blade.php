@extends('administrator.layouts.main')

@section('title')
@endsection

@section('stylesheet')
@endsection

@section('content')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('administrator.dashboard') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('administrator.product.model') }}">Product Model</a></li>
        <li class="breadcrumb-item active" aria-current="page">Edit</li>
    </ol>
    <form id="form-update" action="{{ route('administrator.product.model.update', $product_model->id) }}" method="POST"
        enctype="multipart/form-data" class="container">
        @csrf
        <div class="row justify-content-end mb-4">
            <div class="col-auto">
                <button type="submit" class="btn btn-success">Save</button>
                <a href="{{ route('administrator.product.model') }}" class="btn btn-danger">Cancel</a>
            </div>
        </div>

        <div class="card p-4">
            <div class="mb-4 row">
                <label for="name" class="col-md-2 col-form-label">Name</label>
                <div class="col-md-10">
                    <input class="form-control" type="text" value="{{ $product_model->name }}" id="name"
                        name="name" />
                </div>
            </div>

            <div class="mb-4 row">
                <label for="url" class="col-md-2 col-form-label">Code</label>
                <div class="col-md-10">
                    <input type="text" class="form-control" id="code" name="code"
                        value="{{ $product_model->code }}">
                </div>
            </div>

            <div class="mb-4 row">
                <label for="url" class="col-md-2 col-form-label">Description</label>
                <div class="col-md-10">
                    <textarea type="text" class="form-control areaEditor" id="description" name="description">{{ $product_model->description }}</textarea>
                </div>
            </div>

            <div class="row mb-4">
                <label class="col-md-2 col-form-label" for="status">Status</label>
                <div class="col-md-10 d-flex align-items-center">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="status" value="1" name="status"
                            {{ $product_model->status == 1 ? 'checked' : '0' }} />
                        <label class="form-check-label ms-2" for="status">Active</label>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-md-12">
                <div class="card p-4">
                    @foreach ($product_info as $item)
                        <div class="mb-4 row">
                            <label for="description_[{{ $item->id }}]"
                                class="col-md-2 col-form-label">{{ $item->productAttribute->name ?? null }}</label>
                            <div class="col-md-10">
                                <input type="text" class="form-control" id="description_[{{ $item->id }}]"
                                    name="descriptionAttribute[{{ $item->id }}]" value="{{ $item->detail }}">
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </form>
@endsection

@section('script')
    <script>
        window.csrfToken = @json(csrf_token());
    </script>
    <script type="module" src="{{ asset('administrator/js/ckeditor.js') }}"></script>
@endsection
