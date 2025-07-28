<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Livraison extends Model
{
    use HasFactory;

    protected $fillable = [
        'commande_id',
        'nom',
        'telephone',
        'adresse',
        'ville',
        'code_postal',
        'instructions',
        'statut',
    ];
    public function commande()
{
    return $this->belongsTo(\App\Models\Commande::class);
}

}
