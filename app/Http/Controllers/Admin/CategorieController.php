<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Categorie;
use Illuminate\Http\Request;

class CategorieController extends Controller
{
    public function index()
    {
        $categories = Categorie::all();
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|unique:categories']);
        Categorie::create($request->only('name'));
        return redirect()->route('admin.categories.index');
    }

    public function edit(Categorie $categorie)
    {
        return view('admin.categories.edit', compact('categorie'));
    }

    public function update(Request $request, Categorie $categorie)
    {
        $request->validate(['name' => 'required|string|unique:categories,name,' . $categorie->id]);
        $categorie->update($request->only('name'));
        return redirect()->route('admin.categories.index');
    }

    public function destroy(Categorie $categorie)
    {
        $categorie->delete();
        return back();
    }
}