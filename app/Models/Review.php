<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Review  extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'reviews';

    protected $fillable = [
        'member_id',
        'product_model_id',
        'comments',
        'star_rating',
        'status',
        'created_by',
        'updated_by',
        'deleted_by',
    ];


    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];
    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id');
    }

    public function productModel()
    {
        return $this->belongsTo(ProductModel::class, 'product_model_id');
    }
}
