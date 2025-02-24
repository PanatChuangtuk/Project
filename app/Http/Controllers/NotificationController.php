<?php

namespace App\Http\Controllers;

use App\Http\Controllers\MainController;

class MemberController extends Controller
{
    public function studentDashboard()
    {
        return view('student.dashboard');
    }
}
