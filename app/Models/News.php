<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Observers\Observer;

class News extends Model
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
    
    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function deleter()
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }

    protected static function boot():void
    {
        parent::boot(); 
        static::observe(Observer::class);
    }
}
