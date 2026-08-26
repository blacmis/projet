@extends('admin.layouts.app')

@section('title', 'Stock Report | MarketSmart Admin')

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

{{-- Stock Summary --}}
<div class="admin-table-wrap mb-4">
    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
        <h5 class="mb-0">Stock Summary</h5>
        <form method="GET" action="{{ route('admin.stock-report') }}" class="d-flex gap-2 flex-wrap align-items-center">
            <select name="category" class="form-select form-select-sm" style="width:auto;" onchange="this.form.submit()">
                <option value="all" {{ request('category') == 'all' || !request('category') ? 'selected' : '' }}>All Categories</option>
                <option value="Groceries" {{ request('category') == 'Groceries' ? 'selected' : '' }}>Groceries</option>
                <option value="Beverages" {{ request('category') == 'Beverages' ? 'selected' : '' }}>Beverages</option>
                <option value="Dairy" {{ request('category') == 'Dairy' ? 'selected' : '' }}>Dairy</option>
                <option value="Health & Beauty" {{ request('category') == 'Health & Beauty' ? 'selected' : '' }}>Health & Beauty</option>
                <option value="Household" {{ request('category') == 'Household' ? 'selected' : '' }}>Household</option>
            </select>

            <select name="status" class="form-select form-select-sm" style="width:auto;" onchange="this.form.submit()">
                <option value="all" {{ request('status') == 'all' || !request('status') ? 'selected' : '' }}>All Status</option>
                <option value="In Stock" {{ request('status') == 'In Stock' ? 'selected' : '' }}>In Stock</option>
                <option value="Low Stock" {{ request('status') == 'Low Stock' ? 'selected' : '' }}>Low Stock</option>
            </select>
        </form>
    </div>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Category</th>
                    <th>Total Products</th>
                    <th>Available Stock (Qty)</th>
                    <th>Sold Stock (Qty)</th>
                    <th>Stock Value (Available)</th>
                    <th>Stock Value (Sold)</th>
                    <th>Stock Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($summary as $i => $row)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $row->category }}</td>
                    <td>{{ $row->total_products }}</td>
                    <td>{{ number_format($row->available_stock) }}</td>
                    <td>{{ number_format($row->sold_stock) }}</td>
                    <td>${{ number_format($row->stock_value_available) }}</td>
                    <td>${{ number_format($row->stock_value_sold) }}</td>
                    <td>
                        @if($row->status === 'In Stock')
                            <span class="badge-status badge-good">In Stock</span>
                        @else
                            <span class="badge-status badge-low">Low Stock</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

{{-- Top 5 --}}
<div class="row g-3">
    <div class="col-md-6">
        <div class="admin-table-wrap">
            <h6 class="mb-3">Top 5 Products by Available Stock</h6>
            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Product code</th>
                            <th>Product Name</th>
                            <th>Category</th>
                            <th>Available Stock (Qty)</th>
                            <th>Unit Price</th>
                            <th>Stock Value</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($topAvailable as $i => $p)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td>{{ $p->code }}</td>
                            <td>{{ $p->name }}</td>
                            <td>{{ $p->category }}</td>
                            <td>{{ $p->qty }}</td>
                            <td>{{ number_format($p->unit_price) }}</td>
                            <td>{{ number_format($p->stock_value) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="admin-table-wrap">
            <h6 class="mb-3">Top 5 Products by Sold Stock</h6>
            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Product code</th>
                            <th>Product Name</th>
                            <th>Category</th>
                            <th>Sold Stock (Qty)</th>
                            <th>Unit Price</th>
                            <th>Total Sales Value</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($topSold as $i => $p)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td>{{ $p->code }}</td>
                            <td>{{ $p->name }}</td>
                            <td>{{ $p->category }}</td>
                            <td>{{ $p->qty }}</td>
                            <td>{{ number_format($p->unit_price) }}</td>
                            <td>{{ number_format($p->total_sales) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection