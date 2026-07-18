<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Auth, Storage, Validator, Hash};
use App\Models\{Student, Adviser};
use App\Http\Requests\{AdviserCreateRequest, AdviserUpdateRequest};

class AdviserController extends Controller
{
    private $main_menu = 'admin';
    private $titles = [
        'ศาสตราจารย์',
        'รองศาสตราจารย์',
        'ผู้ช่วยศาสตราจารย์',
        'ดร.',
        'ผศ.',
        'รศ.',
        'อ.',
        'นพ.',
        'น.สพ.',
        'น.ส.',
        'นาย',
        'นางสาว',
        'นาง',
    ];
    public function index(Request $request)
    {
        $query = $request->input('query');

        $adviserQuery = Adviser::query();

        if ($query) {
            $adviserQuery->where('first_name', 'LIKE', "%{$query}%")
                ->orWhere('last_name', 'LIKE', "%{$query}%");
        }

        $adviser = $adviserQuery->paginate(10)->appends([
            'query' => $query,
        ]);
        $main_menu = $this->main_menu;
        return view('administrator.adviser.index', compact('adviser', 'query', 'main_menu'));
    }
    public function add()
    {
        $main_menu = $this->main_menu;
        $titles = $this->titles;
        return view('administrator.adviser.add', compact('main_menu', 'titles'));
    }

    public function edit($id)
    {
        $main_menu = $this->main_menu;
        $adviser = Adviser::find($id);
        $titles = $this->titles;
        return view('administrator.adviser.edit', compact('adviser', 'main_menu', 'titles'));
    }

    public function submit(AdviserCreateRequest $request)
    {
        // dd($request->all());
        $filename = null;
        if ($request->hasFile('image')) {
            $filename = $this->uploadsImage($request->file('image'), 'adviser');
        }
        Adviser::create([
            'titles_name' => $request->titles_name,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'status' =>  $request->input('status', 0),
            'avatar' => $filename,
            'created_at' => now(),
        ]);

        return redirect()->back()
            ->with('success', 'ข้อมูลถูกบันทึกเรียบร้อยแล้ว');
    }

    public function update(AdviserUpdateRequest $request, $id)
    {
        // dd($request->all());
        $filename = null;
        if ($request->hasFile('image')) {
            $filename = $this->uploadsImage($request->file('image'), 'adviser');
        }
        $adviser = Adviser::find($id);
        $adviser->update([
            'titles_name' => $request->titles_name,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'avatar' => $filename ?? $adviser->avatar,
            'status' => $request->input('status', 0),
            'updated_at' => now(),
        ]);
        return redirect()->back()
            ->with('success', 'ข้อมูลถูกอัพเดตเรียบร้อยแล้ว');
    }
    public function destroy($id, Request $request)
    {
        $about = Adviser::findOrFail($id);
        $about->delete();

        $currentPage = $request->query('page', 1);

        return redirect()->route('administrator.adviser', ['page' => $currentPage])->with([
            'success' => 'ข้อมูลถูกลบเรียบร้อยแล้ว!',
            'id' => $id
        ]);
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->input('ids');

        if (is_array($ids) && count($ids) > 0) {
            Adviser::whereIn('id', $ids)->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'ข้อมูลที่เลือกถูกลบเรียบร้อยแล้ว',
                'deleted_ids' => $ids
            ]);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'ไม่ได้เลือกข้อมูลที่จะลบ'
        ], 400);
    }
    public function deleteImage($id)
    {
        $banner = Adviser::find($id);

        if ($banner) {
            $oldImagePath = str_replace(asset('public'), 'file/adviser/', $banner->image);

            if (Storage::disk('public')->exists('file/qr_code/' . $oldImagePath)) {
                Storage::disk('public')->delete('file/qr_code/' . $oldImagePath);
            }

            $banner->update([
                'avatar' => null,
                'updated_by' => Auth::user()->id
            ]);

            return response()->json(['success' => 'Image deleted successfully']);
        }
    }
}
