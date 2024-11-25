<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class UserMember extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'user_member';

    protected $fillable = [
        'username',
        'email',
        'password',
        'first_name',
        'last_name',
        'mobile_phone',
        'company',
        'line_id',
        'vat_register_number',
        'account_type',
        'newsletter',
    ];
}
