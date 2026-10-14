<?php

namespace App\Filament\Auth;

use Filament\Auth\Pages\Login as BaseLogin;
use Illuminate\Contracts\Support\Htmlable;

// Page de connexion de l'administration (look GMS Audio)
class Login extends BaseLogin
{
    public function getHeading(): string|Htmlable|null
    {
        return 'Connexion';
    }

    public function getSubheading(): string|Htmlable|null
    {
        return 'Administration — connectez-vous pour gérer votre boutique.';
    }
}
