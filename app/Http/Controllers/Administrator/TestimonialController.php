<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use App\Models\Language;
use App\Models\Testimonial;
use App\Models\TestimonialContent;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class TestimonialController extends Controller
{
    public function index()
    {
        return view('administrator.testimonial.index');
    }

    public function add()
    {
        $language = Language::get();
        return view('administrator.testimonial.add', compact('language'));
    }

    public function edit($id)
    {
        $languages = Language::all();
        $testimonial = Testimonial::find($id);
        $testimonialContent = TestimonialContent::where('testimonial_id', $testimonial->id)->get()->keyBy('language_id');

        return view('administrator.testimonial.edit', compact('testimonial', 'testimonialContent', 'languages'));
    }

    public function submit(Request $request)
    {
        $languages = Language::all();
        $nameArray = $request->input('name');
        $positionName = $request->input('position_name');
        $descriptionArray = $request->input('description');
        $createdAt = Carbon::now();
        $createdBy = Auth::user()->id;

        $imageName = null;
        if ($request->hasFile('image')) {
            $imageName = $request->file('image');
            $imageNames = substr(Str::uuid(), 0, 5) . '.' . $imageName->getClientOriginalExtension();
            $imageName->storeAs('file/testimonial', $imageNames, 'public');
            $imageName = asset($imageNames);
        }

        $about = Testimonial::create([
            'name' => $nameArray[1],
            'position_name' => $positionName,
            'image' => $imageName,
            'created_at' => $createdAt,
            'created_by' => $createdBy
        ]);

        foreach ($languages as $language) {
            TestimonialContent::create([
                'testimonial_id' => $about->id,
                'language_id' => $language->id,
                'name' => $nameArray[$language->id] ?? null,
                'description' => $descriptionArray[$language->id] ?? null,
            ]);
        }

        return redirect('/administrator/milestone/add');
    }

    public function update(Request $request, $id)
    {
        $languages = Language::all();
        $nameArray = $request->input('name');
        $positionName = $request->input('position_name');
        $descriptionArray = $request->input('description');
        $updatedBy = Auth::user()->id;
        $testimonial = Testimonial::find($id);

        $imageName = $testimonial->image;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = substr(Str::uuid(), 0, 5) . '.' . $file->getClientOriginalExtension();
            $file->storeAs('file/testimonial', $filename, 'public');
            $url = asset($filename);

            if (isset($testimonial) && $testimonial->image !== $url) {
                $oldImagePath = str_replace(asset('public'), 'file/testimonial/', $testimonial->image);
                $relativeUrl = ltrim(str_replace(url(''), '', $oldImagePath), '/');
                Storage::disk('public')->delete('file/testimonial/' . $relativeUrl);
                
                $testimonial->update([
                    'name' => $nameArray[1],
                    'position_name' => $positionName,
                    'image' => $url,
                    'updated_by' => $updatedBy
                ]);
            }
        } else {
            $testimonial->update([
                'name' => $nameArray[1],
                'position_name' => $positionName,
                'image' => $imageName,
                'updated_by' => $updatedBy
            ]);
        }

        foreach ($languages as $language) {
            $testimonialContent = TestimonialContent::where('testimonial_id', $testimonial->id)
                ->where('language_id', $language->id)
                ->first();

            if ($testimonialContent) {
                $testimonialContent->update([
                    'name' => $nameArray[$language->id] ?? null,
                    'description' => $descriptionArray[$language->id] ?? null,
                ]);
            } else {
                TestimonialContent::create([
                    'testimonial_id' => $testimonial->id,
                    'language_id' => $language->id,
                    'name' => $nameArray[$language->id] ?? null,
                    'description' => $descriptionArray[$language->id] ?? null,
                ]);
            }
        }

        return redirect('/administrator/milestone/add');
    }

    public function deleteImage($id)
    {
        $testimonial = Testimonial::find($id);

        if ($testimonial) {
            $oldImagePath = str_replace(asset('public'), 'file/testimonial/', $testimonial->image);
            $relativeUrl = ltrim(str_replace(url(''), '', $oldImagePath), '/');

            if (Storage::disk('public')->exists('file/testimonial/' . $relativeUrl)) {
                Storage::disk('public')->delete('file/testimonial/' . $relativeUrl);
            }

            $testimonial->update([
                'image' => null,
                'updated_by' => Auth::user()->id
            ]);

            return response()->json(['success' => 'Image deleted successfully']);
        }
    }
}
