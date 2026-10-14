<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

// Seeder : ajoute des écouteurs de qualité (AirPods, Oraimo, JBL...)
// dans les bonnes catégories. Prix stockés en EUR (affichage × 650 en FCFA,
// plafond boutique : 50 000 FCFA ≈ 76,92 EUR — aucun prix ne le dépasse).
class EarbudsSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        // [nom, slug, marque, modèle, couleur, prix EUR, prix barré EUR, stock, vedette, catégorie, image, description, fonctionnalités]
        $items = [
            // ----- Casques sans fil -----
            ['Apple AirPods 3', 'apple-airpods-3', 'Apple', 'AirPods 3', 'Blanc', 43.85, null, 40, false, 'Casques sans fil', 'earbuds-2.jpg',
                'Écouteurs sans fil Apple avec audio spatial personnalisé, résistance à l’eau et 30 heures d’autonomie totale avec le boîtier MagSafe.',
                ['Audio spatial personnalisé', 'Bluetooth 5.3', 'Résistance à l’eau IPX4', '30h d’autonomie totale', 'Charge MagSafe']],
            ['Oraimo FreePods Lite', 'oraimo-freepods-lite', 'Oraimo', 'FreePods Lite', 'Noir', 6.92, 8.31, 60, false, 'Casques sans fil', 'earbuds-1.jpg',
                'Écouteurs sans fil Oraimo au rapport qualité-prix imbattable : 36 heures d’autonomie, commandes tactiles et faible latence pour les jeux.',
                ['Bluetooth 5.3', '36h d’autonomie totale', 'Commandes tactiles', 'Mode faible latence']],
            ['Oraimo FreePods Neo', 'oraimo-freepods-neo', 'Oraimo', 'FreePods Neo', 'Noir', 9.23, null, 50, false, 'Casques sans fil', 'earbuds-5.jpg',
                'Écouteurs Oraimo FreePods Neo avec réduction de bruit ENC pour des appels clairs et 40 heures d’autonomie totale.',
                ['Réduction de bruit ENC', 'Bluetooth 5.3', '40h d’autonomie totale', 'Charge rapide USB-C']],
            ['JBL Tune Buds', 'jbl-tune-buds', 'JBL', 'Tune Buds', 'Noir', 25.39, 27.69, 30, false, 'Casques sans fil', 'earbuds-4.jpg',
                'Écouteurs JBL Tune Buds avec le légendaire son JBL Pure Bass, connexion multipoint et 48 heures d’autonomie.',
                ['Son JBL Pure Bass', 'Bluetooth 5.3 multipoint', '48h d’autonomie totale', '4 micros pour des appels clairs']],
            ['Samsung Galaxy Buds FE', 'samsung-galaxy-buds-fe', 'Samsung', 'Galaxy Buds FE', 'Blanc', 20.77, null, 35, false, 'Casques sans fil', 'casque-5.jpg',
                'Écouteurs Samsung Galaxy Buds FE avec réduction de bruit active et 30 heures d’autonomie, parfaits au quotidien.',
                ['Réduction de bruit active', 'Bluetooth 5.3', '30h d’autonomie totale', 'Confort ergonomique']],

            // ----- Casques à réduction de bruit -----
            ['Apple AirPods Pro 2', 'apple-airpods-pro-2', 'Apple', 'AirPods Pro 2', 'Blanc', 62.31, 69.23, 25, true, 'Casques à réduction de bruit', 'earbuds-3.jpg',
                'Apple AirPods Pro 2 avec réduction de bruit deux fois plus puissante, mode transparence adaptatif et boîtier USB-C avec haut-parleur.',
                ['Réduction de bruit active x2', 'Mode transparence adaptatif', 'Audio spatial personnalisé', 'Boîtier USB-C', '30h d’autonomie totale']],
            ['Oraimo FreePods Pro', 'oraimo-freepods-pro', 'Oraimo', 'FreePods Pro', 'Noir', 12.92, 14.77, 45, true, 'Casques à réduction de bruit', 'ofp-pro.jpg',
                'Écouteurs Oraimo FreePods Pro avec réduction de bruit hybride, 36 heures d’autonomie et charge rapide : le meilleur choix anti-bruit à petit prix.',
                ['Réduction de bruit hybride', '36h d’autonomie totale', 'Charge rapide USB-C', 'Mode transparence']],
            ['Sony WF-1000XM5', 'sony-wf-1000xm5', 'Sony', 'WF-1000XM5', 'Noir', 55.39, null, 20, false, 'Casques à réduction de bruit', 'earbuds-1.jpg',
                'Écouteurs Sony WF-1000XM5, la référence de la réduction de bruit avec audio Hi-Res et 24 heures d’autonomie.',
                ['Meilleure réduction de bruit Sony', 'Audio Hi-Res sans fil', '24h d’autonomie totale', 'Multipoint Bluetooth']],

            // ----- Casques sport -----
            ['Oraimo Necklace 2', 'oraimo-necklace-2', 'Oraimo', 'Necklace 2', 'Noir', 5.54, null, 70, false, 'Casques sport', 'earbuds-5.jpg',
                'Tour de cou Oraimo Necklace 2 idéal pour le sport : 20 heures d’autonomie, embouts magnétiques et résistance à la transpiration.',
                ['Format tour de cou sport', '20h d’autonomie', 'Embouts magnétiques', 'Résistant à la transpiration']],
            ['Oraimo OpenPods Neo', 'oraimo-openpods-neo', 'Oraimo', 'OpenPods Neo', 'Noir', 10.16, null, 40, false, 'Casques sport', 'earbuds-1.jpg',
                'Écouteurs à oreille ouverte Oraimo OpenPods Neo : restez attentif à votre environnement pendant le sport, avec un son puissant.',
                ['Conception oreille ouverte', 'Idéal running et vélo', 'Bluetooth 5.3', 'Commandes tactiles']],
            ['JBL Endurance Race', 'jbl-endurance-race', 'JBL', 'Endurance Race', 'Noir', 18.46, 20.77, 30, false, 'Casques sport', 'earbuds-4.jpg',
                'Écouteurs sport JBL Endurance Race étanches IP68 avec 30 heures d’autonomie et maintien parfait pendant l’effort.',
                ['Étanches IP68', '30h d’autonomie totale', 'Maintien sport sécurisé', 'Son JBL Pure Bass']],

            // ----- Casques filaires -----
            ['Apple EarPods Lightning', 'apple-earpods-lightning', 'Apple', 'EarPods Lightning', 'Blanc', 5.54, null, 80, false, 'Casques filaires', 'earpods-wired.jpg',
                'Écouteurs Apple EarPods avec connecteur Lightning, micro intégré et télécommande : le son Apple sans latence pour iPhone.',
                ['Connecteur Lightning', 'Micro et télécommande intégrés', 'Zéro latence', 'Son équilibré Apple']],
            ['Apple EarPods USB-C', 'apple-earpods-usb-c', 'Apple', 'EarPods USB-C', 'Blanc', 5.54, null, 80, false, 'Casques filaires', 'earpods-wired.jpg',
                'Écouteurs Apple EarPods avec connecteur USB-C pour iPhone 15 et plus, avec micro et télécommande intégrés.',
                ['Connecteur USB-C', 'Micro et télécommande intégrés', 'Zéro latence', 'Compatibles iPhone 15 et +']],
            ['Oraimo Classic OEP-E21', 'oraimo-classic-oep-e21', 'Oraimo', 'OEP-E21', 'Noir', 2.31, null, 100, false, 'Casques filaires', 'earbuds-1.jpg',
                'Écouteurs filaires Oraimo Classic avec prise jack 3,5 mm et micro : simples, solides et imbattables à ce prix.',
                ['Prise jack 3,5 mm', 'Micro intégré', 'Câble résistant', 'Compatibles tous appareils']],

            // ----- Casques gaming -----
            ['JBL Quantum 50', 'jbl-quantum-50', 'JBL', 'Quantum 50', 'Noir', 11.54, null, 40, false, 'Casques gaming', 'earbuds-5.jpg',
                'Écouteurs gaming JBL Quantum 50 avec son QuantumSound immersif et micro détachable, compatibles mobile, PC et consoles.',
                ['Son JBL QuantumSound', 'Micro avec télécommande', 'Jack 3,5 mm universel', 'Embouts multi-tailles']],
            ['HyperX Cloud Earbuds II', 'hyperx-cloud-earbuds-2', 'HyperX', 'Cloud Earbuds II', 'Rouge', 16.16, 18.46, 30, false, 'Casques gaming', 'earbuds-1.jpg',
                'Écouteurs gaming HyperX Cloud Earbuds II avec drivers 14 mm, 4 paires d’embouts et micro avec commandes.',
                ['Drivers dynamiques 14 mm', '4 tailles d’embouts', 'Micro avec commandes', 'Étui de transport inclus']],

            // ----- Nouveauté Apple -----
            ['Apple AirPods Pro 3', 'apple-airpods-pro-3', 'Apple', 'AirPods Pro 3', 'Blanc', 74.70, null, 20, true, 'Casques à réduction de bruit', 'airpods-pro-3.jpg',
                'Les tout derniers Apple AirPods Pro 3 : réduction de bruit encore plus puissante, traduction en direct, capteur cardiaque et 30 heures d’autonomie avec le boîtier USB-C.',
                ['Réduction de bruit renforcée', 'Traduction en direct', 'Capteur cardiaque', 'Audio spatial personnalisé', '30h d’autonomie totale']],
        ];

        foreach ($items as $i => $item) {
            [$name, $slug, $brand, $model, $color, $price, $compare, $stock, $featured, $categoryName, $image, $description, $features] = $item;

            // Crée la catégorie si le ProductSeeder aléatoire ne l'a pas créée (évite firstOrFail)
            $category = Category::firstOrCreate(
                ['name' => $categoryName],
                [
                    'slug' => \Illuminate\Support\Str::slug($categoryName) . '-' . fake()->unique()->numberBetween(1000, 9999),
                    'description' => 'Catégorie ' . $categoryName,
                    'is_active' => true,
                    'sort_order' => 10 + $i,
                ]
            );

            // firstOrCreate : relancer le seeder ne duplique pas les produits existants
            Product::firstOrCreate(
                ['slug' => $slug],
                [
                'category_id' => $category->id,
                'name' => $name,
                'slug' => $slug,
                'description' => $description,
                'short_description' => mb_substr($description, 0, 120),
                'price' => $price,
                'compare_at_price' => $compare,
                'sku' => 'EB-' . strtoupper(substr(md5($slug), 0, 8)),
                'stock_quantity' => $stock,
                'low_stock_threshold' => 5,
                'images' => ['products/' . $image],
                'brand' => $brand,
                'model' => $model,
                'color' => $color,
                'specifications' => ['Garantie' => '12 mois'],
                'features' => $features,
                'is_active' => true,
                'is_featured' => $featured,
                'published_at' => $now,
                ]
            );
        }
    }
}
