<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Commande;
use App\Models\CommandeDetail;
use App\Models\Produit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PanierController extends Controller
{
    /**
     * Affiche le contenu du panier.
     */
    public function index()
    {
        $panier = session('panier', []);
        return view('client.paniers.index', compact('panier'));
    }

    /**
     * Ajoute un produit au panier avec suggestions similaires.
     */
    public function add(Request $request, Produit $produit)
    {
        $panier = session()->get('panier', []);

        if (isset($panier[$produit->id])) {
            $panier[$produit->id]['quantite']++;
        } else {
            // Produits similaires (même catégorie, sauf lui-même)
            $similaires = Produit::where('categorie_id', $produit->categorie_id)
                ->where('id', '!=', $produit->id)
                ->inRandomOrder()
                ->take(3)
                ->get();

            $panier[$produit->id] = [
                'id' => $produit->id,
                'nom' => $produit->nom,
                'prix' => $produit->prix,
                'image' => $produit->image,
                'quantite' => 1,
                'similaires' => $similaires->map(function ($sim) {
                    return [
                        'id' => $sim->id,
                        'nom' => $sim->nom,
                        'prix' => $sim->prix,
                    ];
                })->toArray()
            ];
        }

        session()->put('panier', $panier);
        return redirect()->back()->with('success', 'Produit ajouté au panier.');
    }

    /**
     * Retire un produit du panier.
     */
    public function remove($id)
    {
        $panier = session()->get('panier', []);
        if (isset($panier[$id])) {
            unset($panier[$id]);
            session()->put('panier', $panier);
        }
        return redirect()->back()->with('success', 'Produit retiré du panier.');
    }

    /**
     * Vide complètement le panier.
     */
    public function clear()
    {
        session()->forget('panier');
        return redirect()->back()->with('success', 'Panier vidé.');
    }

    /**
     * Valide la commande sans lancer le paiement.
     */
    public function validerCommande()
    {
        $panier = session('panier', []);
        if (empty($panier)) {
            return redirect()->back()->with('error', 'Votre panier est vide.');
        }

        DB::beginTransaction();

        try {
            $total = collect($panier)->sum(fn($item) => $item['prix'] * $item['quantite']);

            $commande = Commande::create([
                'user_id' => Auth::id(),
                'statut' => 'en attente',
                'montant_total' => $total,
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

            return redirect()->route('client.commandes.index')->with('success', 'Commande enregistrée. Vous pouvez maintenant effectuer le paiement.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Erreur lors de la validation : ' . $e->getMessage());
        }
    }
}
