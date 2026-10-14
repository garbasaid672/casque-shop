<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\RecentPayments;
use App\Filament\Widgets\WalletStats;
use BackedEnum;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use UnitEnum;

// Page Wallet : recettes et paiements des commandes
class Wallet extends Page
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBanknotes;

    protected static UnitEnum|string|null $navigationGroup = 'Gestion';

    protected static ?int $navigationSort = 1;

    protected static ?string $navigationLabel = 'Wallet';

    protected static ?string $title = 'Wallet';

    protected function getHeaderWidgets(): array
    {
        return [
            WalletStats::class,
        ];
    }

    protected function getFooterWidgets(): array
    {
        return [
            RecentPayments::class,
        ];
    }
}
