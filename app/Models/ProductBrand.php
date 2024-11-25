<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductBrand extends Model
{
    public $timestamps = false;

    protected $table = 'product_brand';
    protected $fillable = [
        'name',
        'code',
        'image',
        'status',
        'created_by',
        'updated_by',
        'deleted_by'
    ];
    protected $dates = ['deleted_at'];
}
