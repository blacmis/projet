@extends('manager.layouts.app')

@section('title', 'Stock Adjustment')
@section('page_title', 'Stock Adjustment')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="mb-0">Stock Adjustment</h5>
    <button class="btn text-white" style="background:#c47a1a" data-bs-toggle="modal" data-bs-target="#addAdjustmentModal">
        + New Adjustment
    </button>
</div>

<div class="card p-3">
    <form method="GET" class="mb-3">
        <input type="text" name="search" value="{{ $search }}" class="form-control" placeholder="Filter by product or reason...">
    </form>

    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead>
                <tr class="text-muted text-uppercase small">
                    <th>#</th><th>Date</th><th>Product</th><th>Type</th><th>Quantity</th><th>Reason</th>
                </tr>
            </thead>
            <tbody>
                @forelse($adjustments as $i => $adj)
                <tr>
                    <td>{{ $adjustments->firstItem() + $i }}</td>
                    <td>{{ $adj->date->format('d/m/Y') }}</td>
                    <td>{{ $adj->product->name ?? '—' }}</td>
                    <td>
                        <span class="badge {{ $adj->type === 'increase' ? 'bg-success' : 'bg-danger' }}">
                            {{ ucfirst($adj->type) }}
                        </span>
                    </td>
                    <td>{{ $adj->type === 'increase' ? '+' : '-' }}{{ $adj->quantity }}</td>
                    <td>{{ $adj->reason }}</td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center text-muted py-4">Aucun ajustement enregistré.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="d-flex justify-content-between align-items-center">
        <small class="text-muted">Showing {{ $adjustments->firstItem() ?? 0 }} to {{ $adjustments->lastItem() ?? 0 }} of {{ $adjustments->total() }} records</small>
        {{ $adjustments->links() }}
    </div>
</div>

{{-- MODAL --}}
<div class="modal fade" id="addAdjustmentModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="POST" action="{{ route('manager.stock-adjustment.store') }}">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title">New Stock Adjustment</h5>
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
                <option value="increase">Increase</option>
                <option value="decrease">Decrease</option>
              </select>
            </div>
            <div class="col-6 mb-3">
              <label class="form-label">Quantity *</label>
              <input type="number" name="quantity" min="1" class="form-control" required>
            </div>
          </div>
          <div class="mb-3">
            <label class="form-label">Reason *</label>
            <input type="text" name="reason" class="form-control" placeholder="Ex: Stock Count, Spillage, Correction" required>
          </div>
          <div class="mb-2">
            <label class="form-label">Date *</label>
            <input type="date" name="date" class="form-control" value="{{ date('Y-m-d') }}" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn text-white" style="background:#c47a1a">Save Adjustment</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection