<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\{Hash, DB};
use App\Models\{LoanEquipment, LoanTransaction, Equipment};
use Illuminate\Http\Request;
use Rap2hpoutre\FastExcel\FastExcel;
use Carbon\Carbon;

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
        $borrow = LoanTransaction::findOrFail($id);
        $main_menu = $this->main_menu;

        return view('administrator.equipment_return.edit', compact('main_menu', 'borrow'));
    }
    // ใช้ logic และ validation เดียวกับหน้าอนุมัติการยืม เพื่อไม่ให้สองเส้นทางตรวจไม่เท่ากัน
    public function updateApprove(Request $request)
    {
        return app(ApproveEquipmentController::class)->updateApprove($request);
    }
    public function approveEquipment(Request $request)
    {
        return app(ApproveEquipmentController::class)->approveEquipment($request);
    }
    public function exportData(Request $request)
    {
        [$startDate, $endDate] = $this->validateDateRange($request);

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
                    'รหัสนักศึกษา' => (string) $loan->member?->info?->student?->student_number,
                    'ชื่อ-นามสกุล' => trim($loan->member?->info?->first_name . ' ' . $loan->member?->info?->last_name),
                    'สถานะการยืม-คืน' => match ($loan->status_type) {
                        'borrowed' => 'ยืมอุปกรณ์',
                        'returned' => 'คืนอุปกรณ์',
                        'overdue' => 'เกินกำหนด',
                        default => '-',
                    },
                    'สถานะการอนุมัติ' => match ($loan->status) {
                        'completed' => 'อนุมัติ',
                        'cancel' => 'ไม่อนุมัติ',
                        'in_process' => 'รอดำเนินการ',
                        default => '-',
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
        [$startDate, $endDate] = $this->validateDateRange($request);

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

    /**
     * ตรวจช่วงวันที่ของรายงาน และขยายวันสิ้นสุดให้ครอบคลุมทั้งวัน
     * (ถ้าส่ง 2025-01-31 ไปตรงๆ รายการที่สร้างหลังเที่ยงคืนของวันนั้นจะหลุด)
     */
    private function validateDateRange(Request $request): array
    {
        $validated = $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ], [
            'start_date.required' => 'กรุณาเลือกวันที่เริ่มต้น',
            'start_date.date' => 'วันที่เริ่มต้นไม่ถูกต้อง',
            'end_date.required' => 'กรุณาเลือกวันที่สิ้นสุด',
            'end_date.date' => 'วันที่สิ้นสุดไม่ถูกต้อง',
            'end_date.after_or_equal' => 'วันที่สิ้นสุดต้องไม่น้อยกว่าวันที่เริ่มต้น',
        ]);

        return [
            Carbon::parse($validated['start_date'])->startOfDay(),
            Carbon::parse($validated['end_date'])->endOfDay(),
        ];
    }
}
