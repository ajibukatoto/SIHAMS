<?php

namespace App\Filament\Resources\TicketComments\Tables;

use App\Models\TicketComment;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class TicketCommentsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(
                fn ($query) =>
                    $query->whereHas(
                        'ticket',
                        function ($ticketQuery): void {
                            $ticketQuery->visibleTo(
                                Auth::user()
                            );
                        }
                    )
            )
            ->columns([
                TextColumn::make('ticket.ticket_number')
                    ->label('Ticket Number')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('user.name')
                    ->label('Commented By')
                    ->searchable()
                    ->sortable()
                    ->placeholder('Unknown'),

                TextColumn::make('comment')
                    ->label('Comment')
                    ->limit(80)
                    ->wrap()
                    ->searchable(),

                IconColumn::make('is_internal')
                    ->label('Internal')
                    ->boolean(),

                TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime()
                    ->sortable(),

                TextColumn::make('updated_at')
                    ->label('Updated')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),

                DeleteAction::make()
                    ->requiresConfirmation(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort(
                'created_at',
                'desc'
            );
    }
}
