@extends('super-admin.layouts.app')

@section('title', 'Nouveau supermarché | Super Admin')

@section('content')
<div class="form-card">
    <h4 class="mb-3">Créer un nouveau supermarché</h4>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('super-admin.tenants.store') }}">
        @csrf

        <div class="mb-3">
            <label class="form-label">Nom du supermarché</label>
            <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Secteur d'activité</label>
            <input type="text" name="sector" class="form-control" value="{{ old('sector') }}" placeholder="Alimentaire, Téléphonie, ...">
        </div>

        <hr>
        <p class="text-muted small">Ces informations créeront aussi le premier compte administrateur de ce supermarché.</p>

        <div class="mb-3">
            <label class="form-label">Nom de l'administrateur</label>
            <input type="text" name="owner_name" class="form-control" value="{{ old('owner_name') }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Email de l'administrateur</label>
            <input type="email" name="owner_email" class="form-control" value="{{ old('owner_email') }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Téléphone de l'administrateur</label>
            <input type="text" name="owner_phone" class="form-control" value="{{ old('owner_phone') }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Mot de passe de l'administrateur</label>
            <input type="password" name="admin_password" class="form-control" required minlength="6">
        </div>

        <button type="submit" class="btn btn-dark">Créer le supermarché</button>
    </form>
</div>
@endsection