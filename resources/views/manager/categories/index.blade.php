@extends('manager.layouts.app')
@section('title', 'Categories - MarketSmart')
@section('content')
    <div class="page-header">
        <h4 class="page-title">Categories</h4>
        <a href="{{ route('manager.categories.create') }}" class="btn btn-orange">
            <i class="bi bi-plus-lg"></i> Add Category
        </a>
    </div>
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    <div class="card">
        <div class="card-body">
            <div class="mb-3">
                <form action="{{ route('manager.categories.index') }}" method="GET">
                    <div class="search-box">
                        <i class="bi bi-search"></i>
                        <input type="text"
                               name="search"
                               class="form-control"
                               placeholder="Search categories..."
                               value="{{ $search ?? '' }}">
                    </div>
                </form>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Category Name</th>
                            <th>Description</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($categories as $category)
                            <tr>
                                <td>{{ $category['id'] }}</td>
                                <td>
                                    <span class="badge bg-{{ $category['color'] }} me-2">●</span>
                                    {{ $category['name'] }}
                                </td>
                                <td>{{ $category['description'] }}</td>
                                <td>
                                    <a href="{{ route('manager.categories.edit', $category['id']) }}"
                                       class="btn btn-sm btn-outline-primary me-1"
                                       title="Modifier">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('manager.categories.destroy', $category['id']) }}"
                                          method="POST"
                                          class="d-inline"
                                          onsubmit="return confirm('Voulez-vous vraiment supprimer cette catégorie ?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="btn btn-sm btn-outline-danger"
                                                title="Supprimer">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted py-4">
                                    Aucune catégorie trouvée
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-between align-items-center mt-3">
                <small class="text-muted">
                    1 to {{ count($categories) }} of {{ count($categories) }}
                </small>
            </div>
        </div>
    </div>
@endsection