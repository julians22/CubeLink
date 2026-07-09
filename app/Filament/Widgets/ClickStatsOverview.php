<?php

namespace App\Filament\Widgets;

use App\Models\Click;
use App\Models\Link;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ClickStatsOverview extends StatsOverviewWidget
{
    protected ?string $pollingInterval = '30s';

    protected function getStats(): array
    {
        $topLinks = Link::query()
            ->withCount('clicks')
            ->orderByDesc('clicks_count')
            ->limit(2)
            ->get();

        $topOne = $topLinks->get(0);
        $topTwo = $topLinks->get(1);

        return [
            Stat::make('Total Clicks', (string) Click::count())
                ->description('All tracked link clicks'),
            Stat::make('Top Link', $topOne?->label ?? 'No data yet')
                ->description(($topOne?->clicks_count ?? 0) . ' clicks'),
            Stat::make('Second Link', $topTwo?->label ?? 'No data yet')
                ->description(($topTwo?->clicks_count ?? 0) . ' clicks'),
        ];
    }
}
