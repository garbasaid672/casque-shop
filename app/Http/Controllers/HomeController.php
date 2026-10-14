<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;

// Contrôleur pour la page d'accueil de la boutique
class HomeController extends Controller
{
    // Affiche la page d'accueil avec produits vedettes, catégories et nouveautés
    public function index()
    {
        // Récupère 8 produits vedettes (is_featured = true) avec leur catégorie
        $featuredProducts = Product::where('is_active', true)
            ->where('is_featured', true)
            ->with('category')
            ->latest()
            ->take(8)
            ->get();

        // Récupère les catégories actives avec le nombre de produits, triées par sort_order
        $categories = Category::where('is_active', true)
            ->withCount('products')
            ->orderBy('sort_order')
            ->get();

        // Récupère les 4 produits les plus récents (par published_at) avec leur catégorie
        $newProducts = Product::where('is_active', true)
            ->with('category')
            ->latest('published_at')
            ->take(4)
            ->get();

        // Retourne la vue home avec les données
        return view('home', compact('featuredProducts', 'categories', 'newProducts'));
    }
}