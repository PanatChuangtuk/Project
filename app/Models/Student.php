<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'student';

    protected $primaryKey = 'id';

    protected $fillable = [
        'student_number',
        'first_name',
        'last_name',
        'mobile_phone',
        'email',
        'status',
    ];

    public $timestamps = false;

    protected $dates = ['deleted_at'];
}
