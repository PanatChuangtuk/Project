<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Amphure extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'amphures';

    protected $fillable = [
        'name_th',
        'name_en',
        'province_id',
    ];

    protected $dates = ['deleted_at'];
}
