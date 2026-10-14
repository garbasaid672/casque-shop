<?php

namespace App\Filament\Widgets;

use App\Models\Product;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;

// Derniers articles (avec photos) sur le tableau de bord admin
class LatestArticles extends TableWidget
{
    // Chargé directement avec la page (photos visibles aussitôt)
    protected static bool $isLazy = false;

    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(Product::query()->with('category')->latest()->limit(8))
            ->columns([
                ImageColumn::make('images')
                    ->label('Photo')
                    ->disk('public')
                    ->circular()
                    ->stacked()
                    ->limit(1),

                TextColumn::make('name')
                    ->label('Article'),

                TextColumn::make('category.name')
                    ->label('Catégorie'),

                TextColumn::make('price')
                    ->label('Prix')
                    ->formatStateUsing(fn ($state) => number_format((int) round($state * Product::FCFA_RATE), 0, ',', ' ') . ' FCFA'),

                TextColumn::make('stock_quantity')
                    ->label('Stock'),
            ]);
    }
}
