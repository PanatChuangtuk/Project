<?php

namespace App\Http\Controllers;

use App\Http\Controllers\MainController;
use Illuminate\Support\Facades\{Hash, Auth, Validator, Storage};
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Enum\IsSourceEnum;

use App\Models\{Member, MemberInfo};

class RegisterController extends MainController
{

    function registerIndex()
    {
        if (Auth::guard('member')->check()) {
            return redirect()->route('profile');
        }
        return view('register');
    }
    public function submit(Request $request)
    {
        // dd($request->all());
        $fileName = '';
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:member',
            'password' => 'required|string|min:8|confirmed',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'imageData' => 'nullable',
            'student_id' => 'required|integer',
        ], [
            'username.required' => 'กรุณากรอกชื่อผู้ใช้',
            'username.max' => 'ชื่อผู้ใช้ต้องไม่เกิน 255 ตัวอักษร',
            'email.required' => 'กรุณากรอกอีเมล',
            'email.email' => 'กรุณากรอกอีเมลที่ถูกต้อง',
            'email.unique' => 'อีเมลนี้มีผู้ใช้งานแล้ว',
            'password.required' => 'กรุณากรอกรหัสผ่าน',
            'password.min' => 'รหัสผ่านต้องมีความยาวอย่างน้อย 8 ตัวอักษร',
            'password.confirmed' => 'รหัสผ่านไม่ตรงกัน',
            'first_name.required' => 'กรุณากรอกชื่อจริง',
            'last_name.required' => 'กรุณากรอกนามสกุล',
            'student_id.required' => 'กรุณาเลือกรหัสนักศึกษา',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput($request->except('password', 'password_confirmation'));
        }


        $user = Member::create([
            'username' => $request->username,
            'role' => 'user',
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'mobile_phone' => $request->mobile_phone,
            'status' => 0,
            'created_at' => Carbon::now(),
            'created_by' => Auth::check() ? Auth::user()->id : null
        ]);

        if ($request->has('imageData')) {
            $imageData = $request->input('imageData');
            $imageData = str_replace('data:image/png;base64,', '', $imageData);
            $imageData = base64_decode($imageData);
            $fileName = 'captured_' . time() . '.png';
            Storage::disk('public')->put('images/' . $fileName, $imageData);
        }

        MemberInfo::create([
            'member_id' => $user->id,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'student_id' => $request->student_id,
            'adviser_id' => 1,
            'avatar' => $fileName,
        ]);
        return redirect()->route('login');
    }
}
