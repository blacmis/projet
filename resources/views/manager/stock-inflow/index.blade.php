@extends('manager.layouts.app')

@section('title', 'Stock Inflow')
@section('page_title', 'Stock Inflow')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <div>
        <h5 class="mb-0">Stock Inflow</h5>
        <small class="text-muted">Monitor and record products received into inventory.</small>
    </div>
    <button class="btn text-white" style="background:#c47a1a" data-bs-toggle="modal" data-bs-target="#addInflowModal">
        + Record New Inflow
    </button>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card p-3">
            <small class="text-muted text-uppercase">Total Inflows (Today)</small>
            <h4 class="mb-0">{{ $todayCount }} Batches</h4>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card p-3">
            <small class="text-muted text-uppercase">Total Value Received</small>
            <h4 class="mb-0">XAF {{ number_format($todayValue, 0, ',', ' ') }}</h4>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card p-3">
            <small class="text-muted text-uppercase">Active Suppliers</small>
            <h4 class="mb-0">{{ $activeSuppliers }} Suppliers</h4>
        </div>
    </div>
</div>

<div class="card p-3">
    <form method="GET" class="mb-3">
        <input type="text" name="search" value="{{ $search }}" class="form-control" placeholder="Search products or supplier...">
    </form>

    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead>
                <tr class="text-muted text-uppercase small">
                    <th>#</th><th>Date</th><th>Product</th><th>Quantity</th>
                    <th>Unit Cost</th><th>Total Value</th><th>Supplier</th>
                </tr>
            </thead>
            <tbody>
                @forelse($inflows as $i => $inflow)
                <tr>
                    <td>{{ $inflows->firstItem() + $i }}</td>
                    <td>{{ $inflow->date_received->format('d/m/Y') }}</td>
                    <td>{{ $inflow->product->name ?? '—' }}</td>
                    <td>{{ $inflow->quantity }}</td>
                    <td>XAF {{ number_format($inflow->unit_cost, 0, ',', ' ') }}</td>
                    <td>XAF {{ number_format($inflow->total_value, 0, ',', ' ') }}</td>
                    <td>{{ $inflow->supplier->name ?? '—' }}</td>
                </tr>
                @empty
                <tr><td colspan="7" class="text-center text-muted py-4">Aucune entrée de stock enregistrée.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="d-flex justify-content-between align-items-center">
        <small class="text-muted">Showing {{ $inflows->firstItem() ?? 0 }} to {{ $inflows->lastItem() ?? 0 }} of {{ $inflows->total() }} records</small>
        {{ $inflows->links() }}
    </div>
</div>

{{-- MODAL --}}
<div class="modal fade" id="addInflowModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="POST" action="{{ route('manager.stock-inflow.store') }}">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title">Record New Stock Inflow</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label">Product *</label>
            <select name="product_id" class="form-select" required>
              <option value="">Search and select product...</option>
              @foreach($products as $p)
                <option value="{{ $p->id }}">{{ $p->name }}</option>
              @endforeach
            </select>
          </div>
          <div class="row">
            <div class="col-6 mb-3">
              <label class="form-label">Quantity Received *</label>
              <input type="number" name="quantity" min="1" class="form-control" required>
            </div>
            <div class="col-6 mb-3">
              <label class="form-label">Purchase Price / Unit Cost *</label>
              <input type="number" step="0.01" name="unit_cost" class="form-control" required>
            </div>
          </div>
          <div class="mb-3">
            <label class="form-label">Supplier</label>
            <select name="supplier_id" class="form-select">
              <option value="">Select supplier...</option>
              @foreach($suppliers as $s)
                <option value="{{ $s->id }}">{{ $s->name }}</option>
              @endforeach
            </select>
          </div>
          <div class="row">
            <div class="col-6 mb-3">
              <label class="form-label">Date Received *</label>
              <input type="date" name="date_received" class="form-control" value="{{ date('Y-m-d') }}" required>
            </div>
            <div class="col-6 mb-3">
              <label class="form-label">Expiry Date (Optional)</label>
              <input type="date" name="expiry_date" class="form-control">
            </div>
          </div>
          <div class="mb-2">
            <label class="form-label">Batch No (Optional)</label>
            <input type="text" name="batch_no" class="form-control" placeholder="Auto-généré si vide">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn text-white" style="background:#c47a1a">Save Stock Inflow</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection