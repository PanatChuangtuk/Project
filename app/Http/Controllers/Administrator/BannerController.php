<?php

namespace App\Http\Controllers\Administrator;

use App\Models\Service;
use App\Models\ServiceContent;
use App\Models\Language;
use App\Http\Controllers\Controller;
use App\Models\Banner;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('query');

        $status = $request->input('status');

        $bannerQuery = Banner::query();

        if ($query) {
            $bannerQuery->where('name', 'LIKE', "%{$query}%");
        }

        if ($status) {
            $statusValue = ($status === 'active') ? 1 : 0;
            $bannerQuery->where('status', $statusValue);
        }

        $banner = $bannerQuery->paginate(10)->appends([
            'query' => $query,
            'status' => $status,
        ]);
        return view('administrator.banner.index', compact('banner', 'query', 'status'));
    }

    public function add()
    {
        return view('administrator.banner.add');
    }

    public function edit($id)
    {
        $banner = Banner::find($id);
        return view('administrator.banner.edit', compact('banner'));
    }

    public function submit(Request $request)
    {
        $name = $request->input('name');
        $url = $request->input('url');
        $status = $request->input('status', 0);
        $filename = null;

        if ($request->hasFile('image')) {
            $filename = $this->uploadsImage($request->file('image'), 'banner');
        }

        Banner::create([
            'name' => $name,
            'url' => $url,
            'image' => $filename,
            'status' => $status,
            'created_at' => Carbon::now(),
            'created_by' => Auth::user()->id
        ]);

        return redirect()->route('administrator.banner');
    }

    public function update(Request $request, $id)
    {
        $banner = Banner::find($id);
        $name = $request->input('name');
        $url = $request->input('url');
        $status = $request->input('status', 0);
        $filename = $banner->image;

        if ($request->hasFile('image')) {
            $filename = $this->uploadsImage($request->file('image'), 'banner');

            if ($banner->image) {
                Storage::disk('public')->delete('file/banner/' . $banner->image);
            }
        }

        $banner->update([
            'name' => $name,
            'url' => $url,
            'image' => $filename,
            'status' => $status,
            'updated_by' => Auth::user()->id,
        ]);

        return redirect()->route('administrator.banner');
    }

    public function destroy($id, Request $request)
    {
        $banner = Banner::findOrFail($id);
        $banner->delete();

        $currentPage = $request->query('page', 1);

        return redirect()->route('administrator.banner', ['page' => $currentPage])->with([
            'success' => 'Banner deleted successfully!',
            'id' => $id
        ]);
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->input('ids');

        if (is_array($ids) && count($ids) > 0) {
            Banner::whereIn('id', $ids)->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Selected banner have been deleted successfully.',
                'deleted_ids' => $ids
            ]);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'No banner selected for deletion.'
        ], 400);
    }

    public function deleteImage($id)
    {
        $banner = Banner::find($id);

        if ($banner) {
            $oldImagePath = str_replace(asset('public'), 'file/banner/', $banner->image);

            if (Storage::disk('public')->exists('file/banner/' . $oldImagePath)) {
                Storage::disk('public')->delete('file/banner/' . $oldImagePath);
            }

            $banner->update([
                'image' => null,
                'updated_by' => Auth::user()->id
            ]);

            return response()->json(['success' => 'Image deleted successfully']);
        }
    }
}
