@extends('cashier.layout')
@section('title','Profile | MarketSmart')
@section('page_title','Profile')
@section('content')
@include('partials.profile-card', ['updateRoute' => 'cashier.profile.update', 'photoRoute' => 'cashier.profile.photo'])
@endsection