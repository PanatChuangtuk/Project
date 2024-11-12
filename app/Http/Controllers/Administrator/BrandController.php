<?php

namespace App\Http\Controllers\Administrator;

use App\Models\Service;
use App\Models\ServiceContent;
use App\Models\Language;
use App\Http\Controllers\Controller;
use App\Models\Brand;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class BrandController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('query');
        $status = $request->input('status');

        $brandQuery = Brand::query();

        if ($query) {
            $brandQuery->where('name', 'LIKE', "%{$query}%");
        }

        if ($status) {
            $statusValue = ($status === 'active') ? 1 : 0;
            $brandQuery->where('status', $statusValue);
        }

        $brand = $brandQuery->paginate(10)->appends([
            'query' => $query,
            'status' => $status,
        ]);
        return view('administrator.brand.index', compact('brand', 'query', 'status'));
    }

    public function add()
    {

        return view('administrator.brand.add');
    }

    public function edit($id)
    {
        $brand = Brand::find($id);
        return view('administrator.brand.edit', compact('brand'));
    }

    public function submit(Request $request)
    {
        $name = $request->input('name');
        $url = $request->input('url');
        $status = $request->input('status', 0);
        $filename = null;

        if ($request->hasFile('image')) {
            $filename = $this->uploadsImage($request->file('image'), 'brand');
        }

        Brand::create([
            'name' => $name,
            'url' => $url,
            'image' => $filename,
            'status' => $status,
            'created_at' => Carbon::now(),
            'created_by' => Auth::user()->id
        ]);

        return redirect()->route('administrator.brand');
    }

    public function update(Request $request, $id)
    {
        $brand = Brand::find($id);
        $name = $request->input('name');
        $url = $request->input('url');
        $status = $request->input('status', 0);
        $filename = $brand->image;

        if ($request->hasFile('image')) {
            $filename = $this->uploadsImage($request->file('image'), 'brand');

            if ($brand->image) {
                Storage::disk('public')->delete('file/brand/' . $brand->image);
            }
        }

        $brand->update([
            'name' => $name,
            'url' => $url,
            'image' => $filename,
            'status' => $status,
            'updated_by' => Auth::user()->id,
        ]);

        return redirect()->route('administrator.brand');
    }

    public function destroy($id, Request $request)
    {
        $brand = Brand::findOrFail($id);
        $brand->delete();

        $currentPage = $request->query('page', 1);

        return redirect()->route('administrator.brand', ['page' => $currentPage])->with([
            'success' => 'Brand deleted successfully!',
            'id' => $id
        ]);
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->input('ids');

        if (is_array($ids) && count($ids) > 0) {
            Brand::whereIn('id', $ids)->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Selected brand have been deleted successfully.',
                'deleted_ids' => $ids
            ]);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'No brand selected for deletion.'
        ], 400);
    }

    public function deleteImage($id)
    {
        $brand = Brand::find($id);

        if ($brand) {
            $oldImagePath = str_replace(asset('public'), 'file/brand/', $brand->image);

            if (Storage::disk('public')->exists('file/brand/' . $oldImagePath)) {
                Storage::disk('public')->delete('file/brand/' . $oldImagePath);
            }

            $brand->update([
                'image' => null,
                'updated_by' => Auth::user()->id
            ]);

            return response()->json(['success' => 'Image deleted successfully']);
        }
    }
}
