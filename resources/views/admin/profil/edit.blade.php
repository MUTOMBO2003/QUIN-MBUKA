@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h2>Modifier mon profil</h2>

    <form action="{{ route('admin.profil.update') }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="prenom" class="form-label">Prénom</label>
            <input type="text" name="prenom" id="prenom" class="form-control" value="{{ old('prenom', $user->prenom) }}" required>
        </div>

        <div class="mb-3">
            <label for="postnom" class="form-label">Post-nom</label>
            <input type="text" name="postnom" id="postnom" class="form-control" value="{{ old('postnom', $user->postnom) }}" required>
        </div>

        <div class="mb-3">
            <label for="nom" class="form-label">Nom</label>
            <input type="text" name="nom" id="nom" class="form-control" value="{{ old('nom', $user->nom) }}" required>
        </div>

        <button type="submit" class="btn btn-success">Mettre à jour</button>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">Annuler</a>
    </form>
</div>
@endsection
