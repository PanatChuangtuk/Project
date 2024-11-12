@extends('main')

@section('title')
@endsection

@section('stylesheet')
@endsection

@section('content')
    <div class="section section-cart bg-light pt-0">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="my-account.html">@lang('messages.profile')</a>
                </li>
                <li class="breadcrumb-item active">@lang('messages.full_tax_invoice')</li>
            </ol>

            <div class="hgroup py-3 w-100">
                <h1 class="h2 text-underline">@lang('messages.profile')</h1>
            </div>

            <form class="card-info" action="{{ route('tax.update', ['lang' => app()->getLocale(), $tax->id]) }}"
                method="POST">
                @csrf
                <div class="card-body px-md-4 py-2">
                    <h2 class="text-secondary mb-3">@lang('messages.update_full_tax_invoice')</h2>

                    <h3 class="fs-18">@lang('messages.personal_info')</h3>

                    <div class="d-flex gap-5 py-4">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" value="personal" id="personalCheck"
                                name="type" {{ $tax->type == 'personal' ? 'checked' : '' }} />
                            <label class="form-check-label fs-15 text-black" for="personalCheck">
                                @lang('messages.personal')
                            </label>
                        </div>

                        <div class="form-check">
                            <input class="form-check-input" type="radio" value="company" id="companyCheck" name="type"
                                {{ $tax->type == 'company' ? 'checked' : '' }} />
                            <label class="form-check-label fs-15 text-black" for="companyCheck">
                                @lang('messages.company_data')
                            </label>
                        </div>
                    </div>

                    <div class="row form-row g-4">
                        <div class="col-md-6" id="form-company"
                            style="{{ $tax->type == 'company' ? '' : 'display: none;' }}">
                            <div class="form-group">
                                <label class="title">@lang('messages.company')</label>
                                <input type="text" class="form-control" placeholder="@lang('messages.input_company')" name="name"
                                    value="{{ old('name', $tax->name) }}" />
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="title">@lang('messages.firstname')</label>
                                <input type="text" class="form-control" placeholder="@lang('messages.input_firstname')"
                                    name="first_name" value="{{ old('first_name', $tax->first_name) }}">
                                @error('first_name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="title">@lang('messages.lastname')</label>
                                <input type="text" class="form-control" placeholder="@lang('messages.input_lastname')" name="last_name"
                                    value="{{ old('last_name', $tax->last_name) }}">
                                @error('last_name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="title">@lang('messages.mobile_phone')</label>
                                <input type="text" class="form-control" placeholder="@lang('messages.input_phone')" maxlength="10"
                                    name="mobile_phone" title="Please enter a 10-digit phone number"
                                    value="{{ old('mobile_phone', $tax->mobile_phone) }}">
                                @error('mobile_phone')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="title">@lang('messages.input_email')</label>
                                <input type="email" class="form-control" placeholder="@lang('messages.input_email')" name="email"
                                    value="{{ old('email', $tax->email) }}">
                                @error('email')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <h3 class="fs-18 mb-3 mt-5">@lang('messages.tax_info')</h3>
                    <div class="row form-row g-4">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="title">@lang('messages.tax_id')</label>
                                <input type="text" maxlength="13" class="form-control" name="tax_id"
                                    placeholder="@lang('messages.input_tax_id')" value="{{ old('tax_id', $tax->tax_id) }}">
                                @error('tax_id')
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
                                            {{ $tax->province_id == $province->id ? 'selected' : '' }}>
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
                                            {{ $tax->district_id == $district->id ? 'selected' : '' }}>
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
                                            {{ $tax->subdistrict_id == $subdistrict->id ? 'selected' : '' }}>
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
                                            {{ $tax->postal_code == $subdistrict->zip_code ? 'selected' : '' }}>
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
                                <textarea class="form-control h-145" placeholder="@lang('messages.enter_address_details')" name="detail">{{ old('detail', $tax->detail) }}</textarea>
                                @error('detail')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-check mt-3">
                                <input type="hidden" name="is_default" value="0">
                                <input class="form-check-input" type="checkbox" value="1" id="check1"
                                    name="is_default" {{ $tax->is_default ? 'checked' : '' }}>
                                <label class="form-check-label" for="check1">
                                    <strong>@lang('messages.set_as_default')</strong><br>
                                    <span class="fs-14">@lang('messages.automatic_setting')</span>
                                </label>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="buttons button-confirm justify-content-lg-end mb-4">
                                <a class="btn btn-outline-red"
                                    href="{{ route('tax', ['lang' => app()->getLocale()]) }}">@lang('messages.cancel')</a>
                                <button type="submit" class="btn btn-secondary">@lang('messages.submit')</button>
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

                $('#provinceSelect').on('change', function() {
                    $('#districtSelect').val('');
                    $('#subdistrictSelect').val('');
                    $('#postalCodeSelect').val('').find('option').hide();
                });
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

                $('#districtSelect').on('change', function() {
                    $('#subdistrictSelect').val('');
                    $('#postalCodeSelect').val('').find('option').hide();
                });
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

        if ($('input[name="type"]:checked').val() === 'company') {
            $('#form-company').show();
        }

        $('input[name="type"]').change(function() {
            if ($(this).val() === 'personal') {
                $('#form-company').hide();
            } else {
                $('#form-company').show();
            }
        });
    </script>
@endsection
