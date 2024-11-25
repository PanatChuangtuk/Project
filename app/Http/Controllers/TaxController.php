<?php

namespace App\Http\Controllers;

use App\Http\Controllers\MainController;
use Illuminate\Support\Facades\{Auth, Validator, DB};
use Illuminate\Http\Request;
use App\Models\MemberAddressTax;

class TaxController extends MainController
{
    public function tax()
    {
        $userId = Auth::guard('member')->user()->id;
        $tax = MemberAddressTax::select('member_address_tax.*')
            ->where('member_address_tax.member_id', $userId)->orderBy('is_default', 'desc')
            ->get();
        return view('tax-invoice', compact('tax'));
    }
    public function edit($lang, $id)
    {
        $url = url()->previous();
        $provinces = DB::table('provinces')->select('id', 'name_th', 'name_en')->get();
        $districts = DB::table('amphures')->select('id', 'name_th', 'name_en', 'province_id')->get();
        $subdistricts = DB::table('tambons')
            ->select('id', 'zip_code', 'name_th', 'name_en', 'amphure_id')
            ->get();
        $tax = MemberAddressTax::find($id);
        return view('request-full-tax-invoice-detail', compact('tax', 'provinces', 'districts', 'subdistricts', 'url'));
    }

    public function add()
    {
        $url = url()->previous();
        $provinces = DB::table('provinces')->select('id', 'name_th', 'name_en')->get();
        $districts = DB::table('amphures')->select('id', 'name_th', 'name_en', 'province_id')->get();
        $subdistricts = DB::table('tambons')
            ->select('id', 'zip_code', 'name_th', 'name_en', 'amphure_id')
            ->get();

        return view('request-full-tax-invoice', compact('provinces', 'districts', 'subdistricts', 'url'));
    }

    public function submit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'mobile_phone' => ['required', 'regex:/^[0-9]{10}$/'],
            'tax_id' => ['required', 'regex:/^(?:[0-9]{10}|[0-9]{13})$/', 'max:13'],
            'postal_code' =>  ['required', 'regex:/^[0-9]{5}$/'],
            'detail' => 'nullable|string',
            'province_id' => 'required',
            'district_id' => 'required',
            'subdistrict_id' => 'required',
            'postal_code' => 'required',
        ], [
            'first_name.required' => __('messages.please_enter_firstname'),
            'first_name.string' => __('messages.firstname_must_be_text'),
            'first_name.max' => __('messages.firstname_must_not_exceed_255_characters'),
            'last_name.required' =>  __('messages.please_enter_lastname'),
            'last_name.string' => __('messages.lastname_must_be_text'),
            'last_name.max' => __('messages.lastname_must_not_exceed_255_characters'),
            'mobile_phone.required' => __('messages.please_enter_mobile_number'),
            'mobile_phone.regex' => __('messages.mobile_number_must_be_10_digits'),
            'email.required' => __('messages.please_enter_email'),
            'email.email' => __('messages.please_enter_valid_email'),
            'email.max' => __('messages.email_must_not_exceed_255_characters'),
            'tax_id.required' => __('messages.please_enter_tax_id'),
            'tax_id.regex' => __('messages.tax_id_must_be_10_or_13_digits'),
            'tax_id.max' => __('messages.tax_id_must_not_exceed_13_characters'),
            'postal_code.required' =>  __('messages.select_postal_code'),
            'postal_code.regex' =>  __('messages.postal_code_must_be_5_digits'),
            'detail.string' =>  __('messages.details_must_be_text'),
            'province_id.required' => __('messages.select_province'),
            'district_id.required' => __('messages.select_district'),
            'subdistrict_id.required' => __('messages.select_subdistrict'),
            'postal_code.required' => __('messages.select_postal_code'),
        ]);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $userId = Auth::guard('member')->user()->id;
        $status = $request->input('is_default', 0);
        if ($status == 1) {
            MemberAddressTax::where('member_id', $userId)->update(['is_default' => 0]);
        }

        MemberAddressTax::create([
            'member_id' => $userId,
            'name' => $request->input('name'),
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'mobile_phone' => $request->input('mobile_phone'),
            'email' => $request->input('email'),
            'province_id' => $request->input('province_id'),
            'district_id' => $request->input('district_id'),
            'subdistrict_id' => $request->input('subdistrict_id'),
            'tax_id' =>  $request->input('tax_id'),
            'postal_code' => $request->input('postal_code'),
            'detail' => $request->input('detail'),
            'type' => $request->input('type'),
            'is_default' => $status,
            'created_by' => $userId
        ]);
        if (route('tax', ['lang' => app()->getLocale()]) !== $request->input('url')) {
            return redirect($request->input('url'));
        }
        return redirect()->route('tax', ['lang' => app()->getLocale()]);
    }

    public function update(Request $request, $lang, $id)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'mobile_phone' => ['required', 'regex:/^[0-9]{10}$/'],
            'tax_id' => ['required', 'regex:/^(?:[0-9]{10}|[0-9]{13})$/', 'max:13'],
            'postal_code' =>  ['required', 'regex:/^[0-9]{5}$/'],
            'detail' => 'nullable|string',
            'province_id' => 'required',
            'district_id' => 'required',
            'subdistrict_id' => 'required',
            'postal_code' => 'required',
        ], [
            'first_name.required' => __('messages.please_enter_firstname'),
            'first_name.string' => __('messages.firstname_must_be_text'),
            'first_name.max' => __('messages.firstname_must_not_exceed_255_characters'),
            'last_name.required' =>  __('messages.please_enter_lastname'),
            'last_name.string' => __('messages.lastname_must_be_text'),
            'last_name.max' => __('messages.lastname_must_not_exceed_255_characters'),
            'mobile_phone.required' => __('messages.please_enter_mobile_number'),
            'mobile_phone.regex' => __('messages.mobile_number_must_be_10_digits'),
            'email.required' => __('messages.please_enter_email'),
            'email.email' => __('messages.please_enter_valid_email'),
            'email.max' => __('messages.email_must_not_exceed_255_characters'),
            'tax_id.required' => __('messages.please_enter_tax_id'),
            'tax_id.regex' => __('messages.tax_id_must_be_10_or_13_digits'),
            'tax_id.max' => __('messages.tax_id_must_not_exceed_13_characters'),
            'postal_code.required' =>  __('messages.select_postal_code'),
            'detail.string' =>  __('messages.details_must_be_text'),
            'province_id.required' => __('messages.select_province'),
            'district_id.required' => __('messages.select_district'),
            'subdistrict_id.required' => __('messages.select_subdistrict'),
        ]);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $userId = Auth::guard('member')->user()->id;
        $status = $request->input('is_default', 0);
        if ($status == 1) {
            MemberAddressTax::where('member_id', $userId)->update(['is_default' => 0]);
        }
        MemberAddressTax::where('id', $id)->update([
            'name' => $request->input('name'),
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'mobile_phone' => $request->input('mobile_phone'),
            'email' => $request->input('email'),
            'province_id' => $request->input('province_id'),
            'district_id' => $request->input('district_id'),
            'subdistrict_id' => $request->input('subdistrict_id'),
            'tax_id' =>  $request->input('tax_id'),
            'postal_code' => $request->input('postal_code'),
            'detail' => $request->input('detail'),
            'type' => $request->input('type'),
            'is_default' => $status,
            'updated_by' => $userId
        ]);

        if (route('tax', ['lang' => app()->getLocale()]) !== $request->input('url')) {
            return redirect($request->input('url'));
        }
        return redirect()->route('tax', ['lang' => app()->getLocale()]);
    }
}
