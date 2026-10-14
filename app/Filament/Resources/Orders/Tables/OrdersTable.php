<?php

namespace App\Filament\Resources\Orders\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class OrdersTable
{
    // Libellés français des statuts de commande
    public const STATUS_LABELS = [
        'pending' => 'En attente',
        'confirmed' => 'Confirmée',
        'processing' => 'En préparation',
        'shipped' => 'Expédiée',
        'delivered' => 'Livrée',
        'cancelled' => 'Annulée',
        'refunded' => 'Remboursée',
    ];

    // Libellés français des statuts de paiement
    public const PAYMENT_LABELS = [
        'pending' => 'En attente',
        'paid' => 'Payée',
        'failed' => 'Échouée',
        'refunded' => 'Remboursé',
        'partial' => 'Partiel',
    ];

    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('order_number')
                    ->label('N° commande')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('email')
                    ->label('Client')
                    ->searchable(),

                TextColumn::make('phone')
                    ->label('Téléphone')
                    ->searchable()
                    ->toggleable(),

                TextColumn::make('total')
                    ->label('Total')
                    ->formatStateUsing(fn ($state) => number_format((int) round($state), 0, ',', ' ') . ' FCFA')
                    ->sortable(),

                TextColumn::make('status')
                    ->label('Statut')
                    ->badge()
                    ->formatStateUsing(fn ($state) => self::STATUS_LABELS[$state] ?? $state)
                    ->color(fn ($state) => match ($state) {
                        'pending' => 'warning',
                        'confirmed', 'processing' => 'info',
                        'shipped' => 'gray',
                        'delivered' => 'success',
                        'cancelled', 'refunded' => 'danger',
                        default => 'gray',
                    }),

                TextColumn::make('payment_status')
                    ->label('Paiement')
                    ->badge()
                    ->formatStateUsing(fn ($state) => self::PAYMENT_LABELS[$state] ?? $state)
                    ->color(fn ($state) => match ($state) {
                        'pending' => 'warning',
                        'paid' => 'success',
                        'failed' => 'danger',
                        'partial' => 'info',
                        'refunded' => 'gray',
                        default => 'gray',
                    }),

                TextColumn::make('payment_method')
                    ->label('Moyen')
                    ->formatStateUsing(fn ($state) => match ($state) {
                        'kkiapay' => 'En ligne (KkiaPay)',
                        'mobile_money' => 'Mobile Money',
                        'cash_on_delivery' => 'À la livraison',
                        default => $state ?? '—',
                    })
                    ->toggleable(),

                TextColumn::make('created_at')
                    ->label('Passée le')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('status')
                    ->label('Statut')
                    ->options(self::STATUS_LABELS),

                SelectFilter::make('payment_status')
                    ->label('Paiement')
                    ->options(self::PAYMENT_LABELS),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
