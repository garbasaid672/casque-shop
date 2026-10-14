<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\SupportController;
use Illuminate\Support\Facades\Route;

// Route principale - page d'accueil de la boutique
Route::get('/', [HomeController::class, 'index'])->name('home');

// Authentification - page de connexion
Route::get('/connexion', [AuthController::class, 'showLogin'])->name('login');
Route::post('/connexion', [AuthController::class, 'login']);

// Authentification - page d'inscription
Route::get('/inscription', [AuthController::class, 'showRegister'])->name('register');
Route::post('/inscription', [AuthController::class, 'register']);

Route::post('/deconnexion', [AuthController::class, 'logout'])->name('logout');

// Boutique : catalogue et fiche produit
Route::get('/boutique', [ShopController::class, 'index'])->name('shop.index');
Route::get('/produit/{product:slug}', [ShopController::class, 'show'])->name('product.show');

// Catégories : liste de toutes les catégories
Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');

// Commande : formulaire, enregistrement puis confirmation
Route::get('/commander/{product:slug}', [CheckoutController::class, 'show'])->name('checkout.show');
Route::post('/commander/{product:slug}', [CheckoutController::class, 'store'])->name('checkout.store');
// Paiement en ligne KkiaPay : page de paiement, vérification puis confirmation
Route::get('/commande/{orderNumber}/payer', [PaymentController::class, 'show'])->name('payment.show');
Route::post('/commande/{orderNumber}/verifier', [PaymentController::class, 'verify'])->name('payment.verify');
Route::get('/commande/{orderNumber}/merci', [CheckoutController::class, 'success'])->name('checkout.success');

// Webhook KkiaPay (notifications asynchrones de paiement)
Route::post('/kkiapay/webhook', [PaymentController::class, 'webhook'])->name('kkiapay.webhook');

// Contact : page + formulaire de message
Route::get('/contact', [ContactController::class, 'show'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

// Support : FAQ, livraison, retours, garantie
Route::get('/aide/faq', [SupportController::class, 'faq'])->name('support.faq');
Route::get('/aide/livraison', [SupportController::class, 'shipping'])->name('support.shipping');
Route::get('/aide/retours', [SupportController::class, 'returns'])->name('support.returns');
Route::get('/aide/garantie', [SupportController::class, 'warranty'])->name('support.warranty');

// Page d'une catégorie (via son slug) : affiche tous ses produits
Route::get('/categorie/{category:slug}', [CategoryController::class, 'show'])->name('category.show');

// TEMP DEBUG : état réel de la base WEB (à supprimer après diagnostic)
Route::get('/debug-login-status/{secret}', function (string $secret) {
    if ($secret !== env('DEBUG_SECRET', 'gms-debug-123')) {
        abort(404);
    }
    $demo = \App\Models\User::where('email', 'admin@example.com')->first();
    $perso = \App\Models\User::where('email', env('ADMIN_EMAIL', 'admin@casque-shop.com'))->first();
    return response()->json([
        'db' => config('database.default'),
        'users_count' => \App\Models\User::count(),
        'products_count' => \App\Models\Product::count(),
        'demo' => $demo ? ['exists' => true, 'is_admin' => (bool) $demo->is_admin, 'pwd_password_ok' => \Illuminate\Support\Facades\Hash::check('password', $demo->password)] : ['exists' => false],
        'perso_email' => env('ADMIN_EMAIL', 'admin@casque-shop.com'),
        'perso' => $perso ? ['exists' => true, 'is_admin' => (bool) $perso->is_admin] : ['exists' => false],
        'app_url' => config('app.url'),
    ]);
});