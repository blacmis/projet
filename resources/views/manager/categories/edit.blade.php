@extends('manager.layouts.app')
@section('title', 'Edit Category - MarketSmart')
@section('content')
    <div class="page-header">
        <div>
            <h4 class="page-title">Edit Category</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item">
                        <a href="{{ route('manager.categories.index') }}">Categories</a>
                    </li>
                    <li class="breadcrumb-item active">Edit Category</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <p class="text-muted mb-4">
                <i class="bi bi-info-circle"></i> Modifier les informations de la catégorie
            </p>
            <form action="{{ route('manager.categories.update', $category['id']) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label class="form-label">Category Name</label>
                    <input type="text"
                           name="name"
                           class="form-control"
                           value="{{ old('name', $category['name']) }}"
                           required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea name="description"
                              class="form-control"
                              rows="3">{{ old('description', $category['description']) }}</textarea>
                </div>
                <div class="d-flex gap-2 mt-4">
                    <button type="submit" class="btn btn-orange">
                        <i class="bi bi-check-lg"></i> Enregistrer les modifications
                    </button>
                    <a href="{{ route('manager.categories.index') }}" class="btn btn-outline-secondary">
                        Annuler
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection