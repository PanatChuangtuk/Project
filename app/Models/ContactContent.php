<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Observers\Observer;
class ContactContent extends Model
{
    public $timestamps = false;
    protected $table = 'contact_content';
    protected $fillable = [
        'contact_id',
        'language_id',
        'name',
        'address',
    ];
    protected $dates = ['deleted_at'];

    protected static function boot(): void
    {
        parent::boot();
        static::observe(Observer::class);
    }

    public function content()
    {
        return $this->belongsTo(Contact::class, 'contact_id');
    }

    public function language()
    {
        return $this->belongsTo(Language::class, 'language_id');
    }
}
