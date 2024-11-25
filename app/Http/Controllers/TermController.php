<?php

namespace App\Http\Controllers;

use App\Http\Controllers\MainController;

class TermController extends MainController
{
    public function termIndex()
    {
        return view('term-condition');
    }
}
