@extends('layouts.client')

@section('content')
<div class="container mt-4">
    <div class="row">
        <div class="col-md-6">
            @if($produit->image)
                <img src="{{ asset('storage/' . $produit->image) }}" class="img-fluid" alt="{{ $produit->nom }}">
            @endif
        </div>
        <div class="col-md-6">
            <h2>{{ $produit->nom }}</h2>
            <p class="text-muted">{{ $produit->categorie->name ?? '' }}</p>
            
            {{-- Prix en FC formaté --}}
            <h4>{{ number_format($produit->prix, 2, ',', ' ') }} FC</h4>
            
            <p>{{ $produit->description }}</p>

            <form action="{{ route('client.paniers.add', $produit) }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-success">Ajouter au panier</button>
            </form>
        </div>
    </div>
</div>
@endsection
