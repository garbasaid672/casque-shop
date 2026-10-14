<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use App\Models\User;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Actions;
use Filament\Schemas\Components\EmbeddedSchema;
use Filament\Schemas\Components\Form;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\Hash;
use UnitEnum;

// Page Compte : l'admin modifie ses infos + le nom du site
class MonCompte extends Page
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUserCircle;

    protected static UnitEnum|string|null $navigationGroup = 'Gestion';

    protected static ?int $navigationSort = 2;

    protected static ?string $navigationLabel = 'Compte';

    protected static ?string $title = 'Mon compte';

    public ?array $data = [];

    public function mount(): void
    {
        $user = auth()->user();

        $this->form->fill([
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $user->phone,
            'site_name' => setting('site_name', config('app.name', 'GMS Audio')),
        ]);
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->statePath('data')
            ->components([
                Section::make('Mes informations')
                    ->schema([
                        TextInput::make('name')
                            ->label('Nom')
                            ->required()
                            ->maxLength(255),

                        TextInput::make('email')
                            ->label('Email')
                            ->email()
                            ->required()
                            ->maxLength(255),

                        TextInput::make('phone')
                            ->label('Téléphone')
                            ->tel()
                            ->maxLength(30),

                        TextInput::make('password')
                            ->label('Nouveau mot de passe (vide = inchangé)')
                            ->password()
                            ->revealable()
                            ->minLength(8)
                            ->dehydrated(fn ($state): bool => filled($state))
                            ->dehydrateStateUsing(fn ($state): string => Hash::make($state)),

                        TextInput::make('password_confirmation')
                            ->label('Confirmer le mot de passe')
                            ->password()
                            ->same('password')
                            ->dehydrated(false),
                    ]),

                Section::make('Site')
                    ->description('Nom affiché dans la boutique, les titres, le footer et la sidebar admin.')
                    ->schema([
                        TextInput::make('site_name')
                            ->label('Nom du site')
                            ->required()
                            ->maxLength(100),
                    ]),
            ]);
    }

    public function content(Schema $schema): Schema
    {
        return $schema
            ->components([
                Form::make([EmbeddedSchema::make('form')])
                    ->id('form')
                    ->livewireSubmitHandler('save')
                    ->footer([
                        Actions::make([
                            Action::make('save')
                                ->label('Enregistrer')
                                ->submit('save'),
                        ]),
                    ]),
            ]);
    }

    public function save(): void
    {
        $data = $this->form->getState();

        $user = auth()->user();

        // Refuse un email déjà pris par un autre compte
        if ($data['email'] !== $user->email && User::where('email', $data['email'])->exists()) {
            Notification::make()
                ->danger()
                ->title('Cet email est déjà utilisé.')
                ->send();

            return;
        }

        $siteName = trim((string) ($data['site_name'] ?? ''));

        if ($siteName === '') {
            Notification::make()
                ->danger()
                ->title('Le nom du site ne peut pas être vide.')
                ->send();

            return;
        }

        unset($data['site_name']);
        $user->update($data);

        Setting::updateOrCreate(
            ['key' => 'site_name'],
            ['value' => $siteName]
        );

        cache()->forget('setting.site_name');

        Notification::make()
            ->success()
            ->title('Compte et nom du site mis à jour.')
            ->send();
    }
}
