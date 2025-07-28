<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Produit;
use Illuminate\Http\Request;

class PromotionController extends Controller
{
    /**
     * Affiche la liste des produits en promotion
     */
    public function index()
    {
        $produits = Produit::whereNotNull('prix_initial')
            ->whereColumn('prix', '<', 'prix_initial')
            ->latest()
            ->paginate(12);

        return view('admin.promotions.index', compact('produits'));
    }

    /**
     * Affiche le formulaire pour créer une promotion
     */
    public function create()
    {
        $produits = Produit::whereNull('prix_initial')->get(); // Produits non en promo
        return view('admin.promotions.create', compact('produits'));
    }

    /**
     * Enregistre une nouvelle promotion sur un produit
     */
    public function store(Request $request)
    {
        $request->validate([
            'produit_id' => 'required|exists:produits,id',
            'prix_promotionnel' => 'required|numeric|min:0',
        ]);

        $produit = Produit::findOrFail($request->produit_id);

        // Évite de re-appliquer une promo si déjà en promo
        if (!is_null($produit->prix_initial)) {
            return back()->with('error', 'Ce produit est déjà en promotion.');
        }

        $produit->prix_initial = $produit->prix;
        $produit->prix = $request->prix_promotionnel;
        $produit->save();

        return redirect()->route('admin.promotions.index')->with('success', 'Promotion enregistrée avec succès.');
    }
}
