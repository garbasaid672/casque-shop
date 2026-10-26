<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\KkiaPayService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

// Paiement en ligne KkiaPay : page de paiement, vérification et webhook.
class PaymentController extends Controller
{
    // Page de paiement d'une commande en attente (ouvre le widget KkiaPay)
    public function show(string $orderNumber, KkiaPayService $kkiapay)
    {
        $order = Order::where('order_number', $orderNumber)->with('items')->firstOrFail();

        // Déjà payée ou autre moyen : retour à la confirmation
        if ($order->payment_method !== 'kkiapay' || $order->payment_status === 'paid') {
            return redirect()->route('checkout.success', $order->order_number);
        }

        if (! $kkiapay->isConfigured()) {
            return redirect()->route('checkout.success', $order->order_number)
                ->withErrors(['kkiapay' => 'Le paiement en ligne est momentanément indisponible.']);
        }

        return view('shop.pay', compact('order'));
    }

    // Vérifie la transaction après le widget (appel AJAX) puis marque la commande payée
    public function verify(Request $request, string $orderNumber, KkiaPayService $kkiapay)
    {
        $order = Order::where('order_number', $orderNumber)->firstOrFail();

        $validated = $request->validate([
            'transactionId' => ['required', 'string', 'max:255'],
        ]);

        try {
            $transaction = $kkiapay->verify($validated['transactionId']);
        } catch (\Throwable $e) {
            // Log la cause exacte (ex : cURL error 60 = certificats SSL / serveur non redémarré)
            Log::warning('KkiaPay : exception vérification', [
                'order' => $orderNumber,
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'ok' => false,
                'message' => 'Vérification impossible pour le moment, réessayez.',
            ], 502);
        }

        $reason = $kkiapay->confirmFailureReason($order->fresh(), $transaction, $validated['transactionId']);

        if ($reason === 'success') {
            return response()->json([
                'ok' => true,
                'redirect' => route('checkout.success', $order->order_number),
            ]);
        }

        // Message précis selon la cause (le client réessaie tout seul si en attente)
        return response()->json([
            'ok' => false,
            'retry' => in_array($reason, ['pending'], true),
            'message' => match ($reason) {
                'pending' => 'Paiement en attente de validation sur votre téléphone, on revérifie...',
                'failed' => 'Le paiement a échoué ou a été annulé côté KkiaPay.',
                'amount' => 'Montant reçu insuffisant, contactez la boutique.',
                default => 'Paiement non confirmé par KkiaPay.',
            },
        ], 422);
    }

    // Webhook KkiaPay (notifications asynchrones, sans CSRF) : on revérifie
    // systématiquement la transaction via l'API avant de valider la commande.
    public function webhook(Request $request, KkiaPayService $kkiapay)
    {
        $transactionId = $request->input('transactionId', $request->input('transaction_id'));
        $orderNumber = $request->input('data', $request->input('order_number'));

        if (! filled($transactionId)) {
            return response()->json(['ok' => false], 400);
        }

        try {
            $transaction = $kkiapay->verify((string) $transactionId);
        } catch (\Throwable $e) {
            Log::warning('KkiaPay webhook : vérification impossible', ['transaction' => $transactionId]);

            return response()->json(['ok' => false], 502);
        }

        // Retrouve la commande : via "data" du widget (= n° commande) ou la référence déjà stockée
        $order = filled($orderNumber)
            ? Order::where('order_number', $orderNumber)->first()
            : Order::where('payment_reference', $transactionId)->first();

        if (! $order) {
            Log::warning('KkiaPay webhook : commande introuvable', [
                'transaction' => $transactionId,
                'data' => $orderNumber,
            ]);

            return response()->json(['ok' => false], 404);
        }

        $reason = $kkiapay->confirmFailureReason($order, $transaction, (string) $transactionId);

        if (in_array($reason, ['pending', 'unknown'], true)) {
            return response()->json(['ok' => false], 503);
        }

        return response()->json(['ok' => true]);
    }
}
