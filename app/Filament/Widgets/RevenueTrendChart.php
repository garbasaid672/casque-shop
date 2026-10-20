<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use Carbon\CarbonImmutable;
use Filament\Widgets\ChartWidget;

class RevenueTrendChart extends ChartWidget
{
    protected static ?int $sort = -2;

    protected static bool $isLazy = false;

    protected ?string $heading = 'Chiffre d’affaires';

    protected ?string $description = 'Paiements reçus sur les 30 derniers jours';

    protected ?string $maxHeight = '300px';

    protected int|string|array $columnSpan = ['default' => 'full', 'sm' => 1];

    protected function getType(): string
    {
        return 'line';
    }

    protected function getData(): array
    {
        $start = CarbonImmutable::now()->subDays(29)->startOfDay();
        $end = CarbonImmutable::now()->endOfDay();
        $dailyRevenue = Order::query()
            ->where('payment_status', 'paid')
            ->whereBetween('created_at', [$start, $end])
            ->get(['created_at', 'total'])
            ->groupBy(fn (Order $order): string => $order->created_at->toDateString())
            ->map(fn ($orders): float => (float) $orders->sum('total'));

        $labels = [];
        $values = [];

        for ($date = $start; $date <= $end->startOfDay(); $date = $date->addDay()) {
            $key = $date->toDateString();
            $labels[] = $date->format('d/m');
            $values[] = $dailyRevenue->get($key, 0);
        }

        return [
            'datasets' => [[
                'label' => 'Chiffre d’affaires (FCFA)',
                'data' => $values,
                'borderColor' => '#0284c7',
                'backgroundColor' => 'rgba(2, 132, 199, 0.16)',
                'fill' => true,
                'tension' => 0.35,
            ]],
            'labels' => $labels,
        ];
    }
}
