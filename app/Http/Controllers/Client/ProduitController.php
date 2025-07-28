<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Produit;

class ProduitController extends Controller
{
    public function index()
    {
        $produits = Produit::with('categorie')->get();
        return view('client.produits.index', compact('produits'));
    }

    public function show(Produit $produit)
    {
        return view('client.produits.show', compact('produit'));
    }
}