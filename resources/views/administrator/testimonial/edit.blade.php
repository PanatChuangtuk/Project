@extends('administrator.layouts.main')

@section('title')
@endsection

@section('stylesheet')
@endsection

@section('content') 
<form id="myForm" action="{{ route('administrator.testimonial.update',$testimonial->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="demo-inline-spacing">
    <div class="text-end">
        <button type="submit" class="btn btn-success">Save</button>
         <a href="javascript:history.go(0)"> <button type="button" class="btn btn-danger">Cancel</button></a>
    </div>
    <div class="card">
        <div class="nav-align-top nav-tabs-shadow mb-6">
            <ul class="nav nav-tabs" role="tablist">
                @foreach ($language as $index =>$languages)
                <li class="nav-item">
                    <button
                        type="button"
                        class="nav-link {{ $index === 0 ? "active" : '' }} "
                        role="tab"
                        data-bs-toggle="tab"
                        data-bs-target="#tab-{{ $languages->code }}"
                        aria-controls="tab-{{ $languages->code }}"
                        aria-selected="false">
                        {{ $languages->code }}
                    </button>
                </li>
                @endforeach
                <li class="nav-item">
                    <button name=""
                        type="button"
                        class="nav-link"
                        role="tab"
                        data-bs-toggle="tab"
                        data-bs-target="#tab-settings"
                        aria-controls="tab-settings"
                        aria-selected="false">
                        Setting
                    </button>
                </li>
            </ul>
            <div class="tab-content">
                @foreach ($language as $index =>$languages)
                <div class="tab-pane fade {{ $index === 0 ? 'show active' : '' }}" id="tab-{{ $languages->code }}" role="tabpanel">
                    <div class="mb-4 row">
                        <label for="html5-text-input" class="col-md-2 col-form-label">Name</label>
                        <div class="col-md-10">
                            <input class="form-control" type="text" placeholder="Input Name" id="name" name="name[{{ $languages->id}}]" value="{{ $testimonialContent[$language->id]->name ?? '' }}"/>
                        </div>
                    </div>
                    <div class="mb-4 row">
                        <label for="html5-text-input" class="col-md-2 col-form-label">Position</label>
                        <div class="col-md-10">
                            <input class="form-control" type="text" placeholder="Input Position" id="positon" name="positon_name[{{ $languages->id}}]"value="{{ $testimonialContent[$language->id]->positon_name ?? '' }}"/>
                        </div>
                    </div>
                    <div class="mb-4 row">
                        <label for="html5-url-input" class="col-md-2 col-form-label">Description</label>
                        <div class="col-md-10">
                            <textarea class="form-control" id="description" style="height:221px" name="description[{{$languages->id}}]"value="{{ $testimonialContent[$language->id]->description ?? '' }}"></textarea>
                        </div>
                    </div>
                </div>
                @endforeach  
                <div class="tab-pane fade" id="tab-settings" role="tabpanel">
                    <div class="mb-4 row">
                    </div>
                    <div class="container mt-3">
                        <input id="image" name="image" type="file" data-browse-on-zone-click="true" />
                        <div id="kartik-file-errors"></div>
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
            uploadUrl: "{{ route('administrator.testimonial.update', $testimonial->id) }}",
            deleteUrl :"{{ route('administrator.testimonial.delete.image',$testimonial->id).'?_token='.csrf_token() }}",
            enableResumableUpload: true,
            showRemove: false,
            uploadAsync: false,
            initialPreviewAsData: true,
            showCancel: true,
            showUpload: false,
            elErrorContainer: '#kartik-file-errors',
            allowedFileExtensions: ["jpg", "png", "jpeg","svg","raw","gif","tif","webp"],
            resumableUploadOptions: {
                chunkSize: 5,
            },
            initialPreview: [
                @if($testimonial)
                src="{{ asset('storage/file/testimonial/' . basename($testimonial->image)) }}"
                @else
                null
                @endif
                ], initialPreviewConfig: [
                @if($testimonial)
                {caption: "{{basename($testimonial->image)}}", key: 1} 
                 @else
                    { caption: "No image available", key: 0 }
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
        return !window.confirm('Are you sure you want to delete this file?');
    });
        
    });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
        const textareas = document.querySelectorAll('.areaEditor');
        textareas.forEach(textarea => {
                ClassicEditor
                    .create(textarea, {
                    ckfinder: {
                uploadUrl: '{{route('administrator.ckeditor.upload').'?_token='.csrf_token()}}', 
            },updateSourceElementOnDestroy: true, })
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

                