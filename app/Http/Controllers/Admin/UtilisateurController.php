<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UtilisateurController extends Controller
{
    /**
     * Liste des utilisateurs clients et secrétaires
     */
    public function index()
    {
        $utilisateurs = User::whereIn('role', ['client', 'secretaire'])->get();
        return view('admin.utilisateurs.index', compact('utilisateurs'));
    }

    /**
     * Affiche le formulaire de création d'un utilisateur
     */
    public function create()
    {
        return view('admin.utilisateurs.create');
    }

    /**
     * Enregistre un utilisateur avec matricule et rôle uniquement (pré-inscription)
     */
    public function store(Request $request)
    {
        $request->validate([
            'role' => 'required|in:client,secretaire,admin',
            'matricule' => 'required|string|unique:users,matricule',
        ]);

        User::create([
            'role' => $request->role,
            'matricule' => $request->matricule,
            // Les autres champs seront complétés à l'inscription par l'utilisateur
        ]);

        return redirect()->route('admin.utilisateurs.index')
                         ->with('success', 'Utilisateur ajouté avec succès (pré-enregistré).');
    }

    /**
     * Affiche les détails d'un utilisateur
     */
    public function show(User $user)
    {
        return view('admin.utilisateurs.show', compact('user'));
    }

    /**
     * Affiche le formulaire de modification
     */
    public function edit(User $user)
    {
        return view('admin.utilisateurs.edit', compact('user'));
    }

    /**
     * Met à jour les informations d'un utilisateur
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'prenom' => 'required|string|max:255',
            'nom' => 'required|string|max:255',
            'role' => 'required|in:admin,secretaire,client',
            'email' => 'nullable|email|unique:users,email,' . $user->id,
            'matricule' => 'nullable|string|unique:users,matricule,' . $user->id,
        ]);

        $user->prenom = $request->prenom;
        $user->nom = $request->nom;
        $user->role = $request->role;

        if ($request->role === 'client') {
            $user->email = $request->email;
            $user->matricule = null;
        } else {
            $user->matricule = $request->matricule;
            $user->email = null;
        }

        $user->save();

        return redirect()->route('admin.utilisateurs.index')
                         ->with('success', 'Utilisateur mis à jour avec succès.');
    }

    /**
     * Supprime un utilisateur
     */
    public function destroy(User $user)
    {
        $user->delete();
        return back()->with('success', 'Utilisateur supprimé avec succès.');
    }
}
