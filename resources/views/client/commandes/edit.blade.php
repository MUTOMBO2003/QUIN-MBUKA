@extends('layouts.client')

@section('title', 'Modifier la commande')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4 text-primary">📝 Modifier la commande #{{ $commande->id }}</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('client.commandes.update', $commande->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="table-responsive">
            <table class="table table-bordered align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Produit</th>
                        <th>Quantité</th>
                        <th>Prix unitaire</th>
                        <th>Sous-total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($commande->details as $detail)
                        <tr>
                            <td>{{ $detail->produit->nom }}</td>
                            <td width="120">
                                <input type="number" name="quantites[{{ $detail->id }}]"
                                       class="form-control text-center"
                                       min="1"
                                       value="{{ old('quantites.'.$detail->id, $detail->quantite) }}">
                            </td>
                            <td>{{ number_format($detail->prix_unitaire, 2, ',', ' ') }} FC</td>
                            <td>
                                {{ number_format($detail->prix_unitaire * $detail->quantite, 2, ',', ' ') }} FC
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4 d-flex justify-content-between">
            <a href="{{ route('client.commandes.show', $commande->id) }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Retour
            </a>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Enregistrer les modifications
            </button>
        </div>
    </form>
</div>
@endsection
