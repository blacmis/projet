<?php

namespace App\Http\Controllers\Cashier;

use App\Http\Controllers\Controller;
use App\Models\CashierNotification;

class NotificationController extends Controller
{
    public function notifications()
    {
        $notifications = CashierNotification::orderByDesc('created_at')->get();

        return view('cashier.notifications', compact('notifications'));
    }

    public function markNotificationRead($notification)
    {
        $notif = CashierNotification::find($notification);

        if ($notif) {
            $notif->update(['is_read' => true]);
        }

        return back()->with('success', 'Notification marked as read.');
    }

    public function markAllNotificationsRead()
    {
        CashierNotification::where('is_read', false)->update(['is_read' => true]);

        return back()->with('success', 'All notifications marked as read.');
    }
}