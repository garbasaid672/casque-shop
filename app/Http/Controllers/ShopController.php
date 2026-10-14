<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

// Contrôleur de la boutique : catalogue et fiche produit
class ShopController extends Controller
{
    // Catalogue : tous les produits actifs + recherche / filtre / tri
    public function index(Request $request)
    {
        $query = Product::where('is_active', true)->with('category');

        // Recherche par nom ou marque
        if ($search = $request->string('q')->toString()) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('brand', 'like', "%{$search}%");
            });
        }

        // Filtre par catégorie (slug)
        $currentCategory = null;
        if ($request->filled('categorie')) {
            $currentCategory = Category::where('slug', $request->string('categorie')->toString())
                ->where('is_active', true)
                ->first();
            if ($currentCategory) {
                $query->where('category_id', $currentCategory->id);
            }
        }

        // Tri
        match ($request->string('tri')->toString()) {
            'prix-asc' => $query->orderBy('price'),
            'prix-desc' => $query->orderByDesc('price'),
            'nom' => $query->orderBy('name'),
            default => $query->latest('published_at'),
        };

        $products = $query->paginate(12)->withQueryString();
        $categories = Category::where('is_active', true)
            ->withCount(['products' => fn ($q) => $q->where('is_active', true)])
            ->orderBy('sort_order')
            ->get();

        return view('shop.index', compact('products', 'categories', 'currentCategory'));
    }

    // Fiche d'un produit avec bouton "Payer"
    public function show(Product $product)
    {
        if (! $product->is_active) {
            abort(404);
        }

        $product->load('category');

        // Produits similaires (même catégorie)
        $related = Product::where('is_active', true)
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->latest('published_at')
            ->take(4)
            ->get();

        return view('shop.show', compact('product', 'related'));
    }
}
