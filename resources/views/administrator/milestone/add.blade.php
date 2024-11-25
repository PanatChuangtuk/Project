@extends('administrator.layouts.main')

@section('title')
@endsection

@section('stylesheet')
@endsection

@section('content')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('administrator.dashboard') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('administrator.milestone') }}">Milestone</a></li>
        <li class="breadcrumb-item active" aria-current="page">Add</li>
    </ol>
    <form id="form-create" action="{{ route('administrator.milestone.submit') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="demo-inline-spacing">
            <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center me-2"></div>
                <div class="d-flex align-items-center">
                    <label for="aboutSelect" class="form-label me-2">Select Type</label>
                    <select id="aboutSelect" name="about_type" class="form-select" style="width: 125px;">
                        @foreach ($aboutOptions as $option)
                            <option value="{{ $option->value }}">{{ $option->name }}</option>
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
                        @foreach ($language as $index => $languages)
                            <li class="nav-item">
                                <button type="button" class="nav-link {{ $index === 0 ? 'active' : '' }}" role="tab"
                                    data-bs-toggle="tab" data-bs-target="#tab-{{ $languages->code }}"
                                    aria-controls="tab-{{ $languages->code }}" aria-selected="false">
                                    {{ $languages->code }}
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
                        @foreach ($language as $index => $languages)
                            <div class="tab-pane fade {{ $index === 0 ? 'show active' : '' }}"
                                id="tab-{{ $languages->code }}" role="tabpanel">
                                <div class="mb-4 row">
                                    <label for="name-{{ $languages->id }}" class="col-md-2 col-form-label">Name</label>
                                    <div class="col-md-10">
                                        <input class="form-control" type="text" placeholder="Input Name"
                                            value="{{ old('name.' . $languages->id) }}" id="name-{{ $languages->id }}"
                                            name="name[{{ $languages->id }}]" />
                                        @error('name.' . $languages->id)
                                            <div class="text-danger col-form-label">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-4 row" id="description-field-{{ $languages->id }}">
                                    <label for="description-{{ $languages->id }}"
                                        class="col-md-2 col-form-label">Description</label>
                                    <div class="col-md-10">
                                        <textarea class="form-control" style="height:221px" id="description-{{ $languages->id }}"
                                            name="description[{{ $languages->id }}]"></textarea>
                                    </div>
                                </div>

                                <div class="mb-4 row content-field" id="contentFiled-{{ $languages->id }}">
                                    <label for="content-{{ $languages->id }}"
                                        class="col-md-2 col-form-label">Content</label>
                                    <div class="col-md-10">
                                        <textarea name="content[{{ $languages->id }}]" class="areaEditor form-control" cols="30" rows="5"
                                            id="content-{{ $languages->id }}"></textarea>
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
                                <input class="form-check-input" type="checkbox" id="status" value="1"
                                    name="status" />
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
                        if (config.type === 'image') {
                            return true;
                        }
                        return false;
                    }
                }
            });
        });
    </script>

    <script>
        window.csrfToken = @json(csrf_token());
    </script>
    <script type="module" src="{{ asset('administrator/js/ckeditor.js') }}"></script>

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
