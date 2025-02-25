<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Member extends Authenticatable
{
    protected $table = 'member';

    // public function isAdmin()
    // {
    //     return $this->role === 'admin';
    // }

    // public function isStudent()
    // {
    //     return $this->role === 'student';
    // }
}
