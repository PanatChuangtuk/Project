<?php

namespace App\Http\Controllers;

use App\Http\Controllers\MainController;
use App\Models\Member;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProfileController extends MainController
{
    public function profileIndex()
    {
        $userId = Auth::guard('member')->user()->id;
        $profile = Member::join('member_infomation', 'member_infomation.member_id', '=', 'member.id')
            ->select('member.*', 'member_infomation.*')
            ->where('member.id', $userId)
            ->first();
        return view('my-account', compact('profile'));
    }

    public function submit(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:255',
            'email' => 'required|email',
        ], [
            'email.email' => 'รูปแบบอีเมลไม่ถูกต้อง',
        ]);

        $userId = Auth::guard('member')->user()->id;
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

    public function logout(Request $request)
    {
        Auth::guard('member')->logout();
        $request->session()->regenerateToken();

        return redirect(app()->getLocale() . '/ ');
    }
}
