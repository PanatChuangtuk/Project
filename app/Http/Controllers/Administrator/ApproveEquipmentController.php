<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\{DB, Validator};
use App\Models\{EqmHistoryMaster, EqmHistoryDetail, Equipment};
use Illuminate\Http\Request;

class ApproveEquipmentController extends Controller
{
    private $main_menu = 'approve_equipment';
    public function index(Request $request)
    {
        $query = $request->input('query');

        $userQuery = EqmHistoryMaster::whereIn('status', EqmHistoryMaster::WAITING_STATUSES)
            ->orderBy('created_at')
            ->with(['member.info']);

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
        $borrow = EqmHistoryMaster::with(['details.equipmentItem', 'details.equipment', 'histories.admin.info', 'histories.member.info', 'histories.detail', 'histories.equipment'])
            ->findOrFail($id);
        $main_menu = $this->main_menu;

        return view('administrator.equipment_approve.edit', compact('main_menu', 'borrow'));
    }

    /**
     * ปุ่มยกเลิก: คำขอยืม => ยกเลิกใบยืม, คำร้องคืน => ปฏิเสธการคืน (ของยังอยู่กับผู้ยืม)
     */
    public function updateApprove(Request $request)
    {
        $validated = $request->validate([
            'item' => 'required|integer|exists:eqm_history_master,id',
            'status' => 'required|in:cancel',
        ]);

        $master = EqmHistoryMaster::findOrFail($validated['item']);

        if ($master->status === 'pending') {
            DB::transaction(function () use ($master) {
                $master->update(['status' => 'cancelled']);
                $master->logEvent('cancel');
            });
            $message = 'ยกเลิกคำขอยืมเรียบร้อยแล้ว';
        } elseif ($master->status === 'return_pending') {
            DB::transaction(function () use ($master) {
                $status = $master->borrowingStatus();
                $master->update([
                    'status' => $status,
                    'returned_at' => null,
                    'is_overdue' => $master->is_overdue || $status === 'overdue',
                ]);
                $master->logEvent('reject_return');
            });
            $message = 'ปฏิเสธการคืนแล้ว รายการกลับเป็นกำลังยืม';
        } else {
            return response()->json([
                'message' => 'รายการนี้ไม่ได้อยู่ระหว่างรอดำเนินการ',
                'success' => false,
            ], 422);
        }

        return response()->json([
            'message' => $message,
            'success' => true
        ]);
    }

    /**
     * ปุ่มยืนยัน: คำขอยืม => อนุมัติพร้อมระบุเลขอุปกรณ์, คำร้องคืน => ตรวจรับคืนพร้อมระบุสภาพ
     */
    public function approveEquipment(Request $request)
    {
        $master = EqmHistoryMaster::with('details')->find($request->input('master_id'));
        if (!$master || !in_array($master->status, EqmHistoryMaster::WAITING_STATUSES, true)) {
            return redirect()->back()->with('error', 'รายการนี้ไม่ได้อยู่ระหว่างรอดำเนินการ');
        }

        $details = $master->details->keyBy('id');
        $itemIds = array_map('intval', array_values((array) $request->input('item_id', [])));
        sort($itemIds);
        if ($itemIds !== $details->keys()->sort()->values()->all()) {
            return redirect()->back()->with('error', 'ข้อมูลรายการอุปกรณ์ไม่ตรงกับใบยืม กรุณาโหลดหน้าใหม่');
        }

        return $master->status === 'pending'
            ? $this->approveBorrow($request, $master, $details)
            : $this->approveReturn($request, $master, $details);
    }

    private function approveBorrow(Request $request, EqmHistoryMaster $master, $details)
    {
        $validator = Validator::make($request->all(), [
            'equipments_id' => 'required|array|size:' . $details->count(),
            // อุปกรณ์ 1 ชิ้นให้ยืมได้แค่ 1 รายการ
            'equipments_id.*' => 'required|integer|distinct|exists:equipment,id',
        ], [
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

        // ตรวจซ้ำฝั่ง server ให้ตรงกับที่ /api/get-equipment กรองไว้ (ตรงประเภท เปิดใช้งาน และไม่ถูกยืมอยู่)
        $equipments = Equipment::whereIn('id', $equipmentIds)->get()->keyBy('id');
        foreach ($itemIds as $index => $itemId) {
            $equipment = $equipments->get($equipmentIds[$index]);
            if (!$equipment || $equipment->item_id != $details[$itemId]->equipment_item_id) {
                return redirect()->back()->with('error', 'หมายเลขอุปกรณ์ไม่ตรงกับประเภทอุปกรณ์ที่ยืม');
            }
            if (!$equipment->status) {
                return redirect()->back()->with('error', 'อุปกรณ์หมายเลข ' . $equipment->number . ' ถูกปิดใช้งาน');
            }
        }

        $inUse = EqmHistoryDetail::active()
            ->whereIn('equipment_id', $equipmentIds)
            ->where('master_id', '!=', $master->id)
            ->exists();
        if ($inUse) {
            return redirect()->back()->with('error', 'มีหมายเลขอุปกรณ์ที่ถูกยืมอยู่แล้ว กรุณาเลือกใหม่');
        }

        DB::transaction(function () use ($master, $details, $itemIds, $equipmentIds) {
            foreach ($itemIds as $index => $itemId) {
                $detail = $details[$itemId];
                $detail->update(['equipment_id' => $equipmentIds[$index]]);
                $master->logEvent('approve_borrow', $detail);
            }
            $master->update(['status' => 'borrowed']);
        });

        return redirect()->back()->with('success', 'อนุมัติการยืมสำเร็จ');
    }

    private function approveReturn(Request $request, EqmHistoryMaster $master, $details)
    {
        $itemIds = array_values($request->input('item_id'));
        $conditions = array_values((array) $request->input('conditions', []));
        $conditionNotes = array_values((array) $request->input('condition_notes', []));

        // ตอนตรวจรับคืน ต้องระบุสภาพอุปกรณ์ทุกชิ้น
        foreach ($itemIds as $index => $itemId) {
            if (!array_key_exists($conditions[$index] ?? '', EqmHistoryDetail::CONDITIONS)) {
                return redirect()->back()->with('error', 'กรุณาระบุสภาพอุปกรณ์ให้ครบทุกรายการ');
            }
        }

        DB::transaction(function () use ($master, $details, $itemIds, $conditions, $conditionNotes) {
            foreach ($itemIds as $index => $itemId) {
                $detail = $details[$itemId];
                $condition = $conditions[$index];
                $note = mb_substr(trim((string) ($conditionNotes[$index] ?? '')), 0, 255) ?: null;

                $detail->update([
                    'condition' => $condition,
                    'condition_note' => $note,
                ]);
                $master->logEvent('approve_return', $detail, [
                    'condition' => $condition,
                    'note' => $note,
                ]);

                // ชิ้นที่ชำรุด/สูญหาย ปิดใช้งานไว้ ไม่ให้ถูกนับในสต็อกหรือถูกเลือกให้ยืม จนกว่าแอดมินจะเปิดใหม่
                if ($condition !== 'normal' && $detail->equipment_id) {
                    Equipment::withTrashed()->whereKey($detail->equipment_id)->update(['status' => 0]);
                }
            }
            $master->update([
                'status' => 'returned',
                'is_overdue' => $master->is_overdue || $master->returned_at?->greaterThan($master->due_at),
            ]);
        });

        return redirect()->back()->with('success', 'ตรวจรับคืนอุปกรณ์สำเร็จ');
    }
}
