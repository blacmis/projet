<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
class AuditLogController extends Controller
{
    public static function log(string $action, string $details = ''): void
    {
        $logs = session('admin_audit_log', []);
        array_unshift($logs, [
            'id' => count($logs) + 1,
            'user' => session('auth_user', 'admin'),
            'action' => $action,
            'details' => $details,
            'at' => now()->format('d/m/Y H:i:s'),
        ]);
        // garder les 100 dernières
        session(['admin_audit_log' => array_slice($logs, 0, 100)]);
    }
    public function index(Request $request)
    {
        $logs = collect(session('admin_audit_log', []));
        if ($request->filled('q')) {
            $q = strtolower($request->q);
            $logs = $logs->filter(function ($l) use ($q) {
                return str_contains(strtolower($l['action']), $q)
                    || str_contains(strtolower($l['details']), $q)
                    || str_contains(strtolower($l['user']), $q);
            })->values();
        }
        return view('admin.audit-log.index', [
            'logs' => $logs,
        ]);
    }
    public function clear()
    {
        session()->forget('admin_audit_log');
        return back()->with('success', 'Journal vidé.');
    }
}