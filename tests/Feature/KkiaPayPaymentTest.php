<?php

namespace Tests\Feature;

use App\Mail\PaymentConfirmed;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

// Paiement KkiaPay : création, page de paiement, vérification, webhook.
class KkiaPayPaymentTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Clés de test (le service appelle l'API : réponses simulées via Http::fake)
        config([
            'kkiapay.public_key' => 'pk_test',
            'kkiapay.private_key' => 'sk_test',
            'kkiapay.secret' => 'secret_test',
            'kkiapay.sandbox' => true,
        ]);
    }

    private function makeProduct(): Product
    {
        $category = Category::create([
            'name' => 'Casques sans fil',
            'slug' => 'casques-sans-fil',
            'image' => 'categories/cat-2.jpg',
            'is_active' => true,
        ]);

        return Product::create([
            'category_id' => $category->id,
            'name' => 'Casque test',
            'slug' => 'casque-test',
            'price' => 20, // 13 000 FCFA
            'sku' => 'TEST-KKIA',
            'stock_quantity' => 10,
            'images' => ['products/casque-1.jpg'],
            'is_active' => true,
        ]);
    }

    private function orderData(): array
    {
        return [
            'quantity' => 1,
            'first_name' => 'Jean',
            'last_name' => 'Dupont',
            'email' => 'jean@test.com',
            'phone' => '+22890000000',
            'address' => 'Rue 1',
            'quartier' => 'Hédzranawoé',
            'city' => 'Lomé',
            'payment_method' => 'kkiapay',
        ];
    }

    public function test_checkout_with_kkiapay_redirects_to_payment_page(): void
    {
        $product = $this->makeProduct();

        $response = $this->post(route('checkout.store', $product), $this->orderData());

        $order = Order::firstOrFail();
        $response->assertRedirect(route('payment.show', $order->order_number));
        $this->assertSame('pending', $order->payment_status);
    }

    public function test_payment_page_shows_widget_with_amount(): void
    {
        $product = $this->makeProduct();
        $this->post(route('checkout.store', $product), $this->orderData());
        $order = Order::firstOrFail();

        $response = $this->get(route('payment.show', $order->order_number));

        $response->assertOk();
        $response->assertSee('openKkiapayWidget', false);
        $response->assertSee((string) (int) $order->total, false);
    }

    public function test_verify_success_marks_order_paid(): void
    {
        Mail::fake();
        $product = $this->makeProduct();
        $this->post(route('checkout.store', $product), $this->orderData());
        $order = Order::firstOrFail();

        Http::fake([
            '*transactions/status*' => Http::response([
                'status' => 'SUCCESS',
                'amount' => (int) $order->total,
                'transactionId' => 'TX123456',
            ], 200),
        ]);

        $response = $this->postJson(route('payment.verify', $order->order_number), [
            'transactionId' => 'TX123456',
        ]);

        $response->assertOk();
        $response->assertJsonPath('ok', true);
        $this->assertSame('paid', $order->fresh()->payment_status);
        $this->assertSame('TX123456', $order->fresh()->payment_reference);

        // L'email "Paiement effectué..." part au client, une seule fois
        Mail::assertSent(PaymentConfirmed::class, function ($mail) use ($order) {
            return $mail->order->is($order)
                && $mail->hasTo($order->email);
        });
    }

    public function test_verify_success_with_nested_transaction_data_marks_order_paid(): void
    {
        Mail::fake();
        $product = $this->makeProduct();
        $this->post(route('checkout.store', $product), $this->orderData());
        $order = Order::firstOrFail();

        Http::fake([
            '*transactions/status*' => Http::response([
                'data' => [
                    'transaction' => [
                        'status' => 'SUCCESS',
                        'amount' => (int) $order->total,
                        'transaction_id' => 'TX-NESTED',
                    ],
                ],
            ], 200),
        ]);

        $response = $this->postJson(route('payment.verify', $order->order_number), [
            'transactionId' => 'TX-NESTED',
        ]);

        $response->assertOk();
        $response->assertJsonPath('ok', true);
        $this->assertSame('paid', $order->fresh()->payment_status);
        $this->assertSame('TX-NESTED', $order->fresh()->payment_reference);
    }

    public function test_verify_rejects_a_different_transaction_id(): void
    {
        Mail::fake();
        $product = $this->makeProduct();
        $this->post(route('checkout.store', $product), $this->orderData());
        $order = Order::firstOrFail();

        Http::fake([
            '*transactions/status*' => Http::response([
                'status' => 'SUCCESS',
                'amount' => (int) $order->total,
                'transactionId' => 'TX-OTHER',
            ], 200),
        ]);

        $response = $this->postJson(route('payment.verify', $order->order_number), [
            'transactionId' => 'TX-SUBMITTED',
        ]);

        $response->assertStatus(422);
        $response->assertJsonPath('ok', false);
        $this->assertSame('pending', $order->fresh()->payment_status);
        Mail::assertNotSent(PaymentConfirmed::class);
    }

    public function test_verify_with_wrong_amount_keeps_order_pending(): void
    {
        Mail::fake();
        $product = $this->makeProduct();
        $this->post(route('checkout.store', $product), $this->orderData());
        $order = Order::firstOrFail();

        Http::fake([
            '*transactions/status*' => Http::response([
                'status' => 'SUCCESS',
                'amount' => 100, // montant frauduleux, inférieur au total
                'transactionId' => 'TX999',
            ], 200),
        ]);

        $response = $this->postJson(route('payment.verify', $order->order_number), [
            'transactionId' => 'TX999',
        ]);

        $response->assertStatus(422);
        $this->assertSame('pending', $order->fresh()->payment_status);
        Mail::assertNotSent(PaymentConfirmed::class);
    }

    public function test_webhook_confirms_payment(): void
    {
        $product = $this->makeProduct();
        $this->post(route('checkout.store', $product), $this->orderData());
        $order = Order::firstOrFail();

        Http::fake([
            '*transactions/status*' => Http::response([
                'status' => 'SUCCESS',
                'amount' => (int) $order->total,
                'transactionId' => 'TX777',
            ], 200),
        ]);

        // Le webhook n'a pas de session/CSRF : appel direct
        $response = $this->postJson('/kkiapay/webhook', [
            'transactionId' => 'TX777',
            'data' => $order->order_number,
        ]);

        $response->assertOk();
        $this->assertSame('paid', $order->fresh()->payment_status);
    }

    public function test_webhook_requests_retry_while_payment_is_pending(): void
    {
        $product = $this->makeProduct();
        $this->post(route('checkout.store', $product), $this->orderData());
        $order = Order::firstOrFail();

        Http::fake([
            '*transactions/status*' => Http::response([
                'status' => 'PENDING',
                'amount' => (int) $order->total,
                'transactionId' => 'TX-PENDING',
            ], 200),
        ]);

        $response = $this->postJson('/kkiapay/webhook', [
            'transactionId' => 'TX-PENDING',
            'data' => $order->order_number,
        ]);

        $response->assertStatus(503);
        $this->assertSame('pending', $order->fresh()->payment_status);
    }

    public function test_verify_unknown_transaction_is_rejected_not_error(): void
    {
        Mail::fake();
        $product = $this->makeProduct();
        $this->post(route('checkout.store', $product), $this->orderData());
        $order = Order::firstOrFail();

        // KkiaPay répond 400 + TRANSACTION_NOT_FOUND : pas une erreur technique
        Http::fake([
            '*transactions/status*' => Http::response(['status' => 'TRANSACTION_NOT_FOUND'], 400),
        ]);

        $response = $this->postJson(route('payment.verify', $order->order_number), [
            'transactionId' => 'TX-INCONNU',
        ]);

        $response->assertStatus(422);
        $response->assertJsonPath('ok', false);
        $this->assertSame('pending', $order->fresh()->payment_status);
        Mail::assertNotSent(PaymentConfirmed::class);
    }
}
