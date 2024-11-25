@extends('administrator.layouts.main')

@section('title')
@endsection

@section('stylesheet')
@endsection

@section('content')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('administrator.dashboard') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('administrator.promotion') }}">Promotion</a></li>
        <li class="breadcrumb-item active" aria-current="page">Edit</li>
    </ol>
    <form id="form-update" action="{{ route('administrator.promotion.update', $promotion->id) }}" method="POST"
        enctype="multipart/form-data">
        @csrf
        <div class="demo-inline-spacing">
            <div class="text-end">
                <button type="submit" class="btn btn-success">Save</button>
                <a href="{{ route('administrator.promotion') }}">
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
                                        <input class="form-control" type="text"
                                            value="{{ $promotionContents[$language->id]->name ?? '' }}"
                                            id="name-{{ $language->id }}" name="name[{{ $language->id }}]" />
                                    </div>
                                </div>
                                <div class="mb-4 row">
                                    <label for="description-{{ $language->id }}"
                                        class="col-md-2 col-form-label">Description</label>
                                    <div class="col-md-10">
                                        <textarea class="form-control" id="description-{{ $language->id }}" name="description[{{ $language->id }}]">{{ $promotionContents[$language->id]->description ?? '' }}</textarea>
                                    </div>
                                </div>
                                <div class="mb-4 row">
                                    <label for="content-{{ $language->id }}"
                                        class="col-md-2 col-form-label">Content</label>
                                    <div class="col-md-10">
                                        <textarea name="content[{{ $language->id }}]" class="areaEditor form-control" cols="30" rows="5"
                                            id="content-{{ $language->id }}">{{ $promotionContents[$language->id]->content ?? '' }}</textarea>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        <div class="tab-pane fade" id="tab-settings" role="tabpanel">
                            <div class="container mt-5">
                                <input id="image" name="image" type="file" data-browse-on-zone-click="true" />
                                <div id="kartik-file-errors"></div>
                            </div>

                            <div class="form-check form-switch mt-4">
                                <input type="hidden" name="status" value="0">
                                <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault" value="1"
                                    name="status" {{ $promotion->status == 1 ? 'checked' : '' }} />
                                <label class="form-check-label" for="flexSwitchCheckDefault">
                                    <span id="switchStatus">Status</span>
                                </label>
                            </div>
                        </div>
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
                deleteUrl: "{{ route('administrator.promotion.delete.image', $promotion->id) . '?_token=' . csrf_token() }}",
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
                    @if ($promotion->image)
                        src =
                            "{{ asset('upload/file/promotion/' . basename($promotion->image)) }}"
                    @else
                        null
                    @endif
                ],
                initialPreviewConfig: [
                    @if ($promotion)
                        {
                            caption: "{{ basename($promotion->image) }}",
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
                        return config.type === 'pdf' || config.type === 'image';
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

    <script>
        window.csrfToken = @json(csrf_token());
    </script>
    <script type="module" src="{{ asset('administrator/js/ckeditor.js') }}"></script>
@endsection
