<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Observers\Observer;

class NewsImage extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'news_image';
    protected $fillable = [
        'news_id',
        'language_id',
        'image',
        'sort'
    ];
    public function news()
    {
        return $this->belongsTo(News::class, 'news_id');
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
