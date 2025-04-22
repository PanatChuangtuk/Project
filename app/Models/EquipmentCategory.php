<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EquipmentCategory extends Model
{
    use SoftDeletes;
    // public $timestamps = false;
    protected $table = 'equipment_category';

    protected $fillable = [
        'name',
        'status',
    ];
    public function item()
    {
        return $this->hasMany(EquipmentItem::class, 'category_id');
    }
}
