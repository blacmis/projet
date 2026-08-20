@extends('manager.layouts.app')
@section('title', 'Edit Product - MarketSmart')
@section('content')
    <div class="page-header">
        <div>
            <h4 class="page-title">Edit Product</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('manager.products.index') }}">Products</a></li>
                    <li class="breadcrumb-item active">Edit Product</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <p class="text-muted mb-4">
                <i class="bi bi-info-circle"></i> Modifier les informations du produit
            </p>
            <form action="{{ route('manager.products.update', $product['id']) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label class="form-label">Product Name</label>
                    <input type="text" name="name" class="form-control"
                           value="{{ old('name', $product['name']) }}" required>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Category</label>
                        <select name="category" class="form-select" required>
                            <option value="">Sélectionner une catégorie</option>
                            <option value="Grains" {{ $product['category'] == 'Grains' ? 'selected' : '' }}>Grains</option>
                            <option value="Beverage" {{ $product['category'] == 'Beverage' ? 'selected' : '' }}>Beverage</option>
                            <option value="Groceries" {{ $product['category'] == 'Groceries' ? 'selected' : '' }}>Groceries</option>
                            <option value="Dairy" {{ $product['category'] == 'Dairy' ? 'selected' : '' }}>Dairy</option>
                            <option value="Household" {{ $product['category'] == 'Household' ? 'selected' : '' }}>Household</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Unit</label>
                        <select name="unit" class="form-select" required>
                            <option value="">Sélectionner une unité</option>
                            <option value="Piece" {{ $product['unit'] == 'Piece' ? 'selected' : '' }}>Piece</option>
                            <option value="Bag" {{ $product['unit'] == 'Bag' ? 'selected' : '' }}>Bag</option>
                            <option value="Kilogram" {{ $product['unit'] == 'Kilogram' ? 'selected' : '' }}>Kilogram</option>
                            <option value="Litre" {{ $product['unit'] == 'Litre' ? 'selected' : '' }}>Litre</option>
                            <option value="Carton" {{ $product['unit'] == 'Carton' ? 'selected' : '' }}>Carton</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Selling Price (XAF)</label>
                        <input type="number" name="selling_price" class="form-control"
                               value="{{ old('selling_price', $product['selling_price']) }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Quantity</label>
                        <input type="number" name="quantity" class="form-control"
                               value="{{ old('quantity', $product['quantity']) }}" required>
                    </div>
                </div>
                <div class="d-flex gap-2 mt-4">
                    <button type="submit" class="btn btn-orange">
                        <i class="bi bi-check-lg"></i> Enregistrer les modifications
                    </button>
                    <a href="{{ route('manager.products.index') }}" class="btn btn-outline-secondary">
                        Annuler
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection