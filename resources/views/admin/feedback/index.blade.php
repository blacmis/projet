@extends('admin.layouts.app')

@section('title', 'Support | MarketSmart Admin')

@section('content')
<div class="row g-3">
    <div class="col-lg-5">
        <div class="admin-table-wrap">
            <h5 class="mb-3">Écrire à MarketSmart</h5>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <form method="POST" action="{{ route('admin.feedback.store') }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Type de message</label>
                    <select name="type" class="form-select" required>
                        <option value="suggestion">Suggestion d'amélioration</option>
                        <option value="complaint">Réclamation / problème</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Votre message</label>
                    <textarea name="message" class="form-control" rows="5" placeholder="Décrivez votre suggestion ou le problème rencontré..." required></textarea>
                </div>
                <button type="submit" class="btn btn-orange">Envoyer</button>
            </form>
        </div>
    </div>

    <div class="col-lg-7">
        <div class="admin-table-wrap">
            <h5 class="mb-3">Historique de vos messages</h5>
            <table class="table">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Type</th>
                        <th>Message</th>
                        <th>Statut</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($items as $item)
                        <tr>
                            <td>{{ $item->created_at->format('d-m-Y H:i') }}</td>
                            <td>
                                <span class="badge-status badge-{{ $item->type === 'complaint' ? 'out' : 'good' }}">
                                    {{ $item->type === 'complaint' ? 'Réclamation' : 'Suggestion' }}
                                </span>
                            </td>
                            <td style="max-width:320px;">{{ $item->message }}</td>
                            <td>
                                <span class="badge-status badge-{{ $item->status === 'new' ? 'low' : 'good' }}">
                                    {{ $item->status === 'new' ? 'En attente' : 'Lu par MarketSmart' }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="4">Aucun message envoyé pour l'instant.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection