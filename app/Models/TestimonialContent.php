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
        'description', 
    ];

    public function testimonial()
    {
        return $this->belongsTo(Testimonial::class, 'testimonial_id');
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
