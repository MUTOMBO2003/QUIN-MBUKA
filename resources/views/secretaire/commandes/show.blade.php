@extends('layouts.secretaire')

@section('title', 'Détails de la commande')

@section('content')
<div class="container mt-4">
    <a href="{{ route('secretaire.commandes.suivi') }}" class="btn btn-secondary mb-3">
        <i class="fas fa-arrow-left"></i> Retour
    </a>

    <h3>Détails de la commande #{{ $commande->id }}</h3>

    <div class="card shadow-sm mt-3">
        <div class="card-body">
            <p><strong>Client :</strong> {{ $commande->user->nom ?? 'Client inconnu' }}</p>
            <p><strong>Email :</strong> {{ $commande->user->email ?? 'Non renseigné' }}</p>
            <p><strong>Montant total :</strong> {{ number_format($commande->montant_total, 2) }} CDF</p>
            <p><strong>Date de commande :</strong> {{ $commande->created_at->format('d/m/Y H:i') }}</p>
            <p><strong>Statut :</strong> 
                <span class="badge 
                    @if($commande->statut === 'en attente') bg-warning text-dark
                    @elseif($commande->statut === 'en cours de livraison') bg-info
                    @elseif($commande->statut === 'livrée') bg-success
                    @endif">
                    {{ ucfirst($commande->statut) }}
                </span>
            </p>
            <p><strong>Durée estimée :</strong> {{ $commande->duree_livraison ?? 'Non définie' }}</p>
        </div>
    </div>

    @if($commande->articles && $commande->articles->count())
    <h5 class="mt-4">Articles commandés</h5>
    <div class="table-responsive mt-2">
        <table class="table table-bordered">
            <thead class="table-light">
                <tr>
                    <th>Produit</th>
                    <th>Quantité</th>
                    <th>Prix unitaire</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($commande->articles as $article)
                <tr>
                    <td>{{ $article->produit->nom ?? 'Produit supprimé' }}</td>
                    <td>{{ $article->quantite }}</td>
                    <td>{{ number_format($article->prix_unitaire, 2) }} CDF</td>
                    <td>{{ number_format($article->quantite * $article->prix_unitaire, 2) }} CDF</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif
</div>
@endsection
