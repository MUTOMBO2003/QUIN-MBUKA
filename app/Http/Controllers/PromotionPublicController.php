<?php

namespace App\Http\Controllers;

use App\Models\Produit;

class PromotionPublicController extends Controller
{
    public function index()
    {
        $produits = Produit::whereNotNull('prix_initial')
            ->whereColumn('prix', '<', 'prix_initial')
            ->paginate(12);

        return view('promotions.public', compact('produits'));
    }
}