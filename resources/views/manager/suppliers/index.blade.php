@extends('manager.layouts.app')
@section('page_title', 'Suppliers')
@section('content')
    <div class="page-header">
        <h4 class="page-title">Suppliers</h4>
        <a href="{{ route('manager.suppliers.create') }}" class="btn btn-orange">
            <i class="bi bi-plus-lg"></i> Add New Supplier
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
                <form action="{{ route('manager.suppliers.index') }}" method="GET">
                    <div class="search-box">
                        <i class="bi bi-search"></i>
                        <input type="text"
                               name="search"
                               class="form-control"
                               placeholder="Search suppliers..."
                               value="{{ $search ?? '' }}">
                    </div>
                </form>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Supplier Name</th>
                            <th>Phone</th>
                            <th>Email</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($suppliers as $supplier)
                            <tr>
                                <td>{{ $supplier['id'] }}</td>
                                <td>{{ $supplier['name'] }}</td>
                                <td>{{ $supplier['phone'] }}</td>
                                <td>{{ $supplier['email'] }}</td>
                                <td class="text-nowrap">
                                    <a href="{{ route('manager.suppliers.edit', $supplier['id']) }}"
                                       class="btn btn-sm btn-outline-primary me-1"
                                       title="Modifier">
                                        ✏️
                                    </a>
                                    <form action="{{ route('manager.suppliers.destroy', $supplier['id']) }}"
                                          method="POST"
                                          class="d-inline"
                                          onsubmit="return confirm('Voulez-vous vraiment supprimer ce fournisseur ?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="btn btn-sm btn-outline-danger"
                                                title="Supprimer">
                                            🗑️
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">
                                    Aucun fournisseur trouvé
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-between align-items-center mt-3">
                <small class="text-muted">
                    1 to {{ count($suppliers) }} of {{ count($suppliers) }}
                </small>
            </div>
        </div>
    </div>
@endsection