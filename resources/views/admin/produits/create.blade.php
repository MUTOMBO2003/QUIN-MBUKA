@extends('layouts.admin')

@section('title', 'Ajouter un produit')

@section('content')
<div class="container d-flex justify-content-center align-items-center mt-5">
    <div class="card shadow p-4 w-100" style="max-width: 600px;">
        <h3 class="mb-4 text-center text-primary"><i class="fas fa-plus-circle me-2"></i>Ajouter un produit</h3>

        <form action="{{ route('admin.produits.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label for="nom" class="form-label">Nom du produit</label>
                <input type="text" name="nom" id="nom" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="prix" class="form-label">Prix <small class="text-muted">(en Francs Congolais)</small></label>
                <div class="input-group">
                    <input type="number" step="1" name="prix" id="prix" class="form-control" required>
                    <span class="input-group-text">FC</span>
                </div>
            </div>

            <div class="mb-3">
                <label for="stock" class="form-label">Quantité en stock</label>
                <input type="number" name="stock" id="stock" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="categorie_id" class="form-label">Catégorie</label>
                <select name="categorie_id" id="categorie_id" class="form-select" required>
                    <option value="">-- Choisir une catégorie --</option>
                    @foreach($categories as $categorie)
                        <option value="{{ $categorie->id }}">{{ $categorie->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea name="description" id="description" rows="3" class="form-control"></textarea>
            </div>

            <div class="mb-4">
                <label for="image" class="form-label">Image du produit</label>
                <input type="file" name="image" id="image" class="form-control">
            </div>

            <div class="d-flex justify-content-between">
                <a href="{{ route('admin.produits.index') }}" class="btn btn-outline-secondary">Annuler</a>
                <button class="btn btn-success" type="submit"><i class="fas fa-save me-1"></i>Enregistrer</button>
            </div>
        </form>
    </div>
</div>
@endsection
