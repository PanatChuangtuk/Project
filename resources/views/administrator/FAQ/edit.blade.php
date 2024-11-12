@extends('administrator.layouts.main')

@section('title')
@endsection

@section('stylesheet')
@endsection

@section('content')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('administrator.dashboard') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('administrator.faq') }}">Faq</a></li>
        <li class="breadcrumb-item active" aria-current="page">Edit</li>
    </ol>
    <form id="form-update" action="{{ route('administrator.faq.update', $faq->id) }}" method="POST">
        @csrf
        <div class="demo-inline-spacing">
            <div class="text-end">
                <button type="submit" class="btn btn-success">Save</button>
                <a href="{{ route('administrator.faq') }}"> <button type="button"
                        class="btn btn-danger">Cancel</button></a>
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
                                            id="name-{{ $languages->id }}" name="name[{{ $languages->id }}]"
                                            value="{{ $faqContent[$languages->id]->name ?? '' }}" />
                                    </div>
                                </div>

                                <div class="mb-4 row">
                                    <label for="content-{{ $languages->id }}"
                                        class="col-md-2 col-form-label">Content</label>
                                    <div class="col-md-10">
                                        <textarea name="content[{{ $languages->id }}]" class="areaEditor form-control" cols="30" rows="5"
                                            id="content-{{ $languages->id }}">{{ $faqContent[$languages->id]->content ?? '' }}</textarea>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        <div class="tab-pane fade" id="tab-settings" role="tabpanel">
                            <div class="row mb-3">
                                <label class="col-md-1 col-form-label" for="status">Status</label>
                                <div class="col-md-5 d-flex align-items-center">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="status" value="1"
                                            name="status" {{ $faq->status ? 'checked' : '' }} />
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
        document.addEventListener("DOMContentLoaded", function() {
            const textareas = document.querySelectorAll('.areaEditor');
            textareas.forEach(textarea => {
                ClassicEditor
                    .create(textarea, {
                        ckfinder: {
                            uploadUrl: '{{ route('administrator.ckeditor.upload') . '?_token=' . csrf_token() }}',
                        },
                        updateSourceElementOnDestroy: true,
                    })
                    .then(content => {
                        textarea.contentInstance = content;
                    })
                    .catch(error => {
                        console.error(error);
                    });
            });
        });
    </script>
@endsection
