<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class BrandController extends Controller
{
    public function index()
    {
        return view('administrator.brand.index');
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
            $file = $request->file('image');
            $filename = substr(Str::uuid(), 0, 5) . '.' . $file->getClientOriginalExtension();
            $file->storeAs('file/brand', $filename, 'public');
        }

        Brand::create([
            'name' => $name,
            'url' => $url,
            'image' => $filename,
            'status' => $status,
            'created_at' => Carbon::now(),
            'created_by' => Auth::user()->id
        ]);

        return redirect('/administrator/brand/add');
    }

    public function update(Request $request, $id)
    {
        $brand = Brand::find($id);
        $name = $request->input('name');
        $url = $request->input('url');
        $status = $request->input('status', 0);
        $filename = $brand->image;

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = substr(Str::uuid(), 0, 5) . '.' . $file->getClientOriginalExtension();
            $file->storeAs('file/brand', $filename, 'public');

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

        return redirect('/administrator/brand');
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
