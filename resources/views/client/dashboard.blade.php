@extends('layouts.client')

@section('title', 'Mon tableau de bord')

@section('content')
<style>
    .dashboard-card {
        background-color: #ffffff !important;
        border: 2px solid #b2ebf2;
        border-radius: 15px;
        transition: transform 0.2s;
        color: #007bff;
    }

    .dashboard-card:hover {
        transform: scale(1.03);
        box-shadow: 0 6px 20px rgba(0, 188, 212, 0.2);
    }

    .dashboard-card i {
        color: #00bcd4;
    }

    .dashboard-card .card-title {
        font-weight: bold;
        margin-top: 10px;
    }

    .dashboard-card .card-text {
        color: #333;
    }

    a.text-decoration-none:hover {
        text-decoration: none;
    }
</style>

<div class="container mt-5">
    <h2 class="mb-4 text-center">Bienvenue {{ Auth::user()->prenom }}</h2>

    <div class="row g-4">
        <!-- Catalogue Produits -->
        <div class="col-md-4">
            <a href="{{ route('client.produits.index') }}" class="text-decoration-none">
                <div class="card dashboard-card text-center shadow">
                    <div class="card-body">
                        <i class="fas fa-box-open fa-2x mb-2"></i>
                        <h5 class="card-title">Catalogue</h5>
                        <p class="card-text">Voir les produits disponibles</p>
                    </div>
                </div>
            </a>
        </div>

        <!-- Mon Panier -->
        <div class="col-md-4">
            <a href="{{ route('client.paniers.index') }}" class="text-decoration-none">
                <div class="card dashboard-card text-center shadow">
                    <div class="card-body">
                        <i class="fas fa-shopping-cart fa-2x mb-2"></i>
                        <h5 class="card-title">Mon panier</h5>
                        <p class="card-text">Voir les articles sélectionnés</p>
                    </div>
                </div>
            </a>
        </div>

        <!-- Commandes -->
        <div class="col-md-4">
            <a href="{{ route('client.commandes.index') }}" class="text-decoration-none">
                <div class="card dashboard-card text-center shadow">
                    <div class="card-body">
                        <i class="fas fa-clipboard-list fa-2x mb-2"></i>
                        <h5 class="card-title">Mes commandes</h5>
                        <p class="card-text">Historique et suivi</p>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>
@endsection
