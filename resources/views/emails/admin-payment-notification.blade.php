<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Nouvelle commande payée - {{ site_name() }}</title>
</head>
<body style="margin:0;padding:0;background-color:#f1f5f9;font-family:Arial,Helvetica,sans-serif;">
<div style="max-width:600px;margin:0 auto;padding:24px 16px;">
    <!-- En-tête -->
    <div style="background:linear-gradient(135deg,#020617,#0b3b6e);border-radius:12px 12px 0 0;padding:24px;text-align:center;color:#ffffff;">
        <p style="margin:0;font-size:24px;font-weight:800;">{{ site_name() }}</p>
        <p style="margin:6px 0 0;font-size:13px;">Nouveau paiement reçu — livrer vite</p>
    </div>

    <!-- Corps -->
    <div style="background-color:#ffffff;border-radius:0 0 12px 12px;padding:24px;">
        <p style="margin:0 0 8px;font-size:18px;font-weight:bold;color:#0f172a;">
            Commande <strong>{{ $order->order_number }}</strong> payée avec succès
        </p>
        <p style="margin:0 0 16px;font-size:15px;color:#334155;">
            Le client a payé en ligne. Appelez-le au besoin au <strong>{{ $order->phone }}</strong>
            et organisez la livraison dans les 24 heures.
        </p>

        <!-- Détails commande -->
        <div style="background-color:#f8fafc;border:1px solid #e2e8f0;border-radius:8px;padding:16px;margin:20px 0;font-size:14px;color:#334155;">
            <p style="margin:0 0 8px;"><strong>Client :</strong> {{ $order->billing_first_name }} {{ $order->billing_last_name }}</p>
            <p style="margin:0 0 8px;"><strong>Email client :</strong> {{ $order->email }}</p>
            <p style="margin:0 0 8px;"><strong>Tél client :</strong> {{ $order->phone }}</p>
            <p style="margin:0 0 8px;"><strong>Lieu de livraison :</strong> {{ $order->full_shipping_address }}</p>
            <p style="margin:0 0 8px;"><strong>Montant :</strong> {{ number_format((int) round($order->total), 0, ',', ' ') }} FCFA</p>
            <p style="margin:0;"><strong>Moyen :</strong> {{ $order->payment_method }}</p>
            @if($order->payment_reference)
                <p style="margin:8px 0 0;font-size:12px;color:#64748b;">Référence : {{ $order->payment_reference }}</p>
            @endif
        </div>

        <p style="margin:16px 0 0;text-align:center;">
            <a href="{{ \App\Filament\Resources\Orders\OrderResource::getUrl('index') }}"
               style="display:inline-block;background-color:#0369a1;color:#ffffff;text-decoration:none;padding:12px 24px;border-radius:8px;font-weight:bold;">
                Voir la commande dans l'admin
            </a>
        </p>

        <!-- Pied -->
        <p style="margin:24px 0 0;font-size:12px;color:#94a3b8;text-align:center;">
            © {{ date('Y') }} {{ site_name() }}. Tous droits réservés.
        </p>
    </div>
</div>
</body>
</html>
