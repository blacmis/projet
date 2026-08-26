@extends('manager.layouts.app')
@section('page_title', 'Low Stock Report')
@section('content')
    <div class="page-header">
        <h4 class="page-title">Low Stock Report</h4>
        <button class="btn btn-orange">
            <i class="bi bi-download"></i> Export Report
        </button>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="mb-3">
                <form action="{{ route('manager.reports.low-stock') }}" method="GET">
                    <div class="search-box">
                        <i class="bi bi-search"></i>
                        <input type="text"
                               name="search"
                               class="form-control"
                               placeholder="Search products..."
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
                            <th>Current Stock</th>
                            <th>Minimum Stock</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($items as $item)
                            <tr>
                                <td>{{ $item['id'] }}</td>
                                <td>{{ $item['product'] }}</td>
                                <td>{{ $item['current_stock'] }}</td>
                                <td>{{ $item['min_stock'] }}</td>
                                <td>
                                    <span class="badge bg-warning text-dark">{{ $item['status'] }}</span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">
                                    Aucun produit en stock faible
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