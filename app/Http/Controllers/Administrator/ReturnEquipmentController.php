<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\{Hash, DB};
use App\Models\{LoanEquipment, LoanTransaction, Equipment};
use Illuminate\Http\Request;
use Rap2hpoutre\FastExcel\FastExcel;

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
        $years = DB::table('loan_transactions')
            ->selectRaw('YEAR(created_at) as year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year');

        $main_menu = $this->main_menu;
        return view('administrator.equipment_return.index', compact('users', 'query', 'main_menu', 'years'));
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
            if ($loanEquipment->loanTransaction->status == 'in_process') {
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
    public function exportData(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $loans = LoanTransaction::with([
            'member.info',
            'loanEquipments' => function ($query) {
                $query->selectRaw('loan_transactions_id, equipment_item_id, GROUP_CONCAT(DISTINCT name) as equipment_names, SUM(quantity) as total_qty')
                    ->groupBy('loan_transactions_id', 'equipment_item_id');
            }
        ])
            ->whereBetween('created_at', [$startDate, $endDate])
            ->get();

        $exportRows = [];

        foreach ($loans as $loan) {
            foreach ($loan->loanEquipments as $equipment) {
                $exportRows[] = [
                    'รายการที่' => $loan->id,
                    'รหัสนักศึกษา' => optional($loan->member->info)->student->student_number,
                    'ชื่อ-นามสกุล' => optional($loan->member->info)->first_name . ' ' . optional($loan->member->info)->last_name,
                    'สถานะการยืม-คืน' => match ($loan->status_type) {
                        'borrowed' => 'ยืมอุปกรณ์',
                        'returned' => 'คืนอุปกรณ์',
                        'overdue' => 'เกินกำหนด',
                    },
                    'สถานะการอนุมัติ' => match ($loan->status) {
                        'completed' => 'อนุมัติ',
                        'cancel' => 'ไม่อนุมัติ',
                        'in_process' => 'รอดำเนินการ',
                    },
                    'ชื่ออุปกรณ์' => $equipment->equipment_names,
                    'จำนวน' => $equipment->total_qty,
                    'วันที่ยืม' => $loan->borrowed_at ?? '-',
                    'วันที่คืน' => $loan->returned_at ?? '-',
                    'คืนเกินเวลาที่กำหนด' => $loan->is_overdue === 1 ? 'เกินเวลา' : '',
                ];
            }
        }
        return (new FastExcel(collect($exportRows)))
            ->download('รายงานการยืม-คืนอุปกรณ์ ตั้งแต่วันที่ ' . $this->formatThaiDate($startDate) . ' ถึง ' . $this->formatThaiDate($endDate) . '.xlsx');
    }
    public function printReportByYear(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $loans = LoanTransaction::with([
            'member.info',
            'loanEquipments' => function ($query) {
                $query->selectRaw('loan_transactions_id, equipment_item_id, GROUP_CONCAT(DISTINCT name) as equipment_names, SUM(quantity) as total_qty')
                    ->groupBy('loan_transactions_id', 'equipment_item_id');
            }
        ])
            ->whereBetween('created_at', [$startDate, $endDate])
            ->get();

        $startDate =    $this->formatThaiDate($startDate);
        $endDate =  $this->formatThaiDate($endDate);
        return view('reports.loan_report', compact('loans', 'startDate', 'endDate'));
    }
}
