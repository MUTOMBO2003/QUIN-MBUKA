@extends('layouts.admin')

@section('title', 'Modifier le produit')

@section('content')
<div class="container d-flex justify-content-center mt-5">
    <div class="col-md-8">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0"><i class="fas fa-edit me-2"></i>Modifier le produit</h4>
            </div>

            <div class="card-body">
                <form action="{{ route('admin.produits.update', $produit) }}" method="POST" enctype="multipart/form-data">
                    @csrf 
                    @method('PUT')

                    <div class="mb-3">
                        <label for="nom" class="form-label">Nom</label>
                        <input type="text" name="nom" class="form-control" id="nom" value="{{ $produit->nom }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="prix" class="form-label">Prix <small class="text-muted">(en Francs Congolais - FC)</small></label>
                        <div class="input-group">
                            <input type="number" step="1" name="prix" id="prix" class="form-control" value="{{ $produit->prix }}" required>
                            <span class="input-group-text">FC</span>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="stock" class="form-label">Stock</label>
                        <input type="number" name="stock" id="stock" class="form-control" value="{{ $produit->stock }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="categorie_id" class="form-label">Catégorie</label>
                        <select name="categorie_id" id="categorie_id" class="form-control" required>
                            @foreach($categories as $categorie)
                                <option value="{{ $categorie->id }}" {{ $produit->categorie_id == $categorie->id ? 'selected' : '' }}>
                                    {{ $categorie->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea name="description" id="description" class="form-control">{{ $produit->description }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Image actuelle</label><br>
                        @if($produit->image)
                            <img src="{{ asset('storage/' . $produit->image) }}" width="120" class="rounded shadow-sm">
                        @else
                            <p class="text-muted">Aucune image disponible</p>
                        @endif
                    </div>

                    <div class="mb-3">
                        <label for="image" class="form-label">Nouvelle image</label>
                        <input type="file" name="image" id="image" class="form-control">
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.produits.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-1"></i> Annuler
                        </a>
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save me-1"></i> Mettre à jour
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
