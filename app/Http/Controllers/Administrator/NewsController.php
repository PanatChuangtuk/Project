<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use App\Models\Language;
use App\Models\NewsContent;
use App\Models\News;
use App\Models\NewsImage;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class NewsController extends Controller
{
    public function index()
    {
        return view('administrator.news.index');
    }

    public function add()
    {
        $language = Language::get();
        return view('administrator.news.add', compact('language'));
    }

    public function edit($id)
    {
        $languages = Language::all();
        $news = News::find($id);
        $newsContents = NewsContent::where('news_id', $news->id)->get()->keyBy('language_id');
        $newsImage = NewsImage::where('news_id', $news->id)->first();

        return view('administrator.news.edit', compact('news', 'newsContents', 'newsImage', 'languages'));
    }

    public function submit(Request $request)
    {
        $languages = Language::all();
        $nameArray = $request->input('name');
        $contentArray = $request->input('content');
        $descriptionArray = $request->input('description');
        $slug = $request->input('slug');
        $status = $request->input('status', 0);

        $news = News::create([
            'name' => $nameArray[1],
            'slug' => $slug,
            'status' => $status,
            'created_at' => Carbon::now(),
            'created_by' =>  Auth::user()->id
        ]);

        foreach ($languages as $language) {
            $newData = [
                'news_id' => $news->id,
                'language_id' => $language->id,
                'name' => $nameArray[$language->id] ?? null,
                'content' => $contentArray[$language->id] ?? null,
                'description' => $descriptionArray[$language->id] ?? null,
            ];
            NewsContent::create($newData);
        }

        $filename = null;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filenames = substr(Str::uuid(), 0, 5) . '.' . $file->getClientOriginalExtension();
            $file->storeAs('file/news', $filenames, 'public');
            $filename = asset($filenames);
        }
        
        NewsImage::create([
            'news_id' => $news->id,
            'language_id' => $language->id,
            'image' => $filename,
            'sort' => 1
        ]);

        return redirect('/administrator/news/add');
    }

    public function update(Request $request, $id)
    {
        $languages = Language::all();
        $nameArray = $request->input('name');
        $contentArray = $request->input('content');
        $descriptionArray = $request->input('description');
        $slug = $request->input('slug');
        $status = $request->input('status', 0);
        $news = News::find($id);

        $news->update([
            'name' => $nameArray[1],
            'slug' => $slug,
            'status' => $status,
            'updated_by' =>  Auth::user()->id
        ]);

        foreach ($languages as $language) {
            $name = $nameArray[$language->id] ?? null;
            $description = $descriptionArray[$language->id] ?? null;
            $content = $contentArray[$language->id] ?? null;

            $newsContent = NewsContent::where('news_id', $news->id)
                ->where('language_id', $language->id)
                ->first();

            if ($newsContent) {
                $newsContent->update([
                    'name' => $name,
                    'description' => $description,
                    'content' => $content,
                ]);
            } else {
                NewsContent::create([
                    'news_id' => $news->id,
                    'language_id' => $language->id,
                    'name' => $name,
                    'description' => $description,
                    'content' => $content,
                ]);
            }
        }

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = substr(Str::uuid(), 0, 5) . '.' . $file->getClientOriginalExtension();
            $file->storeAs('file/news', $filename, 'public');
            $url = asset($filename);
            $newsImage = NewsImage::where('news_id', $news->id)
                ->where('language_id', $languages->first()->id)
                ->first();

            if (isset($newsImage) && $newsImage->image !== $url) {
                $oldImagePath = str_replace(asset('public'), 'file/news/', $newsImage->image);
                $relativeUrl = ltrim(str_replace(url(''), '', $oldImagePath), '/');
                Storage::disk('public')->delete('file/news/' . $relativeUrl);
                $newsImage->update([
                    'image' => $url,
                    'sort' => 1
                ]);
            } else {
                NewsImage::create([
                    'news_id' => $news->id,
                    'language_id' => $languages->first()->id,
                    'image' => $url,
                    'sort' => 1
                ]);
            }
        }

        return redirect('/administrator/news');
    }

    public function deleteImage($id)
    {
        $news = News::find($id);
        $newsImage = NewsImage::where('news_id', $news->id)->first();

        if ($newsImage) {
            $oldImagePath = str_replace(asset('public'), 'file/news/', $newsImage->image);
            $relativeUrl = ltrim(str_replace(url(''), '', $oldImagePath), '/');

            if (Storage::disk('public')->exists('file/news/' . $relativeUrl)) {
                Storage::disk('public')->delete('file/news/' . $relativeUrl);
            }

            $news->update([ 'updated_by' => Auth::user()->id]);
            $newsImage->delete();

            return response()->json(['success' => 'Image deleted successfully']);
        }
    }
}
