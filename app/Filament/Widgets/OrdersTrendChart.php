<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use Carbon\CarbonImmutable;
use Filament\Widgets\ChartWidget;

class OrdersTrendChart extends ChartWidget
{
    protected static ?int $sort = -1;

    protected static bool $isLazy = false;

    protected ?string $heading = 'Commandes';

    protected ?string $description = 'Commandes créées sur les 30 derniers jours';

    protected ?string $maxHeight = '300px';

    protected int|string|array $columnSpan = ['default' => 'full', 'sm' => 1];

    protected function getType(): string
    {
        return 'bar';
    }

    protected function getData(): array
    {
        $start = CarbonImmutable::now()->subDays(29)->startOfDay();
        $end = CarbonImmutable::now()->endOfDay();
        $dailyOrders = Order::query()
            ->whereBetween('created_at', [$start, $end])
            ->get(['created_at'])
            ->groupBy(fn (Order $order): string => $order->created_at->toDateString())
            ->map(fn ($orders): int => $orders->count());

        $labels = [];
        $values = [];

        for ($date = $start; $date <= $end->startOfDay(); $date = $date->addDay()) {
            $key = $date->toDateString();
            $labels[] = $date->format('d/m');
            $values[] = $dailyOrders->get($key, 0);
        }

        return [
            'datasets' => [[
                'label' => 'Commandes',
                'data' => $values,
                'backgroundColor' => '#f59e0b',
                'borderRadius' => 5,
            ]],
            'labels' => $labels,
        ];
    }
}
