<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nom')
                    ->required()
                    ->maxLength(255)
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn ($state, $set) => $set('slug', \Illuminate\Support\Str::slug($state))),

                TextInput::make('slug')
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true)
                    ->disabled(),

                Select::make('category_id')
                    ->label('Catégorie')
                    ->relationship('category', 'name')
                    ->required()
                    ->searchable()
                    ->preload(),

                TextInput::make('brand')
                    ->label('Marque')
                    ->maxLength(255),

                TextInput::make('model')
                    ->label('Modèle')
                    ->maxLength(255),

                TextInput::make('color')
                    ->label('Couleur')
                    ->maxLength(255),

                TextInput::make('price')
                    ->label('Prix (EUR, affiché en FCFA)')
                    ->required()
                    ->numeric()
                    ->minValue(0)
                    ->maxValue(76.92)
                    ->helperText('Plafond boutique : 76,92 EUR ≈ 50 000 FCFA.'),

                TextInput::make('compare_at_price')
                    ->label('Prix barré (EUR)')
                    ->numeric()
                    ->nullable()
                    ->minValue(0)
                    ->maxValue(76.92)
                    ->helperText('Plafond boutique : 76,92 EUR ≈ 50 000 FCFA.'),

                TextInput::make('sku')
                    ->label('Référence SKU')
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true),

                TextInput::make('stock_quantity')
                    ->label('Stock')
                    ->required()
                    ->numeric()
                    ->default(0)
                    ->minValue(0),

                TextInput::make('low_stock_threshold')
                    ->label('Seuil stock bas')
                    ->numeric()
                    ->default(5)
                    ->minValue(0),

                FileUpload::make('images')
                    ->label('Photos')
                    ->image()
                    ->multiple()
                    ->directory('products')
                    ->maxSize(2048)
                    ->columnSpanFull(),

                Textarea::make('short_description')
                    ->label('Description courte')
                    ->rows(2)
                    ->columnSpanFull(),

                Textarea::make('description')
                    ->label('Description')
                    ->rows(4)
                    ->columnSpanFull(),

                TagsInput::make('features')
                    ->label('Caractéristiques')
                    ->columnSpanFull(),

                Toggle::make('is_active')
                    ->label('Actif')
                    ->default(true),

                Toggle::make('is_featured')
                    ->label('En vedette')
                    ->default(false),
            ]);
    }
}
