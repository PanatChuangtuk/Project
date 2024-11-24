<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Observers\Observer;

class Catalog extends Model
{
    use HasFactory;
    public $timestamps = false; 
    protected $table = 'catalog';
    protected $fillable = [
        'news_id',
        'language_id',
        'name',
        'description',
        'content'
    ];
    protected static function boot():void
    {  
        parent::boot(); 
        static::observe(Observer::class);
    }
 }
