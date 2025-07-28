<?php

namespace App\Http\Controllers\Secretaire;

use App\Http\Controllers\Controller;
use App\Models\Commande;
use Illuminate\Http\Request;

class SuiviCommandesController extends Controller
{
    /**
     * Afficher toutes les commandes avec possibilité de suivi.
     */
    public function index()
    {
        $commandes = Commande::with('user')->latest()->get();
        return view('secretaire.commandes.suivi', compact('commandes'));
    }

    /**
     * Affiche les détails d'une commande.
     */
    public function show($id)
    {
        $commande = Commande::with(['user', 'paniers.produit'])->findOrFail($id);
        return view('secretaire.commandes.show', compact('commande'));
    }

    /**
     * Afficher le formulaire d'édition d'une commande spécifique.
     */
    public function edit(Commande $commande)
    {
        return view('secretaire.commandes.edit', compact('commande'));
    }

    /**
     * Mise à jour du statut et/ou durée de livraison d'une commande.
     */
    public function update(Request $request, Commande $commande)
    {
        $validated = $request->validate([
            'statut' => 'required|in:en attente,en cours de livraison,livrée',
            'duree_livraison' => 'nullable|string|max:255',
        ]);

        $commande->update($validated);

        return redirect()->route('secretaire.commandes.suivi')
                         ->with('success', 'Commande mise à jour avec succès.');
    }
}
