<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrdersAddress  extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'orders_address';

    protected $fillable = [
        'member_id',
        'order_id',
        'first_name',
        'last_name',
        'email',
        'mobile_phone',
        'province_id',
        'district_id',
        'subdistrict_id',
        'postal_code',
        'detail',
        'type',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id');
    }
}
