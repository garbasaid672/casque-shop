<?php

namespace App\Filament\Widgets;

use App\Models\Category;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;

// Catégories (avec photos) sur le tableau de bord admin
class CategoriesOverview extends TableWidget
{
    // Chargé directement avec la page (photos visibles aussitôt)
    protected static bool $isLazy = false;

    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(Category::query()->orderBy('sort_order'))
            ->columns([
                ImageColumn::make('image')
                    ->label('Photo')
                    ->disk('public')
                    ->circular(),

                TextColumn::make('name')
                    ->label('Catégorie'),

                TextColumn::make('is_active')
                    ->label('Statut')
                    ->badge()
                    ->formatStateUsing(fn ($state) => $state ? 'Active' : 'Désactivée')
                    ->color(fn ($state) => $state ? 'success' : 'gray'),
            ]);
    }
}
