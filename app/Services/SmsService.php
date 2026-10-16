<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

// Envoi de SMS (canal admin). Pilote par défaut : "log" — le message est
// écrit dans les logs Laravel en attendant un vrai fournisseur.
// Pour un envoi réel, renseigner SMS_DRIVER=twilio + TWILIO_SID /
// TWILIO_TOKEN / TWILIO_FROM (aucune dépendance supplémentaire requise,
// appel direct de l'API Twilio en HTTP).
class SmsService
{
    public function driver(): string
    {
        return (string) config('services.sms.driver', 'log');
    }

    // Normalise un numéro local (espaces, points, tirets supprimés).
    public function normalize(string $phone): string
    {
        $phone = trim($phone);
        $plus = str_starts_with($phone, '+') ? '+' : '';
        $digits = preg_replace('/\D+/', '', $phone) ?? '';

        return $plus.$digits;
    }

    // Envoie un SMS. Ne lève jamais d'exception : retourne false en cas
    // d'échec (le paiement reste validé quoi qu'il arrive).
    public function send(string $to, string $message): bool
    {
        $to = $this->normalize($to);

        if ($to === '') {
            Log::warning('SMS non envoyé : numéro destinataire vide.');

            return false;
        }

        try {
            if ($this->driver() === 'twilio') {
                return $this->sendViaTwilio($to, $message);
            }

            Log::info('SMS admin (pilote log)', ['to' => $to, 'message' => $message]);

            return true;
        } catch (\Throwable $e) {
            Log::warning('SMS admin non envoyé', ['to' => $to, 'error' => $e->getMessage()]);

            return false;
        }
    }

    protected function sendViaTwilio(string $to, string $message): bool
    {
        $sid = (string) config('services.sms.twilio_sid');
        $token = (string) config('services.sms.twilio_token');
        $from = (string) config('services.sms.twilio_from');

        if (! filled($sid) || ! filled($token) || ! filled($from)) {
            Log::warning('SMS Twilio non configuré (SID/token/expéditeur manquants), message journalisé.', [
                'to' => $to,
                'message' => $message,
            ]);

            return false;
        }

        $response = Http::timeout(15)
            ->withBasicAuth($sid, $token)
            ->asForm()
            ->post("https://api.twilio.com/2010-04-01/Accounts/{$sid}/Messages.json", [
                'To' => $to,
                'From' => $from,
                'Body' => $message,
            ]);

        if ($response->failed()) {
            Log::warning('SMS Twilio refusé', ['to' => $to, 'http' => $response->status()]);

            return false;
        }

        Log::info('SMS admin envoyé (Twilio)', ['to' => $to, 'sid' => $response->json('sid')]);

        return true;
    }
}
