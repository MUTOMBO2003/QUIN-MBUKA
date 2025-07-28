<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'matricule',
        'nom',
        'postnom',
        'prenom',
        'email',
        'password',
        'role', // enum: admin, secretaire, client
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function commandes()
    {
        return $this->hasMany(Commande::class);
    }

    public function paniers()
    {
        return $this->hasMany(Panier::class);
    }

    // Optionnel si tu veux relier à une vraie table `roles`
    public function roleModel()
    {
        return $this->belongsTo(Role::class, 'role', 'name');
    }
}
