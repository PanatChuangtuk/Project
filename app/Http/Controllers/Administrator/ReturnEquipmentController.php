<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\{EqmHistoryMaster, EqmHistoryDetail};
use Illuminate\Http\Request;
use Rap2hpoutre\FastExcel\FastExcel;
use Carbon\Carbon;

class ReturnEquipmentController extends Controller
{
    private $main_menu = 'approve_equipment';
    public function index(Request $request)
    {
        $query = $request->input('query');
        $tab = array_key_exists($request->input('tab'), EqmHistoryMaster::TABS) ? $request->input('tab') : 'all';

        $search = function ($userQuery) use ($query) {
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
            return $userQuery;
        };

        // จำนวนในแต่ละแท็บ (ตามคำค้นหาเดียวกัน)
        $tabCounts = collect(EqmHistoryMaster::TABS)
            ->map(fn($label, $key) => $search(EqmHistoryMaster::query())->tab($key)->count());

        // 1 ใบยืม = 1 กลุ่ม (แถวยืม + แถวคืน) เรียงจากใบที่มีความเคลื่อนไหวล่าสุด
        $users = $search(EqmHistoryMaster::with(['member.info.student', 'details.equipment', 'histories.admin.info']))
            ->tab($tab)
            ->orderByDesc('updated_at')
            ->orderByDesc('id')
            ->paginate(10)
            ->appends(['query' => $query, 'tab' => $tab]);
        $years = DB::table('eqm_history_master')
            ->selectRaw('YEAR(created_at) as year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year');

        $main_menu = $this->main_menu;
        return view('administrator.equipment_return.index', compact('users', 'query', 'main_menu', 'years', 'tab', 'tabCounts'));
    }
    public function edit(Request $request, $id)
    {
        $borrow = EqmHistoryMaster::with(['details.equipmentItem', 'details.equipment', 'histories.admin.info', 'histories.member.info', 'histories.detail', 'histories.equipment'])
            ->findOrFail($id);
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

        $exportRows = [];
        foreach ($this->reportRows($startDate, $endDate) as $row) {
            $loan = $row->master;
            foreach ($row->details->groupBy('equipment_item_id') as $details) {
                $exportRows[] = [
                    'วันที่' => $row->date?->format('Y-m-d H:i') ?? '-',
                    'ชนิด' => $row->type_label,
                    'รายการที่' => $loan->id,
                    'รหัสนักศึกษา' => (string) $loan->member?->info?->student?->student_number,
                    'ชื่อ-นามสกุล' => trim($loan->member?->info?->first_name . ' ' . $loan->member?->info?->last_name),
                    'ชื่ออุปกรณ์' => $details->first()->name,
                    'จำนวน' => $details->count(),
                    'เลขอุปกรณ์' => $details->map(fn($d) => $d->equipment?->number)->filter()->implode(', '),
                    'ผู้ดำเนินการ' => EqmHistoryMaster::personName($row->admin),
                    'สถานะ' => $row->status_label,
                    'กำหนดคืน' => $row->type === 'borrow' ? ($loan->due_at?->format('Y-m-d H:i') ?? '-') : '',
                    'เกินกำหนด (วัน)' => $row->overdue_days ?: '',
                    'สภาพอุปกรณ์ที่ได้รับคืน' => $row->type === 'return' ? EqmHistoryDetail::conditionSummary($details) : '',
                ];
            }
        }
        return (new FastExcel(collect($exportRows)))
            ->download('รายงานการยืม-คืนอุปกรณ์ ตั้งแต่วันที่ ' . $this->formatThaiDate($startDate) . ' ถึง ' . $this->formatThaiDate($endDate) . '.xlsx');
    }
    public function printReportByYear(Request $request)
    {
        [$startDate, $endDate] = $this->validateDateRange($request);

        // จัดกลุ่มตามใบยืม: แสดงทั้งแถวยืมและแถวคืนของใบ แถวที่อยู่นอกช่วงจะแสดงจางไว้ให้เห็นคู่กัน
        $loans = $this->reportLoans($startDate, $endDate)->sortBy('borrowed_at')->values();
        $rangeStart = $startDate;
        $rangeEnd = $endDate;

        $startDate =    $this->formatThaiDate($startDate);
        $endDate =  $this->formatThaiDate($endDate);
        return view('reports.loan_report', compact('loans', 'rangeStart', 'rangeEnd', 'startDate', 'endDate'));
    }

    // ใบยืมที่มีการยืมหรือการคืนอยู่ในช่วงวันที่
    private function reportLoans(Carbon $startDate, Carbon $endDate)
    {
        return EqmHistoryMaster::with(['member.info.student', 'details.equipment', 'histories.admin.info'])
            ->where(function ($q) use ($startDate, $endDate) {
                $q->whereBetween('borrowed_at', [$startDate, $endDate])
                    ->orWhereBetween('returned_at', [$startDate, $endDate]);
            })
            ->get();
    }

    /**
     * แถวยืม/คืนที่วันที่ของเหตุการณ์อยู่ในช่วง (ยืมวันที่ X => แถวยืม, คืนวันที่ Y => แถวคืน)
     */
    private function reportRows(Carbon $startDate, Carbon $endDate)
    {
        return $this->reportLoans($startDate, $endDate)
            ->flatMap(fn($master) => $master->eventRows())
            ->filter(fn($row) => $row->date && $row->date->between($startDate, $endDate))
            ->sortBy(fn($row) => $row->date->timestamp)
            ->values();
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
