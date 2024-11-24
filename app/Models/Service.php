<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Observers\Observer;
class Service extends Model
{
    use SoftDeletes;
    protected $table = 'service';
    protected $fillable = [
        'name', 
        'positon_name', 
        'image',
        'created_by', 
        'updated_by', 
        'deleted_by'
    ];

    protected $dates = ['deleted_at'];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function deleter()
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }

    protected static function boot(): void
    {
        parent::boot(); 
        static::observe(Observer::class);
  
    }
}
