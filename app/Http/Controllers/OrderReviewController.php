<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrderReviewController extends Controller
{
    public function create(string $orderNumber): View
    {
        return view('reviews.create', compact('orderNumber'));
    }

    public function store(Request $request, string $orderNumber): RedirectResponse
    {
        $request->merge([
            'email' => trim((string) $request->input('email')),
        ]);

        $validated = $request->validate([
            'email' => ['required', 'email', 'max:255'],
            'rating' => ['required', 'integer', 'between:1,5'],
            'comment' => ['required', 'string', 'min:10', 'max:1500'],
        ], [
            'rating.between' => 'Choisissez une note entre 1 et 5 étoiles.',
            'comment.min' => 'Votre avis doit contenir au moins 10 caractères.',
        ]);

        $order = Order::query()
            ->where('order_number', $orderNumber)
            ->first();

        $isReviewEligible = ($order?->payment_status === 'paid') || ($order?->status === 'delivered');

        if (! $order || ! $isReviewEligible) {
            return back()
                ->withInput()
                ->withErrors(['email' => 'Cette commande n’est pas encore payée ni livrée. Vérifiez son statut avant de laisser un avis.']);
        }

        if (mb_strtolower(trim($order->email)) !== mb_strtolower($validated['email'])) {
            return back()
                ->withInput()
                ->withErrors(['email' => 'L’adresse e-mail saisie ne correspond pas à celle enregistrée pour cette commande. Vérifiez l’e-mail utilisé lors de l’achat.']);
        }

        $review = $order->review()->firstOrCreate(
            ['order_id' => $order->id],
            [
                'author_name' => trim($order->billing_first_name.' '.mb_substr($order->billing_last_name, 0, 1)).'.',
                'city' => $order->billing_city,
                'rating' => $validated['rating'],
                'comment' => $validated['comment'],
            ],
        );

        if (! $review->wasRecentlyCreated) {
            return back()
                ->withInput()
                ->withErrors(['email' => 'Un avis a déjà été envoyé pour cette commande.']);
        }

        return redirect()
            ->route('reviews.create', $orderNumber)
            ->with('status', 'Merci ! Votre avis a été envoyé et sera publié après vérification.');
    }
}
