<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * อุปกรณ์ 1 ชิ้นในใบยืม
 */
class EqmHistoryDetail extends Model
{
    protected $table = 'eqm_history_detail';

    // สภาพอุปกรณ์ตอนตรวจรับคืน
    const CONDITIONS = [
        'normal' => 'ปกติ',
        'damaged' => 'ชำรุด',
        'lost' => 'สูญหาย',
    ];

    protected $fillable = [
        'master_id',
        'equipment_item_id',
        'equipment_id',
        'name',
        'condition',
        'condition_note',
    ];

    public function master()
    {
        return $this->belongsTo(EqmHistoryMaster::class, 'master_id');
    }

    public function equipment()
    {
        return $this->belongsTo(Equipment::class, 'equipment_id')->withTrashed();
    }

    public function equipmentItem()
    {
        return $this->belongsTo(EquipmentItem::class, 'equipment_item_id')->withTrashed();
    }

    public function histories()
    {
        return $this->hasMany(EqmBorrowReturnHistory::class, 'detail_id');
    }

    // ชิ้นที่อยู่ในใบยืมที่ยังไม่จบ
    public function scopeActive($query)
    {
        return $query->whereHas('master', fn($q) => $q->active());
    }

    public function conditionLabel(): ?string
    {
        return self::CONDITIONS[$this->condition] ?? null;
    }

    /**
     * สรุปสภาพของหลายชิ้น เช่น "ปกติ 2, ชำรุด 1" (ว่างถ้ายังไม่ได้ตรวจรับคืน)
     */
    public static function conditionSummary($details): string
    {
        return collect($details)
            ->whereNotNull('condition')
            ->countBy('condition')
            ->map(fn($count, $condition) => (self::CONDITIONS[$condition] ?? $condition) . ' ' . $count)
            ->implode(', ');
    }
}
