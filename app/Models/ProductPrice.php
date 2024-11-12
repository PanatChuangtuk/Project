<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductPrice extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'product_price';

    protected $fillable = [
        'product_id',
        'member_group_id',
        'price',
        'status',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $dates = ['deleted_at'];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function memberGroup()
    {
        return $this->belongsTo(MemberGroup::class, 'member_group_id', 'id');
    }
}
