@extends('cashier.layout')
@section('title','Payment Confirmation | MarketSmart')
@section('page_title','Payment Confirmation')

@section('content')
<div class="card confirmation-card">
    <div class="card-body">
        <div class="success-circle">✓</div>
        <h2>Payment Successful</h2>
        <p class="muted">Transaction <strong>{{ $sale->transaction_number }}</strong> was completed.</p>

        <div class="confirmation-total">
            <small>Amount Paid</small>
            <strong>{{ number_format($sale->total, 0) }} FCFA</strong>
        </div>

        <div class="confirmation-details">
            <div><span>Payment</span><strong>{{ ucwords(str_replace('_',' ', $sale->payment_method)) }}</strong></div>
            <div><span>Amount received</span><strong>{{ number_format($sale->amount_paid, 0) }} FCFA</strong></div>
            <div><span>Change</span><strong>{{ number_format($sale->change_amount, 0) }} FCFA</strong></div>
        </div>

        <div class="action-row">
            <a href="{{ route('cashier.receipt', $sale) }}" class="btn btn-primary">View Receipt</a>
            <a href="{{ route('cashier.payment') }}" class="btn btn-light">New Sale</a>
        </div>
    </div>
</div>
@endsection
