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
        ], [
            'username.required' => __('messages.please_enter_username'),
            'username.max' => __('messages.username_must_not_exceed_255_characters'),
            'email.required' => __('messages.please_enter_email'),
            'email.email' => __('messages.please_enter_valid_email'),
            'email.unique' => __('messages.email_already_in_use'),
            'password.required' => __('messages.please_enter_password'),
            'password.min' => __('messages.password_must_be_at_least_8_characters'),
            'password.confirmed' => __('messages.passwords_do_not_match'),
            'first_name.required' => __('messages.please_enter_firstname'),
            'last_name.required' => __('messages.please_enter_lastname'),
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput($request->except('password', 'password_confirmation'));
        }


        $user = Member::create([
            'username' => $request->username,
            'student_id' => $request->student_id,
            'role' => 'user',
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'mobile_phone' => $request->student_id,
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
            'student_id' => 1,
            'adviser_id' => 1,
            'avatar' => $fileName,
            'student_number' => 's123456789'
        ]);
        return redirect()->route('login');
    }
}
