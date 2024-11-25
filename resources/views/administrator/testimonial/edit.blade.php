@extends('administrator.layouts.main')

@section('title')
    Edit Testimonial
@endsection

@section('stylesheet')
    <!-- เพิ่ม CSS ถ้าจำเป็น -->
@endsection

@section('content')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('administrator.dashboard') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('administrator.testimonial') }}">Testimonial</a></li>
        <li class="breadcrumb-item active" aria-current="page">Edit</li>
    </ol>

    <form id="form-update" action="{{ route('administrator.testimonial.update', $testimonial->id) }}" method="POST"
        enctype="multipart/form-data">
        @csrf
        <div class="demo-inline-spacing">
            <div class="text-end">
                <button type="submit" class="btn btn-success">Save</button>
                <a href="{{ route('administrator.testimonial') }}">
                    <button type="button" class="btn btn-danger">Cancel</button>
                </a>
            </div>

            <div class="card">
                <div class="nav-align-top nav-tabs-shadow mb-6">
                    <ul class="nav nav-tabs" role="tablist">
                        @foreach ($language as $index => $languages)
                            <li class="nav-item">
                                <button type="button" class="nav-link {{ $index === 0 ? 'active' : '' }}" role="tab"
                                    data-bs-toggle="tab" data-bs-target="#tab-{{ $languages->code }}"
                                    aria-controls="tab-{{ $languages->code }}" aria-selected="false">
                                    {{ $languages->code }}
                                </button>
                            </li>
                        @endforeach
                        <li class="nav-item">
                            <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                data-bs-target="#tab-settings" aria-controls="tab-settings" aria-selected="false">
                                Settings
                            </button>
                        </li>
                    </ul>

                    <div class="tab-content">
                        @foreach ($language as $index => $languages)
                            <div class="tab-pane fade {{ $index === 0 ? 'show active' : '' }}"
                                id="tab-{{ $languages->code }}" role="tabpanel">
                                <div class="mb-4 row">
                                    <label for="name-{{ $languages->id }}" class="col-md-2 col-form-label">Name</label>
                                    <div class="col-md-10">
                                        <input class="form-control" type="text" placeholder="Input Name"
                                            id="name-{{ $languages->id }}" name="name[{{ $languages->id }}]"
                                            value="{{ $testimonialContent[$languages->id]->name ?? '' }}" />
                                    </div>
                                </div>

                                <div class="mb-4 row">
                                    <label for="profile_name-{{ $languages->id }}" class="col-md-2 col-form-label">Position
                                        Name</label>
                                    <div class="col-md-10">
                                        <input class="form-control" type="text" id="profile_name-{{ $languages->id }}"
                                            name="profile_name[{{ $languages->id }}]"
                                            value="{{ $testimonialContent[$languages->id]->profile_name ?? '' }}" />
                                    </div>
                                </div>

                                <div class="mb-4 row">
                                    <label for="profile_position-{{ $languages->id }}"
                                        class="col-md-2 col-form-label">Profile Position</label>
                                    <div class="col-md-10">
                                        <input class="form-control" type="text"
                                            id="profile_position-{{ $languages->id }}"
                                            name="profile_position[{{ $languages->id }}]"
                                            value="{{ $testimonialContent[$languages->id]->profile_position ?? '' }}" />
                                    </div>
                                </div>

                                <div class="mb-4 row">
                                    <label for="content-{{ $languages->id }}"
                                        class="col-md-2 col-form-label">Content</label>
                                    <div class="col-md-10">
                                        <textarea class="form-control areaEditor" id="content-{{ $languages->id }}" style="height:221px"
                                            name="content[{{ $languages->id }}]">{{ $testimonialContent[$languages->id]->content ?? '' }}</textarea>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        <div class="tab-pane fade" id="tab-settings" role="tabpanel">
                            <div class="container mt-3">
                                <div class="mb-4">
                                    <label for="profile_image" class="form-label">Profile Image</label>
                                    <input id="profile_image" name="profile_image" type="file" class="form-control"
                                        data-browse-on-zone-click="true" />
                                    <div id="kartik-file-errors" class="text-danger mt-2"></div>
                                </div>

                                <div class="row mb-4">
                                    <label class="col-md-2 col-form-label" for="status">Status</label>
                                    <div class="col-md-10 d-flex align-items-center">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="status" value="1"
                                                name="status" {{ $testimonial->status ? 'checked' : '' }} />
                                            <label class="form-check-label ms-2" for="status">Active</label>
                                        </div>
                                    </div>
                                </div>
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
            $("#profile_image").fileinput({
                deleteUrl: "{{ route('administrator.testimonial.delete.image', $testimonial->id) . '?_token=' . csrf_token() }}",
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
                    @if ($testimonial->profile_image)
                        "{{ asset('upload/file/testimonial/' . basename($testimonial->profile_image)) }}"
                    @else
                        null
                    @endif
                ],
                initialPreviewConfig: [
                    @if ($testimonial)
                        {
                            caption: "{{ basename($testimonial->profile_image) }}",
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

    <script>
        window.csrfToken = @json(csrf_token());
    </script>
    <script type="module" src="{{ asset('administrator/js/ckeditor.js') }}"></script>
@endsection
