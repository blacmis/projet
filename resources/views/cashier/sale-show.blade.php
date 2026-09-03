@extends('cashier.layout')
@section('title','Sale Details | MarketSmart')
@section('page_title','Sale Details')

@section('content')
<div class="card receipt">
    <div class="card-header">
        <h3>{{ $sale->transaction_number }}</h3>
        <a href="{{ route('cashier.receipt', $sale) }}" class="btn btn-primary">Print Receipt</a>
    </div>
    <div class="card-body">
        <div class="receipt-meta">
            <span>{{ $sale->created_at->format('d M Y, H:i') }}</span>
            <span>{{ ucwords(str_replace('_',' ', $sale->payment_method)) }}</span>
        </div>
        <div class="table-wrap">
            <table>
                <thead><tr><th>Product</th><th>Qty</th><th>Unit Price</th><th>Total</th></tr></thead>
                <tbody>
                @foreach($sale->items as $item)
                    <tr>
                        <td>{{ $item->product_name }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>{{ number_format($item->unit_price, 0) }} FCFA</td>
                        <td>{{ number_format($item->line_total, 0) }} FCFA</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <div class="receipt-total">
            <div class="total-row"><span>Subtotal</span><strong>{{ number_format($sale->subtotal, 0) }} FCFA</strong></div>
            <div class="total-row"><span>Discount</span><strong>{{ number_format($sale->discount, 0) }} FCFA</strong></div>
            <div class="total-row grand"><span>Total</span><span>{{ number_format($sale->total, 0) }} FCFA</span></div>
        </div>
    </div>
</div>
@endsection
