<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

// Seeder principal : lance tous les seeders de l'application
class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        // Compte admin démo pour /admin (Filament exige is_admin = true)
        User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin GMS',
                'password' => 'password',
                'is_admin' => true,
                'email_verified_at' => now(),
            ]
        );

        // Crée un utilisateur boutique de test (/connexion)
        User::firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'password' => 'password',
                'is_admin' => false,
                'email_verified_at' => now(),
            ]
        );

        // Compte admin perso via variables d'environnement Render (recréé à chaque deploy).
        // Définir ADMIN_EMAIL + ADMIN_PASSWORD dans Environment, jamais dans Git.
        if ($adminEmail = env('ADMIN_EMAIL')) {
            User::updateOrCreate(
                ['email' => $adminEmail],
                [
                    'name' => env('ADMIN_NAME', 'Admin'),
                    'password' => env('ADMIN_PASSWORD', 'password'),
                    'is_admin' => true,
                    'email_verified_at' => now(),
                ]
            );
        }

        // Lance le seeder des produits et catégories
        $this->call([
            ProductSeeder::class,
            EarbudsSeeder::class,
        ]);

        // Photo par défaut aux catégories sans image (cat-1..5, en boucle).
        // Ne touche jamais aux images envoyées depuis l'admin.
        $fallbacks = [
            'categories/cat-1.jpg',
            'categories/cat-2.jpg',
            'categories/cat-3.jpg',
            'categories/cat-4.jpg',
            'categories/cat-5.jpg',
        ];
        Category::whereNull('image')->orderBy('id')->get()->each(
            fn ($category, $i) => $category->update(['image' => $fallbacks[$i % count($fallbacks)]])
        );
    }
}