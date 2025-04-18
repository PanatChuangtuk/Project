<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Adviser extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'adviser';
    protected $fillable = [
        'first_name',
        'last_name',
        'avatar',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function students()
    {
        return $this->hasMany(Student::class);
    }
}
