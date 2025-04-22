<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\{Auth, Storage, Validator, Hash};
use Illuminate\Http\Request;
use App\Models\{EquipmentItem, Equipment};

class EquipmentController extends Controller
{
    private $main_menu = 'equipment';

    public function index(Request $request)
    {
        $query = $request->input('query');
        $statuses = $request->input('status', []);
        $categories = $request->input('category', []);

        $userQuery = Equipment::query();

        if ($query) {
            $userQuery->where(function ($q) use ($query) {
                $q->where('number', 'LIKE', "%{$query}%");
            });
        }

        if (!empty($statuses)) {
            $userQuery->whereIn('status', $statuses);
        }

        if (!empty($categories)) {
            $userQuery->whereIn('item_id', $categories);
        }

        $users = $userQuery->paginate(10)->appends($request->all());
        $main_menu = $this->main_menu;
        $allCategories = EquipmentItem::pluck('name', 'id');

        return view('administrator.equipment.index', compact('main_menu', 'users', 'query', 'statuses', 'categories', 'allCategories'));
    }

    public function add()
    {
        $main_menu = $this->main_menu;
        return view('administrator.equipment.add', compact('main_menu'));
    }

    public function edit($id)
    {
        $main_menu = $this->main_menu;
        $equipment = Equipment::find($id);
        return view('administrator.equipment.edit', compact('equipment', 'main_menu'));
    }

    public function submit(Request $request)
    {
        // dd($request->all());
        $filename = null;
        if ($request->hasFile('image')) {
            $filename = $this->uploadsImage($request->file('image'), 'qr_code');
        }

        $item = EquipmentItem::findOrFail($request->item_id);
        $categoryId = $item->category_id;
        $itemsInCategory = EquipmentItem::where('category_id', $categoryId)
            ->orderBy('id')
            ->pluck('id')
            ->toArray();

        $itemIndex = array_search($item->id, $itemsInCategory) + 1;
        $count = Equipment::where('item_id', $item->id)->count();
        $running = str_pad($count + 1, 3, '0', STR_PAD_LEFT);
        $equipmentNumber = $categoryId . $itemIndex . $running;
        Equipment::create([
            'item_id' => $request->item_id,
            'equipment_number' => $request->equipment_number ?? null,
            'number' => $equipmentNumber ?? null,
            'status' =>  $request->input('status', 0),
            'image' => $filename,
            'created_at' => now(),
        ]);

        return redirect()->back()
            ->with('success', 'ข้อมูลถูกบันทึกเรียบร้อยแล้ว');
    }
    public function update(Request $request, $id)
    {
        $filename = null;
        if ($request->hasFile('image')) {
            $filename = $this->uploadsImage($request->file('image'), 'qr_code');
        }
        $equipment = Equipment::findOrFail($id);
        $equipment->update([
            'item_id' => $request->item_id ?? $equipment->item_id,
            'equipment_number' => $request->equipment_number,
            'number' => $equipment->number,
            'image' => $filename ?? $equipment->image,
            'status' => $request->input('status', 0),
            'updated_at' => now(),
        ]);

        return redirect()->back()
            ->with('success', 'ข้อมูลอุปกรณ์ถูกอัปเดตเรียบร้อยแล้ว');
    }

    public function destroy($id, Request $request)
    {
        $about = Equipment::findOrFail($id);
        $about->delete();

        $currentPage = $request->query('page', 1);

        return redirect()->route('administrator.equipment', ['page' => $currentPage])->with([
            'success' => 'ข้อมูลถูกลบเรียบร้อยแล้ว!',
            'id' => $id
        ]);
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->input('ids');

        if (is_array($ids) && count($ids) > 0) {
            Equipment::whereIn('id', $ids)->delete();

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
        $banner = Equipment::find($id);

        if ($banner) {
            $oldImagePath = str_replace(asset('public'), 'file/qr_code/', $banner->image);

            if (Storage::disk('public')->exists('file/qr_code/' . $oldImagePath)) {
                Storage::disk('public')->delete('file/qr_code/' . $oldImagePath);
            }

            $banner->update([
                'image' => null,
                'updated_by' => Auth::user()->id
            ]);

            return response()->json(['success' => 'Image deleted successfully']);
        }
    }
}
