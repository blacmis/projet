@extends('manager.layouts.app')

@section('title', 'Stock Outflow')
@section('page_title', 'Stock Outflow')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <div>
        <h5 class="mb-0">Stock Outflow</h5>
        <small class="text-muted">Monitor and record products leaving inventory (hors ventes comptoir).</small>
    </div>
    <button class="btn text-white" style="background:#c47a1a" data-bs-toggle="modal" data-bs-target="#addOutflowModal">
        + Record New Outflow
    </button>
</div>

<div class="card p-3">
    <form method="GET" class="mb-3">
        <input type="text" name="search" value="{{ $search }}" class="form-control" placeholder="Search by product or type...">
    </form>

    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead>
                <tr class="text-muted text-uppercase small">
                    <th>#</th><th>Date</th><th>Product</th><th>Type</th>
                    <th>Quantity</th><th>Unit Cost</th><th>Total Value</th>
                </tr>
            </thead>
            <tbody>
                @forelse($outflows as $i => $out)
                <tr>
                    <td>{{ $outflows->firstItem() + $i }}</td>
                    <td>{{ $out->date->format('d/m/Y') }}</td>
                    <td>{{ $out->product->name ?? '—' }}</td>
                    <td>
                        <span class="badge {{ $out->type === 'Damage' ? 'bg-danger' : ($out->type === 'Expired' ? 'bg-warning text-dark' : 'bg-secondary') }}">
                            {{ $out->type }}
                        </span>
                    </td>
                    <td>{{ $out->quantity }}</td>
                    <td>XAF {{ number_format($out->unit_cost, 0, ',', ' ') }}</td>
                    <td>XAF {{ number_format($out->total_value, 0, ',', ' ') }}</td>
                </tr>
                @empty
                <tr><td colspan="7" class="text-center text-muted py-4">Aucune sortie de stock enregistrée.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="d-flex justify-content-between align-items-center">
        <small class="text-muted">Showing {{ $outflows->firstItem() ?? 0 }} to {{ $outflows->lastItem() ?? 0 }} of {{ $outflows->total() }} records</small>
        {{ $outflows->links() }}
    </div>
</div>

{{-- MODAL --}}
<div class="modal fade" id="addOutflowModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="POST" action="{{ route('manager.stock-outflow.store') }}">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title">Record New Stock Outflow</h5>
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
              <label class="form-label">Outflow Type *</label>
              <select name="type" class="form-select" required>
                <option value="Damage">Damage</option>
                <option value="Expired">Expired</option>
                <option value="Internal Use">Internal Use</option>
                <option value="Return">Return</option>
              </select>
            </div>
            <div class="col-6 mb-3">
              <label class="form-label">Quantity *</label>
              <input type="number" name="quantity" min="1" class="form-control" required>
            </div>
          </div>
          <div class="row">
            <div class="col-6 mb-3">
              <label class="form-label">Unit Cost (XAF) *</label>
              <input type="number" step="0.01" name="unit_cost" class="form-control" required>
            </div>
            <div class="col-6 mb-3">
              <label class="form-label">Date *</label>
              <input type="date" name="date" class="form-control" value="{{ date('Y-m-d') }}" required>
            </div>
          </div>
          <div class="mb-2">
            <label class="form-label">Reason / Notes</label>
            <textarea name="reason" class="form-control" rows="2"></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn text-white" style="background:#c47a1a">Save Stock Outflow</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection