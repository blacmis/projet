@extends('cashier.layout')
@section('title','Daily Summary | MarketSmart')
@section('page_title','Daily Summary')

@section('content')
<div class="grid grid-4 mb-20"> 
            @csrf
    <div class="card stat"><div class="stat-icon">₣</div><div><h4>{{ number_format($revenue,0) }}</h4><p>Today's Revenue</p></div></div>
    <div class="card stat"><div class="stat-icon">▤</div><div><h4>{{ $salesCount }}</h4><p>Total Sales</p></div></div>
    <div class="card stat"><div class="stat-icon">🛒</div><div><h4>{{ $itemsSold }}</h4><p>Items Sold</p></div></div>
    <div class="card stat"><div class="stat-icon">↩</div><div><h4>{{ $refunds }}</h4><p>Refunds</p></div></div>
</div>

<div class="grid grid-2">
    <div class="card">
        <div class="card-header"><h3>Sales Performance</h3><span class="muted">Today</span></div>
        <div class="chart">
            @php $max = max(1, $hourly->max() ?? 1); @endphp
            @forelse($hourly as $hour => $value)
                <div class="bar" style="height: {{ max(8, ($value / $max) * 85) }}%">
                    <span>{{ $hour }}</span>
                </div>
            @empty
                <div class="empty-state" style="width:100%">No sales recorded today.</div>
            @endforelse
        </div>
    </div>

    <div class="card">
        <div class="card-header"><h3>Payment Breakdown</h3></div>
        <div class="card-body">
            <div class="total-row"><span>Cash</span><strong>{{ number_format($cash,0) }} FCFA</strong></div>
            <div class="total-row"><span>Mobile Money</span><strong>{{ number_format($mobileMoney,0) }} FCFA</strong></div>
            <div class="total-row"><span>Card</span><strong>{{ number_format($card,0) }} FCFA</strong></div>
            <div class="total-row grand"><span>Total</span><span>{{ number_format($revenue,0) }} FCFA</span></div>
        </div>
    </div>
</div>
@endsection
    