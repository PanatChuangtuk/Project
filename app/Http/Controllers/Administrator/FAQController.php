<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use App\Models\Language;
use App\Models\Service;
use App\Models\ServiceContent;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class FAQController extends Controller
{
    public function index()
    {
        return view('administrator.FAQ.index');
    }

    public function add()
    {
        $language = Language::get();
        return view('administrator.FAQ.add', compact('language'));
    }

    public function edit($id)
    {
        $languages = Language::all();
        $service = Service::find($id);
        $serviceContent = ServiceContent::where('service_id', $service->id)->get()->keyBy('language_id');

        return view('administrator.FAQ.edit', compact('service', 'serviceContent', 'languages'));
    }

    public function submit(Request $request)
    {
        $languages = Language::all();
        $nameArray = $request->input('name');
        $descriptionArray = $request->input('description');
        $createdAt = Carbon::now();
        $createdBy = Auth::user()->id;

        $imageName = null;
        if ($request->hasFile('image')) {
            $imageName = $request->file('image');
            $imageNames = substr(Str::uuid(), 0, 5) . '.' . $imageName->getClientOriginalExtension();
            $imageName->storeAs('file/service', $imageNames, 'public');
            $imageName = asset($imageNames);
        }

        $about = Service::create([
            'name' => $nameArray[1],
            'image' => $imageName,
            'created_at' => $createdAt,
            'created_by' => $createdBy
        ]);

        foreach ($languages as $language) {
            ServiceContent::create([
                'service_id' => $about->id,
                'language_id' => $language->id,
                'name' => $nameArray[$language->id] ?? null,
                'description' => $descriptionArray[$language->id] ?? null,
            ]);
        }

        return redirect('/administrator/service/add');
    }

    public function update(Request $request, $id)
    {
        $languages = Language::all();
        $nameArray = $request->input('name');
        $descriptionArray = $request->input('description');
        $updatedBy = Auth::user()->id;
        $service = Service::find($id);

        $imageName = $service->image;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = substr(Str::uuid(), 0, 5) . '.' . $file->getClientOriginalExtension();
            $file->storeAs('file/service', $filename, 'public');
            $url = asset($filename);

            if (isset($service) && $service->image !== $url) {
                $oldImagePath = str_replace(asset('public'), 'file/service/', $service->image);
                $relativeUrl = ltrim(str_replace(url(''), '', $oldImagePath), '/');
                Storage::disk('public')->delete('file/service/' . $relativeUrl);
                
                $service->update([
                    'name' => $nameArray[1],
                    'image' => $url,
                    'updated_at' => now(),
                    'updated_by' => $updatedBy
                ]);
            }
        } else {
            $service->update([
                'name' => $nameArray[1],
                'image' => $imageName,
                'updated_at' => now(),
                'updated_by' => $updatedBy
            ]);
        }

        foreach ($languages as $language) {
            $serviceContent = ServiceContent::where('service_id', $service->id)
                ->where('language_id', $language->id)
                ->first();

            if ($serviceContent) {
                $serviceContent->update([
                    'name' => $nameArray[$language->id] ?? null,
                    'description' => $descriptionArray[$language->id] ?? null,
                ]);
            } else {
                ServiceContent::create([
                    'service_id' => $service->id,
                    'language_id' => $language->id,
                    'name' => $nameArray[$language->id] ?? null,
                    'description' => $descriptionArray[$language->id] ?? null,
                ]);
            }
        }

        return redirect('/administrator/service/add');
    }

    public function deleteImage($id)
    {
        $service = Service::find($id);

        if ($service) {
            $oldImagePath = str_replace(asset('public'), 'file/service/', $service->image);
            $relativeUrl = ltrim(str_replace(url(''), '', $oldImagePath), '/');

            if (Storage::disk('public')->exists('file/service/' . $relativeUrl)) {
                Storage::disk('public')->delete('file/service/' . $relativeUrl);
            }

            $service->update([
                'image' => null,
                'updated_at' => now(),
                'updated_by' => Auth::user()->id
            ]);

            return response()->json(['success' => 'Image deleted successfully']);
        }
    }
}
