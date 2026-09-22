<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\DB;

class HelpDeskStats extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        $total = DB::table('help_desk_tickets')
            ->count();

        $open = DB::table('help_desk_tickets')
            ->whereIn('status', [
                'open',
                'assigned',
            ])
            ->count();

        $inProgress = DB::table('help_desk_tickets')
            ->where('status', 'in_progress')
            ->count();

        $resolved = DB::table('help_desk_tickets')
            ->whereIn('status', [
                'resolved',
                'closed',
            ])
            ->count();

        return [
            Stat::make(
                'Total Tickets',
                $total
            )
                ->description('All help desk tickets')
                ->descriptionIcon('heroicon-o-ticket')
                ->color('primary')
                ->icon('heroicon-o-ticket'),

            Stat::make(
                'Open Tickets',
                $open
            )
                ->description('Waiting for action')
                ->descriptionIcon('heroicon-o-clock')
                ->color('warning')
                ->icon('heroicon-o-clock'),

            Stat::make(
                'In Progress',
                $inProgress
            )
                ->description('Currently being worked on')
                ->descriptionIcon('heroicon-o-wrench-screwdriver')
                ->color('info')
                ->icon('heroicon-o-wrench-screwdriver'),

            Stat::make(
                'Resolved',
                $resolved
            )
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
