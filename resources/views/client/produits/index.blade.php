@extends('layouts.client')

@section('content')
<div class="container mt-4">
    <h2>Catalogue des produits</h2>

    <div class="row">
        @forelse($produits as $produit)
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    @if($produit->image)
                        <img src="{{ asset('storage/' . $produit->image) }}" class="card-img-top" alt="{{ $produit->nom }}">
                    @endif
                    <div class="card-body">
                        <h5 class="card-title">{{ $produit->nom }}</h5>
                        <p class="card-text">
                            {{ number_format($produit->prix, 2, ',', ' ') }} FC
                        </p>
                        <a href="{{ route('client.produits.show', $produit) }}" class="btn btn-primary btn-sm">Détails</a>
                    </div>
                </div>
            </div>
        @empty
            <p>Aucun produit disponible pour le moment.</p>
        @endforelse
    </div>
</div>
@endsection
