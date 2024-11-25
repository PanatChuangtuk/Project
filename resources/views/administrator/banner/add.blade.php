@extends('administrator.layouts.main')

@section('title')
@endsection

@section('stylesheet')
@endsection

@section('content')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('administrator.dashboard') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('administrator.banner') }}">Banner</a></li>
        <li class="breadcrumb-item active" aria-current="page">Add</li>
    </ol>
    <form id="form-create" action="{{ route('administrator.banner.submit') }}" method="POST" enctype="multipart/form-data"
        class="container">
        @csrf
        <div class="row justify-content-end mb-4">
            <div class="col-auto">
                <button type="submit" class="btn btn-success">Save</button>
                <a href="{{ route('administrator.banner') }}" class="btn btn-danger">Cancel</a>
            </div>
        </div>

        <div class="card p-4">
            <div class="mb-4 row">
                <label for="name" class="col-md-2 col-form-label">Name</label>
                <div class="col-md-10">
                    <input class="form-control" type="text" placeholder="Input Name" id="name" name="name"
                        value="{{ old('name') }}" />
                    @error('name')
                        <div class="text-danger col-form-label">{{ $message }}</div>
                    @enderror
                </div>

            </div>

            <div class="mb-4 row">
                <label for="url" class="col-md-2 col-form-label">URL</label>
                <div class="col-md-10">
                    <input type="url" class="form-control" id="url" name="url" placeholder="Enter URL">
                </div>
            </div>

            <div class="mb-4 row">
                <label for="image" class="col-md-2 col-form-label">Image</label>
                <div class="col-md-10">
                    <input id="image" name="image" type="file" data-browse-on-zone-click="true" />
                </div>
            </div>

            <div class="row mb-4">
                <label class="col-md-2 col-form-label" for="status">Status</label>
                <div class="col-md-10 d-flex align-items-center">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="status" value="1" name="status" />
                        <label class="form-check-label ms-2" for="status">Active</label>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $("#image").fileinput({
                showRemove: false,
                enableResumableUpload: true,
                initialPreviewAsData: true,
                showCancel: true,
                showUpload: false,
                elErrorContainer: '#kartik-file-errors',
                allowedFileExtensions: ["jpg", "png", "jpeg", "svg", "raw", "gif", "tif", "webp"],
                resumableUploadOptions: {
                    chunkSize: 5,
                },
                maxFileCount: 1,
                theme: "bs5",
                fileActionSettings: {
                    showZoom: function(config) {
                        if (config.type === 'pdf' || config.type === 'image') {
                            return true;
                        }
                        return false;
                    }
                }
            });
        });
    </script>
@endsection
