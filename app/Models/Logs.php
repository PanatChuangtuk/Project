<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Logs extends Model 
{
    use HasFactory;
    public $timestamps = false; 
    protected $table = 'logs';
    protected $fillable = [
        'module',
        'module_id',
        'action',
        'title',
        'description',
        'created_by'
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
   
}
