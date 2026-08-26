@extends('admin.layouts.app')

@section('title', 'Expiry Report | MarketSmart Admin')

@section('content')
{{-- Stats --}}
<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="stat-card">
            <div class="stat-icon" style="background:#e8f0fe;">🌐</div>
            <p class="stat-value">{{ number_format($stats->total_products) }}</p>
            <p class="stat-label">Total Products</p>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card">
            <div class="stat-icon" style="background:#e6f4ea;">📋</div>
            <p class="stat-value">{{ number_format($stats->available_products) }}</p>
            <p class="stat-label">Available Product</p>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card">
            <div class="stat-icon" style="background:#fef7e0;">📋</div>
            <p class="stat-value">{{ $stats->unavailable_products }}</p>
            <p class="stat-label">Unavailable Product</p>
        </div>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="stat-card">
            <div class="stat-icon" style="background:#fce8e6;">⚠️</div>
            <p class="stat-value">{{ $stats->low_stock }}</p>
            <p class="stat-label">Low-Stock Product</p>
            <p class="stat-sub warn">Needs Attention</p>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card">
            <div class="stat-icon" style="background:#e8f0fe;">📝</div>
            <p class="stat-value">{{ $stats->expiring_soon }}</p>
            <p class="stat-label">Products Expiring Soon</p>
            <p class="stat-sub">within 7 days</p>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card">
            <div class="stat-icon" style="background:#fce8e6;">⏰</div>
            <p class="stat-value">{{ $stats->expired }}</p>
            <p class="stat-label">Expired Product</p>
            <p class="stat-sub danger">Needs Action</p>
        </div>
    </div>
</div>

{{-- Table --}}
<div class="admin-table-wrap">
    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
        <h5 class="mb-0">📋 Expiry Report</h5>
        <form method="GET" action="{{ route('admin.expiry-report') }}" class="d-flex gap-2 flex-wrap align-items-center">
            <select name="category" class="form-select form-select-sm" style="width:auto;" onchange="this.form.submit()">
                <option value="all" {{ request('category') == 'all' || !request('category') ? 'selected' : '' }}>All Categories</option>
                <option value="Beverage" {{ request('category') == 'Beverage' ? 'selected' : '' }}>Beverage</option>
                <option value="Grains" {{ request('category') == 'Grains' ? 'selected' : '' }}>Grains</option>
                <option value="Household" {{ request('category') == 'Household' ? 'selected' : '' }}>Household</option>
                <option value="Groceries" {{ request('category') == 'Groceries' ? 'selected' : '' }}>Groceries</option>
            </select>

            <select name="status" class="form-select form-select-sm" style="width:auto;" onchange="this.form.submit()">
                <option value="all" {{ request('status') == 'all' || !request('status') ? 'selected' : '' }}>All Status</option>
                <option value="Expiring Soon" {{ request('status') == 'Expiring Soon' ? 'selected' : '' }}>Expiring Soon</option>
                <option value="Out-Of-Stock" {{ request('status') == 'Out-Of-Stock' ? 'selected' : '' }}>Out-Of-Stock</option>
                <option value="Within 30days" {{ request('status') == 'Within 30days' ? 'selected' : '' }}>Within 30days</option>
            </select>
        </form>
    </div>

    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Product Code</th>
                    <th>Product Name</th>
                    <th>Category</th>
                    <th>Batch No.</th>
                    <th>Unit Price</th>
                    <th>Quantity</th>
                    <th>Expiry Date</th>
                    <th>Days Left</th>
                    <th>Total Value</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($items as $i => $item)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $item->product_code }}</td>
                    <td>{{ $item->product_name }}</td>
                    <td>{{ $item->category }}</td>
                    <td>{{ $item->batch_no }}</td>
                    <td>{{ number_format($item->unit_price) }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ $item->expiry_date }}</td>
                    <td>{{ $item->days_left }}</td>
                    <td>{{ number_format($item->total_value) }}</td>
                    <td>
                        @if($item->status === 'Expiring Soon')
                            <span class="badge-status badge-low">Expiring Soon</span>
                        @elseif($item->status === 'Out-Of-Stock')
                            <span class="badge-status badge-out">Out-Of-Stock</span>
                        @else
                            <span class="badge-status badge-good">Within 30days</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-2">
        <small class="text-muted">Showing 1 to {{ $items->count() }} of 1,245 items</small>
    </div>
</div>
@endsection