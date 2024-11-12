<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductAttribute extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'product_attribute';
    protected $fillable = [
        'product_type_id',
        'name',
        'code',
        'status',
        'created_by',
        'updated_by',
        'deleted_by'
    ];

    protected $dates = ['deleted_at'];

    public function productType()
    {
        return $this->belongsTo(ProductType::class, 'product_type_id', 'id');
    }

    public function productInformations()
    {
        return $this->hasMany(ProductInformation::class, 'product_attribute_id', 'id');
    }
}
