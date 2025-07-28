@extends('layouts.admin')

@section('title', 'Modifier utilisateur')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4 text-primary">Modifier l'utilisateur</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Oups !</strong> Veuillez corriger les erreurs suivantes :
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.utilisateurs.update', $utilisateur) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="row mb-3">
            <div class="col-md-6">
                <label for="prenom" class="form-label">Prénom</label>
                <input type="text" name="prenom" class="form-control" value="{{ old('prenom', $utilisateur->prenom) }}" required>
            </div>
            <div class="col-md-6">
                <label for="nom" class="form-label">Nom</label>
                <input type="text" name="nom" class="form-control" value="{{ old('nom', $utilisateur->nom) }}" required>
            </div>
        </div>

        <div class="mb-3">
            <label for="role" class="form-label">Rôle</label>
            <select name="role" class="form-select" required>
                <option value="admin" {{ old('role', $utilisateur->role) == 'admin' ? 'selected' : '' }}>Administrateur</option>
                <option value="secretaire" {{ old('role', $utilisateur->role) == 'secretaire' ? 'selected' : '' }}>Secrétaire</option>
                <option value="client" {{ old('role', $utilisateur->role) == 'client' ? 'selected' : '' }}>Client</option>
            </select>
        </div>

        @if($utilisateur->role === 'client')
            <div class="mb-3">
                <label for="email" class="form-label">Adresse email</label>
                <input type="email" name="email" class="form-control" value="{{ old('email', $utilisateur->email) }}" required>
            </div>
        @else
            <div class="mb-3">
                <label for="matricule" class="form-label">Matricule</label>
                <input type="text" name="matricule" class="form-control" value="{{ old('matricule', $utilisateur->matricule) }}" required>
            </div>
        @endif

        <div class="mt-4">
            <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>
            <a href="{{ route('admin.utilisateurs.index') }}" class="btn btn-secondary">Annuler</a>
        </div>
    </form>
</div>
@endsection
