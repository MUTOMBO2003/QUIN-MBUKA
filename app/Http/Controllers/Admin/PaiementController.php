<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Paiement;

class PaiementController extends Controller
{
    /**
     * Affiche la liste des paiements avec leurs commandes et clients.
     */
    public function index()
    {
        $paiements = Paiement::with(['commande.user'])->latest()->get();

        return view('admin.paiements.index', compact('paiements'));
    }

    /**
     * Affiche les détails d’un paiement spécifique.
     */
    public function show(Paiement $paiement)
    {
        $paiement->load(['commande.user']); // Charger la commande et le client
        return view('admin.paiements.show', compact('paiement'));
    }
}
