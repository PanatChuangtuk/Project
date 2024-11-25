<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Observers\Observer;

class About extends Model
{
    use SoftDeletes;
    protected $table = 'about';
    protected $fillable = [
        'name',
        'type',
        'icon',
        'status',
        'created_by',
        'updated_by',
        'deleted_by'
    ];

    protected $dates = ['deleted_at'];

    public function content()
    {
        return $this->hasOne(AboutContent::class, 'about_id', 'id');
    }

    public function creator()
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

    protected static function boot(): void
    {
        parent::boot();
        static::observe(Observer::class);
    }
}
