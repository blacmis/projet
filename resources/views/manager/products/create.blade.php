@extends('manager.layouts.app') {{-- Adapte selon ton layout principal de dashboard --}}
@section('title' , 'Add New Product - MarketSmart')
@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Add New Product</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('manager.products.index') }}">Products</a></li>
        <li class="breadcrumb-item active">Add New Product</li>
    </ol>
    <div class="card mb-4">
        <div class="card-header">
            <i class="bi bi-plus-circle me-1"></i>
            Remplir les informations du nouveau produit
        </div>
        <div class="card-body">
            {{-- Le formulaire pointe vers la route store en méthode POST --}}
            <form action="{{ route('manager.products.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Product Name</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="category" class="form-label">Category</label>
                        <select class="form-control @error('category') is-invalid @enderror" id="category" name="category" required>
                            <option value="">Sélectionner une catégorie</option>
                            <option value="Grains">Grains</option>
                            <option value="Beverage">Beverage</option>
                            <option value="Groceries">Groceries</option>
                            <option value="Dairy">Dairy</option>
                        </select>
                        @error('category')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="unit" class="form-label">Unit</label>
                        <select class="form-control @error('unit') is-invalid @enderror" id="unit" name="unit" required>
                            <option value="">Sélectionner une unité</option>
                            <option value="Bag">Bag</option>
                            <option value="Piece">Piece</option>
                        </select>
                        @error('unit')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="selling_price" class="form-label">Selling Price (XAF)</label>
                        <input type="number" class="form-control @error('selling_price') is-invalid @enderror" id="selling_price" name="selling_price" value="{{ old('selling_price') }}" required>
                        @error('selling_price')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="quantity" class="form-label">Initial Quantity</label>
                        <input type="number" class="form-control @error('quantity') is-invalid @enderror" id="quantity" name="quantity" value="{{ old('quantity') }}" required>
                            @error('quantity')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                    </div>
                </div>
                <button type="submit" class="btn btn-orange">
                   <i class="bi bi-check-lg"></i>  Enregistrer le produit</button>
                <a href="{{ route('manager.products.index') }}" class="btn btn-secondary">Annuler</a>
            </form>
        </div>
    </div>
</div>
@endsection