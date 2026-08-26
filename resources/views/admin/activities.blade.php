@extends('admin.layouts.app')

@section('title', 'Activities Monitoring | MarketSmart Admin')

@section('content')
{{-- Stats --}}
<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="stat-card">
            <div class="stat-icon" style="background:#e8f0fe;">📅</div>
            <p class="stat-value">{{ $stats->total_activities }}</p>
            <p class="stat-label">Total Activities</p>
            <p class="stat-sub">Today</p>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card">
            <div class="stat-icon" style="background:#fef7e0;">📦</div>
            <p class="stat-value">{{ $stats->inventory_activities }}</p>
            <p class="stat-label">Inventory Activities</p>
            <p class="stat-sub">Today</p>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card">
            <div class="stat-icon" style="background:#e6f4ea;">🛒</div>
            <p class="stat-value">{{ $stats->sales_activities }}</p>
            <p class="stat-label">Sales Activities</p>
            <p class="stat-sub">Today</p>
        </div>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="stat-card">
            <div class="stat-icon" style="background:#e8f0fe;">👤</div>
            <p class="stat-value">{{ $stats->user_logins }}</p>
            <p class="stat-label">User Logins</p>
            <p class="stat-sub">Today</p>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card">
            <div class="stat-icon" style="background:#fce8e6;">⚠️</div>
            <p class="stat-value">{{ $stats->failed_attempts }}</p>
            <p class="stat-label">Failed Attempt</p>
            <p class="stat-sub">Today</p>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card">
            <div class="stat-icon" style="background:#e8f0fe;">⚙️</div>
            <p class="stat-value">{{ $stats->system_changes }}</p>
            <p class="stat-label">System Changes</p>
            <p class="stat-sub">Today</p>
        </div>
    </div>
</div>

{{-- Table --}}
<div class="admin-table-wrap">
    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
        <h5 class="mb-0">Recent Activities</h5>
        <form method="GET" action="{{ route('admin.activities') }}" class="d-flex gap-2 flex-wrap align-items-center">
            <select name="user" class="form-select form-select-sm" style="width:auto;">
                <option value="all" {{ request('user') == 'all' || !request('user') ? 'selected' : '' }}>All Users</option>
                <option value="Hillman" {{ request('user') == 'Hillman' ? 'selected' : '' }}>Hillman</option>
                <option value="Ange" {{ request('user') == 'Ange' ? 'selected' : '' }}>Ange</option>
                <option value="System" {{ request('user') == 'System' ? 'selected' : '' }}>System</option>
            </select>

            <select name="activity" class="form-select form-select-sm" style="width:auto;">
                <option value="all" {{ request('activity') == 'all' || !request('activity') ? 'selected' : '' }}>All Activities</option>
                <option value="Stock Received" {{ request('activity') == 'Stock Received' ? 'selected' : '' }}>Stock Received</option>
                <option value="Sales Completed" {{ request('activity') == 'Sales Completed' ? 'selected' : '' }}>Sales Completed</option>
                <option value="User Login" {{ request('activity') == 'User Login' ? 'selected' : '' }}>User Login</option>
            </select>

            <button type="submit" class="btn btn-sm" style="background:#c47a1a;color:#fff;">
                Filter
            </button>
        </form>
    </div>

    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Date & Time</th>
                    <th>User</th>
                    <th>Role</th>
                    <th>Activity</th>
                    <th>Details</th>
                    <th>Reference ID</th>
                    <th>IP address</th>
                </tr>
            </thead>
            <tbody>
                @foreach($activities as $i => $a)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $a->date_time }}</td>
                    <td>{{ $a->user }}</td>
                    <td>
                        @if($a->role === 'Cashier')
                            <span class="badge-status badge-done">{{ $a->role }}</span>
                        @elseif($a->role === 'Inventory')
                            <span class="badge-status badge-low">{{ $a->role }}</span>
                        @else
                            <span class="badge-status" style="background:#e9ecef;color:#495057;">{{ $a->role }}</span>
                        @endif
                    </td>
                    <td>
                        @if($a->activity === 'Sales Completed')
                            <span class="badge-status badge-done">{{ $a->activity }}</span>
                        @elseif($a->activity === 'Stock Received')
                            <span class="badge-status badge-good">{{ $a->activity }}</span>
                        @else
                            <span class="badge-status badge-low">{{ $a->activity }}</span>
                        @endif
                    </td>
                    <td>{{ $a->details }}</td>
                    <td>{{ $a->reference_id }}</td>
                    <td>{{ $a->ip }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-2">
        <small class="text-muted">1 to {{ $activities->count() }} of 256</small>
    </div>
</div>
@endsection