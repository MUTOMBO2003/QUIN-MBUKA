@extends('layouts.admin')

@section('title', 'Promotions en cours')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Produits en Promotion</h2>
        <a href="{{ route('admin.promotions.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Nouvelle Promotion
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($produits->count())
        <div class="row">
            @foreach($produits as $produit)
                <div class="col-md-3 mb-4">
                    <div class="card h-100 border border-warning">
                        @if($produit->image)
                            <img src="{{ asset('storage/' . $produit->image) }}" class="card-img-top" alt="{{ $produit->nom }}">
                        @else
                            <div class="p-5 text-center text-muted">
                                <i class="fas fa-box-open fa-2x"></i><br>
                                <small>Aucune image</small>
                            </div>
                        @endif
                        <div class="card-body">
                            <h5 class="card-title text-warning">{{ $produit->nom }}</h5>
                            <p class="mb-1">
                                <strong class="text-success">{{ number_format($produit->prix, 2) }} $</strong>
                                <del class="text-danger ms-2">{{ number_format($produit->prix_initial, 2) }} $</del>
                            </p>
                            <p>
                                <span class="badge bg-danger">
                                    -{{ round((($produit->prix_initial - $produit->prix) / $produit->prix_initial) * 100) }}%
                                </span>
                            </p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="d-flex justify-content-center mt-4">
            {{ $produits->links('pagination::bootstrap-5') }}
        </div>
    @else
        <div class="alert alert-info">
            Aucun produit en promotion pour le moment.
        </div>
    @endif
</div>
@endsection
