<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Feedback;

class FeedbackController extends Controller
{
    public function index()
    {
        $items = Feedback::with(['sender', 'tenant'])->orderByDesc('created_at')->get();

        $stats = (object) [
            'total' => $items->count(),
            'new' => $items->where('status', 'new')->count(),
            'complaints' => $items->where('type', 'complaint')->count(),
            'suggestions' => $items->where('type', 'suggestion')->count(),
        ];

        return view('super-admin.feedback.index', compact('items', 'stats'));
    }

    public function markRead(Feedback $feedback)
    {
        $feedback->update(['status' => 'read']);

        return back()->with('success', 'Marqué comme lu.');
    }
}