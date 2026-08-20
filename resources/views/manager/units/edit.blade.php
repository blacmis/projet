@extends('manager.layouts.app')
@section('title', 'Edit Unit - MarketSmart')
@section('content')
    <div class="page-header">
        <div>
            <h4 class="page-title">Edit Unit</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item">
                        <a href="{{ route('manager.units.index') }}">Units</a>
                    </li>
                    <li class="breadcrumb-item active">Edit Unit</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <p class="text-muted mb-4">
                <i class="bi bi-info-circle"></i> Modifier les informations de l'unité
            </p>
            <form action="{{ route('manager.units.update', $unit['id']) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label class="form-label">Unit Name</label>
                    <input type="text"
                           name="name"
                           class="form-control"
                           value="{{ old('name', $unit['name']) }}"
                           required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Short Code</label>
                    <input type="text"
                           name="short_code"
                           class="form-control"
                           value="{{ old('short_code', $unit['short_code']) }}"
                           required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea name="description"
                              class="form-control"
                              rows="3">{{ old('description', $unit['description']) }}</textarea>
                </div>
                <div class="d-flex gap-2 mt-4">
                    <button type="submit" class="btn btn-orange">
                        <i class="bi bi-check-lg"></i> Enregistrer les modifications
                    </button>
                    <a href="{{ route('manager.units.index') }}" class="btn btn-outline-secondary">
                        Annuler
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection