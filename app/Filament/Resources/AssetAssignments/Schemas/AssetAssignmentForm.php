<?php

namespace App\Filament\Resources\AssetAssignments\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class AssetAssignmentForm
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

                Select::make('employee_id')
                    ->label('Employee')
                    ->relationship('employee', 'full_name')
                    ->searchable()
                    ->preload()
                    ->required(),

                Select::make('assigned_by')
                    ->label('Assigned By')
                    ->relationship('assignedBy', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),

                DatePicker::make('assigned_date')
                    ->label('Assigned Date')
                    ->required(),

                DatePicker::make('expected_return_date')
                    ->label('Expected Return Date'),

                DatePicker::make('actual_return_date')
                    ->label('Actual Return Date'),

                Select::make('condition_when_assigned')
                    ->label('Condition When Assigned')
                    ->options([
                        'excellent' => 'Excellent',
                        'good' => 'Good',
                        'fair' => 'Fair',
                        'damaged' => 'Damaged',
                    ])
                    ->required(),

                Select::make('condition_when_returned')
                    ->label('Condition When Returned')
                    ->options([
                        'excellent' => 'Excellent',
                        'good' => 'Good',
                        'fair' => 'Fair',
                        'damaged' => 'Damaged',
                    ]),

                Textarea::make('remarks')
                    ->label('Remarks')
                    ->rows(4)
                    ->columnSpanFull(),
            ]);
    }
}
