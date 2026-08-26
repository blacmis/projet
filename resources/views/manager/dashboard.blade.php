@extends('manager.layouts.app')
@section('title', 'Dashboard - MarketSmart')
@section('content')
    {{-- En-tête de la page --}}
    <div class="page-header">
        <div>
            <h4 class="page-title">Inventory Manager</h4>
            <p class="page-subtitle">Welcome back, John Doe</p>
        </div>
        <div class="d-flex align-items-center gap-3">
            <div class="search-box">
                <i class="bi bi-search"></i>
                <input type="text" class="form-control" placeholder="Search anything...">
            </div>
            <button class="btn btn-outline-secondary">
                <i class="bi bi-bell"></i>
            </button>
        </div>
    </div>
    {{-- Cartes de statistiques --}}
    <div class="row g-3 mb-4">
        {{-- Low Stock --}}
        <div class="col-md-3">
            <div class="stat-card d-flex align-items-center gap-3">
                <div class="stat-icon bg-primary bg-opacity-10 text-primary">
                  🛒 <i class="bi bi-exclamation-triangle"></i>
                </div>
                <div>
                    <h3 class="mb-0 fw-bold">28</h3>
                    <small class="text-muted">Low Stock Items</small>
                </div>
            </div>
        </div>
        {{-- Expiring Soon --}}
        <div class="col-md-3">
            <div class="stat-card d-flex align-items-center gap-3">
                <div class="stat-icon bg-warning bg-opacity-10 text-warning">
                   ⚠️ <i class="bi bi-clock-history"></i>
                </div>
                <div>
                    <h3 class="mb-0 fw-bold">15</h3>
                    <small class="text-muted">Products Expiring Soon</small>
                </div>
            </div>
        </div>
        {{-- Expired --}}
        <div class="col-md-3">
            <div class="stat-card d-flex align-items-center gap-3">
                <div class="stat-icon bg-danger bg-opacity-10 text-danger">
                   🚨 <i class="bi bi-trash"></i>
                </div>
                <div>
                    <h3 class="mb-0 fw-bold">7</h3>
                    <small class="text-muted">Expired Products</small>
                </div>
            </div>
        </div>
        {{-- Today's Sales --}}
        <div class="col-md-3">
            <div class="stat-card d-flex align-items-center gap-3">
                <div class="stat-icon bg-success bg-opacity-10 text-success">
                  💰  <i class="bi bi-cash-stack"></i>
                </div>
                <div>
                    <h3 class="mb-0 fw-bold">XAF 620,000</h3>
                    <small class="text-muted">Today's Sales</small>
                </div>
            </div>
        </div>
    </div>
    {{-- Quick Actions --}}
    <h5 class="mb-3">Quick Actions</h5>
    <div class="d-flex flex-wrap gap-2 mb-4">
        <a href="{{ route('manager.products.create') }}" class="btn btn-outline-primary">Add New Products</a>
        <a href="{{ route('manager.stock-inflow.index') }}" class="btn btn-outline-primary">Record stock Inflow</a>
        <a href="{{ route('manager.stock-outflow.index') }}" class="btn btn-outline-primary">Record stock Outflow</a>
        <a href="{{ route('manager.stock-adjustment.index') }}" class="btn btn-outline-primary">Stock Adjustment</a>
        <a href="{{ route('manager.expired.index') }}" class="btn btn-outline-primary">View Expired Products</a>
        <a href="{{ route('manager.reports.inventory') }}" class="btn btn-outline-primary">Inventory Report</a>
        <a href="{{ route('manager.reports.low-stock') }}" class="btn btn-outline-primary">Low Stock report</a>
    </div>
    {{-- Tableaux récents --}}
    <div class="row g-4">
        {{-- Recent Stock Inflow --}}
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    Recent Stock Inflow
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Date & Time</th>
                                    <th>Products</th>
                                    <th>Quantity</th>
                                    <th>Value</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>08/05/2026</td>
                                    <td>Rice 50kg</td>
                                    <td>100</td>
                                    <td>XAF 200,000</td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>08/05/2026</td>
                                    <td>Cooking Oil 20L</td>
                                    <td>50</td>
                                    <td>XAF 150,000</td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>07/05/2026</td>
                                    <td>Sugar 50kg</td>
                                    <td>80</td>
                                    <td>XAF 176,000</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        {{-- Recent Stock Outflow --}}
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    Recent Stock Outflow
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Date & Time</th>
                                    <th>Products</th>
                                    <th>Qty</th>
                                    <th>Type</th>
                                    <th>Value</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>08/05/2026</td>
                                    <td>Rice 50kg</td>
                                    <td>20</td>
                                    <td>Sale</td>
                                    <td>XAF 50,000</td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>08/05/2026</td>
                                    <td>Cooking Oil 20L</td>
                                    <td>10</td>
                                    <td>Sale</td>
                                    <td>XAF 35,000</td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>07/05/2026</td>
                                    <td>Sugar 50kg</td>
                                    <td>5</td>
                                    <td>Damage</td>
                                    <td>XAF 11,000</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection