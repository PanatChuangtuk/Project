<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use App\Models\Language;


class FaqController extends MainController
{
    function faqIndex()
    {
        $locale = app()->getLocale();

        $language = Language::where('code', $locale)->first();

        $faq = Faq::select(
            'faq.*',
            'faq_content.*',
            'faq_content.id as content_id',
            'faq_content.name as content_name',
        )
            ->where('status', true)
            ->join('faq_content', 'faq_content.faq_id', '=', 'faq.id')
            ->where('faq_content.language_id', $language->id)->get();

        return view('faq', compact('faq'));
    }
}
