<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserMemberData extends Model
{
    use HasFactory;

    protected $table = 'user_member_data';

    protected $fillable = [
        'user_member_id',
        'first_name',
        'last_name',
        'company',
        'line_id',
        'vat_register_number',
        'account_type',
        'newsletter',
    ];

    public $timestamps = false;
}
