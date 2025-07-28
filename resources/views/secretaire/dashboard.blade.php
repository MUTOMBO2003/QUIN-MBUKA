@extends('layouts.secretaire')

@section('title', 'Tableau de bord')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm border-0 rounded-4 bg-white mb-4">
        <div class="card-body">
            <h2 class="mb-0 text-primary">
                <i class="fas fa-tachometer-alt me-2"></i>Tableau de bord Secrétaire
            </h2>
        </div>
    </div>

    <div class="row">
        <!-- Carte : Suivi Commandes -->
        <div class="col-md-4 mb-4">
            <a href="{{ route('secretaire.commandes.suivi') }}" class="text-decoration-none">
                <div class="card bg-white text-center shadow-sm border-0 rounded-4">
                    <div class="card-body py-4">
                        <i class="fas fa-box fa-3x text-primary mb-3"></i>
                        <h5 class="card-title text-dark">Suivi des commandes</h5>
                        <p class="card-text text-muted">Gérer l’état et les durées de livraison</p>
                    </div>
                </div>
            </a>
        </div>

        <!-- Carte : Paiements -->
        <div class="col-md-4 mb-4">
            <a href="{{ route('secretaire.paiements.index') }}" class="text-decoration-none">
                <div class="card bg-white text-center shadow-sm border-0 rounded-4">
                    <div class="card-body py-4">
                        <i class="fas fa-credit-card fa-3x text-success mb-3"></i>
                        <h5 class="card-title text-dark">Paiements</h5>
                        <p class="card-text text-muted">Voir tous les paiements effectués</p>
                    </div>
                </div>
            </a>
        </div>

        <!-- ✅ Carte : Livraisons -->
        <div class="col-md-4 mb-4">
            <a href="{{ route('secretaire.livraisons.index') }}" class="text-decoration-none">
                <div class="card bg-white text-center shadow-sm border-0 rounded-4">
                    <div class="card-body py-4">
                        <i class="fas fa-truck fa-3x text-warning mb-3"></i>
                        <h5 class="card-title text-dark">Livraisons</h5>
                        <p class="card-text text-muted">Consulter et mettre à jour les livraisons</p>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>
@endsection
