@extends('layouts.secretaire')

@section('title', 'Suivi des commandes')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Suivi des commandes client</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Filtres -->
    <form method="GET" class="mb-4">
        <div class="row g-2 align-items-end">
            <div class="col-md-4">
                <label for="statut" class="form-label">Filtrer par statut</label>
                <select name="statut" id="statut" class="form-select">
                    <option value="">-- Tous les statuts --</option>
                    <option value="en attente" {{ request('statut') == 'en attente' ? 'selected' : '' }}>En attente</option>
                    <option value="en cours de livraison" {{ request('statut') == 'en cours de livraison' ? 'selected' : '' }}>En cours de livraison</option>
                    <option value="livrée" {{ request('statut') == 'livrée' ? 'selected' : '' }}>Livrée</option>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">Filtrer</button>
            </div>
        </div>
    </form>

    @if($commandes->isEmpty())
        <div class="alert alert-info">Aucune commande disponible.</div>
    @else
        <table class="table table-bordered table-hover">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Client</th>
                    <th>Montant</th>
                    <th>Date</th>
                    <th>Statut</th>
                    <th>Durée estimée</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($commandes as $commande)
                <tr>
                    <td>{{ $commande->id }}</td>
                    <td>{{ $commande->user->nom ?? 'Client' }}</td>
                    <td>{{ number_format($commande->montant_total, 2) }} CDF</td>
                    <td>{{ $commande->created_at->format('d/m/Y H:i') }}</td>
                    <td>
                        <span class="badge 
                            @if($commande->statut === 'en attente') bg-warning text-dark
                            @elseif($commande->statut === 'en cours de livraison') bg-info
                            @elseif($commande->statut === 'livrée') bg-success
                            @endif">
                            {{ ucfirst($commande->statut) }}
                        </span>
                    </td>
                    <td>{{ $commande->duree_livraison ?? 'Non définie' }}</td>
                    <td class="d-flex flex-wrap gap-1">
                        <!-- Bouton Modifier -->
                        <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editModal{{ $commande->id }}">
                            Modifier
                        </button>

                        <!-- Bouton Détails -->
                        <a href="{{ route('secretaire.commandes.show', $commande->id) }}" class="btn btn-sm btn-info">
                            Détails
                        </a>
                    </td>
                </tr>

                <!-- Modal de modification -->
                <div class="modal fade" id="editModal{{ $commande->id }}" tabindex="-1">
                    <div class="modal-dialog">
                        <form method="POST" action="{{ route('secretaire.commandes.update', $commande->id) }}">
                            @csrf
                            @method('PUT')
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Modifier la commande #{{ $commande->id }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label for="statut" class="form-label">Statut</label>
                                        <select name="statut" class="form-select" required>
                                            <option value="en attente" @selected($commande->statut === 'en attente')>En attente</option>
                                            <option value="en cours de livraison" @selected($commande->statut === 'en cours de livraison')>En cours de livraison</option>
                                            <option value="livrée" @selected($commande->statut === 'livrée')>Livrée</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="duree_livraison" class="form-label">Durée estimée</label>
                                        <input type="text" name="duree_livraison" class="form-control" value="{{ $commande->duree_livraison }}">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                                    <button type="submit" class="btn btn-success">Enregistrer</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection