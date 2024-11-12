<?php

namespace App\Http\Controllers;


use App\Models\News;
use App\Models\Language;

class NewsController extends MainController
{
    function newsIndex()
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
            ->paginate(9);

        return view('news', compact('news'));
    }
    function newsDetail($lang, $slug)
    {
        $language = Language::where('code', $lang,)->first();

        $newsContent = News::select(
            'news.*',
            'news_content.*',
            'news_content.id as news_content.content_id ',
            'news_content.name as content_name',
            'news_image.image'
        )
            ->where('news.status', true)
            ->where(function ($query) use ($slug) {
                $query->where('news.slug', $slug)
                    ->orWhere('news.id', $slug);
            })
            ->join('news_content', 'news_content.news_id', '=', 'news.id')
            ->join('news_image', 'news_image.news_id', '=', 'news.id')
            ->where('news_content.language_id', $language->id)->first();
        // dd($newsContent);
        return view('news-detail', compact('newsContent'));
    }
}
