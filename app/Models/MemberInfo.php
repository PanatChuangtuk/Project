<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class MemberInfo extends CoreModel
{
    use SoftDeletes;

    protected $table = 'member_infomation';


    protected $dates = ['deleted_at'];
}
