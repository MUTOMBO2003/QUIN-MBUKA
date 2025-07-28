<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class RegisteredUserController extends Controller
{
    /**
     * Affiche le formulaire d'inscription.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Traite l'enregistrement d'un utilisateur.
     */
    public function store(Request $request): RedirectResponse
    {
        $identifiant = $request->input('identifiant');

        // Déduire le rôle à partir du type d’identifiant
        $role = filter_var($identifiant, FILTER_VALIDATE_EMAIL) ? 'client' : 'staff';

        if ($role === 'client') {
            $data = $request->validate([
                'identifiant' => 'required|email|max:255|unique:users,email',
                'nom' => 'required|string|max:255',
                'postnom' => 'required|string|max:255',
                'prenom' => 'required|string|max:255',
                'password' => 'required|string|confirmed|min:8',
            ]);

            User::create([
                'email' => $data['identifiant'],
                'nom' => $data['nom'],
                'postnom' => $data['postnom'],
                'prenom' => $data['prenom'],
                'password' => Hash::make($data['password']),
                'role' => 'client',
            ]);
        } else {
            $data = $request->validate([
                'identifiant' => 'required|string|size:10|exists:users,matricule',
                'nom' => 'required|string|max:255',
                'postnom' => 'required|string|max:255',
                'prenom' => 'required|string|max:255',
                'password' => 'required|string|confirmed|min:8',
            ]);

            $user = User::where('matricule', $data['identifiant'])->first();

            if ($user->password || $user->email) {
                throw ValidationException::withMessages([
                    'identifiant' => 'Ce matricule a déjà été utilisé.',
                ]);
            }

            $user->update([
                'nom' => $data['nom'],
                'postnom' => $data['postnom'],
                'prenom' => $data['prenom'],
                'password' => Hash::make($data['password']),
            ]);
        }

        // Déclenche l'événement d'inscription (utile pour les listeners si nécessaires)
        event(new Registered($user ?? null));

        // Redirige vers la page de connexion
        return redirect()->route('login')->with('success', 'Votre compte a été créé avec succès. Veuillez vous connecter.');
    }
}
