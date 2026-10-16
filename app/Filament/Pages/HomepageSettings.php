<?php

namespace App\Filament\Pages;

use App\Models\Product;
use App\Models\Setting;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Actions;
use Filament\Schemas\Components\EmbeddedSchema;
use Filament\Schemas\Components\Form;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use UnitEnum;

// Page d'accueil : l'admin modifie les textes du hero et les couleurs
// (fond de page + dégradé du bandeau). Appliqué immédiatement en boutique.
class HomepageSettings extends Page
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedPaintBrush;

    protected static UnitEnum|string|null $navigationGroup = 'Gestion';

    protected static ?int $navigationSort = 3;

    protected static ?string $navigationLabel = 'Accueil du site';

    protected static ?string $title = "Page d'accueil";

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill([
            'hero_title' => setting('hero_title', 'Découvrez nos casques audio premium'),
            'hero_highlight' => setting('hero_highlight', 'casques audio'),
            'hero_subtitle' => setting(
                'hero_subtitle',
                'Qualité sonore exceptionnelle, confort optimal et design moderne pour tous les audiophiles.'
            ),
            'home_bg' => setting('home_bg', '#f1f4f9'),
            'hero_from' => setting('hero_from', '#050b24'),
            'hero_to' => setting('hero_to', '#0b4a6f'),
            'home_featured' => self::idsSetting('home_featured'),
            'home_new' => self::idsSetting('home_new'),
        ]);
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->statePath('data')
            ->components([
                Section::make('Textes du bandeau')
                    ->description('Le mot en surbrillance s’affiche en jaune dans le titre.')
                    ->schema([
                        TextInput::make('hero_title')
                            ->label('Titre principal')
                            ->required()
                            ->maxLength(120),

                        TextInput::make('hero_highlight')
                            ->label('Mot en surbrillance (jaune)')
                            ->maxLength(60),

                        TextInput::make('hero_subtitle')
                            ->label('Sous-titre')
                            ->maxLength(200),
                    ]),

                Section::make('Articles affichés')
                    ->description('Choisis les produits des sections Vedettes et Nouveautés. Vide = sélection automatique.')
                    ->schema([
                        Select::make('home_featured')
                            ->label('Produits vedettes (max 8)')
                            ->multiple()
                            ->searchable()
                            ->maxItems(8)
                            ->options(fn (): array => Product::where('is_active', true)->orderBy('name')->pluck('name', 'id')->all()),

                        Select::make('home_new')
                            ->label('Nouveautés (max 4)')
                            ->multiple()
                            ->searchable()
                            ->maxItems(4)
                            ->options(fn (): array => Product::where('is_active', true)->orderBy('name')->pluck('name', 'id')->all()),
                    ]),

                Section::make('Couleurs')
                    ->description('Fond de la page (mode clair) et dégradé du bandeau. Appliqué dès l’enregistrement.')
                    ->schema([
                        ColorPicker::make('home_bg')
                            ->label('Fond de la page')
                            ->required(),

                        ColorPicker::make('hero_from')
                            ->label('Bandeau : couleur de départ')
                            ->required(),

                        ColorPicker::make('hero_to')
                            ->label("Bandeau : couleur d'arrivée")
                            ->required(),
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

    /** Liste d'ids produit lue depuis les réglages (JSON), nettoyée. */
    public static function idsSetting(string $key): array
    {
        $ids = json_decode((string) setting($key, '[]'), true);

        if (! is_array($ids)) {
            return [];
        }

        return array_values(array_filter(array_map('intval', $ids)));
    }

    public function save(): void
    {
        $data = $this->form->getState();

        foreach (['home_featured', 'home_new'] as $key) {
            $ids = $data[$key] ?? [];
            $ids = is_array($ids) ? array_values(array_filter(array_map('intval', $ids))) : [];

            Setting::updateOrCreate(['key' => $key], ['value' => json_encode($ids)]);
            cache()->forget('setting.'.$key);
        }

        foreach (['hero_title', 'hero_highlight', 'hero_subtitle', 'home_bg', 'hero_from', 'hero_to'] as $key) {
            $value = trim((string) ($data[$key] ?? ''));

            if (in_array($key, ['home_bg', 'hero_from', 'hero_to'], true) && ! preg_match('/^#[0-9a-fA-F]{6}$/', $value)) {
                Notification::make()
                    ->danger()
                    ->title('Couleur invalide : '.$key)
                    ->send();

                return;
            }

            Setting::updateOrCreate(['key' => $key], ['value' => $value]);
            cache()->forget('setting.'.$key);
        }

        Notification::make()
            ->success()
            ->title("Page d'accueil mise à jour.")
            ->send();
    }
}
