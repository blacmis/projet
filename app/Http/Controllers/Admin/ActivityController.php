<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    public function index(Request $request)
    {
        $today = ActivityLog::whereDate('created_at', today());

        $stats = (object) [
            'total_activities' => (clone $today)->count(),
            'inventory_activities' => (clone $today)->where('activity_type', 'stock')->count(),
            'sales_activities' => (clone $today)->where('activity_type', 'sales')->count(),
            'user_logins' => (clone $today)->where('activity_type', 'login')->count(),
            'failed_attempts' => (clone $today)->where('activity_type', 'failed_login')->count(),
            'system_changes' => (clone $today)->where('activity_type', 'system')->count(),
        ];

        $query = ActivityLog::orderByDesc('created_at');

        if ($request->filled('user') && $request->user !== 'all') {
            $query->where('user_name', 'like', "%{$request->user}%");
        }

        if ($request->filled('activity') && $request->activity !== 'all') {
            $query->where('action', $request->activity);
        }

        $activities = $query->take(100)->get()->map(fn ($a) => (object) [
            'date_time' => $a->created_at->format('d-m-Y h:iA'),
            'user' => $a->user_name,
            'role' => $a->role,
            'activity' => $a->action,
            'details' => $a->details,
            'reference_id' => $a->reference_id,
            'ip' => $a->ip_address,
        ]);

        return view('admin.activities', compact('stats', 'activities'));
    }
}