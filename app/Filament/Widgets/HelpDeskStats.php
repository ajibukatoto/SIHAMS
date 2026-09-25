<?php

namespace App\Filament\Widgets;

use App\Models\HelpDeskTicket;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class HelpDeskStats extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        $query = HelpDeskTicket::query();

        $total = (clone $query)->count();

        $open = (clone $query)
            ->whereIn('status', ['open', 'assigned'])
            ->count();

        $inProgress = (clone $query)
            ->where('status', 'in_progress')
            ->count();

        $resolved = (clone $query)
            ->whereIn('status', ['resolved', 'closed'])
            ->count();

        return [
            Stat::make('Total Tickets', $total)
                ->description('Total help desk tickets')
                ->descriptionIcon('heroicon-o-ticket')
                ->color('primary')
                ->icon('heroicon-o-ticket'),

            Stat::make('Open Tickets', $open)
                ->description('Waiting for action')
                ->descriptionIcon('heroicon-o-clock')
                ->color('warning')
                ->icon('heroicon-o-clock'),

            Stat::make('In Progress', $inProgress)
                ->description('Currently being worked on')
                ->descriptionIcon('heroicon-o-wrench-screwdriver')
                ->color('info')
                ->icon('heroicon-o-wrench-screwdriver'),

            Stat::make('Resolved', $resolved)
                ->description('Resolved or closed')
                ->descriptionIcon('heroicon-o-check-circle')
                ->color('success')
                ->icon('heroicon-o-check-circle'),
        ];
    }

    protected function getColumns(): int
    {
        return 4;
    }
}
