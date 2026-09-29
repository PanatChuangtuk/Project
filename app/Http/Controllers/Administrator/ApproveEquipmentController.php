<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\{Hash, DB, Validator};
use App\Models\{LoanEquipment, LoanTransaction, Equipment};
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ApproveEquipmentController extends Controller
{
    private $main_menu = 'approve_equipment';
    public function index(Request $request)
    {
        $query = $request->input('query');

        $userQuery = LoanTransaction::where('status',  'in_process')
            ->orderBy('created_at')
            ->with(['member.info', 'loanEquipments.equipment']);

        if ($query) {
            $userQuery->where(function ($queryBuilder) use ($query) {
                $queryBuilder->whereHas('member.info', function ($infoQuery) use ($query) {
                    $infoQuery->where('first_name', 'LIKE', "%{$query}%")
                        ->orWhere('last_name', 'LIKE', "%{$query}%");
                })
                    ->orWhereHas('member.info.student', function ($studentQuery) use ($query) {
                        $studentQuery->where('student_number', 'LIKE', "%{$query}%");
                    });
            });
        }
        $users = $userQuery->paginate(10)->appends([
            'query' => $query,
        ]);
        $main_menu = $this->main_menu;
        return view('administrator.equipment_approve.index', compact('users', 'query', 'main_menu'));
    }
    public function edit(Request $request, $id)
    {
        $borrow = LoanTransaction::findOrFail($id);
        $main_menu = $this->main_menu;

        return view('administrator.equipment_approve.edit', compact('main_menu', 'borrow'));
    }
    public function updateApprove(Request $request)
    {
        $validated = $this->validateStatusUpdate($request);

        DB::table('loan_transactions')
            ->where('id', $validated['item'])
            ->update([
                'status' => $validated['status'],
            ]);

        return response()->json([
            'message' => 'สถานะการอนุมัติถูกอัปเดตเรียบร้อยแล้ว',
            'success' => true
        ]);
    }
    public function approveEquipment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'item_id' => 'required|array|min:1',
            'item_id.*' => ['required', 'integer', 'distinct', Rule::exists('loan_equipment', 'id')->whereNull('deleted_at')],
            'equipments_id' => 'required|array|size:' . count((array) $request->input('item_id', [])),
            // อุปกรณ์ 1 ชิ้นให้ยืมได้แค่ 1 รายการ
            'equipments_id.*' => 'required|integer|distinct|exists:equipment,id',
        ], [
            'item_id.required' => 'ไม่พบรายการอุปกรณ์ที่ต้องการอนุมัติ',
            'item_id.*.exists' => 'ไม่พบรายการอุปกรณ์ที่ต้องการอนุมัติ',
            'equipments_id.required' => 'กรุณาเลือกหมายเลขอุปกรณ์',
            'equipments_id.size' => 'กรุณาเลือกหมายเลขอุปกรณ์ให้ครบทุกรายการ',
            'equipments_id.*.required' => 'กรุณาเลือกหมายเลขอุปกรณ์ให้ครบทุกรายการ',
            'equipments_id.*.distinct' => 'ห้ามเลือกหมายเลขอุปกรณ์ซ้ำกัน',
            'equipments_id.*.exists' => 'ไม่พบหมายเลขอุปกรณ์ที่เลือก',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors()->first());
        }

        $itemIds = array_values($request->input('item_id'));
        $equipmentIds = array_values($request->input('equipments_id'));

        // ตรวจซ้ำฝั่ง server ให้ตรงกับที่ /api/get-equipment กรองไว้ (ตรงประเภท และไม่ถูกยืมอยู่)
        $loanEquipments = LoanEquipment::whereIn('id', $itemIds)->get()->keyBy('id');
        // withTrashed: ตอนอนุมัติการคืน อุปกรณ์เดิมอาจถูกลบไปแล้ว
        $equipments = Equipment::withTrashed()->whereIn('id', $equipmentIds)->get()->keyBy('id');
        foreach ($itemIds as $index => $itemId) {
            if ($equipments[$equipmentIds[$index]]->item_id != $loanEquipments[$itemId]->equipment_item_id) {
                return redirect()->back()->with('error', 'หมายเลขอุปกรณ์ไม่ตรงกับประเภทอุปกรณ์ที่ยืม');
            }
        }

        $inUse = LoanEquipment::whereIn('equipment_id', $equipmentIds)
            ->whereNotIn('id', $itemIds)
            ->whereHas('loanTransaction', function ($query) {
                $query->whereIn('status_type', ['borrowed', 'overdue'])
                    ->whereIn('status', ['in_process', 'completed']);
            })
            ->exists();
        if ($inUse) {
            return redirect()->back()->with('error', 'มีหมายเลขอุปกรณ์ที่ถูกยืมอยู่แล้ว กรุณาเลือกใหม่');
        }

        DB::transaction(function () use ($itemIds, $equipmentIds) {
            foreach ($itemIds as $index => $itemId) {
                $loanEquipment = LoanEquipment::with('loanTransaction')->findOrFail($itemId);
                if ($loanEquipment->loanTransaction?->status == 'in_process') {
                    $loanEquipment->loanTransaction->update([
                        'status' => 'completed',
                    ]);
                }
                $loanEquipment->update([
                    'equipment_id' => $equipmentIds[$index],
                ]);
            }
        });

        return redirect()->back()->with('success', 'อนุมัติการยืมสำเร็จ');
    }

    private function validateStatusUpdate(Request $request): array
    {
        return $request->validate([
            'item' => 'required|integer|exists:loan_transactions,id',
            'status' => 'required|in:in_process,completed,cancel',
        ]);
    }
}
