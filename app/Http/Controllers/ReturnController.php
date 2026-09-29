<?php

namespace App\Http\Controllers;

use App\Http\Controllers\MainController;
use Illuminate\Support\Facades\{Auth, DB, Validator, Hash};
use Illuminate\Http\Request;
use App\Models\{LoanTransaction, LoanEquipment};

class ReturnController extends MainController
{
    public function index(Request $request)
    {
        $user = Auth::id();
        $status = $request->get('status', '');
        if (!in_array($status, ['borrowed', 'returned', 'overdue'], true)) {
            $status = '';
        }
        $statusBorrow = LoanTransaction::where('member_id', $user)
            ->get();
        $borrowQuery = LoanTransaction::where('member_id', $user)
            ->orderBy('created_at', 'desc');

        if ($status) {
            $borrowQuery->where('status_type', $status);
        }

        $borrow = $borrowQuery->get();

        return view('return', compact('borrow', 'status', 'statusBorrow'));
    }
    public function returnEquipment(Request $request, $id)
    {
        // คืนได้เฉพาะรายการของตัวเอง ที่อนุมัติแล้วและยังไม่คืน (เงื่อนไขเดียวกับปุ่มในหน้า return)
        $loan = LoanTransaction::where('member_id', Auth::id())->findOrFail($id);
        abort_unless(
            in_array($loan->status_type, ['borrowed', 'overdue']) && $loan->status === 'completed',
            422,
            'รายการนี้ไม่สามารถคืนได้'
        );

        $loan->update([
            'status_type' => 'returned',
            'status' => 'in_process',
            'returned_at' => now(),
        ]);


        return redirect()->back()
            ->with('success', 'คืนอุปกรณ์เรียบร้อยแล้ว กรุณรอการตรวจสอบจากเจ้าหน้าที่');
    }
    public function cancelEquipment(Request $request, $id)
    {
        // ยกเลิกได้เฉพาะรายการของตัวเองที่ยังรออนุมัติการยืม
        $loan = LoanTransaction::where('member_id', Auth::id())->findOrFail($id);
        abort_unless(
            $loan->status_type === 'borrowed' && $loan->status === 'in_process',
            422,
            'รายการนี้ไม่สามารถยกเลิกได้'
        );

        $loan->update([
            'status' => 'cancel',
        ]);

        return redirect()->back()
            ->with('success', 'คุณได้ทำการยกเลิกอุปกรณ์เรียบร้อยแล้ว');
    }
}
