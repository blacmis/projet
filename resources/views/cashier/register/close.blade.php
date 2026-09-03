@extends('cashier.layout')
@section('title','Fermeture de Caisse | MarketSmart')
@section('page_title','Fermeture de Caisse')

@section('content')
<div class="card mb-20" style="max-width:1300px;">
    <div class="card-header"><h3>Résumé de la session</h3></div>
    <div class="card-body">
        <p class="muted">Ouverte le {{ $session->opened_at->format('d/m/Y H:i') }} — {{ $salesCount }} vente(s) enregistrée(s)</p>

        <form method="POST" action="{{ route('cashier.register.close.store') }}">
            @csrf

            <div class="form-group mb-15">
                <label>CASH — attendu : {{ number_format($expectedCash, 0) }} FCFA</label>
                <input class="form-control" type="number" step="1" min="0" name="counted_cash" placeholder="Montant compté" required>
            </div>

            <div class="form-group mb-15">
                <label>MOBILE MONEY — attendu : {{ number_format($expectedMobile, 0) }} FCFA</label>
                <input class="form-control" type="number" step="1" min="0" name="counted_mobile_money" placeholder="Montant compté" required>
            </div>

            <div class="form-group mb-15">
                <label>CARD — attendu : {{ number_format($expectedCard, 0) }} FCFA</label>
                <input class="form-control" type="number" step="1" min="0" name="counted_card" placeholder="Montant compté" required>
            </div>

            <div class="form-group mb-15">
                <label>COMMENTAIRE (si écart)</label>
                <textarea class="form-control" name="closing_notes" rows="2"></textarea>
            </div>

            <button class="btn btn-primary" type="submit">Clôturer la caisse</button>
        </form>
    </div>
</div>
@endsection