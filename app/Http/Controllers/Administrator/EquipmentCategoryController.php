<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\{Auth, DB, Validator, Hash};
use Illuminate\Http\Request;
use App\Models\{EquipmentCategory, EquipmentType};
use App\Http\Requests\{EquipmentCategoryUpdateRequest, EquipmentCategoryCreateRequest};

class EquipmentCategoryController extends Controller
{
    private $main_menu = 'equipment';

    public function index(Request $request)
    {
        $query = $request->input('query');

        $userQuery = EquipmentCategory::query();

        if ($query) {
            $userQuery->where(function ($queryBuilder) use ($query) {
                $queryBuilder->where('name', 'LIKE', "%{$query}%");
            });
        }

        $users = $userQuery->paginate(10)->appends([
            'query' => $query,
        ]);
        $main_menu = $this->main_menu;
        return view('administrator.category_equipment.index', compact('main_menu', 'users', 'query'));
    }

    public function add()
    {
        $main_menu = $this->main_menu;
        return view('administrator.category_equipment.add', compact('main_menu'));
    }

    public function edit($id)
    {
        $main_menu = $this->main_menu;
        $category_equipment = EquipmentCategory::find($id);
        return view('administrator.category_equipment.edit', compact('category_equipment', 'main_menu'));
    }

    public function submit(EquipmentCategoryCreateRequest $request)
    {
        // dd($request->all());
        EquipmentCategory::create([
            'name' => $request->name,
            'status' =>  $request->input('status', 0),
            'created_at' => now(),
        ]);

        return redirect()->back()
            ->with('success', 'ข้อมูลถูกบันทึกเรียบร้อยแล้ว');
    }

    public function update(EquipmentCategoryUpdateRequest $request, $id)
    {
        EquipmentCategory::find($id)->update([
            'name' => $request->name,
            'status' =>  $request->input('status', 0),
            'updated_at' => now(),
        ]);

        return redirect()->back()
            ->with('success', 'ข้อมูลถูกอัปเดตเรียบร้อยแล้ว');
    }

    public function destroy($id, Request $request)
    {
        $about = EquipmentCategory::findOrFail($id);
        $about->delete();

        $currentPage = $request->query('page', 1);

        return redirect()->route('administrator.category-equipment', ['page' => $currentPage])->with([
            'success' => 'ข้อมูลถูกลบเรียบร้อยแล้ว!',
            'id' => $id
        ]);
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->input('ids');

        if (is_array($ids) && count($ids) > 0) {
            EquipmentCategory::whereIn('id', $ids)->delete();

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
