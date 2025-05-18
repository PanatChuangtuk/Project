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
        LoanTransaction::find($id)->update([
            'status_type' => 'returned',
            'status' => 'in_process',
            'returned_at' => now(),
        ]);


        return redirect()->back()
            ->with('success', 'คืนอุปกรณ์เรียบร้อยแล้ว กรุณรอการตรวจสอบจากเจ้าหน้าที่');
    }
    public function cancelEquipment(Request $request, $id)
    {
        LoanTransaction::find($id)->update([
            'status' => 'cancel',
        ]);

        return redirect()->back()
            ->with('success', 'คุณได้ทำการยกเลิกอุปกรณ์เรียบร้อยแล้ว');
    }
}
