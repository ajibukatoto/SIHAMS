<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\DB;

class SystemOverview extends StatsOverviewWidget
{
    protected ?string $heading = 'System Overview';

    protected function getStats(): array
    {
        return [
            Stat::make(
                'Employees',
                DB::table('employees')->count()
            )
                ->description('Registered employees')
                ->descriptionIcon('heroicon-o-users')
                ->color('primary')
                ->icon('heroicon-o-users'),

            Stat::make(
                'Departments',
                DB::table('departments')->count()
            )
                ->description('Organizational departments')
                ->descriptionIcon('heroicon-o-building-office-2')
                ->color('info')
                ->icon('heroicon-o-building-office-2'),

            Stat::make(
                'Offices',
                DB::table('offices')->count()
            )
                ->description('Registered offices')
                ->descriptionIcon('heroicon-o-building-office')
                ->color('warning')
                ->icon('heroicon-o-building-office'),

            Stat::make(
                'ICT Assets',
                DB::table('assets')->count()
            )
                ->description('Assets recorded in SIHAMS')
                ->descriptionIcon('heroicon-o-computer-desktop')
                ->color('success')
                ->icon('heroicon-o-computer-desktop'),
        ];
    }

    protected function getColumns(): int
    {
        return 4;
    }
}
