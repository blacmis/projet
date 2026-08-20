@extends('manager.layouts.app')
@section('title', 'Expiring Soon - MarketSmart')
@section('content')
    <div class="page-header">
        <h4 class="page-title">Expiring Soon</h4>
        <div>
            <a href="{{ route('manager.expired.index') }}" class="btn btn-outline-secondary me-2">
                Voir les produits expirés
            </a>
            <button class="btn btn-orange">Export Report</button>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="mb-3">
                <form action="{{ route('manager.expiring.soon') }}" method="GET">
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
                            <th>Batch No.</th>
                            <th>Expiry Date</th>
                            <th>Days Left</th>
                            <th>Quantity</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($expiring as $item)
                            <tr>
                                <td>{{ $item['id'] }}</td>
                                <td>{{ $item['product'] }}</td>
                                <td>{{ $item['batch_no'] }}</td>
                                <td>{{ $item['expiry_date'] }}</td>
                                <td>
                                    @if($item['days_left'] <= 7)
                                        <span class="text-danger fw-bold">{{ $item['days_left'] }} days</span>
                                    @elseif($item['days_left'] <= 15)
                                        <span class="text-warning fw-bold">{{ $item['days_left'] }} days</span>
                                    @else
                                        <span>{{ $item['days_left'] }} days</span>
                                    @endif
                                </td>
                                <td>{{ $item['quantity'] }} units</td>
                                <td>
                                    <button class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">
                                    Aucun produit trouvé
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-between align-items-center mt-3">
                <small class="text-muted">
                    1 to {{ count($expiring) }} of {{ count($expiring) }}
                </small>
            </div>
        </div>
    </div>
@endsection