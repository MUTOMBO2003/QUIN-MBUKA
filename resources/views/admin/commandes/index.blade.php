@extends('layouts.app')

@section('title', 'Liste des commandes')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4">📦 Commandes clients</h2>

    {{-- Message de succès --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Formulaire de filtre --}}
    <form method="GET" action="{{ route('admin.commandes.index') }}" class="row g-3 align-items-center mb-4">
        <div class="col-auto">
            <label for="statut" class="col-form-label fw-bold">Filtrer par statut :</label>
        </div>
        <div class="col-auto">
            <select name="statut" id="statut" class="form-select">
                <option value="">-- Tous --</option>
                <option value="en attente" {{ request('statut') == 'en attente' ? 'selected' : '' }}>En attente</option>
                <option value="en cours de livraison" {{ request('statut') == 'en cours de livraison' ? 'selected' : '' }}>En cours de livraison</option>
                <option value="livrée" {{ request('statut') == 'livrée' ? 'selected' : '' }}>Livrée</option>
                <option value="payée" {{ request('statut') == 'payée' ? 'selected' : '' }}>Payée</option>
            </select>
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-primary">Appliquer</button>
        </div>
    </form>

    {{-- Liste des commandes --}}
    @if($commandes->count() > 0)
        <div class="table-responsive">
            <table class="table table-striped table-bordered align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>#ID</th>
                        <th>Client</th>
                        <th>Total</th>
                        <th>Durée livraison</th>
                        <th>Temps écoulé</th>
                        <th>Date</th>
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($commandes as $commande)
                        <tr>
                            <td>{{ $commande->id }}</td>
                            <td>{{ $commande->user->prenom }} {{ $commande->user->nom }}</td>
                            <td>{{ number_format($commande->montant_total, 2, ',', ' ') }} FC</td>
                            <td>{{ $commande->duree_livraison ?? 'Non définie' }}</td>
                            <td>{{ now()->diffInHours($commande->created_at) }} h</td>
                            <td>{{ $commande->created_at->format('d/m/Y H:i') }}</td>
                            <td>
                                <span class="badge 
                                    @if($commande->statut === 'payée') bg-success
                                    @elseif($commande->statut === 'en cours de livraison') bg-info
                                    @elseif($commande->statut === 'livrée') bg-primary
                                    @else bg-warning text-dark @endif">
                                    {{ ucfirst($commande->statut) }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('admin.commandes.show', $commande) }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-eye"></i> Détails
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="alert alert-info text-center">
            Aucune commande trouvée pour ce filtre.
        </div>
    @endif
</div>
@endsection
