@extends('manager.layouts.app')

@section('title', 'Expiring Soon')
@section('page_title', 'Expiring Soon')

@section('content')
<a href="{{ route('manager.expired.index') }}" class="btn btn-link ps-0">← Retour à Expired & Damage Goods</a>

<div class="card p-3">
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead>
                <tr class="text-muted text-uppercase small">
                    <th>#</th><th>Product</th><th>Batch No</th><th>Expiry Date</th><th>Days Left</th><th>Quantity</th>
                </tr>
            </thead>
            <tbody>
                @forelse($batches as $i => $b)
                <tr>
                    <td>{{ $batches->firstItem() + $i }}</td>
                    <td>{{ $b->product->name ?? '—' }}</td>
                    <td>{{ $b->batch_no ?? '—' }}</td>
                    <td>{{ $b->expiry_date->format('d/m/Y') }}</td>
                    <td>
                        @php $days = now()->diffInDays($b->expiry_date, false); @endphp
                        <span class="badge {{ $days <= 7 ? 'bg-danger' : 'bg-warning text-dark' }}">{{ $days }} days</span>
                    </td>
                    <td>{{ $b->quantity }} units</td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center text-muted py-4">Aucun produit n'expire dans les 7 prochains jours.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    {{ $batches->links() }}
</div>
@endsection