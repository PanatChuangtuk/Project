<?php

namespace App\Http\Controllers;

use App\Enum\IsSourceEnum;
use Illuminate\Support\Facades\{Auth, Validator, Hash};
use Illuminate\Http\Request;
use App\Models\Member;
use Firebase\JWT\{JWT, Key};

class LoginController extends MainController
{
    public function loginIndex()
    {
        if (Auth::guard('member')->check()) {
            return redirect()->route('profile');
        } else if (Auth::guard('web')->check()) {
            return redirect()->route('administrator.dashboard')->with('success', __('messages.login_success'));
        }
        return view('login');
    }

    public function submit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email_or_phone' => 'required|string',
            'password' => 'required|string|min:8',
        ], [
            'email_or_phone.required' => 'กรุณากรอกอีเมล',
            'password.required' => 'กรุณากรอกรหัสผ่าน',
            'password.min' => 'รหัสผ่านต้องมีความยาวอย่างน้อย 8 ตัวอักษร',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $emailOrPhone = $request->input('email_or_phone');
        $password = $request->input('password');

        $user = Member::where('email', $emailOrPhone)
            ->where('status', '1')
            // ->orWhere('student_id', $emailOrPhone)
            ->first();


        if (!$user) {
            return redirect()->back()->withErrors(['email_or_phone' => 'ไม่พบบัญชีผู้ใช้ (หากสมัครแล้วกรุณาติดต่อเจ้าหน้าที่)'])->withInput();
        }

        if (!Hash::check($password, $user->password)) {
            return redirect()->back()->withErrors(['password' => 'รหัสผ่านไม่ถูกต้อง'])->withInput();
        }

        if ($user->role === 'user') {
            Auth::guard('member')->login($user);
            return redirect()->route('equipment')->with('success', 'เข้าสู่ระบบสำเร็จ');
        } elseif ($user->role === 'admin') {
            Auth::guard('web')->login($user);
            return redirect()->route('administrator.dashboard')->with('success', 'เข้าสู่ระบบสำเร็จ');
        }
    }
}
