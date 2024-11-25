<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class MemberInfo extends CoreModel
{
    use SoftDeletes;

    protected $table = 'member_infomation';

    protected $fillable = [
        'member_id',
        'first_name',
        'last_name',
        'company',
        'line_id',
        'vat_register_number',
        'account_type',
        'created_by',
        'updated_by',
        'deleted_by',
    ];
    protected $dates = ['deleted_at'];
}
