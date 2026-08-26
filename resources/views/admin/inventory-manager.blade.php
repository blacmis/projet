@extends('admin.layouts.app')

@section('title', 'Inventory Manager | MarketSmart Admin')

@section('content')
{{-- Stats du haut --}}
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

{{-- Table Inventory Overview --}}
<div class="admin-table-wrap">
    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
        <h5 class="mb-0">📋 Inventory Overview</h5>
        <div class="d-flex gap-2">
            <form method="GET" action="{{ route('admin.inventory-manager') }}" class="d-flex gap-2">
                <select name="category" class="form-select form-select-sm" style="width:auto;" onchange="this.form.submit()">
                    <option value="all" {{ request('category') == 'all' || !request('category') ? 'selected' : '' }}>All Categories</option>
                    <option value="beverages" {{ request('category') == 'beverages' ? 'selected' : '' }}>beverages</option>
                    <option value="grains" {{ request('category') == 'grains' ? 'selected' : '' }}>grains</option>
                    <option value="bakery" {{ request('category') == 'bakery' ? 'selected' : '' }}>bakery</option>
                </select>
                <select name="status" class="form-select form-select-sm" style="width:auto;" onchange="this.form.submit()">
                    <option value="all" {{ request('status') == 'all' || !request('status') ? 'selected' : '' }}>All Status</option>
                    <option value="Good" {{ request('status') == 'Good' ? 'selected' : '' }}>Good</option>
                    <option value="Low Stock" {{ request('status') == 'Low Stock' ? 'selected' : '' }}>Low Stock</option>
                    <option value="Out of Stock" {{ request('status') == 'Out of Stock' ? 'selected' : '' }}>Out of Stock</option>
                </select>
            </form>
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
                    <th>Status</th>
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
                    <td>
                        @if($p->status === 'Good')
                            <span class="badge-status badge-good">Good</span>
                        @elseif($p->status === 'Low Stock')
                            <span class="badge-status badge-low">Low Stock</span>
                        @else
                            <span class="badge-status badge-out">Out of Stock</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-between align-items-center mt-3">
        <small class="text-muted">Showing 1 to {{ $products->count() }} of 1,245 products</small>
        <div>
            <button class="btn btn-sm btn-light" disabled>&lt;</button>
            <button class="btn btn-sm" style="background:#c47a1a;color:#fff;">1</button>
            <button class="btn btn-sm btn-light" disabled>&gt;</button>
        </div>
    </div>
</div>
@endsection