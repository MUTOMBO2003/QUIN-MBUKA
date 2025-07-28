<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfilController extends Controller
{
    public function edit()
    {
        $client = Auth::user();
        return view('client.profil.edit', compact('client'));
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

        return redirect()->route('client.dashboard')->with('success', 'Profil mis à jour.');
    }
}