@extends('admin.layouts.app')

@section('title', 'Dashboard | MarketSmart Admin')

@section('content')
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-icon" style="background:#e8f0fe;">📦</div>
            <p class="stat-value">{{ number_format($stats->total_products) }}</p>
            <p class="stat-label">Total Products</p>
            <p class="stat-sub">All products in the system</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-icon" style="background:#e6f4ea;">🛒</div>
            <p class="stat-value">{{ number_format($stats->available_products) }}</p>
            <p class="stat-label">Available Product</p>
            <p class="stat-sub">Products currently in stock</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-icon" style="background:#fef7e0;">📋</div>
            <p class="stat-value">{{ number_format($stats->unavailable_products) }}</p>
            <p class="stat-label">Unavailable Product</p>
            <p class="stat-sub">Products not available</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-icon" style="background:#f3e8fd;">📊</div>
            <p class="stat-value">{{ number_format($stats->today_sales) }}</p>
            <p class="stat-label">Today's Sales</p>
            <p class="stat-sub up">{{ $stats->today_sales_change }}</p>
        </div>
    </div>
</div>

<div class="row g-3">
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
            <div class="stat-icon" style="background:#fce8e6;">⚠️</div>
            <p class="stat-value">{{ $stats->low_stock }}</p>
            <p class="stat-label">Low-Stock Product</p>
            <p class="stat-sub warn">Needs Attention</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-icon" style="background:#e8f0fe;">⏰</div>
            <p class="stat-value">{{ $stats->expiring_soon }}</p>
            <p class="stat-label">Products Expiring Soon</p>
            <p class="stat-sub">within 7 days</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-icon" style="background:#fce8e6;">🚨</div>
            <p class="stat-value">{{ $stats->expired }}</p>
            <p class="stat-label">Expired Product</p>
            <p class="stat-sub danger">Needs Action</p>
        </div>
    </div>
</div>
@endsection