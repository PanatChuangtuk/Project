@extends('main')

@section('title')
@endsection

@section('stylesheet')
@endsection

@section('content')
    <div class="section section-cart bg-light pt-0">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url(app()->getLocale() . '/cart') }}">@lang('messages.cart')</a></li>
                <li class="breadcrumb-item active">@lang('messages.checkout')</li>
            </ol>

            <div class="hgroup py-3 w-100">
                <h1 class="h2 text-underline">@lang('messages.checkout')</h1>
            </div>

            <form class="card-info" id="form-create"
                action="{{ route('profile.address.submit', ['lang' => app()->getLocale()]) }}" method="POST">
                @csrf
                <div class="card-body px-md-4 py-2">
                    <h2 class="text-secondary mb-3">@lang('messages.my_address')</h2>
                    <h3 class="fs-18 mb-5">@lang('messages.personal_info')</h3>
                    <div class="row form-row g-4">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="title">@lang('messages.firstname')</label>
                                <input type="text" class="form-control" placeholder="@lang('messages.input_firstname')" name="first_name"
                                    value="{{ old('first_name') }}">
                                @error('first_name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="title">@lang('messages.lastname')</label>
                                <input type="text" class="form-control" placeholder="@lang('messages.lastname')" name="last_name"
                                    value="{{ old('last_name') }}">
                                @error('last_name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="title">@lang('messages.mobile_phone')</label>
                                <input type="text" class="form-control" placeholder="@lang('messages.input_phone')"
                                    pattern="[0-9]{10}" maxlength="10" name="mobile_phone"
                                    title="Please enter a 10-digit phone number" value="{{ old('mobile_phone') }}">
                                @error('mobile_phone')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="title">@lang('messages.email')</label>
                                <input type="email" class="form-control" placeholder="@lang('messages.input_email')" name="email"
                                    value="{{ old('email') }}">
                                @error('email')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="title">@lang('messages.province')</label>
                                <select id="provinceSelect" name="province_id" class="form-select">
                                    <option value="">@lang('messages.select_province')</option>
                                    @foreach ($provinces as $province)
                                        <option value="{{ $province->id }}"
                                            {{ old('province_id') == $province->id ? 'selected' : '' }}>
                                            {{ App::getLocale() == 'en' ? $province->name_en : $province->name_th }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('province_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="title">@lang('messages.district')</label>
                                <select id="districtSelect" name="district_id" class="form-select">
                                    <option value="">@lang('messages.select_district')</option>
                                    @foreach ($districts as $district)
                                        <option class="district-option" data-province="{{ $district->province_id }}"
                                            value="{{ $district->id }}"
                                            {{ old('district_id') == $district->id ? 'selected' : '' }}>
                                            {{ App::getLocale() == 'en' ? $district->name_en : $district->name_th }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('district_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="title">@lang('messages.subdistrict')</label>
                                <select id="subdistrictSelect" name="subdistrict_id" class="form-select">
                                    <option value="">@lang('messages.select_subdistrict')</option>
                                    @foreach ($subdistricts as $subdistrict)
                                        <option class="subdistrict-option" data-district="{{ $subdistrict->amphure_id }}"
                                            value="{{ $subdistrict->id }}"
                                            {{ old('subdistrict_id') == $subdistrict->id ? 'selected' : '' }}>
                                            {{ App::getLocale() == 'en' ? $subdistrict->name_en : $subdistrict->name_th }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('subdistrict_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="title">@lang('messages.postal_code')</label>
                                <select id="postalCodeSelect" name="postal_code" class="form-select">
                                    <option value="">@lang('messages.select_postal_code')</option>
                                    @foreach ($subdistricts as $subdistrict)
                                        <option class="postal-option" data-subdistrict="{{ $subdistrict->id }}"
                                            value="{{ $subdistrict->zip_code }}"
                                            {{ old('postal_code') == $subdistrict->zip_code ? 'selected' : '' }}>
                                            {{ $subdistrict->zip_code }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('postal_code')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-xl-6">
                            <div class="form-group">
                                <label class="title">@lang('messages.detailed_address')</label>
                                <textarea class="form-control h-145" placeholder="@lang('messages.enter_address_details')" name="detail">{{ old('detail') }}</textarea>
                                @error('detail')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-check mt-3">
                                <input type="hidden" name="is_default" value="0">
                                <input class="form-check-input" type="checkbox" value="1" id="check1"
                                    name="is_default" {{ old('is_default') ? 'checked' : '' }}>
                                <label class="form-check-label" for="check1">
                                    <strong>@lang('messages.set_as_default')</strong><br>
                                    <span class="fs-14">@lang('messages.automatic_setting')</span>
                                </label>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="buttons button-confirm justify-content-lg-end mb-4">
                                <a class="btn btn-outline-red"
                                    href="{{ route('profile.address', ['lang' => app()->getLocale()]) }}">@lang('messages.cancel')</a>
                                <button class="btn btn-secondary" type="submit">@lang('messages.submit')</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $('#provinceSelect').on('change', function() {
                var selectedProvince = $(this).val();

                $('#districtSelect .district-option').hide();
                $('#subdistrictSelect .subdistrict-option').hide();
                $('#postalCodeSelect .postal-option').hide();

                if (selectedProvince) {
                    $('#districtSelect .district-option').filter(function() {
                        return $(this).data('province') == selectedProvince;
                    }).show();
                }

                $('#districtSelect').val('');
                $('#subdistrictSelect').val('');
                $('#postalCodeSelect').val('').find('option').hide();
            });
            $('#districtSelect').on('change', function() {
                var selectedDistrict = $(this).val();
                $('#subdistrictSelect .subdistrict-option').hide();
                $('#postalCodeSelect .postal-option').hide();

                if (selectedDistrict) {
                    $('#subdistrictSelect .subdistrict-option').filter(function() {
                        return $(this).data('district') == selectedDistrict;
                    }).show();
                }
                $('#subdistrictSelect').val('');
                $('#postalCodeSelect').val('').find('option').hide();
            });

            $('#subdistrictSelect').on('change', function() {
                var selectedSubdistrict = $(this).val();
                $('#postalCodeSelect .postal-option').hide();
                if (selectedSubdistrict) {
                    $('#postalCodeSelect .postal-option').filter(function() {
                        return $(this).data('subdistrict') == selectedSubdistrict;
                    }).show();
                }
            });
        });
    </script>
@endsection
