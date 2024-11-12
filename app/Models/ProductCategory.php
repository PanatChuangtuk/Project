<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    public $timestamps = false;

    protected $table = 'product_category';
    protected $fillable = [
        'product_type_id',
        'name',
        'status',
        'created_at',
        'created_by',
        'updated_at',
        'updated_by',
        'deleted_at',
        'deleted_by',
    ];
    public function productType()
    {
        return $this->belongsTo(ProductType::class);
    }
}
