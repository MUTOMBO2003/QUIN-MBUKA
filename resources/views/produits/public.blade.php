@extends('layouts.app')

@section('title', 'Tous les produits')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Tous les produits</h2>
    <div class="row">
        @foreach($produits as $produit)
        <div class="col-md-3 mb-4">
            <div class="card h-100">
                @if($produit->image)
                <img src="{{ asset('storage/' . $produit->image) }}" class="card-img-top" alt="{{ $produit->nom }}">
                @endif
                <div class="card-body">
                    <h5>{{ $produit->nom }}</h5>
                    <p>{{ number_format($produit->prix, 2) }} $</p>
                    <form method="POST" action="{{ route('client.paniers.add', $produit) }}">
                        @csrf
                        <button class="btn btn-success btn-sm w-100">Ajouter au panier</button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    {{ $produits->links('pagination::bootstrap-5') }}
</div>
@endsection