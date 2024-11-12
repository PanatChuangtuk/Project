<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Catalog extends CoreModel
{
    use SoftDeletes;
    protected $table = 'catalog';
    protected $fillable = [
        'name',
        'image',
        'status',
        'created_by',
        'updated_by',
        'deleted_by'
    ];
    protected $dates = ['deleted_at'];

    public function content()
    {
        return $this->hasOne(CatalogContent::class, 'catalog_id', 'id');
    }
}
