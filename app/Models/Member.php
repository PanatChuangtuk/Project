<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Member extends Authenticatable
{
    use SoftDeletes, Notifiable;

    protected $table = 'member';

    protected $fillable = [
        'role',
        'password',
        'email',
        'status',
        'created_by',
        'updated_by',
        'deleted_by'
    ];

    protected $hidden = [
        'password',
    ];

    protected $dates = ['deleted_at'];

    public function info()
    {
        return $this->hasOne(MemberInfo::class, 'member_id', 'id');
    }
    public function loanTransactions()
    {
        return $this->hasMany(LoanTransaction::class, 'member_id');
    }
}
