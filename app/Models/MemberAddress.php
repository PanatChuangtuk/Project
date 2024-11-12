<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MemberAddress extends CoreModel
{
    use SoftDeletes;

    protected $table = 'member_address';

    protected $fillable = [
        'member_id',
        'first_name',
        'last_name',
        'email',
        'mobile_phone',
        'province_id',
        'district_id',
        'subdistrict_id',
        'postal_code',
        'detail',
        'is_default',
        'created_by',
        'updated_by',
        'deleted_by',
    ];
    protected $dates = ['deleted_at'];
}
