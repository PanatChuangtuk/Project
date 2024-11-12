<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use App\Observers\Observer;

class Brand extends CoreModel
{
    use SoftDeletes;
    protected $table = 'brand';
    protected $fillable = [
        'name',
        'image',
        'url',
        'status',
        'created_by',
        'updated_by',
        'deleted_by'
    ];

    protected $dates = ['deleted_at'];
}
