<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfilController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        return view('admin.profil.edit', compact('user'));
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

        return redirect()->route('admin.dashboard')->with('success', 'Profil mis à jour.');
    }
}
