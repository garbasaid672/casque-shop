<?php

namespace App\Services;

use App\Mail\AdminPaymentNotification;
use App\Models\Order;
use App\Models\User;
use Filament\Notifications\Notification as FilamentNotification;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

// Notifie l'admin après un paiement (ou une nouvelle commande) :
// 1) email, 2) SMS, 3) cloche du dashboard Filament.
// Chaque canal est isolé : un échec ne bloque ni les autres ni le paiement.
class AdminNotifier
{
    public function __construct(protected SmsService $sms) {}

    public function adminPhone(): string
    {
        return (string) (setting('admin_phone', config('shop.admin_phone', '')) ?? '');
    }

    public function adminEmail(): ?string
    {
        $email = setting('admin_email', config('shop.admin_email'));

        if (filled($email)) {
            return (string) $email;
        }

        return User::where('is_admin', true)->orderBy('id')->value('email');
    }

    /** @return Collection<int, User> */
    public function admins(): Collection
    {
        return User::where('is_admin', true)->get();
    }

    // Commande payée en ligne : l'admin doit livrer vite.
    public function notifyPaid(Order $order): void
    {
        $order->loadMissing('items');
        $this->sendMail($order, true);
        $this->sendSms($order, true);
        $this->sendDashboard($order, true);
    }

    // Commande hors ligne (à la livraison / Mobile Money manuel) : l'admin
    // doit la préparer même si le paiement n'est pas encore encaissé.
    public function notifyNewOrder(Order $order): void
    {
        $order->loadMissing('items');
        $this->sendMail($order, false);
        $this->sendSms($order, false);
        $this->sendDashboard($order, false);
    }

    protected function sendMail(Order $order, bool $paid): void
    {
        $email = $this->adminEmail();

        if (! filled($email)) {
            Log::warning('Email admin non envoyé : aucun email admin configuré.', ['order' => $order->order_number]);

            return;
        }

        try {
            Mail::to($email)->send(new AdminPaymentNotification($order));
        } catch (\Throwable $e) {
            Log::warning('Email admin non envoyé', ['order' => $order->order_number, 'error' => $e->getMessage()]);
        }
    }

    protected function sendSms(Order $order, bool $paid): void
    {
        $phone = $this->adminPhone();

        if (! filled($phone)) {
            Log::warning('SMS admin non envoyé : aucun numéro admin configuré.', ['order' => $order->order_number]);

            return;
        }

        $total = number_format((int) round($order->total), 0, ',', ' ').' FCFA';
        $client = trim($order->billing_first_name.' '.$order->billing_last_name);
        $address = $order->full_shipping_address;

        $message = $paid
            ? "NOUVEAU PAIEMENT {$order->order_number} : {$total} recu. Client : {$client} ({$order->phone}). Livraison : {$address}. Livrer VITE. Boutique : appelez le client pour confirmer."
            : "NOUVELLE COMMANDE {$order->order_number} : {$total} ({$order->payment_method}). Client : {$client} ({$order->phone}). Livraison : {$address}. A preparer.";

        $this->sms->send($phone, $message);
    }

    protected function sendDashboard(Order $order, bool $paid): void
    {
        if (! class_exists(FilamentNotification::class)) {
            return;
        }

        $admins = $this->admins();

        if ($admins->isEmpty()) {
            Log::warning('Notification dashboard non envoyée : aucun admin.', ['order' => $order->order_number]);

            return;
        }

        $total = number_format((int) round($order->total), 0, ',', ' ').' FCFA';

        try {
            FilamentNotification::make()
                ->title($paid ? 'Paiement reçu : '.$order->order_number : 'Nouvelle commande : '.$order->order_number)
                ->body(
                    ($paid ? "{$total} encaissés. Livrez vite ! " : "{$total} ({$order->payment_method}). À préparer. ")
                    .'Client : '.trim($order->billing_first_name.' '.$order->billing_last_name)
                    .' ('.$order->phone.'). Livraison : '.$order->full_shipping_address.'.'
                )
                ->success()
                ->sendToDatabase($admins);
        } catch (\Throwable $e) {
            Log::warning('Notification dashboard non envoyée', ['order' => $order->order_number, 'error' => $e->getMessage()]);
        }
    }
}
