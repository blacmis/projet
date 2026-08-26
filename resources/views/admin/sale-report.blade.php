@extends('admin.layouts.app')

@section('title', 'Sale Report | MarketSmart Admin')

@section('content')
{{-- Stats --}}
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-icon" style="background:#e8f0fe;">🧾</div>
            <p class="stat-value">{{ number_format($stats->total_sales) }}</p>
            <p class="stat-label">Total Sales</p>
            <p class="stat-sub">This Month</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-icon" style="background:#e6f4ea;">💰</div>
            <p class="stat-value">{{ number_format($stats->total_revenue) }}</p>
            <p class="stat-label">Total Revenue</p>
            <p class="stat-sub">This Month</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-icon" style="background:#e8f0fe;">📄</div>
            <p class="stat-value">{{ number_format($stats->total_transactions) }}</p>
            <p class="stat-label">Total Transactions</p>
            <p class="stat-sub">This Month</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-icon" style="background:#fef7e0;">🛒</div>
            <p class="stat-value">{{ number_format($stats->items_sold) }}</p>
            <p class="stat-label">Items Sold</p>
            <p class="stat-sub">This Month</p>
        </div>
    </div>
</div>

{{-- Table --}}
<div class="admin-table-wrap">
    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
        <h5 class="mb-0">Recent Activities</h5>
        <div class="d-flex gap-2 flex-wrap">
            <form method="GET" action="{{ route('admin.sale-report') }}" class="d-flex gap-2">
                <select name="payment_method" class="form-select form-select-sm" style="width:auto;" onchange="this.form.submit()">
                    <option value="all">All Method</option>
                    <option value="Cash" {{ request('payment_method') == 'Cash' ? 'selected' : '' }}>Cash</option>
                    <option value="Card" {{ request('payment_method') == 'Card' ? 'selected' : '' }}>Card</option>
                    <option value="Mobile Money" {{ request('payment_method') == 'Mobile Money' ? 'selected' : '' }}>Mobile Money</option>
                </select>
            </form>
        </div>
    </div>

    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Date & Time</th>
                    <th>Receipt No.</th>
                    <th>Items</th>
                    <th>Amount</th>
                    <th>Payment Method</th>
                </tr>
            </thead>
            <tbody>
                @foreach($sales as $i => $s)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $s->date_time }}</td>
                    <td>{{ $s->receipt_no }}</td>
                    <td>{{ $s->items }}</td>
                    <td>{{ number_format($s->amount) }}</td>
                    <td>{{ $s->payment_method }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-2">
        <small class="text-muted">1 to {{ $sales->count() }} of 256</small>
    </div>
</div>
@endsection