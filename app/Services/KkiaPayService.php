<?php

namespace App\Services;

use App\Models\Order;
use App\Mail\PaymentConfirmed;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

// Intégration KkiaPay : vérification serveur des transactions.
// Le widget JavaScript (public) initie le paiement côté client, puis chaque
// transaction DOIT être vérifiée ici avec les clés privée + secrète.
class KkiaPayService
{
    // URL de base de l'API selon le mode (bac à sable ou production)
    public function baseUrl(): string
    {
        return $this->isSandbox()
            ? 'https://api-sandbox.kkiapay.me'
            : 'https://api.kkiapay.me';
    }

    public function isSandbox(): bool
    {
        return (bool) config('kkiapay.sandbox', true);
    }

    // Vrai si les 3 clés sont renseignées (sinon le paiement en ligne est masqué)
    public function isConfigured(): bool
    {
        return filled(config('kkiapay.public_key'))
            && filled(config('kkiapay.private_key'))
            && filled(config('kkiapay.secret'));
    }

    // Interroge l'API KkiaPay pour récupérer le statut réel d'une transaction.
    // Retourne le tableau décodé (status, amount, transactionId, ...) ou lève une exception.
    public function verify(string $transactionId): array
    {
        $response = Http::timeout(20)
            ->acceptJson()
            ->withHeaders([
                'X-API-KEY' => config('kkiapay.public_key'),
                'X-PRIVATE-KEY' => config('kkiapay.private_key'),
                'X-SECRET-KEY' => config('kkiapay.secret'),
            ])
            ->post($this->baseUrl().'/api/v1/transactions/status', [
                'transactionId' => $transactionId,
            ]);

        if ($response->failed()) {
            // KkiaPay répond 4xx avec un statut explicite quand la transaction
            // est inconnue (ex : TRANSACTION_NOT_FOUND) : on le remonte tel quel,
            // confirmOrderPayment() refusera alors le paiement (422 côté client).
            $data = $response->json();
            if (is_array($data) && isset($data['status'])) {
                return $data;
            }

            Log::warning('KkiaPay : vérification transaction impossible', [
                'transaction' => $transactionId,
                'http' => $response->status(),
            ]);

            throw new \RuntimeException('Vérification KkiaPay impossible (HTTP '.$response->status().').');
        }

        return $response->json();
    }

    // Valide le paiement d'une commande à partir de la réponse KkiaPay.
    // Idempotent : une commande déjà payée reste payée sans double traitement.
    public function confirmOrderPayment(Order $order, array $transaction): bool
    {
        if ($order->payment_status === 'paid') {
            return true;
        }

        $status = strtoupper((string) ($transaction['status'] ?? ''));
        $amount = (int) ($transaction['amount'] ?? 0);
        $txId = $transaction['transactionId'] ?? null;

        // Succès : statut SUCCESS + référence + montant couvrant le total (XOF)
        if ($status === 'SUCCESS' && filled($txId) && $amount >= (int) $order->total) {
            $order->update([
                'payment_status' => 'paid',
                'payment_reference' => $txId,
                'status' => 'confirmed',
                'confirmed_at' => now(),
            ]);

            Log::info('KkiaPay : commande payée', [
                'order' => $order->order_number,
                'transaction' => $txId,
                'amount' => $amount,
            ]);

            // Email de confirmation au client (l'échec d'envoi ne remet
            // jamais en cause le paiement déjà validé)
            try {
                Mail::to($order->email)->send(new PaymentConfirmed($order));
            } catch (\Throwable $e) {
                Log::warning('KkiaPay : email de confirmation non envoyé', [
                    'order' => $order->order_number,
                    'error' => $e->getMessage(),
                ]);
            }

            return true;
        }

        // Échec définitif côté KkiaPay : on le reflète sur la commande
        if (in_array($status, ['FAILED', 'REVERTED'], true)) {
            $order->update([
                'payment_status' => 'failed',
                'payment_reference' => $txId,
            ]);
        }

        Log::warning('KkiaPay : paiement non confirmé', [
            'order' => $order->order_number,
            'status' => $status,
            'amount' => $amount,
            'expected' => (int) $order->total,
        ]);

        return false;
    }
}
