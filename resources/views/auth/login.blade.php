@extends('layouts.app')

@section('title', 'Connexion')

@section('content')
<style>
    body {
        background-color: #e0f7fa; /* Bleu ciel clair */
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .login-container {
        background-color: #ffffff;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0px 8px 20px rgba(0, 123, 255, 0.1);
        max-width: 500px;
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

    .btn-primary {
        background-color: #00bcd4;
        border: none;
        font-weight: bold;
    }

    .btn-primary:hover {
        background-color: #00acc1;
    }

    .form-check-label {
        color: #007BFF;
    }

    a {
        color: #00acc1;
        text-decoration: none;
    }

    a:hover {
        text-decoration: underline;
    }

    .text-danger {
        font-size: 0.9rem;
    }
</style>

<div class="container">
    <div class="login-container">
        <h2 class="text-center mb-4">Connexion à votre compte</h2>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="mb-3">
                <label for="identifiant" class="form-label">Email ou Matricule</label>
                <input type="text" name="identifiant" id="identifiant" class="form-control" value="{{ old('identifiant') }}" required autofocus>
                @error('identifiant')
                    <div class="text-danger mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Mot de passe</label>
                <input type="password" name="password" id="password" class="form-control" required>
                @error('password')
                    <div class="text-danger mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 form-check">
                <input type="checkbox" name="remember" id="remember" class="form-check-input">
                <label class="form-check-label" for="remember">Se souvenir de moi</label>
            </div>

            <button type="submit" class="btn btn-primary w-100">Se connecter</button>

            <div class="text-center mt-3">
                <a href="{{ route('register') }}">Pas encore inscrit ? Créer un compte</a>
            </div>
        </form>
    </div>
</div>
@endsection
