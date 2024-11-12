<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class News extends CoreModel
{
    use HasFactory, SoftDeletes;

    protected $table = 'news';
    protected $fillable = [
        'name',
        'slug',
        'status',
        'created_by',
        'updated_by',
        'deleted_by'
    ];
    protected $dates = ['deleted_at'];

    public function content()
    {
        return $this->hasOne(NewsContent::class, 'news_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function images()
    {
        return $this->hasMany(NewsImage::class, 'news_id', 'id');
    }
}
