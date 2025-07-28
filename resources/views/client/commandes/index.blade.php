@extends('layouts.client')

@section('title', 'Mes commandes')

@section('content')
<div class="container mt-5">
    <div class="text-center mb-4">
        <h2 class="fw-bold text-primary"><i class="fas fa-shopping-cart me-2"></i>Mes commandes</h2>
    </div>

    {{-- Messages --}}
    @if(session('success'))
        <div class="alert alert-success"><i class="fas fa-check-circle me-2"></i> {{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger"><i class="fas fa-exclamation-triangle me-2"></i> {{ session('error') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-warning">
            <strong>Erreurs détectées :</strong>
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li><i class="fas fa-bug me-1"></i>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if($commandes->count())
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle text-center">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Montant total</th>
                        <th>Statut commande</th>
                        <th>Paiement</th>
                        <th>Durée livraison</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($commandes as $commande)
                        <tr>
                            <td>{{ $commande->id }}</td>
                            <td>{{ number_format($commande->montant_total, 0, ',', ' ') }} FC</td>

                            {{-- Statut commande --}}
                            <td>
                                @php
                                    $statut = strtolower($commande->statut);
                                @endphp
                                @switch($statut)
                                    @case('livrée')
                                        <span class="badge bg-primary">Livrée</span>
                                        @break
                                    @case('en cours de livraison')
                                        <span class="badge bg-info text-white">En cours</span>
                                        @break
                                    @case('payée')
                                        <span class="badge bg-success">Payée</span>
                                        @break
                                    @case('non payée')
                                        <span class="badge bg-danger">Non payée</span>
                                        @break
                                    @default
                                        <span class="badge bg-warning text-dark">En attente</span>
                                @endswitch
                            </td>

                            {{-- Statut paiement --}}
                            <td>
                                @php $paiement = $commande->paiement ?? null; @endphp
                                @if($paiement && $paiement->statut === 'payée')
                                    <span class="badge bg-success">Payée</span>
                                @else
                                    <span class="badge bg-danger">Non payée</span>
                                @endif
                            </td>

                            <td>{{ $commande->duree_livraison ?? 'Non définie' }}</td>
                            <td>{{ $commande->created_at->format('d/m/Y') }}</td>

                            <td>
                                <a href="{{ route('client.commandes.show', $commande) }}" class="btn btn-sm btn-info mb-1">
                                    <i class="fas fa-eye"></i> Voir
                                </a>

                                {{-- Paiement intégré CinetPay --}}
                                @if(!$paiement || $paiement->statut !== 'payée')
                                    <button onclick="checkout({{ $commande->id }}, {{ $commande->montant_total }})" class="btn btn-sm btn-success mb-1">
                                        <i class="fas fa-credit-card"></i> Payer
                                    </button>
                                @endif

                                {{-- Livraison disponible seulement si payé --}}
                                @if($paiement && $paiement->statut === 'payée')
                                    <a href="{{ route('client.livraisons.create', $commande) }}" class="btn btn-sm btn-primary mt-1">
                                        <i class="fas fa-truck"></i> Livraison
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="alert alert-info text-center mt-4">
            <i class="fas fa-info-circle me-2"></i> Aucune commande enregistrée.
        </div>
    @endif
</div>

{{-- Script CinetPay --}}
<script src="https://cdn.cinetpay.com/seamless/main.js"></script>
<script>
    function checkout(commandeId, montant) {
        const transactionId = 'CMD_' + Math.random().toString(36).substr(2, 9).toUpperCase();

        CinetPay.setConfig({
            apikey: '39378926168021035595416.34524459',
            site_id: '105892564',
            notify_url: '{{ route('client.paiements.notify') }}',
            mode: 'PRODUCTION'
        });

        CinetPay.getCheckout({
            transaction_id: transactionId,
            amount: montant,
            currency: 'CDF',
            channels: 'ALL',
            description: 'Paiement commande #' + commandeId,
            openInNewTab: true
        });

        CinetPay.waitResponse(function(data) {
            if (data.status === "ACCEPTED") {
                window.location.href = "/client/paiements/" + commandeId + "?transaction_id=" + transactionId + "&mode=cinetpay";
            } else if (data.status === "REFUSED") {
                alert("❌ Paiement refusé. Vous pouvez réessayer.");
                window.location.reload();
            }
        });

        CinetPay.onError(function(data) {
            alert("⚠️ Erreur technique : " + data.description);
        });
    }
</script>
@endsection
