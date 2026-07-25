<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Guide extends Authenticatable
{
    use SoftDeletes, Notifiable;

    protected $table = 'guide';

    protected $fillable = [

        'link_video',
        'video_name',
        'status',
        'created_at',
        'updated_at',
        'deleted_at',
        'created_by',
        'updated_by',
        'deleted_by'
    ];

    protected $hidden = [
        'password',
    ];

    protected $dates = ['deleted_at'];

    public function creator()
    {
        return $this->belongsTo(Member::class, 'created_by', 'id');
    }
}
