@extends('layouts.app')

@section('title', 'Plan du site')

@section('content')
<div class="container mt-5">
    <h2>Plan du site</h2>
    <ul>
        <li><a href="{{ route('home') }}">Accueil</a></li>
        <li><a href="{{ route('about') }}">À propos</a></li>
        <li><a href="{{ route('contact') }}">Contact</a></li>
        <li><a href="{{ route('client.produits.index') }}">Produits</a></li>
        <li><a href="{{ route('admin.promotions.index') }}">Promotions</a></li>
    </ul>
</div>
@endsection
