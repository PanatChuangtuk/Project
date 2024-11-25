<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{About, Brand, Common, Language, Testimonial};

class AboutController extends MainController
{
    function aboutIndex()
    {
        $locale = app()->getLocale();
        $language = Language::where('code', $locale)->first();
        $brand = Brand::select('brand.*')->where('status', true)->get();
        $about = About::select(
            'about.*',
            'about_content.about_id',
            'about_content.language_id',
            'about_content.name as content_name',
            'about_content.description',
            'about_content.content'
        )
            ->join('about_content', 'about_content.about_id', '=', 'about.id')->where('status', true)->where('about.type', 'block')
            ->orderBy('about_content.about_id')
            ->where('about_content.language_id', $language->id)
            ->get();
        $aboutContent = About::select(
            'about.*',
            'about_content.*',
            'about_content.name as content_name',
        )
            ->where('about.id', 1)->where('about.type', 'content')
            ->join('about_content', 'about_content.about_id', '=', 'about.id')
            ->where('about_content.language_id', $language->id)
            ->first();
        $service = Common::select(
            'common.*',
            'common_content.*',
            'common_content.name as content_name',
        )
            ->where('type', 'service')
            ->join('common_content', 'common_content.common_id', '=', 'common.id')
            ->where('common_content.language_id', $language->id)->first();
        $testimonial = Testimonial::select(
            'testimonial.*',
            'testimonial_content.*',
            'testimonial_content.name as content_name',
        )
            ->where('status', true)
            ->join('testimonial_content', 'testimonial_content.testimonial_id', '=', 'testimonial.id')
            ->where('testimonial_content.language_id', $language->id)->get();
        return view('about', compact('aboutContent', 'brand', 'about', 'service', 'testimonial'));
    }
}
