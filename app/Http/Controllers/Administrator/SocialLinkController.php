<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class SocialLinkController extends Controller
{
    public function index()
    {
        return view('administrator.social.index');
    }

    public function add()
    {
        return view('administrator.social.add');
    }

    public function edit($id)
    {
        $banner = Banner::find($id);
        return view('administrator.social.edit', compact('banner'));
    }

    public function submit(Request $request)
    {
        $name = $request->input('name');
        $url = $request->input('url');
        $status = $request->input('status', 0);
        $createdAt = Carbon::now();
        $createdBy = Auth::user()->id;
        $filename = null;

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = substr(Str::uuid(), 0, 5) . '.' . $file->getClientOriginalExtension();
            $file->storeAs('file/banner', $filename, 'public');
        }

        Banner::create([
            'name' => $name,
            'url' => $url,
            'image' => $filename,
            'status' => $status,
            'created_at' => $createdAt,
            'created_by' => $createdBy
        ]);

        return redirect('/administrator/banner/add');
    }

    public function update(Request $request, $id)
    {
        $updatedBy = Auth::user()->id;
        $banner = Banner::find($id);
        $name = $request->input('name');
        $url = $request->input('url');
        $status = $request->input('status', 0);
        $filename = $banner->image;

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = substr(Str::uuid(), 0, 5) . '.' . $file->getClientOriginalExtension();
            $file->storeAs('file/banner', $filename, 'public');

            if ($banner->image) {
                Storage::disk('public')->delete('file/banner/' . $banner->image);
            }
        }

        $banner->update([
            'name' => $name,
            'url' => $url,
            'image' => $filename,
            'status' => $status,
            'updated_at' => now(),
            'updated_by' => $updatedBy,
        ]);

        return redirect('/administrator/banner');
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
                'updated_at' => now(),
                'updated_by' => Auth::user()->id
            ]);

            return response()->json(['success' => 'Image deleted successfully']);
        }
    }
}
