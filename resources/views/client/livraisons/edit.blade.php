@extends('layouts.client')

@section('title', 'Modifier livraison')

@section('content')
<div class="container mt-5">
    <h3 class="mb-4">✏️ Modifier l'adresse de livraison</h3>

    <form method="POST" action="{{ route('client.livraisons.update', $livraison) }}">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="nom" class="form-label">Nom complet</label>
            <input type="text" name="nom" class="form-control" value="{{ old('nom', $livraison->nom) }}" required>
        </div>

        <div class="mb-3">
            <label for="telephone" class="form-label">Téléphone</label>
            <input type="text" name="telephone" class="form-control" value="{{ old('telephone', $livraison->telephone) }}" required>
        </div>

        <div class="mb-3">
            <label for="adresse" class="form-label">Adresse complète</label>
            <input type="text" name="adresse" class="form-control" value="{{ old('adresse', $livraison->adresse) }}" required>
        </div>

        <div class="mb-3">
            <label for="ville" class="form-label">Ville</label>
            <input type="text" name="ville" class="form-control" value="{{ old('ville', $livraison->ville) }}" required>
        </div>

        <div class="mb-3">
            <label for="code_postal" class="form-label">Code postal (optionnel)</label>
            <input type="text" name="code_postal" class="form-control" value="{{ old('code_postal', $livraison->code_postal) }}">
        </div>

        <div class="mb-3">
            <label for="instructions" class="form-label">Instructions (optionnel)</label>
            <textarea name="instructions" class="form-control">{{ old('instructions', $livraison->instructions) }}</textarea>
        </div>

        <button type="submit" class="btn btn-success w-100">💾 Enregistrer</button>
    </form>
</div>
@endsection
