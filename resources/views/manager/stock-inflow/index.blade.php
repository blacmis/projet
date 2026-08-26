@extends('manager.layouts.app')
@section('page_title', 'Stock Inflow')
@section('content')
    <div class="page-header">
        <h4 class="page-title">Stock Inflow</h4>
        <a href="{{ route('manager.stock-inflow.create') }}" class="btn btn-orange">
            <i class="bi bi-plus-lg"></i> Record New Inflow
        </a>
    </div>
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    <div class="card">
        <div class="card-body">
            <div class="mb-3">
                <form action="{{ route('manager.stock-inflow.index') }}" method="GET">
                    <div class="search-box">
                        <i class="bi bi-search"></i>
                        <input type="text"
                               name="search"
                               class="form-control"
                               placeholder="Search by product or supplier..."
                               value="{{ $search ?? '' }}">
                    </div>
                </form>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Date</th>
                            <th>Product</th>
                            <th>Quantity</th>
                            <th>Unit Cost</th>
                            <th>Total Value</th>
                            <th>Supplier</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($inflows as $inflow)
                            <tr>
                                <td>{{ $inflow['id'] }}</td>
                                <td>{{ $inflow['date'] }}</td>
                                <td>{{ $inflow['product'] }}</td>
                                <td>{{ $inflow['quantity'] }}</td>
                                <td>XAF {{ number_format($inflow['unit_cost'], 0, ',', ' ') }}</td>
                                <td>XAF {{ number_format($inflow['total_value'], 0, ',', ' ') }}</td>
                                <td>{{ $inflow['supplier'] }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">
                                    Aucune entrée de stock trouvée
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-between align-items-center mt-3">
                <small class="text-muted">
                    1 to {{ count($inflows) }} of {{ count($inflows) }}
                </small>
            </div>
        </div>
    </div>
@endsection