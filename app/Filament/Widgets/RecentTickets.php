<?php

namespace App\Filament\Widgets;

use App\Models\HelpDeskTicket;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;

class RecentTickets extends TableWidget
{
    protected static ?string $heading = 'Recent Help Desk Tickets';

    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                HelpDeskTicket::query()
                    ->with([
                        'requester',
                        'department',
                        'technician',
                    ])
            )
            ->columns([
                TextColumn::make('ticket_number')
                    ->label('Ticket')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('subject')
                    ->label('Subject')
                    ->limit(45)
                    ->searchable(),

                TextColumn::make('requester.name')
                    ->label('Requester')
                    ->placeholder('Unknown'),

                TextColumn::make('department.name')
                    ->label('Department')
                    ->placeholder('Unknown'),

                TextColumn::make('priority')
                    ->badge()
                    ->formatStateUsing(
                        fn (string $state): string =>
                            str($state)->replace('_', ' ')->title()
                    ),

                TextColumn::make('status')
                    ->badge()
                    ->formatStateUsing(
                        fn (string $state): string =>
                            str($state)->replace('_', ' ')->title()
                    ),

                TextColumn::make('technician.name')
                    ->label('Technician')
                    ->placeholder('Unassigned'),

                TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime()
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->paginated(false);
    }
}

