<?php

namespace App\Http\Controllers\Cashier;

use App\Http\Controllers\Controller;

class NotificationController extends Controller
{
    public function notifications()
    {
        $notifications = collect([
            (object) [
                'id' => 1,
                'title' => 'Payment received',
                'message' => 'Transaction MS-260821-103 was completed for 15,000 FCFA.',
                'type' => 'payment',
                'is_read' => false,
                'created_at' => now()->subMinutes(10),
            ],
            (object) [
                'id' => 2,
                'title' => 'Low stock alert',
                'message' => 'White Flour 25kg is running low.',
                'type' => 'stock',
                'is_read' => true,
                'created_at' => now()->subHours(2),
            ],
        ]);

        return view('cashier.notifications', compact('notifications'));
    }

    public function markNotificationRead($notification)
    {
        return back()->with('success', 'Notification marked as read (données fictives).');
    }

    public function markAllNotificationsRead()
    {
        return back()->with('success', 'All notifications marked as read (données fictives).');
    }
}