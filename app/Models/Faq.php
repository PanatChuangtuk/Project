<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;

class Faq extends CoreModel
{
    use SoftDeletes;
    protected $table = 'faq';
    protected $fillable = [
        'name',
        'status',
        'created_by',
        'updated_by',
        'deleted_by'
    ];

    protected $dates = ['deleted_at'];

    public function content()
    {
        return $this->hasOne(FaqContent::class);
    }
}
