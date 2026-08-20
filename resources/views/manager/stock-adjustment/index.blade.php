@extends('manager.layouts.app')
@section('title', 'Stock Adjustment - MarketSmart')
@section('content')
    <div class="page-header">
        <h4 class="page-title">Stock Adjustment</h4>
        <a href="{{ route('manager.stock-adjustment.create') }}" class="btn btn-orange">
            <i class="bi bi-plus-lg"></i> New Adjustment
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
                <form action="{{ route('manager.stock-adjustment.index') }}" method="GET">
                    <div class="search-box">
                        <i class="bi bi-search"></i>
                        <input type="text"
                               name="search"
                               class="form-control"
                               placeholder="Search by product, type or reason..."
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
                            <th>Type</th>
                            <th>Quantity</th>
                            <th>Reason</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($adjustments as $adjustment)
                            <tr>
                                <td>{{ $adjustment['id'] }}</td>
                                <td>{{ $adjustment['date'] }}</td>
                                <td>{{ $adjustment['product'] }}</td>
                                <td>
                                    @if($adjustment['type'] === 'Increase')
                                        <span class="badge bg-success">Increase</span>
                                    @else
                                        <span class="badge bg-danger">Decrease</span>
                                    @endif
                                </td>
                                <td>{{ $adjustment['quantity'] }}</td>
                                <td>{{ $adjustment['reason'] }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">
                                    Aucun ajustement trouvé
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-between align-items-center mt-3">
                <small class="text-muted">
                    1 to {{ count($adjustments) }} of {{ count($adjustments) }}
                </small>
            </div>
        </div>
    </div>
@endsection