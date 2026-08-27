@extends('admin.layouts.app')
@section('title', 'Stock Control | MarketSmart Admin')
@section('content')
<div class="admin-table-wrap">
    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
        <h5 class="mb-0">📦 Stock Control (Admin)</h5>
    </div>
    <form method="GET" class="d-flex gap-2 flex-wrap mb-3">
        <input type="text" name="q" value="{{ request('q') }}" class="form-control form-control-sm"
               placeholder="Search product..." style="max-width:200px;">
        <select name="status" class="form-select form-select-sm" style="width:auto;" onchange="this.form.submit()">
            <option value="all">All status</option>
            <option value="In Stock" {{ request('status')=='In Stock'?'selected':'' }}>In Stock</option>
            <option value="Low Stock" {{ request('status')=='Low Stock'?'selected':'' }}>Low Stock</option>
            <option value="Out of Stock" {{ request('status')=='Out of Stock'?'selected':'' }}>Out of Stock</option>
            <option value="Unavailable" {{ request('status')=='Unavailable'?'selected':'' }}>Unavailable</option>
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
                    <th>Code</th>
                    <th>Product</th>
                    <th>Category</th>
                    <th>Stock</th>
                    <th>Min</th>
                    <th>Status</th>
                    <th>Adjust stock</th>
                    <th>Set status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $p)
                <tr>
                    <td>{{ $p['code'] }}</td>
                    <td>{{ $p['name'] }}</td>
                    <td>{{ $p['category'] }}</td>
                    <td><strong>{{ $p['stock'] }}</strong></td>
                    <td>{{ $p['min_stock'] }}</td>
                    <td>{{ $p['status'] }}</td>
                    <td>
                        <form method="POST" action="{{ route('admin.inventory-actions.adjust', $p['id']) }}" class="d-flex gap-1 align-items-center">
                            @csrf
                            <select name="type" class="form-select form-select-sm" style="width:auto;">
                                <option value="add">+</option>
                                <option value="remove">−</option>
                                <option value="set">=</option>
                            </select>
                            <input type="number" name="quantity" min="0" value="1" class="form-control form-control-sm" style="width:70px;" required>
                            <button class="btn btn-sm btn-outline-primary">OK</button>
                        </form>
                    </td>
                    <td>
                        <form method="POST" action="{{ route('admin.inventory-actions.status', $p['id']) }}" class="d-flex gap-1">
                            @csrf
                            <select name="status" class="form-select form-select-sm" style="width:auto;">
                                <option value="In Stock">In Stock</option>
                                <option value="Low Stock">Low Stock</option>
                                <option value="Out of Stock">Out of Stock</option>
                                <option value="Unavailable">Unavailable</option>
                            </select>
                            <button class="btn btn-sm btn-outline-secondary">Set</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection