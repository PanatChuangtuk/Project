<?php

namespace App\Http\Controllers;

use App\Http\Controllers\MainController;

class ChangePasswordController extends MainController
{
    public function changePasswordIndex()
    {
        return view('change-password');
    }
}
