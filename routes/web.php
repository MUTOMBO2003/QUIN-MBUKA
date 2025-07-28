<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RechercheProduitController;

use App\Http\Controllers\ProduitPublicController;
use App\Http\Controllers\PromotionPublicController;
// === SECRETAIRE ===
use App\Http\Controllers\Secretaire\SecretaireDashboardController;
use App\Http\Controllers\Secretaire\CommandeController as SecretaireCommandeController;
use App\Http\Controllers\Secretaire\PaiementController as SecretairePaiementController;
use App\Http\Controllers\Secretaire\ProfilController as SecretaireProfilController;
use App\Http\Controllers\Secretaire\SuiviCommandesController;
use App\Http\Controllers\Secretaire\ProfilController;
use App\Http\Controllers\Secretaire\SuiviPaiementController;
// === ADMIN ===
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\CategorieController;
use App\Http\Controllers\Admin\ProduitController;
use App\Http\Controllers\Admin\CommandeController as AdminCommandeController;
use App\Http\Controllers\Admin\PaiementController as AdminPaiementController;
use App\Http\Controllers\Admin\UtilisateurController;
use App\Http\Controllers\Admin\ProfilController as AdminProfilController;
use App\Http\Controllers\Admin\PromotionController;
// === CLIENT ===
use App\Http\Controllers\Client\ClientDashboardController;
use App\Http\Controllers\Client\ProduitController as ClientProduitController;
use App\Http\Controllers\Client\PanierController;
use App\Http\Controllers\Client\CommandeController as ClientCommandeController;
use App\Http\Controllers\Client\PaiementController as ClientPaiementController;
use App\Http\Controllers\Client\ProfilController as ClientProfilController;
use App\Http\Controllers\Client\PaiementController;
use App\Http\Controllers\Client\CommandeController;
use App\Http\Controllers\Secretaire\SecretaireLivraisonController;
use App\Http\Controllers\Client\LivraisonController;

use App\Http\Controllers\PageController;
use App\Models\Produit;

Route::get('/', function () {
    $nouveautes = Produit::latest()->take(8)->get();
    $promotions = Produit::whereNotNull('prix_initial')
        ->whereColumn('prix', '<', 'prix_initial')
        ->take(8)->get();

    return view('welcome', compact('nouveautes', 'promotions'));
})->name('home');
use App\Models\Categorie;



use App\Models\Promotion;

Route::get('/', function () {
    $categories = Categorie::all();
    $nouveautes = Produit::latest()->take(10)->get();
    $promotions = collect();

    return view('welcome', compact('categories', 'nouveautes', 'promotions'));
})->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';



Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::resource('/categories', CategorieController::class);
    Route::resource('/produits', ProduitController::class);

    Route::get('/commandes', [AdminCommandeController::class, 'index'])->name('commandes.index');
    Route::get('/commandes/{commande}', [AdminCommandeController::class, 'show'])->name('commandes.show');

    Route::get('/paiements', [AdminPaiementController::class, 'index'])->name('paiements.index');
    Route::get('/paiements/{paiement}', [AdminPaiementController::class, 'show'])->name('paiements.show');

    Route::get('/profil/edit', [AdminProfilController::class, 'edit'])->name('profil.edit');
    Route::put('/profil/update', [AdminProfilController::class, 'update'])->name('profil.update');
});


Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/promotions', [PromotionController::class, 'index'])->name('promotions.index');
    Route::get('/promotions/create', [PromotionController::class, 'create'])->name('promotions.create');
    Route::post('/promotions', [PromotionController::class, 'store'])->name('promotions.store');
});

Route::get('/recherche', [RechercheProduitController::class, 'index'])->name('recherche.produits');

Route::get('/produits', [ProduitController::class, 'index'])->name('client.produits.index');

Route::get('/a-propos', [PageController::class, 'about'])->name('about');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::get('/confidentialite', [PageController::class, 'privacy'])->name('privacy');
Route::get('/conditions', [PageController::class, 'terms'])->name('terms');
Route::get('/plan-du-site', [PageController::class, 'sitemap'])->name('sitemap');


Route::get('/produits', [ProduitPublicController::class, 'index'])->name('produits.public');
Route::get('/promotions', [PromotionPublicController::class, 'index'])->name('promotions.public');




Route::prefix('client')->name('client.')->group(function () {
    Route::get('/dashboard', [ClientDashboardController::class, 'index'])->name('dashboard');
    Route::get('/produits', [ClientProduitController::class, 'index'])->name('produits.index');
    Route::get('/produits/{produit}', [ClientProduitController::class, 'show'])->name('produits.show');
    Route::get('/commandes', [ClientCommandeController::class, 'index'])->name('commandes.index');
    Route::get('/commandes/{commande}', [ClientCommandeController::class, 'show'])->name('commandes.show');
    Route::get('/profil/edit', [ClientProfilController::class, 'edit'])->name('profil.edit');
    Route::put('/profil/update', [ClientProfilController::class, 'update'])->name('profil.update');
    Route::get('/profil', [ClientProfilController::class, 'edit'])->name('profile');
});
Route::prefix('client')->name('client.')->group(function () {
    Route::get('/paniers', [PanierController::class, 'index'])->name('paniers.index');
    Route::post('/paniers/add/{produit}', [PanierController::class, 'add'])->name('paniers.add');
    Route::delete('/paniers/remove/{id}', [PanierController::class, 'remove'])->name('paniers.remove');
    Route::delete('/paniers/clear', [PanierController::class, 'clear'])->name('paniers.clear');
});

Route::post('/client/paniers/valider', [PanierController::class, 'validerCommande'])->name('client.paniers.valider');
Route::get('/visiteur/panier', function () {
    return view('visiteur.panier'); // ou autre vue selon ton projet
})->name('panier.visiteur');


Route::post('/panier/valider', [PanierController::class, 'validerCommande'])->name('client.paniers.valider');
Route::middleware(['auth'])->group(function () {
    Route::get('/paiements/{commande}/create', [PaiementController::class, 'create'])->name('client.paiements.create');
});

Route::get('/secretaire/dashboard', [SecretaireDashboardController::class, 'index'])
    ->name('secretaire.dashboard');

Route::prefix('secretaire')->group(function () {
    Route::get('/profil/edit', [ProfilController::class, 'edit'])->name('secretaire.profil.edit');
    Route::post('/profil/update', [ProfilController::class, 'update'])->name('secretaire.profil.update');
});
Route::prefix('secretaire')->name('secretaire.')->group(function () {
    Route::get('/commandes/suivi', [SuiviCommandesController::class, 'index'])->name('commandes.suivi');
    Route::get('/commandes/{commande}/livraison/edit', [SuiviCommandesController::class, 'edit'])->name('commandes.livraison.edit');
    Route::put('/commandes/{commande}/livraison', [SuiviCommandesController::class, 'update'])->name('commandes.livraison.update');
    Route::get('/secretaire/commandes/{commande}/edit', [SuiviCommandesController::class, 'edit'])->name('secretaire.commandes.edit');
    Route::put('/commandes/{commande}', [SuiviCommandesController::class, 'update'])->name('secretaire.commandes.update');
});


Route::prefix('secretaire')->name('secretaire.')->group(function () {
    Route::get('paiements', [SuiviPaiementController::class, 'index'])->name('paiements.index');
    Route::get('paiements/{id}', [SuiviPaiementController::class, 'show'])->name('paiements.show');
});

Route::prefix('secretaire')->group(function () {
    Route::get('/commandes/suivi', [SuiviCommandesController::class, 'index'])->name('secretaire.commandes.suivi');
    Route::get('/commandes/{commande}/edit', [SuiviCommandesController::class, 'edit'])->name('secretaire.commandes.edit');
    Route::put('/commandes/{commande}', [SuiviCommandesController::class, 'update'])->name('secretaire.commandes.update');
});
use App\Models\Commande;

Route::get('/test-duree', function () {
    $commande = Commande::first();
    $commande->update(['duree_livraison' => '3 jours']);
    return $commande;
});
// Routes de paiement client sans middleware
Route::get('/paiements/{commande}/create', [PaiementController::class, 'create'])->name('client.paiements.create');
Route::post('/paiements/{commande}/store', [PaiementController::class, 'store'])->name('client.paiements.store');
// Paiement Client
Route::post('/paiements/callback', [\App\Http\Controllers\Client\PaiementController::class, 'callback'])->name('client.paiements.callback');
Route::get('/paiements/{commande}/create', [PaiementController::class, 'create'])->name('client.paiements.create');
Route::post('/paiements/{commande}/store', [PaiementController::class, 'store'])->name('client.paiements.store');
Route::get('/paiements/{commande}/waiting', [PaiementController::class, 'waiting'])->name('client.paiements.waiting');
Route::get('/paiements/{commande}/create', [PaiementController::class, 'create'])->name('client.paiements.create');
Route::post('/paiements/{commande}/store', [PaiementController::class, 'store'])->name('client.paiements.store');
Route::get('/paiements/{commande}/waiting', [PaiementController::class, 'waiting'])->name('client.paiements.waiting');


Route::post('/paiement/callback', [PaiementController::class, 'callback'])->name('paiement.callback');
Route::post('/paiement/callback', [PaiementController::class, 'callback'])->name('paiement.callback');

Route::get('/paiement/callback', function () {
    return redirect()->route('client.commandes.index')->with('success', 'Paiement traité ou en cours.');
})->name('paiement.callback');
// Nouvelle route directe pour initier le paiement
Route::get('/paiements/{commande}/payer', [PaiementController::class, 'payer'])->name('client.paiements.payer');


Route::prefix('client')->name('client.')->group(function () {
    Route::get('/commandes', [CommandeController::class, 'index'])->name('commandes.index');
    Route::get('/commandes/create', [CommandeController::class, 'create'])->name('commandes.create');
    Route::post('/commandes', [CommandeController::class, 'store'])->name('commandes.store');
});

Route::get('/nouveautes', [ProduitPublicController::class, 'index'])->name('nouveautes.public');
Route::get('/promotions', [PromotionPublicController::class, 'index'])->name('promotions.public');


// Routes Livraison accessibles sans middleware
Route::prefix('client')->name('client.')->group(function () {
    
    // Afficher toutes les livraisons du client
    Route::get('livraisons', [LivraisonController::class, 'index'])->name('livraisons.index');

    // Formulaire de création d'une livraison liée à une commande
    Route::get('livraison/{commande}/create', [LivraisonController::class, 'create'])->name('livraisons.create');

    // Enregistrer une livraison
    Route::post('livraison/{commande}/store', [LivraisonController::class, 'store'])->name('livraisons.store');

    // Formulaire d'édition
    Route::get('livraisons/{livraison}/edit', [LivraisonController::class, 'edit'])->name('livraisons.edit');

    // Mise à jour
    Route::put('livraisons/{livraison}', [LivraisonController::class, 'update'])->name('livraisons.update');

    // Suppression (optionnel)
    Route::delete('livraisons/{livraison}', [LivraisonController::class, 'destroy'])->name('livraisons.destroy');
});
Route::post('paiement/callback', [PaiementController::class, 'callback'])->name('paiement.callback');

Route::get('/produits/similaires/{id}', [App\Http\Controllers\Client\ProduitController::class, 'similaires'])
    ->name('client.produits.similaires');
Route::prefix('secretaire')->name('secretaire.')->group(function () {
    Route::get('/commandes', [SuiviCommandesController::class, 'index'])->name('commandes.suivi');
    Route::get('/commandes/{id}', [SuiviCommandesController::class, 'show'])->name('commandes.show');
    Route::put('/commandes/{commande}', [SuiviCommandesController::class, 'update'])->name('commandes.update');
});



// Routes des livraisons pour le rôle secrétaire
Route::prefix('secretaire/livraisons')->name('secretaire.livraisons.')->group(function () {
    Route::get('/', [SecretaireLivraisonController::class, 'index'])->name('index');
    Route::get('/{livraison}', [SecretaireLivraisonController::class, 'show'])->name('show');
    Route::get('/{livraison}/edit', [SecretaireLivraisonController::class, 'edit'])->name('edit');
    Route::put('/{livraison}', [SecretaireLivraisonController::class, 'update'])->name('update');
});

Route::post('/commandes', [ClientCommandeController::class, 'store'])->name('commandes.store');


Route::post('/client/paiements/notify', [PaiementController::class, 'notify'])->name('client.paiements.notify');
Route::get('/client/paiements/{commande}', [PaiementController::class, 'create'])->name('client.paiements.create');
Route::post('/client/paiements/{commande}', [PaiementController::class, 'payer'])->name('client.paiements.payer');
Route::post('/client/paiements/notify', [PaiementController::class, 'notify'])->name('client.paiements.notify');


// Routes CRUD utilisateurs (sans middleware)
Route::prefix('admin/utilisateurs')->name('admin.utilisateurs.')->group(function () {
    Route::get('/', [UtilisateurController::class, 'index'])->name('index');
    Route::get('/create', [UtilisateurController::class, 'create'])->name('create');
    Route::post('/', [UtilisateurController::class, 'store'])->name('store');
    Route::get('/{user}', [UtilisateurController::class, 'show'])->name('show');
    Route::get('/{user}/edit', [UtilisateurController::class, 'edit'])->name('edit');
    Route::put('/{user}', [UtilisateurController::class, 'update'])->name('update');
    Route::delete('/{user}', [UtilisateurController::class, 'destroy'])->name('destroy');
});

// Commandes client
Route::get('/client/commandes', [CommandeController::class, 'index'])->name('client.commandes.index');
Route::get('/client/commandes/{commande}', [CommandeController::class, 'show'])->name('client.commandes.show');
Route::get('/client/commandes/{commande}/edit', [CommandeController::class, 'edit'])->name('client.commandes.edit');
Route::put('/client/commandes/{commande}', [CommandeController::class, 'update'])->name('client.commandes.update');
Route::patch('/client/commandes/{commande}/annuler', [CommandeController::class, 'annuler'])->name('client.commandes.annuler');
Route::post('/client/commandes', [CommandeController::class, 'store'])->name('client.commandes.store');
