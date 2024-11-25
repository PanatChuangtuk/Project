<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Contact extends CoreModel
{
    use SoftDeletes;
    protected $table = 'contact';
    protected $fillable = [
        'name',
        'phone',
        'fax',
        'email',
        'image',
        'created_by',
        'updated_by',
        'deleted_by'
    ];
    protected $dates = ['deleted_at'];

    public function content()
    {
        return $this->hasOne(ContactContent::class, 'contact_id', 'id');
    }
}
