<?php

namespace Tests\Feature;

use App\Filament\Auth\Login;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

// Vérifie l'admin : sidebar, dashboard avec photos, page login
class AdminDashboardTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Compte admin + données de démo (photos incluses)
        $admin = User::create([
            'name' => 'Administrateur',
            'email' => 'admin@casque-shop.com',
            'password' => 'Admin123456',
        ]);
        // is_admin n'est pas "fillable" (sécurité) : assignation directe
        $admin->is_admin = true;
        $admin->save();

        $category = Category::create([
            'name' => 'Casques sans fil',
            'slug' => 'casques-sans-fil',
            'image' => 'categories/cat-2.jpg',
            'is_active' => true,
        ]);

        Product::create([
            'category_id' => $category->id,
            'name' => 'Produit test',
            'slug' => 'produit-test',
            'price' => 50,
            'sku' => 'TEST-001',
            'stock_quantity' => 10,
            'images' => ['products/casque-1.jpg'],
            'is_active' => true,
            'is_featured' => true,
        ]);
    }

    public function test_login_page_shows_branding(): void
    {
        $response = $this->get('/admin/login');

        $response->assertOk();
        $response->assertSee('GMS Audio');
        // Même habillage que la page client (/connexion)
        $response->assertSee('Bienvenue');
        $response->assertSee("Retour à l'accueil", false);
        $response->assertSee('Se connecter');
        // Fond photo + encadré d'essai
        $response->assertSee('storage/categories/cat-1.jpg', false);
        $response->assertSee("Compte d'essai", false);
    }

    public function test_admin_can_login_from_custom_page(): void
    {
        Livewire::test(Login::class)
            ->set('data.email', 'admin@casque-shop.com')
            ->set('data.password', 'Admin123456')
            ->call('authenticate')
            ->assertHasNoErrors();

        $this->assertAuthenticated();
    }

    public function test_dashboard_sidebar_menus(): void
    {
        $admin = User::where('email', 'admin@casque-shop.com')->firstOrFail();

        $response = $this->actingAs($admin)->get('/admin');

        $response->assertOk();
        $response->assertSee('Articles');
        $response->assertSee('Catégories');
        $response->assertSee('Commandes');
        $response->assertSee('Clients');
        $response->assertSee('Messages');
        $response->assertSee('Wallet');
        $response->assertSee('Compte');
    }

    public function test_dashboard_shows_photos(): void
    {
        $admin = User::where('email', 'admin@casque-shop.com')->firstOrFail();

        $response = $this->actingAs($admin)->get('/admin');

        $response->assertOk();
        // Vraies balises <img> (pas seulement des URLs dans du JS) pour produits et catégories
        $html = $response->getContent();
        $this->assertMatchesRegularExpression('/<img[^>]+storage\/products\//', $html);
        $this->assertMatchesRegularExpression('/<img[^>]+storage\/categories\//', $html);
    }

    public function test_products_page_loads(): void
    {
        $admin = User::where('email', 'admin@casque-shop.com')->firstOrFail();

        $response = $this->actingAs($admin)->get('/admin/products');

        $response->assertOk();
        // Photos rendues en vraies balises <img> dans la liste des articles
        $this->assertMatchesRegularExpression('/<img[^>]+storage\/products\//', $response->getContent());
    }

    public function test_admin_account_cannot_be_deleted(): void
    {
        $admin = User::where('email', 'admin@casque-shop.com')->firstOrFail();

        $admin->delete();

        // Le compte admin existe toujours
        $this->assertDatabaseHas('users', ['email' => 'admin@casque-shop.com']);
    }

    public function test_sidebar_has_blue_violet_theme(): void
    {
        $admin = User::where('email', 'admin@casque-shop.com')->firstOrFail();

        $response = $this->actingAs($admin)->get('/admin');

        $response->assertOk();
        // Dégradé bleu nuit du sidebar injecté dans le HTML
        $response->assertSee('linear-gradient(180deg, #020617', false);
    }
}
