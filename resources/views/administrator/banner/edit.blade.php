@extends('administrator.layouts.main')

@section('title')
@endsection

@section('stylesheet')
@endsection

@section('content')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('administrator.dashboard') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('administrator.banner') }}">Banner</a></li>
        <li class="breadcrumb-item active" aria-current="page">Edit</li>
    </ol>
    <form id="form-update" action="{{ route('administrator.banner.update', $banner->id) }}" method="POST"
        enctype="multipart/form-data" class="container">
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
                    <input class="form-control" type="text" value="{{ $banner->name }}" id="name" name="name" />
                </div>
            </div>

            <div class="mb-4 row">
                <label for="url" class="col-md-2 col-form-label">URL</label>
                <div class="col-md-10">
                    <input type="url" class="form-control" id="url" name="url" value="{{ $banner->url }}">
                </div>
            </div>

            <div class="mb-4 row">
                <label for="image" class="col-md-2 col-form-label">Image</label>
                <div class="col-md-10">
                    <input id="image" name="image" type="file" data-browse-on-zone-click="true" />
                    <div id="kartik-file-errors"></div>
                </div>
            </div>

            <div class="row mb-4">
                <label class="col-md-2 col-form-label" for="status">Status</label>
                <div class="col-md-10 d-flex align-items-center">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="status" value="1" name="status"
                            {{ $banner->status == 1 ? 'checked' : '0' }} />
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
                deleteUrl: "{{ route('administrator.banner.delete.image', $banner->id) . '?_token=' . csrf_token() }}",
                enableResumableUpload: true,
                showRemove: false,
                uploadAsync: false,
                initialPreviewAsData: true,
                showCancel: true,
                showUpload: false,
                elErrorContainer: '#kartik-file-errors',
                allowedFileExtensions: ["jpg", "png", "jpeg", "svg", "raw", "gif", "tif", "webp"],
                resumableUploadOptions: {
                    chunkSize: 5,
                },
                initialPreview: [
                    @if ($banner->image)
                        src = "{{ asset('upload/file/banner/' . basename($banner->image)) }}"
                    @else
                        null
                    @endif
                ],
                initialPreviewConfig: [
                    @if ($banner)
                        {
                            caption: "{{ basename($banner->image) }}",
                            key: 1
                        }
                    @else
                        {
                            caption: "No image available",
                            key: 0
                        }
                    @endif
                ],
                maxFileCount: 1,
                theme: "bs5",
                fileActionSettings: {
                    showZoom: function(config) {
                        if (config.type === 'pdf' || config.type === 'image') {
                            return true;
                        }
                        return false;
                    },
                }
            }).on('filebeforedelete', function() {
                return new Promise(function(resolve, reject) {
                    $.confirm({
                        title: 'Confirmation!',
                        content: 'Are you sure you want to delete this file?',
                        type: 'red',
                        buttons: {
                            ok: {
                                btnClass: 'btn-primary text-white',
                                keys: ['enter'],
                                action: function() {
                                    resolve();
                                }
                            },
                            cancel: function() {
                                reject();

                            }
                        }
                    });
                });
            }).on('filedeleted', function() {

            });
            $('#form-update').on('submit', function(e) {
                e.preventDefault();
                this.submit();
            });
        });
    </script>
@endsection
