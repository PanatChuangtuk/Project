<?php

namespace App\Http\Controllers;

use App\Http\Controllers\MainController;
use App\Models\ThaiTambon;
use App\Models\ThaiProvince;
use App\Models\ThaiGeographies;
use App\Models\ThaiAmphure;
use App\Models\Member;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\MemberAddress;
use Illuminate\Support\Facades\Validator;

class AddressController extends MainController
{
    public function address()
    {
        $userId = Auth::guard('member')->user()->id;

        $address = MemberAddress::select('member_address.*')
            ->where('member_address.member_id', $userId)
            ->get();

        return view('addresses', compact('address'));
    }
    public function edit($lang, $id)
    {
        $provinces = DB::table('provinces')->select('id', 'name_th', 'name_en')->get();
        $districts = DB::table('amphures')->select('id', 'name_th', 'name_en', 'province_id')->get();
        $subdistricts = DB::table('tambons')
            ->select('id', 'zip_code', 'name_th', 'name_en', 'amphure_id')
            ->get();

        $address = MemberAddress::find($id);
        return view('cart-address-detail', compact('address', 'provinces', 'districts', 'subdistricts'));
    }

    public function cartAddress()
    {
        $userId = Auth::guard('member')->user()->id;

        $profile = Member::join('member_infomation', 'member_infomation.member_id', '=', 'member.id')
            ->select('member.*', 'member_infomation.*')
            ->where('member.id', $userId)
            ->first();

        $provinces = DB::table('provinces')->select('id', 'name_th', 'name_en')->get();
        $districts = DB::table('amphures')->select('id', 'name_th', 'name_en', 'province_id')->get();
        $subdistricts = DB::table('tambons')
            ->select('id', 'zip_code', 'name_th', 'name_en', 'amphure_id')
            ->get();


        return view('cart-address', compact('profile', 'provinces', 'districts', 'subdistricts'));
    }

    public function submit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'mobile_phone' => 'required|regex:/^[0-9]{10}$/',
            'email' => 'required|email|max:255',
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

        $status = $request->input('is_default', 0);
        $userId = Auth::guard('member')->user()->id;
        if ($status == 1) {
            MemberAddress::where('member_id', $userId)->update(['is_default' => 0]);
        }

        MemberAddress::create([
            'member_id' => $userId,
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'mobile_phone' => $request->input('mobile_phone'),
            'email' => $request->input('email'),
            'province_id' => $request->input('province_id'),
            'district_id' => $request->input('district_id'),
            'subdistrict_id' => $request->input('subdistrict_id'),
            'postal_code' => $request->input('postal_code'),
            'detail' => $request->input('detail'),
            'is_default' => $status,
            'created_by' => $userId
        ]);
        return redirect()->route('profile.address', ['lang' => app()->getLocale()]);
    }

    public function update(Request $request, $lang, $id)
    {

        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'mobile_phone' => 'required|regex:/^[0-9]{10}$/',
            'email' => 'required|email|max:255',
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
        $status = $request->input('is_default', 0);
        $userId = Auth::guard('member')->user()->id;
        if ($status == 1) {
            MemberAddress::where('member_id', $userId)->update(['is_default' => 0]);
        }
        MemberAddress::where('id', $id)->update([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'mobile_phone' => $request->input('mobile_phone'),
            'email' => $request->input('email'),
            'province_id' => $request->input('province_id'),
            'district_id' => $request->input('district_id'),
            'subdistrict_id' => $request->input('subdistrict_id'),
            'postal_code' => $request->input('postal_code'),
            'detail' => $request->input('detail'),
            'is_default' =>  $status,
            'updated_by' => $userId
        ]);
        return redirect()->route('profile.address', ['lang' => app()->getLocale()]);
    }
}
