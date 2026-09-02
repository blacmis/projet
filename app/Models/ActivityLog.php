<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    protected $fillable = [
        'user_name', 'role', 'activity_type', 'action', 'details', 'reference_id', 'ip_address',
    ];

    public static function record(string $activityType, string $action, string $details = '', ?string $referenceId = null): void
    {
        static::create([
            'user_name' => session('auth_user', 'System'),
            'role' => session('auth_role') ? ucfirst(session('auth_role')) : 'System',
            'activity_type' => $activityType,
            'action' => $action,
            'details' => $details,
            'reference_id' => $referenceId,
            'ip_address' => request()->ip(),
        ]);
    }

    public static function recordFailedLogin(string $email): void
    {
        static::create([
            'user_name' => $email,
            'role' => 'Unknown',
            'activity_type' => 'failed_login',
            'action' => 'Failed Login',
            'details' => 'Invalid credentials attempt',
            'ip_address' => request()->ip(),
        ]);
    }
}