@extends('layouts.client')

@section('title', 'Paiement CinetPay')

@section('content')
<div class="container mt-5 mb-5">
    <div class="text-center mb-4">
        <h3 class="fw-bold text-primary">
            <i class="fas fa-lock me-2"></i> Paiement sécurisé via CinetPay
        </h3>
        <p class="text-muted">Complétez votre paiement pour la commande n°{{ $commande->id }}</p>
    </div>

    {{-- Messages --}}
    @if(session('error'))
        <div class="alert alert-danger">
            <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
        </div>
    @endif

    @if(session('success'))
        <div class="alert alert-success">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
        </div>
    @endif

    {{-- Formulaire de paiement --}}
    <form method="POST" action="{{ route('client.paiements.payer', $commande->id) }}">
        @csrf

        <div class="mb-4">
            <label for="telephone" class="form-label">Numéro Mobile Money (Airtel / Orange)</label>
            <input type="text" name="telephone" id="telephone" class="form-control" placeholder="+243..." required>
        </div>

        <div class="text-center">
            <button type="submit" class="btn btn-success btn-lg w-100">
                <i class="fas fa-credit-card me-1"></i>
                Confirmer et Payer {{ number_format($commande->montant_total, 2, ',', ' ') }} CDF
            </button>
        </div>
    </form>
</div>
@endsection
