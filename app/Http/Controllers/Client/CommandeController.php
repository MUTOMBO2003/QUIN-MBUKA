<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Commande;
use App\Models\CommandeDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CommandeController extends Controller
{
    /**
     * Liste des commandes du client connecté.
     */
    public function index()
    {
        $commandes = Commande::with(['details.produit', 'paiement'])
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('client.commandes.index', compact('commandes'));
    }

    /**
     * Affiche les détails d'une commande spécifique.
     */
    public function show($id)
    {
        $commande = Commande::with(['details.produit', 'paiement'])
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        return view('client.commandes.show', compact('commande'));
    }

    /**
     * Crée une nouvelle commande à partir du panier.
     */
    public function store(Request $request)
    {
        $panier = session('panier', []);

        if (empty($panier)) {
            return redirect()->back()->with('error', 'Votre panier est vide.');
        }

        DB::beginTransaction();

        try {
            $montantTotal = collect($panier)->sum(fn($item) => $item['prix'] * $item['quantite']);

            $commande = Commande::create([
                'user_id' => Auth::id(),
                'statut' => 'en attente',
                'montant_total' => $montantTotal,
            ]);

            foreach ($panier as $item) {
                CommandeDetail::create([
                    'commande_id' => $commande->id,
                    'produit_id' => $item['id'],
                    'quantite' => $item['quantite'],
                    'prix_unitaire' => $item['prix'],
                ]);
            }

            DB::commit();
            session()->forget('panier');

            return redirect()->route('client.commandes.index')
                ->with('success', 'Commande enregistrée. Veuillez procéder au paiement.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Erreur lors du traitement de votre commande.');
        }
    }

    /**
     * Affiche le formulaire de modification.
     */
    public function edit($id)
    {
        $commande = Commande::with('details.produit')
            ->where('user_id', Auth::id())
            ->where('statut', 'en attente')
            ->findOrFail($id);

        return view('client.commandes.edit', compact('commande'));
    }

    /**
     * Met à jour la commande avec les nouvelles quantités.
     */
    public function update(Request $request, $id)
    {
        $commande = Commande::where('user_id', Auth::id())
            ->where('statut', 'en attente')
            ->findOrFail($id);

        $data = $request->validate([
            'quantites' => 'required|array',
            'quantites.*' => 'required|integer|min:1',
        ]);

        $total = 0;

        foreach ($commande->details as $detail) {
            if (isset($data['quantites'][$detail->id])) {
                $quantite = $data['quantites'][$detail->id];
                $detail->quantite = $quantite;
                $detail->save();
                $total += $quantite * $detail->prix_unitaire;
            }
        }

        $commande->update(['montant_total' => $total]);

        return redirect()->route('client.commandes.show', $commande->id)
            ->with('success', 'Commande mise à jour avec succès.');
    }

    /**
     * Permet au client d'annuler une commande en attente.
     */
    public function annuler($id)
    {
        $commande = Commande::where('user_id', Auth::id())
            ->where('statut', 'en attente')
            ->findOrFail($id);

        $commande->update(['statut' => 'annulée']);

        return redirect()->route('client.commandes.index')
            ->with('success', 'Commande annulée avec succès.');
    }
}
