<?php

namespace App\Http\Controllers;

use App\Http\Controllers\MainController;
use Illuminate\Support\Facades\{Auth, DB, Validator, Hash};
use Illuminate\Http\Request;
use App\Models\{Member, MemberInfo};

class ProfileController extends MainController
{
    public function profileIndex()
    {
        $userId = Auth::guard('member')->user()->id;
        // MemberInfo::create(['first_name' => 'test', 'last_name' => 'test', 'adviser_id' => 1, 'member_id' => 4]);
        $profile = Member::join('member_infomation', 'member_infomation.member_id', '=', 'member.id')
            ->select('member.*', 'member_infomation.*')
            ->where('member.id', $userId)
            ->first();
        return view('my-account', compact('profile'));
    }

    public function submit(Request $request)
    {

        $userId = Auth::guard('member')->user()->id;
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:255',
            'email' => 'required|email|unique:member,email,' . $userId,
            // 'mobile_phone' => 'required|digits:10|unique:member_infomation,mobile_phone,' . $userId,
        ], [
            'email.email' => __('messages.invalid_email_format'),
            'email.unique' => __('messages.email_already_in_use'),
            // 'mobile_phone.unique' =>  __('messages.phone_exists'),
            // 'mobile_phone.digits' =>  __('messages.mobile_number_must_be_10_digits'),
        ]);
        // if ($validator->fails()) {
        //     return redirect()
        //         ->back()
        //         ->withErrors($validator);
        // }
        // dd($request->all());
        DB::table('member')
            ->where('id', $userId);

        DB::table('member_infomation')
            ->where('member_id', $userId)
            ->update([
                'first_name' => $request->first_name ?? null,
                'last_name' => $request->last_name ?? null,
                'mobile_phone' => $request->mobile_phone,

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
