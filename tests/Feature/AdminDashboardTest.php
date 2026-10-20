<?php

namespace Tests\Feature;

use App\Filament\AdminDashboard;
use App\Filament\Auth\Login;
use App\Filament\Widgets\OrdersTrendChart;
use App\Filament\Widgets\RevenueTrendChart;
use App\Models\Category;
use App\Models\Order;
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
        // Les liens de la navigation principale restent accessibles depuis la connexion.
        $response->assertSee('Accueil');
        $response->assertSee('Boutique');
        $response->assertSee('Catégories');
        $response->assertSee('FAQ');
        $response->assertSee('Contact');
        $response->assertSee('Se connecter');
        // Fond photo de la page de connexion
        $response->assertSee('storage/categories/cat-1.jpg', false);
        $response->assertSee('id="main-nav"', false)
            ->assertSee(route('home'))
            ->assertSee(route('shop.index'))
            ->assertSee(route('categories.index'))
            ->assertSee(route('support.faq'))
            ->assertSee(route('contact'));
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
        $response->assertSee('Chiffre d’affaires');
        $response->assertSee('Paiements reçus');
        $response->assertSee('Commandes totales');
    }

    public function test_dashboard_welcome_shows_three_ordered_summary_sections(): void
    {
        $this->createOrder('ORDER-PAID-1', 'paid', 12500);
        $this->createOrder('ORDER-PENDING-1', 'pending', 7500);
        $admin = User::where('email', 'admin@casque-shop.com')->firstOrFail();

        $response = $this->actingAs($admin)->get('/admin');

        $response->assertOk()
            ->assertSee('Bienvenue')
            ->assertSee('Administrateur')
            ->assertSee('Tableau de bord')
            ->assertDontSee('https://casque-shop-1.onrender.com/dashbord')
            ->assertSee('12 500 FCFA')
            ->assertSee('Commandes totales')
            ->assertSee('Paiements reçus sur les 30 derniers jours')
            ->assertSee('Commandes créées sur les 30 derniers jours')
            ->assertDontSee('dashboard-period', false);

        $html = $response->getContent();
        $welcomePosition = strpos($html, 'Bienvenue');
        $headingPosition = strpos($html, 'Tableau de bord');
        $revenuePosition = strpos($html, 'Chiffre d’affaires');
        $paymentsPosition = strpos($html, 'Paiements reçus');
        $ordersPosition = strpos($html, 'Commandes totales');
        $revenueChartPosition = strpos($html, 'Paiements reçus sur les 30 derniers jours');
        $ordersChartPosition = strpos($html, 'Commandes créées sur les 30 derniers jours');

        $this->assertNotFalse($welcomePosition);
        $this->assertNotFalse($headingPosition);
        $this->assertNotFalse($revenuePosition);
        $this->assertNotFalse($paymentsPosition);
        $this->assertNotFalse($ordersPosition);
        $this->assertNotFalse($revenueChartPosition);
        $this->assertNotFalse($ordersChartPosition);
        $this->assertLessThan($headingPosition, $welcomePosition);
        $this->assertLessThan($revenuePosition, $headingPosition);
        $this->assertLessThan($paymentsPosition, $revenuePosition);
        $this->assertLessThan($ordersPosition, $paymentsPosition);
        $this->assertLessThan($revenueChartPosition, $ordersPosition);
        $this->assertLessThan($ordersChartPosition, $revenueChartPosition);
    }

    public function test_dashboard_charts_render(): void
    {
        $this->assertSame(['default' => 2], (new AdminDashboard)->getColumns());
        $admin = User::where('email', 'admin@casque-shop.com')->firstOrFail();
        $dashboard = $this->actingAs($admin)->get('/admin');

        $dashboard->assertOk()
            ->assertSee('fi-grid-cols', false)
            ->assertSee('--cols-default: repeat(2, minmax(0, 1fr))', false)
            ->assertSee('--col-span-default: 1 / -1', false)
            ->assertSee('white-space: nowrap', false)
            ->assertSee('grid-template-columns: repeat(2, minmax(0, 1fr))', false)
            ->assertSee('grid-column: 1 / -1', false)
            ->assertSee('Commandes créées sur les 30 derniers jours')
            ->assertSee('Catégories')
            ->assertSee('Derniers articles');

        $this->createOrder('ORDER-PAID-1', 'paid', 12500);
        $this->createOrder('ORDER-PENDING-1', 'pending', 7500);

        Livewire::test(RevenueTrendChart::class)
            ->assertSee('Paiements reçus sur les 30 derniers jours')
            ->assertSee('12500', false)
            ->assertDontSee('7500', false);

        Livewire::test(OrdersTrendChart::class)
            ->assertSee('Commandes créées sur les 30 derniers jours');
    }

    private function createOrder(string $orderNumber, string $paymentStatus, int $total): Order
    {
        return Order::create([
            'order_number' => $orderNumber,
            'email' => 'client@example.com',
            'status' => 'pending',
            'payment_status' => $paymentStatus,
            'subtotal' => $total,
            'tax_amount' => 0,
            'shipping_amount' => 0,
            'discount_amount' => 0,
            'total' => $total,
            'currency' => 'XOF',
            'billing_first_name' => 'Client',
            'billing_last_name' => 'Test',
            'billing_address' => 'Adresse',
            'billing_city' => 'Cotonou',
            'billing_postal_code' => '0000',
            'billing_country' => 'BJ',
        ]);
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
