<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MemberAddressTax extends CoreModel
{
    use SoftDeletes;

    protected $table = 'member_address_tax';

    protected $fillable = [
        'member_id',
        'name',
        'first_name',
        'last_name',
        'email',
        'mobile_phone',
        'province_id',
        'district_id',
        'subdistrict_id',
        'tax_id',
        'postal_code',
        'type',
        'detail',
        'is_default',
        'created_by',
        'updated_by',
        'deleted_by',
    ];
    protected $dates = ['deleted_at'];
}
