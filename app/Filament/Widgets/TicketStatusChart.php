<?php

namespace App\Filament\Widgets;

use App\Models\HelpDeskTicket;
use Filament\Widgets\ChartWidget;

class TicketStatusChart extends ChartWidget
{
    protected ?string $heading = 'Ticket Status';

    protected int | string | array $columnSpan = 1;

    protected function getData(): array
    {
        $statuses = [
            'open' => 'Open',
            'assigned' => 'Assigned',
            'in_progress' => 'In Progress',
            'pending' => 'Pending',
            'resolved' => 'Resolved',
            'closed' => 'Closed',
            'cancelled' => 'Cancelled',
        ];

        $query = HelpDeskTicket::query();

        $data = [];

        foreach (array_keys($statuses) as $status) {
            $data[] = (clone $query)
                ->where('status', $status)
                ->count();
        }

        return [
            'labels' => array_values($statuses),

            'datasets' => [
                [
                    'label' => 'Tickets',
                    'data' => $data,
                ],
            ],
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }
}
