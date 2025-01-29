<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Observers\Observer;

class Geographies extends Model
{
    public $timestamps = false;
    protected $table = 'geographies';
    protected $fillable = [
        'name',
    ];
}
