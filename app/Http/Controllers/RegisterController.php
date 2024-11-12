<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\Member;
use App\Http\Controllers\MainController;
use Carbon\Carbon;
use App\Models\MemberInfo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;

class RegisterController extends MainController
{

    function registerIndex()
    {
        if (Auth::guard('member')->check()) {
            return redirect()->route('profile', ['lang' => app()->getLocale()]);
        }
        return view('register');
    }
    public function submit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:member',
            'password' => 'required|string|min:8|confirmed',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'mobile_phone' => 'nullable|string|max:20',
            'company' => 'nullable|string|max:255',
            'line_id' => 'nullable|string|max:50',
            'vat_register_number' => 'nullable|string|max:13',
            'account_type' => 'required|in:government,private',
            'newsletter' => 'nullable|boolean',
            'g-recaptcha-response' => 'required',
        ], [
            'username.required' =>  __('messages.please_enter_username'),
            'username.max' =>  __('messages.username_must_not_exceed_255_characters'),
            'email.required' => __('messages.please_enter_email'),
            'email.email' => __('messages.please_enter_valid_email'),
            'email.unique' => __('messages.email_already_in_use'),
            'password.required' =>  __('messages.please_enter_password'),
            'password.min' =>  __('messages.password_must_be_at_least_8_characters'),
            'password.confirmed' => __('messages.passwords_do_not_match'),
            'first_name.required' =>  __('messages.please_enter_firstname'),
            'last_name.required' => __('messages.please_enter_lastname'),
            'account_type.required' => __('messages.please_select_account_type'),
            'account_type.in' => __('messages.invalid_account_type_selected'),
            'vat_register_number.max' => __('messages.tax_id_must_not_exceed_13_digits'),
            'g-recaptcha-response.required' => __('messages.captcha_is_required'),
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput($request->except('password', 'password_confirmation'));
        }

        $verificationResponse = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => config('app.nocaptcha.secret'),
            'response' => $request->input('g-recaptcha-response'),
            'remoteip' => $request->ip(),
        ]);
        $result = $verificationResponse->json();

        if (!$result['success']) {
            return redirect()->back()->withErrors(['g-recaptcha-response' => __('messages.recaptcha_verification_failed_en')]);
        }

        $user = Member::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'mobile_phone' => $request->mobile_phone,
            'created_at' => Carbon::now(),
            'created_by' => Auth::check() ? Auth::user()->id : null
        ]);
        MemberInfo::create([
            'member_id' => $user->id,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'company' => $request->company,
            'line_id' => $request->line_id,
            'vat_register_number' => $request->vat_register_number,
            'account_type' => $request->account_type,
            'newsletter' => $request->newsletter,
        ]);
        return redirect()->route('login', ['lang' => app()->getLocale()]);
    }
}
