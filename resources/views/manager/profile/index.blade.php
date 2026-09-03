@extends('manager.layouts.app')
@section('page_title', 'My Profile')
@section('content')
<div class="page-header">
    <h4 class="page-title">Inventory Manager Profile</h4>
</div>
@include('partials.profile-card', ['updateRoute' => 'manager.profile.update', 'photoRoute' => 'manager.profile.photo'])
@endsection