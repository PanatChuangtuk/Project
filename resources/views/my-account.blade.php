@extends('main')

@section('title')
    โปรไฟล์
@endsection

@section('stylesheet')
@endsection

@section('content')
    <div class="section section-profile bg-light pt-0">
        <div class="container has-sidebar">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">โปรไฟล์</li>
            </ol>

            <x-nav-profile />
            <!--sidebar-->

            <div class="content">
                <div class="card-info main px-5">
                    <div class="avatar-setting">
                        <img class="avatar" src="{{ asset('upload/images/' . $profile->info->avatar) }}" alt="" />

                    </div>

                    <form class="form pt-3" method="POST" action="{{ route('profile.submit') }}">
                        @csrf
                        <div class="row form-row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="title">อีเมล<span class="star">*</span></label>
                                    <input type="email" class="form-control" name ="email"
                                        value="{{ $profile->email ?? null }}"readonly />
                                    @error('email')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="title">เบอร์โทรศัพท์</label>
                                    <input type="text" class="form-control"name="mobile_phone"
                                        value="{{ $profile->info->mobile_phone ?? null }}" pattern="[0-9]*"
                                        maxlength="10" />
                                    @error('mobile_phone')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="title">ชื่อ</label>
                                    <input type="text" class="form-control"name="first_name"
                                        value="{{ $profile->info->first_name ?? null }}" />
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="title">นามสกุล</label>
                                    <input type="text" class="form-control" name="last_name"
                                        value="{{ $profile->info->last_name ?? null }}" />
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="title">รหัสนักศึกษา</label>
                                    <input type="text" class="form-control"
                                        value="{{ $profile->info->student->student_number ?? null }}"readonly />
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="title">อาจารย์ที่ปรึกษา</label>
                                    <input type="text" class="form-control"
                                        value="{{ $profile->info->adviser->first_name . ' ' . $profile->info->adviser->last_name ?? null }}"readonly />
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary" id="confirmSave">บันทึก</button>
                            </div>
                        </div>
                        <!--row-->
                    </form>
                </div>
                <!--card-info-->
            </div>
            <!--content-->
        </div>
        <!--container-->
    </div>
    <!--section-->
@endsection

@section('script')
@endsection
