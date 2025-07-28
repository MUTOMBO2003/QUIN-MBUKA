@extends('layouts.client')

@section('title', 'Détail de la commande')

@section('content')
<div class="container mt-4">
    <h2 class="mb-3">🧾 Détail de la commande #{{ $commande->id }}</h2>

    <p><strong>Date :</strong> {{ $commande->created_at->format('d/m/Y à H:i') }}</p>
    <p><strong>Statut :</strong>
        <span class="badge
            @if($commande->statut === 'payée') bg-success
            @elseif($commande->statut === 'en attente') bg-warning text-dark
            @elseif($commande->statut === 'annulée') bg-danger
            @else bg-secondary @endif">
            {{ ucfirst($commande->statut) }}
        </span>
    </p>

    <table class="table table-bordered mt-3">
        <thead class="table-secondary">
            <tr>
                <th>Produit</th>
                <th>Quantité</th>
                <th>Prix unitaire</th>
                <th>Sous-total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($commande->details as $detail)
                <tr>
                    <td>{{ $detail->produit->nom }}</td>
                    <td>{{ $detail->quantite }}</td>
                    <td>{{ number_format($detail->prix_unitaire, 2, ',', ' ') }} FC</td>
                    <td>{{ number_format($detail->quantite * $detail->prix_unitaire, 2, ',', ' ') }} FC</td>
                </tr>
            @endforeach
            <tr class="table-light">
                <td colspan="3" class="text-end"><strong>Total :</strong></td>
                <td><strong>{{ number_format($commande->montant_total, 2, ',', ' ') }} FC</strong></td>
            </tr>
        </tbody>
    </table>

    {{-- Actions client : Modifier ou Annuler --}}
    <div class="mt-4 d-flex gap-2">
        @if($commande->statut === 'en attente')
            <a href="{{ route('client.commandes.edit', $commande->id) }}" class="btn btn-warning">
                <i class="fas fa-edit me-1"></i> Modifier la commande
            </a>
            <form action="{{ route('client.commandes.annuler', $commande->id) }}" method="POST" onsubmit="return confirm('Confirmer l\'annulation de cette commande ?')">
                @csrf
                @method('PATCH')
                <button class="btn btn-danger">
                    <i class="fas fa-times-circle me-1"></i> Annuler la commande
                </button>
            </form>
        @else
            <div class="alert alert-info">
                Cette commande ne peut plus être modifiée ou annulée.
            </div>
        @endif
    </div>
</div>
@endsection
