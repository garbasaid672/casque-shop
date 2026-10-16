<?php

return [
    // Contact admin notifié après chaque paiement / nouvelle commande.
    // Modifiables sans toucher au code : .env (ADMIN_PHONE / ADMIN_EMAIL)
    // ou table settings (clés admin_phone / admin_email, prioritaires).
    'admin_phone' => env('ADMIN_PHONE', '0153938588'),
    'admin_email' => env('ADMIN_EMAIL'),
];
