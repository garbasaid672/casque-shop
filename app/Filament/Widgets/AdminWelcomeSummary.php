<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use Filament\Widgets\Widget;

class AdminWelcomeSummary extends Widget
{
    protected static ?int $sort = -3;

    protected static bool $isLazy = false;

    protected int|string|array $columnSpan = 'full';

    protected string $view = 'filament.widgets.admin-welcome-summary';

    protected function getViewData(): array
    {
        return [
            'administrator' => filament()->auth()->user()->name,
            'revenue' => number_format((float) Order::query()->where('payment_status', 'paid')->sum('total'), 0, ',', ' ').' FCFA',
            'payments' => Order::query()->where('payment_status', 'paid')->count(),
            'orders' => Order::query()->count(),
        ];
    }
}
