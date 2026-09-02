@extends('admin.layouts.app')
@section('title', 'Profile | MarketSmart Admin')
@section('content')
<h4 class="mb-4">Administrator Profile</h4>
@include('partials.profile-card', ['updateRoute' => 'admin.profile.update', 'photoRoute' => 'admin.profile.photo'])
@endsection