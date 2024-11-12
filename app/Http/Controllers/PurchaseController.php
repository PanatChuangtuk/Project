<?php

namespace App\Http\Controllers;

use App\Http\Controllers\MainController;
use App\Models\Member;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\MemberAddressTax;
use Illuminate\Support\Facades\Validator;

class PurchaseController extends MainController
{
    public function purchaseIndex()
    {
        return view('my-purchase');
    }
    // public function edit($lang, $id) {}

    // public function add() {}

    // public function submit(Request $request) {}

    // public function update(Request $request, $lang, $id) {}
}
