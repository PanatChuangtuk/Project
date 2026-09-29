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
        $profile = Member::find($userId);

        return view('my-account', compact('profile'));
    }

    public function submit(Request $request)
    {

        $userId = Auth::guard('member')->user()->id;
        // อีเมลเป็น readonly ในฟอร์ม จึงตรวจเฉพาะฟิลด์ที่แก้ไขได้ (ไม่รับค่า email จากฟอร์ม)
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'mobile_phone' => 'nullable|digits_between:9,10',
        ], [
            'first_name.required' => 'กรุณากรอกชื่อ',
            'first_name.max' => 'ชื่อต้องไม่เกิน 255 ตัวอักษร',
            'last_name.required' => 'กรุณากรอกนามสกุล',
            'last_name.max' => 'นามสกุลต้องไม่เกิน 255 ตัวอักษร',
            'mobile_phone.digits_between' => 'เบอร์โทรศัพท์ต้องเป็นตัวเลข 9-10 หลัก',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

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
