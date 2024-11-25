@extends('administrator.layouts.main')

@section('title')
@endsection

@section('stylesheet')
@endsection

@section('content')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('administrator.dashboard') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('administrator.common') }}">Common</a></li>
        <li class="breadcrumb-item active" aria-current="page">Add</li>
    </ol>
    <form id="form-create" action="{{ route('administrator.common.submit') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="demo-inline-spacing">
            <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center me-2"></div>
                <div class="d-flex align-items-center">
                    <label for="commonSelect" class="form-label me-2">Select Type</label>
                    <select id="commonSelect" name="common_type" class="form-select" style="width: 155px;">
                        @foreach ($commonOptions as $option)
                            <option value="{{ $option->value }}">{{ $option->name }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="btn btn-success ms-3">Save</button>
                    <a href="{{ route('administrator.common') }}">
                        <button type="button" class="btn btn-danger ms-2">Cancel</button>
                    </a>
                </div>
            </div>

            <div class="card">
                <div class="nav-align-top nav-tabs-shadow mb-6">
                    <ul class="nav nav-tabs" role="tablist">
                        @foreach ($language as $index => $languages)
                            <li class="nav-item">
                                <button type="button" class="nav-link {{ $index === 0 ? 'active' : '' }} " role="tab"
                                    data-bs-toggle="tab" data-bs-target="#tab-{{ $languages->code }}"
                                    aria-controls="tab-{{ $languages->code }}" aria-selected="false">
                                    {{ $languages->code }}
                                </button>
                            </li>
                        @endforeach

                        {{-- <li class="nav-item">
                        <button
                            type="button"
                            class="nav-link"
                            role="tab"
                            data-bs-toggle="tab"
                            data-bs-target="#tab-settings"
                            aria-controls="tab-settings"
                            aria-selected="false">
                            Setting
                        </button>
                    </li> --}}
                    </ul>

                    <div class="tab-content">
                        @foreach ($language as $index => $languages)
                            <div class="tab-pane fade {{ $index === 0 ? 'show active' : '' }}"
                                id="tab-{{ $languages->code }}" role="tabpanel">
                                <div class="mb-4 row">
                                    <label for="html5-text-input" class="col-md-2 col-form-label">Name</label>
                                    <div class="col-md-10">
                                        <input class="form-control" type="text" placeholder="Input Name" id="name"
                                            name="name[{{ $languages->id }}]"
                                            value="{{ old('name.' . $languages->id) }}" />
                                        @error('name.' . $languages->id)
                                            <div class="text-danger col-form-label">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-4 row">
                                    <label for="html5-url-input" class="col-md-2 col-form-label">Description</label>
                                    <div class="col-md-10">
                                        <textarea class="form-control" id="description" name="description[{{ $languages->id }}]"></textarea>
                                    </div>
                                </div>

                                <div class="mb-4 row">
                                    <label for="content" class="col-md-2 col-form-label">Content</label>
                                    <div class="col-md-10">
                                        <textarea name="content[{{ $languages->id }}]" class="areaEditor form-control" cols="30" rows="5"
                                            id="content"></textarea>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@section('script')
    <script>
        window.csrfToken = @json(csrf_token());
    </script>
    <script type="module" src="{{ asset('administrator/js/ckeditor.js') }}"></script>
@endsection
