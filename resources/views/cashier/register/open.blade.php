@extends('cashier.layout')
@section('title','Ouverture de Caisse | MarketSmart')
@section('page_title','Ouverture de Caisse')

@section('content')
<div class="card mb-20" style="max-width:1300px;">
    <div class="card-header"><h3>Ouvrir la caisse</h3></div>
    <div class="card-body">
        <p class="muted">Caissier : <strong>{{ $authUser->name }}</strong></p>

        <form method="POST" action="{{ route('cashier.register.store') }}">
            @csrf
            <div class="form-group mb-15">
                <label>MONTANT D'OUVERTURE (FOND DE CAISSE)</label>
                <input class="form-control" type="number" step="1" min="0" name="opening_amount" value="0" required>
            </div>
            <button class="btn btn-primary" type="submit">Ouvrir la caisse & commencer les ventes</button>
        </form>
    </div>
</div>

@if($recentSessions->count())
<div class="card" style="max-width:520px;">
    <div class="card-header"><h3>Historique récent</h3></div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead><tr><th>Date</th><th>Fond initial</th><th>Écart</th></tr></thead>
                <tbody>
                @foreach($recentSessions as $s)
                    <tr>
                        <td>{{ $s->opened_at->format('d/m/Y H:i') }}</td>
                        <td>{{ number_format($s->opening_amount, 0) }} FCFA</td>
                        <td>{{ $s->variance !== null ? number_format($s->variance, 0).' FCFA' : '—' }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endif
@endsection