@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h2>Modifier la catégorie</h2>
    <form action="{{ route('admin.categories.update', $categorie) }}" method="POST">
        @csrf @method('PUT')
        <div class="mb-3">
            <label for="name" class="form-label">Nom de la catégorie</label>
            <input type="text" name="name" class="form-control" value="{{ $categorie->name }}" required>
        </div>
        <button type="submit" class="btn btn-success">Mettre à jour</button>
        <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Annuler</a>
    </form>
</div>
@endsection