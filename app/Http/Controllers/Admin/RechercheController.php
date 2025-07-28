<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RechercheController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('query');

        // Exemple de logique : recherche dans les produits
        $resultats = \App\Models\Produit::where('nom', 'like', '%' . $query . '%')->get();

        return view('admin.recherche.index', compact('resultats', 'query'));
    }
}
