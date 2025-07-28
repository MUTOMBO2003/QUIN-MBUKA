@extends('layouts.secretaire')

@section('title', 'Détails de la livraison')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">🔍 Détails de la livraison #{{ $livraison->id }}</h2>

    <div class="card">
        <div class="card-body">
            <p><strong>Commande :</strong> #{{ $livraison->commande_id }}</p>
            <p><strong>Adresse de livraison :</strong> {{ $livraison->adresse }}</p>
            <p><strong>Statut :</strong> 
                <span class="badge bg-{{ $livraison->statut == 'livrée' ? 'success' : ($livraison->statut == 'en_cours' ? 'warning text-dark' : 'secondary') }}">
                    {{ ucfirst($livraison->statut) }}
                </span>
            </p>
            <p><strong>Date de création :</strong> {{ $livraison->created_at->format('d/m/Y H:i') }}</p>
            <p><strong>Dernière mise à jour :</strong> {{ $livraison->updated_at->format('d/m/Y H:i') }}</p>
        </div>
    </div>

    <a href="{{ route('secretaire.livraisons.index') }}" class="btn btn-primary mt-3">⬅ Retour</a>
</div>
@endsection
