@extends('layouts.app')

@section('title', 'Résultats de recherche')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4">Résultats de recherche</h2>

    <!-- Formulaire de recherche avancée -->
    <form action="{{ route('recherche.produits') }}" method="GET" class="row g-3 mb-4">
        <div class="col-md-3">
            <input type="text" name="query" class="form-control" placeholder="Nom du produit..." value="{{ request('query') }}">
        </div>
        <div class="col-md-3">
            <select name="categorie" class="form-select">
                <option value="">Toutes les catégories</option>
                @foreach(App\Models\Categorie::all() as $categorie)
                    <option value="{{ $categorie->id }}" {{ request('categorie') == $categorie->id ? 'selected' : '' }}>
                        {{ $categorie->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <input type="number" name="min" class="form-control" placeholder="Min ($)" value="{{ request('min') }}">
        </div>
        <div class="col-md-2">
            <input type="number" name="max" class="form-control" placeholder="Max ($)" value="{{ request('max') }}">
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-primary w-100">Rechercher</button>
        </div>
    </form>

    @if($produits->count())
        <div class="row">
            @foreach($produits as $produit)
                <div class="col-md-3 mb-4">
                    <div class="card h-100">
                        @if($produit->image)
                            <img src="{{ asset('storage/' . $produit->image) }}" class="card-img-top" alt="{{ $produit->nom }}">
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">{{ $produit->nom }}</h5>
                            <p class="card-text">{{ number_format($produit->prix, 2) }} $</p>
                            <form action="{{ route('client.paniers.add', $produit) }}" method="POST">
                                @csrf
                                <button class="btn btn-sm btn-success w-100">Ajouter au panier</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination Bootstrap -->
        <div class="d-flex justify-content-center">
            {{ $produits->withQueryString()->links('pagination::bootstrap-5') }}
        </div>
    @else
        <div class="alert alert-warning">
            Aucun produit trouvé pour cette recherche.
        </div>
    @endif

    <div class="mt-4">
        <a href="{{ url('/') }}" class="btn btn-secondary">Retour à l'accueil</a>
    </div>
</div>
@endsection
