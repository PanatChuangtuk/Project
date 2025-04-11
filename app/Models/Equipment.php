<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Equipment extends Model
{
    use SoftDeletes;

    protected $table = 'equipment';

    protected $fillable = [
        'type_id',
        'name',
        'quantity',
        'status',
        'equipment_number',
    ];

    public function type()
    {
        return $this->belongsTo(EquipmentType::class);
    }
}
