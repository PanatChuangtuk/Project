<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Guide extends Model
{
    use SoftDeletes;

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

    public function creator()
    {
        return $this->belongsTo(Member::class, 'created_by', 'id');
    }
}
