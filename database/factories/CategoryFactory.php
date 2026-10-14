<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * Factory pour générer des catégories de test
 * @extends Factory<Category>
 */
class CategoryFactory extends Factory
{
    protected $model = Category::class;

    // Définit les données par défaut pour une catégorie
    public function definition(): array
    {
        // Nom unique parmi une liste prédéfinie de catégories de casques
        $name = fake()->unique()->randomElement([
            'Casques sans fil',
            'Casques filaires',
            'Casques gaming',
            'Casques audiophiles',
            'Casques sport',
            'Casques à réduction de bruit',
            'Écouteurs true wireless',
            'Casques Bluetooth',
        ]);

        return [
            'name' => $name,
            // Slug unique : nom en kebab-case + nombre aléatoire
            'slug' => Str::slug($name) . '-' . fake()->unique()->numberBetween(1000, 9999),
            'description' => fake()->paragraph(),  // Description aléatoire
            'image' => null,                       // Pas d'image par défaut
            'sort_order' => fake()->numberBetween(1, 100), // Ordre aléatoire
            'is_active' => true,                   // Catégorie active par défaut
        ];
    }
}