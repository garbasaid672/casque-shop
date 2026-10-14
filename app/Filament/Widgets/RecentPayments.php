<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\Orders\Tables\OrdersTable;
use App\Models\Order;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;

// Derniers paiements affichés sur la page Wallet
class RecentPayments extends TableWidget
{
    // Chargé directement avec la page (pas d'attente Livewire)
    protected static bool $isLazy = false;

    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(Order::query()->latest()->limit(10))
            ->columns([
                TextColumn::make('order_number')
                    ->label('N° commande')
                    ->searchable(),

                TextColumn::make('email')
                    ->label('Client'),

                TextColumn::make('total')
                    ->label('Total')
                    ->formatStateUsing(fn ($state) => number_format((int) round($state), 0, ',', ' ') . ' FCFA'),

                TextColumn::make('payment_status')
                    ->label('Paiement')
                    ->badge()
                    ->formatStateUsing(fn ($state) => OrdersTable::PAYMENT_LABELS[$state] ?? $state)
                    ->color(fn ($state) => match ($state) {
                        'pending' => 'warning',
                        'paid' => 'success',
                        'failed' => 'danger',
                        default => 'gray',
                    }),

                TextColumn::make('payment_method')
                    ->label('Moyen')
                    ->formatStateUsing(fn ($state) => match ($state) {
                        'mobile_money' => 'Mobile Money',
                        'cash_on_delivery' => 'À la livraison',
                        default => $state ?? '—',
                    }),

                TextColumn::make('created_at')
                    ->label('Passée le')
                    ->dateTime('d/m/Y H:i'),
            ]);
    }
}
