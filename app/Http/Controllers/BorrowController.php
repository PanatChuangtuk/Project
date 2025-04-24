<?php

namespace App\Http\Controllers;

use App\Http\Controllers\MainController;
use Illuminate\Support\Facades\{Auth, DB, Validator, Hash};
use Illuminate\Http\Request;
use App\Models\{EquipmentCategory, EquipmentItem};

class BorrowController extends MainController
{
    public function borrow(Request $request)
    {
        $cart = session()->get('cart', []);

        dd($cart);
        return view('borrow', compact('equipment'));
    }
}
