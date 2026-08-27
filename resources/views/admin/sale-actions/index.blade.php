@extends('admin.layouts.app')
@section('title', 'Sales Control | MarketSmart Admin')
@section('content')
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="stat-card">
            <p class="stat-value">{{ $stats->total }}</p>
            <p class="stat-label">Total Sales</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <p class="stat-value">{{ $stats->completed }}</p>
            <p class="stat-label">Completed</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <p class="stat-value">{{ $stats->cancelled }}</p>
            <p class="stat-label">Cancelled</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <p class="stat-value">{{ number_format($stats->revenue) }}</p>
            <p class="stat-label">Revenue (XAF)</p>
        </div>
    </div>
</div>
<div class="admin-table-wrap">
    <h5 class="mb-3">🧾 Sales Control (Admin)</h5>
    <form method="GET" class="d-flex gap-2 flex-wrap mb-3">
        <input type="text" name="q" value="{{ request('q') }}" class="form-control form-control-sm"
               placeholder="Receipt, cashier..." style="max-width:200px;">
        <select name="status" class="form-select form-select-sm" style="width:auto;" onchange="this.form.submit()">
            <option value="all">All status</option>
            <option value="Completed" {{ request('status')=='Completed'?'selected':'' }}>Completed</option>
            <option value="Cancelled" {{ request('status')=='Cancelled'?'selected':'' }}>Cancelled</option>
        </select>
        <select name="payment" class="form-select form-select-sm" style="width:auto;" onchange="this.form.submit()">
            <option value="all">All payments</option>
            <option value="Cash" {{ request('payment')=='Cash'?'selected':'' }}>Cash</option>
            <option value="Card" {{ request('payment')=='Card'?'selected':'' }}>Card</option>
            <option value="Mobile Money" {{ request('payment')=='Mobile Money'?'selected':'' }}>Mobile Money</option>
        </select>
        <button class="btn btn-sm btn-outline-secondary">Filter</button>
    </form>
    @if(session('success'))
        <div class="alert alert-success py-2">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger py-2">{{ session('error') }}</div>
    @endif
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>Receipt</th>
                    <th>Date / Time</th>
                    <th>Cashier</th>
                    <th>Items</th>
                    <th>Amount</th>
                    <th>Payment</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($sales as $s)
                <tr style="{{ $s['status']==='Cancelled' ? 'opacity:0.65;' : '' }}">
                    <td>{{ $s['receipt_no'] }}</td>
                    <td>{{ $s['date_time'] }}</td>
                    <td>{{ $s['cashier'] }}</td>
                    <td>{{ $s['items'] }}</td>
                    <td>{{ number_format($s['amount']) }} XAF</td>
                    <td>{{ $s['payment_method'] }}</td>
                    <td>
                        @if($s['status'] === 'Completed')
                            <span class="badge-status badge-good">Completed</span>
                        @else
                            <span class="badge-status badge-out">Cancelled</span>
                        @endif
                    </td>
                    <td class="text-nowrap">
                        @if($s['status'] === 'Completed')
                            <form method="POST" action="{{ route('admin.sale-actions.cancel', $s['id']) }}" class="d-inline"
                                  onsubmit="return confirm('Annuler cette vente ?')">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-outline-danger">Cancel</button>
                            </form>
                        @else
                            <form method="POST" action="{{ route('admin.sale-actions.restore', $s['id']) }}" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-outline-success">Restore</button>
                            </form>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection