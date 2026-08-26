@extends('admin.layouts.app')

@section('title', 'Revenue Report | MarketSmart Admin')

@section('content')
{{-- Stats ligne 1 --}}
<div class="row g-3 mb-3">
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-icon" style="background:#e6f4ea;">💵</div>
            <p class="stat-value">${{ number_format($stats->total_revenue, 2) }}</p>
            <p class="stat-label">Total Revenue</p>
            <p class="stat-sub">This Month</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-icon" style="background:#e8f0fe;">📄</div>
            <p class="stat-value">${{ number_format($stats->today_revenue, 2) }}</p>
            <p class="stat-label">Today's Revenue</p>
            <p class="stat-sub">{{ $stats->today_date }}</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-icon" style="background:#fef7e0;">📊</div>
            <p class="stat-value">${{ number_format($stats->week_revenue, 2) }}</p>
            <p class="stat-label">This Week Revenue</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-icon" style="background:#fef7e0;">👛</div>
            <p class="stat-value">${{ number_format($stats->month_revenue, 2) }}</p>
            <p class="stat-label">This Month Revenue</p>
        </div>
    </div>
</div>

{{-- Stats ligne 2 --}}
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-icon" style="background:#e8f0fe;">🌐</div>
            <p class="stat-value">${{ number_format($stats->year_revenue, 2) }}</p>
            <p class="stat-label">This Year Revenue</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-icon" style="background:#e8f0fe;">📈</div>
            <p class="stat-value">${{ number_format($stats->average_daily, 2) }}</p>
            <p class="stat-label">Average Daily sales</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-icon" style="background:#f3e8fd;">📑</div>
            <p class="stat-value">${{ number_format($stats->gross_profit, 2) }}</p>
            <p class="stat-label">Gross Profit</p>
            <p class="stat-sub">This Month</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-icon" style="background:#e8f0fe;">🧾</div>
            <p class="stat-value">{{ number_format($stats->total_transactions) }}</p>
            <p class="stat-label">Total Transactions</p>
            <p class="stat-sub">This month</p>
        </div>
    </div>
</div>

{{-- Table --}}
<div class="admin-table-wrap">
    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
        <h5 class="mb-0">📈 Revenue Report</h5>
        <form method="GET" action="{{ route('admin.revenue-report') }}" class="d-flex gap-2 flex-wrap align-items-center">
            <select name="payment_method" class="form-select form-select-sm" style="width:auto;" onchange="this.form.submit()">
                <option value="all" {{ request('payment_method') == 'all' || !request('payment_method') ? 'selected' : '' }}>All Methods</option>
                <option value="Cash" {{ request('payment_method') == 'Cash' ? 'selected' : '' }}>Cash</option>
                <option value="Card" {{ request('payment_method') == 'Card' ? 'selected' : '' }}>Card</option>
                <option value="Mobile Money" {{ request('payment_method') == 'Mobile Money' ? 'selected' : '' }}>Mobile Money</option>
            </select>
        </form>
    </div>

    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Date & Time</th>
                    <th>Receipt No.</th>
                    <th>Amount</th>
                    <th>Payment Method</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transactions as $i => $t)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $t->date_time }}</td>
                    <td>{{ $t->receipt_no }}</td>
                    <td>{{ number_format($t->amount) }}</td>
                    <td>{{ $t->payment_method }}</td>
                    <td>
                        <span class="badge-status badge-done">{{ $t->status }}</span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-2">
        <small class="text-muted">1 to {{ $transactions->count() }} of 256</small>
    </div>
</div>
@endsection