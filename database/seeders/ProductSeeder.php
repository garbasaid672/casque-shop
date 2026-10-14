<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

// Seeder pour peupler la base avec des catégories et produits de test
class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // Idempotent : ne recrée pas 25 produits à chaque redémarrage gratuit
        if (Product::count() >= 20) {
            return;
        }
        // Crée 5 catégories actives
        $categories = Category::factory()->count(5)->create([
            'is_active' => true,
        ]);

        // Crée 20 produits actifs assignés aléatoirement aux catégories
        Product::factory()->count(20)->create([
            'is_active' => true,
            'category_id' => $categories->random()->id,
        ])->each(function ($product) use ($categories) {
            // 30% de chance de passer le produit en vedette
            if (fake()->boolean(30)) {
                $product->update([
                    'is_featured' => true,
                ]);
            }
        });

        // Crée 5 produits supplémentaires garantis en vedette (pour la page d'accueil)
        Product::factory()->count(5)->create([
            'is_active' => true,
            'is_featured' => true,
            'category_id' => $categories->random()->id,
        ]);
    }
}