<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

// Statistiques du Wallet : montants encaissés, en attente, commandes
class WalletStats extends StatsOverviewWidget
{
    // Chargé directement avec la page (pas d'attente Livewire)
    protected static bool $isLazy = false;
    // Formate un montant en FCFA
    protected function fcfa(int|float $amount): string
    {
        return number_format((int) round($amount), 0, ',', ' ') . ' FCFA';
    }

    protected function getStats(): array
    {
        $paid = (float) Order::where('payment_status', 'paid')->sum('total');
        $pending = (float) Order::where('payment_status', 'pending')->sum('total');
        $count = Order::count();

        return [
            Stat::make('Encaissé', $this->fcfa($paid))
                ->description('Paiements reçus')
                ->color('success'),

            Stat::make('En attente', $this->fcfa($pending))
                ->description('Paiements à recevoir')
                ->color('warning'),

            Stat::make('Commandes', (string) $count)
                ->description('Total des commandes'),
        ];
    }
}
