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

    protected int|array|null $columns = ['@xl' => 3, '!@xl' => 2];

    protected function getStats(): array
    {
        return [
            Stat::make('Articles', (string) Product::where('is_active', true)->count())
                ->description('Produits en vente')
                ->color('info'),

            Stat::make('En attente', (string) Order::where('status', 'pending')->count())
                ->description('Commandes à traiter')
                ->color('warning'),

            Stat::make('Clients', (string) User::where('is_admin', false)->count())
                ->description('Comptes inscrits'),
        ];
    }
}
