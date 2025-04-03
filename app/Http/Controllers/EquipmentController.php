<?php

namespace App\Http\Controllers;

use App\Http\Controllers\MainController;
use Illuminate\Support\Facades\{Auth, DB, Validator, Hash};
use Illuminate\Http\Request;
use App\Models\{Member, MemberInfo};

class EquipmentController extends MainController
{
    public function index()
    {
        $userId = Auth::guard('member')->user()->id;
        // MemberInfo::create(['first_name' => 'test', 'last_name' => 'test', 'adviser_id' => 1, 'member_id' => 4]);
        $profile = Member::join('member_infomation', 'member_infomation.member_id', '=', 'member.id')
            ->select('member.*', 'member_infomation.*')
            ->where('member.id', $userId)
            ->first();
        return view('equipment', compact('profile'));
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
}
