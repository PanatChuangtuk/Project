<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Banner extends CoreModel
{
    use SoftDeletes;
    protected $table = 'banner';
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
