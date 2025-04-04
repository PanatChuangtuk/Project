<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // public function login()
    // {
    //     return view('administrator.auth.login');
    // }

    // public function loginPost(Request $request)
    // {
    //     $credetials = [
    //         'email' => $request->email,
    //         'password' => $request->password,
    //     ];

    //     if (Auth::guard('web')->attempt($credetials)) {
    //         return redirect('/administrator/dashboard')->with('success', 'Login berhasil');
    //     }
    //     return back()->with('error', 'Email or Password salah');
    // }

    public function logout()
    {
        Auth::guard('web')->logout();
        return redirect()->route('login');
    }
}
