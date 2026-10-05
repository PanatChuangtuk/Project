<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

/**
 * ใบยืม 1 ใบต่อการยืม 1 ครั้ง
 */
class EqmHistoryMaster extends Model
{
    use SoftDeletes;

    protected $table = 'eqm_history_master';

    // ระยะเวลายืมสูงสุด (วัน) นับจาก borrowed_at
    const LOAN_DAYS = 7;

    const STATUSES = [
        'pending' => 'รออนุมัติการยืม',
        'borrowed' => 'กำลังยืม',
        'overdue' => 'เกินกำหนด (ยังไม่คืน)',
        'return_pending' => 'รอตรวจรับคืน',
        'returned' => 'คืนแล้ว',
        'cancelled' => 'ยกเลิก',
    ];

    // สถานะที่อุปกรณ์ยังไม่กลับเข้าคลัง (นับว่าไม่ว่าง)
    const ACTIVE_STATUSES = ['pending', 'borrowed', 'overdue', 'return_pending'];

    // สถานะที่รอเจ้าหน้าที่ดำเนินการ
    const WAITING_STATUSES = ['pending', 'return_pending'];

    protected $fillable = [
        'member_id',
        'status',
        'borrowed_at',
        'due_at',
        'returned_at',
        'is_overdue',
    ];

    protected $casts = [
        'borrowed_at' => 'datetime',
        'due_at' => 'datetime',
        'returned_at' => 'datetime',
        'is_overdue' => 'boolean',
    ];

    public function details()
    {
        return $this->hasMany(EqmHistoryDetail::class, 'master_id');
    }

    public function histories()
    {
        return $this->hasMany(EqmBorrowReturnHistory::class, 'master_id');
    }

    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id');
    }

    // แท็บกรองในหน้ารายการของแอดมิน
    const TABS = [
        'all' => 'ทั้งหมด',
        'waiting' => 'รอดำเนินการ',
        'borrowing' => 'กำลังยืม',
        'overdue' => 'เกินกำหนด',
        'returned' => 'คืนแล้ว',
        'damaged' => 'ชำรุด/สูญหาย',
        'cancelled' => 'ยกเลิก',
    ];

    public function scopeTab($query, string $tab)
    {
        return match ($tab) {
            'waiting' => $query->whereIn('status', self::WAITING_STATUSES),
            'borrowing' => $query->where('status', 'borrowed')->where('due_at', '>', now()),
            // ทั้งที่ยังค้างอยู่ และที่เคยคืนช้า
            'overdue' => $query->where(function ($q) {
                $q->overdueUnreturned()
                    ->orWhere('is_overdue', true)
                    ->orWhereColumn('returned_at', '>', 'due_at');
            }),
            'returned' => $query->where('status', 'returned'),
            'damaged' => $query->whereHas('details', fn($q) => $q->whereIn('condition', ['damaged', 'lost'])),
            'cancelled' => $query->where('status', 'cancelled'),
            default => $query,
        };
    }

    public function scopeActive($query)
    {
        return $query->whereIn('status', self::ACTIVE_STATUSES);
    }

    /**
     * รายการที่อนุมัติแล้ว ยังไม่คืน และเลยกำหนดคืน
     * ตรวจจาก due_at ด้วย ไม่พึ่งแค่ status = overdue เพราะ hourly task อาจยังไม่ได้รัน
     */
    public function scopeOverdueUnreturned($query)
    {
        return $query->where(function ($q) {
            $q->where('status', 'overdue')
                ->orWhere(function ($q) {
                    $q->where('status', 'borrowed')->where('due_at', '<=', now());
                });
        });
    }

    public function isPastDue(): bool
    {
        return in_array($this->status, ['borrowed', 'overdue'], true) && $this->due_at?->isPast();
    }

    /**
     * สถานะตามขั้นตอนจริง (borrowed ที่เลยกำหนดแต่ task ยังไม่รัน แสดงเป็นเกินกำหนด)
     */
    public function stageLabel(): string
    {
        return $this->isPastDue() ? self::STATUSES['overdue'] : (self::STATUSES[$this->status] ?? '-');
    }

    // ชนิดคำร้อง ใช้ในตารางหน้าแอดมิน
    public function requestTypeLabel(): string
    {
        return match ($this->status) {
            'overdue' => 'เกินกำหนด',
            'return_pending', 'returned' => 'คืนอุปกรณ์',
            default => 'ยืมอุปกรณ์',
        };
    }

    // สถานะคำร้อง ใช้ในตารางหน้าแอดมิน
    public function approvalLabel(): string
    {
        return match ($this->status) {
            'pending', 'return_pending' => 'รอดำเนินการ',
            'cancelled' => 'ยกเลิก',
            default => 'อนุมัติ',
        };
    }

    /**
     * จำนวนวันที่เกินกำหนด (นับถึงวันที่คืน หรือถึงปัจจุบันถ้ายังไม่คืน) 0 = ไม่เกิน
     */
    public function overdueDays(): int
    {
        if (!$this->due_at || in_array($this->status, ['pending', 'cancelled'], true)) {
            return 0;
        }
        $end = $this->returned_at ?? now();
        return $end->greaterThan($this->due_at) ? (int) ceil($this->due_at->diffInDays($end)) : 0;
    }

    /**
     * บันทึกเหตุการณ์ระดับใบยืม หรือระดับชิ้น (ส่ง $detail)
     */
    public function logEvent(string $action, ?EqmHistoryDetail $detail = null, array $attributes = []): EqmBorrowReturnHistory
    {
        return $this->histories()->create($attributes + [
            'detail_id' => $detail?->id,
            'action' => $action,
            'equipment_id' => $detail?->equipment_id,
            'member_id' => Auth::guard('member')->id(),
            'admin_id' => Auth::guard('web')->id(),
            'created_at' => Carbon::now(),
        ]);
    }

    /**
     * แยกใบยืมเป็นแถว "ยืม" และแถว "คืน" (ถ้ามีการแจ้งคืนแล้ว) สำหรับหน้ารายการ/รายงาน
     * ต้อง eager load histories.admin.info และ details.equipment ไว้ก่อน
     */
    public function eventRows(): \Illuminate\Support\Collection
    {
        $lastAdmin = fn(array $actions) => $this->histories
            ->whereIn('action', $actions)
            ->whereNotNull('admin_id')
            ->sortBy('id')
            ->last()?->admin;

        $rows = collect([(object) [
            'type' => 'borrow',
            'type_label' => 'ยืม',
            'date' => $this->borrowed_at,
            'master' => $this,
            'details' => $this->details,
            'admin' => $lastAdmin(['approve_borrow', 'cancel']),
            'status_label' => match ($this->status) {
                'pending' => 'รออนุมัติ',
                'cancelled' => 'ยกเลิก',
                default => 'อนุมัติ',
            },
            'condition_summary' => '',
            'overdue_days' => 0,
        ]]);

        if ($this->returned_at) {
            $rows->push((object) [
                'type' => 'return',
                'type_label' => 'คืน',
                'date' => $this->returned_at,
                'master' => $this,
                'details' => $this->details,
                'admin' => $this->status === 'returned' ? $lastAdmin(['approve_return']) : null,
                'status_label' => $this->status === 'returned' ? 'ตรวจรับแล้ว' : 'รอตรวจรับ',
                'condition_summary' => EqmHistoryDetail::conditionSummary($this->details),
                'overdue_days' => $this->overdueDays(),
            ]);
        }

        return $rows;
    }

    public static function personName(?Member $admin): string
    {
        if (!$admin) {
            return '-';
        }
        return trim(($admin->info?->first_name ?? '') . ' ' . ($admin->info?->last_name ?? '')) ?: ($admin->email ?? '-');
    }

    // ชื่อผู้ยืมพร้อมรหัสนักศึกษา ใช้ในตัวเลือก/ป้ายตัวกรอง
    public static function borrowerLabel(Member $member): string
    {
        $number = $member->info?->student?->student_number;
        return self::personName($member) . ($number ? " ({$number})" : '');
    }

    // สถานะหลังเจ้าหน้าที่ปฏิเสธการคืน
    public function borrowingStatus(): string
    {
        return $this->due_at?->isPast() ? 'overdue' : 'borrowed';
    }
}
