<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Lead;

class LeadController extends Controller
{
    public function index()
    {
        $leads = Lead::orderByDesc('created_at')->get();

        return view('super-admin.leads.index', compact('leads'));
    }
}