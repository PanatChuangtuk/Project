<?php

namespace App\Http\Controllers;

use App\Http\Controllers\MainController;

class TrackTraceController extends MainController
{
    public function trackTraceIndex()
    {
        return view('track-trace');
    }
    // public function edit($lang, $id) {}

    // public function add() {}

    // public function submit(Request $request) {}

    // public function update(Request $request, $lang, $id) {}
}
