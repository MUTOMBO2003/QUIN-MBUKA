<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Commande;
use App\Models\Paiement;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class PaiementController extends Controller
{
    /**
     * Crée et vérifie le paiement après retour de CinetPay.
     */
    public function create(Request $request, $commandeId)
    {
        $transactionId = $request->get('transaction_id');
        $mode = $request->get('mode'); // ex : cinetpay

        $commande = Commande::with('paiement')->findOrFail($commandeId);

        if ($commande->user_id !== Auth::id()) {
            return redirect()->route('client.commandes.index')->with('error', 'Commande non autorisée.');
        }

        if (!$transactionId || $mode !== 'cinetpay') {
            return redirect()->route('client.commandes.index')->with('error', 'Transaction invalide ou mode incorrect.');
        }

        // Clés API CinetPay
        $apiKey = '39378926168021035595416.34524459';
        $siteId = '105892564';

        // Appel API pour vérifier la transaction
        $response = Http::post('https://api-checkout.cinetpay.com/v2/payment/check', [
            'apikey' => $apiKey,
            'site_id' => $siteId,
            'transaction_id' => $transactionId,
        ]);

        $data = $response->json();

        if (isset($data['code']) && $data['code'] === '00') {
            // Paiement confirmé
            $commande->statut = 'payée';
            $commande->save();

            Paiement::updateOrCreate(
                ['commande_id' => $commande->id],
                [
                    'transaction_id' => $transactionId,
                    'reference' => $data['data']['payment_method'] ?? 'CinetPay',
                    'montant' => $commande->montant_total,
                    'methode' => 'CinetPay',
                    'statut' => 'payée',
                ]
            );

            return redirect()->route('client.commandes.index')->with('success', '✅ Paiement effectué avec succès.');
        } else {
            return redirect()->route('client.commandes.index')->with('error', '❌ Paiement non confirmé. Veuillez réessayer.');
        }
    }
}
