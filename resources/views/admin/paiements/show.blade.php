@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h2>Détail du paiement</h2>

    <div class="card mt-3">
        <div class="card-header bg-info text-white">
            Paiement #{{ $paiement->id }}
        </div>
        <div class="card-body">
            <p><strong>Référence :</strong> {{ $paiement->reference }}</p>
            <p><strong>Montant :</strong> {{ number_format($paiement->montant, 2) }} $</p>
            <p><strong>Moyen de paiement :</strong> {{ $paiement->moyen ?? 'Non spécifié' }}</p>
            <p><strong>Statut :</strong>
                <span class="badge 
                    @if($paiement->statut === 'payé') bg-success 
                    @elseif($paiement->statut === 'en attente') bg-warning 
                    @else bg-danger 
                    @endif">
                    {{ ucfirst($paiement->statut) }}
                </span>
            </p>
            <p><strong>Date :</strong> {{ $paiement->created_at->format('d/m/Y à H:i') }}</p>
        </div>
    </div>

    <div class="card mt-4">
        <div class="card-header bg-secondary text-white">
            Informations de la commande liée
        </div>
        <div class="card-body">
            <p><strong>ID Commande :</strong> {{ $paiement->commande->id }}</p>
            <p><strong>Client :</strong> {{ $paiement->commande->user->prenom }} {{ $paiement->commande->user->nom }}</p>
            <p><strong>Statut de la commande :</strong> {{ ucfirst($paiement->commande->statut) }}</p>
            <a href="{{ route('admin.commandes.show', $paiement->commande) }}" class="btn btn-outline-primary">
                Voir la commande
            </a>
        </div>
    </div>

    <a href="{{ route('admin.paiements.index') }}" class="btn btn-secondary mt-3">Retour à la liste</a>
</div>
@endsection