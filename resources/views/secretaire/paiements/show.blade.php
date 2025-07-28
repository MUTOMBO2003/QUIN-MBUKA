@extends('layouts.secretaire')

@section('title', 'Détails du paiement')

@section('content')
<div class="container mt-4">
    <h2><i class="fas fa-receipt me-2 text-success"></i>Détails du paiement</h2>

    <div class="card mt-4">
        <div class="card-body">
            <h5 class="card-title">Référence de transaction : <strong>{{ $paiement->transaction_id }}</strong></h5>

            <ul class="list-group list-group-flush mt-3">
                <li class="list-group-item"><strong>Client :</strong> {{ $paiement->commande->user->prenom }} {{ $paiement->commande->user->nom }}</li>
                <li class="list-group-item"><strong>Montant :</strong> {{ number_format($paiement->montant, 2) }} FC</li>
                <li class="list-group-item"><strong>Statut :</strong>
                    @if($paiement->statut === 'payé' || $paiement->statut === 'payée')
                        <span class="badge bg-success"><i class="fas fa-check-circle me-1"></i>{{ ucfirst($paiement->statut) }}</span>
                    @elseif($paiement->statut === 'en attente')
                        <span class="badge bg-warning text-dark"><i class="fas fa-clock me-1"></i>En attente</span>
                    @else
                        <span class="badge bg-secondary">{{ ucfirst($paiement->statut) }}</span>
                    @endif
                </li>
                <li class="list-group-item"><strong>Date :</strong> {{ $paiement->created_at->format('d/m/Y à H:i') }}</li>
                <li class="list-group-item"><strong>Commande associée :</strong> #{{ $paiement->commande_id }}</li>
            </ul>

            <div class="mt-4">
                <a href="{{ route('secretaire.paiements.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left"></i> Retour à la liste
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
