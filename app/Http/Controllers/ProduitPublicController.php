<?php

namespace App\Http\Controllers;

use App\Models\Produit;
use Illuminate\Http\Request;

class ProduitPublicController extends Controller
{
    public function index()
    {
        $produits = Produit::latest()->paginate(12);
        return view('produits.public', compact('produits'));
    }
}
