@extends('admin.layouts.app')

@section('title', 'Cashier | MarketSmart Admin')

@section('content')
{{-- Stats --}}
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-icon" style="background:#e6f4ea;">🛒</div>
            <p class="stat-value">{{ $stats->today_sales }}</p>
            <p class="stat-label">Today's Sales</p>
            <p class="stat-sub up">{{ $stats->today_sales_change }}</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-icon" style="background:#e6f4ea;">💰</div>
            <p class="stat-value">{{ number_format($stats->today_revenue) }}</p>
            <p class="stat-label">Today's Revenue</p>
            <p class="stat-sub up">{{ $stats->today_revenue_change }}</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-icon" style="background:#e8f0fe;">🧾</div>
            <p class="stat-value">{{ $stats->transactions }}</p>
            <p class="stat-label">Transactions</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-icon" style="background:#fef7e0;">🛍️</div>
            <p class="stat-value">{{ $stats->transactions }}</p>
            <p class="stat-label">Transactions</p>
        </div>
    </div>
</div>

{{-- Product Search --}}
<div class="admin-table-wrap mb-4">
    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
        <h5 class="mb-0">Product Search</h5>
        <div class="d-flex gap-2 flex-wrap">
            <form method="GET" action="{{ route('admin.cashier') }}" class="d-flex gap-2 align-items-center">
                <input type="text"
                    name="q"
                    value="{{ request('q') }}"
                    class="form-control form-control-sm"
                    placeholder="search by name or code"
                    style="width:200px;">
                <button type="submit" class="btn btn-sm" style="background:#c47a1a;color:#fff;">
                    Search
                </button>
            </form>
            <input type="text" class="form-control form-control-sm" placeholder="search by name or code" style="width:180px;">
        </div>
    </div>

    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Product Code</th>
                    <th>Product Name</th>
                    <th>Category</th>
                    <th>Available Stock</th>
                    <th>Sold Stock</th>
                    <th>Min. Stock Level</th>
                    <th>Expiry Date</th>
                    <th>Unit Price (FCFA)</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $i => $p)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $p->product_code }}</td>
                    <td>{{ $p->product_name }}</td>
                    <td>{{ $p->category }}</td>
                    <td>{{ $p->available_stock }}</td>
                    <td>{{ $p->sold_stock }}</td>
                    <td>{{ $p->min_stock }}</td>
                    <td>{{ $p->expiry_date }}</td>
                    <td>{{ number_format($p->unit_price) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-2">
        <small class="text-muted">Showing 1 to {{ $products->count() }} out of 1,245 products</small>
    </div>
</div>

{{-- Recent Sales --}}
<div class="admin-table-wrap">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="mb-0">Recent Sales</h5>
        <a href="{{ route('admin.sale-report') }}" class="btn btn-sm btn-outline-secondary">View all</a>
    </div>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>Receipt No.</th>
                    <th>Time</th>
                    <th>Items</th>
                    <th>Amount</th>
                    <th>Payment Method</th>
                </tr>
            </thead>
            <tbody>
                @foreach($recentSales as $sale)
                <tr>
                    <td>{{ $sale->receipt_no }}</td>
                    <td>{{ $sale->time }}</td>
                    <td>{{ $sale->items }}</td>
                    <td>{{ number_format($sale->amount) }}</td>
                    <td>{{ $sale->payment_method }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection