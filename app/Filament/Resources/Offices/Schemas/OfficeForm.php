<?php

namespace App\Filament\Resources\Offices\Schemas;

use App\Models\Department;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;

class OfficeForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('department_id')
                    ->relationship('department', 'name')
                    ->label('Department')
                    ->required(),

                TextInput::make('office_name')
                    ->label('Office Name')
                    ->required()
                    ->maxLength(255),

                TextInput::make('region')
                    ->label('Region')
                    ->required()
                    ->maxLength(255),

                TextInput::make('district')
                    ->label('District')
                    ->required()
                    ->maxLength(255),

                TextInput::make('address')
                    ->label('Address')
                    ->maxLength(255),

                Toggle::make('is_active')
                    ->label('Is Active')
                    ->default(true),
            ]);
    }
}
