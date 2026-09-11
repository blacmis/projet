@extends('super-admin.layouts.app')

@section('title', 'Supermarchés | Super Admin')

@section('content')
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="stat-card">
            <p class="stat-value">{{ $stats->total }}</p>
            <p class="stat-label">Supermarchés au total</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <p class="stat-value">{{ $stats->active }}</p>
            <p class="stat-label">Actifs</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <p class="stat-value">{{ $stats->pending }}</p>
            <p class="stat-label">En attente</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <p class="stat-value">{{ $stats->suspended }}</p>
            <p class="stat-label">Suspendus</p>
        </div>
    </div>
</div>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0">Liste des supermarchés</h4>
    <a href="{{ route('super-admin.tenants.create') }}" class="btn btn-dark btn-sm">+ Nouveau supermarché</a>
</div>

<div class="table-wrap">
    <table class="table">
        <thead>
            <tr>
                <th>Nom</th>
                <th>Secteur</th>
                <th>Statut</th>
                <th>Souscrit le</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($tenants as $tenant)
                <tr>
                    <td><a href="{{ route('super-admin.tenants.show', $tenant) }}">{{ $tenant->name }}</a></td>
                    <td>{{ $tenant->sector ?? '—' }}</td>
                    <td>
                        <span class="badge-status badge-{{ $tenant->status === 'active' ? 'good' : ($tenant->status === 'pending' ? 'low' : 'out') }}">
                            {{ ucfirst($tenant->status) }}
                        </span>
                    </td>
                    <td>{{ $tenant->subscribed_at?->format('d-m-Y') ?? '—' }}</td>
                    <td>
                        @if($tenant->status !== 'active')
                            <form method="POST" action="{{ route('super-admin.tenants.activate', $tenant) }}" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-success">Activer</button>
                            </form>
                        @endif
                        @if($tenant->status !== 'suspended')
                            <form method="POST" action="{{ route('super-admin.tenants.suspend', $tenant) }}" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-danger">Suspendre</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @empty
                <tr><td colspan="5">Aucun supermarché pour l'instant.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection