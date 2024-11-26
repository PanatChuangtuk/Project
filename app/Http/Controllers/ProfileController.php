<?php

namespace App\Http\Controllers;

use App\Http\Controllers\MainController;
use Illuminate\Support\Facades\{Auth, DB, Validator, Hash};
use Illuminate\Http\Request;
use App\Models\Member;

class ProfileController extends MainController
{
    public function profileIndex()
    {

        $userId = Auth::guard('member')->user()->id;

        $profile = Member::join('member_infomation', 'member_infomation.member_id', '=', 'member.id')
            ->select('member.*', 'member_infomation.*')
            ->where('member.id', $userId)
            ->first();
        return view('my-account', compact('profile'));
    }

    public function resetPasswordIndex()
    {
        $userId = Auth::guard('member')->user()->id;

        $userData = Member::find($userId);

        return view('set-new-password-2', compact('userData'));
    }


    public function resetPasswordSubmit(Request $request)
    {
        $user = Auth::guard('member')->user();

        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'password_old' => 'required',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'password_old.required' => 'กรุณากรอกรหัสผ่านเก่า',
            'password.required' => 'กรุณากรอกรหัสผ่านใหม่',
            'password.confirmed' => 'การยืนยันรหัสผ่านใหม่ไม่ตรงกัน',
            'password.min' => 'รหัสผ่านใหม่ต้องมีอย่างน้อย 8 ตัวอักษร',
        ]);
        // dd($validator);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput($request->except('new_password', 'password_confirmation'));
        }

        if (!Hash::check($request->password_old, $user->password)) {
            return redirect()->back()->withErrors([
                'password_old' => 'รหัสผ่านเก่าไม่ถูกต้อง',
            ]);
        }

        if (Hash::check($request->password, $user->password)) {
            return redirect()->back()->withErrors([
                'new_password' => 'รหัสผ่านใหม่ซ้ำกับรหัสผ่านเก่า กรุณาใช้รหัสผ่านอื่น',
            ]);
        }
        $user = Auth::guard('member')->user()->id;
        $userData = Member::find($user);
        // dd($userId);
        $userData->update([
            'password' => Hash::make($request->password),
        ]);
        Auth::guard('member')->logout();
        return redirect()->route('index', ['lang' => app()->getLocale()]);
    }



    public function submit(Request $request)
    {
        $userId = Auth::guard('member')->user()->id;
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:255',
            'email' => 'required|email|unique:member,email,' . $userId,
            'mobile_phone' => 'required|digits:10|unique:member,mobile_phone,' . $userId,
        ], [
            'email.email' => __('messages.invalid_email_format'),
            'email.unique' => __('messages.email_already_in_use'),
            'mobile_phone.unique' =>  __('messages.phone_exists'),
            'mobile_phone.digits' =>  __('messages.mobile_number_must_be_10_digits'),
        ]);
        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator);
        }

        DB::table('member')
            ->where('id', $userId)
            ->update([
                'username' => $request->username,
                'email' => $request->email,
                'mobile_phone' => $request->mobile_phone,
                'updated_by' => $userId
            ]);
        DB::table('member_infomation')
            ->where('member_id', $userId)
            ->update([
                'first_name' => $request->first_name ?? null,
                'last_name' => $request->last_name ?? null,
                'company' => $request->company ?? null,
                'line_id' => $request->line_id ?? null,
                'vat_register_number' => $request->vat_register_number ?? null,
                'updated_by' => $userId
            ]);
        return redirect()->route('profile', ['lang' => app()->getLocale()]);
    }

    public function logout(Request $request)
    {
        Auth::guard('member')->logout();
        $request->session()->regenerateToken();
        return redirect('/ ');
    }
}
