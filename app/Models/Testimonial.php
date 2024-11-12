<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;

class Testimonial extends CoreModel
{
    use SoftDeletes;
    protected $table = 'testimonial';
    protected $fillable = [
        'name',
        'profile_image',
        'status',
        'created_by',
        'updated_by',
        'name',
        'profile_image',
        'status',
        'created_by',
        'updated_by',
        'deleted_by'
    ];

    protected $dates = ['deleted_at'];

    public function content()
    {
        return $this->hasOne(TestimonialContent::class);
    }
}
