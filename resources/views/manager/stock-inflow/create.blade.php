@extends('manager.layouts.app')
@section('title', 'Record Stock Inflow - MarketSmart')
@section('content')
    <div class="page-header">
        <div>
            <h4 class="page-title">Record New Inflow</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item">
                        <a href="{{ route('manager.stock-inflow.index') }}">Stock Inflow</a>
                    </li>
                    <li class="breadcrumb-item active">Record New Inflow</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <p class="text-muted mb-4">
                <i class="bi bi-info-circle"></i> Remplir les informations de l'entrée de stock
            </p>
            <form action="{{ route('manager.stock-inflow.store') }}" method="POST">
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
                        <label class="form-label">Supplier</label>
                        <select name="supplier" class="form-select" required>
                            <option value="">Sélectionner un fournisseur</option>
                            @foreach($suppliers as $supplier)
                                <option value="{{ $supplier }}" {{ old('supplier') == $supplier ? 'selected' : '' }}>
                                    {{ $supplier }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Quantity</label>
                        <input type="number"
                               name="quantity"
                               class="form-control"
                               value="{{ old('quantity') }}"
                               min="1"
                               required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Unit Cost (XAF)</label>
                        <input type="number"
                               name="unit_cost"
                               class="form-control"
                               value="{{ old('unit_cost') }}"
                               min="0"
                               required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Date</label>
                        <input type="date"
                               name="date"
                               class="form-control"
                               value="{{ old('date', date('Y-m-d')) }}"
                               required>
                    </div>
                </div>
                <div class="d-flex gap-2 mt-4">
                    <button type="submit" class="btn btn-orange">
                        <i class="bi bi-check-lg"></i> Enregistrer l'entrée
                    </button>
                    <a href="{{ route('manager.stock-inflow.index') }}" class="btn btn-outline-secondary">
                        Annuler
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection