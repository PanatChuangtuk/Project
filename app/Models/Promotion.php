<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;

class Promotion extends CoreModel
{
    use SoftDeletes;
    protected $table = 'promotion';
    protected $fillable = [
        'name',
        'image',
        'status',
        'created_by',
        'updated_by',
        'deleted_by'
    ];

    protected $dates = ['deleted_at'];

    public function content()
    {
        return $this->hasOne(PromotionContent::class, 'promotion_id', 'id');
    }
}
