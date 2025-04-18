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

    // public function dataForgotPassword()
    // {
    //     if (Auth::guard('member')->check()) {
    //         return redirect()->route('profile');
    //     } else if (Auth::guard('web')->check()) {
    //         return redirect()->route('administrator.dashboard')->with('success', __('messages.login_success'));
    //     }

    //     return view('otp-forgot-password-login');
    // }


    // public function dataForgotPasswordSubmit(Request $request)
    // {
    //     if (Auth::guard('member')->check()) {
    //         return redirect()->route('profile');
    //     }
    //     $validator = Validator::make($request->all(), [
    //         'email_or_phone' => 'required|string',

    //     ], [
    //         'email_or_phone.required' =>  __('messages.email_or_phone_field_required'),

    //     ]);
    //     if ($validator->fails()) {
    //         return redirect()->back()->withErrors($validator)->withInput();
    //     }

    //     $userData = Member::where('email', $request->email_or_phone)
    //         ->orWhere('mobile_phone', $request->email_or_phone)
    //         ->first();

    //     if (!$userData) {
    //         return response()->json([
    //             'status' => 'error',
    //         ], 404);
    //     }

    //     $payload = [
    //         'email' => $request->email_or_phone,
    //         'iat' => time(),
    //         'exp' => time() + 300,
    //     ];

    //     $token = JWT::encode($payload, env('JWT_SECRET'), 'HS256');
    //     session(['reset_token' => $token]);
    //     return response()->json([
    //         'status' => 'success',
    //     ], 200);
    // }

    // public function otpForgotPassword(Request $request)
    // {

    //     return view('otp-forgot-password');
    // }


    // public function otpForgotPasswordSubmit(Request $request)
    // {

    //     return redirect()->route('login.reset.password', [
    //         'lang' => app()->getLocale(),
    //     ]);
    // }

    // public function resetPasswordIndex($lang, Request $request)
    // {
    //     if (Auth::guard('member')->check()) {
    //         return redirect()->route('profile');
    //     }
    //     return view('set-new-password');
    // }

    // public function resetPasswordSubmit($lang, Request $request)
    // {
    //     $token = JWT::decode(session('reset_token'), new Key(env('JWT_SECRET'), 'HS256'));

    //     $userData = Member::where('email', $token->email)
    //         ->orWhere('mobile_phone', $token->email)
    //         ->first();

    //     $validator = Validator::make($request->all(), [
    //         'password' => 'required|string|min:8|confirmed',
    //     ], [
    //         'password.required' => __('messages.password_field_required'),
    //         'password.confirmed' => __('messages.passwords_do_not_match'),
    //         'password.min' => __('messages.password_must_be_at_least_8_characters'),
    //     ]);

    //     if ($validator->fails()) {
    //         return redirect()->back()
    //             ->withErrors($validator)
    //             ->withInput($request->except('new_password', 'password_confirmation'));
    //     }

    //     $userData->update([
    //         'is_source' => IsSourceEnum::Register->value,
    //         'password' => Hash::make($request->password),
    //     ]);
    //     session()->forget('reset_token');

    //     return redirect()->route('login');
    // }

    public function submit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email_or_phone' => 'required|string',
            'password' => 'required|string|min:8',
        ], [
            'email_or_phone.required' => 'กรุณากรอกอีเมล',
            'password.required' => 'กรุณากรอกรหัสผ่าน',
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
            return redirect()->route('profile')->with('success', 'เข้าสู่ระบบสำเร็จ');
        } elseif ($user->role === 'admin') {
            Auth::guard('web')->login($user);
            return redirect()->route('administrator.dashboard')->with('success', 'เข้าสู่ระบบสำเร็จ');
        }
    }
}
