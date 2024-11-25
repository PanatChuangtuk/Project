<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Observers\Observer;

class FaqContent extends Model
{
    public $timestamps = false;
    protected $table = 'faq_content';
    protected $fillable = [
        'faq_id',
        'language_id',
        'name',
        'content',
    ];

    public function faq()
    {
        return $this->belongsTo(Faq::class, 'faq_id');
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
