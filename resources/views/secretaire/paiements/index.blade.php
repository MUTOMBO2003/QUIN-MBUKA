@extends('layouts.secretaire')

@section('title', 'Liste des paiements')

@section('content')
<style>
    .badge {
        font-size: 0.85rem;
        padding: 6px 12px;
        border-radius: 10px;
    }

    .ligne-payee {
        background-color: #e0f7fa !important;
    }

    .table td {
        vertical-align: middle;
    }

    /* Centrer la pagination */
    .pagination {
        justify-content: center;
    }

    .pagination .page-item.active .page-link {
        background-color: #007bff;
        border-color: #007bff;
        color: #fff;
    }

    .pagination .page-link {
        color: #007bff;
    }
</style>

<div class="container mt-4">
    <h2 class="mb-4">
        <i class="fas fa-money-check-alt me-2 text-primary"></i>
        Liste des paiements
    </h2>

    @if($paiements->count())
        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle">
                <thead class="table-dark text-center">
                    <tr>
                        <th>#</th>
                        <th>Transaction</th>
                        <th>Client</th>
                        <th>Montant</th>
                        <th>Statut</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($paiements as $paiement)
                        @php
                            $status = strtolower($paiement->statut);
                        @endphp
                        <tr class="{{ in_array($status, ['payé', 'payée']) ? 'ligne-payee' : '' }}">
                            <td class="text-center">{{ $paiement->id }}</td>
                            <td>{{ $paiement->transaction_id }}</td>
                            <td>{{ $paiement->commande->user->prenom }} {{ $paiement->commande->user->nom }}</td>
                            <td>{{ number_format($paiement->montant, 2, ',', ' ') }} FC</td>
                            <td class="text-center">
                                @if($status === 'payée' || $status === 'payé')
                                    <span class="badge bg-success">
                                        <i class="fas fa-check-circle me-1"></i> Payé
                                    </span>
                                @elseif($status === 'en attente')
                                    <span class="badge bg-warning text-dark">
                                        <i class="fas fa-clock me-1"></i> En attente
                                    </span>
                                @elseif($status === 'échoué' || $status === 'refusé')
                                    <span class="badge bg-danger">
                                        <i class="fas fa-times-circle me-1"></i> Échoué
                                    </span>
                                @else
                                    <span class="badge bg-secondary">{{ ucfirst($status) }}</span>
                                @endif
                            </td>
                            <td class="text-center">{{ $paiement->created_at->format('d/m/Y H:i') }}</td>
                            <td class="text-center">
                                <a href="{{ route('secretaire.paiements.show', $paiement->id) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-eye"></i> Voir
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Pagination centrée et propre --}}
        <div class="mt-3">
            {{ $paiements->links('pagination::bootstrap-5') }}
        </div>
    @else
        <div class="alert alert-info text-center">
            <i class="fas fa-info-circle me-2"></i>Aucun paiement trouvé.
        </div>
    @endif
</div>
@endsection
