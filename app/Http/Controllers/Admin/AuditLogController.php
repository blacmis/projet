<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class AuditLogController extends Controller
{
    public static function log(string $action, string $details = ''): void
    {
        ActivityLog::record('system', $action, $details);
    }

    public function index(Request $request)
    {
        $query = ActivityLog::orderByDesc('created_at');

        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($sub) use ($q) {
                $sub->where('action', 'like', "%{$q}%")
                    ->orWhere('details', 'like', "%{$q}%")
                    ->orWhere('user_name', 'like', "%{$q}%");
            });
        }

        $logs = $query->get()->map(fn ($l) => [
            'at' => $l->created_at->format('d/m/Y H:i:s'),
            'user' => $l->user_name,
            'action' => $l->action,
            'details' => $l->details,
        ]);

        return view('admin.audit-log.index', compact('logs'));
    }

    public function clear()
    {
        ActivityLog::truncate();

        return back()->with('success', 'Journal vidé.');
    }
}