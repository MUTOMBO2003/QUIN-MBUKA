<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Produit;
use App\Models\Categorie;
use App\Models\Commande;
use App\Models\Promotion;
use App\Models\User;
use App\Models\Paiement;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Compteurs pour les cartes du tableau de bord
        $produitsCount    = Produit::count();
        $categoriesCount  = Categorie::count();
        $commandesCount   = Commande::count();
    
        $usersCount       = User::count();
        $paiementsCount   = Paiement::count();

        // Activités récentes (5 dernières commandes et clients)
        $recentActivities = [];

        $recentCommandes = Commande::latest()->take(5)->get();
        foreach ($recentCommandes as $commande) {
            $recentActivities[] = [
                'type' => 'commande',
                'description' => "Commande #{$commande->id} par {$commande->user->name}",
                'created_at' => $commande->created_at,
            ];
        }

        $recentClients = User::where('role', 'client')->latest()->take(5)->get();
        foreach ($recentClients as $client) {
            $recentActivities[] = [
                'type' => 'utilisateur',
                'description' => "Nouvel utilisateur : {$client->name}",
                'created_at' => $client->created_at,
            ];
        }

        // Tri par date décroissante
        usort($recentActivities, fn($a, $b) => strtotime($b['created_at']) <=> strtotime($a['created_at']));

        return view('admin.dashboard', compact(
            'produitsCount',
            'categoriesCount',
            'commandesCount',
       
            'usersCount',
            'paiementsCount',
            'recentActivities'
        ));
    }
}
