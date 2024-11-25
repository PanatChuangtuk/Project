<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;

class Common extends CoreModel
{
    use SoftDeletes;
    protected $table = 'common';
    protected $fillable = [
        'name',
        'type',
        'created_by',
        'updated_by',
        'deleted_by'
    ];

    protected $dates = ['deleted_at'];

    public function content()
    {
        return $this->hasOne(CommonContent::class, 'common_id', 'id');
    }
}
