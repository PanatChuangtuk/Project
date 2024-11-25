<?php

namespace App\Http\Controllers;

use App\Http\Controllers\MainController;

class TrackTraceController extends MainController
{
    public function trackTraceIndex()
    {
        return view('track-trace');
    }
}
