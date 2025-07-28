<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Produit extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'description',
        'prix',
        'prix_initial',
        'image',
        'categorie_id',
        'stock',
    ];

    /**
     * Casts pour forcer les montants à être manipulés comme des entiers (CDF)
     */
    protected $casts = [
        'prix' => 'integer',
        'prix_initial' => 'integer',
    ];

    /**
     * Relation avec la catégorie
     */
    public function categorie()
    {
        return $this->belongsTo(Categorie::class);
    }

    /**
     * Détermine si le produit est en promotion
     */
    public function estEnPromotion(): bool
    {
        return $this->prix_initial && $this->prix < $this->prix_initial;
    }

    /**
     * Pourcentage de réduction
     */
    public function reductionPourcentage(): int
    {
        if ($this->estEnPromotion() && $this->prix_initial > 0) {
            return round((($this->prix_initial - $this->prix) / $this->prix_initial) * 100);
        }
        return 0;
    }

    /**
     * Formatage du prix pour l’affichage en FC
     */
    public function getPrixFormatAttribute(): string
    {
        return number_format($this->prix, 0, ',', ' ') . ' FC';
    }

    public function getPrixInitialFormatAttribute(): string
    {
        return $this->prix_initial ? number_format($this->prix_initial, 0, ',', ' ') . ' FC' : '';
    }
}