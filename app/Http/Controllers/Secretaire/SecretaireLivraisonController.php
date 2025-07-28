<?php

namespace App\Http\Controllers\Secretaire;

use App\Http\Controllers\Controller;
use App\Models\Livraison;
use Illuminate\Http\Request;

class SecretaireLivraisonController extends Controller
{
    /**
     * Afficher toutes les livraisons.
     */
    public function index()
    {
        $livraisons = Livraison::with(['commande.user'])->latest()->get();
        return view('secretaire.livraisons.index', compact('livraisons'));
    }

    /**
     * Afficher une livraison spécifique.
     */
    public function show($id)
    {
        $livraison = Livraison::with(['commande.user'])->findOrFail($id);
        return view('secretaire.livraisons.show', compact('livraison'));
    }

    /**
     * Modifier le statut de la livraison.
     */
    public function edit($id)
    {
        $livraison = Livraison::with('commande')->findOrFail($id);
        return view('secretaire.livraisons.edit', compact('livraison'));
    }

    /**
     * Mettre à jour les informations de la livraison.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'statut' => 'required|in:en attente,en cours,livrée,annulée',
            'date_livraison' => 'nullable|date',
            'remarques' => 'nullable|string|max:255'
        ]);

        $livraison = Livraison::findOrFail($id);
        $livraison->update([
            'statut' => $request->statut,
            'date_livraison' => $request->date_livraison,
            'remarques' => $request->remarques
        ]);

        return redirect()->route('secretaire.livraisons.index')->with('success', 'Livraison mise à jour avec succès.');
    }
}
