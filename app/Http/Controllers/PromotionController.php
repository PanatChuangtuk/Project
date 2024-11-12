<?php

namespace App\Http\Controllers;

use App\Models\Promotion;
use App\Models\Language;

class PromotionController extends MainController
{
    function promotionIndex()
    {

        $locale = app()->getLocale();
        $language = Language::where('code', $locale)->first();

        $promotion = Promotion::select(
            'promotion.*',
            'promotion_content.*',
            'promotion_content.id as content_id',
            'promotion_content.name as content_name'
        )
            ->where('promotion.status', true)
            ->join('promotion_content', 'promotion_content.promotion_id', '=', 'promotion.id')
            ->where('promotion_content.language_id', $language->id)
            ->paginate(9);
        return view('promotion', compact('promotion'));
    }
    function promotionDetail($lang, $id)
    {
        $language = Language::where('code', $lang)->first();
        $promotionContent =  Promotion::select(
            'promotion.*',
            'promotion_content.*',
            'promotion_content.id as content_id',
            'promotion_content.name as content_name'
        )
            ->where('promotion.status', true)
            ->where('promotion.id', $id)
            ->join('promotion_content', 'promotion_content.promotion_id', '=', 'promotion.id')
            ->where('promotion_content.language_id', $language->id)
            ->first();

        return view('promotion-detail', compact('promotionContent'));
    }
}
