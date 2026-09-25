<?php

namespace App\Filament\Widgets;

use App\Models\HelpDeskTicket;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;

class TicketActivityChart extends ChartWidget
{
    protected ?string $heading = 'Ticket Activity — Last 7 Days';

    protected int | string | array $columnSpan = 2;

    protected function getData(): array
    {
        $query = HelpDeskTicket::query();

        $labels = [];
        $data = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);

            $labels[] = $date->format('D');

            $data[] = (clone $query)
                ->whereDate('created_at', $date)
                ->count();
        }

        return [
            'datasets' => [
                [
                    'label' => 'Tickets Created',
                    'data' => $data,
                    'fill' => true,
                    'tension' => 0.4,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
