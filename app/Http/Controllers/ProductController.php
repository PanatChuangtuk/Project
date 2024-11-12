<?php

namespace App\Http\Controllers;

use App\Http\Controllers\MainController;
use App\Models\News;
use App\Models\Language;
use App\Models\ProductModel;
use App\Models\ProductCategory;
use App\Models\ProductType;
use App\Models\ProductInformation;
use App\Models\ProductPrice;
use Illuminate\Http\Request;

class ProductController extends MainController
{
    public function productIndex()
    {
        $locale = app()->getLocale();

        $language = Language::where('code', $locale)->first();

        $news = News::select(
            'news.*',
            'news_content.*',
            'news_content.id as news_content.content_id ',
            'news_content.name as content_name',
            'news_image.image'
        )
            ->where('news.status', true)
            ->join('news_content', 'news_content.news_id', '=', 'news.id')
            ->where('news_content.language_id', $language->id)
            ->join('news_image', 'news_image.news_id', '=', 'news.id')
            ->paginate(10);
        $product_type = ProductType::get();
        // dd($product_type);
        $product_category = ProductCategory::whereIn('product_type_id', $product_type->pluck('id'))->get();
        // dd($product_category);
        $product_model = ProductModel::whereIn('product_type_id', $product_type->pluck('id'))->get();

        return view('product', compact('news', 'product_type', 'product_category', 'product_model'));
    }
    public function productDetail($lang, $id)
    {
        $product = ProductModel::with('products.productPrices')->find($id);
        $product_list = ProductPrice::with('product')
            ->where('member_group_id', 1)
            ->where('product_id', $id)
            ->get();
        $product_info = ProductInformation::with('productAttribute')
            ->where('product_model_id', $product->id)
            ->get();
        return view('product-detail', compact('product', 'product_list', 'product_info'));
    }
    public function submit($lang, Request $request)
    {
        try {
            $cart = session()->get('cart', []);
            $ids = $request->input('id');
            $prices = $request->input('price');
            $names = $request->input('name');
            $skus = $request->input('sku');
            $sizes = $request->input('size');
            $quantities = $request->input('quantity');
            $models = $request->input('model');
            foreach ($ids as $index => $id) {
                $name = isset($names[$index]) ? $names[$index] : 0;
                $sku = isset($skus[$index]) ? $skus[$index] : 0;
                $size = isset($sizes[$index]) ? $sizes[$index] : 0;
                $model = isset($models[$index]) ? $models[$index] : 0;
                $price = isset($prices[$index]) ? $prices[$index] : 0;
                $quantity = isset($quantities[$index]) ? $quantities[$index] : 0;
                if (isset($cart[$id])) {
                    $cart[$id]['quantity'] += $quantity;
                } elseif ($quantity > 0) {
                    $cart[$id] = [
                        'name' => $name,
                        'sku' => $sku,
                        'size' => $size,
                        'model' => $model,
                        'quantity' => $quantity,
                        'price' => $price,
                    ];
                }
            }
            session()->put('cart', $cart);

            return redirect()->route('cart.index', ['lang' => app()->getLocale()]);
        } catch (\Exception $e) {

            return redirect()->back()->with('error', 'เกิดข้อผิดพลาดในการเพิ่มสินค้าไปยังรถเข็น: ' . $e->getMessage());
        }
    }
}
