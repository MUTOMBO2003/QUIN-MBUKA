<?php

namespace App\Http\Controllers\Secretaire;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Paiement;

class SuiviPaiementController extends Controller
{
    /**
     * Affiche la liste paginée des paiements avec les infos clients et statut stocké en base.
     */
    public function index()
    {
        // On utilise paginate() pour permettre l'utilisation de links() dans la vue
        $paiements = Paiement::with('commande.user')
            ->orderByDesc('created_at')
            ->paginate(10); // Pagination (10 paiements par page)

        return view('secretaire.paiements.index', compact('paiements'));
    }

    /**
     * Affiche les détails d’un paiement donné.
     */
    public function show($id)
    {
        $paiement = Paiement::with('commande.user')->findOrFail($id);

        return view('secretaire.paiements.show', compact('paiement'));
    }
}
