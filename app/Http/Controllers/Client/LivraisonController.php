<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Livraison;
use App\Models\Commande;

class LivraisonController extends Controller
{
    // Afficher toutes les livraisons de l'utilisateur connecté
    public function index()
    {
        $livraisons = Livraison::whereHas('commande', function ($q) {
            $q->where('user_id', Auth::id());
        })->get();

        return view('client.livraisons.index', compact('livraisons'));
    }

    // Formulaire pour ajouter une nouvelle livraison
    public function create(Commande $commande)
    {
        // Vérifie que la commande appartient bien à l'utilisateur connecté
        if ($commande->user_id !== Auth::id()) {
            abort(403, 'Commande non autorisée.');
        }

        return view('client.livraisons.create', compact('commande'));
    }

    // Enregistrement de la livraison
    public function store(Request $request, Commande $commande)
    {
        if ($commande->user_id !== Auth::id()) {
            abort(403, 'Commande non autorisée.');
        }

        $request->validate([
            'nom' => 'required|string|max:255',
            'telephone' => 'required|string|min:8',
            'adresse' => 'required|string',
            'ville' => 'required|string',
            'code_postal' => 'nullable|string',
            'instructions' => 'nullable|string',
        ]);

        Livraison::create([
            'commande_id' => $commande->id,
            'nom' => $request->nom,
            'telephone' => $request->telephone,
            'adresse' => $request->adresse,
            'ville' => $request->ville,
            'code_postal' => $request->code_postal,
            'instructions' => $request->instructions,
        ]);

        return redirect()->route('client.commandes.index')->with('success', 'Adresse de livraison enregistrée.');
    }

    // Formulaire de modification d'une livraison
    public function edit(Livraison $livraison)
    {
        if ($livraison->commande->user_id !== Auth::id()) {
            abort(403, 'Accès refusé.');
        }

        return view('client.livraisons.edit', compact('livraison'));
    }

    // Mise à jour d'une livraison
    public function update(Request $request, Livraison $livraison)
    {
        if ($livraison->commande->user_id !== Auth::id()) {
            abort(403, 'Accès refusé.');
        }

        $request->validate([
            'nom' => 'required|string|max:255',
            'telephone' => 'required|string|min:8',
            'adresse' => 'required|string',
            'ville' => 'required|string',
            'code_postal' => 'nullable|string',
            'instructions' => 'nullable|string',
        ]);

        $livraison->update($request->all());

        return redirect()->route('client.livraisons.index')->with('success', 'Livraison mise à jour.');
    }

    // Suppression d'une livraison (optionnel)
    public function destroy(Livraison $livraison)
    {
        if ($livraison->commande->user_id !== Auth::id()) {
            abort(403, 'Accès refusé.');
        }

        $livraison->delete();

        return redirect()->route('client.livraisons.index')->with('success', 'Livraison supprimée.');
    }
}