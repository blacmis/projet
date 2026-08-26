@extends('manager.layouts.app')
@section('page_title', 'Stock Outflow')
@section('content')
    <div class="page-header">
        <h4 class="page-title">Stock Outflow</h4>
        <a href="{{ route('manager.stock-outflow.create') }}" class="btn btn-orange">
            <i class="bi bi-plus-lg"></i> Record New Outflow
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
                <form action="{{ route('manager.stock-outflow.index') }}" method="GET">
                    <div class="search-box">
                        <i class="bi bi-search"></i>
                        <input type="text"
                               name="search"
                               class="form-control"
                               placeholder="Search by product or type..."
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
                            <th>Type</th>
                            <th>Unit Cost</th>
                            <th>Total Value</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($outflows as $outflow)
                            <tr>
                                <td>{{ $outflow['id'] }}</td>
                                <td>{{ $outflow['date'] }}</td>
                                <td>{{ $outflow['product'] }}</td>
                                <td>{{ $outflow['quantity'] }}</td>
                                <td>
                                    @if($outflow['type'] === 'Sale')
                                        <span class="badge bg-success">Sale</span>
                                    @elseif($outflow['type'] === 'Damage')
                                        <span class="badge bg-danger">Damage</span>
                                    @elseif($outflow['type'] === 'Expired')
                                        <span class="badge bg-warning text-dark">Expired</span>
                                    @else
                                        <span class="badge bg-secondary">{{ $outflow['type'] }}</span>
                                    @endif
                                </td>
                                <td>XAF {{ number_format($outflow['unit_cost'], 0, ',', ' ') }}</td>
                                <td>XAF {{ number_format($outflow['total_value'], 0, ',', ' ') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">
                                    Aucune sortie de stock trouvée
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-between align-items-center mt-3">
                <small class="text-muted">
                    1 to {{ count($outflows) }} of {{ count($outflows) }}
                </small>
            </div>
        </div>
    </div>
@endsection