<?php

namespace App\Filament\Auth;

use Filament\Actions\Action;
use Filament\Auth\Pages\Login as BaseLogin;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Component;
use Illuminate\Contracts\Support\Htmlable;

// Page de connexion admin : utilisation de la page par défaut de Filament.
class Login extends BaseLogin
{

    protected static string $layout = 'filament.auth.layouts.client';

    public function getHeading(): string|Htmlable|null
    {
        return 'Connexion';
    }

    public function getSubheading(): string|Htmlable|null
    {
        return 'Administration — connectez-vous pour gérer votre boutique.';
    }

    protected function getEmailFormComponent(): Component
    {
        return TextInput::make('email')
            ->label('Adresse email')
            ->email()
            ->required()
            ->autocomplete()
            // Compte d'essai pré-rempli (tests uniquement, à retirer en production)
            ->default('admin@example.com');
    }

    protected function getPasswordFormComponent(): Component
    {
        return TextInput::make('password')
            ->label('Mot de passe')
            ->password()
            ->revealable(filament()->arePasswordsRevealable())
            ->autocomplete('current-password')
            ->required()
            // Compte d'essai pré-rempli (tests uniquement, à retirer en production)
            ->default('password');
    }

    protected function getRememberFormComponent(): Component
    {
        return Checkbox::make('remember')
            ->label('Se souvenir de moi');
    }

    protected function getAuthenticateFormAction(): Action
    {
        return Action::make('authenticate')
            ->label('Se connecter')
            ->submit('authenticate');
    }
}
