@extends('layouts.client')

@section('title', 'Paiement en attente')

@section('content')
<div class="container mt-5 text-center">
    <h2 class="mb-4 text-primary">Paiement en attente de confirmation</h2>

    <div class="alert alert-info">
        <i class="fas fa-info-circle me-2"></i>
        Un message a été envoyé à votre téléphone. <br>
        Veuillez confirmer l'achat en saisissant votre code PIN Mobile Money.
    </div>

    <p class="mt-4 fs-6">
        Ne fermez pas cette page tant que vous n'avez pas confirmé le paiement.
    </p>

    <div class="spinner-border text-primary mt-3" role="status">
        <span class="visually-hidden">Chargement...</span>
    </div>

    <p class="mt-3">
        <strong>Référence transaction :</strong> {{ $transactionId }}
    </p>

    <a href="{{ route('client.commandes.index') }}" class="btn btn-secondary mt-4">
        <i class="fas fa-arrow-left me-1"></i> Retour aux commandes
    </a>
</div>
@endsection
