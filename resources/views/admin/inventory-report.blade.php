@extends('admin.layouts.app')

@section('title', 'Inventory Report | MarketSmart Admin')

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
        <h5 class="mb-0">📋 Inventory Report</h5>
        <form method="GET" action="{{ route('admin.inventory-report') }}" class="d-flex gap-2 flex-wrap align-items-center">
            <select name="category" class="form-select form-select-sm" style="width:auto;" onchange="this.form.submit()">
                <option value="all" {{ request('category') == 'all' || !request('category') ? 'selected' : '' }}>All Categories</option>
                <option value="Beverage" {{ request('category') == 'Beverage' ? 'selected' : '' }}>Beverage</option>
                <option value="Grains" {{ request('category') == 'Grains' ? 'selected' : '' }}>Grains</option>
                <option value="Household" {{ request('category') == 'Household' ? 'selected' : '' }}>Household</option>
                <option value="Groceries" {{ request('category') == 'Groceries' ? 'selected' : '' }}>Groceries</option>
            </select>

            <select name="supplier" class="form-select form-select-sm" style="width:auto;" onchange="this.form.submit()">
                <option value="all" {{ request('supplier') == 'all' || !request('supplier') ? 'selected' : '' }}>All Suppliers</option>
                <option value="ABC Foods Ltd" {{ request('supplier') == 'ABC Foods Ltd' ? 'selected' : '' }}>ABC Foods Ltd</option>
                <option value="Hilton Foods" {{ request('supplier') == 'Hilton Foods' ? 'selected' : '' }}>Hilton Foods</option>
                <option value="Jasmine Food" {{ request('supplier') == 'Jasmine Food' ? 'selected' : '' }}>Jasmine Food</option>
                <option value="Detol Ltd" {{ request('supplier') == 'Detol Ltd' ? 'selected' : '' }}>Detol Ltd</option>
                <option value="Chang Farmers Ltd" {{ request('supplier') == 'Chang Farmers Ltd' ? 'selected' : '' }}>Chang Farmers Ltd</option>
            </select>

            <select name="status" class="form-select form-select-sm" style="width:auto;" onchange="this.form.submit()">
                <option value="all" {{ request('status') == 'all' || !request('status') ? 'selected' : '' }}>All Status</option>
                <option value="In Stock" {{ request('status') == 'In Stock' ? 'selected' : '' }}>In Stock</option>
                <option value="Low Stock" {{ request('status') == 'Low Stock' ? 'selected' : '' }}>Low Stock</option>
                <option value="Out-Of-Stock" {{ request('status') == 'Out-Of-Stock' ? 'selected' : '' }}>Out-Of-Stock</option>
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
                    <th>Date</th>
                    <th>Unit Price</th>
                    <th>Total Stock</th>
                    <th>Sold Stock</th>
                    <th>Available Stock</th>
                    <th>Status</th>
                    <th>Expiry Date</th>
                    <th>Inventory Value</th>
                    <th>Supplier</th>
                </tr>
            </thead>
            <tbody>
                @foreach($items as $i => $item)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $item->product_code }}</td>
                    <td>{{ $item->product_name }}</td>
                    <td>{{ $item->category }}</td>
                    <td>{{ $item->date }}</td>
                    <td>{{ number_format($item->unit_price) }}</td>
                    <td>{{ $item->total_stock }}</td>
                    <td>{{ $item->sold_stock }}</td>
                    <td>{{ $item->available_stock }}</td>
                    <td>
                        @if($item->status === 'In Stock')
                            <span class="badge-status badge-good">In Stock</span>
                        @elseif($item->status === 'Low Stock')
                            <span class="badge-status badge-low">Low Stock</span>
                        @else
                            <span class="badge-status badge-out">Out-Of-Stock</span>
                        @endif
                    </td>
                    <td>{{ $item->expiry_date }}</td>
                    <td>{{ number_format($item->inventory_value) }}</td>
                    <td>{{ $item->supplier }}</td>
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