<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\{Hash, DB};
use App\Models\{LoanEquipment, LoanTransaction, Equipment};
use Illuminate\Http\Request;

class ReturnEquipmentController extends Controller
{
    private $main_menu = 'approve_equipment';
    public function index(Request $request)
    {
        $query = $request->input('query');

        $userQuery = LoanTransaction::whereIn('status',  ['completed', 'cancel']);

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
        return view('administrator.equipment_return.index', compact('users', 'query', 'main_menu'));
    }
    public function edit(Request $request, $id)
    {
        // dd($request->all());
        $borrow = LoanTransaction::find($id);
        $main_menu = $this->main_menu;

        return view('administrator.equipment_return.edit', compact('main_menu', 'borrow'));
    }
    public function updateApprove(Request $request)
    {

        $item = $request->get('item');
        $status = $request->get('status');
        DB::table('loan_transactions')
            ->where('id', $item)
            ->update([
                'status' => $status,
            ]);

        return response()->json([
            'message' => 'สถานะการอนุมัติถูกอัปเดตเรียบร้อยแล้ว',
            'success' => true
        ]);
    }
    public function approveEquipment(Request $request)
    {
        $itemIds = $request->input('item_id');
        $equipmentIds = $request->input('equipments_id');

        foreach ($itemIds as $index => $itemId) {
            $equipmentId = $equipmentIds[$index];
            $loanEquipment = LoanEquipment::find($itemId);
            if ($loanEquipment->loanTransaction->status == 'in_progress') {
                $loanEquipment->loanTransaction->update([
                    'status' => 'completed',
                ]);
            }
            $loanEquipment->update([
                'equipment_id' => $equipmentId,
            ]);
        }
        return redirect()->back()->with('success', 'อนุมัติการยืมสำเร็จ');
    }
}
