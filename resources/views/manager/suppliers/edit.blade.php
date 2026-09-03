@extends('manager.layouts.app')
@section('title', 'Edit Supplier - MarketSmart')
@section('content')
    <div class="page-header">
        <div>
            <h4 class="page-title">Edit Supplier</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item">
                        <a href="{{ route('manager.suppliers.index') }}">Suppliers</a>
                    </li>
                    <li class="breadcrumb-item active">Edit Supplier</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <p class="text-muted mb-4">
                <i class="bi bi-info-circle"></i> Modifier les informations du fournisseur
            </p>
            <form action="{{ route('manager.suppliers.update', $supplier['id']) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label class="form-label">Supplier Name</label>
                    <input type="text"
                           name="name"
                           class="form-control"
                           value="{{ old('name', $supplier['name']) }}"
                           required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Phone</label>
                    <input type="text"
                           name="phone"
                           class="form-control"
                           value="{{ old('phone', $supplier['phone']) }}"
                           required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email"
                           name="email"
                           class="form-control"
                           value="{{ old('email', $supplier['email']) }}"
                           required>
                </div>
                <div class="d-flex gap-2 mt-4">
                    <button type="submit" class="btn btn-orange">
                        <i class="bi bi-check-lg"></i> Enregistrer les modifications
                    </button>
                    <a href="{{ route('manager.suppliers.index') }}" class="btn btn-outline-secondary">
                        Annuler
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection