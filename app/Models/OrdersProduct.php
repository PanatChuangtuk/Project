<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrdersProduct extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'orders_product';

    protected $fillable = [
        'product_id',
        'order_id',
        'name',
        'sku',
        'size',
        'price',
        'quantity',
        'total',
        'created_by',
        'updated_by',
        'deleted_by'
    ];

    protected $dates = ['deleted_at'];
}
