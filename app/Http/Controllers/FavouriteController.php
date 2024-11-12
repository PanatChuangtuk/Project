<?php

namespace App\Http\Controllers;

use App\Http\Controllers\MainController;
use App\Models\Member;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\MemberAddressTax;
use Illuminate\Support\Facades\Validator;

class FavouriteController extends MainController
{
    public function favouriteIndex()
    {
        return view('my-favourite');
    }
}
