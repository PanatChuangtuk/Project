<?php

namespace App\Http\Controllers;

use App\Http\Controllers\MainController;
use Illuminate\Support\Facades\{Hash, Auth, Validator, Storage};
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Http\Requests\{RegisterMemberRequest};
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
    public function submit(RegisterMemberRequest  $request)
    {
        dd($request->all());
        $fileName = '';
        $user = Member::create([
            'username' => $request->username,
            'role' => 'user',
            'email' => $request->email,
            'password' => Hash::make($request->password),
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
            'mobile_phone' => $request->mobile_phone,
            'avatar' => $fileName,
        ]);
        return redirect()->route('login');
    }
}
