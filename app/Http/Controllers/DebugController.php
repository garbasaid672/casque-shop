<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

// TEMP DEBUG : état réel de la base WEB (à supprimer après diagnostic)
class DebugController extends Controller
{
    public function status(string $secret): JsonResponse
    {
        if ($secret !== env('DEBUG_SECRET', 'gms-debug-123')) {
            abort(404);
        }
        $demo = User::where('email', 'admin@example.com')->first();
        $persoEmail = (string) env('ADMIN_EMAIL', 'admin@casque-shop.com');
        $perso = User::where('email', $persoEmail)->first();

        return response()->json([
            'db' => config('database.default'),
            'users_count' => User::count(),
            'categories_count' => \App\Models\Category::count(),
            'products_count' => Product::count(),
            'demo' => $demo
                ? ['exists' => true, 'is_admin' => (bool) $demo->is_admin, 'pwd_password_ok' => Hash::check('password', $demo->password)]
                : ['exists' => false],
            'perso_email' => $persoEmail,
            'perso' => $perso
                ? ['exists' => true, 'is_admin' => (bool) $perso->is_admin]
                : ['exists' => false],
            'app_url' => config('app.url'),
        ]);
    }

    // TEMP DEBUG : lance ProductSeeder en capturant l'exception (diagnostic seed)
    public function seedTest(string $secret): JsonResponse
    {
        if ($secret !== env('DEBUG_SECRET', 'gms-debug-123')) {
            abort(404);
        }
        try {
            (new \Database\Seeders\ProductSeeder())->run();
            (new \Database\Seeders\EarbudsSeeder())->run();
        } catch (\Throwable $e) {
            return response()->json([
                'seed_error' => true,
                'message' => $e->getMessage(),
                'class' => get_class($e),
                'file' => $e->getFile() . ':' . $e->getLine(),
                'categories_count' => \App\Models\Category::count(),
                'products_count' => \App\Models\Product::count(),
            ]);
        }

        return response()->json([
            'seed_error' => false,
            'categories_count' => \App\Models\Category::count(),
            'products_count' => \App\Models\Product::count(),
        ]);
    }
}
