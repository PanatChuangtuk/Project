@extends('administrator.layouts.main')

@section('title')
@endsection

@section('stylesheet')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
@endsection

@section('content')
    <div class="card p-4">
        <h4 class="mb-4">Import Products</h4>
        
        <form action="{{ route('administrator.product.import.submit') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="file" class="form-label">Choose File</label>
                <input type="file" name="file" id="file" class="form-control" accept=".xlsx, .xls, .csv" required>
            </div>
            <button type="submit" class="btn btn-primary">Import</button>
        </form>
    </div>
@endsection
