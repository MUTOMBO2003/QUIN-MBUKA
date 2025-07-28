@extends('layouts.app')

@section('title', 'Promotions')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Produits en promotion</h2>
    <div class="row">
        @foreach($produits as $produit)
        <div class="col-md-3 mb-4">
            <div class="card h-100 border border-warning">
                @if($produit->image)
                <img src="{{ asset('storage/' . $produit->image) }}" class="card-img-top" alt="{{ $produit->nom }}">
                @endif
                <div class="card-body">
                    <h5 class="text-warning">{{ $produit->nom }}</h5>
                    <p>
                        <strong class="text-success">{{ number_format($produit->prix, 2) }} $</strong>
                        <del class="text-danger ms-2">{{ number_format($produit->prix_initial, 2) }} $</del>
                    </p>
                    <span class="badge bg-danger">
                        -{{ round((($produit->prix_initial - $produit->prix) / $produit->prix_initial) * 100) }}%
                    </span>
                    <form method="POST" action="{{ route('client.paniers.add', $produit) }}" class="mt-2">
                        @csrf
                        <button class="btn btn-sm btn-success w-100">Ajouter au panier</button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    {{ $produits->links('pagination::bootstrap-5') }}
</div>
@endsection
