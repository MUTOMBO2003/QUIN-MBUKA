<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class AuthenticatedSessionController extends Controller
{
    /**
     * Affiche le formulaire de connexion.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Gère la tentative de connexion.
     */
    public function store(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'identifiant' => 'required|string',
            'password' => 'required|string',
        ]);

        // Détermine si l’identifiant est un email ou un matricule
        $champ = filter_var($credentials['identifiant'], FILTER_VALIDATE_EMAIL) ? 'email' : 'matricule';

        if (!Auth::attempt([
            $champ => $credentials['identifiant'],
            'password' => $credentials['password'],
        ], $request->boolean('remember'))) {
            throw ValidationException::withMessages([
                'identifiant' => __('Identifiant ou mot de passe incorrect.'),
            ]);
        }

        $request->session()->regenerate();

        // Si le panier existe et l'utilisateur est client, redirige vers le panier
        if (session()->has('panier') && Auth::user()->role === 'client') {
            return redirect()->route('client.paniers.index');
        }

        // Redirection par rôle
        return match (Auth::user()->role) {
            'admin' => redirect()->intended('/admin/dashboard'),
            'secretaire' => redirect()->intended('/secretaire/dashboard'),
            'client' => redirect()->intended('/client/dashboard'),
            default => redirect('/'),
        };
    }
    /**
     * Déconnecte l’utilisateur.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}