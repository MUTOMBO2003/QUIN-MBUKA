<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Commande;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CommandeController extends Controller
{
    /**
     * Liste toutes les commandes avec option de filtrage par statut.
     */
    public function index(Request $request)
    {
        $query = Commande::with('user')->latest();

        // Appliquer un filtre par statut si fourni
        if ($request->filled('statut')) {
            $query->where('statut', $request->input('statut'));
        }

        $commandes = $query->get();

        return view('admin.commandes.index', compact('commandes'));
    }

    /**
     * Affiche les détails d'une commande.
     */
    public function show(Commande $commande)
    {
        $commande->load('user', 'produits'); // produits = relation optionnelle
        return view('admin.commandes.show', compact('commande'));
    }

    /**
     * Met à jour le statut d'une commande.
     */
    public function updateStatut(Request $request, Commande $commande): RedirectResponse
    {
        $request->validate([
            'statut' => 'required|in:en attente,en cours de livraison,livrée,payée,annulée',
        ]);

        $commande->update([
            'statut' => $request->statut,
        ]);

        return back()->with('success', 'Statut de la commande mis à jour.');
    }
}
