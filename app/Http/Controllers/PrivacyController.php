<?php

namespace App\Http\Controllers;

use App\Http\Controllers\MainController;

class PrivacyController extends MainController
{
    public function privacyIndex()
    {
        return view('privacy-policy');
    }
}
