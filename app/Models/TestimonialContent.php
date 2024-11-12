<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Observers\Observer;

class TestimonialContent extends Model
{
    public $timestamps = false;
    protected $table = 'testimonial_content';
    protected $fillable = [
        'testimonial_id',
        'language_id',
        'name',
        'profile_name',
        'profile_position',
        'content',
        'testimonial_id',
        'language_id',
        'name',
        'profile_name',
        'profile_position',
        'content',
    ];

    protected static function boot(): void
    {
        parent::boot();
        static::observe(Observer::class);
    }
}
