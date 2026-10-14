<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

// Statistiques affichées en haut du tableau de bord admin
class ShopStats extends StatsOverviewWidget
{
    // Chargé directement avec la page (pas d'attente Livewire)
    protected static bool $isLazy = false;
    protected function fcfa(int|float $amount): string
    {
        return number_format((int) round($amount), 0, ',', ' ') . ' FCFA';
    }

    protected function getStats(): array
    {
        return [
            Stat::make('Articles', (string) Product::where('is_active', true)->count())
                ->description('Produits en vente')
                ->color('info'),

            Stat::make('En attente', (string) Order::where('status', 'pending')->count())
                ->description('Commandes à traiter')
                ->color('warning'),

            Stat::make('Encaissé', $this->fcfa((float) Order::where('payment_status', 'paid')->sum('total')))
                ->description('Paiements reçus')
                ->color('success'),

            Stat::make('Clients', (string) User::where('is_admin', false)->count())
                ->description('Comptes inscrits'),
        ];
    }
}
