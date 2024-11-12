<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Member;
use Illuminate\Support\Facades\Hash;

class LoginController extends MainController
{
    public function loginIndex()
    {
        if (Auth::guard('member')->check()) {
            return redirect()->route('profile', ['lang' => app()->getLocale()]);
        }
        return view('login');
    }

    public function submit(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'email_or_phone' => 'required|string',
            'password' => 'required|string|min:8',
        ], [
            'email_or_phone.required' =>  __('messages.email_or_phone_field_required'),
            'password.required' =>  __('messages.password_field_required'),
        ]);


        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $emailOrPhone = $request->input('email_or_phone');
        $password = $request->input('password');

        $user = Member::where('email', $emailOrPhone)
            ->orWhere('mobile_phone', $emailOrPhone)->first();

        if ($user) {
            if (Hash::check($password, $user->password)) {
                Auth::guard('member')->login($user);
                return redirect()->route('profile', ['lang' => app()->getLocale()])->with('success');
            } else {
                return redirect()->back()->withErrors(['password' => __('messages.invalid_password')])->withInput();
            }
        }
        return redirect()->back()->withErrors(['email_or_phone' => __('messages.user_not_found')])->withInput();
    }
}
