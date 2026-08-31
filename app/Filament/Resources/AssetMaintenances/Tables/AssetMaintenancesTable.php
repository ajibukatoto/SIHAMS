<?php
namespace App\Filament\Resources\AssetMaintenances\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class AssetMaintenancesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('asset.name')
                    ->label('Asset')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('reportedBy.name')
                    ->label('Reported By')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('maintenance_type')
                    ->label('Maintenance Type')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('problem_description')
                    ->label('Problem')
                    ->limit(40)
                    ->searchable(),

                TextColumn::make('maintenance_date')
                    ->label('Maintenance Date')
                    ->date()
                    ->sortable(),

                TextColumn::make('completion_date')
                    ->label('Completion Date')
                    ->date()
                    ->sortable(),

                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
                        'in_progress' => 'info',
                        'completed' => 'success',
                        'cancelled' => 'danger',
                        default => 'gray',
                    })
                    ->sortable(),

                TextColumn::make('technician')
                    ->label('Technician')
                    ->searchable()
                    ->toggleable(),

                TextColumn::make('cost')
                    ->label('Cost')
                    ->money('TZS')
                    ->sortable(),

                TextColumn::make('remarks')
                    ->label('Remarks')
                    ->limit(30)
                    ->toggleable(),

                TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])

            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'in_progress' => 'In Progress',
                        'completed' => 'Completed',
                        'cancelled' => 'Cancelled',
                    ]),

                SelectFilter::make('maintenance_type')
                    ->options([
                        'preventive' => 'Preventive',
                        'corrective' => 'Corrective',
                        'emergency' => 'Emergency',
                    ]),

                Filter::make('maintenance_date')
                    ->form([
                        DatePicker::make('from')
                            ->label('From Date'),

                        DatePicker::make('until')
                            ->label('Until Date'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['from'] ?? null,
                                fn (Builder $query, $date): Builder =>
                                    $query->whereDate('maintenance_date', '>=', $date),
                            )
                            ->when(
                                $data['until'] ?? null,
                                fn (Builder $query, $date): Builder =>
                                    $query->whereDate('maintenance_date', '<=', $date),
                            );
                    }),
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

