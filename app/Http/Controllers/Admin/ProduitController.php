<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Produit;
use App\Models\Categorie;
use Illuminate\Http\Request;

class ProduitController extends Controller
{
    public function index()
    {
        $produits = Produit::with('categorie')->get();
        return view('admin.produits.index', compact('produits'));
    }

    public function create()
    {
        $categories = Categorie::all();
        return view('admin.produits.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nom' => 'required|string',
            'prix' => 'required|numeric',
            'stock' => 'required|integer',
            'categorie_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
            'image' => 'nullable|image',
        ]);

        // Convertir le prix en entier (CDF)
        $data['prix'] = intval($data['prix']);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('produits', 'public');
        }

        Produit::create($data);
        return redirect()->route('admin.produits.index')->with('success', 'Produit ajouté avec succès');
    }

    public function edit(Produit $produit)
    {
        $categories = Categorie::all();
        return view('admin.produits.edit', compact('produit', 'categories'));
    }

    public function update(Request $request, Produit $produit)
    {
        $data = $request->validate([
            'nom' => 'required|string',
            'prix' => 'required|numeric',
            'stock' => 'required|integer',
            'categorie_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
            'image' => 'nullable|image',
        ]);

        // Convertir le prix en entier (CDF)
        $data['prix'] = intval($data['prix']);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('produits', 'public');
        }

        $produit->update($data);
        return redirect()->route('admin.produits.index')->with('success', 'Produit mis à jour avec succès');
    }

    public function destroy(Produit $produit)
    {
        $produit->delete();
        return back()->with('success', 'Produit supprimé');
    }
}
