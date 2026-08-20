@extends('cashier.layout')
@section('title','Receipt | MarketSmart')
@section('page_title','Receipt')

@section('content')
<div class="receipt card print-area">
    <div class="receipt-head">
        <div class="brand-mark receipt-logo">M</div>
        <div class="receipt-title">MarketSmart Supermarket</div>
        <p class="muted">Sales Receipt</p>
        <small>Transaction: {{ $sale->transaction_number }}</small>
    </div>

    <div class="card-body">
        <div class="receipt-meta">
            <span>Cashier: {{ $sale->cashier_name }}</span>
            <span>{{ $sale->created_at->format('d M Y, H:i') }}</span>
        </div>

        <div class="table-wrap">
            <table>
                <thead><tr><th>Product</th><th>Qty</th><th>Unit</th><th>Total</th></tr></thead>
                <tbody>
                @foreach($sale->items as $item)
                    <tr>
                        <td>{{ $item->product_name }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>{{ number_format($item->unit_price, 0) }}</td>
                        <td>{{ number_format($item->line_total, 0) }} FCFA</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <div class="receipt-total">
            <div class="total-row"><span>Subtotal</span><strong>{{ number_format($sale->subtotal, 0) }} FCFA</strong></div>
            <div class="total-row"><span>Discount</span><strong>− {{ number_format($sale->discount, 0) }} FCFA</strong></div>
            <div class="total-row grand"><span>Total Paid</span><span>{{ number_format($sale->total, 0) }} FCFA</span></div>
            <div class="total-row"><span>Payment</span><strong>{{ ucwords(str_replace('_',' ', $sale->payment_method)) }}</strong></div>
            <div class="total-row"><span>Change</span><strong>{{ number_format($sale->change_amount, 0) }} FCFA</strong></div>
        </div>

        <div class="receipt-footer">
            Thank you for shopping with MarketSmart.
        </div>

        
    </div>
</div>
<div class="no-print action-row">
            <button onclick="window.print()" class="btn btn-primary">Print Receipt</button>
            <a href="{{ route('cashier.quick-shop') }}" class="btn btn-light">New Sale</a>
            <script>
                function handlePrint() {
                    window.print();
                    setTimeout(() => {
                        window.location.reload();
                    }, 1000);
                }
                function handleNewSale(url) {
                    window.location.href = url;
                }
            </script>
        </div>
@endsection
