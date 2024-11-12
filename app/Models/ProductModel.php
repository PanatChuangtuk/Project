<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductModel extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'product_model';
    protected $fillable = [
        'product_type_id',
        'product_brand_id',
        'product_category_id',
        'name',
        'code',
        'description',
        'status',
        'created_by',
        'updated_by',
        'deleted_by'
    ];

    protected $dates = ['deleted_at'];

    public function products()
    {
        return $this->hasMany(Product::class, 'product_model_id', 'id');
    }
    public function productInformations()
    {
        return $this->hasMany(ProductInformation::class, 'product_model_id', 'id');
    }
    public function productPrices()
    {
        return $this->hasManyThrough(ProductPrice::class, Product::class, 'product_model_id', 'product_id', 'id', 'id');
    }
}
