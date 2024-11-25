<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Observers\Observer;

class AboutContent extends Model
{
    public $timestamps = false;
    protected $table = 'about_content';
    protected $fillable = [
        'about_id',
        'language_id',
        'name',
        'description',
        'content'
    ];

    public function content()
    {
        return $this->belongsTo(About::class, 'about_id');
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
}
