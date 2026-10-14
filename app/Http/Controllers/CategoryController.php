<?php

namespace App\Http\Controllers;

use App\Models\Category;

// Contrôleur pour la page d'une catégorie (affiche tous ses produits)
class CategoryController extends Controller
{
    // Liste toutes les catégories actives
    public function index()
    {
        $categories = Category::where('is_active', true)
            ->withCount(['products' => fn ($q) => $q->where('is_active', true)])
            ->orderBy('sort_order')
            ->get();

        return view('categories.index', compact('categories'));
    }

    // Affiche la catégorie et tous ses produits actifs
    public function show(Category $category)
    {
        // Catégorie désactivée : page introuvable
        if (! $category->is_active) {
            abort(404);
        }

        // Tous les produits actifs de la catégorie, plus récents d'abord
        $products = $category->products()
            ->where('is_active', true)
            ->with('category')
            ->latest('published_at')
            ->paginate(12);

        return view('categories.show', compact('category', 'products'));
    }
}
