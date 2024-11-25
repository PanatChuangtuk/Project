<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Observers\Observer;

class CommonContent extends Model
{
    public $timestamps = false;
    protected $table = 'common_content';
    protected $fillable = [
        'common_id',
        'language_id',
        'name',
        'description',
        'content'
    ];

    protected $dates = ['deleted_at'];
    public function content()
    {
        return $this->belongsTo(Common::class, 'common_id');
    }
    public function language()
    {
        return $this->belongsTo(Language::class, 'language_id');
    }
    protected static function boot(): void
    {
        parent::boot();
        static::observe(Observer::class);
    }

    public function content()
    {
        return $this->belongsTo(Common::class, 'common_id');
    }
}
