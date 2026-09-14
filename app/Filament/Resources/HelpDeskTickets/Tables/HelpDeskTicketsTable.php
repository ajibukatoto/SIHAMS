<?php

namespace App\Filament\Resources\HelpDeskTickets\Tables;

use App\Models\User;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

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
                            str($state)
                                ->replace('_', ' ')
                                ->title()
                    ),

                TextColumn::make('priority')
                    ->badge()
                    ->sortable(),

                TextColumn::make('status')
                    ->badge()
                    ->formatStateUsing(
                        fn (string $state): string =>
                            str($state)
                                ->replace('_', ' ')
                                ->title()
                    )
                    ->sortable(),

                TextColumn::make('technician.name')
                    ->label('Technician')
                    ->placeholder('Unassigned')
                    ->searchable(),

                TextColumn::make('created_at')
                    ->label('Created')
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

            ->recordActions([
                /*
                 * Assign Ticket
                 */
                Action::make('assign')
                    ->label('Assign')
                    ->icon('heroicon-o-user-plus')
                    ->color('primary')
                    ->visible(fn ($record): bool =>
                        Auth::user()?->can('tickets.assign') &&
                        $record->status === 'open'
                    )
                    ->form([
                        Select::make('assigned_to')
                            ->label('ICT Technician')
                            ->options(
                                User::role([
                                    'ICT Technician',
                                    'ICT Manager',
                                ])
                                    ->orderBy('name')
                                    ->pluck('name', 'id')
                                    ->toArray()
                            )
                            ->searchable()
                            ->required(),
                    ])
                    ->action(function ($record, array $data): void {
                        $record->update([
                            'assigned_to' => $data['assigned_to'],
                            'status' => 'assigned',
                            'assigned_at' => now(),
                        ]);
                    }),

                /*
                 * Start Work
                 */
                Action::make('start_work')
                    ->label('Start Work')
                    ->icon('heroicon-o-play')
                    ->color('info')
                    ->visible(fn ($record): bool =>
                        Auth::user()?->can('tickets.update') &&
                        $record->assigned_to === Auth::id() &&
                        $record->status === 'assigned'
                    )
                    ->requiresConfirmation()
                    ->action(function ($record): void {
                        $record->update([
                            'status' => 'in_progress',
                        ]);
                    }),

                /*
                 * Mark Pending
                 */
                Action::make('pending')
                    ->label('Pending')
                    ->icon('heroicon-o-pause')
                    ->color('warning')
                    ->visible(fn ($record): bool =>
                        Auth::user()?->can('tickets.update') &&
                        $record->assigned_to === Auth::id() &&
                        in_array(
                            $record->status,
                            ['in_progress']
                        )
                    )
                    ->form([
                        Textarea::make('comment')
                            ->label('Reason for Pending')
                            ->required()
                            ->rows(4),
                    ])
                    ->action(function ($record, array $data): void {
                        $record->update([
                            'status' => 'pending',
                        ]);

                        $record->comments()->create([
                            'user_id' => Auth::id(),
                            'comment' => $data['comment'],
                            'is_internal' => false,
                        ]);
                    }),

                /*
                 * Resolve Ticket
                 */
                Action::make('resolve')
                    ->label('Resolve')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->visible(fn ($record): bool =>
                        Auth::user()?->can('tickets.resolve') &&
                        $record->assigned_to === Auth::id() &&
                        in_array(
                            $record->status,
                            ['in_progress', 'pending']
                        )
                    )
                    ->form([
                        Textarea::make('resolution')
                            ->label('Resolution / Work Done')
                            ->required()
                            ->rows(5),
                    ])
                    ->action(function ($record, array $data): void {
                        $record->update([
                            'resolution' => $data['resolution'],
                            'status' => 'resolved',
                            'resolved_at' => now(),
                        ]);
                    }),

                /*
                 * Close Ticket
                 */
                Action::make('close')
                    ->label('Close')
                    ->icon('heroicon-o-lock-closed')
                    ->color('success')
                    ->visible(fn ($record): bool =>
                        Auth::user()?->can('tickets.close') &&
                        $record->requester_id === Auth::id() &&
                        $record->status === 'resolved'
                    )
                    ->requiresConfirmation()
                    ->modalHeading('Confirm Ticket Closure')
                    ->modalDescription(
                        'Confirm that the reported issue has been resolved.'
                    )
                    ->action(function ($record): void {
                        $record->update([
                            'status' => 'closed',
                            'closed_at' => now(),
                        ]);
                    }),

                /*
                 * Reopen
                 */
                Action::make('reopen')
                    ->label('Reopen')
                    ->icon('heroicon-o-arrow-path')
                    ->color('warning')
                    ->visible(fn ($record): bool =>
                        $record->requester_id === Auth::id() &&
                        $record->status === 'resolved'
                    )
                    ->requiresConfirmation()
                    ->action(function ($record): void {
                        $record->update([
                            'status' => 'in_progress',
                            'resolved_at' => null,
                            'closed_at' => null,
                        ]);
                    }),

                /*
                 * Cancel
                 */
                Action::make('cancel')
                    ->label('Cancel')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->visible(fn ($record): bool =>
                        Auth::user()?->can('tickets.update') &&
                        in_array(
                            $record->status,
                            ['open', 'assigned']
                        )
                    )
                    ->requiresConfirmation()
                    ->action(function ($record): void {
                        $record->update([
                            'status' => 'cancelled',
                        ]);
                    }),

                /*
                 * Edit
                 */
                EditAction::make()
                    ->visible(fn (): bool =>
                        Auth::user()?->can('tickets.update') ?? false
                    ),
            ])

            ->defaultSort('created_at', 'desc');
    }
}
