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
        'member_id',
        'student_id',
        'avatar'
    ];

    protected $dates = ['deleted_at'];

    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id', 'id');
    }
    public function student()
    {
        return $this->hasOne(Student::class, 'student_id', 'id');
    }
}
