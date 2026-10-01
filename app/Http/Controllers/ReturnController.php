<?php

namespace App\Http\Controllers;

use App\Http\Controllers\MainController;
use Illuminate\Support\Facades\{Auth, DB};
use Illuminate\Http\Request;
use App\Models\EqmHistoryMaster;

class ReturnController extends MainController
{
    // แท็บในหน้า return => สถานะที่แสดง
    const TABS = [
        'borrowed' => ['pending', 'borrowed'],
        'overdue' => ['overdue'],
        'returned' => ['return_pending', 'returned'],
    ];

    public function index(Request $request)
    {
        $user = Auth::id();
        $status = $request->get('status', '');
        if (!array_key_exists($status, self::TABS)) {
            $status = '';
        }
        $statusBorrow = EqmHistoryMaster::where('member_id', $user)
            ->get();
        $borrowQuery = EqmHistoryMaster::where('member_id', $user)
            ->with('details.equipmentItem', 'details.equipment')
            ->orderBy('created_at', 'desc');

        if ($status) {
            $borrowQuery->whereIn('status', self::TABS[$status]);
        }

        $borrow = $borrowQuery->get();

        return view('return', compact('borrow', 'status', 'statusBorrow'));
    }
    public function returnEquipment(Request $request, $id)
    {
        // คืนได้เฉพาะรายการของตัวเอง ที่อนุมัติแล้วและยังไม่คืน (เงื่อนไขเดียวกับปุ่มในหน้า return)
        $master = EqmHistoryMaster::where('member_id', Auth::id())->findOrFail($id);
        abort_unless(in_array($master->status, ['borrowed', 'overdue'], true), 422, 'รายการนี้ไม่สามารถคืนได้');

        DB::transaction(function () use ($master) {
            $master->update([
                'status' => 'return_pending',
                'returned_at' => now(),
            ]);
            foreach ($master->details as $detail) {
                $master->logEvent('return_request', $detail);
            }
        });

        return redirect()->back()
            ->with('success', 'คืนอุปกรณ์เรียบร้อยแล้ว กรุณรอการตรวจสอบจากเจ้าหน้าที่');
    }
    public function cancelEquipment(Request $request, $id)
    {
        // ยกเลิกได้เฉพาะรายการของตัวเองที่ยังรออนุมัติการยืม
        $master = EqmHistoryMaster::where('member_id', Auth::id())->findOrFail($id);
        abort_unless($master->status === 'pending', 422, 'รายการนี้ไม่สามารถยกเลิกได้');

        DB::transaction(function () use ($master) {
            $master->update(['status' => 'cancelled']);
            $master->logEvent('cancel');
        });

        return redirect()->back()
            ->with('success', 'คุณได้ทำการยกเลิกอุปกรณ์เรียบร้อยแล้ว');
    }
}
