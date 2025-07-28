@extends('layouts.admin')

@section('title', 'Liste des paiements')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Liste des paiements</h2>

    @if($paiements->count())
        <table class="table table-bordered table-striped align-middle">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Client</th>
                    <th>Montant</th>
                    <th>Référence</th>
                    <th>Commande</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($paiements as $paiement)
                    <tr>
                        <td>{{ $paiement->id }}</td>
                        <td>{{ $paiement->commande->user->prenom ?? 'N/A' }} {{ $paiement->commande->user->nom ?? '' }}</td>
                        <td>{{ number_format($paiement->montant, 2) }} $</td>
                        <td>{{ $paiement->reference }}</td>
                        <td>#{{ $paiement->commande_id }}</td>
                        <td>{{ $paiement->created_at->format('d/m/Y H:i') }}</td>
                        <td>
                            <a href="{{ route('admin.paiements.show', $paiement) }}" class="btn btn-sm btn-info">Détails</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="alert alert-info">
            Aucun paiement trouvé.
        </div>
    @endif
</div>
@endsection
