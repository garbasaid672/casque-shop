<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Votre avis - {{ site_name() }}</title>
</head>
<body style="margin:0;padding:0;background:#f1f5f9;font-family:Arial,Helvetica,sans-serif;color:#0f172a;">
    <main style="max-width:600px;margin:0 auto;padding:28px 16px;">
        <section style="padding:28px;border-radius:14px;background:#fff;">
            <p style="margin:0;color:#0369a1;font-size:13px;font-weight:bold;">{{ site_name() }}</p>
            <h1 style="margin:14px 0 8px;font-size:24px;">Bonjour {{ $order->billing_first_name }},</h1>
            <p style="font-size:15px;line-height:1.6;">
                Votre commande <strong>{{ $order->order_number }}</strong> a été marquée comme livrée.
                Si vous avez reçu votre casque, partagez votre expérience avec notre équipe.
            </p>
            <p style="margin:24px 0;">
                <a href="{{ route('reviews.create', $order->order_number) }}"
                    style="display:inline-block;padding:13px 20px;border-radius:9px;background:#0284c7;color:#fff;font-weight:bold;text-decoration:none;">
                    Donner mon avis
                </a>
            </p>
            <p style="color:#64748b;font-size:13px;line-height:1.5;">
                Pour vérifier l’achat, le formulaire vous demandera l’adresse e-mail utilisée pour cette commande.
                Votre avis sera publié sur notre site après vérification.
            </p>
        </section>
        <p style="padding:12px;text-align:center;color:#94a3b8;font-size:12px;">
            © {{ date('Y') }} {{ site_name() }}. Tous droits réservés.
        </p>
    </main>
</body>
</html>
