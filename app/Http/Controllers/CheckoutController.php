<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Services\KkiaPayService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

// Commande d'un produit : formulaire, enregistrement puis confirmation
class CheckoutController extends Controller
{
    // Frais de livraison forfaitaires (en FCFA)
    public const SHIPPING_FCFA = 1500;

    // Affiche le récapitulatif et le formulaire de commande
    public function show(Request $request, Product $product)
    {
        if (! $product->is_active) {
            abort(404);
        }

        // Les administrateurs n'achètent pas : pas de commande possible
        if (Auth::check() && Auth::user()->is_admin) {
            return redirect()->route('product.show', $product)
                ->withErrors(['admin' => 'Compte administrateur : les achats sont désactivés.']);
        }

        // Quantité demandée, limitée au stock disponible
        $quantity = max(1, (int) $request->query('quantity', 1));
        if ($product->stock_quantity < 1) {
            return redirect()->route('product.show', $product)
                ->withErrors(['stock' => 'Ce produit est en rupture de stock.']);
        }
        $quantity = min($quantity, $product->stock_quantity);

        $user = Auth::user();

        // Le paiement en ligne n'est proposé que si KkiaPay est configuré
        $kkiapayConfigured = app(KkiaPayService::class)->isConfigured();

        return view('shop.checkout', compact('product', 'quantity', 'user', 'kkiapayConfigured'));
    }

    // Enregistre la commande et décrémente le stock
    public function store(Request $request, Product $product)
    {
        if (! $product->is_active) {
            abort(404);
        }

        // Les administrateurs n'achètent pas : pas de commande possible
        if (Auth::check() && Auth::user()->is_admin) {
            return redirect()->route('product.show', $product)
                ->withErrors(['admin' => 'Compte administrateur : les achats sont désactivés.']);
        }

        $validated = $request->validate([
            'quantity' => ['required', 'integer', 'min:1'],
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:30'],
            'address' => ['required', 'string', 'max:255'],
            'quartier' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
            'payment_method' => ['required', 'in:kkiapay,cash_on_delivery,mobile_money'],
        ], [
            'first_name.required' => 'Veuillez saisir votre prénom.',
            'last_name.required' => 'Veuillez saisir votre nom.',
            'email.required' => 'Veuillez saisir votre adresse email.',
            'email.email' => 'Veuillez saisir une adresse email valide.',
            'phone.required' => 'Veuillez saisir votre numéro de téléphone.',
            'address.required' => 'Veuillez saisir votre adresse.',
            'quartier.required' => 'Veuillez saisir votre quartier.',
            'city.required' => 'Veuillez saisir votre ville.',
            'payment_method.required' => 'Veuillez choisir un moyen de paiement.',
            'payment_method.in' => 'Moyen de paiement invalide.',
        ]);

        // Vérifie le stock avant de commander
        $quantity = min((int) $validated['quantity'], $product->stock_quantity);
        if ($quantity < 1) {
            return back()->withErrors(['stock' => 'Ce produit est en rupture de stock.'])->withInput();
        }

        // Montants en FCFA (entiers, sans centimes)
        $unitPrice = (int) round($product->price * Product::FCFA_RATE);
        $subtotal = $unitPrice * $quantity;
        $shipping = self::SHIPPING_FCFA;
        $total = $subtotal + $shipping;

        // Crée la commande (paiement à confirmer : Mobile Money ou à la livraison)
        $order = Order::create([
            'order_number' => 'CMD-' . now()->format('Ymd') . '-' . strtoupper(Str::random(6)),
            'user_id' => Auth::id(),
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'status' => 'pending',
            'payment_status' => 'pending',
            'payment_method' => $validated['payment_method'],
            'subtotal' => $subtotal,
            'tax_amount' => 0,
            'shipping_amount' => $shipping,
            'discount_amount' => 0,
            'total' => $total,
            'currency' => 'XOF',
            'billing_first_name' => $validated['first_name'],
            'billing_last_name' => $validated['last_name'],
            'billing_address' => $validated['address'] . ' (' . $validated['quartier'] . ')',
            'billing_city' => $validated['city'],
            'billing_postal_code' => '-',
            'billing_country' => 'Togo',
            'billing_phone' => $validated['phone'],
        ]);

        $order->items()->create([
            'product_id' => $product->id,
            'quantity' => $quantity,
            'unit_price' => $unitPrice,
            'total' => $subtotal,
            'product_name' => $product->name,
            'product_sku' => $product->sku,
        ]);

        // Décrémente le stock
        $product->decrement('stock_quantity', $quantity);

        // Paiement en ligne : redirige vers la page de paiement KkiaPay
        // (l'admin sera notifié à la confirmation du paiement).
        if ($validated['payment_method'] === 'kkiapay') {
            if (! app(KkiaPayService::class)->isConfigured()) {
                return back()->withErrors(['payment_method' => 'Le paiement en ligne est momentanément indisponible.'])->withInput();
            }

            return redirect()->route('payment.show', $order->order_number);
        }

        // Commande hors ligne (à la livraison / Mobile Money manuel) :
        // notifie l'admin pour préparer la livraison. Isolée : un échec
        // ne bloque jamais la commande du client.
        try {
            app(\App\Services\AdminNotifier::class)->notifyNewOrder($order->fresh('items'));
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::warning('Commande : notification admin non envoyée', [
                'order' => $order->order_number,
                'error' => $e->getMessage(),
            ]);
        }

        return redirect()->route('checkout.success', $order->order_number);
    }

    // Page de confirmation après paiement/commande
    public function success(string $orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)->with('items')->firstOrFail();

        return view('shop.success', compact('order'));
    }
}
