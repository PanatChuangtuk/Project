<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\{Auth, Validator, Storage};
use Illuminate\Http\Request;
use App\Models\{EquipmentItem, EquipmentCategory};
use App\Http\Requests\{EquipmentCategoryUpdateRequest, EquipmentCategoryCreateRequest};

class EquipmentItemController extends Controller
{
    private $main_menu = 'equipment';

    public function index(Request $request)
    {
        $query = $request->input('query');
        $category_id = $request->input('category_id');

        $userQuery = EquipmentItem::with('category');

        if ($query) {
            $userQuery->where('name', 'LIKE', "%{$query}%");
        }

        if ($category_id) {
            $userQuery->whereHas('category', function ($queryBuilder) use ($category_id) {
                $queryBuilder->where('id', $category_id);
            });
        }

        $users = $userQuery->paginate(10)->appends([
            'query' => $query,
            'category_id' => $category_id,
        ]);

        $category = EquipmentCategory::where('status', 1)->get();
        $main_menu = $this->main_menu;

        return view('administrator.item_equipment.index', compact(
            'main_menu',
            'users',
            'query',
            'category',
            'category_id'
        ));
    }

    public function add()
    {
        $main_menu = $this->main_menu;
        return view('administrator.item_equipment.add', compact('main_menu'));
    }

    public function edit($id)
    {
        $main_menu = $this->main_menu;
        $item_equipment = EquipmentItem::find($id);
        return view('administrator.item_equipment.edit', compact('item_equipment', 'main_menu'));
    }

    public function submit(EquipmentCategoryCreateRequest $request)
    {
        $filename = null;
        if ($request->hasFile('image')) {
            $filename = $this->uploadsImage($request->file('image'), 'equipment_item');
        }
        EquipmentItem::create([
            'category_id' => $request->category_id,
            'image' => $filename,
            'name' => $request->name,
            'status' =>  $request->input('status', 0),
            'created_at' => now(),
        ]);

        return redirect()->back()
            ->with('success', 'ข้อมูลถูกบันทึกเรียบร้อยแล้ว');
    }

    public function update(EquipmentCategoryUpdateRequest $request, $id)
    {
        $item_equipment = EquipmentItem::find($id);
        $filename = null;
        if ($request->hasFile('image')) {
            $filename = $this->uploadsImage($request->file('image'), 'equipment_item');
        }
        $item_equipment->update([
            'category_id' => $request->category_id ?? $item_equipment->category_id,
            'name' => $request->name,
            'image' => $filename ?? $item_equipment->image,
            'status' =>  $request->input('status', 0),
            'updated_at' => now(),
        ]);

        return redirect()->back()
            ->with('success', 'ข้อมูลถูกอัปเดตเรียบร้อยแล้ว');
    }

    public function destroy($id, Request $request)
    {
        $about = EquipmentItem::findOrFail($id);
        $about->delete();

        $currentPage = $request->query('page', 1);

        return redirect()->route('administrator.item-equipment', ['page' => $currentPage])->with([
            'success' => 'ข้อมูลถูกลบเรียบร้อยแล้ว!',
            'id' => $id
        ]);
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->input('ids');

        if (is_array($ids) && count($ids) > 0) {
            EquipmentItem::whereIn('id', $ids)->delete();

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
        $banner = EquipmentItem::find($id);

        if ($banner) {
            $oldImagePath = str_replace(asset('public'), 'file/equipment_item/', $banner->image);

            if (Storage::disk('public')->exists('file/equipment_item/' . $oldImagePath)) {
                Storage::disk('public')->delete('file/equipment_item/' . $oldImagePath);
            }

            $banner->update([
                'image' => null,
                'updated_by' => Auth::user()->id
            ]);

            return response()->json(['success' => 'Image deleted successfully']);
        }
    }
}
