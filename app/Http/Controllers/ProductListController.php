<?php

namespace App\Http\Controllers;

use App\Http\Controllers\MainController;
use App\Models\{ProductModel};
use Illuminate\Http\Request;

class ProductListController extends MainController
{
    public function productListIndex(Request $request)
    {
        $type = $request->query('type');
        $id = $request->query('id');

        if ($type === 'brand') {
            $product = ProductModel::where('product_brand_id', $id)->paginate(1);
        } else {
            $product = ProductModel::where('product_category_id', $id)->paginate(1);
        }

        $product->appends($request->query());

        return view('product-list', compact('product'));
    }
}
