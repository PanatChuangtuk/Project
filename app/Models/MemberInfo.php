<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class MemberInfo extends Model
{
    use SoftDeletes;

    protected $table = 'member_infomation';
    protected $fillable = [
        'first_name',
        'last_name',
        'adviser_id',
        'member_id'
    ];

    protected $dates = ['deleted_at'];
}
