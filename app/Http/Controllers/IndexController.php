<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Banner, Language, News, ProductType, ProductBrand, ProductCategory, ProductAttribute};

class IndexController extends MainController
{
    function bannerShow()
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
        $product_brand = ProductBrand::get();
        $product_category = ProductCategory::whereIn('product_type_id', $product_type->pluck('id'))->get();
        $product_attribute = ProductAttribute::whereIn('product_type_id', $product_type->pluck('id'))->get();


        $banner = Banner::where('status', true)->get();
        return view('index', compact('banner', 'news', 'product_type', 'product_category', 'product_attribute', 'product_brand'));
    }
}
