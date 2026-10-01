<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LoanTransaction extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'loan_transactions';

    // ระยะเวลายืมสูงสุด (วัน) นับจาก borrowed_at
    const LOAN_DAYS = 7;

    protected $fillable = [
        'member_id',
        'status_type',
        'status',
        'borrowed_at',
        'returned_at',
        'is_overdue',
    ];


    protected $dates = ['deleted_at'];
    public function loanEquipments()
    {
        return $this->hasMany(LoanEquipment::class, 'loan_transactions_id');
    }
    /**
     * รายการที่อนุมัติแล้ว ยังไม่คืน และเลยกำหนดคืน
     * ตรวจจาก borrowed_at ด้วย ไม่พึ่งแค่ status_type = overdue เพราะ hourly task อาจยังไม่ได้รัน
     */
    public function scopeOverdueUnreturned($query)
    {
        return $query->where('status', 'completed')
            ->where(function ($q) {
                $q->where('status_type', 'overdue')
                    ->orWhere(function ($q) {
                        $q->where('status_type', 'borrowed')
                            ->where('borrowed_at', '<=', now()->subDays(self::LOAN_DAYS));
                    });
            });
    }
    public function dueAt(): ?\Carbon\Carbon
    {
        return $this->borrowed_at ? \Carbon\Carbon::parse($this->borrowed_at)->addDays(self::LOAN_DAYS) : null;
    }

    /**
     * สถานะตามขั้นตอนจริงของรายการ (status_type อย่างเดียวบอกไม่ได้ว่ารออนุมัติหรือเสร็จแล้ว)
     */
    public function stageLabel(): string
    {
        if ($this->status === 'cancel') {
            return 'ยกเลิก';
        }
        return match ($this->status_type) {
            'borrowed' => $this->status === 'in_process' ? 'รออนุมัติการยืม'
                : ($this->dueAt()?->isPast() ? 'เกินกำหนด (ยังไม่คืน)' : 'กำลังยืม'),
            'overdue' => 'เกินกำหนด (ยังไม่คืน)',
            'returned' => $this->status === 'in_process' ? 'รอตรวจรับคืน' : 'คืนแล้ว',
            default => '-',
        };
    }

    /**
     * จำนวนวันที่เกินกำหนด (นับถึงวันที่คืน หรือถึงปัจจุบันถ้ายังไม่คืน) 0 = ไม่เกิน
     */
    public function overdueDays(): int
    {
        $due = $this->dueAt();
        if (!$due || $this->status === 'cancel' || ($this->status_type === 'borrowed' && $this->status === 'in_process')) {
            return 0;
        }
        $end = $this->returned_at ? \Carbon\Carbon::parse($this->returned_at) : now();
        return $end->greaterThan($due) ? (int) ceil($due->diffInDays($end)) : 0;
    }

    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id');
    }
}
