<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductInformation extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'product_information';
    protected $fillable = [
        'product_model_id',
        'product_attribute_id',
        'detail',
        'status',
        'created_by',
        'updated_by',
        'deleted_by'
    ];

    protected $dates = ['deleted_at'];


    public function productAttribute()
    {
        return $this->belongsTo(ProductAttribute::class, 'product_attribute_id', 'id');
    }

    public function productModel()
    {
        return $this->belongsTo(ProductModel::class, 'product_model_id', 'id');
    }
}
