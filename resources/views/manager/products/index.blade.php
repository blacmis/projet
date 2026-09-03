@extends('manager.layouts.app')
@section('page_title', 'Products')
@section('content')
    <div class="page-header">
        <h4 class="page-title">Products</h4>
        <a href="{{ route('manager.products.create') }}" class="btn btn-orange">
            <i class="bi bi-plus-lg"></i> Add New Product
        </a>
    </div>
    {{-- Messages de succès / erreur --}}
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
                <form action="{{ route('manager.products.index') }}" method="GET">
                    <div class="search-box">
                        <i class="bi bi-search"></i>
                        <input type="text"
                            name="search"
                            class="form-control"
                            placeholder="Search Product"
                            value="{{ $search ?? '' }}">
                    </div>
                </form>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Product Name</th>
                            <th>Category</th>
                            <th>Unit</th>
                            <th>Selling Price</th>
                            <th>Quantity</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products as $product)
                            <tr>
                                <td>{{ $product['id'] }}</td>
                                <td>{{ $product['name'] }}</td>
                                <td>{{ $product['category'] }}</td>
                                <td>{{ $product['unit'] }}</td>
                                <td>XAF {{ number_format($product['selling_price'], 0, ',', ' ') }}</td>
                                <td>{{ $product['quantity'] }}</td>
                                <td>
                                    @if($product['status'] === 'In Stock')
                                        <span class="badge bg-success">In Stock</span>
                                    @else
                                        <span class="badge bg-warning text-dark">Low Stock</span>
                                    @endif
                                </td>
                                <td class="text-nowrap">
                                    <a href="{{ route('manager.products.edit', $product['id']) }}"
                                    class="btn btn-sm btn-outline-primary me-1"
                                    title="Edit">
                                        ✏️
                                    </a>
                                    <form action="{{ route('manager.products.destroy', $product['id']) }}"
                                        method="POST"
                                        class="d-inline"
                                        onsubmit="return confirm('Supprimer cet élément ?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                                            🗑️
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted py-4">
                                    Aucun produit trouvé
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-between align-items-center mt-3">
                <small class="text-muted">1 to {{ count($products) }} of {{ count($products) }}</small>
            </div>
        </div>
    </div>
@endsection