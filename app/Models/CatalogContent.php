<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Observers\Observer;
class CatalogContent extends Model
{
    public $timestamps = false;
    protected $table = 'catalog_content';
    protected $fillable = [
        'catalog_id',
        'language_id',
        'name',
        'description',
        'file',
    ];

    protected static function boot(): void
    {
        parent::boot();
        static::observe(Observer::class);

    }

    public function content()
    {
        return $this->belongsTo(Catalog::class, 'catalog_id');
    }

    public function language()
    {
        return $this->belongsTo(Language::class, 'language_id');
    }

}
