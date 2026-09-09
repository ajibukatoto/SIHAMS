<?php

namespace App\Filament\Resources\Assets\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class AssetsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Asset Name')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('code')
                    ->label('Asset Code')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('description')
                    ->label('Description')
                    ->limit(50)
                    ->toggleable(),

                TextColumn::make('assetCategory.name')
                    ->label('Asset Category')
                    ->sortable()
                    ->searchable(),

                ToggleColumn::make('is_active')
                    ->label('Is Active')
                    ->sortable()
                    ->disabled(
                        fn (): bool =>
                            ! (Auth::user()?->can('assets.update') ?? false)
                    ),
            ])

            ->filters([
                //
            ])

            ->recordActions([
                EditAction::make()
                    ->visible(
                        fn (): bool =>
                            Auth::user()?->can('assets.update') ?? false
                    ),
            ])

            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->visible(
                            fn (): bool =>
                                Auth::user()?->can('assets.delete') ?? false
                        ),
                ]),
            ]);
    }
}
