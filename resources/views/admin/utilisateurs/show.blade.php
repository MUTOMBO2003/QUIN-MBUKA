@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h2>Détails de l’utilisateur</h2>

    <div class="card mt-3">
        <div class="card-header bg-primary text-white">
            Utilisateur #{{ $user->id }} — {{ ucfirst($user->role) }}
        </div>
        <div class="card-body">
            <p><strong>Nom complet :</strong> {{ $user->prenom }} {{ $user->postnom }} {{ $user->nom }}</p>
            <p><strong>Identifiant :</strong> 
                @if($user->role === 'client')
                    {{ $user->email }}
                @else
                    {{ $user->matricule }}
                @endif
            </p>
            <p><strong>Créé le :</strong> {{ $user->created_at->format('d/m/Y à H:i') }}</p>
        </div>
    </div>

    <a href="{{ route('admin.utilisateurs.index') }}" class="btn btn-secondary mt-3">Retour</a>
@endsection
