@extends('administrator.layouts.main')

@section('title')
@endsection

@section('stylesheet')
@endsection

@section('content')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('administrator.dashboard') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('administrator.contact') }}">Contact</a></li>
        <li class="breadcrumb-item active" aria-current="page">Add</li>
    </ol>
    <form id="form-create" action="{{ route('administrator.contact.submit') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="demo-inline-spacing">
            <div class="text-end">
                <button type="submit" class="btn btn-success">Save</button>
                <a href="{{ route('administrator.contact') }}">
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
                                            id="name-{{ $languages->id }}" name="name[{{ $languages->id }}]" />
                                    </div>
                                </div>

                                <div class="mb-4 row">
                                    <label for="html5-text-input" class="col-md-2 col-form-label">Address</label>
                                    <div class="col-md-10">
                                        <input class="form-control" type="text" placeholder="Input Address"
                                            id="address" name="address[{{ $languages->id }}]" />
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        <div id="contact-info-fields">
                            <div class="mb-4 row">
                                <label for="html5-text-input" class="col-md-2 col-form-label">Phone</label>
                                <div class="col-md-10">
                                    <input class="form-control" type="tel" placeholder="Input Phone" id="phone"
                                        name="phone" pattern="[0-9]{10}"
                                        title="Please enter a valid 10-digit phone number" />
                                </div>
                            </div>

                            <div class="mb-4 row">
                                <label for="html5-text-input" class="col-md-2 col-form-label">Fax</label>
                                <div class="col-md-10">
                                    <input class="form-control" type="fax" placeholder="Input Fax" id="fax"
                                        name="fax" pattern="[0-9]{9}" title="Please enter a valid 9-digit fax number" />
                                </div>
                            </div>

                            <div class="mb-4 row">
                                <label for="html5-text-input" class="col-md-2 col-form-label">Email</label>
                                <div class="col-md-10">
                                    <input class="form-control" type="email" placeholder="Input Email" id="email"
                                        name="email" />
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="tab-settings" role="tabpanel">
                            <div class="mb-4 row">
                                <input id="image" name="image" type="file" data-browse-on-zone-click="true" />
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
            $(".nav-link").on("click", function() {
                var target = $(this).data("bs-target");
                if (target === "#tab-settings") {
                    $("#contact-info-fields").hide();
                } else {
                    $("#contact-info-fields").show();
                }
            });
        });
    </script>
@endsection
