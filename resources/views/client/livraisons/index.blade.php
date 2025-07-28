@extends('layouts.client')

@section('title', 'Mes livraisons')

@section('content')
<div class="container mt-5">
    <h3 class="mb-4 text-center">📦 Mes adresses de livraison</h3>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if ($livraisons->isEmpty())
        <div class="alert alert-info text-center">Aucune livraison enregistrée.</div>
    @else
        <div class="table-responsive">
            <table class="table table-bordered align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Nom</th>
                        <th>Téléphone</th>
                        <th>Adresse</th>
                        <th>Ville</th>
                        <th>Commande</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($livraisons as $livraison)
                        <tr>
                            <td>{{ $livraison->nom }}</td>
                            <td>{{ $livraison->telephone }}</td>
                            <td>{{ $livraison->adresse }}</td>
                            <td>{{ $livraison->ville }}</td>
                            <td>#{{ $livraison->commande_id }}</td>
                            <td>
                                <a href="{{ route('client.livraisons.edit', $livraison) }}" class="btn btn-sm btn-primary">
                                    ✏️ Modifier
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
