@extends('layouts.app')

@section('title', 'Détails de la commande')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4 text-primary">📦 Détails de la commande #{{ $commande->id }}</h2>

    {{-- Informations client --}}
    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-primary text-white fw-bold">Informations du client</div>
        <div class="card-body">
            <p><strong>Nom :</strong> {{ $commande->user->prenom }} {{ $commande->user->nom }}</p>
            <p><strong>Email :</strong> {{ $commande->user->email }}</p>
        </div>
    </div>

    {{-- Informations commande --}}
    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-primary text-white fw-bold">Informations sur la commande</div>
        <div class="card-body">
            <p><strong>Montant total :</strong> {{ number_format($commande->montant_total, 2, ',', ' ') }} FC</p>
            <p><strong>Date de commande :</strong> {{ $commande->created_at->format('d/m/Y H:i') }}</p>
            <p><strong>Durée livraison :</strong> {{ $commande->duree_livraison ?? 'Non définie' }}</p>
            <p><strong>Statut commande :</strong>
                <span class="badge 
                    @if($commande->statut === 'payée') bg-success
                    @elseif($commande->statut === 'en cours de livraison') bg-info
                    @elseif($commande->statut === 'livrée') bg-primary
                    @else bg-warning text-dark @endif">
                    {{ ucfirst($commande->statut) }}
                </span>
            </p>
        </div>
    </div>

    {{-- Produits de la commande --}}
    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-primary text-white fw-bold">Produits commandés</div>
        <div class="card-body table-responsive">
            @if($commande->produits->count() > 0)
                <table class="table table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>Produit</th>
                            <th>Prix unitaire</th>
                            <th>Quantité</th>
                            <th>Sous-total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($commande->produits as $produit)
                            <tr>
                                <td>{{ $produit->nom }}</td>
                                <td>{{ number_format($produit->prix, 2, ',', ' ') }} FC</td>
                                <td>{{ $produit->pivot->quantite }}</td>
                                <td>{{ number_format($produit->prix * $produit->pivot->quantite, 2, ',', ' ') }} FC</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p class="text-muted">Aucun produit lié à cette commande.</p>
            @endif
        </div>
    </div>

    {{-- Bouton retour --}}
    <div class="mt-4">
        <a href="{{ route('admin.commandes.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Retour à la liste des commandes
        </a>
    </div>
</div>
@endsection
