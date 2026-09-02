@extends('manager.layouts.app')

@section('title', 'Expired & Damage Goods')
@section('page_title', 'Expired & Damage Goods')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="mb-0">Expired Products</h5>
    <div class="d-flex gap-2">
        <a href="{{ route('manager.expiring.soon') }}" class="btn btn-outline-warning">Voir les produits qui expirent bientôt</a>
        <button class="btn text-white" style="background:#c47a1a" data-bs-toggle="modal" data-bs-target="#addExpiredModal">
            + Retirer un produit
        </button>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card p-3 border-start border-danger border-4">
            <small class="text-muted text-uppercase">Expired Today</small>
            <h4 class="mb-0 text-danger">{{ $expiredTodayCount }} Items</h4>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card p-3 border-start border-warning border-4">
            <small class="text-muted text-uppercase">Expiring in 7 Days</small>
            <h4 class="mb-0 text-warning">{{ $expiringSoonCount }} Items</h4>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card p-3">
            <small class="text-muted text-uppercase">Estimated Loss</small>
            <h4 class="mb-0">XAF {{ number_format($estimatedLoss, 0, ',', ' ') }}</h4>
        </div>
    </div>
</div>

<div class="card p-3">
    <form method="GET" class="mb-3">
        <input type="text" name="search" value="{{ $search }}" class="form-control" placeholder="Search inventory...">
    </form>

    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead>
                <tr class="text-muted text-uppercase small">
                    <th>#</th><th>Product</th><th>Batch No</th><th>Type</th>
                    <th>Expiry Date</th><th>Quantity</th><th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($records as $i => $r)
                <tr>
                    <td>{{ $records->firstItem() + $i }}</td>
                    <td>{{ $r->product->name ?? '—' }}</td>
                    <td>{{ $r->batch_no ?? '—' }}</td>
                    <td>
                        <span class="badge {{ $r->type === 'expired' ? 'bg-danger' : 'bg-secondary' }}">
                            {{ ucfirst($r->type) }}
                        </span>
                    </td>
                    <td class="{{ $r->expiry_date ? 'text-danger' : '' }}">{{ $r->expiry_date?->format('d/m/Y') ?? '—' }}</td>
                    <td>{{ $r->quantity }}</td>
                    <td>{{ $r->status }}</td>
                </tr>
                @empty
                <tr><td colspan="7" class="text-center text-muted py-4">Aucun produit périmé/endommagé enregistré.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="d-flex justify-content-between align-items-center">
        <small class="text-muted">Showing {{ $records->firstItem() ?? 0 }} to {{ $records->lastItem() ?? 0 }} of {{ $records->total() }} records</small>
        {{ $records->links() }}
    </div>
</div>

{{-- MODAL --}}
<div class="modal fade" id="addExpiredModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="POST" action="{{ route('manager.expired.store') }}">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title">Retirer un produit (Expiré / Endommagé)</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label">Product *</label>
            <select name="product_id" class="form-select" required>
              <option value="">Select product...</option>
              @foreach($products as $p)
                <option value="{{ $p->id }}">{{ $p->name }} (stock: {{ $p->stock_quantity }})</option>
              @endforeach
            </select>
          </div>
          <div class="row">
            <div class="col-6 mb-3">
              <label class="form-label">Type *</label>
              <select name="type" class="form-select" required>
                <option value="expired">Expired</option>
                <option value="damaged">Damaged</option>
              </select>
            </div>
            <div class="col-6 mb-3">
              <label class="form-label">Quantity *</label>
              <input type="number" name="quantity" min="1" class="form-control" required>
            </div>
          </div>
          <div class="row">
            <div class="col-6 mb-3">
              <label class="form-label">Batch No</label>
              <input type="text" name="batch_no" class="form-control">
            </div>
            <div class="col-6 mb-3">
              <label class="form-label">Expiry Date</label>
              <input type="date" name="expiry_date" class="form-control">
            </div>
          </div>
          <div class="mb-2">
            <label class="form-label">Estimated Loss (XAF) — optionnel</label>
            <input type="number" step="0.01" name="estimated_loss" class="form-control" placeholder="Calculé automatiquement si vide">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn text-white" style="background:#c47a1a">Confirmer le retrait</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection