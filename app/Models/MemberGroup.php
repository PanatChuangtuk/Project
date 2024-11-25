<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class MemberGroup extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'member_group';
    protected $fillable = [
        'name',
        'code',
        'status',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $dates = ['deleted_at'];
    public function productPrices()
    {
        return $this->hasMany(ProductPrice::class, 'member_group_id', 'id');
    }
}
