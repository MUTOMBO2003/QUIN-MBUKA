@extends('layouts.app')

@section('title', 'Inscription')

@section('content')
<style>
    body {
        background-color: #e0f7fa; /* Bleu ciel clair */
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .register-container {
        background-color: #ffffff;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0px 8px 20px rgba(0, 123, 255, 0.1);
        max-width: 600px;
        margin: 60px auto;
        border: 2px solid #b2ebf2;
    }

    h2 {
        color: #007BFF;
    }

    .form-label {
        color: #007BFF;
        font-weight: bold;
    }

    .form-control {
        border: 1px solid #b2ebf2;
        transition: border-color 0.3s, box-shadow 0.3s;
    }

    .form-control:focus {
        border-color: #00bcd4;
        box-shadow: 0 0 0 0.2rem rgba(0, 188, 212, 0.25);
    }

    .btn-success {
        background-color: #00bcd4;
        border: none;
        font-weight: bold;
    }

    .btn-success:hover {
        background-color: #00acc1;
    }

    .text-danger {
        font-size: 0.9rem;
    }
</style>

<div class="container">
    <div class="register-container">
        <h2 class="text-center mb-4">Créer un compte</h2>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="mb-3">
                <label for="nom" class="form-label">Nom</label>
                <input type="text" name="nom" class="form-control" value="{{ old('nom') }}" required>
                @error('nom')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="postnom" class="form-label">Post-nom</label>
                <input type="text" name="postnom" class="form-control" value="{{ old('postnom') }}" required>
                @error('postnom')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="prenom" class="form-label">Prénom</label>
                <input type="text" name="prenom" class="form-control" value="{{ old('prenom') }}" required>
                @error('prenom')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="identifiant" class="form-label">Adresse email ou numéro matricule</label>
                <input type="text" name="identifiant" id="identifiant" class="form-control" value="{{ old('identifiant') }}" required>
                @error('identifiant')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Mot de passe</label>
                <input type="password" name="password" class="form-control" required>
                @error('password')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Confirmer le mot de passe</label>
                <input type="password" name="password_confirmation" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-success w-100">Créer mon compte</button>
        </form>
    </div>
</div>
@endsection
