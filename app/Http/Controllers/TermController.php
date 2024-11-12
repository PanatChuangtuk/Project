<?php

namespace App\Http\Controllers;

use App\Http\Controllers\MainController;

class TermController extends MainController
{
    public function termIndex()
    {
        return view('term-condition');
    }
    // public function edit($lang, $id) {}

    // public function add() {}

    // public function submit(Request $request) {}

    // public function update(Request $request, $lang, $id) {}
}
