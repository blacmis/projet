@extends('cashier.layout')
@section('title','Profile | MarketSmart')
@section('page_title','Profile')

@section('content')
<div class="card mb-20">
    <div class="profile-head">
        <div class="profile-avatar">{{ strtoupper(substr($user->name ?? 'CA', 0, 2)) }}</div>
        <div>
            <h2 style="color:var(--navy)">{{ $user->name ?? 'Cashier' }}</h2>
            <p class="muted">{{ $user->email ?? 'cashier@marketsmart.cm' }}</p>
            <span class="badge badge-green">Active</span>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header"><h3>Personal Information</h3></div>
    <div class="card-body">
        @if(!$user)
            <div class="alert alert-error">No authenticated user was found. Add Laravel authentication before editing the profile.</div>
        @else
        <form method="POST" action="{{ route('cashier.profile.update') }}">
            @csrf
            @method('PUT')
            <div class="form-grid">
                <div class="form-group">
                    <label>FULL NAME</label>
                    <input class="form-control" name="name" value="{{ old('name', $user->name) }}" required>
                </div>
                <div class="form-group">
                    <label>EMAIL</label>
                    <input class="form-control" type="email" name="email" value="{{ old('email', $user->email) }}" required>
                </div>
                <div class="form-group">
                    <label>PHONE</label>
                    <input class="form-control" name="phone" value="{{ old('phone', $user->phone ?? '') }}">
                </div>
            </div>
            <div style="margin-top:20px"><button class="btn btn-primary">Save Changes</button></div>
        </form>
        @endif
    </div>
</div>
@endsection
