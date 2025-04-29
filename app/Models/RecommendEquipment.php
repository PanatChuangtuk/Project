<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RecommendEquipment extends Model
{
    use SoftDeletes;

    protected $table = 'recommend_equipment';

    protected $fillable = [
        'member_id',
        'description',
    ];

    protected $dates = ['deleted_at'];
}
