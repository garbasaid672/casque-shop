<?php

namespace App\Filament\Pages;

use App\Models\Product;
use App\Models\Setting;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
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
            'home_video_enabled' => setting('home_video_enabled', '1') === '1',
            'home_video_title' => setting('home_video_title', 'Du téléphone à la livraison'),
            'home_video_description' => setting(
                'home_video_description',
                'Découvrez le parcours d’une commande : le client choisit son produit, règle sa commande et reçoit son casque.'
            ),
            'home_reviews_enabled' => setting('home_reviews_enabled', '1') === '1',
            'home_reviews_title' => setting('home_reviews_title', 'Leur expérience après commande'),
            'home_reviews_description' => setting(
                'home_reviews_description',
                'Chaque avis provient d’une commande livrée et est vérifié par notre équipe avant publication.'
            ),
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

                Section::make('Section vidéo')
                    ->description('Configure l’animation qui présente le parcours d’une commande.')
                    ->schema([
                        Toggle::make('home_video_enabled')
                            ->label('Afficher la section vidéo')
                            ->default(true),

                        TextInput::make('home_video_title')
                            ->label('Titre')
                            ->required()
                            ->maxLength(120),

                        Textarea::make('home_video_description')
                            ->label('Description')
                            ->required()
                            ->rows(3)
                            ->maxLength(500)
                            ->columnSpanFull(),
                    ]),

                Section::make('Section avis clients')
                    ->description('Les avis affichés restent ceux approuvés dans le menu Avis clients.')
                    ->schema([
                        Toggle::make('home_reviews_enabled')
                            ->label('Afficher les avis clients')
                            ->default(true),

                        TextInput::make('home_reviews_title')
                            ->label('Titre')
                            ->required()
                            ->maxLength(120),

                        Textarea::make('home_reviews_description')
                            ->label('Description')
                            ->required()
                            ->rows(3)
                            ->maxLength(500)
                            ->columnSpanFull(),
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

        foreach (['home_video_enabled', 'home_reviews_enabled'] as $key) {
            $value = ($data[$key] ?? false) ? '1' : '0';

            Setting::updateOrCreate(['key' => $key], ['value' => $value]);
            cache()->forget('setting.'.$key);
        }

        foreach ([
            'hero_title',
            'hero_highlight',
            'hero_subtitle',
            'home_video_title',
            'home_video_description',
            'home_reviews_title',
            'home_reviews_description',
            'home_bg',
            'hero_from',
            'hero_to',
        ] as $key) {
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
