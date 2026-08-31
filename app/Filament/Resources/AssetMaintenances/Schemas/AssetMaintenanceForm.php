<?php

namespace App\Filament\Resources\AssetMaintenances\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class AssetMaintenanceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('asset_id')
                    ->label('Asset')
                    ->relationship('asset', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),

                Select::make('reported_by')
                    ->label('Reported By')
                    ->relationship('reportedBy', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),

                TextInput::make('maintenance_type')
                    ->label('Maintenance Type')
                    ->required()
                    ->maxLength(255),

                Textarea::make('problem_description')
                    ->label('Problem Description')
                    ->required()
                    ->rows(4)
                    ->columnSpanFull(),

                DatePicker::make('maintenance_date')
                    ->label('Maintenance Date')
                    ->required(),

                DatePicker::make('completion_date')
                    ->label('Completion Date'),

                Select::make('status')
                    ->label('Status')
                    ->options([
                        'pending' => 'Pending',
                        'in_progress' => 'In Progress',
                        'completed' => 'Completed',
                        'cancelled' => 'Cancelled',
                    ])
                    ->default('pending')
                    ->required(),

                TextInput::make('technician')
                    ->label('Technician')
                    ->maxLength(255),

                TextInput::make('cost')
                    ->label('Cost')
                    ->numeric()
                    ->prefix('TZS'),

                Textarea::make('remarks')
                    ->label('Remarks')
                    ->rows(3)
                    ->columnSpanFull(),
            ]);
    }
}
