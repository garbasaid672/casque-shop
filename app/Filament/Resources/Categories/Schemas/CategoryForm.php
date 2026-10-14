<?php

namespace App\Filament\Resources\Categories\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class CategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn ($state, $set) => $set('slug', \Illuminate\Support\Str::slug($state))),

                TextInput::make('slug')
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true)
                    ->disabled(),

                RichEditor::make('description')
                    ->columnSpanFull()
                    ->toolbarButtons([
                        'bold',
                        'italic',
                        'underline',
                        'link',
                        'bulletList',
                        'orderedList',
                    ]),

                FileUpload::make('image')
                    ->image()
                    ->disk('public')
                    ->visibility('public')
                    ->directory('categories')
                    ->maxSize(2048)
                    ->columnSpanFull(),

                TextInput::make('sort_order')
                    ->numeric()
                    ->default(0)
                    ->minValue(0),

                Toggle::make('is_active')
                    ->label('Actif')
                    ->default(true),
            ]);
    }
}