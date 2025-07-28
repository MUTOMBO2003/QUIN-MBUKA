@extends('layouts.client')

@section('title', 'Livraison')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow border-0">
                <div class="card-header bg-primary text-white text-center">
                    <h4 class="mb-0">📦 Informations de livraison</h4>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('client.livraisons.store', $commande) }}">
                        @csrf

                        <div class="mb-3">
                            <label for="nom" class="form-label">Nom complet</label>
                            <input type="text" name="nom" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="telephone" class="form-label">Téléphone</label>
                            <input type="text" name="telephone" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="adresse" class="form-label">Adresse complète</label>
                            <input type="text" name="adresse" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="ville" class="form-label">Ville</label>
                            <input type="text" name="ville" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="code_postal" class="form-label">Code postal (optionnel)</label>
                            <input type="text" name="code_postal" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label for="instructions" class="form-label">Instructions de livraison (optionnel)</label>
                            <textarea name="instructions" class="form-control" rows="3"></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">
                            📬 Valider la livraison
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
