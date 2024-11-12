<?php

namespace App\Http\Controllers;

use App\Http\Controllers\MainController;
use App\Models\Language;
use Illuminate\Http\Request;
use App\Models\ProductModel;


class ProductListController extends MainController
{
    public function productListIndex()
    {
        $product = ProductModel::select()->paginate(10);
        return view('product-list', compact('product'));
    }
}
