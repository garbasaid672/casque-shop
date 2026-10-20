<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\OrderReview;
use App\Models\Product;
use App\Services\KkiaPayService;
use Illuminate\Support\Collection;

// Contrôleur pour la page d'accueil de la boutique
class HomeController extends Controller
{
    // Affiche la page d'accueil avec produits vedettes, catégories et nouveautés
    public function index(KkiaPayService $kkiapay)
    {
        // Vedettes : choix de l'admin (Admin > Gestion > Accueil du site),
        // sinon 8 produits marqués is_featured
        $featuredProducts = $this->chosenProducts('home_featured')
            ?? Product::where('is_active', true)
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

        // Nouveautés : choix de l'admin, sinon les 4 produits les plus récents
        $newProducts = $this->chosenProducts('home_new')
            ?? Product::where('is_active', true)
                ->with('category')
                ->latest('published_at')
                ->take(4)
                ->get();

        $reviews = OrderReview::query()
            ->where('is_approved', true)
            ->latest()
            ->take(6)
            ->get();
        $reviewCount = OrderReview::where('is_approved', true)->count();
        $reviewAverage = OrderReview::where('is_approved', true)->avg('rating');
        $kkiapayConfigured = $kkiapay->isConfigured();

        return view('home', compact(
            'featuredProducts',
            'categories',
            'newProducts',
            'reviews',
            'reviewCount',
            'reviewAverage',
            'kkiapayConfigured',
        ));
    }

    // Produits choisis par l'admin (réglage JSON), dans l'ordre choisi et
    // limités aux actifs. null si aucun choix (= sélection automatique).
    protected function chosenProducts(string $key): ?Collection
    {
        $raw = setting($key, '[]');
        $ids = json_decode((string) $raw, true);

        if (! is_array($ids) || count($ids) === 0) {
            return null;
        }

        $ids = array_values(array_filter(array_map('intval', $ids)));

        if (count($ids) === 0) {
            return null;
        }

        return Product::whereIn('id', $ids)
            ->where('is_active', true)
            ->with('category')
            ->get()
            ->sortBy(fn (Product $p): int => array_search($p->id, $ids, true) === false ? PHP_INT_MAX : array_search($p->id, $ids, true))
            ->values();
    }
}
