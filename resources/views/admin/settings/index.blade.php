@extends('admin.layouts.app')
@section('title', 'Settings | MarketSmart Admin')
@section('content')
<div class="admin-table-wrap" style="max-width:1300px;">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="mb-0">⚙️ Store Settings</h5>
        <form method="POST" action="{{ route('admin.settings.reset') }}"
              onsubmit="return confirm('Réinitialiser les paramètres par défaut ?')">
            @csrf
            <button type="submit" class="btn btn-sm btn-outline-secondary">Reset defaults</button>
        </form>
    </div>
    @if(session('success'))
        <div class="alert alert-success py-2">{{ session('success') }}</div>
    @endif
    @if($errors->any())
        <div class="alert alert-danger py-2">
            @foreach($errors->all() as $e) <div>{{ $e }}</div> @endforeach
        </div>
    @endif
    <form method="POST" action="{{ route('admin.settings.update') }}">
        @csrf
        @method('PUT')
        <h6 class="text-muted mb-3">Informations magasin</h6>
        <div class="mb-3">
            <label class="form-label">Store name</label>
            <input type="text" name="store_name" class="form-control"
                   value="{{ old('store_name', $settings->store_name) }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Address</label>
            <input type="text" name="store_address" class="form-control"
                   value="{{ old('store_address', $settings->store_address) }}">
        </div>
        <div class="mb-3">
            <label class="form-label">Phone</label>
            <input type="text" name="store_phone" class="form-control"
                   value="{{ old('store_phone', $settings->store_phone) }}">
        </div>
        <hr class="my-4">
        <h6 class="text-muted mb-3">Finance & reçus</h6>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Currency</label>
                <input type="text" name="currency" class="form-control"
                       value="{{ old('currency', $settings->currency) }}" required>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Tax rate (%)</label>
                <input type="number" step="0.01" min="0" max="100" name="tax_rate" class="form-control"
                       value="{{ old('tax_rate', $settings->tax_rate) }}">
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label">Receipt footer message</label>
            <input type="text" name="receipt_footer" class="form-control"
                   value="{{ old('receipt_footer', $settings->receipt_footer) }}">
        </div>
        <hr class="my-4">
        <h6 class="text-muted mb-3">Alertes stock</h6>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Low stock threshold (default)</label>
                <input type="number" min="0" name="low_stock_threshold" class="form-control"
                       value="{{ old('low_stock_threshold', $settings->low_stock_threshold) }}">
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Expiry alert (days before)</label>
                <input type="number" min="1" max="90" name="expiry_alert_days" class="form-control"
                       value="{{ old('expiry_alert_days', $settings->expiry_alert_days) }}">
            </div>
        </div>
        <button type="submit" class="btn" style="background:#c47a1a;color:#fff;border:none;">
            Save settings
        </button>
    </form>
</div>
@endsection