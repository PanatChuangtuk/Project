<?php

namespace App\Http\Controllers\Administrator;

use App\Models\{Social, Language};
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Auth, Storage, Validator};

class SocialController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('query');
        $status = $request->input('status');

        $socialQuery = Social::query();

        if ($query) {
            $socialQuery->where('name', 'LIKE', "%{$query}%");
        }

        if ($status) {
            $statusValue = ($status === 'active') ? 1 : 0;
            $socialQuery->where('status', $statusValue);
        }

        $social = $socialQuery->paginate(10)->appends([
            'query' => $query,
            'status' => $status,
        ]);

        return view('administrator.social.index', compact('social', 'query', 'status'));
    }

    public function add()
    {
        $language = Language::get();
        return view('administrator.social.add', compact('language'));
    }

    public function edit($id)
    {
        $social = Social::find($id);
        return view('administrator.social.edit', compact('social'));
    }

    public function submit(Request $request)
    {

        $name = $request->input('name');
        $html = $request->input('html');
        $status = $request->input('status', 0);
        $createdAt = Carbon::now();
        $createdBy = Auth::user()->id;
        $filename = null;

        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ], [
            'name.required' => 'กรุณากรอกชื่อ',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }


        if ($request->hasFile('image')) {
            $filename = $this->uploadsImage($request->file('image'), 'social');
        }
        Social::create([
            'name' => $name,
            'html' => $html,
            'image' => $filename,
            'status' => $status,
            'created_at' => $createdAt,
            'created_by' => $createdBy
        ]);

        return redirect()->route('administrator.social');
    }

    public function update(Request $request, $id)
    {
        $updatedBy = Auth::user()->id;
        $social = Social::find($id);
        $name = $request->input('name');
        $html = $request->input('html');
        $status = $request->input('status', 0);
        $filename = $social->image;

        if ($request->hasFile('image')) {
            $filename = $this->uploadsImage($request->file('image'), 'social');

            if ($social->image) {
                Storage::disk('public')->delete('file/social/' . $social->image);
            }
        }

        $social->update([
            'name' => $name,
            'html' => $html,
            'image' => $filename,
            'status' => $status,
            'updated_at' => now(),
            'updated_by' => $updatedBy,
        ]);

        return redirect()->route('administrator.social');
    }

    public function destroy($id, Request $request)
    {
        $social = Social::findOrFail($id);
        $social->delete();

        $currentPage = $request->query('page', 1);

        return redirect()->route('administrator.social', ['page' => $currentPage])->with([
            'success' => 'Social deleted successfully!',
            'id' => $id
        ]);
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->input('ids');

        if (is_array($ids) && count($ids) > 0) {
            Social::whereIn('id', $ids)->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Selected social have been deleted successfully.',
                'deleted_ids' => $ids
            ]);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'No social selected for deletion.'
        ], 400);
    }

    public function deleteImage($id)
    {
        $social = Social::find($id);

        if ($social) {
            $oldImagePath = str_replace(asset('public'), 'file/social/', $social->image);

            if (Storage::disk('public')->exists('file/social/' . $oldImagePath)) {
                Storage::disk('public')->delete('file/social/' . $oldImagePath);
            }

            $social->update([
                'image' => null,
                'updated_at' => now(),
                'updated_by' => Auth::user()->id
            ]);

            return response()->json(['success' => 'Image deleted successfully']);
        }
    }
}
