<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Banner;


class IndexController extends MainController
{
    function bannerShow()
    {
        $banner = Banner::where('status', true)->get();
        return view('index', compact('banner'));
    }
}
