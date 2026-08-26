<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    public function index(Request $request)
    {
        $stats = (object) [
            'total_activities' => 128,
            'inventory_activities' => 95,
            'sales_activities' => 123,
            'user_logins' => 5,
            'failed_attempts' => 2,
            'system_changes' => 1,
        ];

        $activities = collect([
            (object) ['date_time' => '30-07-2026 12:00PM', 'user' => 'Hillman', 'role' => 'Inventory', 'activity' => 'Stock Received', 'details' => '250 Items Received', 'reference_id' => 'STK- REC - 00123', 'ip' => '192.168.1.12'],
            (object) ['date_time' => '30-07-2026 12:02PM', 'user' => 'Ange', 'role' => 'Cashier', 'activity' => 'Sales Completed', 'details' => 'Receipt #RCPT-0048021', 'reference_id' => 'RCPT-0048021', 'ip' => '192.168.1.10'],
            (object) ['date_time' => '30-07-2026 12:05PM', 'user' => 'System', 'role' => 'System', 'activity' => 'User Login', 'details' => 'Manager login', 'reference_id' => 'LOGIN-00125', 'ip' => '192.168.1.5'],
            (object) ['date_time' => '30-07-2026 12:10PM', 'user' => 'Ange', 'role' => 'Cashier', 'activity' => 'Sales Completed', 'details' => 'Receipt #RCPT-0048010', 'reference_id' => 'RCPT-0048010', 'ip' => '192.168.1.10'],
            (object) ['date_time' => '30-07-2026 12:15PM', 'user' => 'Ange', 'role' => 'Cashier', 'activity' => 'Sales Completed', 'details' => 'Receipt #RCPT-0048005', 'reference_id' => 'RCPT-0048005', 'ip' => '192.168.1.10'],
        ]);

        if ($request->filled('user') && $request->user !== 'all') {
            $activities = $activities->where('user', $request->user)->values();
        }
        if ($request->filled('activity') && $request->activity !== 'all') {
            $activities = $activities->where('activity', $request->activity)->values();
        }

        return view('admin.activities', compact('stats', 'activities'));
    }
}