@extends('administrator.layouts.main')

@section('title')
@endsection

@section('stylesheet')
@endsection

@section('content')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('administrator.dashboard') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('administrator.milestone') }}">Milestone</a></li>
        <li class="breadcrumb-item active" aria-current="page">Edit</li>
    </ol>
    <form id="form-update" action="{{ route('administrator.milestone.update', $about->id) }}" method="POST"
        enctype="multipart/form-data">
        @csrf
        <div class="demo-inline-spacing">
            <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center me-2"></div>
                <div class="d-flex align-items-center">
                    <label for="aboutSelect" class="form-label me-2">Select Type</label>
                    <select id="aboutSelect" name="about_type" class="form-select" style="width: 125px;">
                        @foreach ($aboutOptions as $option)
                            <option value="{{ $option->value }}" {{ $about->type === $option->value ? 'selected' : '' }}>
                                {{ $option->name }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="btn btn-success ms-3">Save</button>
                    <a href="{{ route('administrator.milestone') }}">
                        <button type="button" class="btn btn-danger ms-2">Cancel</button>
                    </a>
                </div>
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
                        <li class="nav-item" id="seting">
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
                                        <input class="form-control" type="text" placeholder="Input Name"
                                            id="name-{{ $language->id }}" name="name[{{ $language->id }}]"
                                            value="{{ $aboutContent[$language->id]->name ?? '' }}" />
                                    </div>
                                </div>
                                <div class="mb-4 row" id="description-field-{{ $language->id }}">
                                    <label for="description-{{ $language->id }}"
                                        class="col-md-2 col-form-label">Description</label>
                                    <div class="col-md-10">
                                        <textarea class="form-control" style="height:221px" id="description-{{ $language->id }}"
                                            name="description[{{ $language->id }}]">{{ $aboutContent[$language->id]->description ?? '' }}</textarea>
                                    </div>
                                </div>
                                <div class="mb-4 row content-field" id="contentFiled-{{ $language->id }}">
                                    <label for="content-{{ $language->id }}"
                                        class="col-md-2 col-form-label">Content</label>
                                    <div class="col-md-10">
                                        <textarea name="content[{{ $language->id }}]" class="areaEditor form-control" cols="30" rows="5"
                                            id="content-{{ $language->id }}">{{ $aboutContent[$language->id]->content ?? '' }}</textarea>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        <div class="tab-pane fade" id="tab-settings" role="tabpanel">
                            <div class="mb-4 row">
                                <input id="icon" name="icon" type="file" data-browse-on-zone-click="true" />
                                <div class="col-md-10"></div>
                                <div id="kartik-file-errors"></div>
                            </div>
                            <div class="form-check form-switch mt-4">
                                <input class="form-check-input" type="checkbox" id="status" value="1" name="status"
                                    {{ $about->status ? 'checked' : '' }} />
                                <label class="form-check-label" for="status">
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
            $("#icon").fileinput({
                deleteUrl: "{{ route('administrator.milestone.delete.image', $about->id) . '?_token=' . csrf_token() }}",
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
                    @if ($about->icon)
                        src = "{{ asset('upload/file/milestone/' . basename($about->icon)) }}"
                    @else
                        null
                    @endif
                ],
                initialPreviewConfig: [
                    @if ($about)
                        {
                            caption: "{{ basename($about->icon) }}",
                            key: 1
                        }
                    @else
                        {
                            caption: "No icon available",
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
        document.addEventListener("DOMContentLoaded", function() {
            const textareas = document.querySelectorAll('.areaEditor');
            textareas.forEach(textarea => {
                ClassicEditor
                    .create(textarea, {
                        ckfinder: {
                            uploadUrl: '{{ route('administrator.ckeditor.upload') . '?_token=' . csrf_token() }}',
                        }
                    })
                    .then(editor => {
                        textarea.contentInstance = editor;
                    })
                    .catch(error => {
                        console.error(error);
                    });
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('.content-field').hide();
            $('[id^=description-field-]').show();
            $('#seting').hide();

            var initialType = $('#aboutSelect').val();
            if (initialType === 'block') {
                $('.content-field').hide();
                $('[id^=description-field-]').show();
                $('#seting').show();
            } else if (initialType === 'content') {
                $('.content-field').show();
                $('[id^=description-field-]').hide();
            }

            $('#aboutSelect').change(function() {
                var selectedType = $(this).val();
                if (selectedType === 'block') {
                    $('.content-field').hide();
                    $('[id^=description-field-]').show();
                    $('#seting').show();
                } else if (selectedType === 'content') {
                    $('.content-field').show();
                    $('[id^=description-field-]').hide();
                    $('#seting').hide();
                }
            });
        });
    </script>
@endsection
