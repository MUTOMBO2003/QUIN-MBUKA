@extends('layouts.secretaire')

@section('title', 'Modifier la commande')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Modifier la commande #{{ $commande->id }}</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('secretaire.commandes.update', $commande->id) }}">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="duree_livraison" class="form-label">Durée de livraison estimée</label>
            <input type="text" name="duree_livraison" class="form-control" value="{{ old('duree_livraison', $commande->duree_livraison) }}" placeholder="Ex: 3 jours, 48 heures">
        </div>

        <div class="mb-3">
            <label for="statut" class="form-label">Statut de la commande</label>
            <select name="statut" class="form-select" required>
                <option value="en attente" {{ $commande->statut === 'en attente' ? 'selected' : '' }}>En attente</option>
                <option value="en cours de livraison" {{ $commande->statut === 'en cours de livraison' ? 'selected' : '' }}>En cours de livraison</option>
                <option value="livrée" {{ $commande->statut === 'livrée' ? 'selected' : '' }}>Livrée</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Enregistrer</button>
        <a href="{{ route('secretaire.commandes.suivi') }}" class="btn btn-secondary">Annuler</a>
    </form>
</div>
@endsection
