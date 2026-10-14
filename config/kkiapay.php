<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Clés API KkiaPay (https://app.kkiapay.me/dashboard/developers/keys)
    |--------------------------------------------------------------------------
    | Clé publique : utilisée par le widget JavaScript (visible côté client).
    | Clé privée + secret : utilisés UNIQUEMENT côté serveur pour vérifier
    | les transactions. Ne les exposez jamais dans une vue ou du JS.
    */
    'public_key' => env('KKIAPAY_PUBLIC_KEY'),
    'private_key' => env('KKIAPAY_PRIVATE_KEY'),
    'secret' => env('KKIAPAY_SECRET_KEY'),

    // true = bac à sable (tests), false = production (vrais paiements)
    'sandbox' => env('KKIAPAY_SANDBOX', true),

];
