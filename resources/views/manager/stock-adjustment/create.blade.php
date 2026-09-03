@extends('manager.layouts.app')
@section('title', 'New Stock Adjustment - MarketSmart')
@section('content')
    <div class="page-header">
        <div>
            <h4 class="page-title">New Adjustment</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item">
                        <a href="{{ route('manager.stock-adjustment.index') }}">Stock Adjustment</a>
                    </li>
                    <li class="breadcrumb-item active">New Adjustment</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <p class="text-muted mb-4">
                <i class="bi bi-info-circle"></i> Remplir les informations de l'ajustement de stock
            </p>
            <form action="{{ route('manager.stock-adjustment.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Product</label>
                        <select name="product" class="form-select" required>
                            <option value="">Sélectionner un produit</option>
                            @foreach($products as $product)
                                <option value="{{ $product }}" {{ old('product') == $product ? 'selected' : '' }}>
                                    {{ $product }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Type</label>
                        <select name="type" class="form-select" required>
                            <option value="">Sélectionner un type</option>
                            @foreach($types as $type)
                                <option value="{{ $type }}" {{ old('type') == $type ? 'selected' : '' }}>
                                    {{ $type }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Quantity</label>
                        <input type="number"
                               name="quantity"
                               class="form-control"
                               value="{{ old('quantity') }}"
                               min="1"
                               required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Date</label>
                        <input type="date"
                               name="date"
                               class="form-control"
                               value="{{ old('date', date('Y-m-d')) }}"
                               required>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Reason</label>
                    <textarea name="reason"
                              class="form-control"
                              rows="3"
                              required>{{ old('reason') }}</textarea>
                </div>
                <div class="d-flex gap-2 mt-4">
                    <button type="submit" class="btn btn-orange">
                        <i class="bi bi-check-lg"></i> Enregistrer l'ajustement
                    </button>
                    <a href="{{ route('manager.stock-adjustment.index') }}" class="btn btn-outline-secondary">
                        Annuler
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection