<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commande extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'statut',
        'montant_total',
        'duree_livraison',
    ];

    /**
     * L'utilisateur qui a passé la commande
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Détails de la commande (articles, quantités, etc.)
     */
    public function details()
    {
        return $this->hasMany(CommandeDetail::class);
    }

    /**
     * Paniers associés (si structure différente des détails)
     */
    public function paniers()
    {
        return $this->hasMany(Panier::class);
    }

    /**
     * Paiement de la commande
     */
    public function paiement()
    {
        return $this->hasOne(Paiement::class);
    }

    /**
     * Produits liés à la commande (relation many-to-many)
     */
    public function produits()
    {
        return $this->belongsToMany(Produit::class, 'commande_details', 'commande_id', 'produit_id')
                    ->withPivot('quantite') // si présent dans la table pivot
                    ->withTimestamps();
    }
}
