<?php

namespace App\Filament\Resources\HelpDeskTickets\Tables;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class HelpDeskTicketsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('ticket_number')
                    ->label('Ticket')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('subject')
                    ->searchable()
                    ->limit(40),

                TextColumn::make('requester.name')
                    ->label('Requester')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('department.name')
                    ->label('Department')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('category')
                    ->badge()
                    ->formatStateUsing(
                        fn (string $state): string =>
                            str($state)->replace('_', ' ')->title()
                    ),

                TextColumn::make('priority')
                    ->badge()
                    ->sortable(),

                TextColumn::make('status')
                    ->badge()
                    ->sortable(),

                TextColumn::make('technician.name')
                    ->label('Technician')
                    ->placeholder('Unassigned')
                    ->searchable(),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
            ])

            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'open' => 'Open',
                        'assigned' => 'Assigned',
                        'in_progress' => 'In Progress',
                        'pending' => 'Pending',
                        'resolved' => 'Resolved',
                        'closed' => 'Closed',
                        'cancelled' => 'Cancelled',
                    ]),

                SelectFilter::make('priority')
                    ->options([
                        'low' => 'Low',
                        'medium' => 'Medium',
                        'high' => 'High',
                        'critical' => 'Critical',
                    ]),

                SelectFilter::make('category')
                    ->options([
                        'hardware' => 'Hardware',
                        'software' => 'Software',
                        'network' => 'Network',
                        'printer' => 'Printer',
                        'email' => 'Email',
                        'system' => 'System',
                        'user_account' => 'User Account',
                        'other' => 'Other',
                    ]),
            ])

            ->defaultSort('created_at', 'desc');
    }
}
