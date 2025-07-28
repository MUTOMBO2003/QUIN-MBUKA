@extends('layouts.secretaire')

@section('title', 'Modifier la durée de livraison')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">
        <i class="fas fa-clock me-2 text-primary"></i> Modifier la durée de livraison - Commande #{{ $commande->id }}
    </h2>

    {{-- Message de succès --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Affichage des erreurs --}}
    @if($errors->any())
        <div class="alert alert-danger">
            <strong>Erreur :</strong>
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li><i class="fas fa-exclamation-triangle text-danger me-1"></i> {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('secretaire.commandes.livraison.update', $commande->id) }}">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="duree_livraison" class="form-label">Durée estimée de livraison</label>
            <input 
                type="text" 
                name="duree_livraison" 
                id="duree_livraison" 
                class="form-control @error('duree_livraison') is-invalid @enderror" 
                value="{{ old('duree_livraison', $commande->duree_livraison) }}" 
                required
            >
            @error('duree_livraison')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save me-1"></i> Mettre à jour
            </button>
            <a href="{{ route('secretaire.commandes.suivi') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-1"></i> Annuler
            </a>
        </div>
    </form>
</div>
@endsection
