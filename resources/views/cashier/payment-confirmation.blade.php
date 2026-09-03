@extends('cashier.layout')
{{-- ⚠️ garde le même @extends que tes autres pages cashier --}}

@section('title', 'Confirmation de paiement | MarketSmart')

@section('content')
<style>
    .confirm-wrap {
        min-height: calc(100vh - 120px);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 1.5rem;
    }
    .confirm-card {
        width: 100%;
        max-width: 480px;
        background: #fff;
        border-radius: 20px;
        box-shadow: 0 10px 40px rgba(0,0,0,.08);
        padding: 2.5rem 2rem;
        text-align: center;
    }
    .confirm-icon {
        width: 96px;
        height: 96px;
        margin: 0 auto 1.25rem;
        border-radius: 50%;
        border: 5px solid #22c55e;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f0fdf4;
    }
    .confirm-title {
        font-size: 1.6rem;
        font-weight: 700;
        color: #111;
        margin-bottom: .35rem;
    }
    .confirm-subtitle {
        color: #6b7280;
        font-size: .95rem;
        margin-bottom: 1.5rem;
    }
    .confirm-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: .7rem 0;
        border-bottom: 1px solid #f3f4f6;
        font-size: 1rem;
    }
    .confirm-row:last-child {
        border-bottom: none;
    }
    .confirm-row .label {
        color: #6b7280;
        font-weight: 500;
    }
    .confirm-row .value {
        color: #111;
        font-weight: 700;
        text-align: right;
    }
    .confirm-actions {
        display: flex;
        justify-content: center;
        gap: 2.5rem;
        margin: 1.75rem 0 1.5rem;
    }
    .confirm-actions a {
        text-decoration: none;
        color: #374151;
        font-size: .9rem;
        font-weight: 600;
    }
    .confirm-actions a:hover {
        color: #c47a1a;
    }
    .confirm-actions .icon {
        font-size: 1.75rem;
        display: block;
        margin-bottom: .35rem;
    }
    .btn-okay {
        display: block;
        width: 100%;
        background: #111;
        color: #fff !important;
        border: none;
        border-radius: 999px;
        padding: .85rem 1rem;
        font-size: 1.05rem;
        font-weight: 700;
        text-decoration: none;
        transition: background .2s;
    }
    .btn-okay:hover {
        background: #333;
        color: #fff;
    }
</style>

<div class="confirm-wrap">
    <div class="confirm-card">

        <div class="confirm-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="#22c55e" viewBox="0 0 16 16">
                <path d="M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0z"/>
            </svg>
        </div>

        <h1 class="confirm-title">Transfert réussi !</h1>
        <p class="confirm-subtitle">
            Votre transaction a bien été soumise au traitement.
        </p>

        <div class="text-start mb-1">
            <div class="confirm-row">
                <span class="label">Montant transféré</span>
                <span class="value">{{ number_format($sale->total ?? 0, 2) }} FCFA</span>
            </div>
            <div class="confirm-row">
                <span class="label">N° transaction</span>
                <span class="value" style="font-size:.9rem;">{{ $sale->transaction_number ?? 'N/A' }}</span>
            </div>
            <div class="confirm-row">
                <span class="label">Mode de paiement</span>
                <span class="value">{{ ucwords(str_replace('_', ' ', $sale->payment_method ?? 'cash')) }}</span>
            </div>
            <div class="confirm-row">
                <span class="label">Montant payé</span>
                <span class="value">{{ number_format($sale->amount_paid ?? 0, 2) }} FCFA</span>
            </div>
            <div class="confirm-row">
                <span class="label">Monnaie</span>
                <span class="value">{{ number_format($sale->change_amount ?? 0, 2) }} FCFA</span>
            </div>
            <div class="confirm-row">
                <span class="label">Statut</span>
                <span class="value" style="color:#16a34a;">Vente terminée</span>
            </div>
        </div>

        <div class="confirm-actions">
            <a href="{{ route('cashier.receipt', $sale->id ?? null) }}">
                <span class="icon">▧</span>
                Partager le reçu
            </a>
            <a href="{{ route('cashier.payment') }}">
                <span class="icon">$</span>
                Nouvelle vente
            </a>
        </div>

        <a href="{{ route('cashier.payment') }}" class="btn-okay">
            D'accord
        </a>

    </div>
</div>
@endsection