<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public $timestamps = false;

    protected $table = 'product';
    protected $fillable = [
        'product_model_id',
        'sku',
        'name',
        'size',
        'model',
        'price',
        'quantity',
    ];
    public function productModel()
    {
        return $this->belongsTo(ProductModel::class, 'product_model_id', 'id');
    }
    public function productPrices()
    {
        return $this->hasMany(ProductPrice::class, 'product_id', 'id');
    }
}
