@extends('main')
@section('title')
    @lang('messages.find_your_email')
@endsection
@section('stylesheet')
@endsection
@section('content')
    <div class="section section-column">
        <div class="container">
            <div class="row row-main">
                <div class="cols col-photo" data-aos="fade-in">
                    <img src="{{ asset('img/thumb/photo-1000x965--1.jpg') }}" alt="" />
                </div>
                <!--cols-->
                <div class="cols col-form" data-aos="fade-in">
                    <div class="boxed me-lg-0">
                        <div class="article pb-3" style="--font-size: 14px; --color: #375b51">
                            <h2>@lang('messages.find_your_email')</h2>

                            <p>
                                @lang('messages.enter_phone_or_email')
                            </p>
                        </div>

                        <form id="forgotPasswordForm" class="form" method="POST"
                            action="{{ route('login.forgot.password.submit', ['lang' => app()->getLocale()]) }}">
                            @csrf
                            <div class="row g-4">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="title">@lang('messages.email')/@lang('messages.phone_number')</label>
                                        <input type="text" class="form-control" name="email_or_phone"
                                            value="{{ old('email_or_phone') }}" placeholder="@lang('messages.input_email_or_phone')" />
                                    </div>
                                    @error('email_or_phone')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-12 d-flex pt-sm-4">
                                    <button class="btn px-5 ms-auto me-sm-0 me-auto" type="submit">
                                        <span class="px-3">@lang('messages.submit')</span>
                                    </button>
                                </div>
                            </div>
                        </form>

                    </div>
                    <!--boxed-->
                </div>
                <!--cols-->
            </div>
            <!--row-main-->
        </div>
        <!--container-->
    </div>
    <!--section-->
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            $('#forgotPasswordForm').on('submit', function(e) {
                e.preventDefault();

                $.ajax({
                    url: $(this).attr('action'),
                    method: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        if (response.status === 'success') {
                            Swal.fire({
                                title: '@lang('messages.completed')',
                                icon: 'success',
                                confirmButtonText: '@lang('messages.ok')'
                            }).then((result) => {
                                window.location.href =
                                    "{{ route('forgot.password', ['lang' => app()->getLocale()]) }}";
                            });
                        } else {
                            Swal.fire({
                                title: '@lang('messages.email_or_phone_field_required')',
                                icon: 'error',
                                confirmButtonText: '@lang('messages.ok')'
                            });
                        }
                    },
                    error: function(xhr) {
                        if (xhr.status === 404) {
                            Swal.fire({
                                title: '@lang('messages.user_not_found')',
                                icon: 'error',
                                confirmButtonText: '@lang('messages.ok')'
                            });
                        }
                    }
                });
            });
        });
    </script>
@endsection
