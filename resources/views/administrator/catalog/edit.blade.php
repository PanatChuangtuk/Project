@extends('administrator.layouts.main')

@section('title')

@section('stylesheet')
@endsection

@section('content')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('administrator.dashboard') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('administrator.catalog') }}">Catalog</a></li>
        <li class="breadcrumb-item active" aria-current="page">Update</li>
    </ol>

    <form id="form-update" action="{{ route('administrator.catalog.update', $catalog->id) }}" method="POST"
        enctype="multipart/form-data">
        @csrf
        <div class="demo-inline-spacing">
            <div class="text-end">
                <button type="submit" class="btn btn-success">Update</button>
                <a href="{{ route('administrator.catalog') }}">
                    <button type="button" class="btn btn-danger">Cancel</button>
                </a>
            </div>

            <div class="card">
                <div class="nav-align-top nav-tabs-shadow mb-6">
                    <ul class="nav nav-tabs" role="tablist">
                        @foreach ($languages as $index => $language)
                            <li class="nav-item">
                                <button type="button" class="nav-link {{ $index === 0 ? 'active' : '' }}" role="tab"
                                    data-bs-toggle="tab" data-bs-target="#tab-{{ $language->code }}"
                                    aria-controls="tab-{{ $language->code }}" aria-selected="false">
                                    {{ $language->code }}
                                </button>
                            </li>
                        @endforeach

                        <li class="nav-item">
                            <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                data-bs-target="#tab-settings" aria-controls="tab-settings" aria-selected="false">
                                Setting
                            </button>
                        </li>
                    </ul>

                    <div class="tab-content">
                        @foreach ($languages as $index => $language)
                            <div class="tab-pane fade {{ $index === 0 ? 'show active' : '' }}"
                                id="tab-{{ $language->code }}" role="tabpanel">
                                <div class="mb-4 row">
                                    <label for="name-{{ $language->id }}" class="col-md-2 col-form-label">Name</label>
                                    <div class="col-md-10">
                                        <input class="form-control" type="text" id="name-{{ $language->id }}"
                                            name="name[{{ $language->id }}]"
                                            value="{{ $catalogContent[$language->id]->name }}" />
                                    </div>
                                </div>

                                <div class="mb-4 row">
                                    <label for="description-{{ $language->id }}"
                                        class="col-md-2 col-form-label">Description</label>
                                    <div class="col-md-10">
                                        <textarea class="form-control" id="description-{{ $language->id }}" name="description[{{ $language->id }}]">{{ $catalogContent[$language->id]->description }}</textarea>
                                    </div>
                                </div>
                                <div class="mb-4 row">
                                    <label for="file-{{ $language->id }}" class="col-md-2 col-form-label">File Upload
                                        ({{ $language->code }})
                                    </label>
                                    <input id="file-{{ $language->id }}" name="file[{{ $language->id }}]" type="file"
                                        data-browse-on-zone-click="true" />
                                    <div id="kartik-files-errors"></div>
                                </div>
                            </div>
                        @endforeach

                        <!-- Tab Settings -->
                        <div class="tab-pane fade" id="tab-settings" role="tabpanel">
                            <div class="container mt-2">
                                <label for="image" class="col-md-2 col-form-label">Upload Image</label>
                                <input id="image" name="image" type="file" data-browse-on-zone-click="true" />
                                <div id="kartik-file-errors"></div>
                            </div>

                            <div class="form-check form-switch mt-4">
                                <input class="form-check-input" type="checkbox" id="status" value="1" name="status"
                                    {{ $catalog->status ? 'checked' : '' }} />
                                <label class="form-check-label" for="status">
                                    <span id="switchStatus">Status</span>
                                </label>
                            </div>
                        </div>
                        <!-- End Tab Settings -->

                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            @foreach ($languages as $language)
                $("input[name='file[{{ $language->id }}]']").fileinput({
                    deleteUrl: "{{ route('administrator.catalog.delete.file', $catalog->id) . '?_token=' . csrf_token() }}&language_id={{ $language->id }}",
                    showRemove: false,
                    uploadAsync: false,
                    enableResumableUpload: true,
                    initialPreviewAsData: true,
                    showCancel: true,
                    showUpload: false,
                    elErrorContainer: '#kartik-files-errors',
                    allowedFileExtensions: ["pdf"],
                    resumableUploadOptions: {
                        chunkSize: 5,
                    },
                    initialPreview: [
                        @if (isset($catalogContent[$language->id]) && $catalogContent[$language->id]->file)
                            "{{ asset('upload/file/catalog/file/' . strtolower($language->code) . '/' . basename($catalogContent[$language->id]->file)) }}"
                        @endif
                    ],
                    initialPreviewConfig: [{
                        type: "pdf",
                        caption: "{{ basename($catalogContent[$language->id]->file) }}",
                        key: 1
                    }],
                    maxFileCount: 1,
                    theme: "bs5",
                    fileActionSettings: {
                        showZoom: function(config) {
                            return config.type === 'pdf' || config.type === 'image';
                        },
                    }
                });
            @endforeach
            $(document).on('filebeforedelete', function(event) {
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
            }).on('filedeleted', function() {});
            $("#image").fileinput({
                deleteUrl: "{{ route('administrator.catalog.delete.image', $catalog->id) . '?_token=' . csrf_token() }}",
                showRemove: false,
                uploadAsync: false,
                enableResumableUpload: true,
                initialPreviewAsData: true,
                showCancel: true,
                showUpload: false,
                elErrorContainer: '#kartik-file-errors',
                allowedFileExtensions: ["jpg", "png", "jpeg", "svg", "raw", "gif", "tif", "webp"],
                resumableUploadOptions: {
                    chunkSize: 5,
                },
                initialPreview: [
                    @if ($catalog && $catalog->image)
                        "{{ asset('upload/file/catalog/image/' . basename($catalog->image)) }}"
                    @endif
                ],
                initialPreviewConfig: [{
                    caption: "{{ basename($catalog->image) }}",
                    key: 1
                }],
                maxFileCount: 1,
                theme: "bs5",
                fileActionSettings: {
                    showZoom: function(config) {
                        return config.type === 'pdf' || config.type === 'image';
                    },
                }
            });
            $('#form-update').on('submit', function(e) {
                e.preventDefault();
                this.submit();
            });
        });
    </script>


@endsection
