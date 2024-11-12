<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'orders';

    // กำหนดฟิลด์ที่สามารถกำหนดค่าได้โดยตรง
    protected $fillable = [
        'member_id',
        'order_number',
        'subtotal',
        'vat',
        'shipping_free',
        'discount',
        'total',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];
}
