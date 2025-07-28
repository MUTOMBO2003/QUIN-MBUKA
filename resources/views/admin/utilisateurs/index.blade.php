@extends('layouts.admin')

@section('title', 'Liste des utilisateurs')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">Liste des utilisateurs</h2>
        <a href="{{ route('admin.utilisateurs.create') }}" class="btn btn-success">
            <i class="fas fa-plus"></i> Créer un utilisateur
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-striped align-middle">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Nom complet</th>
                <th>Rôle</th>
                <th>Identifiant</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($utilisateurs as $utilisateur)
                <tr>
                    <td>{{ $utilisateur->id }}</td>
                    <td>{{ $utilisateur->prenom }} {{ $utilisateur->nom }}</td>
                    <td>{{ ucfirst($utilisateur->role) }}</td>
                    <td>
                        @if($utilisateur->role === 'client')
                            {{ $utilisateur->email }}
                        @else
                            {{ $utilisateur->matricule }}
                        @endif
                    </td>
                    <td class="d-flex gap-1">
                        <a href="{{ route('admin.utilisateurs.show', $utilisateur) }}" class="btn btn-sm btn-info">Voir</a>
                        <a href="{{ route('admin.utilisateurs.edit', $utilisateur) }}" class="btn btn-sm btn-warning">Modifier</a>
                        <form action="{{ route('admin.utilisateurs.destroy', $utilisateur) }}" method="POST" onsubmit="return confirm('Supprimer cet utilisateur ?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger" type="submit">Supprimer</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center text-muted">Aucun utilisateur enregistré.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
