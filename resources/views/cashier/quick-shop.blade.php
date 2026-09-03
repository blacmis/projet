@extends('cashier.layout')
@section('title','Quick Shop | MarketSmart')
@section('page_title','Quick Shop')

@section('content')
<form class="search-row mb-20" method="GET">
    <div class="search">
        <span>⌕</span>
        <input class="form-control" name="search" value="{{ request('search') }}" placeholder="Search products or scan barcode...">
    </div>
    <select class="form-control" name="category" style="max-width:200px">
        <option value="">All Categories</option>
        @foreach($categories as $category)
            <option value="{{ $category }}" @selected(request('category') === $category)>{{ $category }}</option>
        @endforeach
    </select>
    <button class="btn btn-primary">Search</button>
</form>

<div class="shop-grid">
@forelse($products as $product)
    <div class="shop-product">
        <div class="shop-photo">🛒</div>
        <h4>{{ $product->name }}</h4>
        <div class="muted">{{ $product->category }}</div>
        <div class="price">{{ number_format($product->price, 0) }} FCFA</div>
        <div class="stock">Stock: {{ $product->stock_quantity }}</div>
        <form method="POST" action="{{ route('cashier.cart.add') }}">
            @csrf
            <input type="hidden" name="product_id" value="{{ $product->id }}">
            <input type="hidden" name="quantity" value="1">
            <button class="btn btn-primary" onclick="showcartpopup()" id="add-to-cart" style="width:100%;margin-top:10px" {{ $product->stock_quantity < 1 ? 'disabled' : '' }}>Add to Sale<a href="resources/views/cashier/payment.blade.php">
            <script>
                function showcartpopup() {
                    swal.fire({
                        title: 'succes',
                        Text: 'item added',
                        icon: 'success',
                        confirmButtonText: 'continue shopping',
                        timer: 2500 // automatic closs after 2.5seconds
                    });
                }
                
                </script></a></button>
        </form>
    </div>
@empty
    <div class="empty-state" style="grid-column:1/-1">No products found.</div>
@endforelse
</div>
@endsection
