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

class PromotionController extends Controller
{
    public function index()
    {
        return view('administrator.promotion.index');
    }

    public function add()
    {
        $language = Language::get();
        return view('administrator.promotion.add', compact('language'));
    }

    public function edit($id)
    {
        $languages = Language::all();
        $promotion = News::find($id);
        $promotionContents = NewsContent::where('promotion_id', $promotion->id)->get()->keyBy('language_id');
        $promotionImage = NewsImage::where('promotion_id', $promotion->id)->first();

        return view('administrator.promotion.edit', compact('promotion', 'promotionContents', 'promotionImage', 'languages'));
    }

    public function submit(Request $request)
    {
        $languages = Language::all();
        $nameArray = $request->input('name');
        $contentArray = $request->input('content');
        $descriptionArray = $request->input('description');
        $slug = $request->input('slug');
        $status = $request->input('status', 0);
        $createdAt = Carbon::now();
        $createdBy = Auth::user()->id;

        $promotion = News::create([
            'name' => $nameArray[1],
            'slug' => $slug,
            'status' => $status,
            'created_at' => $createdAt,
            'created_by' => $createdBy
        ]);

        foreach ($languages as $language) {
            $newData = [
                'promotion_id' => $promotion->id,
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
            $file->storeAs('file/promotion', $filenames, 'public');
            $filename = asset($filenames);
        }
        
        NewsImage::create([
            'promotion_id' => $promotion->id,
            'language_id' => $language->id,
            'image' => $filename,
            'sort' => 1
        ]);

        return redirect('/administrator/promotion/add');
    }

    public function update(Request $request, $id)
    {
        $languages = Language::all();
        $nameArray = $request->input('name');
        $contentArray = $request->input('content');
        $descriptionArray = $request->input('description');
        $slug = $request->input('slug');
        $status = $request->input('status', 0);
        $updatedBy = Auth::user()->id;
        $promotion = News::find($id);

        $promotion->update([
            'name' => $nameArray[1],
            'slug' => $slug,
            'status' => $status,
            'updated_at' => now(),
            'update_by' => $updatedBy
        ]);

        foreach ($languages as $language) {
            $name = $nameArray[$language->id] ?? null;
            $description = $descriptionArray[$language->id] ?? null;
            $content = $contentArray[$language->id] ?? null;

            $promotionContent = NewsContent::where('promotion_id', $promotion->id)
                ->where('language_id', $language->id)
                ->first();

            if ($promotionContent) {
                $promotionContent->update([
                    'name' => $name,
                    'description' => $description,
                    'content' => $content,
                ]);
            } else {
                NewsContent::create([
                    'promotion_id' => $promotion->id,
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
            $file->storeAs('file/promotion', $filename, 'public');
            $url = asset($filename);
            $promotionImage = NewsImage::where('promotion_id', $promotion->id)
                ->where('language_id', $languages->first()->id)
                ->first();

            if (isset($promotionImage) && $promotionImage->image !== $url) {
                $oldImagePath = str_replace(asset('public'), 'file/promotion/', $promotionImage->image);
                $relativeUrl = ltrim(str_replace(url(''), '', $oldImagePath), '/');
                Storage::disk('public')->delete('file/promotion/' . $relativeUrl);
                $promotionImage->update([
                    'image' => $url,
                    'sort' => 1
                ]);
            } else {
                NewsImage::create([
                    'promotion_id' => $promotion->id,
                    'language_id' => $languages->first()->id,
                    'image' => $url,
                    'sort' => 1
                ]);
            }
        }

        return redirect('/administrator/promotion');
    }

    public function deleteImage($id)
    {
        $promotion = News::find($id);
        $promotionImage = NewsImage::where('promotion_id', $promotion->id)->first();

        if ($promotionImage) {
            $oldImagePath = str_replace(asset('public'), 'file/promotion/', $promotionImage->image);
            $relativeUrl = ltrim(str_replace(url(''), '', $oldImagePath), '/');

            if (Storage::disk('public')->exists('file/promotion/' . $relativeUrl)) {
                Storage::disk('public')->delete('file/promotion/' . $relativeUrl);
            }

            $promotion->update(['updated_at' => now(), 'updated_by' => Auth::user()->id]);
            $promotionImage->delete();

            return response()->json(['success' => 'Image deleted successfully']);
        }
    }
}
