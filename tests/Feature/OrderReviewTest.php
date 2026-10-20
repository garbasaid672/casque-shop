<?php

namespace Tests\Feature;

use App\Filament\Resources\OrderReviews\Pages\EditOrderReview;
use App\Filament\Resources\Orders\Pages\EditOrder;
use App\Mail\OrderDeliveredReviewInvitation;
use App\Models\Order;
use App\Models\OrderReview;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Livewire\Livewire;
use Tests\TestCase;

class OrderReviewTest extends TestCase
{
    use RefreshDatabase;

    public function test_customer_can_submit_one_review_for_a_delivered_order(): void
    {
        $order = $this->createOrder('CMD-DELIVERED-1', 'delivered');

        $this->get(route('reviews.create', $order->order_number))
            ->assertOk()
            ->assertSee('E-mail utilisé pour la commande')
            ->assertSee('Votre commentaire');

        $this->from(route('reviews.create', $order->order_number))
            ->post(route('reviews.store', $order->order_number), [
                'email' => ' CLIENT@example.com ',
                'rating' => 5,
                'comment' => 'Très bon casque et livraison rapide.',
            ])
            ->assertRedirect(route('reviews.create', $order->order_number))
            ->assertSessionHas('status');

        $review = OrderReview::query()->firstOrFail();
        $this->assertSame($order->id, $review->order_id);
        $this->assertSame('Awa K.', $review->author_name);
        $this->assertFalse($review->is_approved);

        $this->from(route('reviews.create', $order->order_number))
            ->post(route('reviews.store', $order->order_number), [
                'email' => $order->email,
                'rating' => 4,
                'comment' => 'Une deuxième tentative.',
            ])
            ->assertSessionHasErrors('email');

        $this->assertDatabaseCount('order_reviews', 1);
    }

    public function test_customer_can_submit_review_for_a_paid_order_before_delivery(): void
    {
        $order = $this->createOrder('CMD-PAID-REVIEW-1', 'confirmed');

        $this->from(route('reviews.create', $order->order_number))
            ->post(route('reviews.store', $order->order_number), [
                'email' => $order->email,
                'rating' => 5,
                'comment' => 'Le paiement est confirmé, merci.',
            ])
            ->assertRedirect(route('reviews.create', $order->order_number))
            ->assertSessionHas('status');

        $this->assertDatabaseHas('order_reviews', [
            'order_id' => $order->id,
            'comment' => 'Le paiement est confirmé, merci.',
        ]);
    }

    public function test_order_confirmation_keeps_a_link_to_share_feedback_after_delivery(): void
    {
        $order = $this->createOrder('CMD-REVIEW-LINK-1', 'processing');

        $this->get(route('checkout.success', $order->order_number))
            ->assertOk()
            ->assertSee('Partager mon expérience')
            ->assertSee(route('reviews.create', $order->order_number));
    }

    public function test_review_requires_a_delivered_order_and_matching_email(): void
    {
        $pendingOrder = $this->createOrder('CMD-PENDING-1', 'processing');
        $pendingOrder->update(['payment_status' => 'pending']);

        $this->from(route('reviews.create', $pendingOrder->order_number))
            ->post(route('reviews.store', $pendingOrder->order_number), [
                'email' => $pendingOrder->email,
                'rating' => 5,
                'comment' => 'Une commande pas encore livrée.',
            ])
            ->assertSessionHasErrors([
                'email' => 'Cette commande n’est pas encore payée ni livrée. Vérifiez son statut avant de laisser un avis.',
            ]);

        $deliveredOrder = $this->createOrder('CMD-DELIVERED-2', 'delivered');

        $this->from(route('reviews.create', $deliveredOrder->order_number))
            ->post(route('reviews.store', $deliveredOrder->order_number), [
                'email' => 'intrus@example.com',
                'rating' => 5,
                'comment' => 'Cet avis ne correspond pas.',
            ])
            ->assertSessionHasErrors([
                'email' => 'L’adresse e-mail saisie ne correspond pas à celle enregistrée pour cette commande. Vérifiez l’e-mail utilisé lors de l’achat.',
            ]);

        $this->assertDatabaseCount('order_reviews', 0);
    }

    public function test_homepage_only_displays_approved_order_reviews(): void
    {
        $approvedOrder = $this->createOrder('CMD-APPROVED-1', 'delivered');
        $pendingOrder = $this->createOrder('CMD-REVIEW-PENDING-1', 'delivered');

        $approvedOrder->review()->create([
            'author_name' => 'Awa K.',
            'city' => 'Lomé',
            'rating' => 5,
            'comment' => 'Très satisfait de ma commande.',
            'is_approved' => true,
        ]);

        $pendingOrder->review()->create([
            'author_name' => 'Kossi A.',
            'city' => 'Cotonou',
            'rating' => 4,
            'comment' => 'Cet avis attend la validation.',
            'is_approved' => false,
        ]);

        $this->get(route('home'))
            ->assertOk()
            ->assertSee('https://casque-shop-1.onrender.com/dashbord')
            ->assertDontSee('href="https://casque-shop-1.onrender.com/dashbord"', false)
            ->assertSee('dashboard-browser-address', false)
            ->assertSee('dashboard-browser-dots', false)
            ->assertSee('Très satisfait de ma commande.')
            ->assertDontSee('Cet avis attend la validation.')
            ->assertSee('Du téléphone à la livraison')
            ->assertSee('Le livreur prend la route')
            ->assertSee('Wallet')
            ->assertSee('Produits')
            ->assertSee('images/purchase-story/shopping-phone.jpg')
            ->assertSee('images/purchase-story/package-handover.jpg')
            ->assertSee('data-theme-toggle', false)
            ->assertSee('IntersectionObserver', false);
    }

    public function test_admin_can_review_and_moderate_submissions(): void
    {
        $admin = User::create([
            'name' => 'Administrateur',
            'email' => 'admin-reviews@example.com',
            'password' => 'Admin123456',
        ]);
        $admin->is_admin = true;
        $admin->save();

        $order = $this->createOrder('CMD-ADMIN-REVIEW-1', 'delivered');
        $review = $order->review()->create([
            'author_name' => 'Awa K.',
            'city' => 'Lomé',
            'rating' => 5,
            'comment' => 'Commande reçue dans les délais.',
        ]);

        $this->actingAs($admin)
            ->get('/admin/order-reviews')
            ->assertOk()
            ->assertSee('Avis clients')
            ->assertSee('À vérifier');

        $this->actingAs($admin)
            ->get('/admin/order-reviews/'.$review->id.'/edit')
            ->assertOk()
            ->assertSee('Approuver et publier cet avis');

        Livewire::actingAs($admin)
            ->test(EditOrderReview::class, ['record' => $review->getKey()])
            ->fillForm(['is_approved' => true])
            ->call('save')
            ->assertHasNoErrors();

        $this->assertTrue($review->fresh()->is_approved);
    }

    public function test_customer_receives_review_invitation_when_order_is_marked_delivered(): void
    {
        Mail::fake();

        $admin = User::create([
            'name' => 'Administrateur',
            'email' => 'admin-delivery@example.com',
            'password' => 'Admin123456',
        ]);
        $admin->is_admin = true;
        $admin->save();

        $order = $this->createOrder('CMD-DELIVERED-EMAIL-1', 'processing');

        $editPage = Livewire::actingAs($admin)
            ->test(EditOrder::class, ['record' => $order->getKey()])
            ->fillForm(['status' => 'delivered'])
            ->call('save', false, false)
            ->assertHasNoErrors();

        $editPage->call('save', false, false);

        Mail::assertSent(OrderDeliveredReviewInvitation::class, function ($mail) use ($order): bool {
            return $mail->order->is($order)
                && $mail->hasTo($order->email)
                && str_contains($mail->render(), route('reviews.create', $order->order_number));
        });
        Mail::assertSent(OrderDeliveredReviewInvitation::class, 1);
    }

    private function createOrder(string $orderNumber, string $status): Order
    {
        return Order::create([
            'order_number' => $orderNumber,
            'email' => 'client@example.com',
            'status' => $status,
            'payment_status' => 'paid',
            'subtotal' => 10000,
            'tax_amount' => 0,
            'shipping_amount' => 1500,
            'discount_amount' => 0,
            'total' => 11500,
            'currency' => 'XOF',
            'billing_first_name' => 'Awa',
            'billing_last_name' => 'Kossi',
            'billing_address' => 'Adresse',
            'billing_city' => 'Lomé',
            'billing_postal_code' => '0000',
            'billing_country' => 'TG',
        ]);
    }
}
