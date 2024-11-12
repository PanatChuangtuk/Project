<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class ProductType extends Model
{
    public $timestamps = false;
    use SoftDeletes;

    protected $table = 'product_type';
    protected $fillable = [
        'name',
        'status',
        'created_by',
        'updated_by',
        'deleted_by'
    ];
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function productCategories()
    {
        return $this->hasMany(ProductCategory::class, 'product_type_id');
    }
}
