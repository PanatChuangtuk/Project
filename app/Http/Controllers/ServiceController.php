<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\About;
use App\Models\Brand;
use App\Models\Common;
use App\Models\Language;
use App\Models\Testimonial;

class ServiceController extends MainController
{
    function serviceIndex()
    {
        $locale = app()->getLocale();

        $language = Language::where('code', $locale)->first();

        $service = Common::select(
            'common.*',
            'common_content.*',
            'common_content.name as content_name',
        )
            ->where('type', 'service')
            ->join('common_content', 'common_content.common_id', '=', 'common.id')
            ->where('common_content.language_id', $language->id)->first();

        return view('service', compact('service'));
    }
}
