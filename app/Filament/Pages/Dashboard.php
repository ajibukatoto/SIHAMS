<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\DashboardWelcome;
use App\Filament\Widgets\HelpDeskStats;
use App\Filament\Widgets\RecentTickets;
use App\Filament\Widgets\SystemOverview;
use App\Filament\Widgets\TicketActivityChart;
use App\Filament\Widgets\TicketStatusChart;
use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    protected static ?string $title = 'SIHAMS Dashboard';

    public function getWidgets(): array
    {
        return [
            DashboardWelcome::class,
            HelpDeskStats::class,
            TicketActivityChart::class,
            TicketStatusChart::class,
            RecentTickets::class,
            SystemOverview::class,
        ];
    }
}
