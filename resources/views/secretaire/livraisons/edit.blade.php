@extends('layouts.secretaire')

@section('title', 'Modifier la livraison')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">✏️ Modifier la livraison #{{ $livraison->id }}</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('secretaire.livraisons.update', $livraison->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="statut" class="form-label">Statut</label>
            <select name="statut" class="form-select" required>
                <option value="en_attente" @selected($livraison->statut === 'en_attente')>En attente</option>
                <option value="en_cours" @selected($livraison->statut === 'en_cours')>En cours</option>
                <option value="livrée" @selected($livraison->statut === 'livrée')>Livrée</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="adresse" class="form-label">Adresse de livraison</label>
            <input type="text" name="adresse" class="form-control" value="{{ old('adresse', $livraison->adresse) }}" required>
        </div>

        <button type="submit" class="btn btn-success">Enregistrer</button>
        <a href="{{ route('secretaire.livraisons.index') }}" class="btn btn-secondary">Annuler</a>
    </form>
</div>
@endsection
