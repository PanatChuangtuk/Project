<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Equipment extends Model
{
    use SoftDeletes;

    protected $table = 'equipment';

    protected $fillable = [
        'item_id',
        'image',
        'number',
        'status',
        'equipment_number',
    ];
    public function item()
    {
        return $this->belongsTo(EquipmentItem::class, 'item_id');
    }
}
