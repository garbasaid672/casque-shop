<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Paiement reçu — {{ site_name() }}</title>
</head>
<body style="margin:0;padding:0;background-color:#f1f5f9;font-family:Arial,Helvetica,sans-serif;">
    <div style="max-width:600px;margin:0 auto;padding:24px 16px;">
        <!-- En-tête marque -->
        <div style="background:linear-gradient(135deg,#020617,#0b3b6e);border-radius:12px 12px 0 0;padding:28px;text-align:center;">
            <p style="margin:0;font-size:24px;font-weight:800;color:#ffffff;">{{ site_name() }}</p>
            <p style="margin:6px 0 0;font-size:13px;color:#bae6fd;">Merci pour votre confiance</p>
        </div>

        <!-- Corps -->
        <div style="background-color:#ffffff;border-radius:0 0 12px 12px;padding:28px;">
            <p style="margin:0 0 8px;font-size:18px;font-weight:bold;color:#0f172a;">
                Bonjour {{ $order->billing_first_name }},
            </p>
            <p style="margin:0 0 16px;font-size:15px;font-weight:bold;color:#15803d;">
                Paiement effectué, vous serez contacté {{ $message->date }} au plus pour votre livraison.
            </p>

            <!-- Récapitulatif commande -->
            <div style="background-color:#f8fafc;border:1px solid #e2e8f0;border-radius:8px;padding:16px;font-size:14px;color:#334155;">
                <p style="margin:0 0 10px;"><strong>Commande :</strong> {{ $order->order_number }}</p>
                @foreach($order->items as $item)
                    <p style="margin:4px 0;">
                        {{ $item->product_name }} × {{ $item->quantity }}
                        — <strong>{{ number_format($item->total, 0, ',', ' ') }} FCFA</strong>
                    </p>
                @endforeach
                <p style="margin:4px 0;">Livraison — <strong>{{ number_format($order->shipping_amount, 0, ',', ' ') }} FCFA</strong></p>
                <p style="margin:10px 0 0;padding-top:10px;border-top:1px solid #e2e8f0;font-size:16px;">
                    Total payé : <strong style="color:#0369a1;">{{ number_format($order->total, 0, ',', ' ') }} FCFA</strong>
                </p>
                @if($order->payment_reference)
                    <p style="margin:8px 0 0;font-size:12px;color:#64748b;">Référence : {{ $order->payment_reference }}</p>
                @endif
            </div>

            <p style="margin:16px 0 0;font-size:13px;color:#64748b;">
                Une question ? Répondez simplement à cet email ou contactez-nous via la page Contact de la boutique.
            </p>
        </div>

        <!-- Pied -->
        <p style="margin:16px 0 0;text-align:center;font-size:12px;color:#94a3b8;">
            © {{ date('Y') }} {{ site_name() }}. Tous droits réservés.
        </p>
    </div>
</body>
</html>
