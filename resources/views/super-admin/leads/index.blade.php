@extends('super-admin.layouts.app')

@section('title', 'Demandes reçues | Super Admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0">Demandes reçues</h4>
</div>

<div class="table-wrap">
    <table class="table">
        <thead>
            <tr>
                <th>Nom</th>
                <th>Contact</th>
                <th>Supermarché</th>
                <th>Message</th>
                <th>Reçu le</th>
            </tr>
        </thead>
        <tbody>
            @forelse($leads as $lead)
                <tr>
                    <td>{{ $lead->name }}</td>
                    <td>{{ $lead->email }}{{ $lead->phone ? ' — '.$lead->phone : '' }}</td>
                    <td>{{ $lead->market_name ?? '—' }}</td>
                    <td style="max-width:320px;">{{ $lead->message ?? '—' }}</td>
                    <td>{{ $lead->created_at->format('d-m-Y H:i') }}</td>
                </tr>
            @empty
                <tr><td colspan="5">Aucune demande pour l'instant.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection