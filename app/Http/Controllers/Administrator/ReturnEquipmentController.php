<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\{EqmHistoryMaster, EqmHistoryDetail, EquipmentItem, Member};
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Rap2hpoutre\FastExcel\FastExcel;
use Carbon\Carbon;

class ReturnEquipmentController extends Controller
{
    private $main_menu = 'approve_equipment';
    public function index(Request $request)
    {
        $filters = $this->filters($request);
        $query = $filters['query'];
        $tab = array_key_exists($request->input('tab'), EqmHistoryMaster::TABS) ? $request->input('tab') : 'all';
        $showAll = $request->boolean('all');

        // ยังไม่ได้กรอง (และไม่ได้กดแสดงทั้งหมด): ยังไม่ดึงข้อมูล รอผู้ใช้เลือกตัวกรองก่อน
        $filtered = $showAll || array_filter($filters);
        if (!$filtered) {
            $tabCounts = collect(EqmHistoryMaster::TABS)->map(fn() => 0);
            $users = new LengthAwarePaginator([], 0, 10);
        } else {
            // จำนวนในแต่ละแท็บ (ตามตัวกรองเดียวกัน)
            $tabCounts = collect(EqmHistoryMaster::TABS)
                ->map(fn($label, $key) => $this->applyFilters(EqmHistoryMaster::query(), $filters)->tab($key)->count());

            // 1 ใบยืม = 1 กลุ่ม (แถวยืม + แถวคืน) เรียงจากใบที่มีความเคลื่อนไหวล่าสุด
            $users = $this->applyFilters(EqmHistoryMaster::with(['member.info.student', 'details.equipment', 'histories.admin.info']), $filters)
                ->tab($tab)
                ->orderByDesc('updated_at')
                ->orderByDesc('id')
                ->paginate(10)
                ->appends(array_filter($filters + ['tab' => $tab, 'all' => $showAll ? 1 : null]));
        }

        // ตัวเลือกอุปกรณ์ในตัวกรอง: เฉพาะที่เคยถูกยืม (รวมที่ถูกลบไปแล้ว)
        $equipmentItems = EquipmentItem::withTrashed()
            ->whereIn('id', EqmHistoryDetail::select('equipment_item_id'))
            ->orderBy('name')
            ->get(['id', 'name']);
        // ตัวเลือกผู้ยืมในตัวกรอง: เฉพาะคนที่เคยยืม
        $borrowers = Member::withTrashed()
            ->with('info.student')
            ->whereIn('id', EqmHistoryMaster::select('member_id'))
            ->get()
            ->mapWithKeys(fn($member) => [$member->id => EqmHistoryMaster::borrowerLabel($member)])
            ->sort();
        $years = DB::table('eqm_history_master')
            ->selectRaw('YEAR(created_at) as year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year');

        $main_menu = $this->main_menu;
        return view('administrator.equipment_return.index', compact('users', 'query', 'main_menu', 'years', 'tab', 'tabCounts', 'filters', 'equipmentItems', 'borrowers', 'filtered', 'showAll'));
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
        foreach ($this->reportRows($startDate, $endDate, $this->filters($request)) as $row) {
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
        $loans = $this->reportLoans($startDate, $endDate, $this->filters($request))->sortBy('borrowed_at')->values();
        $rangeStart = $startDate;
        $rangeEnd = $endDate;

        $startDate =    $this->formatThaiDate($startDate);
        $endDate =  $this->formatThaiDate($endDate);
        return view('reports.loan_report', compact('loans', 'rangeStart', 'rangeEnd', 'startDate', 'endDate'));
    }

    // ใบยืมที่มีการยืมหรือการคืนอยู่ในช่วงวันที่
    private function reportLoans(Carbon $startDate, Carbon $endDate, array $filters = [])
    {
        return $this->applyFilters(EqmHistoryMaster::with(['member.info.student', 'details.equipment', 'histories.admin.info']), $filters)
            ->where(function ($q) use ($startDate, $endDate) {
                $q->whereBetween('borrowed_at', [$startDate, $endDate])
                    ->orWhereBetween('returned_at', [$startDate, $endDate]);
            })
            ->get();
    }

    /**
     * แถวยืม/คืนที่วันที่ของเหตุการณ์อยู่ในช่วง (ยืมวันที่ X => แถวยืม, คืนวันที่ Y => แถวคืน)
     */
    private function reportRows(Carbon $startDate, Carbon $endDate, array $filters = [])
    {
        return $this->reportLoans($startDate, $endDate, $filters)
            ->flatMap(fn($master) => $master->eventRows())
            ->filter(fn($row) => $row->date && $row->date->between($startDate, $endDate))
            ->sortBy(fn($row) => $row->date->timestamp)
            ->values();
    }

    /**
     * ค่าตัวกรองจาก dialog ตัวกรอง (ค่าที่ไม่ถูกต้องจะถูกละไว้ ไม่ทำให้หน้า error)
     */
    private function filters(Request $request): array
    {
        $date = function ($value) {
            try {
                return $value ? Carbon::parse($value)->toDateString() : null;
            } catch (\Exception $e) {
                return null;
            }
        };

        // รายการ id ที่เลือกได้หลายค่า (member_ids[]=1&member_ids[]=2)
        $ids = fn($value) => array_values(array_unique(array_filter(array_map('intval', (array) $value))));

        return [
            'query' => trim((string) $request->input('query')) ?: null,
            'loan_no' => ltrim(trim((string) $request->input('loan_no')), '#') ?: null,
            'member_ids' => $ids($request->input('member_ids')),
            'equipment_item_ids' => $ids($request->input('equipment_item_ids')),
            'start_date' => $date($request->input('start_date')),
            'end_date' => $date($request->input('end_date')),
        ];
    }

    private function applyFilters($masterQuery, array $filters)
    {
        $filters += ['query' => null, 'loan_no' => null, 'member_ids' => [], 'equipment_item_ids' => [], 'start_date' => null, 'end_date' => null];

        if ($search = $filters['query']) {
            $masterQuery->where(function ($queryBuilder) use ($search) {
                $queryBuilder->whereHas('member.info', function ($infoQuery) use ($search) {
                    $infoQuery->where('first_name', 'LIKE', "%{$search}%")
                        ->orWhere('last_name', 'LIKE', "%{$search}%")
                        ->orWhereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["%{$search}%"]);
                })
                    ->orWhereHas('member.info.student', function ($studentQuery) use ($search) {
                        $studentQuery->where('student_number', 'LIKE', "%{$search}%");
                    });
            });
        }

        if ($filters['loan_no']) {
            $masterQuery->where('id', ctype_digit($filters['loan_no']) ? (int) $filters['loan_no'] : 0);
        }

        // เลือกหลายรายการ = ตรงกับรายการใดรายการหนึ่ง
        if ($filters['member_ids']) {
            $masterQuery->whereIn('member_id', $filters['member_ids']);
        }

        if ($filters['equipment_item_ids']) {
            $masterQuery->whereHas('details', fn($q) => $q->whereIn('equipment_item_id', $filters['equipment_item_ids']));
        }

        // ช่วงวันที่: มีการยืมหรือการคืนอยู่ในช่วง (กติกาเดียวกับรายงาน)
        $from = $filters['start_date'] ? Carbon::parse($filters['start_date'])->startOfDay() : null;
        $to = $filters['end_date'] ? Carbon::parse($filters['end_date'])->endOfDay() : null;
        if ($from || $to) {
            $masterQuery->where(function ($q) use ($from, $to) {
                foreach (['borrowed_at', 'returned_at'] as $column) {
                    $q->orWhere(function ($q) use ($column, $from, $to) {
                        $q->whereNotNull($column);
                        if ($from) {
                            $q->where($column, '>=', $from);
                        }
                        if ($to) {
                            $q->where($column, '<=', $to);
                        }
                    });
                }
            });
        }

        return $masterQuery;
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
