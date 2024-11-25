@extends('administrator.layouts.main')

@section('title')
@endsection

@section('stylesheet')
@endsection

@section('content')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('administrator.dashboard') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('administrator.product') }}">Product Model</a></li>
        <li class="breadcrumb-item active" aria-current="page">Edit</li>
    </ol>

    <form id="form-update" action="{{ route('administrator.product.update', $product->id) }}" method="POST"
        enctype="multipart/form-data" class="container">
        @csrf
        <div class="row justify-content-end mb-4">
            <div class="col-auto">
                <button type="submit" class="btn btn-success">Save</button>
                <a href="{{ route('administrator.product') }}" class="btn btn-danger">Cancel</a>
            </div>
        </div>

        <div class="card p-4">
            <!-- Product Information -->
            <div class="mb-4 row">
                <label for="name" class="col-md-2 col-form-label">Name</label>
                <div class="col-md-10">
                    <input class="form-control" type="text" value="{{ $product->name }}" id="name" name="name" />
                </div>
            </div>

            <div class="mb-4 row">
                <label for="sku" class="col-md-2 col-form-label">Sku</label>
                <div class="col-md-10">
                    <input type="text" class="form-control" id="sku" name="sku" value="{{ $product->sku }}">
                </div>
            </div>

            <div class="mb-4 row">
                <label for="size" class="col-md-2 col-form-label">Size</label>
                <div class="col-md-10">
                    <input type="text" class="form-control" id="size" name="size" value="{{ $product->size }}">
                </div>
            </div>

            <div class="mb-4 row">
                <label for="model" class="col-md-2 col-form-label">Model</label>
                <div class="col-md-10">
                    <select class="form-control" id="model" name="model">
                        <option value="">Select Model</option>
                        @foreach ($models as $model)
                            <option value="{{ $model->id }}"
                                {{ $product->product_model_id == $model->id ? 'selected' : '' }}>
                                {{ $model->code }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <!-- Product Price Information -->
        <div class="row mt-2">
            <div class="col-md-12">
                <div class="card p-4">
                    @foreach ($product_price as $item)
                        <div class="mb-4 row">
                            <div class="col-md-2">
                                <label for="price[{{ $item->id }}]"
                                    class="col-form-label">{{ $item->member_group_name }}</label>
                            </div>
                            <div class="col-md-10">
                                <input type="text" class="form-control" id="price[{{ $item->id }}]"
                                    name="price[{{ $item->id }}]" value="{{ $item->price }}">
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </form>
@endsection


@section('script')
@endsection
