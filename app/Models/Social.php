<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;

class Social extends CoreModel
{
    use SoftDeletes;
    protected $table = 'social';
    protected $fillable = [
        'name',
        'image',
        'html',
        'status',
        'created_by',
        'updated_by',
        'name',
        'image',
        'html',
        'status',
        'created_by',
        'updated_by',
        'deleted_by'
    ];

    protected $dates = ['deleted_at'];
}
