<?php

namespace App\Http\Controllers\Secretaire;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfilController extends Controller
{
    public function edit()
    {
        $secretaire = Auth::user();
        return view('secretaire.profil.edit', compact('secretaire'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'nom' => 'required|string',
            'postnom' => 'required|string',
            'prenom' => 'required|string',
        ]);

        $user->update($request->only('nom', 'postnom', 'prenom'));

        return redirect()->route('secretaire.dashboard')->with('success', 'Profil mis à jour.');
    }
}
