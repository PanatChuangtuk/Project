<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * เหตุการณ์ยืม-คืน (เพิ่มอย่างเดียว ไม่แก้ไข)
 */
class EqmBorrowReturnHistory extends Model
{
    protected $table = 'eqm_borrow_return_history';

    // มีแค่ created_at และเป็น null ได้ (ข้อมูลที่ย้ายมาไม่ทราบเวลา)
    public $timestamps = false;

    const ACTIONS = [
        'request' => 'ขอยืม',
        'approve_borrow' => 'อนุมัติการยืม',
        'overdue' => 'เกินกำหนด',
        'return_request' => 'แจ้งคืน',
        'approve_return' => 'ตรวจรับคืน',
        'reject_return' => 'ปฏิเสธการคืน',
        'cancel' => 'ยกเลิก',
    ];

    protected $fillable = [
        'master_id',
        'detail_id',
        'action',
        'equipment_id',
        'condition',
        'note',
        'member_id',
        'admin_id',
        'created_at',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    public function master()
    {
        return $this->belongsTo(EqmHistoryMaster::class, 'master_id');
    }

    public function detail()
    {
        return $this->belongsTo(EqmHistoryDetail::class, 'detail_id');
    }

    public function equipment()
    {
        return $this->belongsTo(Equipment::class, 'equipment_id')->withTrashed();
    }

    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id');
    }

    public function admin()
    {
        return $this->belongsTo(Member::class, 'admin_id');
    }

    /**
     * ชื่อผู้ทำเหตุการณ์ พร้อมบทบาท เช่น "ปณัติ ช่วงถึก (ผู้ยืม)"
     */
    public function actorLabel(): string
    {
        if ($this->admin_id) {
            return EqmHistoryMaster::personName($this->admin) . ' (เจ้าหน้าที่)';
        }
        if ($this->member_id) {
            return EqmHistoryMaster::personName($this->member) . ' (ผู้ยืม)';
        }
        return $this->action === 'overdue' ? 'ระบบ' : 'ไม่ทราบ';
    }

    public function actionLabel(): string
    {
        return self::ACTIONS[$this->action] ?? $this->action;
    }
}
