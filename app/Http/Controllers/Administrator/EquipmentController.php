<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\{Auth, DB, Validator, Hash};
use Illuminate\Http\Request;
use App\Models\{EquipmentItem, Equipment};

class EquipmentController extends Controller
{
    private $main_menu = 'equipment';

    public function index(Request $request)
    {
        $query = $request->input('query');

        $userQuery = Equipment::query();

        if ($query) {
            $userQuery->where(function ($queryBuilder) use ($query) {
                $queryBuilder->where('name', 'LIKE', "%{$query}%");
            });
        }

        $users = $userQuery->paginate(10)->appends([
            'query' => $query,
        ]);
        $main_menu = $this->main_menu;
        return view('administrator.equipment.index', compact('main_menu', 'users', 'query'));
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
            'created_at' => now(),
        ]);

        return redirect()->back()
            ->with('success', 'ข้อมูลถูกบันทึกเรียบร้อยแล้ว');
    }

    public function destroy($id, Request $request)
    {
        $about = Equipment::findOrFail($id);
        $about->forceDelete();

        $currentPage = $request->query('page', 1);

        return redirect()->route('administrator.equipment', ['page' => $currentPage])->with([
            'success' => 'ข้อมูลถูกลบเรียบร้อยแล้ว!',
            'id' => $id
        ]);
    }
    public function update(Request $request, $id)
    {
        // ค้นหา Equipment ที่ต้องการอัปเดต
        $equipment = Equipment::findOrFail($id);

        $equipment->update([
            'item_id' => $request->item_id ?? $equipment->item_id,
            'equipment_number' => $request->equipment_number,
            'number' => $equipment->number,
            'status' => $request->input('status', 0),
            'updated_at' => now(),
        ]);

        return redirect()->back()
            ->with('success', 'ข้อมูลอุปกรณ์ถูกอัปเดตเรียบร้อยแล้ว');
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->input('ids');

        if (is_array($ids) && count($ids) > 0) {
            Equipment::whereIn('id', $ids)->forceDelete();

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
}
