<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Province extends Model
{
    use HasFactory, SoftDeletes;

    // ชื่อตารางในฐานข้อมูล
    protected $table = 'provinces';

    // กำหนดฟิลด์ที่สามารถกรอกข้อมูลได้
    protected $fillable = [
        'name_th',
        'name_en',
        'geography_id',
    ];

    // กำหนดฟิลด์ที่ใช้สำหรับการทำ soft delete
    protected $dates = ['deleted_at'];
}
