@extends('manager.layouts.app')
@section('page_title', 'Inventory Report')
@section('content')
    <div class="page-header">
        <h4 class="page-title">Inventory Report</h4>
        <button class="btn btn-orange">
            <i class="bi bi-download"></i> Export Report
        </button>
    </div>
    {{-- Stats --}}
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="stat-card">
                <h5 class="mb-1">{{ $totalProducts }}</h5>
                <small class="text-muted">Total Products</small>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card">
                <h5 class="mb-1">XAF {{ number_format($totalValue, 0, ',', ' ') }}</h5>
                <small class="text-muted">Total Inventory Value</small>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card">
                <h5 class="mb-1 text-success">In Stock</h5>
                <small class="text-muted">Overall Status</small>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="mb-3">
                <form action="{{ route('manager.reports.inventory') }}" method="GET">
                    <div class="search-box">
                        <i class="bi bi-search"></i>
                        <input type="text"
                               name="search"
                               class="form-control"
                               placeholder="Search inventory..."
                               value="{{ $search ?? '' }}">
                    </div>
                </form>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Product</th>
                            <th>Category</th>
                            <th>Quantity</th>
                            <th>Unit</th>
                            <th>Value (XAF)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($items as $item)
                            <tr>
                                <td>{{ $item['id'] }}</td>
                                <td>{{ $item['product'] }}</td>
                                <td>{{ $item['category'] }}</td>
                                <td>{{ $item['quantity'] }}</td>
                                <td>{{ $item['unit'] }}</td>
                                <td>XAF {{ number_format($item['value'], 0, ',', ' ') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">
                                    Aucun produit trouvé
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-between align-items-center mt-3">
                <small class="text-muted">
                    1 to {{ count($items) }} of {{ count($items) }}
                </small>
            </div>
        </div>
    </div>
@endsection