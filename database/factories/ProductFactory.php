<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * Factory pour générer des produits de test (casques audio)
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    protected $model = Product::class;

    // Mapping produit -> image placeholder (Unsplash headphones)
    protected $productImages = [
        'Sony WH-1000XM5' => 'https://images.unsplash.com/photo-1618366712010-f4ae9c647dcb?w=800&h=600&fit=crop',
        'Bose QuietComfort Ultra' => 'https://images.unsplash.com/photo-1546435770-a3e426bf472b?w=800&h=600&fit=crop',
        'Apple AirPods Max' => 'https://images.unsplash.com/photo-1572569511254-d8f925fe2cbb?w=800&h=600&fit=crop',
        'Sennheiser Momentum 4' => 'https://images.unsplash.com/photo-1484704849700-f032a568e944?w=800&h=600&fit=crop',
        'Bowers & Wilkins Px8' => 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=800&h=600&fit=crop',
        'Audio-Technica ATH-M50xBT2' => 'https://images.unsplash.com/photo-1583394838336-acd977736f90?w=800&h=600&fit=crop',
        'Jabra Elite 85h' => 'https://images.unsplash.com/photo-1484704849700-f032a568e944?w=800&h=600&fit=crop',
        'Beats Studio Pro' => 'https://images.unsplash.com/photo-1572569511254-d8f925fe2cbb?w=800&h=600&fit=crop',
        'Sony WH-CH720N' => 'https://images.unsplash.com/photo-1618366712010-f4ae9c647dcb?w=800&h=600&fit=crop',
        'Bose QuietComfort 45' => 'https://images.unsplash.com/photo-1546435770-a3e426bf472b?w=800&h=600&fit=crop',
        'Sennheiser HD 450BT' => 'https://images.unsplash.com/photo-1484704849700-f032a568e944?w=800&h=600&fit=crop',
        'Anker Soundcore Space Q45' => 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=800&h=600&fit=crop',
        'JBL Tour One M2' => 'https://images.unsplash.com/photo-1583394838336-acd977736f90?w=800&h=600&fit=crop',
        'Technics EAH-A800' => 'https://images.unsplash.com/photo-1618366712010-f4ae9c647dcb?w=800&h=600&fit=crop',
        'Focal Bathys' => 'https://images.unsplash.com/photo-1546435770-a3e426bf472b?w=800&h=600&fit=crop',
        'Shure AONIC 50' => 'https://images.unsplash.com/photo-1484704849700-f032a568e944?w=800&h=600&fit=crop',
        'Puro Sound Labs BT2200' => 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=800&h=600&fit=crop',
        'Skullcandy Crusher Evo' => 'https://images.unsplash.com/photo-1583394838336-acd977736f90?w=800&h=600&fit=crop',
        'Razer Barracuda Pro' => 'https://images.unsplash.com/photo-1618366712010-f4ae9c647dcb?w=800&h=600&fit=crop',
        'SteelSeries Arctis Nova Pro' => 'https://images.unsplash.com/photo-1546435770-a3e426bf472b?w=800&h=600&fit=crop',
        'Sony WH-XB910N' => 'https://images.unsplash.com/photo-1618366712010-f4ae9c647dcb?w=800&h=600&fit=crop',
        'Bose 700' => 'https://images.unsplash.com/photo-1546435770-a3e426bf472b?w=800&h=600&fit=crop',
        'Sennheiser HD 660S2' => 'https://images.unsplash.com/photo-1484704849700-f032a568e944?w=800&h=600&fit=crop',
        'Meze Audio 99 Classics' => 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=800&h=600&fit=crop',
        'Hifiman Ananda BT' => 'https://images.unsplash.com/photo-1583394838336-acd977736f90?w=800&h=600&fit=crop',
    ];

    // Définit les données par défaut pour un produit
    public function definition(): array
    {
        // Nom aléatoire parmi une liste de vrais modèles de casques
        $name = fake()->randomElement([
            'Sony WH-1000XM5',
            'Bose QuietComfort Ultra',
            'Apple AirPods Max',
            'Sennheiser Momentum 4',
            'Bowers & Wilkins Px8',
            'Audio-Technica ATH-M50xBT2',
            'Jabra Elite 85h',
            'Beats Studio Pro',
            'Sony WH-CH720N',
            'Bose QuietComfort 45',
            'Sennheiser HD 450BT',
            'Anker Soundcore Space Q45',
            'JBL Tour One M2',
            'Technics EAH-A800',
            'Focal Bathys',
            'Shure AONIC 50',
            'Puro Sound Labs BT2200',
            'Skullcandy Crusher Evo',
            'Razer Barracuda Pro',
            'SteelSeries Arctis Nova Pro',
            'Sony WH-XB910N',
            'Bose 700',
            'Sennheiser HD 660S2',
            'Meze Audio 99 Classics',
            'Hifiman Ananda BT',
        ]);

        // Prix stockés en EUR (affichage converti en FCFA avec Product::FCFA_RATE).
        // Plafond boutique : 50 000 FCFA ≈ 76,92 EUR — aucun prix ne doit le dépasser.
        $price = fake()->randomFloat(2, 10, 76.92);
        // 40% de chance d'avoir un prix barré (promo) entre 1.1x et 1.3x le prix, plafonné à 76,92 EUR
        $compareAtPrice = fake()->boolean(40) ? min(round($price * fake()->randomFloat(2, 1.1, 1.3), 2), 76.92) : null;
        // Si le plafond écrase la promo (prix barré <= prix), on l'annule
        if ($compareAtPrice !== null && $compareAtPrice <= $price) {
            $compareAtPrice = null;
        }

        // Image correspondante au produit
        $imageUrl = $this->productImages[$name] ?? 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=800&h=600&fit=crop';

        return [
            'category_id' => null, // Sera défini dans le seeder
            'name' => $name,
            // Slug : nom en kebab-case + nombre aléatoire
            'slug' => Str::slug($name) . '-' . fake()->numberBetween(1000, 9999),
            'description' => fake()->paragraphs(3, true),    // 3 paragraphes
            'short_description' => fake()->sentence(),       // 1 phrase
            'price' => $price,
            'compare_at_price' => $compareAtPrice,
            // SKU unique : SKU-XXX00000
            'sku' => 'SKU-' . fake()->bothify('???#####'),
            'stock_quantity' => fake()->numberBetween(0, 100),
            'low_stock_threshold' => fake()->numberBetween(5, 15),
            // Images : tableau avec l'URL principale
            'images' => [$imageUrl],
            // Marque cohérente avec le nom du produit
            'brand' => fake()->randomElement(['Sony', 'Bose', 'Apple', 'Sennheiser', 'Bowers & Wilkins', 'Audio-Technica', 'Jabra', 'Beats', 'JBL', 'Technics', 'Focal', 'Shure', 'Anker', 'Skullcandy', 'Razer', 'SteelSeries']),
            'model' => fake()->bothify('??-####'), // Ex: WH-1000
            'color' => fake()->randomElement(['Noir', 'Blanc', 'Argent', 'Gris', 'Bleu', 'Rouge', 'Rose', 'Vert']),
            // Spécifications techniques aléatoires
            'specifications' => [
                'Type' => fake()->randomElement(['Circum-auriculaire', 'Supra-auriculaire', 'Intra-auriculaire']),
                'Connectivité' => fake()->randomElement(['Bluetooth 5.0', 'Bluetooth 5.2', 'Bluetooth 5.3', 'Filaire 3.5mm', 'USB-C']),
                'Réduction de bruit' => fake()->boolean() ? 'Active (ANC)' : 'Passive',
                'Autonomie' => fake()->numberBetween(20, 60) . 'h',
                'Poids' => fake()->numberBetween(200, 400) . 'g',
            ],
            // Fonctionnalités standard
            'features' => [
                'Réduction de bruit active',
                'Mode transparence',
                'Assistant vocal',
                'Multipoint Bluetooth',
                'Charge rapide',
            ],
            'is_active' => true,      // Produit visible
            'is_featured' => false,   // Pas en vedette par défaut
            'published_at' => fake()->dateTimeBetween('-6 months', 'now'), // Publié récemment
        ];
    }
}