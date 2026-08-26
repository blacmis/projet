@extends('manager.layouts.app')
@section('page_title', 'Expired Products')
@section('content')
    <div class="page-header">
        <h4 class="page-title">Expired Products</h4>
        <a href="{{ route('manager.expiring.soon') }}" class="btn btn-outline-orange">
            Voir les produits qui expirent bientôt
        </a>
    </div>
    {{-- Stats --}}
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="stat-card border-start border-danger border-4">
                <h5 class="mb-1 text-danger">12 Items</h5>
                <small class="text-muted">EXPIRED TODAY</small>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card border-start border-warning border-4">
                <h5 class="mb-1 text-warning">45 Items</h5>
                <small class="text-muted">EXPIRING IN 7 DAYS</small>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card border-start border-secondary border-4">
                <h5 class="mb-1">$240.50</h5>
                <small class="text-muted">ESTIMATED LOSS</small>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="mb-3">
                <form action="{{ route('manager.expired.index') }}" method="GET">
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
                            <th>Batch No</th>
                            <th>Expiry Date</th>
                            <th>Quantity</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($expired as $item)
                            <tr>
                                <td>{{ $item['id'] }}</td>
                                <td>{{ $item['product'] }}</td>
                                <td>{{ $item['batch_no'] }}</td>
                                <td class="text-danger">{{ $item['expiry_date'] }}</td>
                                <td>{{ $item['quantity'] }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">
                                    Aucun produit expiré trouvé
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-between align-items-center mt-3">
                <small class="text-muted">
                    1 to {{ count($expired) }} of {{ count($expired) }}
                </small>
            </div>
        </div>
    </div>
@endsection