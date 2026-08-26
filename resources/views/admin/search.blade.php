@extends('admin.layouts.app')

@section('title', 'Search | MarketSmart Admin')

@section('content')
<div class="mb-4">
    <h4 class="mb-1">🔍 Global Search</h4>
    @if($q !== '')
        <p class="text-muted mb-0">“{{ $q }}” — <strong>{{ $total }}</strong> result(s) across the system</p>
    @else
        <p class="text-muted mb-0">Search products, sales, users, suppliers, categories, pages…</p>
    @endif
</div>

@if($q === '')
    <div class="admin-table-wrap">
        <p class="text-muted mb-0">Use the top search bar. Examples: <code>rice</code>, <code>Ange</code>, <code>cash</code>, <code>Hilton</code>, <code>expiry</code>, <code>profile</code></p>
    </div>
@elseif($total === 0)
    <div class="admin-table-wrap">
        <p class="text-muted mb-0">No results for “{{ $q }}”.</p>
    </div>
@else
    @php
        $labels = [
            'products' => '📦 Products',
            'sales' => '🧾 Sales / Receipts',
            'activities' => '📋 Activities',
            'notifications' => '🔔 Notifications',
            'suppliers' => '🚚 Suppliers',
            'categories' => '📁 Categories',
            'users' => '👤 Users',
            'reports' => '📄 Pages & Reports',
        ];
    @endphp

    @foreach($sections as $key => $items)
        @if($items->isNotEmpty())
        <div class="admin-table-wrap mb-3">
            <h6 class="mb-3">{{ $labels[$key] ?? $key }} ({{ $items->count() }})</h6>
            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>Type</th>
                            <th>Code / Ref</th>
                            <th>Name</th>
                            <th>Details</th>
                            @if($key === 'reports')
                                <th></th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($items as $item)
                        <tr>
                            <td>{{ $item->type }}</td>
                            <td>{{ $item->code }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->extra }}</td>
                            @if($key === 'reports' && isset($item->url))
                                <td><a href="{{ $item->url }}" class="btn btn-sm btn-outline-secondary">Open</a></td>
                            @endif
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif
    @endforeach
@endif
@endsection