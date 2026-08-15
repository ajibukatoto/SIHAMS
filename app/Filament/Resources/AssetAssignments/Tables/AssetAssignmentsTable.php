<?php

namespace App\Filament\Resources\AssetAssignments\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AssetAssignmentsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('asset.name')
                    ->label('Asset Name')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('employee.full_name')
                    ->label('Employee Name')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('assignedBy.name')
                    ->label('Assigned By')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('assigned_date')
                    ->label('Assigned Date')
                    ->date()
                    ->sortable(),

                TextColumn::make('expected_return_date')
                    ->label('Expected Return Date')
                    ->date()
                    ->sortable(),

                TextColumn::make('actual_return_date')
                    ->label('Actual Return Date')
                    ->date()
                    ->sortable(),

                TextColumn::make('condition_when_assigned')
                    ->label('Condition When Assigned')
                    ->badge()
                    ->sortable(),

                TextColumn::make('condition_when_returned')
                    ->label('Condition When Returned')
                    ->badge()
                    ->sortable(),

                TextColumn::make('remarks')
                    ->label('Remarks')
                    ->limit(50),
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
            ]);
    }
}
