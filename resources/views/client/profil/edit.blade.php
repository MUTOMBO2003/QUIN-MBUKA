@extends('layouts.client')

@section('content')
<div class="container mt-4">
    <h2>Modifier mon profil</h2>

    <form action="{{ route('client.profil.update') }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="prenom" class="form-label">Prénom</label>
            <input type="text" name="prenom" id="prenom" class="form-control" value="{{ old('prenom', $client->prenom) }}" required>
        </div>

        <div class="mb-3">
            <label for="postnom" class="form-label">Post-nom</label>
            <input type="text" name="postnom" id="postnom" class="form-control" value="{{ old('postnom', $client->postnom) }}" required>
        </div>

        <div class="mb-3">
            <label for="nom" class="form-label">Nom</label>
            <input type="text" name="nom" id="nom" class="form-control" value="{{ old('nom', $client->nom) }}" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Adresse email</label>
            <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $client->email) }}" required>
        </div>

        <button type="submit" class="btn btn-success">Enregistrer</button>
        <a href="{{ route('client.dashboard') }}" class="btn btn-secondary">Annuler</a>
    </form>
</div>
@endsection
