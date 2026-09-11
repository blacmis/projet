<?php

namespace App\Models;

use App\Concerns\BelongsToTenant;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use HasFactory;
    use BelongsToTenant;

    protected $fillable = [
        'tenant_id', 'name', 'email', 'phone', 'department', 'password', 'role', 'status', 'photo',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'password' => 'hashed',
    ];
}