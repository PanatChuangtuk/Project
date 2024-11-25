<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Observers\Observer;

class PromotionContent extends Model
{
    public $timestamps = false;
    protected $table = 'promotion_content';
    protected $fillable = [
        'promotion_id',
        'language_id',
        'name',
        'description',
        'content',
    ];

    public function content()
    {
        return $this->belongsTo(Promotion::class, 'promotion_id');
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
