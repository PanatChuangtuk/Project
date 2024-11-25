<?php

namespace App\Http\Controllers;

use App\Http\Controllers\MainController;

class FavouriteController extends MainController
{
    public function favouriteIndex()
    {
        return view('my-favourite');
    }
}
