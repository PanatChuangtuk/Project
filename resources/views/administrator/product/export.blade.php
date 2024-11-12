@extends('administrator.layouts.main')

@section('title')
@endsection

@section('stylesheet')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
@endsection

@section('content')
    <div class="card p-4">
        <h4 class="mb-4">Export Products</h4>
    
        <form action="{{ route('administrator.product.export.submit') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="model" class="form-label">Select Model</label>
                <select name="model" id="model" class="form-control">
                    <option value="">All Models</option>
                    @foreach($models as $model)
                        <option value="{{ $model }}">{{ $model }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-success">Export</button>
        </form>
    </div>
@endsection

