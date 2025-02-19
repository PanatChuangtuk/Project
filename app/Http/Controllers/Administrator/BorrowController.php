<?php

namespace App\Http\Controllers\Administrator;

use App\Models\About;
use App\Http\Controllers\Controller;
use App\Models\Language;
use App\Models\Service;
use App\Models\ServiceContent;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class BorrowController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('query');
        $status = $request->input('status');

        $aboutQuery = About::with('content');

        if ($query) {
            $aboutQuery->where('name', 'LIKE', "%{$query}%");
        }

        if ($status) {
            $statusValue = ($status === 'active') ? 1 : 0;
            $aboutQuery->where('status', $statusValue);
        }

        $about = $aboutQuery->paginate(10)->appends([
            'query' => $query,
            'status' => $status,
        ]);

        return view('administrator.about.index', compact('about', 'query', 'status'));
    }

    // public function add()
    // {
    //     $language = Language::get();
    //     return view('administrator.about.add', compact('language'));
    // }

    // public function edit($id)
    // {
    //     $languages = Language::all();
    //     $service = Service::find($id);
    //     $serviceContent = ServiceContent::where('service_id', $service->id)->get()->keyBy('language_id');

    //     return view('administrator.about.edit', compact('service', 'serviceContent', 'languages'));
    // }

    // public function submit(Request $request)
    // {
    //     $languages = Language::all();
    //     $nameArray = $request->input('name');
    //     $descriptionArray = $request->input('description');
    //     $createdAt = Carbon::now();
    //     $createdBy = Auth::user()->id;

    //     $imageName = null;
    //     if ($request->hasFile('image')) {
    //         $imageName = $request->file('image');
    //         $imageNames = substr(Str::uuid(), 0, 5) . '.' . $imageName->getClientOriginalExtension();
    //         $imageName->storeAs('file/service', $imageNames, 'public');
    //         $imageName = asset($imageNames);
    //     }

    //     $about = Service::create([
    //         'name' => $nameArray[1],
    //         'image' => $imageName,
    //         'created_at' => $createdAt,
    //         'created_by' => $createdBy
    //     ]);

    //     foreach ($languages as $language) {
    //         ServiceContent::create([
    //             'service_id' => $about->id,
    //             'language_id' => $language->id,
    //             'name' => $nameArray[$language->id] ?? null,
    //             'description' => $descriptionArray[$language->id] ?? null,
    //         ]);
    //     }

    //     return redirect('/administrator/service/add');
    // }

    // public function update(Request $request, $id)
    // {
    //     $languages = Language::all();
    //     $nameArray = $request->input('name');
    //     $descriptionArray = $request->input('description');
    //     $updatedBy = Auth::user()->id;
    //     $service = Service::find($id);

    //     $imageName = $service->image;
    //     if ($request->hasFile('image')) {
    //         $file = $request->file('image');
    //         $filename = substr(Str::uuid(), 0, 5) . '.' . $file->getClientOriginalExtension();
    //         $file->storeAs('file/service', $filename, 'public');
    //         $url = asset($filename);

    //         if (isset($service) && $service->image !== $url) {
    //             $oldImagePath = str_replace(asset('public'), 'file/service/', $service->image);
    //             $relativeUrl = ltrim(str_replace(url(''), '', $oldImagePath), '/');
    //             Storage::disk('public')->delete('file/service/' . $relativeUrl);

    //             $service->update([
    //                 'name' => $nameArray[1],
    //                 'image' => $url,
    //                 'updated_at' => now(),
    //                 'updated_by' => $updatedBy
    //             ]);
    //         }
    //     } else {
    //         $service->update([
    //             'name' => $nameArray[1],
    //             'image' => $imageName,
    //             'updated_at' => now(),
    //             'updated_by' => $updatedBy
    //         ]);
    //     }

    //     foreach ($languages as $language) {
    //         $serviceContent = ServiceContent::where('service_id', $service->id)
    //             ->where('language_id', $language->id)
    //             ->first();

    //         if ($serviceContent) {
    //             $serviceContent->update([
    //                 'name' => $nameArray[$language->id] ?? null,
    //                 'description' => $descriptionArray[$language->id] ?? null,
    //             ]);
    //         } else {
    //             ServiceContent::create([
    //                 'service_id' => $service->id,
    //                 'language_id' => $language->id,
    //                 'name' => $nameArray[$language->id] ?? null,
    //                 'description' => $descriptionArray[$language->id] ?? null,
    //             ]);
    //         }
    //     }

    //     return redirect('/administrator/service/add');
    // }

    // public function destroy($id, Request $request)
    // {
    //     $about = About::findOrFail($id);
    //     $about->delete();

    //     $currentPage = $request->query('page', 1);

    //     return redirect()->route('administrator.about', ['page' => $currentPage])->with([
    //         'success' => 'About deleted successfully!',
    //         'id' => $id
    //     ]);
    // }

    // public function bulkDelete(Request $request)
    // {
    //     $ids = $request->input('ids');

    //     if (is_array($ids) && count($ids) > 0) {
    //         About::whereIn('id', $ids)->delete();

    //         return response()->json([
    //             'status' => 'success',
    //             'message' => 'Selected about have been deleted successfully.',
    //             'deleted_ids' => $ids
    //         ]);
    //     }

    //     return response()->json([
    //         'status' => 'error',
    //         'message' => 'No about selected for deletion.'
    //     ], 400);
    // }

    // public function deleteImage($id)
    // {
    //     $service = Service::find($id);

    //     if ($service) {
    //         $oldImagePath = str_replace(asset('public'), 'file/service/', $service->image);
    //         $relativeUrl = ltrim(str_replace(url(''), '', $oldImagePath), '/');

    //         if (Storage::disk('public')->exists('file/service/' . $relativeUrl)) {
    //             Storage::disk('public')->delete('file/service/' . $relativeUrl);
    //         }

    //         $service->update([
    //             'image' => null,
    //             'updated_at' => now(),
    //             'updated_by' => Auth::user()->id
    //         ]);

    //         return response()->json(['success' => 'Image deleted successfully']);
    //     }
    // }
}
