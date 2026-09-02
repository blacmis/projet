<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CashierNotification;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = CashierNotification::orderByDesc('created_at')->get()->map(function (CashierNotification $n) {
            return (object) [
                'id' => $n->id,
                'title' => $n->title,
                'message' => $n->message,
                'type' => $n->type === 'stock' ? 'warning' : 'info',
                'is_read' => $n->is_read,
                'created_at' => $n->created_at,
            ];
        });

        return view('admin.notifications', compact('notifications'));
    }

    public function markAllRead()
    {
        CashierNotification::where('is_read', false)->update(['is_read' => true]);

        return redirect()->route('admin.notifications')
            ->with('success', 'All notifications marked as read.');
    }
}