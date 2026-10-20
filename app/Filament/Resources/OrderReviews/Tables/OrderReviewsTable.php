<?php

namespace App\Filament\Resources\OrderReviews\Tables;

use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class OrderReviewsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('author_name')
                    ->label('Client')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('order.order_number')
                    ->label('Commande')
                    ->searchable(),

                TextColumn::make('rating')
                    ->label('Note')
                    ->formatStateUsing(fn ($state): string => $state.'/5')
                    ->sortable(),

                TextColumn::make('comment')
                    ->label('Avis')
                    ->limit(70)
                    ->wrap(),

                TextColumn::make('is_approved')
                    ->label('Publication')
                    ->badge()
                    ->formatStateUsing(fn ($state): string => $state ? 'Publié' : 'À vérifier')
                    ->color(fn ($state): string => $state ? 'success' : 'warning'),

                TextColumn::make('created_at')
                    ->label('Reçu le')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                TernaryFilter::make('is_approved')
                    ->label('Publication')
                    ->placeholder('Tous les avis')
                    ->trueLabel('Publiés')
                    ->falseLabel('À vérifier'),
            ])
            ->recordActions([
                EditAction::make()->label('Vérifier'),
            ]);
    }
}
