<?php

namespace App\Filament\Auth;

use Filament\Actions\Action;
use Filament\Auth\Pages\Login as BaseLogin;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Component;
use Illuminate\Contracts\Support\Htmlable;

// Page de connexion admin : même habillage que la page client (/connexion).
class Login extends BaseLogin
{
    protected string $view = 'filament.auth.custom-login';

    protected static string $layout = 'filament.auth.layouts.client';

    public function getHeading(): string|Htmlable|null
    {
        return 'Identification';
    }

    public function getSubheading(): string|Htmlable|null
    {
        return 'Connectez-vous pour gérer votre boutique casque-shop';
    }

    protected function getEmailFormComponent(): Component
    {
        return TextInput::make('email')
            ->label('Adresse email')
            ->email()
            ->required()
            ->autocomplete()
            ->autofocus();
    }

    protected function getPasswordFormComponent(): Component
    {
        return TextInput::make('password')
            ->label('Mot de passe')
            ->password()
            ->revealable(filament()->arePasswordsRevealable())
            ->autocomplete('current-password')
            ->required();
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
