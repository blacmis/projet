@extends('cashier.layout')
@section('title','Payment | MarketSmart')
@section('page_title','Payment')

@section('content')
<div class="payment-layout">
    <div>
        <div class="card mb-20">
            <div class="card-header">
                <h3>Product Search</h3>
                <a class="btn btn-light" href="{{ route('cashier.quick-shop') }}">Quick Shop</a>
            </div>
            <div class="card-body">
                <form method="GET" action="{{ route('cashier.quick-shop') }}" class="search-row">
                    <div class="search">
                        <span>⌕</span>
                        <input id="productSearch" class="form-control" name="search" placeholder="Search product or barcode..." value="{{ request('search') }}">
                    </div>
                </form>

             
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h3>Current Sale</h3>
                @if(count($cart))
                    <form method="POST" action="{{ route('cashier.cart.clear') }}">
                        @csrf
                        <button class="btn btn-danger" type="submit" data-confirm="Clear this sale?">Clear Sale</button>
                    </form>
                @endif
            </div>

            <div class="card-body">
                @forelse($cart as $item)
                    <div class="cart-item">
                        <div class="product-img">🛒</div>
                        <div style="flex:1">
                            <strong>{{ $item['name'] }}</strong>
                            <div class="muted">{{ number_format($item['price'], 0) }} FCFA each</div>
                        </div>

                        <form method="POST" action="{{ route('cashier.cart.update') }}" class="qty-form">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $item['product_id'] }}">
                            <input class="qty-input" type="number" name="quantity" min="1" max="999" value="{{ $item['quantity'] }}">
                            <button class="btn btn-light" type="submit">Update</button>
                        </form>

                        <strong>{{ number_format($item['price'] * $item['quantity'], 0) }} FCFA</strong>

                        <form method="POST" action="{{ route('cashier.cart.remove') }}">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $item['product_id'] }}">
                            <button class="remove-btn" type="submit">×</button>
                        </form>
                    </div>
                @empty
                    <div class="empty-state">
                        <div>🛒</div>
                        <h3>No items in the sale</h3>
                        <p>Add products above to start a transaction.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <div class="card checkout-card">
        <div class="card-header"><h3>Payment Summary</h3></div>
        <div class="card-body">
            <div class="total-row"><span>Subtotal</span><strong>{{ number_format($totals['subtotal'], 0) }} FCFA</strong></div>

            <form method="POST" action="{{ route('cashier.checkout') }}" id="checkoutForm">
                @csrf

                <div class="form-group mb-15">
                    <label>DISCOUNT</label>
                    <input class="form-control" id="discountInput" type="number" min="0" step="1" name="discount" value="0">
                </div>

                <div class="total-row grand">
                    <span>Total</span>
                    <span id="grandTotal">{{ number_format($totals['total'], 0) }} FCFA</span>
                </div>

                <h4 style="margin:20px 0 10px;color:var(--navy)">Payment Method</h4>
                <div class="pay-methods mb-20">
                    <label class="pay-method active" > 
                        <input type="radio" name="payment_method" value="cash" check>
                        💵<br><small>Cash</small>
                    </label>
                    <label class="pay-method">
                        <input type="radio" name="payment_method" value="mobile_money">
                        📱<br><small>Mobile Money</small>
                    </label>
                    <label class="pay-method">
                        <input type="radio" name="payment_method" value="card">
                        💳<br><small>Card</small>
                    </label>
                    <label class="pay-method">
                        <input type="radio" name="payment_method" value="card">
                        💳<br><small>Others</small>
                        </label>
                </div>

                <div class="form-group mb-15">
                    <label>AMOUNT PAID</label>
                    <input class="form-control" id="amountPaid" type="number" name="amount_paid" min="0" step="1" required>
                </div>

                <div class="change-box">
                    <span>Change</span>
                    <strong id="changeAmount">0 FCFA</strong>
                </div>

                <button class="btn btn-primary checkout-btn" type="submit" {{ count($cart) ? '' : 'disable' }}          
>
                    Confirm Payment <a href="resources/views/cashier/receipt.blade.php"></a>
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
