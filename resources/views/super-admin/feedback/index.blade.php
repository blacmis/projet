@extends('super-admin.layouts.app')

@section('title', 'Réclamations & suggestions | Super Admin')

@section('content')
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="stat-card">
            <p class="stat-value">{{ $stats->total }}</p>
            <p class="stat-label">Messages au total</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <p class="stat-value">{{ $stats->new }}</p>
            <p class="stat-label">Non lus</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <p class="stat-value">{{ $stats->complaints }}</p>
            <p class="stat-label">Réclamations</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <p class="stat-value">{{ $stats->suggestions }}</p>
            <p class="stat-label">Suggestions</p>
        </div>
    </div>
</div>

<div class="table-wrap">
    <table class="table">
        <thead>
            <tr>
                <th>Supermarché</th>
                <th>Envoyé par</th>
                <th>Type</th>
                <th>Message</th>
                <th>Reçu le</th>
                <th>Statut</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($items as $item)
                <tr>
                    <td>{{ $item->tenant->name ?? '—' }}</td>
                    <td>{{ $item->sender->name ?? '—' }}</td>
                    <td>
                        <span class="badge-status badge-{{ $item->type === 'complaint' ? 'out' : 'good' }}">
                            {{ $item->type === 'complaint' ? 'Réclamation' : 'Suggestion' }}
                        </span>
                    </td>
                    <td style="max-width:280px;">{{ $item->message }}</td>
                    <td>{{ $item->created_at->format('d-m-Y H:i') }}</td>
                    <td>
                        <span class="badge-status badge-{{ $item->status === 'new' ? 'low' : 'good' }}">
                            {{ $item->status === 'new' ? 'Non lu' : 'Lu' }}
                        </span>
                    </td>
                    <td>
                        @if($item->status === 'new')
                            <form method="POST" action="{{ route('super-admin.feedback.read', $item) }}">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-outline-secondary">Marquer comme lu</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @empty
                <tr><td colspan="7">Aucun message pour l'instant.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection