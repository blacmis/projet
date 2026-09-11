<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Tenant;

class DashboardController extends Controller
{
    public function index()
    {
        $tenants = Tenant::orderByDesc('created_at')->get();

        $stats = (object) [
            'total' => $tenants->count(),
            'active' => $tenants->where('status', 'active')->count(),
            'pending' => $tenants->where('status', 'pending')->count(),
            'suspended' => $tenants->where('status', 'suspended')->count(),
        ];

        return view('super-admin.dashboard', compact('tenants', 'stats'));
    }
}