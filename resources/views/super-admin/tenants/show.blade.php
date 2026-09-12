@extends('super-admin.layouts.app')

@section('title', $tenant->name . ' | Super Admin')

@section('content')
<div class="form-card">
    <h4 class="mb-1">{{ $tenant->name }}</h4>
    <p class="text-muted mb-3">
        <span class="badge-status badge-{{ $tenant->status === 'active' ? 'good' : ($tenant->status === 'pending' ? 'low' : 'out') }}">
            {{ ucfirst($tenant->status) }}
        </span>
    </p>

    <table class="table table-borderless mb-4">
        <tr><th>Secteur</th><td>{{ $tenant->sector ?? '—' }}</td></tr>
        <tr><th>Contact</th><td>{{ $tenant->owner_name }} — {{ $tenant->owner_email }} — {{ $tenant->owner_phone ?? '—' }}</td></tr>
        <tr><th>Souscrit le</th><td>{{ $tenant->subscribed_at?->format('d-m-Y') ?? '—' }}</td></tr>
        <tr><th>Comptes utilisateurs</th><td>{{ $tenant->users_count }}</td></tr>
    </table>

    <div class="d-flex gap-2">
        @if($tenant->status !== 'active')
            <form method="POST" action="{{ route('super-admin.tenants.activate', $tenant) }}">
                @csrf
                <button type="submit" class="btn btn-success">Activer</button>
            </form>
        @endif
        @if($tenant->status !== 'suspended')
            <form method="POST" action="{{ route('super-admin.tenants.suspend', $tenant) }}">
                @csrf
                <button type="submit" class="btn btn-danger">Suspendre</button>
            </form>
        @endif
        <a href="{{ route('super-admin.dashboard') }}" class="btn btn-outline-secondary">Retour</a>
    </div>
</div>
@endsection