<?php

namespace App\Http\Responses;

use Filament\Auth\Http\Responses\Contracts\LogoutResponse as LogoutResponseContract;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;

// Après une déconnexion depuis l'admin, retourne à la boutique (accueil)
// au lieu de la page de connexion admin.
class LogoutResponse implements LogoutResponseContract
{
    public function toResponse($request): RedirectResponse | Redirector
    {
        return redirect()->route('home');
    }
}
