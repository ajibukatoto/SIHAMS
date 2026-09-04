<?php

namespace App\Filament\Resources\TicketComments\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class TicketCommentsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('helpDeskTicket.ticket_number')
                    ->label('Ticket Number')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('user.name')
                    ->label('Commented By')
                    ->searchable()
                    ->sortable(),

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
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
