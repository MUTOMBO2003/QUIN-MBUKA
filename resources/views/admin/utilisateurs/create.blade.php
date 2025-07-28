@extends('layouts.admin')

@section('title', 'Créer un utilisateur')

@section('content')
<style>
    .form-container {
        max-width: 600px;
        margin: 0 auto;
        background-color: #e0f7fa; /* bleu ciel */
        border-radius: 12px;
        padding: 30px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .form-container h2 {
        text-align: center;
        color: #0077b6;
        font-weight: bold;
    }

    .btn-primary-custom {
        background-color: #0077b6;
        border-color: #0077b6;
    }

    .btn-primary-custom:hover {
        background-color: #005f8f;
        border-color: #005f8f;
    }
</style>

<div class="container mt-5">
    <div class="form-container">
        <h2>Créer un nouvel utilisateur</h2>

        @if ($errors->any())
            <div class="alert alert-danger mt-3">
                <strong>Oups !</strong> Veuillez corriger les erreurs suivantes :
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if(session('success'))
            <div class="alert alert-success mt-3">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('admin.utilisateurs.store') }}" method="POST" class="mt-4">
            @csrf

            <div class="mb-3">
                <label for="role" class="form-label">Rôle</label>
                <select name="role" id="role" class="form-select" required>
                    <option value="">-- Sélectionner un rôle --</option>
                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Administrateur</option>
                    <option value="secretaire" {{ old('role') == 'secretaire' ? 'selected' : '' }}>Secrétaire</option>
                    <option value="client" {{ old('role') == 'client' ? 'selected' : '' }}>Client</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="matricule" class="form-label">Matricule</label>
                <input type="text" name="matricule" id="matricule" class="form-control" value="{{ old('matricule') }}" required>
                <div class="form-text">Ce matricule doit être pré-enregistré dans la base.</div>
            </div>

            <div class="d-flex justify-content-between mt-4">
                <button type="submit" class="btn btn-primary-custom">Créer l'utilisateur</button>
                <a href="{{ route('admin.utilisateurs.index') }}" class="btn btn-secondary">Annuler</a>
            </div>
        </form>
    </div>
</div>
@endsection
