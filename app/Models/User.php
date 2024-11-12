<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'deleted_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function ($user) {
            if ($user->role_id) {
                $role = Role::find($user->role_id);
                if ($role) {
                    $role->increment('user_count');
                }
            }
        });

        static::deleting(function ($user) {
            if ($user->role_id) {
                $role = Role::find($user->role_id);
                if ($role) {
                    $role->decrement('user_count');
                }
            }
        });

        static::updating(function ($user) {
            if ($user->isDirty('role_id')) {
                $oldRole = Role::find($user->getOriginal('role_id'));
                if ($oldRole) {
                    $oldRole->decrement('user_count');
                }

                $newRole = Role::find($user->role_id);
                if ($newRole) {
                    $newRole->increment('user_count');
                }
            }
        });
    }
}

