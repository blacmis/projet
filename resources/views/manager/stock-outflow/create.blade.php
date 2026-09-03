@extends('manager.layouts.app')
@section('title', 'Record Stock Outflow - MarketSmart')
@section('content')
    <div class="page-header">
        <div>
            <h4 class="page-title">Record New Outflow</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item">
                        <a href="{{ route('manager.stock-outflow.index') }}">Stock Outflow</a>
                    </li>
                    <li class="breadcrumb-item active">Record New Outflow</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <p class="text-muted mb-4">
                <i class="bi bi-info-circle"></i> Remplir les informations de la sortie de stock
            </p>
            <form action="{{ route('manager.stock-outflow.store') }}" method="POST">
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
                        <i class="bi bi-check-lg"></i> Enregistrer la sortie
                    </button>
                    <a href="{{ route('manager.stock-outflow.index') }}" class="btn btn-outline-secondary">
                        Annuler
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection