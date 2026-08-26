<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class NotificationController extends Controller
{
    public function index()
    {
        $allRead = session('admin_notifications_all_read', false);

        $notifications = collect([
            (object) [
                'id' => 1,
                'title' => 'Low stock alert',
                'message' => 'Rice 50kg is below minimum stock level (30 remaining).',
                'type' => 'warning',
                'is_read' => $allRead,
                'created_at' => now()->subMinutes(10),
            ],
            (object) [
                'id' => 2,
                'title' => 'Product expiring soon',
                'message' => 'Coca-Cola 1L (Batch #346555) expires in 2 days.',
                'type' => 'expiry',
                'is_read' => $allRead,
                'created_at' => now()->subHours(1),
            ],
            (object) [
                'id' => 3,
                'title' => 'Daily sales summary',
                'message' => 'Today\'s revenue reached 4,769,000 FCFA with 96 sales.',
                'type' => 'info',
                'is_read' => true,
                'created_at' => now()->subHours(3),
            ],
            (object) [
                'id' => 4,
                'title' => 'Failed login attempt',
                'message' => '2 failed login attempts detected on cashier terminal.',
                'type' => 'danger',
                'is_read' => true,
                'created_at' => now()->subHours(5),
            ],
        ]);

        return view('admin.notifications', compact('notifications'));
    }

    public function markAllRead()
    {
        session(['admin_notifications_all_read' => true]);

        return redirect()->route('admin.notifications')
            ->with('success', 'All notifications marked as read.');
    }
}