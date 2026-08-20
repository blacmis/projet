@extends('cashier.layout')
@section('title','Sales History | MarketSmart')
@section('page_title','Sales History')

@section('content')
<div class="card">
    <div class="card-header">
        <h3>Sales Transactions</h3>
        <form class="filter-form" method="GET">
            <input class="form-control" name="search" placeholder="Transaction ID..." value="{{ request('search') }}">
            <select class="form-control" name="payment_method">
                <option value="">All Payments</option>
                <option value="cash" @selected(request('payment_method')==='cash')>Cash</option>
                <option value="mobile_money" @selected(request('payment_method')==='mobile_money')>Mobile Money</option>
                <option value="card" @selected(request('payment_method')==='card')>Card</option>
            </select>
            <button class="btn btn-primary">Filter</button>
        </form>
    </div>

    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Transaction ID</th><th>Date & Time</th><th>Items</th><th>Payment</th>
                    <th>Total</th><th>Status</th><th>Action</th>
                </tr>
            </thead>
            <tbody>
            @forelse($sales as $sale)
                <tr>
                    <td><strong>{{ $sale->transaction_number }}</strong></td>
                    <td>{{ $sale->created_at->format('d M Y, H:i') }}</td>
                    <td>{{ $sale->items->sum('quantity') }}</td>
                    <td>{{ ucwords(str_replace('_',' ', $sale->payment_method)) }}</td>
                    <td><strong>{{ number_format($sale->total, 0) }} FCFA</strong></td>
                    <td><span class="badge {{ $sale->status === 'completed' ? 'badge-green' : 'badge-red' }}">{{ ucfirst($sale->status) }}</span></td>
                    <td>
                        <a class="btn btn-light" href="{{ route('cashier.sale.show', $sale) }}">View <a class="btn btn-light" href="{{ route('cashier.receipt', $sale) }}"></a>
                    </td>
                </tr>
            @empty
                <tr><td colspan="7" class="empty-cell">No sales found.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>

    <div class="pagination">{{ $sales->links() }}</div>
</div>
@endsection
