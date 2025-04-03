<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Banner, Language, News, ProductType, ProductBrand, ProductCategory, ProductAttribute};

class IndexController extends MainController
{
    function bannerShow()
    {
        return view('index');
    }
}
