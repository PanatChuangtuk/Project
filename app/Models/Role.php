<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    use SoftDeletes;

    protected $table = 'roles';

    protected $fillable = [
        'name',
        'user_count',
        'updated_at',
        'deleted_at',
    ];

    public function users()
    {
        return $this->hasMany(User::class, 'role_id', 'id');
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'role_permission', 'role_id', 'permission_id');
    }

    public function updateUserCount()
    {
        $this->user_count = $this->users()->count();
        $this->save();
    }
}
