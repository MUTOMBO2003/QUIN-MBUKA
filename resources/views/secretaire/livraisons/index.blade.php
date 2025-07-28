@extends('layouts.secretaire')

@section('title', 'Liste des livraisons')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">📦 Liste des livraisons</h2>

    {{-- Message de succès --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($livraisons->isEmpty())
        <div class="alert alert-info">Aucune livraison enregistrée.</div>
    @else
        <table class="table table-bordered table-hover align-middle">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Commande</th>
                    <th>Adresse</th>
                    <th>Statut</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($livraisons as $livraison)
                    <tr>
                        <td>{{ $livraison->id }}</td>
                        <td>#{{ $livraison->commande_id }}</td>
                        <td>{{ $livraison->adresse }}</td>
                        <td>
                            @php
                                $badgeClass = match($livraison->statut) {
                                    'en_attente' => 'secondary',
                                    'en_cours' => 'warning text-dark',
                                    'livrée' => 'success',
                                    'annulée' => 'danger',
                                    default => 'light text-dark'
                                };
                            @endphp
                            <span class="badge bg-{{ $badgeClass }}">
                                {{ ucfirst(str_replace('_', ' ', $livraison->statut)) }}
                            </span>
                        </td>
                        <td>{{ $livraison->created_at->format('d/m/Y H:i') }}</td>
                        <td class="d-flex gap-1">
                            <a href="{{ route('secretaire.livraisons.show', $livraison->id) }}" class="btn btn-sm btn-info">
                                <i class="fas fa-eye"></i> Détails
                            </a>
                            <a href="{{ route('secretaire.livraisons.edit', $livraison->id) }}" class="btn btn-sm btn-primary">
                                <i class="fas fa-edit"></i> Modifier
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
