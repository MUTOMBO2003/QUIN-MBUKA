@extends('layouts.admin')

@section('title', 'Liste des produits')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-primary"><i class="fas fa-box-open me-2"></i>Liste des produits</h2>
        <a href="{{ route('admin.produits.create') }}" class="btn btn-success">
            <i class="fas fa-plus-circle me-1"></i> Ajouter un produit
        </a>
    </div>

    <div class="card shadow border-0">
        <div class="card-body table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Nom</th>
                        <th>Catégorie</th>
                        <th>Prix (FC)</th>
                        <th>Stock</th>
                        <th>Image</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($produits as $produit)
                        <tr>
                            <td>{{ $produit->id }}</td>
                            <td>{{ $produit->nom }}</td>
                            <td>{{ $produit->categorie->name ?? 'Non catégorisé' }}</td>
                            <td>{{ number_format($produit->prix, 0, ',', ' ') }} FC</td>
                            <td>{{ $produit->stock }}</td>
                            <td>
                                @if($produit->image)
                                    <img src="{{ asset('storage/' . $produit->image) }}" width="60" class="rounded shadow-sm" alt="Image">
                                @else
                                    <span class="text-muted">Aucune</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <a href="{{ route('admin.produits.edit', $produit) }}" class="btn btn-sm btn-warning me-1">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.produits.destroy', $produit) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger" onclick="return confirm('Supprimer ce produit ?')" type="submit">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted">Aucun produit disponible.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
