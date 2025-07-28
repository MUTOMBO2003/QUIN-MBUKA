<?php

namespace App\Http\Controllers;

use App\Models\Produit;
use App\Models\Categorie;
use Illuminate\Http\Request;

class RechercheProduitController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('query');
        $categorieId = $request->input('categorie');
        $min = $request->input('min');
        $max = $request->input('max');

        $produits = Produit::query()
            ->when($query, fn($q) => $q->where('nom', 'like', "%$query%"))
            ->when($categorieId, fn($q) => $q->where('categorie_id', $categorieId))
            ->when($min, fn($q) => $q->where('prix', '>=', $min))
            ->when($max, fn($q) => $q->where('prix', '<=', $max))
            ->paginate(12)
            ->appends($request->all());

        return view('recherche.resultats', [
            'produits' => $produits,
            'query' => $query,
            'categorieId' => $categorieId,
            'min' => $min,
            'max' => $max,
        ]);
    }
}
