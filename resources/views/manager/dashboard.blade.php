@extends('manager.layouts.app')
@section('title', 'Dashboard - MarketSmart')
@section('content')
    {{-- En-tête de la page --}}
    <div class="page-header">
        <div>
            <h4 class="page-title">Inventory Manager</h4>
            <p class="page-subtitle">Welcome back, John Doe</p>
        </div>
        <div class="d-flex align-items-center gap-3"></div>
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
                    <h3 class="mb-0 fw-bold">{{ $lowStockCount }}</h3>
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
                    <h3 class="mb-0 fw-bold">{{ $expiringSoonCount }}</h3>
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
                    <h3 class="mb-0 fw-bold">{{ $expiredCount }}</h3>
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
                    <h3 class="mb-0 fw-bold">XAF {{ number_format($todaysSales, 0, ',', ' ') }}</h3>
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
                <div class="card-header">Recent Stock Inflow</div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>#</th><th>Date & Time</th><th>Products</th><th>Quantity</th><th>Value</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentInflows as $i => $inflow)
                                <tr>
                                    <td>{{ $i + 1 }}</td>
                                    <td>{{ $inflow->date_received->format('d/m/Y') }}</td>
                                    <td>{{ $inflow->product->name ?? '—' }}</td>
                                    <td>{{ $inflow->quantity }}</td>
                                    <td>XAF {{ number_format($inflow->total_value, 0, ',', ' ') }}</td>
                                </tr>
                                @empty
                                <tr><td colspan="5" class="text-center text-muted py-3">Aucune entrée récente.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        {{-- Recent Stock Outflow --}}
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Recent Stock Outflow</div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>#</th><th>Date & Time</th><th>Products</th><th>Qty</th><th>Type</th><th>Value</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentOutflows as $i => $out)
                                <tr>
                                    <td>{{ $i + 1 }}</td>
                                    <td>{{ $out->date->format('d/m/Y') }}</td>
                                    <td>{{ $out->product->name ?? '—' }}</td>
                                    <td>{{ $out->quantity }}</td>
                                    <td>{{ $out->type }}</td>
                                    <td>XAF {{ number_format($out->total_value, 0, ',', ' ') }}</td>
                                </tr>
                                @empty
                                <tr><td colspan="6" class="text-center text-muted py-3">Aucune sortie récente.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection