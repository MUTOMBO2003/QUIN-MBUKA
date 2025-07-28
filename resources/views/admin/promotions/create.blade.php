@extends('layouts.admin')

@section('title', 'Créer une promotion')

@section('content')
<div class="container mt-4">
    <h2>Créer une promotion</h2>

    <form action="{{ route('admin.promotions.store') }}" method="POST" class="mt-4">
        @csrf

        <div class="mb-3">
            <label for="produit_id" class="form-label">Produit à promouvoir</label>
            <select name="produit_id" id="produit_id" class="form-select" required>
                <option value="">-- Sélectionner un produit --</option>
                @foreach($produits as $produit)
                    <option value="{{ $produit->id }}">{{ $produit->nom }} — {{ number_format($produit->prix, 2) }} $</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="prix_promotionnel" class="form-label">Prix promotionnel</label>
            <input type="number" name="prix_promotionnel" id="prix_promotionnel" class="form-control" step="0.01" required>
        </div>

        <button type="submit" class="btn btn-success">Enregistrer la promotion</button>
        <a href="{{ route('admin.promotions.index') }}" class="btn btn-secondary">Annuler</a>
    </form>
</div>
@endsection
